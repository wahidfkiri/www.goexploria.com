<?php

namespace App\Models;

use App\Models\BaseModel;

class GalleryComment extends BaseModel
{
    protected $table = 'galleries_comments';
    
    public $timestamps = false;

    public $incrementing = false;

    public $primaryKey = ["comment_id", "gallery_id"];
    
    public function gallery() {
  	    return $this->belongsTo('App/Models/Gallery', 'gallery_id');
  	}
  	
  	public function comment() {
  	    return $this->belongsTo('App/Models/Comment', 'comment_id');
  	}
}
