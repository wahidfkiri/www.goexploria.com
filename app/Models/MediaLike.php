<?php

namespace App\Models;

use App\Models\BaseModel;

class MediaLike extends BaseModel
{
    protected $table = 'media_likes';
    
    public $timestamps = false;

    public $incrementing = false;

    public $primaryKey = ["user_id", "media_id"];
    
    public function media() {
  	    return $this->belongsTo('App/Models/Media', 'media_id');
  	}
  	
  	public function user() {
  	    return $this->belongsTo('App/Models/User', 'user_id');
  	}
}
