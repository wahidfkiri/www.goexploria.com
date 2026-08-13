<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\Location;

class Language extends BaseModel
{
    protected $table = 'languages';
    public $timestamps = false;
    
    public function locations()
    {
        return $this->belongsToMany('App\Models\Location', 'locations_languages', 'language_id', 'location_id');
    }
    
    public static function getLangIdByLocale($locale)
    {
        // Récupération des infos du lieu
        $lang = Language::where('locale', $locale)->first();
  
        return $lang->id;
    }
}
