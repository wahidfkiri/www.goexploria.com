<?php

namespace App\Models;

use App\Models\BaseModel;

class CommentLike extends BaseModel
{
    protected $table = 'comment_likes';
    
    public $timestamps = false;

    public $incrementing = false;

    public $primaryKey = ["user_id", "comment_id"];
    
    public function comment() {
  	    return $this->belongsTo('App/Models/Comment', 'comment_id');
  	}
  	
  	public function user() {
  	    return $this->belongsTo('App/Models/User', 'user_id');
  	}
}
