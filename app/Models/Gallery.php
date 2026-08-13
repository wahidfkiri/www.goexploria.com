<?php

namespace App\Models;

use App\Models\BaseModel;

class Gallery extends BaseModel
{
    protected $table = 'galleries';

    protected $fillable = ['name', 'content', 'user_id'];

  	public function tags(){
    	return $this->belongsToMany("App\Models\Tag", 'App\Models\GalleryTag', 'tag_id', 'gallery_id');
  	}

  	public function comments(){
    	return $this->belongsToMany("App\Models\Comment", 'App\Models\GalleryComment', 'comment_id', 'gallery_id');
  	}

  	public function user(){
    	return $this->belongsTo("App\Models\User", 'user_id');
  	}

  	public function locations(){
    	return $this->belongsToMany("App\Models\Location", 'locations_galleries', 'gallery_id', 'location_id')->withPivot('language_id');
  	}

  	public function countries(){
    	return $this->belongsToMany("App\Models\Country", 'countries_galleries', 'gallery_id', 'country_id')->withPivot('language_id');
  	}

  	public function activities(){
    	return $this->belongsToMany("App\Models\Activity", 'activities_galleries', 'activity_id', 'gallery_id');
  	}

  	public function companies(){
    	return $this->belongsToMany("App\Models\Company", 'companies_galleries', 'gallery_id', 'company_id')->withPivot('language_id');
  	}

  	public function medias(){
    	return $this->hasMany("App\Models\Media", 'gallery_id');
  	}

    public function page() {
      return $this->belongsTo("App\Models\Page", 'page_id');
    }
    public function isChild() {
      return ! $this->page()->get()->isEmpty();
    }

    public static function unlinkAll($dir) {
      $files = scandir($dir);
      foreach($files as $i) {
        $f = $dir . '/' . $i;
        if($i == '.' || $i == '..') continue;
        if( is_dir($f) ) {
          static::unlinkAll($f);
        } else {
          unlink($f);
        }
      }
      rmdir($dir);
    }

    // Events
    protected static function boot() {
      parent::boot();

      static::deleting(function($gallery) {
        foreach( $gallery->medias as $media ){
          $media->delete();
        }

        // Enlever le dossier maintenant vide de la galerie
        $gallery_dir = base_path().'/public/uploads/galleries/'.$gallery->id;
        if( is_dir( $gallery_dir ) ){
          static::unlinkAll( $gallery_dir );
        }
      });
    }

  	// Helpers
  	public function isAdminCreated(){
      return User::find($this->user_id)->isAdmin();
  	}

  	public function getLocationRef(){
  	  dd($this->locations()->first()->id);
      return Location::find($this->locations()->id)->name;
  	}

  	public function getLanguage(){
  	  return Language::find($this->pivot->language_id)->name;
  	}
}
