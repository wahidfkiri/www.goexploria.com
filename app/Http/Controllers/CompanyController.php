<?php
namespace App\Http\Controllers;

use App\Models\CompanyContact;
use Session;
use Response;
use View;
use Redirect;
use Auth;
use App\Models\Company;
use App\Models\MediaAttr;
use App\Models\Media;
use App\Models\Page;
use App\Models\CompanyFollower;
use App\Models\Language;
use App\Models\Gallery;

use Illuminate\Http\Request;
use App\Http\Requests\SubscribeInfolettreRequest;

use App\Helpers\Formatter;
use URL;


class CompanyController extends Controller {

    public function getPubSlider() {

        $currentlangId='';
        if(session()->has('locale')){
            $currentlangId = Language::getLangIdByLocale(session()->get('locale'));
        }

        $pubs_slider = Gallery::leftjoin('locations_galleries as lg', 'lg.gallery_id', '=', 'galleries.id')
            ->leftjoin('locations as l', 'l.id', '=', 'lg.location_id')
            ->leftjoin('countries_galleries as cg', 'cg.gallery_id', '=', 'galleries.id')
            ->leftjoin('countries as c', 'c.id', '=', 'cg.country_id')
            ->leftjoin('companies_galleries as eg', 'eg.gallery_id', '=', 'galleries.id')
            ->leftjoin('companies as e', 'e.id', '=', 'eg.company_id')
            ->where(function ($q) use ($currentlangId) {
                $q->where('lg.language_id', $currentlangId)->where('l.is_activated', 1)
                    ->orWhere('cg.language_id', $currentlangId)->where('c.is_activated', 1)
                    ->orWhere('eg.language_id', $currentlangId);
            })
            ->WhereNotNull('galleries.is_pubslider')
            ->whereIn('user_id', [1,2]) // ADMINs
            ->select('galleries.slug', 'galleries.id', 'galleries.name', 'l.name as lname', 'c.name as cname', 'e.name as ename')
            ->take('50')
            ->orderBy('galleries.is_pubslider')
            ->with('medias')
            ->get();

        return $pubs_slider;
    }

    /** Désabonnement de la newsletter d'une entreprise*/
    public function resign($company, $email) {
        $company = Company::find($company);

        if (!CompanyFollower::isAFollower($company->id, $email)) {
            return Redirect::route('front.company.id', $company->id)->with('info', "Vous n'êtes pas abonné aux newsletters de cette entreprise");
        } //else

        CompanyFollower::where('company_id', $company->id)->where('email', $email)->delete();
        return Redirect::route('front.company.id', $company->id)->with('info', "Vous ne recevrez plus les newsletters de " . $company->name);
    }

    /** Inscription à la newsletter d'une entreprise */
    public function subscribe(SubscribeInfolettreRequest $request, $company) {
        // Si déjà abonné
        $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
        $isSite = !strstr($referer, $_ENV["DOMAIN"]);

        if (CompanyFollower::isAFollower($company, $request->mail)) {
          $msg = "Vous êtes déjà abonné à l'infolettre de cette entreprise.";
          if($isSite) {
            return back()->withErrors($msg);
          } else {
            return Redirect::route('front.company.id', $company)->withErrors($msg);
          }
        }

        // On abonne
        $news = new CompanyFollower();
        $news->company_id = $company;
        $news->email = $request->mail;
        $news->name = $request->name;
        $news->save();

        $msg = "Vous êtes maintenant abonné à l'infolettre de cette entreprise.";

        if( ! $isSite ) {
          return Redirect::route('front.company.id', $company)->with('success', $msg);
        } else {
          return back()->with('success', $msg);
        }
    }

    /** Formulaire d'inscription à la newsletter d'une entrepise */
    public function subscribeForm(Request $request, $slug) {
        $company = Company::getFromSlug($slug);
        $email = isset($request->email) ? $request->email : null;
        return view('front.company.subscribe', compact('company', 'email'));
    }

    /** Impression du formulaire d'achat */
    public function printForm(Request $request, $slug) {
        $company = Company::getFromSlug($slug);
        
        if ($company->is_deactivated) {
            return Redirect::route('error');
        }

        if (empty($request->product)) {
            return Redirect::route('error');
        }

        if ($company->last_invoice_number) {
            $company->last_invoice_number += 1;
        } else {
            $company->last_invoice_number = 1;
        }
        $company->save();

        $primaryContact = CompanyContact::getPrimaryContact($company->id);

        $products = $request->product;
        $user = $request->user;

        $companyProducts = [];
        if (!empty($company->products)) {
            $companyProducts = json_decode($company->products, true);
        }

        return view('front.company.print', compact('company', 'products', 'companyProducts', 'user', 'primaryContact'));
    }

    /** Renvoi l'entreprise à partir de son id */
    public function getByID($company) {
        $company = Company::find($company);

        if ($company->is_deactivated) {
            return Redirect::route('error');
        }

        return Redirect::route('front.company', Formatter::slugWithId($company->slugify()));
    }

