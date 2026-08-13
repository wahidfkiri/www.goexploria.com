<?php

namespace App\Http\Controllers;

use App\Models\Continent;
use App\Models\Country;
use App\Models\Activity;
use App\Models\ActivityCategory;
use App\Models\ActivityType;
use App\Models\Company;

class FrontTemplateController extends Controller
{
	//QUERIES
    public function getContinents()
    {
        return Continent::select("code","name", "id")
                        ->orderBy('rank', 'desc')
                        ->orderBy('name')
                        ->get();
    }
    
    public function getCountriesByContinent($continent)
    {
    
        return Country::join('continents', 'continents.id', '=', 'countries.continent_id')
                 ->where('continent_id', $continent)
                 ->where('is_activated', true)
                 ->select("countries.code", "countries.slug","countries.name", "countries.id", "continents.code as continent")
                 ->orderBy('countries.rank', 'desc')
                 ->orderBy('countries.name')
                 ->get();
    }

    /** Liste des catégories d'activités touristiques */
    public function getTourismActivitiesCategories()
    {
        return ActivityCategory::where('type_id', 1)
                        ->select("name", "id", 'slug')
                        ->orderBy('name')
                        ->get();
    }

    /** Liste des activités touristiques */
    public function getTourismActivities($category)
    {
        return Activity::join('activities_categories', 'activities_categories.id', '=', 'activities.category_id')
                        ->where('activities_categories.type_id', 1)
                        ->where('activities_categories.slug', $category)
                        ->select("activities.name", "activities.id")
                        ->orderBy('name')
                        ->get();
    }
    
    /**
     * Get country rows by activity without duplicate rows
     * 
     * @param int $activity Activity id
     * @return array Array of objects
     */
    public function getCoutriesByActivity($activity) {
        return Company::join('coordinates', 'coordinates.id', '=', 'companies.coordinate_id')
                        ->join('locations', 'locations.id', '=', 'coordinates.location_id')
                        ->join('locations_types', 'locations.type_id', '=', 'locations_types.id')
                        ->join('countries', 'locations_types.country_id', '=', 'countries.id')
                        ->join('companies_activities', 'companies_activities.company_id', '=', 'companies.id')
                        ->select('countries.*')
                        ->orderBy('countries.name')
                        ->where('companies_activities.activity_id','=',$activity)
                        ->distinct()
                        ->get();
    }
    
    /** Liste des catégories d'activités économiques */
    public function getBusinessActivitiesCategories()
    {
        return ActivityCategory::where('type_id', 2)
                        ->select("name", "id", 'slug')
                        ->orderBy('name')
                        ->get();
    }

    /** Liste des activités économiques */
    public function getBusinessActivities($category)
    {
        return Activity::join('activities_categories', 'activities_categories.id', '=', 'activities.category_id')
                        ->where('activities_categories.type_id', 2)
                        ->where('activities_categories.slug', $category)
                        ->select("activities.name", "activities.id")
                        ->orderBy('name')
                        ->get();
    }

}
