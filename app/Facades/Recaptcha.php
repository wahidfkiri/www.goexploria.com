<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Support\HtmlString render(?string $lang = null)
 * @method static bool verify(?string $response, ?string $ip = null)
 * @method static ?string siteKey()
 *
 * @see \App\Services\Recaptcha
 */
class Recaptcha extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \App\Services\Recaptcha::class;
    }
}
