<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Models\LocationType;
use App\Models\Continent;
use App\Models\Language;
use App\Models\Activity;
use App\Models\Gallery;
use DB;

class Location extends BaseModel
{
    protected $table = 'locations';

    public function getChildren()
    {
        return false;
    }

    /** Liste des statuts disponibles */
    private static $statut = null;

    public function type()
    {
        return $this->belongsTo('App\Models\LocationType', 'type_id');
    }

    public function galleries()
    {
        return $this->belongsToMany("App\Models\Gallery", 'locations_galleries', 'location_id', 'gallery_id')->withPivot('language_id');
    }

    # TMP TEST
    public function medias()
    {
        return $this->hasManyThrough("App\Models\Media", 'App\Models\Gallery', 'id', 'gallery_id');
    }

    public function fils()
    {
        return $this->hasMany('App\Models\Location', 'parent_id');
    }

    public function pages()
    {
        return $this->belongsToMany("App\Models\Page", 'locations_pages', 'location_id', 'page_id');
    }

    public function head()
    {
        return $this->belongsTo('App\Models\Location', 'parent_id');
    }

    public function coordinate()
    {
        return $this->belongsTo('App\Models\Coordinate', 'coordinate_id');
    }

    public function languages()
    {
        return $this->belongsToMany('App\Models\Language', 'locations_languages', 'location_id', 'language_id');
    }

    public function contacts()
    {
        return $this->hasMany('App\Models\LocationContacts', 'location_id');
    }

    public function info()
    {
        return $this->coordinate->belongsTo('App\Models\Location', 'location_id');
    }

    public function country()
    {
        return $this->type->belongsTo('App\Models\Country', 'country_id');
    }

    public function mainCity()
    {
        return $this->whereIn('id', $this->getBottomId())
            ->whereNotNull('population')
            ->whereIn('locations.type_id', [3, 7, 12, 17])// Villes
            ->where('is_activated', true)
            ->orderBy('population', 'desc')
            ->orderBy('name')
            ->get();
    }

    public function mainDestination()
    {
        $location = Location::where('locations.parent_id', $this->id)
            ->where('locations.is_activated', true);

        if ($this->type->name == 'Région') {

            $location->whereIn('locations.type_id', [3, 7, 12, 17]); // Villes
        }

        return $location->join('locations as loc', 'loc.id', '=', 'locations.id')
            ->select('locations.name', 'locations.slug', DB::raw('sum(loc.population) as population'))
            ->groupBy('locations.id')
            ->orderBy('population', 'desc')
            ->take(4)
            ->get();

    }

    public function hasDetails()
    {
        $ok = $this->population > 0;
        $ok |= $this->description != null;
        $ok |= $this->latitude != null;
        $ok |= $this->longitude != null;
        $ok |= $this->superficie != null;
        $ok |= $this->fondation != null;
        $ok |= $this->gentile != null;
        $ok |= $this->description != null;
        $ok |= $this->drapeau != null;
        return $ok;
    }

    public static function biggestCity()
    {
        return Location::whereNotExists(function ($query) {
            $query->select(DB::raw(1))
                ->from('locations as l')
                ->whereRaw('l.parent_id = locations.id');
        })
            ->where('locations.is_activated', true)
            ->orderBy('locations.population', 'desc')
            ->orderBy('locations.name')
            ->select('locations.*')
            ->get();
    }

    public function activities()
    {
        /*return Activity::with(['companies', 'companies.coordinate'])
            ->join('activities_categories as ac', 'ac.id', '=', 'activities.category_id')
            ->join('companies_activities as ca', 'activities.id', '=', 'ca.activity_id')
            ->join('companies', 'companies.id', '=', 'ca.company_id')
            ->join('coordinates', 'coordinates.id', '=', 'companies.coordinate_id')
            ->whereIn('coordinates.location_id', $this->getSubId())
            ->select('activities.*', 'ac.type_id', 'ac.name as category_name')
            ->distinct()
            ->get();*/

        $activities = [];

        $prime_time_companies = $this->companies()->where('prime_time', 1)->get();

        foreach($prime_time_companies as $company) {
            $company_activities = $company->activities()->get();

            foreach($company_activities as $activity) {
                if (!in_array($activity->id, $activities)) {
                    $activities[] = $activity->id;
                }
            }
        }

        $activities = Activity::whereIn('activities.id', $activities)->join('activities_categories as ac', 'ac.id', '=', 'activities.category_id')->select('activities.*', 'ac.type_id', 'ac.name as category_name')->get();

        return $activities;
    }


    public function companies()
    {
        return $this->hasManyThrough('App\Models\Company', 'App\Models\Coordinate', 'location_id', 'coordinate_id');
    }

    /** Retourne les identifiants de toutes les sous branche */
    public function getSubId()
    {
        $data = array();
        array_push($data, $this->id);

        foreach ($this->fils as $location) {
            $data = $location->sub($data);
        }

        return $this->flatten($data);
    }

    private function sub(Array $data)
    {
        array_push($data, $this->id);

        foreach ($this->fils as $location) {
            $data = $location->sub($data);
        }

        return $data;

    }


    /**
     * Get Level 1
     */
    public function getTopHead()
    {
        $location = $this;
        while (($location->head) != null) {
            $location = $location->head;
        }
        return $location;
    }

    /** Retourne les identifiants de tous les éléments placés en bas de l'arbre */
    public function getBottomId()
    {
        $data = array();

        // On parcourt tous les fils
        foreach ($this->fils as $location) {
            $data = $location->bottom($data);
        }

        return $this->flatten($data);
    }

