<?php

namespace App\Models;

use App\Models\BaseModel;

class GalleryLike extends BaseModel
{
    protected $table = 'galleries_likes';
    
    public $timestamps = false;

    public $incrementing = false;

    public $primaryKey = ["user_id", "gallery_id"];
    
    public function gallery() {
  	    return $this->belongsTo('App/Models/Gallery', 'gallery_id');
  	}
  	
  	public function user() {
  	    return $this->belongsTo('App/Models/User', 'user_id');
  	}
}
