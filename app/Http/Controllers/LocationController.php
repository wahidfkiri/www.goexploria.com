<?php

namespace App\Http\Controllers;

use App\Services\CountryCacheService;
use App\Services\LocationCacheService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\Location;
use App\Models\LocationType;
use App\Models\Country;
use App\Models\Continent;
use App\Models\Company;
use App\Models\Gallery;
use App\Models\Media;
use App\Models\Language;

use Redirect;
use DB;

class LocationController extends Controller
{

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
            ->WhereNotNull('galleries.is_pubslider_destination')
            ->whereIn('user_id', [1,2]) // ADMINs
            ->select('galleries.slug', 'galleries.id', 'galleries.name', 'l.name as lname', 'c.name as cname', 'e.name as ename')
            ->take('50')
            ->orderBy('galleries.is_pubslider_destination')
            ->with('medias')
            ->get();

        return $pubs_slider;
    }

    // Renvoi la liste pour type à taille variable
    public function getFromSlug($slug)
    {
        $hierarchie = explode('/', $slug);

        // Tentative avec slug faux
        switch (count_of($hierarchie)) {
            case 0:
                return Redirect::route('error');

            // On récupère les pays pour un continent
            case 1:
                return $this->getContinentDetail($hierarchie[0]);

            // On récupère le premier niveau pour un pays
            case 2:
                return $this->getCountryDetail($hierarchie[0], $hierarchie[1]);

            // On récupère les infos d'un lieu
            default:
                return $this->getLocation($hierarchie[0], $hierarchie[1], $hierarchie);

        }
    }

    // Renvoie la liste des continents
    public function continent()
    {
        return redirect('/');
        $location = Continent::select('name', 'code as slug')
            ->orderBy('rank', 'desc')
            ->orderBy('name')
            ->get();
        $type = "Continent";
        $fils = $location;

        $mainCity = Location::biggestCity();

        $pubs_slider = $this->getPubSlider();

        return view('front.location', compact('fils', 'location', 'type', 'mainCity', 'pubs_slider'));
    }

    // Renvoi la page des lieux en fonction d'un id
    public function getLocationByID($id)
    {
        // Récupération des infos du lieu
        $current = Location::find($id);

        // Génération du slug
        $slug = Location::createSlug($current);
        $type = $current->type->name;

        return Redirect::route('front.location', [$slug]);
    }

    // Renvoi la page des pays en fonction d'un id
    public function getCountryByID($id)
    {
        // Récupération des infos du pays
        $current = Country::find($id);

        // Génération du slug
        $slug = $current->continent->code . '/' . $current->slug;

        return Redirect::route('front.location', [$slug]);
    }

    // Renvoi la page des continents en fonction d'un id
    public function getContinentByID($id)
    {
        // Récupération des infos du continent
        $current = Continent::find($id);

        // Génération du slug
        $slug = $current->code;

        return Redirect::route('front.location', [$slug]);
    }

    /** Retourne la liste des pays pour un continent donné */
    public function getContinentDetail($continent)
    {
        // Récupération du nom du continent
        $location = Continent::where('code', $continent)->first();

        // Par défaut on a des pays
        $type = "Pays";

        // On récupère la liste triée
        #$fils = $location->countries()->orderBy("rank", 'desc')->orderBy("is_activated", 'desc')->orderBy('name')->get();
        $fils = $location->countries()->orderBy("is_activated", 'desc')->orderBy('name')->get();

        $mainCity = $location->mainCity();
        $mainDestination = $location->mainDestination();

        $hierarchie = $location->slugify();

        $pubs_slider = $this->getPubSlider();

        return view('front.location', compact('location', 'fils', 'type', 'mainCity', 'hierarchie', 'mainDestination', 'pubs_slider'));
    }

    /** Retourne la liste du premier niveau pour un pays donné */
    public function getCountryDetail($continent, $country)
    {
        // Récupération du nom du continent
        $location = Country::join('continents', 'continents.id', '=', 'countries.continent_id')
            ->where('countries.slug', $country)
            ->where('continents.code', $continent)
            ->select('countries.*')
            ->first();
        $countryCache = new CountryCacheService($location);
        // Par défaut on a des pays
        $fils = $countryCache->fils();


        $type = count_of($fils) > 0 ? $fils[0]->type->name : "Aucun";
        $activities = $countryCache->activities();
        //$activityCompanies = $countryCache->activityCompanies();
        $mainCity = $countryCache->mainCity();       
        $location->population = $countryCache->population();
        $hierarchie = $location->slugify();

        $mainDestination = $countryCache->mainDestination();

        $pages = $countryCache->pages();

        $currentlangId = '';
        if (session()->has('locale')) {
            $currentlangId = Language::getLangIdByLocale(session()->get('locale'));
        }



        $country_id = Country::where('countries.slug', $country)->first()->id;

        $medias = $countryCache->medias($currentlangId);

        /*
        # DEBUG
        foreach( $medias as $media ){
          echo $media->id;
          echo "<br>------###------<br>";
        }
        exit;     
        */

        $pubs_slider = $this->getPubSlider();

        return view('front.location', compact('location', 'fils', 'type', 'activities', 'mainCity', 'hierarchie', 'pages', 'medias', 'mainDestination', 'pubs_slider'));
    }

    /** Retourne le détail d'un lieu */
    public function getLocation($continent, $country, $hierarchie)
    {

        // On retire les infos inutiles du slug
        $proper_slug = $hierarchie;
        array_shift($proper_slug);
        array_shift($proper_slug);

        /** On récupère le bon lieu */
        $location = Location::locationFromSlug($continent, $country, $proper_slug);
        $locationCache = new LocationCacheService($location);
        /** On récupère les fils et le type de ceux-ci */
        $fils = $locationCache->fils();
        $type = count_of($fils) > 0 ? $fils[0]->type->name : "Aucun";
        $coordinate = $locationCache->coordinate();
        $activities = $locationCache->activities();
        //$activityCompanies = $locationCache->activityCompanies();
        $mainCity = $locationCache->mainCity();
        $hierarchie = $location->slugify();
        $pages = $locationCache->pages();

        $mainDestination = $locationCache->mainDestination();

        #BON $galleries = Location::find($location->id)->galleries()->where('user_id','=','1')->with('medias')->get();

        $currentlangId = '';
        if (session()->has('locale')) {
            $currentlangId = Language::getLangIdByLocale(session()->get('locale'));
        }

        $medias = $locationCache->medias($currentlangId);

        /*
        # DEBUG
        foreach( $medias as $media ){
          echo $media->id;
          echo "<br>------###------<br>";
        }
        exit;     
        */

        $pubs_slider = $this->getPubSlider();

        return view('front.location', compact('location', 'fils', 'type', 'coordinate', 'activities', 'mainCity', 'pages', 'hierarchie', 'medias', 'mainDestination', 'pubs_slider'));
    }

    // AJAX
    /* BACKUP TEMP POSSIBLE DOUBLON INUTILE
    public function getlocationsbysearch(Request $request) {
      
      if($request->ajax())
      {
        #$locations = Country::find($request->id)->locations()->orderBy('name')->pluck('locations.name', 'locations.id');
        
        $locations = Location::join('locations_types as lt', 'lt.id', '=', 'locations.type_id')
        ->leftjoin('countries as c', 'c.id', '=', 'locations.parent_id')
        ->where('locations.name', 'ilike', $request->search.'%')
        ->where('locations.is_activated', true)
        
        ->orderBy('locations.name')
        ->select('locations.id', 'locations.name', 'c.name as cname', 'lt.name as tname')
        ->get();
        
        return response()->json($locations);
      } else {
        return response()->json(['error' => 'it fails!']);
      }
    }
   */

}
