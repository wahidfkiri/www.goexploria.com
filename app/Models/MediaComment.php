<?php

namespace App\Models;

use App\Models\BaseModel;

class MediaComment extends BaseModel
{
    protected $table = 'medias_comments';
    public $timestamps = false;

    public $incrementing = false;

    public $primaryKey = ["media_id", "comment_id"];
    
    public function media() {
  	    return $this->belongsTo('App/Models/Media', 'media_id');
  	}
  	
  	public function comment() {
  	    return $this->belongsTo('App/Models/Comment', 'comment_id');
  	}
}
