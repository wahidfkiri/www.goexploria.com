<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Gallery;
use Redirect;
use App\Http\Controllers\Controller;

class GalleryController extends Controller {

	public function delete($id) {
		Gallery::find($id)->delete();
		return Redirect::back()->with ( 'info', "La galerie a bien été supprimée");
	}

	public function visibility($id) {
		$gallery = Gallery::find($id);
		$gallery->is_visible = !$gallery->is_visible;
		$gallery->save();
		return Redirect::back()->with ( 'info', "La galerie ".$page->name." est devenue " .strtolower($page->statut()) );
	}



}
