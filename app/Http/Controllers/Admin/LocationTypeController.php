<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\LocationType;
use App\Models\Country;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddLocationTypePostRequest;
use App\Http\Requests\EditLocationTypePostRequest;

class LocationTypeController extends Controller {

	// LOCATION TYPE
	// GET ROUTES
	public function add($countryCode) {
		$parent = LocationType::getByCountry ( $countryCode )->pluck('name', 'id');
		$country = Country::getByCode($countryCode);
		return view ( 'back.location.type.add', compact('parent', 'country'));
	}
	public function edit($countryCode, $id) {
		if ($id <= 1) {
			return back ();
		} else {
			$country = Country::getByCode($countryCode);
			$parent = LocationType::getByCountry ( $countryCode );
			$type = LocationType::find( $id );
			return view ( 'back.location.type.edit' , compact('parent', 'country', 'type'));
		}
	}
	public function delete($countryCode, $id) {
		$type = LocationType::find($id);
		// S'il y a des types fils
		if (count_of($type->fils) > 0) {
			return Redirect::route('location.type.search', [ $countryCode ] )->with ( 'error', "Suppression impossible, il existe des fils au type");

		// S'il y a des lieux pour le type
		} else if (count_of($type->locations) > 0) {
			return Redirect::route('location.type.search', [ $countryCode ] )->with ( 'error', "Suppression impossible, il existe des lieux pour ce type");
		} else {
			$type->delete();
			return Redirect::route('location.type.search', [ $countryCode ] )->with ( 'info', "Le type a bien été supprimé");
		}
	}
	public function map() {
		return view ( 'back.location.type.map' )->withCode ( Country::getAvailable() );
	}
	public function index($countryCode) {
		$types = LocationType::getByCountry ( $countryCode );
		$country = Country::getByCode($countryCode);
		return view ( 'back.location.type.search', compact('types', 'country') );
	}

	// POST ROUTES
	public function register(AddLocationTypePostRequest $request, $countryCode) {
		$pays = Country::where('code', $countryCode)->first();
		$type = new LocationType ();
		$type->name = $request->name;
		$type->parent_id = $request->parentID;
		$type->level = isset($request->parentID) ? LocationType::find($request->parentID)->level + 1 : 1;
		$type->country_id = $pays->id;

		$type->save ();

		return Redirect::route ( 'location.type.search', [
				$countryCode
		] )->with ( 'success', "Le type \"".$type->name."\" a été ajouté avec succès");;
	}
	public function update(EditLocationTypePostRequest $request, $countryCode, $id) {
		$type = LocationType::find ( $id );
		$type->name = $request->name;

		$type->save ();
		return Redirect::route ( 'location.type.search', [
				$countryCode
		] )->with ( 'success', "Le type \"".$type->name."\" a été modifié avec succès");
	}

}
