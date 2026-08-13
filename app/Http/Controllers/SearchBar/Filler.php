<?php

namespace App\Http\Controllers\SearchBar;
use App\Http\Controllers\SearchBar\BaseModel;

class Filler {

    /* Les données contenues dans la barre de recherche */
    private $data;

    public function __construct() {
        $this->data = array();
    }

    /** Renvoi les donénes au format JSON*/
    public function getJSONData() {
        return json_encode($this->data);
    } 

    /** Renvoi les données sous forme de tableau */
    public function getData() {
        return $data;
    }


    /** Remplit le module à partir d'un tableau existant */
    public function fill(Array $src) {
         
        // Récupération des liens et génération de la liste
        foreach ($src as $info) {
            // On rentre les données
            array_push($this->data, array('value' => $info->entryValue(), 'url' => $info->entryUrl(), 'nom' => $info->entryLabel(), 'groupe'=>($info->groupLabel()),  'label' => $info->groupLabel()));
            }

    }

}
