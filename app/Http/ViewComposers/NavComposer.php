<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;

use App\Models\Continent;
use App\Models\Country;
use App\Models\ActivityCategory;
use App\Models\Activity;
use App\Models\Company;
use Illuminate\Support\Facades\Cache;

class NavComposer
{

    protected $continents,
        $countries,
        $tourismCategories,
        $tourismActivities,
        $tourismActivityCountries,
        $businessCategories,
        $businessActivities,
        $businessActivityCountries,
        $localCategories,
        $localActivities,
        $localActivityCountries,
        $primeCategories,
        $primeActivities,
        $primeActivityCountries,
        $videosCategories,
        $videosActivities,
        $videosActivityCountries,
        $photosCategories,
        $photosActivities,
        $photosActivityCountries,
        $forfaitsCategories,
        $forfaitsActivities,
        $forfaitsActivityCountries,
        $produitsCategories,
        $produitsActivities,
        $produitsActivityCountries,
        $plusCategories,
        $plusActivities,
        $plusActivityCountries;


    /**
     * Create a new profile composer.
     *
     * @param UserRepository $users
     * @return void
     */
    public function __construct()
    {

        $this->tourismCategories = $this->_getTourismeCategories();
        $this->tourismActivities = [];
        $this->tourismActivityCountries = [];

        foreach ($this->tourismCategories as $category) {
            $activities = $this->_getTourismActivities($category->slug);
            $this->tourismActivities[$category->slug] = $activities;
            /**
             * foreach ($activities as $activity) {
             * $this->tourismActivityCountries[$activity->id] = $this->_getCountriesByActivity($activity->id);
             * }
             **/
        }

        $this->businessCategories = $this->_getBusinessCategories();
        $this->businessActivities = [];
        $this->businessActivityCountries = [];

        foreach ($this->businessCategories as $category) {
            $businesses = $this->_getBusinessActivities($category->slug);
            $this->businessActivities[$category->slug] = $businesses;
        }

        $this->localCategories = $this->_getSpecificCategories(3);
        $this->localActivities = [];
        $this->localActivityCountries = [];

        foreach ($this->localCategories as $category) {
            $locales = $this->_getSpecificActivities($category->slug, 3);
            $this->localActivities[$category->slug] = $locales;
        }

        $this->primeCategories = $this->_getSpecificCategories(4);
        $this->primeActivities = [];
        $this->primeActivityCountries = [];

        foreach ($this->primeCategories as $category) {
            $primees = $this->_getSpecificActivities($category->slug, 4);
            $this->primeActivities[$category->slug] = $primees;
        }

        $this->videosCategories = $this->_getSpecificCategories(5);
        $this->videosActivities = [];
        $this->videosActivityCountries = [];

        foreach ($this->videosCategories as $category) {
            $videoses = $this->_getSpecificActivities($category->slug, 5);
            $this->videosActivities[$category->slug] = $videoses;
        }

        $this->photosCategories = $this->_getSpecificCategories(6);
        $this->photosActivities = [];
        $this->photosActivityCountries = [];

        foreach ($this->photosCategories as $category) {
            $photoses = $this->_getSpecificActivities($category->slug, 6);
            $this->photosActivities[$category->slug] = $photoses;
        }

        $this->forfaitsCategories = $this->_getSpecificCategories(7);
        $this->forfaitsActivities = [];
        $this->forfaitsActivityCountries = [];

        foreach ($this->forfaitsCategories as $category) {
            $forfaitses = $this->_getSpecificActivities($category->slug, 7);
            $this->forfaitsActivities[$category->slug] = $forfaitses;
        }

        $this->produitsCategories = $this->_getSpecificCategories(8);
        $this->produitsActivities = [];
        $this->produitsActivityCountries = [];

        foreach ($this->produitsCategories as $category) {
            $produitses = $this->_getSpecificActivities($category->slug, 8);
            $this->produitsActivities[$category->slug] = $produitses;
        }

        $this->plusCategories = $this->_getSpecificCategories(9);
        $this->plusActivities = [];
        $this->plusActivityCountries = [];

        foreach ($this->plusCategories as $category) {
            $pluses = $this->_getSpecificActivities($category->slug, 9);
            $this->plusActivities[$category->slug] = $pluses;
        }
    }

