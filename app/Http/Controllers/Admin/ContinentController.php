<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Laracasts\Utilities\JavaScript\JavaScriptFacade as JavaScript;
use App\Models\Continent;
use Redirect;
use Session;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddContinentPostRequest;
use App\Http\Requests\EditContinentPostRequest;

class ContinentController extends Controller {

	
	// LOCATION
	// GET ROUTES
	public function index() {
		$continents = Continent::orderBy ( 'name' )->get();
		return view ( 'back.continent.search' , compact('continents') );
	}
	
	public function add() {
		return view ( 'back.continent.add' );
	}

	public function edit($id) {
		$continent = Continent::find($id);
		Session::put('continent-update', $id);
		return view ( 'back.continent.edit' , compact('continent') );
	}

	public function update(EditContinentPostRequest $request, $id) {
		$continent = Continent::find($id);
		$continent->name = $request->name;
		$continent->rank = $request->rank;
		$continent->code = $request->code;
	 	$continent->save();

		return Redirect::route('continent.search')->with ( 'success', "Le continent \"".$continent->name."\" a été modifié avec succès");
	}

	public function register(AddContinentPostRequest $request) {
		$continent = new Continent();
		$continent->name = $request->name;
		$continent->rank = $request->rank != null ? $request->rank : 1;
		$continent->code = $request->code;
	 	$continent->save();

		return Redirect::route('continent.search')->with ( 'success', "Le continent \"".$continent->name."\" a été ajouté avec succès");
	}


	public function delete($id) {
		$continent = Continent::find($id);
		
		if (count_of($continent->countries) > 0) {
			return Redirect::route('continent.search')->with ( 'error', "Impossible de supprimer le continent, des pays dépendent encore de lui");
		}
		// Sinon on supprime
		$continent->delete ();
		return Redirect::route('continent.search')->with ( 'info', "Le continent a été supprimé avec succès");
	}
}
