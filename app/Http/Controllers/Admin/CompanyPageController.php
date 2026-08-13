<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Page;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;

class CompanyPageController extends Controller {


	// Company TYPE
	// GET ROUTES
	public function add($company) {
		$company = Company::find($company);
		$languages = Page::languages();

		return view ( 'back.company.page.add', compact('company', 'languages'));
	}
	public function edit($company, $id) {
		$company = Company::find($company);
		$languages = Page::languages();
		$page = Page::find( $id );
    $parent = $page->parent_id != null ? $page->parent_id : 0;
    $logo_path = Page::$logo_path;
    $pages = [];
    $pages[] = "Aucun";
    foreach($company->pages as $p) {
      if($page->id == $p->id || $p->parent != null ) continue;
      $pages[$p->id] = $p->name;
    }
		return view ( 'back.company.page.edit' , compact('page', 'company', 'pages', 'parent', "logo_path", 'languages'));
	}


	public function delete($company, $id) {
		Company::find($company)->pages()->detach($id);
		Page::find($id)->delete();
		return Redirect::route('company.page.search', [ $company] )->with ( 'info', "La page a bien été supprimée");
	}

	public function visibility($company, $id) {
		$page = Page::find($id);
		$page->is_visible = !$page->is_visible;
		$page->save();
		return Redirect::route('company.page.search', [$company] )->with ( 'info', "La page ".$page->name." est devenue " .strtolower($page->statut()) );
	}

	public function search($company) {
		$company = Company::find($company);
		$statuts = Page::statuts();
		return view ( 'back.company.page.search', compact('company', 'statuts') );
	}

	// POST ROUTES
	public function register(PageRequest $request, $company) {
		$page = new Page();
		$page->set($request);

		$page->language = $request->language;
		$page->is_visible = $request->visible != null;
        $page->is_home = ($request->is_home == 'on') ? true : false ;
		$page->save ();

		Company::find($company)->pages()->attach($page);


		return Redirect::route ( 'company.page.search', [
				$company
		] )->with ( 'success', "La page \"".$page->name."\" a été ajoutée avec succès");;
	}

	public function update(PageRequest $request, $company, $id) {
		$page = Page::find ($id);
		$page->set($request);
		$page->language = $request->language;
		$page->external_link = $request->external_link;
        $page->is_home = ($request->is_home == 'on') ? true : false ;
		$page->save ();

		return Redirect::route ( 'company.page.search', [
				 $company
		] )->with ( 'success', "La page \"".$page->name."\" a été modifiée avec succès");
	}


}
