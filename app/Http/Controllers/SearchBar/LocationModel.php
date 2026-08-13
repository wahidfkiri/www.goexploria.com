<?php

namespace App\Http\Controllers\SearchBar;

use App\Http\Controllers\Location;
use App\Http\Controllers\SearchBar\BaseModel;

class LocationModel extends BaseModel {
    
    /** Le lieu que l'on manipule */
    private $location = null;

    public function __construct($lieu) {
        $this->location = $lieu;
    }

    /** Renvoi le nom de l'entrée tel qu'affiché */
    public function entryLabel() {
        $parent = $this->location->parent == null ? '' : " (" . $this->location->parent . ")";
        return $this->location->lieu . $parent;
    }

    /** Renvoi le nom du groupe tel qu'affiché */
    public function groupLabel() {
        return $this->location->type . " - " . $this->location->pays;
    }

    /** Renvoi la valeur d'une entrée */
    public function entryValue() {
        return $this->location->id;
    }

    public function entryUrl() {
        return route('front.location.id', $this->location->id);
    }

    public function __toString() {
        return json_encode($this->location);
    }

}