<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Page;
use Redirect;
use App\Http\Controllers\Controller;
use App\Http\Requests\PageRequest;

class PageController extends Controller {

	public function delete($id) {
		Page::find($id)->delete();
		return Redirect::back()->with ( 'info', "La page a bien été supprimée");
	}

	public function visibility($id) {
		$page = Page::find($id);
		$page->is_visible = !$page->is_visible;
		$page->save();
		return Redirect::back()->with ( 'info', "La page ".$page->name." est devenue " .strtolower($page->statut()) );
	}



}
