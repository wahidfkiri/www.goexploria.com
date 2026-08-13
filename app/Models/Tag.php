<?php

namespace App\Models;

use App\Models\BaseModel;

class Tag extends BaseModel {

    protected $table = 'tags';
    
    public $timestamps = false;

  	public function gallery(){
    	return $this->galleryLink->gallery;
  	}
  	
  	public function media(){
    	return $this->mediaLink->gallery;
  	}
  	
  	
  	public function mediaLink() {
  	    return $this->belongsTo('App/Models/MediaTag', 'tag_id');
  	}
  	
  	public function galleryLink() {
  	    return $this->belongsTo('App/Models/GalleryTag', 'tag_id');
  	}
}
