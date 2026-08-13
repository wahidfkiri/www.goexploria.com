<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Clés d'API reCAPTCHA v2
    |--------------------------------------------------------------------------
    |
    | "site_key" est la clé publique (exposée dans le HTML), "secret_key" la
    | clé privée utilisée pour la vérification serveur.
    |
    | Les anciennes clés étaient codées en dur dans ce fichier ; elles sont
    | conservées comme valeurs par défaut pour ne pas casser les déploiements
    | existants, mais elles devraient être déplacées dans le .env et la clé
    | secrète régénérée depuis la console reCAPTCHA.
    |
    */

    'site_key' => env('RECAPTCHA_SITE_KEY', env('RECAPTCHA_PUBLIC_KEY', '6LejMSATAAAAAM53udmxG65V_P-WZEjtlVDq8awD')),

    'secret_key' => env('RECAPTCHA_SECRET_KEY', env('RECAPTCHA_PRIVATE_KEY', '6LejMSATAAAAAAoRMUZMdUgL5TqOVjAL5IXZi5Gc')),

    /*
    |--------------------------------------------------------------------------
    | Délai d'attente (secondes) de l'appel de vérification
    |--------------------------------------------------------------------------
    */

    'timeout' => (int) env('RECAPTCHA_TIMEOUT', 5),

];
