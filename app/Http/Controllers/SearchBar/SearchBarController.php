<?php
namespace App\Http\Controllers\SearchBar;

use App\Http\Controllers\Controller;

use App\Models\Location;
use App\Models\Country;
use App\Models\Continent;
use App\Models\Company;


use App\Http\Controllers\SearchBar\Filler;
use App\Http\Controllers\SearchBar\LocationModel;
use App\Http\Controllers\SearchBar\CountryModel;
use App\Http\Controllers\SearchBar\ContinentModel;
use App\Http\Controllers\SearchBar\CompanyModel;

class SearchBarController extends Controller
{
    /** Recherche sur l'ensemble des données du site */
    public function find($name) {
        $data = array();

        // On ajoute les valeurs sources
        $data = $this->searchContinents($data, $name);
        $data = $this->searchCountries($data, $name);
        $data = $this->searchLocations($data, $name);
        $data = $this->searchCompanies($data, $name);

        // On génère le JSON
        $filler = new Filler();
        $filler->fill($data);
        return $filler->getJSONData();           
    }

    /** Recherche d'un lieu sur le site en fonction de son pays */
    public function findLocationByCountry($countryCode, $name) {
        $data = array();

        // On ajoute les valeurs sources
        $data = $this->searchLocationsByCountry($data, $name, $countryCode);

        // On génère le JSON
        $filler = new Filler();
        $filler->fill($data);
        return $filler->getJSONData();           
    }

    /** Recherche d'un lieu sur le site */
    public function findLocation($name) {
        $data = array();

        // On ajoute les valeurs sources
        $data = $this->searchLocations($data, $name);

        // On génère le JSON
        $filler = new Filler();
        $filler->fill($data);
        return $filler->getJSONData();           
    }

    /** Recherche d'une entreprise sur le site */
    public function findCompany($name) {
        $data = array();

        // On ajoute les valeurs sources
        $data = $this->searchCompanies($data, $name);

        // On génère le JSON
        $filler = new Filler();
        $filler->fill($data);
        return $filler->getJSONData();           
    }

    public function findLocationChildrens($location, $name) {
        $data = array();

        // On ajoute les valeurs sources
        $data = $this->searchLocationsChildrens($data, $name, $location);

        // On génère le JSON
        $filler = new Filler();
        $filler->fill($data);
        return $filler->getJSONData();   
    }

    /** Recherche sur les pays */
    private function searchCountries($data, $name) {
        $countries = Country::whereRaw('LOWER(name) LIKE ?', ['%'.strtolower($name).'%'])
                        ->orderBy('rank')
                        ->orderBy('name')
                        ->select('name', 'id')
                        ->get();

        foreach ($countries as $country) {
            array_push($data, new CountryModel($country));
        }

        return $data;
    }

    /** Recherche sur les entreprises */
    private function searchCompanies($data, $name) {
        $items = Company::join('coordinates as coord', 'coord.id', '=', 'companies.coordinate_id')
                        ->join ( 'locations as l', 'l.id', '=', 'coord.location_id' )
                        ->join ( 'locations_types as lt', 'l.type_id', '=', 'lt.id' )
                        ->join ( 'countries as c', 'lt.country_id', '=', 'c.id' )
                        ->whereRaw('LOWER(companies.name) LIKE ? AND (companies.is_deactivated IS NULL OR companies.is_deactivated = 0)', ['%'.strtolower($name).'%'])
                        ->orderBy('companies.name')
                        ->select('companies.name', 'companies.id', 'l.name as location', 'c.name as country')
                        ->get();

        foreach ($items as $item) {
            array_push($data, new CompanyModel($item));
        }

        return $data;
    }
    
    /** Recherche sur les continents */
    private function searchContinents($data, $name) {
        $continents = Continent::whereRaw('LOWER(name) LIKE ?', ['%'.strtolower($name).'%'])
                        ->orderBy('rank')
                        ->orderBy('name')
                        ->select('name', 'id')
                        ->get();

        foreach ($continents as $continent) {
            array_push($data, new ContinentModel($continent));
        }
        return $data;
    }

    /** On recherche sur les lieux */
    private function searchLocations($data, $name) {
        $locations = Location::join ( 'locations_types as lt', 'locations.type_id', '=', 'lt.id' )
                        ->leftJoin ( 'locations as l', 'locations.parent_id', '=', 'l.id' )
                        ->join ( 'countries as c', 'lt.country_id', '=', 'c.id' )
                        ->where('c.is_activated', true)
                        ->where('locations.is_activated', true)
                        ->whereRaw('LOWER(locations.name) LIKE ?', ['%'.strtolower($name).'%'])
                        ->orderBy('c.rank')
                        ->orderBy('c.name')
                        ->orderBy('lt.level')
                        ->orderBy('locations.name')
                        ->select('locations.id', 'c.name as pays', 'lt.name as type', 'locations.name as lieu', 'l.name as parent')
                        ->get();

        foreach ($locations as $location) {
            array_push($data, new LocationModel($location));
        }
        
        return $data;
    }

        /** On recherche sur les lieux pour un pays donné */
    private function searchLocationsByCountry($data, $name, $countryCode) {
        $locations = Location::join ( 'locations_types as lt', 'locations.type_id', '=', 'lt.id' )
                        ->leftJoin ( 'locations as l', 'locations.parent_id', '=', 'l.id' )
                        ->join ( 'countries as c', 'lt.country_id', '=', 'c.id' )
                        ->where('c.is_activated', true)
                        ->where('c.code', $countryCode)
                        ->whereRaw('LOWER(locations.name) LIKE ?', ['%'.strtolower($name).'%'])
                        ->orderBy('c.rank')
                        ->orderBy('c.name')
                        ->orderBy('lt.level')
                        ->orderBy('locations.name')
                        ->select('locations.id', 'c.name as pays', 'lt.name as type', 'locations.name as lieu', 'l.name as parent')
                        ->get();

        foreach ($locations as $location) {
            array_push($data, new LocationModel($location));
        }
        return $data;
    }

    /** On recherche sur les lieux fils d'un lieu donné*/
    private function searchLocationsChildrens($data, $name, $baseId) {
        $base = Location::find($baseId);

        $locations = Location::join ( 'locations_types as lt', 'locations.type_id', '=', 'lt.id' )
                        ->leftJoin ( 'locations as l', 'locations.parent_id', '=', 'l.id' )
                        ->join ( 'countries as c', 'lt.country_id', '=', 'c.id' )
                        ->where('c.is_activated', true)
                        ->whereIn('l.id', $base->getSubId())
                        ->whereRaw('LOWER(locations.name) LIKE ?', ['%'.strtolower($name).'%'])
                        ->orderBy('c.rank', 'desc')
                        ->orderBy('c.name')
                        ->orderBy('lt.level')
                        ->orderBy('locations.name')
                        ->select('locations.id', 'c.name as pays', 'lt.name as type', 'locations.name as lieu', 'l.name as parent')
                        ->get();

        foreach ($locations as $location) {
            array_push($data, new LocationModel($location));
        }
        return $data;
    }

}