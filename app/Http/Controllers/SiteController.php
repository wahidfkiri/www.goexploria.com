<?php
namespace App\Http\Controllers;

use App\Models\Content;
use Session;
#use Response;
use View;
use Redirect;

use App\Models\Site;
use App\Models\Company;
use App\Models\Page;
use App\Models\MediaAttr;
use App\Models\Media;

use App\Models\CompanyFollower;
use App\Models\Language;

#use Illuminate\Http\Request;
use App\Http\Requests\SubscribeInfolettreRequest;

#use App\Helpers\Formatter;

use Image;
#use URL;

class SiteController extends Controller {

    /** Retourne la page demandé pour un site avec domaine externe */
    public function index($page_slug = 'index') {

        // request()->getHost() plutôt que $_SERVER['HTTP_HOST'] : ce dernier
        // est absent en CLI et en test, ce qui provoquait un « Undefined array
        // key "HTTP_HOST" » fatal depuis PHP 8.
        $domain = preg_replace('/(www|dev)\./i', '', request()->getHost());
        $company = Company::getFromDomain($domain);
        if( !$company ) {
          return redirect('/');
        }

        #URL::forceRootUrl('http://'.$_SERVER['SERVER_NAME']);

        $coordinate = $company->coordinate;
        $activities = $company->activitiesDetails();

        $page = $company->pages()->where('slug', $page_slug)->first();
        if($page == null) {
          if($page_slug == 'contact') {
            $page = new Page;
            $page->name = 'Contact';
            $page->slug = 'contact';

          } else {
            $page_slug = "index";
            $page = new Page;
            $page->name = 'Accueil';
            $page->slug = 'accueil';
          }
        }
        $_pages = $company->pages()->where('is_visible', 1)->orderBy('rank')->orderBy('name')->get();

        $pages = [];
        foreach($_pages as $p) {
          if($p->parent_id == null) {
            $pages[] = $p;
          }
        }

        $currentlangId='';
        if(session()->has('locale')){
          $currentlangId = Language::getLangIdByLocale(session()->get('locale'));
        }

        $medias = Company::where('cg.company_id', $company->id)
        ->join('companies_galleries as cg', 'cg.company_id', '=', 'companies.id')
        ->join('galleries as g', 'g.id', '=', 'cg.gallery_id')
        ->join('medias as m', 'm.gallery_id', '=', 'g.id');

        if ($page_slug == "index") {
          $medias = $medias->where('cg.language_id', $currentlangId);
        } else {
          $medias = $medias
          ->join('pages as p', 'p.id', '=', 'g.page_id')
          ->where([
            ['cg.language_id', $currentlangId],
            ['p.slug', $page_slug]
          ]);
        }
        $medias = $medias->select('g.slug as gslug', 'g.is_slider as gslider', 'g.is_carousel as gcarousel', 'g.id as gid', 'g.name as gname', 'cg.language_id', 'm.*')
        ->orderBy('g.id')
        ->orderBy('rank')
        ->get();

        $medias_attr = array_reduce( array_map(function($m) {
          return [
            'id' => $m["id"],
            'attrs' => MediaAttr::where("media_id",$m["id"])->get()
          ];
        }, $medias->toArray()), function($carry, $item) {
          if(sizeof($item['attrs']) == 0) return $carry;
          $carry[$item['id']] = $item['attrs'];
          return $carry;
        }, []);

        $theme = $company->getSiteTheme();

        $company_domain = $company->coordinate->website;
        if( is_null($company_domain) || empty($company_domain) ) {
          return 'Customer domain is empty.';
        }

        if( !starts_with($company_domain, 'http://') ){
          $company_domain = 'http://'.$company_domain;
        }

        $company_domain = str_finish($company_domain, '/');

        $company_logo = $company->getLogoFilename();
        $company_headImage = $company->getLogoFilename('headImage');
        $company_footerImage = $company->getLogoFilename('footerImage');
        $logo_height=80;
        if( !empty($company_logo) ){
          $logo_height = Image::make(public_path() . '/uploads/companies/' . $company->id . '/' . $company_logo)->height();
        }

        $pictos = [];
        if (!empty($company->pictos)) {
            $pictos = json_decode($company->pictos, true);
        }

        $products = [];
        if (!empty($company->products)) {
            $tmpProducts = json_decode($company->products, true);
            if (!empty($tmpProducts)) {
                foreach ($tmpProducts as $keyP => $p) {
                    $products[$keyP] = $p;
                    $products[$keyP]['order'] = (isset($p['order']) && !empty($p['order'])) ? (int)$p['order'] : 0 ;
                    $products[$keyP]['url'] = (isset($p['url']) && !empty($p['url'])) ? $p['url'] : '' ;
                }
            }
        }

        usort($products, function ($a, $b) {
            if ((int)$a["order"] == (int)$b["order"]) {
                return 0;
            }
            return ((int)$a["order"] < (int)$b["order"]) ? -1 : 1;
            //return strcmp((int)$a["order"], (int)$b["order"]);
        });

        $configs = Site::where('company_id', $company->id)->pluck('value', 'config');

        $config_content = Content::latest()->first();

        if( $page_slug == 'index' ) {
          return view('front.site.'.$theme.'.index', compact('company', 'pictos', 'pages', 'activities', 'coordinate', 'medias','medias_attr','page', 'company_domain', 'company_logo', 'logo_height', 'configs', 'company_headImage', 'company_footerImage', 'theme', 'config_content', 'products'));
        }else {
          return view('front.site.'.$theme.'.page', compact('company', 'pictos', 'pages', 'activities', 'coordinate', 'page', "medias",'medias_attr','company_domain', 'company_logo', 'logo_height', 'configs', 'company_headImage', 'company_footerImage', 'theme', 'products'));
        }

    }

