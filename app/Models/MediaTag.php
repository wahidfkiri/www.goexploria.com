<?php

namespace App\Models;

use App\Models\BaseModel;

class MediaTag extends BaseModel
{
        protected $table = 'medias_tags';
    public $timestamps = false;

    public $incrementing = false;

    public $primaryKey = ["media_id", "tag_id"];
    
    public function media() {
  	    return $this->belongsTo('App/Models/Media', 'media_id');
  	}
  	
  	public function tag() {
  	    return $this->belongsTo('App/Models/Tag', 'tag_id');
  	}
}
