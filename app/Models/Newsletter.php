<?php

namespace App\Models;

use App\Models\BaseModel;

class Newsletter extends BaseModel
{
    protected $table = 'newsletters';

    /** Liste des statuts disponibles */
    private static $statut = null;

    public function sends(){
    	return $this->hasMany('App\Models\NewsletterHistory', 'newsletter_id');
    }

    /** Renvoi vrai si déjà envoyée */
    public function isSended() {
    	return count_of($this->sends) > 0;
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
    	if (array_key_exists ( $value, Newsletter::statuts () )) {
            return self::$statut [$value];
        } else {
            return self::$statut [0];
        } 
    }
}