    /** Retourne la page demandé pour un site SANS domaine externe */
    public function dev($slug, $page_slug = 'index') {

        $company = Company::getFromSlug($slug);
        if( !$company ) {
          dd('Entreprise invalide!');
        }

        $coordinate = $company->coordinate;
        $activities = $company->activitiesDetails();

        $pages = $company->pages()->where('is_visible', 1)->orderBy('rank')->orderBy('name')->get();
        $page = $company->pages()->where('slug', $page_slug)->first();

        $currentlangId='';
        if(session()->has('locale')){
          $currentlangId = Language::getLangIdByLocale(session()->get('locale'));
        }

        $medias = Company::where('cg.company_id', $company->id)
        ->join('companies_galleries as cg', 'cg.company_id', '=', 'companies.id')
        ->join('galleries as g', 'g.id', '=', 'cg.gallery_id')
        ->join('medias as m', 'm.gallery_id', '=', 'g.id')
        #->where('g.user_id', 1)
        ->where('cg.language_id', $currentlangId)
        ->select('g.slug as gslug', 'g.is_slider as gslider', 'g.id as gid', 'g.name as gname', 'cg.language_id', 'm.*')
        ->orderBy('g.id')
        ->orderBy('rank')
        ->get();

        /*
        # DEBUG
        foreach( $medias->where('gslider', null) as $media ){
          echo $media->gname.'-'.$media->gid.' , '.$media->gallery_id.' , '.$media->rank."<br>";
          echo "<br>------###------<br>";
        }
        exit;
        */
        $medias_attr = array_reduce( array_map(function($m) {
          return [
            'id' => $m["id"],
            'attrs' => MediaAttr::where("media_id",$m["id"])->get()
          ];
        }, $medias->toArray()), function($carry, $item) {
          if(sizeof($item['attrs']) == 0) return $carry;
          $carry[$item['id']] = $item['attrs'];
          return $carry;
        }, []);

        $theme = 'theme1';

        if( empty($page_slug) || $page_slug == 'index' ){
          $page = new Page;
          $page->name = 'Accueil';
          $page->slug = 'accueil';
        } else if( $page_slug == 'contact' ){
          $page = new Page;
          $page->name = 'Contact';
          $page->slug = 'contact';
        }

        $company_domain = $company->coordinate->website;
        if( is_null($company_domain) || empty($company_domain) ) {
          return 'Customer domain is empty.';
        }

        if( !starts_with($company_domain, 'http://') ){
          $company_domain = 'http://'.$company_domain;
        }

        $company_domain = str_finish($company_domain, '/');

        $company_logo = $company->getLogoFilename();
        $logo_height=80;
        if( !empty($company_logo) ){
          $logo_height = Image::make(public_path() . '/uploads/companies/' . $company->id . '/' . $company_logo)->height();
        }

        $configs = Site::where('company_id', $company->id)->pluck('value', 'config');

        $config_content = Content::latest()->first();

        if( $page_slug == 'index' ) {
          return view('front.site.'.$theme.'.index', compact('company', 'pages', 'activities', 'coordinate', 'medias','medias_attr', 'page', 'company_domain', 'company_logo', 'logo_height', 'configs', 'config_content'));
        }else {
          return view('front.site.'.$theme.'.page', compact('company', 'pages', 'activities', 'coordinate', 'page', 'company_domain', 'company_logo', 'logo_height', 'configs'));
        }

    }

}
