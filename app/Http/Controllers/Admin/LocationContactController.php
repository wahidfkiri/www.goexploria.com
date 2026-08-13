<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\LocationContactRequest;
use App\Models\Country;
use App\Models\LocationContact;
use App\Models\LocationContacts;
use Illuminate\Http\Request;
use App\Models\Location;
use Redirect;
use App\Http\Controllers\Controller;

class LocationContactController extends Controller {


	// Location TYPE
	// GET ROUTES
	public function add($countryCode, $location) {
        $country = Country::getByCode($countryCode);
		$location = Location::find($location);		

		return view ( 'back.location.contact.add', compact('location', 'country'));
	}
	public function edit($countryCode, $location, $contact_id) {
        $country = Country::getByCode($countryCode);
		$location = Location::find($location);
		$contact = LocationContacts::find( $contact_id );
		return view ( 'back.location.contact.edit' , compact('contact', 'location', 'country'));
	}


	public function delete($countryCode, $location, $contact_id) {
        $country = Country::getByCode($countryCode);
		LocationContacts::find($contact_id)->delete();
		return Redirect::route('location.contact.search', [
            $country,
            $location
        ] )->with ( 'info', "Le contact a bien été supprimé");
	}

	public function index($countryCode, $location) {
        $country = Country::getByCode($countryCode);
		$location = Location::find($location);
		return view ( 'back.location.contact.search', compact('location', 'country') );
	}

	// POST ROUTES
	public function register(LocationContactRequest $request, $countryCode, $location) {
        $country = Country::getByCode($countryCode);

		$contact = new LocationContacts();
		$contact->name = $request->name;
		$contact->email = $request->email;
		$contact->phone = $request->phone;
		$contact->mobile = $request->mobile;
		$contact->fax = $request->fax;
		$contact->address = $request->address;
		$contact->notes = $request->notes;
		$contact->is_main_contact = ($request->is_main_contact == 'on') ? true : false ;
		$contact->location_id = $location;
		$contact->save ();

		return Redirect::route ( 'location.contact.search', [
            $country,
            $location
		] )->with ( 'success', "Le contact a été ajouté avec succès");;
	}
	public function update(LocationContactRequest $request, $countryCode, $location, $contact_id) {
        $country = Country::getByCode($countryCode);
		$contact = LocationContacts::find ($contact_id);
		$contact->name = $request->name;
		$contact->email = $request->email;
		$contact->phone = $request->phone;
		$contact->mobile = $request->mobile;
		$contact->fax = $request->fax;
		$contact->address = $request->address;
		$contact->notes = $request->notes;
		$contact->is_main_contact = ($request->is_main_contact == 'on') ? true : false ;
		$contact->save ();

		return Redirect::route ( 'location.contact.search', [
            $country,
             $location
		] )->with ( 'success', "Le contact été modifié avec succès");
	}


}
