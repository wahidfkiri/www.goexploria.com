<?php

namespace App\Models;

use App\Models\BaseModel;

class Media extends BaseModel {

    protected $table = 'medias';
    protected $primaryKey = 'id';
    #protected $fillable = ['gallery_id', 'name', 'slug', 'content', 'target', 'photo', 'rank'];

  	public function tags() {
    	return $this->belongsToMany("App\Models\Tag", 'App\Models\MediaTag', 'tag_id', 'media_id');
  	}

  	public function comments() {
    	return $this->belongsToMany("App\Models\Comment", 'App\Models\MediaComment', 'comment_id', 'media_id');
  	}

  	public function gallery() {
    	return $this->belongsTo("App\Models\Gallery", 'gallery_id');
  	}

    public function attrs() {
      return $this->hasMany("App\Models\MediaAttr", "media_id", "id");
  	}


    // Events
    protected static function boot() {
      parent::boot();

      static::deleting(function($media) {
        $filename = $media->gallery_id.'/'.$media->slug;
        if( file_exists(base_path().'/public/uploads/galleries/'.$filename) ){
          unlink(base_path().'/public/uploads/galleries/'.$filename);
        }
      });
    }

    public static function getEntityMedias($entity) {
      $table = $entity->getTable();
      $name = strtolower(class_basename($entity));
      $entity_id = $entity->id;
      $isPhoto = 1;

      return Media::join('galleries as g', 'medias.gallery_id', '=', 'g.id')
      ->join($table . '_galleries as tblg', 'tblg.gallery_id', '=', 'g' . '.id')
      #->join('media_attrs as ma', 'ma.media_id', '=', 'm.id')
      ->where('tblg.' . $name . '_id', $entity_id)
      ->where('medias.photo', '=', $isPhoto)
      //->whereIn('g.page_id',$pages_id)
      ->select('g.page_id', 'g.id as gallery_id', 'medias.content', 'medias.name as name', 'medias.slug', "medias.updated_at", 'g.page_id' )
      ->get();
    }

    //sous array de medias par pages, les null sont à la page 0
    public static function getEntityMediasByPages($entity) {
      return array_reduce(Media::getEntityMedias($entity)->toArray(), function($carry, $item) {
        $page = $item['page_id'];
        if($page == null) $page = 0;
        if(!key_exists($page, $carry)) {
          $carry[$page] = [];
        }
        $carry[$page][] = $item;
        return $carry;
      }, []);
    }
}
