<?php


namespace App\Services;

use App\Models\Location;
use Illuminate\Support\Facades\Cache;

class LocationCacheService
{
    static $expire = 10;
    protected $location;
    protected $prefix = 'location_prime_time_';

    public function __construct($location)
    {
        $this->location = $location;
    }

    /**
     * @return mixed
     */
    public function fils()
    {
        $key = $this->prefix . $this->location->id . '_fils';
        /*if (Cache::has($key)) {
            return Cache::get($key);
        } else {*/
            $fils = $this->location->fils()->where('is_activated', true)->orderBy('name')->get();
            //Cache::put($key, $fils, static::$expire);
            return $fils;
        //}
    }

    public function coordinate()
    {
        $key = $this->prefix . $this->location->id . '_coordinate';
        /*if (Cache::has($key)) {
            return Cache::get($key);
        } else {*/
            $coordinate = $this->location->coordinate;
            //Cache::put($key, $coordinate, static::$expire);
            return $coordinate;
        //}
    }

    public function activities()
    {
        $key = $this->prefix . $this->location->id . '_activities';
        /*if (Cache::has($key)) {
            return Cache::get($key);
        } else {*/
            $activities = $this->location->activities();
            //Cache::put($key, $activities, static::$expire);
            return $activities;
        //}
    }

    /*public function activityCompanies()
    {
        $key = $this->prefix . $this->location->id . '_activity_companies';
        if (Cache::has($key)) {
            return Cache::get($key);
        } else {
            $companies = [];
            $activities = $this->activities();
            foreach ($activities->where('type_id', 1)->sortBy('category_name')->all() as $activity) {
                foreach ($activity->companies()->where('prime_time', 1)->locationId($this->location->id)->get() as $company) {
                    $companyInfo = [
                        'activityName' => $activity->name,
                        'activityCategoryName' => $activity->category_name,
                        'countryName' => $company->location->country->name,
                        'locationName' => $company->location ? $company->location->name : '',
                        'locationSlug' => Location::createSlug($company->location),
                        'locationHeadName' => $company->location->head ? $company->location->head->name : '',
                        'website' => $company->coordinate->website,
                        'companyName' => $company->name
                    ];
                    $companies[$activity->id][] = $companyInfo;
                }
            }
            Cache::put($key, $companies, static::$expire);
            return $companies;
        }
    }*/

    public function mainCity()
    {
        $key = $this->prefix . $this->location->id . '_mainCity';
        /*if (Cache::has($key)) {
            return Cache::get($key);
        } else {*/
            $mainCity = $this->location->mainCity();
            //Cache::put($key, $mainCity, static::$expire);
            return $mainCity;
        //}
    }

    public function pages()
    {
        $key = $this->prefix . $this->location->id . '_pages';
       /*if (Cache::has($key)) {
            return Cache::get($key);
        } else {*/
            $pages = $this->location->pages()->where('is_visible', 1)->orderBy('rank', 'desc')->orderBy('name')->get();
            //Cache::put($key, $pages, static::$expire);
            return $pages;
        //}
    }

    public function mainDestination()
    {
        $key = $this->prefix . $this->location->id . '_mainDestination';
        /*if (Cache::has($key)) {
            return Cache::get($key);
        } else {*/
            $mainDestination = $this->location->mainDestination();
            Cache::put($key, $mainDestination, static::$expire);
            return $mainDestination;
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
            $medias = Location::where('lg.location_id', $this->location->id)
                ->join('locations_galleries as lg', 'lg.location_id', '=', 'locations.id')
                ->join('galleries as g', 'g.id', '=', 'lg.gallery_id')
                ->join('medias as m', 'm.gallery_id', '=', 'g.id')
                ->whereIn('g.user_id', [1, 2])
                ->where('lg.language_id', $currentlangId)
                ->select('g.is_slider as gslider', 'g.id as gid', 'g.name as gname', 'lg.language_id', 'm.*')
                ->orderBy('g.id')
                ->orderBy('rank')
                ->get();
            Cache::put($key, $medias, static::$expire);
            return $medias;
        //}
    }

    public function callAll()
    {
        $this->fils();
        $this->coordinate();
        $this->activities();
        // activityCompanies() est commentée plus haut : l'appeler provoquait un
        // fatal « Call to undefined method » dans la commande location:cache.
        // $this->activityCompanies();
        $this->mainCity();
        $this->pages();
        $this->mainDestination();

    }
}