<?php

namespace App\Http\Controllers\Admin;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Laracasts\Utilities\JavaScript\JavaScriptFacade as JavaScript;
use App\Models\Location;
use App\Models\LocationType;
use App\Models\Country;
use App\Models\Language;
use App\Models\LocationLanguage;
use App\Models\Coordinate;
use Redirect;
use Session;
use Carbon;
use File;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddLocationPostRequest;
use App\Http\Requests\LocationHierarchieRequest;
use App\Http\Requests\LocationInfosRequest;
use App\Http\Requests\SearchLocationRequest;
use App\Http\Requests\LocationContactRequest;
use App\Http\Requests\ListLocationRequest;

class LocationController extends Controller {

	
	// LOCATION
	// GET ROUTES
	public function add($countryCode) {
		$type = LocationType::getByCountry ( $countryCode )->pluck('name', 'id');
		$languages = Language::orderBy('name')
					->pluck('name', 'id')
					->all();
		$country = Country::getByCode($countryCode);
		return view ( 'back.location.add', compact('type', 'country', 'languages'));
	}

	public function map() {
		return view ( 'back.location.map' )->withCode ( Country::getAvailable() );
	}

    // Page de recherche des villes
	public function index($countryCode) {
	    // Récupération des infos du pays
	    $country = Country::getByCode($countryCode);
	    $statuts = Location::statutsList();

	    // $search n'est affecté que dans la branche « recherche enregistrée » ;
	    // compact() lève une ErrorException sur une variable non définie
	    // depuis PHP 8 (elle était silencieusement ignorée avant PHP 7.3).
	    $search = null;

	    // Recherche d'une ville dans le cas normal
	    if (!Session::has('search-location-data') ||  Session::get('search-location-data')->country != $countryCode) {
	        // on efface les données de recherche pour le pays d'avant
	        if (Session::has('search-location-data')) {
	            Session::forget('search-location-data');
	        }
	        // on cherche
	        $locations = Location::join ( 'locations_types', 'locations.type_id', '=', 'locations_types.id' )
	                ->join ( 'countries', 'locations_types.country_id', '=', 'countries.id' )
	                ->where ( 'countries.code', '=', $countryCode )
	                ->select ( 'locations.*', 'locations_types.name as l_t_name' )
	                ->orderBy('locations_types.level')
	                ->orderBy('locations.name')
	                ->paginate($this->page);
	    } else {        
	        // recherche dans le cas où l'on a déjà des données enregistrés dans le formulaire
	        $request = Session::get('search-location-data');
	        $search = $request;
            $locations = Location::search($countryCode, $request->name, $request->type, $request->parent, $request->statut)->paginate($this->page);
            Session::reflash('search-location-data');

	    }          
	                
	    foreach ( $locations as $l ) {
	    	$l = LocationController::generateForMap($l);  
	    }

	    // On stocke la page courante
	    $this->storePage();

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

		return view ( 'back.location.search', compact('locations', 'country', 'search', 'statuts', 'pubs_slider'));
	}
	
	// Page de recherche des villes
	public function search($countryCode, SearchLocationRequest $request) {
	    $data = (object) [
         'name' => $request->name,
         'parent' => $request->parent,
         'type' => $request->type,
         'country' => $countryCode,
         'statut' => $request->statut,
        ];
	    Session::flash('search-location-data', $data);
	    
	    return Redirect::route('location.search', [ $countryCode ] );
	}
	
    // Suppression des paramètres de recherche
	public function clear($countryCode) {
	    if (Session::has('search-location-data')) {
	        Session::forget('search-location-data');
	    }
	    
	    return Redirect::route('location.search', [ $countryCode ] );
	}
	
	// Génération de la chaine pour la recherche sur la carte 
	private static function generateForMap($location) {           
	    
		    $lieu = $location;
		    $map = $location->name.',';
		    while($lieu->head != null) {
		        $map .= $lieu->head->name.',';
		        $lieu = $lieu->head;
		    }
		    
		    $map .= $lieu->type->country->name;
		    $location->map = $map;
		
		return $location;
	} 

	// Page de détail côté admin
	public function edit($countryCode, $id) {
		$location = Location::find( $id );
		$country = Country::getByCode($countryCode);
		 $activities = $location->activities();
		 $coordinate = $location->coordinate;
		 $location = LocationController::generateForMap($location);  
		return view ( 'back.location.details', compact('location', 'country', 'activities', 'coordinate'));
	}

