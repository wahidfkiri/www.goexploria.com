<?php

namespace App\Http\Controllers\SearchBar;
use App\Http\Controllers\Company;
use App\Http\Controllers\SearchBar\BaseModel;

class CompanyModel extends BaseModel {
    
    /** Le lieu que l'on manipule */
    private $data = null;

    public function __construct($data) {
        $this->data = $data;
    }

    /** Renvoi le nom de l'entrée tel qu'affiché */
    public function entryLabel() {
        return $this->data->name . " (" . $this->data->location . " / " .$this->data->country. ")";
    }

    /** Renvoi le nom du groupe tel qu'affiché */
    public function groupLabel() {
        return "Entreprises";
    }

    /** Renvoi la valeur d'une entrée */
    public function entryValue() {
        return $this->data->id;
    }

    public function entryUrl() {
        return route('front.company.id', $this->data->id);
    }

    public function __toString() {
        return json_encode($this->data);
    }

}