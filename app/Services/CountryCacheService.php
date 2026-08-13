<?php


namespace App\Services;


use App\Models\Country;
use Illuminate\Support\Facades\Cache;

class CountryCacheService extends LocationCacheService
{
    protected $prefix = 'country_prime_time_';

    public function fils()
    {
        $key = $this->prefix . $this->location->id . '_fils';
        /*if (Cache::has($key)) {
            return Cache::get($key);
        } else {*/
            $fils = $this->location->locations()
                ->where('locations.parent_id', null)
                ->orderBy('name')
                ->get();
            //Cache::put($key, $fils, static::$expire);
            return $fils;
        //}
    }

    /**
     * @param $currentlangId
     * @return mixed
     */
    public function medias($currentlangId)
    {
        $key = $this->prefix . $this->location->id . '_medias';
        /*if (Cache::has($key)) {
            return Cache::get($key);
        } else {*/
            $medias = Country::join('countries_galleries as cg', 'cg.country_id', '=', 'countries.id')
                ->join('galleries as g', 'g.id', '=', 'cg.gallery_id')
                ->join('medias as m', 'm.gallery_id', '=', 'g.id')
                ->where('countries.id', $this->location->id)
                ->where('cg.language_id', $currentlangId)
                ->whereIn('g.user_id', [1, 2])
                ->select('g.is_slider as gslider', 'g.id as gid', 'g.name as gname', 'cg.language_id', 'm.*')
                ->orderBy('g.id')
                ->orderBy('rank')
                ->get();
            //Cache::put($key, $medias, static::$expire);
            return $medias;
        //}
    }

    /**
     * @return mixed
     */
    public function population()
    {
        $key = $this->prefix . $this->location->id . '_populations';
        /*if (Cache::has($key)) {
            return Cache::get($key);
        } else {*/
            $this->location->population = $this->location->population();
            Cache::put($key, $this->location->population, static::$expire);
            return $this->location->population;
        //}
    }

    public function callAll()
    {
        parent::callAll();
        $this->population();
    }

}