	// Formulaire de MAJ des infos générales
	public function editInfos($countryCode, $id) {
		$location = Location::find( $id );
		// Langues que l'on ne parle pas
		$languages = Language::orderBy('name')
					->pluck('name', 'id')
					->all();

		$country = Country::getByCode($countryCode);
		return view ( 'back.location.infos', compact('location', 'country', 'languages'));
	}

	// Mise à jour des informations générales du lieu
	public function updateInfos(LocationInfosRequest $request, $countryCode, $id) {
		$location = Location::find( $id );

		$nom = explode(',', $request->name);
		$location->name = $nom[0];
		$location->slug = $this->generateSlug($request->slug);
		$location->description = $request->description != null ? $request->description : null;;
		$location->population = $request->population != null ? $request->population : 0;
		$location->latitude = $request->latitude != null ? $request->latitude : null;
		$location->longitude = $request->longitude != null ? $request->longitude : null;
		$location->superficie = $request->superficie != null ? $request->superficie : null;
		$location->gentile = $request->gentile != null ? $request->gentile : null;
                $location->map_url = empty($request->map_url) ? null : $request->map_url;
                
		if ($request->fondation != null)
			$location->fondation = Carbon::createFromFormat('m/d/Y', $request->fondation);

		// Mise à jour de l'image si une nouvelle a été rensiegnée
		if ($request->drapeau != null) {
			// Suppression de l'ancienne image s'il y en a une
			if ($location->drapeau != null){
				File::delete($location->drapeau);
			}
			$location->drapeau = $this->uploadImage($request->drapeau, 'uploads/drapeau');   
		}

		$location->save ();   // Sauvegarde
		
		// Mise à jour des langues parlées
		$langs = $request->languages == null ? array() : $request->languages;
		$location->languages()->sync($langs);

		return Redirect::route('location.edit',[$countryCode, $id])->with ( 'succes', "Les informations générales concernant ont bien été mises à jour");
	}

	// Formulaire d'édition du point d'informations
	public function editContact($countryCode, $id) {
		$location = Location::find( $id );
		$country = Country::getByCode($countryCode);
		return view ( 'back.location.contact', compact('location', 'country'));
	}


	// Mise à jour des infos du point d'informations
	public function updateContact(LocationContactRequest $request, $countryCode, $id) {
		$location = Location::find( $id );

		$location = $this->updateCoordinate($location, $request);
		$location->save ();   // Sauvegarde


		return Redirect::route('location.edit',[$countryCode, $id])->with ( 'succes', "Les données concernant la point d'informations ont bien été mises à jour");
	}

	// Formulaire d'édition de la hiérarchie
	public function editHierarchie($countryCode, $id) {
		$location = Location::find( $id );
		$type = LocationType::getByCountry ( $countryCode )->pluck('name', 'id');
	
		$country = Country::getByCode($countryCode);
		return view ( 'back.location.hierarchie', compact('location', 'country', 'type'));
	}

	// Mise à jour des infos de la hiérarchie
	public function updateHierarchie(LocationHierarchieRequest $request, $countryCode, $id) {
		$location = Location::find( $id );

		$location->type_id = $request->locationType;
		$location->parent_id = $request->parentID != null ? $request->parentID : null;
		$location->save();

		return Redirect::route('location.edit',[$countryCode, $id])->with ( 'succes', "Les informations concernant la hiérarchie ont bien été mises à jour");
	}

  // Formulaire d'édition du slider
	public function editSlider($countryCode, $id) {
		$location = Location::find( $id );
		$type = LocationType::getByCountry ( $countryCode )->pluck('name', 'id');
	
		$country = Country::getByCode($countryCode);
		return view ( 'back.location.slider', compact('location', 'country', 'type'));
	}

