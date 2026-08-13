<?php

namespace App\Models;

use App\Models\BaseModel;

class Activity extends BaseModel
{
    protected $table = 'activities';

    public function category()
    {
    	return $this->belongsTo('App\Models\ActivityCategory', 'category_id');
    }


    public function companies()
    {
    	return $this->belongsToMany('App\Models\Company', 'companies_activities', 'activity_id', 'company_id');
    }
    
    public function galleries(){
    	return $this->belongsToMany("App\Models\Gallery", 'activities_galleries', 'gallery_id', 'activity_id');
  	}

    public function locations() {
        return $this->hasManyThroughBelongTo( 'App/Models/Location', 'App/Models/Company' );
    }
}