    private function bottom(Array $data)
    {
        if (count_of($this->fils) <= 0) {
            array_push($data, $this->id);
            return $data;
        }

        foreach ($this->fils as $location) {
            $data = $location->bottom($data);
        }

        return $data;

    }

    static function locationFromSlug($continent, $country, $slug)
    {
        // On récupère le premier élément en fonction du slug
        $location = Location::join('locations_types', 'locations_types.id', '=', 'locations.type_id')
            ->join('countries', 'countries.id', '=', 'locations_types.country_id')
            ->join('continents', 'continents.id', '=', 'countries.continent_id')
            ->where('locations.parent_id', null)
            ->where('countries.slug', $country)
            ->where('continents.code', $continent)
            ->where('locations.slug', $slug[0])
            ->select('locations.*')
            ->first();

        // Tant qu'on a pas fini de parcourir le slug
        $last = null;
        for ($i = 1; $i < count_of($slug) && $location != null; $i++) {
            $last = $location;

            // On cherche le fils correspondant
            $location = $location->fils()
                ->where('slug', $slug[$i])
                ->select('locations.*')
                ->first();
        }

        return $location == null ? $last : $location;
    }

    /** Recherche sur les infos d'un lieu */
    public static function search($countryCode, $name, $type, $parent, $isActivated)
    {
        return Location::join('locations_types', 'locations.type_id', '=', 'locations_types.id')
            ->join('countries', 'locations_types.country_id', '=', 'countries.id')
            ->leftJoin('locations as locate', 'locate.id', '=', 'locations.parent_id')
            ->leftJoin('locations_types as lt', 'lt.id', '=', 'locate.type_id')
            ->where('countries.code', '=', $countryCode)
            ->where(function ($query) use ($name, $type, $parent, $isActivated) {
                $query->where(function ($query) use ($name) {
                    // Recherche sur le champ du nom
                    if (!empty($name)) {
                        $query->whereRaw("LOWER(locations.name) LIKE ?", ['%' . strtolower($name) . '%']);
                    }
                })
                    ->where(function ($query) use ($type) {
                        // Recherche sur le champ du type
                        if (!empty($type)) {
                            $query->whereRaw("LOWER(locations_types.name) LIKE ?", ['%' . strtolower($type) . '%']);
                        }
                    })
                    ->where(function ($query) use ($isActivated) {
                        // Recherche sur le champ de l'is_activated
                        if (isset($isActivated) && is_numeric($isActivated) && $isActivated >= 0) {
                            $query->where('locations.is_activated', $isActivated > 0);
                        }
                    })
                    ->where(function ($query) use ($parent) {
                        // Recherche sur le champ du nom ou du type du parent
                        if (!empty($parent)) {
                            if (strtolower($parent) != 'aucun') {
                                $query->whereRaw("LOWER(locate.name) LIKE ?", ['%' . strtolower($parent) . '%'])
                                    ->orWhereRaw("LOWER(lt.name) LIKE ?", ['%' . strtolower($parent) . '%']);
                            } else {
                                $query->where("locate.name", null)
                                    ->orWhere("lt.name", null);
                            }
                        }
                    });
            })
            ->select('locations.*')
            ->orderBy('locations_types.level')
            ->orderBy('locations.name');
    }

    /** Retourne le slug complet pour un lieu à partir de son id */
    public static function createSlug(Location $location)
    {
        // On récupère le continent
        $slug = $location->country->continent->code;
        $slug .= '/';

        // On récupère le pays
        $slug .= $location->country->slug;
        $slug .= '/';

        // On récupère les slugs dans l'ordre inverse
        $parents = array();
        do {
            array_push($parents, $location->slug);
        } while (($location = $location->head) != null);

        // On inverse
        $parents = array_reverse($parents);

        // On génère la chaine
        foreach ($parents as $parent) {
            $slug .= $parent;
            $slug .= '/';
        }

        return $slug;
    }

    public function slugify()
    {
        $slugs = [];
        $country = $this->type->country;
        $continent = $country->continent;

        $parent = $this;
        do {
            array_push($slugs, (object)["key" => $parent->id, "value" => $parent->slug, "name" => $parent->name]);
            $parent = $parent->head;
        } while ($parent != null);

        array_push($slugs, (object)["key" => $country->id, "value" => $country->slug, "name" => $country->name]);
        array_push($slugs, (object)["key" => $continent->id, "value" => $continent->code, "name" => $continent->name]);

        $slugs = array_reverse($slugs);
        return $slugs;
    }


    /** Récupère la valeur affichable de l'is_activated */
    public function statut()
    {
        return Location::getStatut($this->is_activated ? 1 : 0);
    }

    /** Renvoie la liste statuts d'is_activated disponibles */
    public static function statuts()
    {
        self::$statut = array(
            1 => (object)['name' => "Affiché", 'action' => 'Masquer', 'txt' => 'affiché'],
            0 => (object)['name' => "Masqué", 'action' => 'Afficher', 'txt' => 'masqué']
        );
        return self::$statut;
    }

    /** Renvoie la visibilité opposée */
    public function opposite()
    {
        return Location::getStatut($this->is_activated ? 0 : 1);
    }

    /** Renvoi la visibilité en fonction de la valeur passé en argument */
    private static function getStatut($statut)
    {
        if (array_key_exists($statut, Location::statuts())) {
            return self::$statut [$statut];
        } else {
            return self::$statut [0];
        }
    }

    /** Renvoi une liste de statut */
    public static function statutsList()
    {
        $return = array();
        foreach (Location::statuts() as $key => $value) {
            $return[$key] = $value->name;
        }
        return $return;
    }

}
