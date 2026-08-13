<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Models\Country;
use App\Models\Page;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;

class LocationPageController extends Controller {


	// LOCATION TYPE
	// GET ROUTES
	public function add($countryCode, $location) {
		$country = Country::getByCode($countryCode);
		$location = Location::find($location);		

		return view ( 'back.location.page.add', compact('location', 'country'));
	}
	
	public function edit($countryCode, $location, $id) {
		$country = Country::getByCode($countryCode);
		$location = Location::find($location);		
		$page = Page::find( $id );
		return view ( 'back.location.page.edit' , compact('page', 'country', 'location'));
	}


	public function delete($countryCode, $location, $id) {
		Location::find($location)->pages()->detach($id);
		Page::find($id)->delete();
		return Redirect::route('location.page.search', [ $countryCode, $location] )->with ( 'info', "La page a bien été supprimée");
	}

	public function visibility($countryCode, $location, $id) {
		$page = Page::find($id);
		$page->is_visible = !$page->is_visible;
		$page->save();
		return Redirect::route('location.page.search', [ $countryCode, $location] )->with ( 'info', "La page ".$page->name." est devenue " .strtolower($page->statut()) );
	}

	public function search($countryCode, $location) {
		$country = Country::getByCode($countryCode);
		$location = Location::find($location);
		$statuts = Page::statuts();		
		return view ( 'back.location.page.search', compact('location', 'country', 'statuts') );
	}
	

	// POST ROUTES
	public function register(PageRequest $request, $countryCode, $location) {
		$page = new Page();
		$page->set($request);

		$page->is_visible = $request->visible != null;
		$page->save ();

		Location::find($location)->pages()->attach($page);


		return Redirect::route ( 'location.page.search', [
				$countryCode, $location
		] )->with ( 'success', "La page \"".$page->name."\" a été ajoutée avec succès");;
	}
	
	public function update(PageRequest $request, $countryCode, $location, $id) {
		$page = Page::find ($id);	
		$page->set($request);
		$page->save ();

		return Redirect::route ( 'location.page.search', [
				$countryCode, $location
		] )->with ( 'success', "La page \"".$page->name."\" a été modifiée avec succès");
	}
   
}
