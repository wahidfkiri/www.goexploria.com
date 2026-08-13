<?php

namespace App\Models;

use App\Models\BaseModel;

class Infolettre extends BaseModel
{
    protected $table = 'infolettres';

    /** Liste des statuts disponibles */
    private static $statut = null;

    public function company(){
    	return $this->belongsTo('App\Models\Company', 'company_id');
    }

    /** Renvoi vrai si déjà envoyée */
    public function isSended() {
        return $this->sended_at != null;
    }


    /** Renvoie la liste des statuts disponibles */
    public static function statuts() {
        self::$statut = array (
                        0 => "En attente",
                        1 => "Envoyée"
        );
        return self::$statut;
    }

    /** Récupère la valeur affichable de la visibilité*/
    public function statut() {
    	$value = $this->isSended() ? 1 : 0;
    	if (array_key_exists ( $value, Infolettre::statuts () )) {
            return self::$statut [$value];
        } else {
            return self::$statut [0];
        } 
    }
}
