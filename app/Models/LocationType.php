<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\Country;
use App\Models\Location;

class LocationType extends BaseModel
{
    protected $table = 'locations_types';

    public function country(){
    	return $this->belongsTo('App\Models\Country', 'country_id');
    }

    public function locations(){
    	return $this->hasMany('App\Models\Location', 'type_id');
    }
    
    public function fils(){
    	return $this->hasMany('App\Models\LocationType', 'parent_id');
    }
    
    public function head(){
    	return $this->belongsTo('App\Models\LocationType', 'parent_id');
    }
    
    public static function getByCountry($countryCode) {
		return LocationType::join ( 'countries', 'locations_types.country_id', '=', 'countries.id' )
		                ->where ( 'countries.code', $countryCode )
		                ->orderBy('level')
		                ->select('locations_types.*')->get ();
	}
}
