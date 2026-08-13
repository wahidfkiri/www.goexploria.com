<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\LocationType;
use DB;

class Country extends BaseModel
{
    protected $table = 'countries';
    public $timestamps = false;
    
    public function types()
    {
    	return $this->hasMany('App\Models\LocationType', 'code');
    }

    public function getChildren() {
      return $this->locations();
    }

    public function locations(){
        return $this->hasManyThrough('App\Models\Location', 'App\Models\LocationType', 'country_id', 'type_id');
    }
    
    public function galleries(){
        return $this->belongsToMany('App\Models\Gallery', 'countries_galleries', 'country_id', 'gallery_id');
    }
    
    public function pages()
    {
      return $this->belongsToMany("App\Models\Page", 'countries_pages', 'country_id', 'page_id');
    }
    
    public function continent()
    {
        return $this->belongsTo('App\Models\Continent', 'continent_id');
    }

    public function hasDetails() {
        return $this->population() > 0;
    }

    public function mainCity() {
        return Location::join('locations_types as lt', 'lt.id','=', 'locations.type_id' )
                        ->where('lt.country_id', $this->id)
                        ->where('locations.is_activated', true)
                        ->whereIn('locations.type_id', [3, 7, 12, 17]) // Villes
                        ->whereNotExists(function ($query) {
                            $query->select(DB::raw(1))
                            ->from('locations as l')
                            ->where('locations.is_activated', true)
                            ->whereRaw('l.parent_id = locations.id');
                        })
                        ->orderBy('locations.population', 'desc')
                        ->orderBy('locations.name')
                        ->select('locations.*')
                        ->get();
    }
    
    public function mainDestination() {
        return Location::join('locations_types as lt', 'lt.id','=', 'locations.type_id' )
                      ->where('lt.country_id', $this->id)        				       
                      ->where('locations.is_activated', true)
                      ->where('locations.type_id', 4) // Province
                      ->join('locations as loc', 'loc.id', '=', 'locations.id')
                      ->select('locations.name', 'locations.slug', DB::raw('sum(loc.population) as population'))
                      ->groupBy('locations.id')
                      ->orderBy('population', 'desc')
                      ->take(4)
                      ->get();
    }
    
    public function population() {
        return Location::join('locations_types as lt', 'lt.id','=', 'locations.type_id' )
                        ->where('lt.country_id', $this->id)
                        ->where('locations.is_activated', true)
                        ->whereNotExists(function ($query) {
                            $query->select(DB::raw(1))
                            ->from('locations as l')
                            ->whereRaw('l.parent_id = locations.id');
                        })
                        ->sum('locations.population');

    }

    public function activities() {
        return Activity::join('activities_categories as ac', 'ac.id', '=', 'activities.category_id')
                        ->join('companies_activities as ca', 'activities.id','=', 'ca.activity_id' )
                        ->join('companies', 'companies.id','=', 'ca.company_id' )
                        ->join('coordinates', 'coordinates.id','=', 'companies.coordinate_id' )
                        ->join('locations', 'locations.id','=', 'coordinates.location_id' )
                        ->join('locations_types as lt', 'lt.id','=', 'locations.type_id' )
                        ->where('lt.country_id', $this->id)
                        ->select('activities.*', 'ac.type_id', 'ac.name as category_name')
                        ->distinct()
                        ->get();
    }
    
    public static function getAvailable() {
    	return Country::select ( 'code' )->where('is_activated', true)->get ();
    }
    
    public static function getByCode($code) {
    	return Country::where('code', $code)->first ();
    }

    public function slugify() {
        $slugs = [];
        $continent = $this->continent;        

        array_push($slugs, (object)["key" => $continent->id, "value" => $continent->code, "name" => $continent->name]);
        array_push($slugs, (object)["key" => $this->id, "value" => $this->slug, "name" => $this->name]);

        return $slugs;
    }
}
