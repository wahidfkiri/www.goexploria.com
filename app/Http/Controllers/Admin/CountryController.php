<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\Continent;
use Redirect;
use Session;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddCountryPostRequest;
use App\Http\Requests\ActivateCountryPostRequest;
use App\Http\Requests\EditCountryPostRequest;

class CountryController extends Controller {

	
	// LOCATION
	// GET ROUTES
	public function index() {
		$pays = Country::where('is_activated', false)->orderBy('name')->pluck('name', 'id')->all();
        $paysOk = Country::orderBy ('name')->where('is_activated', true)->get();
		return view ( 'back.country.search' , compact ( 'pays', 'paysOk') );
	}
	
	public function add() {
		$continents = Continent::all()->pluck('name', 'id');
		return view ( 'back.country.add' , compact ( 'continents') );
	}

	public function edit($id) {
		$continents = Continent::all()->pluck('name', 'id');
		$country = Country::find($id);
		Session::put('country-update', $country->id);
		return view ( 'back.country.edit' , compact ( 'country', 'continents') );
	}

	public function update(EditCountryPostRequest $request, $id) {
		$country = Country::find($id);
		$country->name = $request->name;
		$country->rank = $request->rank;
		if( $country->code != $request->code ){
		  $country->code = $request->code;
		}
		$country->continent_id = $request->continent;
	 	$country->slug = $this->generateSlug($request->slug);
	 	$country->save();

		return Redirect::route('country.search')->with ( 'success', "Le pays <strong>".$country->name."</strong> a été modifié avec succès");
	}

	public function register(AddCountryPostRequest $request) {
		$country = new Country();
		$country->name = $request->name;
		$country->rank = $request->rank != null ? $request->rank : 1;
		$country->code = $request->code;
		$country->is_activated = true;
		$country->continent_id = $request->continent;
	 	$country->slug = $this->generateSlug($request->name);
	 	$country->save();

		return Redirect::route('country.search')->with ( 'success', "Le pays \"".$country->name."\" a été ajouté avec succès");
	}
	// POST ROUTES
	public function activate(ActivateCountryPostRequest $request) {
		$country = Country::find ( request()->input('pays') );
		$country->is_activated = true;
		$country->save ();
		return Redirect::route('country.search')->with ( 'success', "Le pays \"".$country->name."\" a été activé avec succès");
	}
	
	public function disable($id) {
		$country = Country::find($id);
		
		$country->is_activated = false;
		$country->save ();
		return Redirect::route('country.search')->with ( 'info', "Le pays \"".$country->name."\" a été désactivé avec succès");
	}

	public function delete($id) {
		$country = Country::find($id);
		
		if (count_of($country->locations) > 0) {
			return redirect()->back()->with ( 'error', "Impossible de supprimer le pays, des lieux dépendent encore de lui");
		}
		// Sinon on supprime
		$country->delete ();
		return Redirect::route('country.search')->with ( 'info', "Le pays a été supprimé avec succès");
	}
	
	// AJAX
  public function getcountriesbysearch(Request $request) {
    
    if($request->ajax())
    {
      $countries = Country::where('name', 'like', $request->search.'%')
      ->where('is_activated', true)
      /*
      ->whereNotExists(function ($query) {
          $query->select(DB::raw(1))
          ->from('locations as l')
          ->where('locations.is_activated', true)
          ->whereRaw('l.parent_id = locations.id');
      })
      */
      ->orderBy('name')
      ->select('id', 'name')
      ->get();
      
      return response()->json($countries);
    } else {
      return response()->json(['error' => 'it fails!']);
    }
  }
}
