<?php

namespace App\Http\Controllers\SearchBar;

abstract class BaseModel {

    /** Renvoi le nom de l'entrée tel qu'affiché */
    abstract protected function entryLabel();

    /** Renvoi le nom du groupe tel qu'affiché */
    abstract protected function groupLabel();

    /** Renvoi la valeur d'une entrée */
    abstract protected function entryValue();

    /** Renvoi l'url d'accès à l'entrée */
    abstract protected function entryUrl();
}

