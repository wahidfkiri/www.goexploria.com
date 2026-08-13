<?php

namespace App\Models;

use App\Models\BaseModel;

class LocationContacts extends BaseModel {

    protected $table = 'locations_contacts';

	public function location()
	{
		return $this->belongsTo('App\Models\Location', 'location_id');
	}

	public static function getPrimaryContact($locationId)
	{
		$locationContact = LocationContact::where('location_id', '=', $locationId)->where('is_main_contact', true)->first();

		return $locationContact;
	}

}
