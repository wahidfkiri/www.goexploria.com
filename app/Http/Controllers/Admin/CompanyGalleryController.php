<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\GalleryRequest;
use App\Http\Requests\EditGalleryPostRequest;

use App\Http\Controllers\Controller;

use App\Models\Country;
use App\Models\Location;
use App\Models\Gallery;
use App\Models\Media;
use App\Models\Language;

use Image;

use Redirect;
use Storage;
use Auth;

class CompanyGalleryController extends Controller {


	// GET ROUTES

	public function add() {
	  $langList = Language::orderBy('name')->has('locations')->pluck('name', 'id');
    if( count_of($langList) == 0 ){
      $langList[34] = 'Français';
      $langList[1] = 'Anglais';
    }

		return view ( 'back.gallery.company.add', compact('langList') );
	}

	public function addmedia($gallery_id) {
	  if( $gallery = Gallery::find($gallery_id) ) {
      $medias = Media::where('gallery_id', $gallery_id)->get();

      if($gallery->is_slider) {
        $dims = [945, 380,];
      } else {
        $dims = [1024, null];
      }

		  return view ( 'back.gallery.company.addmedia', compact('gallery', 'medias', 'dims') );
		}
		return Redirect::route('company.gallery.search')->withErrors('La référence à la galerie est manquant!');
	}

	public function edit($id) {
		$gallery = Gallery::find( $id );
		$companies = $gallery->companies()->withPivot('language_id')->get();
		$langList = Language::orderBy('name')->has('locations')->pluck('name', 'id');
		if( count_of($langList) == 0 ){
      $langList[34] = 'Français';
      $langList[1] = 'Anglais';
    }

    $language_ids=[];
    foreach( $companies as $company ){
      $language_ids[] = $company->pivot->language_id;
    }
    $pages = [];
    $page = Gallery::find( $id )->page()->get();

    $parent = $page->isEmpty() ? null : $page[0]->id;


    foreach($companies as $company) {
      foreach($company->pages()->get() as $page) {
        if( $page->children->count() > 0) continue;
        $pages[$page->id] =  $page->name ;
      }
    }

		return view ( 'back.gallery.company.edit' , compact('gallery', 'companies', 'langList', 'language_ids', 'pages', 'parent'));
	}

	public function delete($id) {
		Gallery::find($id)->delete();
		return Redirect::route('company.gallery.search', [])->with('info', "La galerie a bien été supprimée");
	}

  public function deleteMedia($id) {
		if($media = Media::find($id)){
		  $gallery_id = $media->gallery->id;
  		$media->delete();
  		return Redirect::route('company.gallery.addmedia', [$gallery_id])->with('info', "Le média a bien été supprimé");
		}
		return Redirect::route('company.gallery.search', [])->with('info', "Le média n'a pas été trouvé");
	}

	public function search(request $request) {
    $galleries = new Gallery;
    $galleries = $galleries->join('companies_galleries as cg', 'cg.gallery_id', '=', 'galleries.id')
    ->join('languages as l', 'l.id', '=', 'cg.language_id')
    ->select('galleries.*', 'galleries.name as gname', 'l.locale')
    ->groupBy('gname');

    $galleries = $galleries->get(); #->unique()

		return view ( 'back.gallery.company.search', compact('galleries', 'request') );
	}

