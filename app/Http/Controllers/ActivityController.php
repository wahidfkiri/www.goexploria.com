<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Language;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Models\Activity;

class ActivityController extends Controller
{
    public function getPubSlider() {

        $currentlangId='';
        if(session()->has('locale')){
            $currentlangId = Language::getLangIdByLocale(session()->get('locale'));
        }

        $pubs_slider = Gallery::leftjoin('locations_galleries as lg', 'lg.gallery_id', '=', 'galleries.id')
            ->leftjoin('locations as l', 'l.id', '=', 'lg.location_id')
            ->leftjoin('countries_galleries as cg', 'cg.gallery_id', '=', 'galleries.id')
            ->leftjoin('countries as c', 'c.id', '=', 'cg.country_id')
            ->leftjoin('companies_galleries as eg', 'eg.gallery_id', '=', 'galleries.id')
            ->leftjoin('companies as e', 'e.id', '=', 'eg.company_id')
            ->where(function ($q) use ($currentlangId) {
                $q->where('lg.language_id', $currentlangId)->where('l.is_activated', 1)
                    ->orWhere('cg.language_id', $currentlangId)->where('c.is_activated', 1)
                    ->orWhere('eg.language_id', $currentlangId);
            })
            ->WhereNotNull('galleries.is_pubslider_list')
            ->whereIn('user_id', [1,2]) // ADMINs
            ->select('galleries.slug', 'galleries.id', 'galleries.name', 'l.name as lname', 'c.name as cname', 'e.name as ename')
            ->take('50')
            ->orderBy('galleries.is_pubslider_list')
            ->with('medias')
            ->get();

        return $pubs_slider;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return view('front.activity', 
    }

    public function search($id, $slug)
    {
        $activity = Activity::find($id);

        $activity_countries = [];
        $companies = $activity->companies()->whereRaw('(is_deactivated IS NULL OR is_deactivated = 0)')->paginate(10);
        foreach ($companies as $company) {
            $activity_countries[$company->location->country->code] = $company->location->country;

            //<option value="{{ $company->location->country->id }}">{{ $company->location->country->name }}</option>
        }


        $pubs_slider = $this->getPubSlider();

        return view('front.activity.search', compact('activity', 'activity_countries', 'companies', 'pubs_slider'));
    }

    /**
     * Get "Level 1" position
     * @param type $country
     * @param type $activity
     * @todo Not implemented yet
     */
    private function _getLevel1ByCountryActivity($activity, $country)
    {

        /* Get location */
        $locations = Location::join('coordinates', 'locations.id', '=', 'coordinates.location_id')
            ->join('companies', 'coordinates.id', '=', 'companies.coordinate_id')
            ->join('locations_types', 'locations.type_id', '=', 'locations_types.id')
            ->join('countries', 'locations_types.country_id', '=', 'countries.id')
            ->join('companies_activities', 'companies_activities.company_id', '=', 'companies.id')
            ->select('locations.*')
            ->where('companies_activities.activity_id', '=', $activity)
            ->where('countries.id', '=', $country)
            ->distinct();

//               return $locations->getTopHead();

        $headLocation = [];
//        $locations->getTopHead();
        foreach ($locations->get() as $location) {
            /* @var  $location Location */
            array_push($headLocation, $location->getTopHead());
        }
        return $headLocation;
    }


    /**
     * Determine if location has specified activity
     * @param type $location
     * @return type
     */
    private function _hasActivity($location, $activity)
    {
        $r = \App\Models\Company::join('coordinates', 'companies.coordinate_id', '='
            , 'coordinates.id')
            ->join('locations', 'locations.id', '=', 'coordinates.location_id')
            ->join('companies_activities', 'companies_activities.company_id', '=', 'companies.id')
            ->where('locations.id', '=', $location)
            ->where('companies_activities.activity_id', '=', $activity)
            ->get();
        return (!$r->isEmpty());
    }


    private function _getSubLevelByLocationActivity($location, $activity)
    {
        $locationObj = Location::find($location);
        $r = array();
        foreach ($locationObj->fils as $fils) {
            if ($this->_hasActivity($fils->id, $activity)) {
                array_push($r, $fils);
            }
        }
        return $r;
    }


    private function _getActivitiesByLocation($location, $activity)
    {

    }


    private function _getCompagniesByLocationActivity($location, $activity)
    {

        $locationsId = array_merge(Location::find($location)->getBottomId(), [$location]);

        $results = \App\Models\Company::join('coordinates', 'companies.coordinate_id', '='
            , 'coordinates.id')
            ->join('locations', 'locations.id', '=', 'coordinates.location_id')
            ->join('companies_activities', 'companies_activities.company_id', '=', 'companies.id')
            ->wherein('locations.id', $locationsId)
            ->where('companies_activities.activity_id', '=', $activity)
            ->where(function($query) {
                $query->where('companies.is_deactivated IS NULL')->orWhere('companies.is_deactivated = 0');
            })
            ->select('companies.*')
            ->with('coordinate')
            ->get();

        //dd($results);

        return $results;

    }

    /**
     * Return view
     */
    public function getFromCountryAndActivity($activity, $country, $location = null)
    {
        $dataCountry = \App\Models\Country::find($country);
        $locationObj = !empty($location) ? Location::find($location) : $dataCountry;
        $activityObj = \App\Models\Activity::find($activity);
        $provinces = $this->_getLevel1ByCountryActivity($activity, $country);
        $compagnies = $this->_getCompagniesByLocationActivity(empty($location) ?
            $country : $location, $activity);
        return view('front.activity.details', [
            'activity' => $activityObj
            , 'country' => $dataCountry
            , 'location' => empty($location) ? $dataCountry : $locationObj
            , 'hierarchie' => $location === null ? $dataCountry->slugify() : $locationObj->slugify()
            , 'compagnies' => $compagnies
            , 'provinces' => $location === null ? $provinces : $this->_getSubLevelByLocationActivity($location, $activity)
            , 'pubs_slider' => $this->getPubSlider()
        ]);
    }

    public function ajaxSearch(Request $request, $activity, $location)
    {
        $activityObj = Activity::find($activity);
        $short = $request->get('short', false);
        $columns = ['*'];
        if (!empty($short)) {
            $columns = ['id', 'name', 'slug', 'coordinate_id'];
        }
        if (!$activityObj) {
            return response()->json(['success' => false], 204);
        }
        $activities = $activityObj->companies()
            ->with('coordinate')
            ->locationId($location)
            ->paginate($request->get('limit', 10), $columns);

        return response()->json($activities);

    }

}
