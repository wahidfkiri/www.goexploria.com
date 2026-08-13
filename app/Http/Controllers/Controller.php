<?php

namespace App\Http\Controllers;

use App\Models\Content;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use App\Models\Location;
use App\Models\Company;
use App\Models\Gallery;
use App\Models\Language;

use Image;
use Session;
use File;
use View;


class Controller extends BaseController
{
    /** Temps d'expiration des différentes valeurs => 6h*/
    protected $expireTime;
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    protected $page;

    public function __construct() {
        $this->expireTime = 6*60*60;
        $this->page = 25;

        $config_content = Content::latest()->first();

        View::share ( 'config_content', $config_content );
    }

    // HOMEPAGE
    public function homepage() {
      
      $currentlangId='';
      if(session()->has('locale')){
        $currentlangId = Language::getLangIdByLocale(session()->get('locale'));
      }

      /*  */
      $galleries_slider = Gallery::leftjoin('locations_galleries as lg', 'lg.gallery_id', '=', 'galleries.id')
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
      ->WhereNotNull('galleries.is_homeslider')
      ->whereIn('user_id', [1,2]) // ADMINs
      ->select('galleries.slug', 'galleries.id', 'galleries.name', 'l.name as lname', 'c.name as cname', 'e.name as ename')
      ->take('50')
      ->orderBy('galleries.is_homeslider')
      ->with('medias')
      ->get();

      /*  */
      $galleries = Gallery::leftjoin('locations_galleries as lg', 'lg.gallery_id', '=', 'galleries.id')
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
      ->whereNotNull('galleries.is_home')
      ->whereIn('user_id', [1,2]) // ADMINs
      ->select('galleries.slug', 'galleries.id', 'galleries.name', 'l.name as lname', 'c.name as cname', 'e.name as ename')
      ->take('12')
      ->orderBy('galleries.is_home')
      ->orderBy('galleries.updated_at', 'desc')
      ->with('medias')
      ->get();

      /*  */
      $vedette_companies = Company::with('coordinate')
      ->whereRaw('is_deactivated IS NULL OR is_deactivated = 0')
      ->take('5')
      ->orderBy('created_at', 'desc')
      ->get();

        $config_content = Content::latest()->first();

      # DEBUG
      /*
      foreach( $galleries as $gallery ){
        #echo $media->id;
        dd($gallery->name.' '.$gallery->lname);
        echo "<br>------###------<br>";
      }
      exit;
      */
      return view('front.index', compact('galleries_slider', 'galleries', 'vedette_companies', 'config_content'));
    }

    protected function randomString($length) {
        $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        return $str;
    }

    private function normalize ($string) {
      $table = array(
          'Š'=>'S', 'š'=>'s', 'Đ'=>'Dj', 'đ'=>'dj', 'Ž'=>'Z', 'ž'=>'z', 'Č'=>'C', 'č'=>'c', 'Ć'=>'C', 'ć'=>'c',
          'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
          'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O',
          'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss',
          'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e',
          'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o',
          'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b',
          'ÿ'=>'y', 'Ŕ'=>'R', 'ŕ'=>'r',
      );

      return strtr($string, $table);
    }

    /** Génère un slug valide à ppartir d'une chaine */
    protected function generateSlug($text) {
        $text = $this->normalize($text);
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    /** Renvoie la page courante lors d'une recherche*/
    public function storePage() {
        Session::flash('page', request()->input('page', 1));
    }

    public function getPage() {
        Session::reflash('page');
        $page = "page=".(Session::has('page') ? Session::get('page') : 1);
        return $page;
    }
}
