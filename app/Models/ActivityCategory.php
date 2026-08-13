<?php

namespace App\Models;

use App\Models\BaseModel;

class ActivityCategory extends BaseModel
{

	/** Liste des types d'activités dispo */
    private static $type = null;

    protected $table = 'activities_categories';
    public function activities()
    {
    	return $this->hasMany('App\Models\Activity', 'category_id');
    }

    /** Récupère la valeur affichable du type */
    public function type() {
        if (array_key_exists ( $this->type_id, ActivityCategory::types () )) {
            return self::$type [$this->type_id];
        } else {
            return self::$type [1];
        }
    }

    /** Renvoie la liste de tous les types d'activités disponibles */
    public static function types() {
        self::$type = array (
            1 => "Tourisme",
            2 => "Affaire",
            3 => "Local",
            4 => "Prime Time",
            5 => "Web TV",
            6 => "Photos",
            7 => "Certificats Cadeaux Québec",
            8 => "Marketplace",
            9 => "Book Direct",
        );
        return self::$type;
    }


}
