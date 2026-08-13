<?php

namespace App\Models;

use App\Models\BaseModel;


class Company extends BaseModel
{
    protected $table = 'companies';

    public function coordinate()
    {
        return $this->belongsTo('App\Models\Coordinate', 'coordinate_id');
    }

    public function comments()
    {
        return $this->hasMany('App\Models\CompanyComment', 'company_id');
    }

    public function meetings()
    {
        return $this->hasMany('App\Models\CompanyMeeting', 'company_id');
    }

    public function contacts()
    {
        return $this->hasMany('App\Models\CompanyContact', 'companies_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'companies_users');
    }

    public function activitiesDetails()
    {
        return Activity::join('activities_categories as ac', 'ac.id', '=', 'activities.category_id')
            ->join('companies_activities as ca', 'activities.id', '=', 'ca.activity_id')
            ->where('ca.company_id', $this->id)
            ->select('activities.*', 'ac.type_id', 'ac.name as category_name')
            ->get();
    }

    public function activities()
    {
        return $this->belongsToMany("App\Models\Activity", 'companies_activities', 'company_id', 'activity_id');
    }

    public function galleries()
    {
        return $this->belongsToMany("App\Models\Gallery", 'companies_galleries', 'company_id', 'gallery_id')->withPivot('language_id');
    }

    public function followers()
    {
        return $this->hasMany("App\Models\CompanyFollower", 'company_id');
    }

    public function pages()
    {
        return $this->belongsToMany("App\Models\Page", 'companies_pages', 'company_id', 'page_id');
    }

    public function site()
    {
        return $this->hasMany('App\Models\Site', 'company_id');
    }

    public function socialNetworks()
    {
        return $this->hasOne('App\Models\SocialNetworks', 'company_id', 'id');
    }

    public function addExternalSite($domain)
    {

        $found = $this->site()
            ->where('value', $domain)
            ->first();
        if ($found) return false;

        $site = new Site;
        $site->company_id = $this->id;
        $site->config = "domain";
        $site->value = $domain;
        return $site->save();
    }


    public function getExternalDomains()
    {
        return $this
            ->site()
            ->where('config', 'domain')
            ->get()
            ->all();
    }

    public function delExternalSite($domain)
    {
        return $this->site()
            ->where('value', $domain)
            ->delete();
    }

    public function add_rm_fileCss($file, $action, &$error)
    {
        if (!$action == "add" && !$action == "remove") {
            $error = "action not supported";
            return false;
        }
        if ($action == "add") {
            $found = $this->site()
                ->where('config', "fichier_css")
                ->first();

            if ($found) {
                $found->value = $file;
                return $found->save();

            } else {
                $site = new Site;
                $site->company_id = $this->id;
                $site->config = "fichier_css";
                $site->value = $file;
                return $site->save();
            }

        } else if ($action == "remove") {
            return $this->site()
                ->where('config', "fichier_css")
                ->delete();
        }

    }

    public function setSiteTheme($theme_name)
    {
        $site = $this->site()
            ->where('config', "theme")
            ->first();
        if ($site) {
            $this->site()
                ->where('config', "theme")
                ->delete();
        }

        $site = new Site;
        $site->company_id = $this->id;
        $site->config = "theme";
        $site->value = $theme_name;
        return $site->save();

    }

    public function getSiteTheme()
    {
        $site = $this->site()
            ->where('config', "theme")
            ->first();
        if (!$site) {
            return "theme1";
        }
        return $site->value;
    }


    public function location()
    {
        return $this->coordinate->belongsTo('App\Models\Location', 'location_id');
    }

    /** Recherche sur les infos d'une entreprise */
    public static function search($name, $country, $location, $activities, $mail, $tel)
    {
        return Company::join('coordinates', 'coordinates.id', '=', 'companies.coordinate_id')
            ->join('locations', 'locations.id', '=', 'coordinates.location_id')
            ->join('locations_types', 'locations.type_id', '=', 'locations_types.id')
            ->join('countries', 'locations_types.country_id', '=', 'countries.id')
            ->leftJoin('companies_activities', 'companies_activities.company_id', '=', 'companies.id')// Left join since it's possible a company don't have any activity
            ->leftJoin('activities', 'activities.id', '=', 'companies_activities.activity_id')// Left join since it's possible a company don't have any activity
            ->where(function ($query) use ($name, $country, $location, $activities, $mail, $tel) {
                $query->where(function ($query) use ($name) {
                    // Recherche sur le champ du nom
                    if (!empty($name)) {
                        $query->whereRaw("LOWER(companies.name) LIKE ?", ['%' . strtolower($name) . '%']);
                    }
                })
                    ->where(function ($query) use ($country) {
                        // Recherche sur le champ du type
                        if (!empty($country)) {
                            $query->whereRaw("LOWER(countries.name) LIKE ?", ['%' . strtolower($country) . '%']);
                        }
                    })
                    ->where(function ($query) use ($location) {
                        // Recherche sur le champ du type
                        if (!empty($location)) {
                            $query->whereRaw("LOWER(locations.name) LIKE ?", ['%' . strtolower($location) . '%']);
                        }
                    })
                    ->where(function ($query) use ($activities) {
                        // Recherche sur le champ des activités
                        if (!empty($activities)) {
                            $query->whereRaw("LOWER(activities.name) LIKE ?", ['%' . strtolower($activities) . '%']);
                        }
                    })
                    ->where(function ($query) use ($mail) {
                        // Recherche sur le champ du type
                        if (!empty($mail)) {
                            if (strtolower($mail) != 'aucun') {
                                $query->whereRaw("LOWER(coordinates.mail) LIKE ?", ['%' . strtolower($mail) . '%']);
                            } else {
                                $query->where("coordinates.mail", null);
                            }
                        }
                    })
                    ->where(function ($query) use ($tel) {
                        // Recherche sur le champ du nom ou du type du parent
                        if (!empty($tel)) {
                            if (strtolower($tel) != 'aucun') {
                                $query->whereRaw("LOWER(coordinates.tel) LIKE ?", ['%' . strtolower($tel) . '%']);
                            } else {
                                $query->where("coordinates.tel", null);
                            }
                        }
                    });
            })
            ->select('companies.*')
            ->distinct()
            ->orderBy('countries.name')
            ->orderBy('companies.name');
    }

    public function slugify()
    {
        $slugs = [];

        array_push($slugs, (object)["key" => $this->id, "value" => $this->slug, "name" => $this->name]);

        return $slugs;

    }

    public static function getFromSlug($slug)
    {
        $slug = explode('/', $slug);

        if (!$company = Company::find($slug[0])) {
            $company = Company::where('slug', $slug[0])->first();
        }
        return $company;
    }

    public function isActivated()
    {
        $company = Company::where('is_deactivated', true)
            ->where('id', $this->id)
            ->first();

        if ($company) {
            return false;
        }
        return true;
    }

    public static function getFromDomain($domain)
    {

        $company = Company::join('sites as s', 's.company_id', '=', 'companies.id')
            ->where('config', 'domain')
            ->where('value', $domain)
            ->first();

        if ($company && !$company->isActivated()) {
            dd('Site web désactivé. / Website is disabled.');
        }

        return $company;
    }

    public function getLogoFilename($type = "logo")
    {

        $file = $this->slug;

        if ($type == 'headImage') {
            $file = $file . '_headImage';
        }

        if ($type == 'footerImage') {
            $file = $file . '_footerImage';
        }

        $logo = '';
        if (file_exists(public_path('uploads/companies/' . $this->id . '/' . $file . '.jpg'))) {
            $logo = $file . '.jpg';
        } else if (file_exists(public_path('uploads/companies/' . $this->id . '/' . $file . '.png'))) {
            $logo = $file . '.png';
        }

        return $logo;
    }

    public function getListImageFilename()
    {

        $file = $this->slug;

        $logo = '';
        if (file_exists(public_path('uploads/list_images/' . $this->id . '/' . $file . '.jpg'))) {
            $logo = $file . '.jpg';
        } else if (file_exists(public_path('uploads/list_images/' . $this->id . '/' . $file . '.png'))) {
            $logo = $file . '.png';
        }

        return $logo;
    }
    
    public function scopeLocationId($query, $locationId)
    {
        return $query->whereHas('coordinate.location', function ($q) use ($locationId) {
            $q->where('id', $locationId);
        });
    }

    public function scopeTypeId($query, $typeId) {
        return 1;
    }

    public static function getVisits() {
        $companies = Company::whereRaw('visits IS NOT NULL')->whereRaw('visits > 0')->get();

        $visits = 0;
        foreach ($companies as $company) {
            $visits += $company->visits;
        }

        return $visits;
    }
}
