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
use App\Models\MediaAttr;
use App\Models\Language;

use Image;

use Redirect;
use Storage;
use Auth;

class LocationGalleryController extends Controller {


	// GET ROUTES

	public function add() {
	  #$countries = Country::has('locations')->orderBy('name')->with('locations')->get();
	  #$locations = Location::where('is_activated', '=', true)->orderBy('name')->get();
	  $langList = Language::orderBy('name')->has('locations')->pluck('name', 'id');
    if( count_of($langList) == 0 ){
      $langList[34] = 'Français';
      $langList[1] = 'Anglais';
    }

		return view ( 'back.gallery.location.add', compact('langList') );
	}

	public function addmedia($gallery_id) {
	  if( $gallery = Gallery::find($gallery_id) ){

		  $medias = Gallery::where('galleries.id', $gallery_id)
        ->join('medias as m', 'm.gallery_id', '=', 'galleries.id')
        ->orderBy('rank')
        ->get();

		  return view ( 'back.gallery.location.addmedia', compact('gallery', 'medias') );
		}
		return Redirect::route('location.gallery.search')->withErrors('La référence à la galerie est manquant!');
	}

	public function edit($id) {
		$gallery = Gallery::find( $id );
		$locations = $gallery->locations()->withPivot('language_id')->get();
		$langList = Language::orderBy('name')->has('locations')->pluck('name', 'id');
		if( count_of($langList) == 0 ){
      $langList[34] = 'Français';
      $langList[1] = 'Anglais';
    }

    $language_ids=[];
    foreach( $locations as $location ){
      $language_ids[] = $location->pivot->language_id;
    }

		return view ( 'back.gallery.location.edit' , compact('gallery', 'locations', 'langList', 'language_ids'));
	}

	public function delete($id) {
		#Gallery::find($gallery_id)->detach($gallery_id);
		Gallery::find($id)->delete();
		return Redirect::route('location.gallery.search', [])->with('info', "La galerie a bien été supprimée");
	}

  public function deleteMedia($id) {
		if($media = Media::find($id)){
		  $gallery_id = $media->gallery->id;
  		$media->delete();
  		return Redirect::route('location.gallery.addmedia', [$gallery_id])->with('info', "Le média a bien été supprimé");
		}
		return Redirect::route('location.gallery.search', [])->with('info', "Le média n'a pas été trouvé");
	}

/*
	public function visibility($countryCode, $location, $id) {
		$page = Page::find($id);
		$page->is_visible = !$page->is_visible;
		$page->save();
		return Redirect::route('location.page.search', [ $countryCode, $location] )->with ( 'info', "La page ".$page->name." est devenue " .strtolower($page->statut()) );
	}
*/
	public function search(request $request) {
    $galleries = new Gallery;
    $galleries = $galleries->join('locations_galleries as lg', 'lg.gallery_id', '=', 'galleries.id')
    ->join('languages as l', 'l.id', '=', 'lg.language_id')
    ->select('galleries.*', 'galleries.name as gname', 'l.locale');

    $galleries = $galleries->get(); #->unique()

		return view ( 'back.gallery.location.search', compact('galleries', 'request') );
	}

    public function addVideo(Request $request) {
        if( !$request->has('gallery_id')) {
            return Redirect::route('location.gallery.search')->withInput()->withErrors('La référence à la galerie est manquante!');
        }

        if ( $request->url == "" || !$request->has('url')) {
            return Redirect::route('location.gallery.addmedia', $request->gallery_id )->withInput()->withErrors('Veuillez entrer un url valide');
        }

        $media = new Media;
        $media->gallery_id = $request->gallery_id;
        $media->slug = $request->url;
        $media->photo = 0;
        $media->content = $request->source;

        $media->name = '';
        $media->rank = 1;
        $media->code = '';
        $media->save ();

        return Redirect::route('location.gallery.addmedia', $request->gallery_id );
    }

	// POST ROUTES
	public function register(GalleryRequest $request) {

    if( !$request->has('locations') )
    {
      return Redirect::route('location.gallery.add')->withInput()->withErrors('Veuillez sélectionner au moins une destination');
    }

    if( !$request->has('languages') )
    {
      return Redirect::route('location.gallery.add')->withInput()->withErrors('Veuillez sélectionner au moins une langue');
    }

    $gallery = new Gallery;
    $gallery->user_id = Auth::user()->id;
    $gallery->name = $request->name;
    $gallery->content = $request->content;
    $gallery->slug = str_slug($request->name);

    $is_slider = $request->slider ? 1 : NULL;

		$gallery->is_slider = $is_slider;

		$gallery->save ();

  	foreach( $request->languages as $language ){
  		foreach( $request->locations as $location_id ){
    		 #echo $language." ".$location_id."<br>";
    		 $gallery->locations()->attach($location_id, ['language_id' => $language]);
  		}
  	}

		return Redirect::route ( 'location.gallery.addmedia', [$gallery->id] )->with ('success', "La galerie <strong>".$gallery->name."</strong> a été ajoutée avec succès");
	}

	public function registerMedia(Request $request) {

		if( !$request->has('gallery_id')) {
      return Redirect::route('location.gallery.search')->withInput()->withErrors('La référence à la galerie est manquant!');
    }

    if( !$request->hasFile('medias') ){
      return Redirect::route('location.gallery.addmedia')->withInput()->withErrors('Veuillez sélectionner au moins un média à ajouter!');
    }

    #TODO: vidéo

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
        if( $gallery->is_slider ){

        	// http://image.intervention.io/
        	Image::make( $file )->fit(945, 380, function ($constraint) {
					    $constraint->upsize();
					})->save( $url );

        } else {
        	Image::make( $file )->resize(1024, null, function ($constraint) {
            $constraint->upsize();
					  $constraint->aspectRatio();
					})->save( $url );
        }
      }
      $rank++;
    }

	}

	public function update(EditGalleryPostRequest $request, $id) {
		if( !$request->has('locations') )
    {
      return Redirect::route('location.gallery.edit', $id)->withInput()->withErrors('Veuillez sélectionner au moins une destination');
    }

    if( !$request->has('languages') )
    {
      return Redirect::route('location.gallery.add')->withInput()->withErrors('Veuillez sélectionner au moins une langue');
    }

		$gallery = Gallery::find($id);
		$gallery->slug = str_slug($request->name);
		$gallery->name = $request->name;
		#$gallery->content = $request->content;

		$is_slider = $request->slider ? 1 : NULL;
		$gallery->is_slider = $is_slider;

		$gallery->save ();

    $gallery->locations()->detach(); // On écrase tout

		foreach( $request->languages as $language ){
  		foreach( $request->locations as $id ){
  		  $ids[$id] = ['language_id' => $language];
  		}
  		$gallery->locations()->attach($ids); // On ajoute
  	}

		return Redirect::route ( 'location.gallery.search', [] )->with( 'success', "La galerie <strong>".$gallery->name."</strong> a été modifiée avec succès");
	}

  public function saveEditMedia(Request $request){

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


    if($request->attrs && is_array($request->attrs)) {
      $media->attrs()->delete();

      $media->attrs()->saveMany(
        array_map(function($attr) {
          if($attr["attr"] != '') {
            return new MediaAttr($attr);
          }
        },
        array_reduce($request->attrs, function($carry, $attr) {
          if($attr["attr"] != '') {
            $carry[] = $attr;
          }
          return $carry;
        }, []))
      );
    }

    return response()->json($media);
  }

}