	public function delete($countryCode, $id) {
		Session::reflash('search-location-data');

		$location = Location::find($id);
		$route = route('location.search', [ $countryCode, $this->getPage() ] );
		if (count_of($location->fils) > 0) {
			return Redirect::to($route)->with ( 'error', "Suppression impossible, il existe des fils au lieu");
		} else if (Coordinate::where('location_id', $id)->count() > 0) {	
			return Redirect::to($route)->with ( 'error', "Suppression impossible, certaines coordonnées sont basées sur ce lieu");
		} else if (count_of($location->pages) > 0) {	
			return Redirect::to($route)->with ( 'error', "Suppression impossible, des pages ont été saisies pour le lieu");
		} else {
			$coordinate = $location->coordinate_id;
			$location->delete();

			// Suppression de la coordonnée s'il en existe une
			if ($coordinate != null) {
				Coordinate::find($coordinate)->delete();
			}
			return Redirect::to($route)->with ( 'info', "Le lieu a bien été supprimé");
		}
	}
	
	// POST ROUTES
	public function register(AddLocationPostRequest $request, $countryCode) {
		$location = new Location ();
		$location->type_id = $request->locationType;
		$location->parent_id = $request->parentID != null ? $request->parentID : null;
		$nom = explode(',', $request->name);
		$location->name = $nom[0];
		$location->slug = $this->generateSlug($location->name);
		$location->description = $request->description != null ? $request->description : null;;
		$location->population = $request->population != null ? $request->population : 0;
		$location->latitude = $request->latitude != null ? $request->latitude : null;
		$location->longitude = $request->longitude != null ? $request->longitude : null;
		$location->superficie = $request->superficie != null ? $request->superficie : null;
		$location->gentile = $request->gentile != null ? $request->gentile : null;
		if ($request->fondation != null)
			$location->fondation = Carbon::createFromFormat('m/d/Y', $request->fondation);

		if ($request->drapeau != null) 
			$location->drapeau = $this->uploadImage($request->drapeau, 'uploads/drapeau');  
		$location->save ();   
		
		// Mise à jour des langues parlées
		$langs = $request->languages == null ? array() : $request->languages;
		$location->languages()->sync($langs);
       
		return Redirect::route ( 'location.search', [ 
				$countryCode 
		] )->with ( 'success', "Le lieu \"".$location->name."\" a été ajouté avec succès");
	}
	

	
	// Mise à jour des coordonnées d'un lieu
	private function updateCoordinate(Location $location, $request) {
		// On renseigne les coordonnées du lieux
		if ($request->fax != null || $request->mail != null || $request->adresse != null || $request->tel != null || $request->website != null || $request->cp != null || $request->ville != null) {
			
			$coordinate = null;
			// Si pas encore de coordonnées renseignées on fait une nouvelle
			if ($location->coordinate_id == null) {
				$coordinate = new Coordinate();
			} else { // sinon on modifie l'actuelle
				$coordinate = Coordinate::find($location->coordinate_id);
			}

			// On remplit les champs non nuls
			$coordinate->set($request);
			$coordinate->save();

			// On met à jour la coordonnée du lieux
			if ($location->coordinate_id == null) {
				$location->coordinate_id = $coordinate->id;
			}
		}

		return $location;
	}	

	/** Inverse le statut de publication du lieu  */
	public function statut($countryCode, $id) {
		Session::reflash('search-location-data');

		$location = Location::find($id);
		$location->is_activated = !$location->is_activated;
		$location->save();
		return Redirect::route('location.search', [$countryCode, $this->getPage()])->with ( 'info', "Le lieu ".$location->name ." a bien été ".$location->statut()->txt);
	}
	
	// AJAX
  public function getlocationsbysearch(Request $request) {
    
    if($request->ajax())
    {
      #$locations = Country::find($request->id)->locations()->orderBy('name')->pluck('locations.name', 'locations.id');
      
      $locations = Location::join('locations_types as lt', 'lt.id', '=', 'locations.type_id')
      ->leftjoin('countries as c', 'c.id', '=', 'locations.parent_id')
      ->where('locations.name', 'like', $request->search.'%')
      ->where('locations.is_activated', true)
      /*
      ->whereNotExists(function ($query) {
          $query->select(DB::raw(1))
          ->from('locations as l')
          ->where('locations.is_activated', true)
          ->whereRaw('l.parent_id = locations.id');
      })
      */
      ->orderBy('locations.name')
      ->select('locations.id', 'locations.name', 'c.name as cname', 'lt.name as tname')
      ->get();
      
      return response()->json($locations);
    } else {
      return response()->json(['error' => 'it fails!']);
    }
  }

}
