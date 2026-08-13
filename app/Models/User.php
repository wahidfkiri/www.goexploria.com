<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends BaseModel implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    protected $table = 'users';

    /** Liste des statuts disponibles */
    private static $statut = null;

    /** Liste des rangs disponibles */
    private static $rang = null;

    /** Liste des valeurs pour  */
    private static $news = null;

    public function getAuthIdentifier()
    {
        return $this->id;
    }

    public function getAuthPassword()
    {
        return $this->password;
    }

    public function companies()
    {
        return $this->belongsToMany("App\Models\Company", "companies_users", "user_id", 'company_id');
    }

    public function subscriptions()
    {
        return $this->hasMany("App\Models\CompanyFollower", 'email', 'email');
    }

    public function galleries()
    {
        return $this->hasMany("App\Models\Gallery", 'user_id');
    }

    public function comments()
    {
        return $this->hasMany("App\Models\Comment", 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function meetings()
    {
        return $this->hasMany(CompanyMeeting::class);
    }

    /** @return true si administrateur */
    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function type()
    {
        return $this->belongsTo('App\Models\UserType', 'type_id');
    }

    public function newslettersHistoryEntries()
    {
        return $this->hasMany('App\Models\NewsletterHistory', 'user_id');
    }

    public function coordinate()
    {
        return $this->belongsTo('App\Models\Coordinate', 'coordinate_id');
    }

    /** Recherche sur les infos d'une entreprise */
    public static function search($name, $lastName, $firstName, $mail, $type, $isActivated, $isAdmin, $isNewsletterEnabled)
    {
        return User::join('users_types', 'users_types.id', '=', 'users.type_id')
            ->where(function ($query) use ($name, $firstName, $lastName, $mail, $type, $isActivated, $isAdmin, $isNewsletterEnabled) {
                $query->where(function ($query) use ($name) {
                    // Recherche sur le champ du nom complet
                    if (!empty($name)) {
                        $query->whereRaw("LOWER(users.name) LIKE  ?", ["%" . strtolower($name) . "%"]);
                    }
                })
                    ->where(function ($query) use ($firstName) {
                        // Recherche sur le champ du prénom
                        if (!empty($firstName)) {
                            $query->whereRaw("LOWER(users.first_name) LIKE  ?", ["%" . strtolower($firstName) . "%"]);
                        }
                    })
                    ->where(function ($query) use ($lastName) {
                        // Recherche sur le champ du nom
                        if (!empty($lastName)) {
                            $query->whereRaw("LOWER(users.last_name) LIKE ?", ["%" . strtolower($lastName) . "%"]);
                        }
                    })
                    ->where(function ($query) use ($mail) {
                        // Recherche sur le champ du mail
                        if (!empty($mail)) {
                            $query->whereRaw("LOWER(users.email) LIKE ?", ["%" . strtolower($mail) . "%"]);
                        }
                    })
                    ->where(function ($query) use ($isActivated) {
                        // Recherche sur le champ de l'is_activated
                        if (isset($isActivated) && is_numeric($isActivated) && $isActivated >= 0) {
                            $query->where('users.is_activated', $isActivated > 0);
                        }
                    })
                    ->where(function ($query) use ($isAdmin) {
                        // Recherche sur le champ du rang
                        if (isset($isAdmin) && is_numeric($isAdmin) && $isAdmin >= 0) {
                            $query->where('users.is_admin', $isAdmin > 0);
                        }
                    })
                    ->where(function ($query) use ($isNewsletterEnabled) {
                        // Recherche sur le champ de la newsletter
                        if (isset($isNewsletterEnabled) && is_numeric($isNewsletterEnabled) && $isNewsletterEnabled >= 0) {
                            $query->where('users.is_news_enabled', $isNewsletterEnabled > 0);
                        }
                    })
                    ->where(function ($query) use ($type) {
                        // Recherche sur le champ du type
                        if (!empty($type)) {
                            $query->where("users_types.id", "=", $type);
                        }
                    });
            })
            ->select('users.*')
            ->orderBy('last_name')
            ->orderBy('first_name');
    }


    /** Récupère le rang disponible */
    public function rang()
    {
        $rang = $this->is_admin ? 1 : 0;
        if (array_key_exists($rang, User::rangs())) {
            return self::$rang [$rang];
        } else {
            return self::$rang [0];
        }
    }

    /** Renvoie la liste des rangs disponibles */
    public static function rangs()
    {
        self::$rang = array(
            0 => (object)['name' => "Membre", 'action' => 'Promouvoir', 'txt' => 'rétrogradé'],
            1 => (object)['name' => "Administrateur", 'action' => 'Rétrograder', 'txt' => 'promu']
        );
        return self::$rang;
    }

    /** Renvoie la liste des statuts pour la newsletter */
    public static function newsStatut()
    {
        self::$news = array(
            0 => "Désactivée",
            1 => "Abonné"
        );
        return self::$news;
    }

    /** Renvoi le statut de la newsletter en fonction de l'état de l'objet */
    public function news()
    {
        $news = $this->is_news_enabled ? 1 : 0;
        if (array_key_exists($news, User::newsStatut())) {
            return self::$news [$news];
        } else {
            return self::$news [0];
        }
    }


    /** Récupère la valeur affichable de l'is_activated */
    public function statut()
    {
        return User::getStatut($this->is_activated ? 1 : 0);
    }

    /** Renvoie la liste statuts d'is_activated disponibles */
    public static function statuts()
    {
        self::$statut = array(
            0 => (object)['name' => "En attente", 'action' => 'Activer', 'txt' => 'désactivé'],
            1 => (object)['name' => "Actif", 'action' => 'Désactiver', 'txt' => 'activé']
        );
        return self::$statut;
    }

    /** Renvoie la visibilité opposée */
    public function opposite()
    {
        return User::getStatut($this->is_activated ? 0 : 1);
    }

    /** Renvoi la visibilité en fonction de la valeur passé en argument */
    private static function getStatut($statut)
    {
        if (array_key_exists($statut, User::statuts())) {
            return self::$statut [$statut];
        } else {
            return self::$statut [0];
        }
    }

    /** Renvoi une liste de statut */
    public static function statutsList()
    {
        $return = array();
        foreach (User::statuts() as $key => $value) {
            $return[$key] = $value->name;
        }
        return $return;
    }

    /** Renvoi une liste de rangs */
    public static function rangsList()
    {
        $return = array();
        foreach (User::rangs() as $key => $value) {
            $return[$key] = $value->name;
        }
        return $return;
    }
}
