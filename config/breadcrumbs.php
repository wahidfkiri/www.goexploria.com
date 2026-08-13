<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Gabarit d'affichage
    |--------------------------------------------------------------------------
    |
    | Le thème de l'application est en Bootstrap 3 ; le gabarit correspondant
    | est fourni dans resources/views/vendor/breadcrumbs/bootstrap3.blade.php.
    |
    */

    'view' => 'breadcrumbs::bootstrap3',

    /*
    |--------------------------------------------------------------------------
    | Fichier de définitions
    |--------------------------------------------------------------------------
    */

    'files' => base_path('routes/breadcrumbs.php'),

    /*
    |--------------------------------------------------------------------------
    | Fil d'Ariane manquant
    |--------------------------------------------------------------------------
    |
    | En 5.2 l'application n'échouait pas sur un fil d'Ariane non défini ; on
    | conserve ce comportement pour ne pas casser des pages existantes.
    |
    */

    'missing-route-bound-breadcrumb-exception' => false,

    'unnamed-route-exception' => false,

    'invalid-named-breadcrumb-exception' => false,

];
