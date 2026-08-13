<?php

namespace App\Models;

use App\Models\BaseModel;

class Comment extends BaseModel {

    protected $table = 'comments';

  	public function gallery(){
    	return $this->galleryLink->gallery;
  	}
  	
  	public function media(){
    	return $this->mediaLink->gallery;
  	}
  	
  	
  	public function mediaLink() {
  	    return $this->belongsTo('App/Models/MediaComment', 'comment_id');
  	}
  	
  	  	public function galleryLink() {
  	    return $this->belongsTo('App/Models/GalleryComment', 'comment_id');
  	}
  	
  	
  	public function user() {
  	    return $this->belongsTo('App/Models/User', 'user_id');
  	}
  	

}
