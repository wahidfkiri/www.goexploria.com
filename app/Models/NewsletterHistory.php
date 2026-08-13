<?php

namespace App\Models;

use App\Models\BaseModel;

class NewsletterHistory extends BaseModel
{
    protected $table = 'newsletters_histories';

    public $timestamps = false;

    public $incrementing = false;

    public $primaryKey = ["newsletter_id", "sended_at"];


    public function newsletter(){
    	return $this->belongsTo('App\Models\Newsletter', 'newsletter_id');
    }

    public function user(){
    	return $this->belongsTo('App\Models\User', 'user_id');
    }
}
