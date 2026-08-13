<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CompanyContactRequest;
use App\Models\CompanyContact;
use Illuminate\Http\Request;
use App\Models\Company;
use Redirect;
use App\Http\Controllers\Controller;

class CompanyContactController extends Controller {


	// Company TYPE
	// GET ROUTES
	public function add($company) {
		$company = Company::find($company);		

		return view ( 'back.company.contact.add', compact('company'));
	}
	public function edit($company, $id) {
		$company = Company::find($company);
		$contact = CompanyContact::find( $id );
		return view ( 'back.company.contact.edit' , compact('contact', 'company'));
	}


	public function delete($company, $id) {
		CompanyContact::find($id)->delete();
		return Redirect::route('company.contact.search', [ $company] )->with ( 'info', "Le contact a bien été supprimé");
	}

	public function index($company) {
		$company = Company::find($company);
		return view ( 'back.company.contact.search', compact('company') );
	}

	// POST ROUTES
	public function register(CompanyContactRequest $request, $company) {

		$contact = new CompanyContact();
		$contact->name = $request->name;
		$contact->email = $request->email;
		$contact->phone = $request->phone;
		$contact->mobile = $request->mobile;
		$contact->fax = $request->fax;
		$contact->address = $request->address;
		$contact->notes = $request->notes;
		$contact->is_main_contact = ($request->is_main_contact == 'on') ? true : false ;
		$contact->companies_id = $company;
		$contact->save ();

		return Redirect::route ( 'company.contact.search', [
				$company
		] )->with ( 'success', "Le contact a été ajouté avec succès");;
	}
	public function update(CompanyContactRequest $request, $company, $id) {
		$contact = CompanyContact::find ($id);
		$contact->name = $request->name;
		$contact->email = $request->email;
		$contact->phone = $request->phone;
		$contact->mobile = $request->mobile;
		$contact->fax = $request->fax;
		$contact->address = $request->address;
		$contact->notes = $request->notes;
		$contact->is_main_contact = ($request->is_main_contact == 'on') ? true : false ;
		$contact->save ();

		return Redirect::route ( 'company.contact.search', [
				 $company
		] )->with ( 'success', "Le contact été modifié avec succès");
	}


}