	// POST ROUTES
	public function register(GalleryRequest $request) {

    if( !$request->has('locations') )
    {
      return Redirect::route('company.gallery.add')->withInput()->withErrors('Veuillez sélectionner au moins une destination');
    }

    if( !$request->has('languages') )
    {
      return Redirect::route('company.gallery.add')->withInput()->withErrors('Veuillez sélectionner au moins une langue');
    }


    $gallery = new Gallery;
    $gallery->user_id = Auth::user()->id;
    $gallery->name = $request->name;
    $gallery->content = $request->content;
    $gallery->slug = str_slug($request->name);

		$gallery->is_slider      = ( ($request->slider > 0 && $request->slider <= 100 ) || ($request->slider < 0 && $request->slider >= -100) ) ? $request->slider : null;
		$gallery->is_homeslider  = ( ($request->homeslider > 0 && $request->homeslider <= 100 ) || ($request->homeslider < 0 && $request->homeslider >= -100) ) ? $request->homeslider : null;
		$gallery->is_home        = ( ($request->home > 0 && $request->home <= 100 ) || ($request->home < 0 && $request->home >= -100) ) ? $request->home : null;
        $gallery->is_carousel        = ( ($request->carousel > 0 && $request->carousel <= 100 ) || ($request->carousel < 0 && $request->carousel >= -100) ) ? $request->carousel : null;
        $gallery->is_pubslider  = ( ($request->pubslider > 0 && $request->pubslider <= 100 ) || ($request->pubslider < 0 && $request->pubslider >= -100) ) ? $request->pubslider : null;
        $gallery->is_pubslider_destination  = ( ($request->is_pubslider_destination > 0 && $request->is_pubslider_destination <= 100 ) || ($request->is_pubslider_destination < 0 && $request->is_pubslider_destination >= -100) ) ? $request->is_pubslider_destination : null;
        $gallery->is_pubslider_list         = ( ($request->is_pubslider_list > 0 && $request->is_pubslider_list <= 100 ) || ($request->is_pubslider_list < 0 && $request->is_pubslider_list >= -100) ) ? $request->is_pubslider_list : null;

		$gallery->save ();

  	foreach( $request->languages as $language ){
  		foreach( $request->locations as $id ){
    		 $gallery->companies()->attach($id, ['language_id' => $language]);
  		}
  	}

		return Redirect::route ( 'company.gallery.addmedia', [$gallery->id] )->with ('success', "La galerie <strong>".$gallery->name."</strong> a été ajoutée avec succès");
	}

  public function addVideo(Request $request) {
    if( !$request->has('gallery_id')) {
      return Redirect::route('company.gallery.search')->withInput()->withErrors('La référence à la galerie est manquant!');
    }

    if ( $request->url == "" || !$request->has('url')) {
      return Redirect::route('company.gallery.addmedia', $request->gallery_id )->withInput()->withErrors('Veuillez entrer un url valide');
    }


    $media = new Media;
    $media->gallery_id = $request->gallery_id;
    $media->slug = $request->url;
    $media->photo = false;
    $media->content = $request->source;

    $media->name = '';
    $media->rank = 1;
    $media->code = '';
    $media->save ();

    return Redirect::route('company.gallery.addmedia', $request->gallery_id );
  }

	public function registerMedia(Request $request) {

		if( !$request->has('gallery_id')) {
      return Redirect::route('company.gallery.search')->withInput()->withErrors('La référence à la galerie est manquant!');
    }

    if( !$request->hasFile('medias') ){
      return Redirect::route('company.gallery.addmedia')->withInput()->withErrors('Veuillez sélectionner au moins un média à ajouter!');
    }

    #TODO: vidéo
    #TODO: Error quand le format n'est pas accepté (Ex: gif))

        $rank=1;
        $code='';
		$images_arr=[];
		foreach( $request->file('medias') as $file )
		{
		  $ext = strtolower($file->getClientOriginalExtension());
		  $filename = str_slug(substr($file->getClientOriginalName(), 0, -(strlen($ext)+1)));

		  $filename .= '.'.$ext;

      if( in_array($ext, ['jpg', 'jpeg', 'png'] ))
      {
        $media = new Media;
        $media->gallery_id = $request->gallery_id;
        $media->name = '';
        $media->slug = $filename;
        $media->rank = $rank;
        $media->code = $code;
        $media->photo = true;
        $media->save ();

        #Storage::put('media-' . $media->id . '-' . $media->slug . '.' . $ext1, file_get_contents($file1));

        $filename = $request->gallery_id.'/'.$filename;
        $url = base_path().'/public/uploads/galleries/' . $filename;
        $gallery_dir = base_path().'/public/uploads/galleries/' . $request->gallery_id;

        if( !is_dir( $gallery_dir ) ){
        	mkdir( $gallery_dir, 0770 );
        }

        $gallery = Gallery::find( $request->gallery_id );

        if( $request->must_resize ) {

          $width = !$request->has('width') || $request->width == '0' ? null: $request->width;
          $height = !$request->has('height') || $request->height == '0' ? null: $request->height;

          if( $gallery->is_slider ){

            // http://image.intervention.io/
            Image::make( $file )->fit($width, $height, function ($constraint) {
              #$constraint->upsize();
            }, 'top')->save( $url );

          } else {
            Image::make( $file )->resize($width, $height, function ($constraint) {
              $constraint->upsize();
              $constraint->aspectRatio();
            })->save( $url );
          }
        } else {
          Image::make( $file )->save( $url );
        }

      }
      $rank++;
    }

	}