    /**
     * Return tourism categories
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function _getTourismeCategories()
    {
        return ActivityCategory::where('type_id', 1)
            ->select("name", "id", 'slug')
            ->orderBy('name')
            ->get();
    }

    /**
     * Return business categories
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function _getBusinessCategories()
    {
        return ActivityCategory::where('type_id', 2)
            ->select("name", "id", 'slug')
            ->orderBy('name')
            ->get();
    }

    /**
     * Return specific categories
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function _getSpecificCategories($type)
    {
        return ActivityCategory::where('type_id', $type)
            ->select("name", "id", 'slug')
            ->orderBy('name')
            ->get();
    }

    /**
     * Get Activities by Categories
     *
     * @param string $category Category slug
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function _getTourismActivities($category)
    {
        $key = 'tourism_activities_' . $category;

        if (Cache::has($key)) {
            return Cache::get($key);
        } else {
            $activities = Activity::join('activities_categories', 'activities_categories.id', '=', 'activities.category_id')
                ->where('activities_categories.type_id', 1)
                ->where('activities_categories.slug', $category)
                ->select("activities.name", "activities.id", "activities.slug")
                ->orderBy('name')
                ->get();
            Cache::put($key, $activities, 240);
            return $activities;
        }

    }

    /**
     * Get Activities by Categories
     *
     * @param string $category Category slug
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function _getBusinessActivities($category)
    {
        $key = 'tourism_activities_' . $category;

        if (Cache::has($key)) {
            return Cache::get($key);
        } else {
            $activities = Activity::join('activities_categories', 'activities_categories.id', '=', 'activities.category_id')
                ->where('activities_categories.type_id', 2)
                ->where('activities_categories.slug', $category)
                ->select("activities.name", "activities.id", "activities.slug")
                ->orderBy('name')
                ->get();
            Cache::put($key, $activities, 240);
            return $activities;
        }

    }

    /**
     * Get Activities by Categories
     *
     * @param string $category Category slug
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function _getSpecificActivities($category, $type)
    {
        $key = 'tourism_activities_' . $category;

        if (Cache::has($key)) {
            return Cache::get($key);
        } else {
            $activities = Activity::join('activities_categories', 'activities_categories.id', '=', 'activities.category_id')
                ->where('activities_categories.type_id', $type)
                ->where('activities_categories.slug', $category)
                ->select("activities.name", "activities.id", "activities.slug")
                ->orderBy('name')
                ->get();
            Cache::put($key, $activities, 240);
            return $activities;
        }

    }

    /**
     * Get country rows by activity without duplicate rows
     *
     * @param int $activity Activity id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function _getCountriesByActivity($activity)
    {
        return Company::join('coordinates', 'coordinates.id', '=', 'companies.coordinate_id')
            ->join('locations', 'locations.id', '=', 'coordinates.location_id')
            ->join('locations_types', 'locations.type_id', '=', 'locations_types.id')
            ->join('countries', 'locations_types.country_id', '=', 'countries.id')
            ->join('companies_activities', 'companies_activities.company_id', '=', 'companies.id')
            ->select('countries.*')
            ->orderBy('countries.name')
            ->where('companies_activities.activity_id', '=', $activity)
            ->distinct()
            ->get();
    }


    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with([
            #'continents' => $this->continents,
            # 'countries' => $this->countries,
            'tourismeCategories' => $this->tourismCategories,
            'tourismeActivities' => $this->tourismActivities,
            'businessCategories' => $this->businessCategories,
            'businessActivities' => $this->businessActivities,
            'localCategories' => $this->localCategories,
            'localActivities' => $this->localActivities,
            'primeCategories' => $this->primeCategories,
            'primeActivities' => $this->primeActivities,
            'videosCategories' => $this->videosCategories,
            'videosActivities' => $this->videosActivities,
            'photosCategories' => $this->photosCategories,
            'photosActivities' => $this->photosActivities,
            'forfaitsCategories' => $this->forfaitsCategories,
            'forfaitsActivities' => $this->forfaitsActivities,
            'produitsCategories' => $this->produitsCategories,
            'produitsActivities' => $this->produitsActivities,
            'plusCategories' => $this->plusCategories,
            'plusActivities' => $this->plusActivities,
            # 'tourismActivityCountries'=>$this->tourismActivityCountries
        ]);
    }

    private function getTourismCategories()
    {
        if (session()->has('tourismCategories')) {
            return session('tourismCategories');
        }
        return false;
    }

    private function getTourismActivities()
    {
        if (session()->has('tourismActivities')) {
            return session('tourismActivities');
        }
        return false;
    }
}
