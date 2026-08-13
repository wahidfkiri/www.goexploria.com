<?php

namespace App\Models;

use App\Models\BaseModel;
use DB;

class Continent extends BaseModel
{
    protected $table = "continents";
        public $timestamps = false;

    public function getChildren() {
      return $this->countries();
    }

    public function countries()
    {
        return $this->hasMany('App\Models\Country', 'continent_id');
    }

    public function mainCity() {
        return Location::join('locations_types as lt', 'lt.id','=', 'locations.type_id' )
        				->join('countries', 'countries.id','=', 'lt.country_id' )
                        ->where('locations.is_activated', true)
                        ->where('countries.is_activated', true)
                        ->where('countries.continent_id', $this->id)
                        ->whereNotExists(function ($query) {
                            $query->select(DB::raw(1))
                            ->from('locations as l')
                            ->whereRaw('l.parent_id = locations.id');
                        })
                        ->orderBy('locations.population', 'desc')
                        ->orderBy('locations.name')
                        ->select('locations.*')
                        ->get();
    }
    
    public function mainDestination() {
        return Location::join('locations_types as lt', 'lt.id','=', 'locations.type_id' )
        				       ->join('countries', 'countries.id','=', 'lt.country_id' )
                       ->where('locations.is_activated', true)
                       ->where('countries.is_activated', true)
                       ->where('countries.continent_id', $this->id)
                       ->whereNotExists(function ($query) {
                           $query->select(DB::raw(1))
                           ->from('locations as l')
                           ->whereRaw('l.parent_id = locations.id');
                       })
                       ->select('countries.name', 'countries.slug', DB::raw('sum(locations.population) as population'))
                       ->groupBy('countries.id')
                       ->orderBy('population', 'desc')
                       ->take(8)
                       ->get();
    }

    public function slugify() {
        $slugs = [];

        array_push($slugs, (object)["key" => $this->id, "value" => $this->code, "name" => $this->name]);

        return $slugs;
    }

    public function galleries(){
      return false;
    }
}
