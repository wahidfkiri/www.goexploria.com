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

class CountryGalleryController extends Controller {


	// GET ROUTES
	
	public function add() {
	  $langList = Language::orderBy('name')->has('locations')->pluck('name', 'id');
    if( count_of($langList) == 0 ){
      $langList[34] = 'Français';
      $langList[1] = 'Anglais';
    }
	  
		return view ( 'back.gallery.country.add', compact('langList') );
	}
	
	public function addmedia($gallery_id) {
	  if( $gallery = Gallery::find($gallery_id) ){
		  
		  $medias = Gallery::where('galleries.id', $gallery_id)
        ->join('medias as m', 'm.gallery_id', '=', 'galleries.id')
        ->orderBy('rank')
        ->get();
		  
		  return view ( 'back.gallery.country.addmedia', compact('gallery', 'medias') );
		}
		return Redirect::route('country.gallery.search')->withErrors('La référence à la galerie est manquant!');
	}
	
	public function edit($id) {		
		$gallery = Gallery::find( $id );
		$countries = $gallery->countries()->withPivot('language_id')->get();
		$langList = Language::orderBy('name')->has('locations')->pluck('name', 'id');		
		if( count_of($langList) == 0 ){
      $langList[34] = 'Français';
      $langList[1] = 'Anglais';
    }
    
    $language_ids=[];
    foreach( $countries as $country ){
      $language_ids[] = $country->pivot->language_id;
    }
    
		return view ( 'back.gallery.country.edit' , compact('gallery', 'countries', 'langList', 'language_ids'));
	}

	public function delete($id) {
		Gallery::find($id)->delete();
		return Redirect::route('country.gallery.search', [])->with('info', "La galerie a bien été supprimée");
	}
	
  public function deleteMedia($id) {
		if($media = Media::find($id)){
		  $gallery_id = $media->gallery->id; 
  		$media->delete();
  		return Redirect::route('country.gallery.addmedia', [$gallery_id])->with('info', "Le média a bien été supprimé");
		}
		return Redirect::route('country.gallery.search', [])->with('info', "Le média n'a pas été trouvé");
	}	
	
	public function search(request $request) {
    $galleries = new Gallery;
    $galleries = $galleries->join('countries_galleries as cg', 'cg.gallery_id', '=', 'galleries.id')
    ->join('languages as l', 'l.id', '=', 'cg.language_id')
    ->select('galleries.*', 'galleries.name as gname', 'l.locale');

    $galleries = $galleries->get(); #->unique()
    
		return view ( 'back.gallery.country.search', compact('galleries', 'request') );
	}

    public function addVideo(Request $request) {
        if( !$request->has('gallery_id')) {
            return Redirect::route('country.gallery.search')->withInput()->withErrors('La référence à la galerie est manquante!');
        }

        if ( $request->url == "" || !$request->has('url')) {
            return Redirect::route('country.gallery.addmedia', $request->gallery_id )->withInput()->withErrors('Veuillez entrer un url valide');
        }

        $media = new Media;
        $media->gallery_id = $request->gallery_id;
        $media->slug = $request->url;
        $media->photo = 0;
        $media->content = $request->source;

        $media->name = '';
        $media->rank = 1;
        $media->save ();

        return Redirect::route('country.gallery.addmedia', $request->gallery_id );
    }
	
	// POST ROUTES
	public function register(GalleryRequest $request) {
		
    if( !$request->has('locations') )
    {
      return Redirect::route('country.gallery.add')->withInput()->withErrors('Veuillez sélectionner au moins une destination');
    } 
    
    if( !$request->has('languages') )
    {
      return Redirect::route('country.gallery.add')->withInput()->withErrors('Veuillez sélectionner au moins une langue');
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
  		foreach( $request->locations as $id ){
    		 $gallery->countries()->attach($id, ['language_id' => $language]);
  		}
  	}
		
		return Redirect::route ( 'country.gallery.addmedia', [$gallery->id] )->with ('success', "La galerie <strong>".$gallery->name."</strong> a été ajoutée avec succès");
	}
	
	public function registerMedia(Request $request) {
		
		if( !$request->has('gallery_id')) {
      return Redirect::route('country.gallery.search')->withInput()->withErrors('La référence à la galerie est manquant!');
    }
		
    if( !$request->hasFile('medias') ){
      return Redirect::route('country.gallery.addmedia')->withInput()->withErrors('Veuillez sélectionner au moins un média à ajouter!');
    }
		
    #TODO: vidéo
    #TODO: Error quand le format n'est pas accepté (Ex: gif))
    
		$rank=1;
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
      return Redirect::route('country.gallery.edit', $id)->withInput()->withErrors('Veuillez sélectionner au moins un pays');
    } 
    
    if( !$request->has('languages') )
    {
      return Redirect::route('country.gallery.add')->withInput()->withErrors('Veuillez sélectionner au moins une langue');
    } 
    
    $gallery = Gallery::find($id);	
		$gallery->slug = str_slug($request->name);
		$gallery->name = $request->name;
		#$gallery->content = $request->content;
		
		$is_slider = $request->slider ? 1 : NULL;
		$gallery->is_slider = $is_slider;
		
		$gallery->save ();
		
		$gallery->countries()->detach(); // On écrase tout
		
		foreach( $request->languages as $language ){
  		foreach( $request->locations as $id ){
  		  $ids[$id] = ['language_id' => $language];
  		}
  		$gallery->countries()->attach($ids); // On ajoute
  	}
		
		return Redirect::route ( 'country.gallery.search', [] )->with( 'success', "La galerie <strong>".$gallery->name."</strong> a été modifiée avec succès");
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
    $media->save();
    
    return response()->json($media);
  }
  
}
