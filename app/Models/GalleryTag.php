<?php

namespace App\Models;

use App\Models\BaseModel;

class GalleryTag extends BaseModel
{
        protected $table = 'galleries_tags';
    public $timestamps = false;

    public $incrementing = false;

    public $primaryKey = ["gallery_id", "tag_id"];
    
    public function gallery() {
  	    return $this->belongsTo('App/Models/Gallery', 'gallery_id');
  	}
  	
  	public function tag() {
  	    return $this->belongsTo('App/Models/Tag', 'tag_id');
  	}
}