	public function update(EditGalleryPostRequest $request, $id) {

		if( !$request->has('locations') )
    {
      return Redirect::route('company.gallery.edit', $id)->withInput()->withErrors('Veuillez sélectionner au moins un établissement');
    }

    if( !$request->has('languages') )
    {
      return Redirect::route('company.gallery.add')->withInput()->withErrors('Veuillez sélectionner au moins une langue');
    }

		$gallery = Gallery::find($id);
		$gallery->slug = str_slug($request->name);
		$gallery->name = $request->name;
		#$gallery->content = $request->content;

		$gallery->is_slider      = ( ($request->slider > 0 && $request->slider <= 100 ) || ($request->slider < 0 && $request->slider >= -100) ) ? $request->slider : null;
		$gallery->is_homeslider  = ( ($request->homeslider > 0 && $request->homeslider <= 100 ) || ($request->homeslider < 0 && $request->homeslider >= -100) ) ? $request->homeslider : null;
		$gallery->is_home        = ( ($request->home > 0 && $request->home <= 100 ) || ($request->home < 0 && $request->home >= -100) ) ? $request->home : null;
    $gallery->is_carousel        = ( ($request->carousel > 0 && $request->carousel <= 100 ) || ($request->carousel < 0 && $request->carousel >= -100) ) ? $request->carousel : null;
        $gallery->is_pubslider  = ( ($request->pubslider > 0 && $request->pubslider <= 100 ) || ($request->pubslider < 0 && $request->pubslider >= -100) ) ? $request->pubslider : null;
        $gallery->is_pubslider_destination  = ( ($request->pubslider_destination > 0 && $request->pubslider_destination <= 100 ) || ($request->pubslider_destination < 0 && $request->pubslider_destination >= -100) ) ? $request->pubslider_destination : null;
        $gallery->is_pubslider_list         = ( ($request->pubslider_list > 0 && $request->pubslider_list <= 100 ) || ($request->pubslider_list < 0 && $request->pubslider_list >= -100) ) ? $request->pubslider_list : null;
    $gallery->page_id = $request->page == 0 ? null: $request->page;
		$gallery->save ();

		$gallery->companies()->detach(); // On écrase tout

		foreach( $request->languages as $language ){
  		foreach( $request->locations as $id ){
  		  $ids[$id] = ['language_id' => $language];
  		}
  		$gallery->companies()->attach($ids); // On ajoute
  	}

		return Redirect::route ( 'company.gallery.search', [] )->with( 'success', "La galerie <strong>".$gallery->name."</strong> a été modifiée avec succès");
	}

  public function saveEditMedia(Request $request){
die('TEST');
    if( substr($request->target, 0, 4) !== 'http' && strlen($request->target) > 0 ){ // Valide pour http et https
      $target = 'http://'.$request->target;
    }
    else{
      $target = $request->target;
    }

    $media = Media::find($request->id);
    $media->name = $request->name;
    $media->target = $target;
    $media->content = $request->content;
    $media->rank = $request->rank;
    $media->code = $request->code;
    $media->save();

    return response()->json($media);
  }

}
