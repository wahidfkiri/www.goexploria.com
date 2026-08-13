<?php

use Illuminate\Support\Facades\Facade;

return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    */

    'name' => env('APP_NAME', 'GoExploria'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    */

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL'),

    /*
    | Domaine principal du site, utilisé par routes/web.php pour distinguer le
    | site principal des sous-sites d'entreprise. Lu auparavant directement
    | dans $_ENV, ce qui cassait dès que la configuration était mise en cache.
    */

    'domain' => env('DOMAIN'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    */

    'timezone' => 'America/Montreal',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | "locales" pilote le préfixe de langue des routes (voir bootstrap/app.php)
    | ainsi que le middleware App\Http\Middleware\Locale.
    |
    */

    'locale' => 'fr',

    'locales' => ['en' => 'English', 'fr' => 'Français'],

    'fallback_locale' => 'fr',

    'faker_locale' => 'fr_FR',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    */

    'cipher' => 'AES-256-CBC',

    'key' => env('APP_KEY'),

    'previous_keys' => [
        ...array_filter(
            explode(',', env('APP_PREVIOUS_KEYS', ''))
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    */

    'maintenance' => [
        'driver' => env('APP_MAINTENANCE_DRIVER', 'file'),
        'store' => env('APP_MAINTENANCE_STORE', 'database'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | Les alias des paquets (Form, Html, Breadcrumbs, Calendar, Image,
    | JsValidator, Debugbar…) sont fournis par l'auto-découverte de Composer.
    | Seuls les alias propres à l'application sont déclarés ici.
    |
    */

    'aliases' => Facade::defaultAliases()->merge([
        'Formatter' => App\Helpers\Formatter::class,
        'Carbon' => Carbon\Carbon::class,
        'Recaptcha' => App\Facades\Recaptcha::class,
    ])->toArray(),

];