    /** Retourne l'entreprise à partir de son slug*/
    public function get($slug) {



        $company = Company::getFromSlug($slug);

        if ($company->is_deactivated) {
            return Redirect::route('error');
        }

        $coordinate = $company->coordinate;
        $activities = $company->activitiesDetails();


        $allLanguages = Page::languages();
        $defaultPageLanguage = 'FR';

        $defaultLanguageCode = (array_key_exists('default_language', $company->toArray()) && !empty($company->default_language)) ? $company->default_language : $defaultPageLanguage ;
        $allPages = $company->pages()->where('is_visible', 1)->orderBy('rank')->orderBy('name')->get();

        if (isset($_GET['cl']) && !empty($_GET['cl'])) {
            if (array_key_exists($_GET['cl'], $allLanguages)) {
                $pages = $company->pages()->where('is_visible', 1)->where('language', $_GET['cl'])->orderBy('rank')->orderBy('name')->get();
            } else {
                $pages = $company->pages()->where('is_visible', 1)
                    ->where(function($query) use ($defaultLanguageCode) {
                        $query->orWhere('language', NULL)
                            ->orWhere('language', $defaultLanguageCode)
                            ->orWhere('language', '');
                    })->orderBy('rank')->orderBy('name')->get();
            }
        } else {
            //$pages = $allPages;
            $pages = $company->pages()->where('is_visible', 1)
                ->where(function($query) use ($defaultLanguageCode) {
                    $query->orWhere('language', NULL)
                        ->orWhere('language', $defaultLanguageCode)
                        ->orWhere('language', '');
                })->orderBy('rank')->orderBy('name')->get();
        }


        $currentlangId='';
        if(session()->has('locale')){
          $currentlangId = Language::getLangIdByLocale(session()->get('locale'));
        }

        $medias = Company::where('cg.company_id', $company->id)
        ->join('companies_galleries as cg', 'cg.company_id', '=', 'companies.id')
        ->join('galleries as g', 'g.id', '=', 'cg.gallery_id')
        ->join('medias as m', 'm.gallery_id', '=', 'g.id')
        //->leftJoin('media_attrs as ma', 'm.id', '=', 'ma.media_id')
        #->where('g.user_id', 1)
        ->where('cg.language_id', $currentlangId)
        ->select('g.slug as gslug', 'g.is_slider as gslider', 'g.id as gid', 'g.name as gname', 'cg.language_id', 'm.*'/*, 'ma.*'*/)
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

      $_page_medias = Company::where('cg.company_id', $company->id)
        ->join('companies_galleries as cg', 'cg.company_id', '=', 'companies.id')
        ->join('galleries as g', 'g.id', '=', 'cg.gallery_id')
        ->join('medias as m', 'm.gallery_id', '=', 'g.id')
        ->join('pages as p', 'p.id', '=', 'g.page_id')
        ->where('cg.language_id', $currentlangId)
        ->select('g.slug as gslug', 'g.is_slider as gslider', 'g.id as gid', 'g.name as gname', 'cg.language_id', 'm.*', 'p.slug as pslug')
        ->orderBy('g.id')
        ->orderBy('rank')
        ->get();

        $page_medias = [];
        foreach($_page_medias as $media) {
          if(!isset($page_medias[$media['pslug']])) {
            $page_medias[$media['pslug']] = [];
          }
          $page_medias[$media['pslug']][] = $media;
        }
        //dd($page_medias);

        $company_logo = $company->getLogoFilename();
        $company_headImage = $company->getLogoFilename('headImage');
        $company_footerImage = $company->getLogoFilename('footerImage');

        $pubs_slider = $this->getPubSlider();

        $pagesLanguages = [];
        $currentLanguage = $allLanguages[$defaultLanguageCode];

        foreach ($allPages as $page) {
            if (!empty($page->language)) {
                if (isset($allLanguages[$page->language])) {
                    $pagesLanguages[$page->language] = [
                        'name' => $allLanguages[$page->language],
                        'url' => url()->current() . '?cl=' . $page->language
                    ];
                }
            }
        }

        if (!empty($pagesLanguages)) {
            if (isset($_GET['cl']) && !empty($_GET['cl'])) {
                $default = (array_key_exists('default_language', $company->toArray()) && !empty($company->default_language)) ? $allLanguages[$company->default_language] : $currentLanguage ;
                $currentLanguage = (isset($allLanguages[$_GET['cl']])) ? $allLanguages[$_GET['cl']] : $default;
            }
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

        if (!empty($company->visits)) {
            $company->visits += 1;
        } else {
            $company->visits = 1;
        }
        $company->save();

        return view('front.company.details', compact('company', 'pages', 'pagesLanguages', 'currentLanguage', 'activities', 'coordinate', 'medias', 'company_logo',"medias_attr", "page_medias", 'company_headImage', 'company_footerImage', 'pubs_slider', 'pictos', 'products'));

    }


}
