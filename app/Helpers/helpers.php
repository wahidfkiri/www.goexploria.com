<?php

/*
|--------------------------------------------------------------------------
| Helpers globaux retirés depuis Laravel 6
|--------------------------------------------------------------------------
|
| Laravel 5.2 exposait une série de helpers globaux (str_*, array_*) qui ont
| été supprimés en 6.0 au profit des classes Illuminate\Support\Str et Arr.
| L'application les utilise encore ; on les réimplémente ici en déléguant aux
| classes officielles afin de conserver un comportement identique.
|
*/

use Illuminate\Support\Str;

if (! function_exists('count_of')) {
    /**
     * Compte un ensemble en tolérant les valeurs non dénombrables.
     *
     * Jusqu'à PHP 7.1, count() acceptait n'importe quelle valeur : null valait
     * 0 et un objet non Countable valait 1. Depuis PHP 8 c'est une TypeError.
     * L'application s'appuyait sur cet ancien comportement pour tester la
     * présence d'une relation (par exemple `count($coordinate) > 0` sur un
     * modèle unique). Ce helper restitue la sémantique d'origine.
     *
     * Pour un tableau ou un Countable (dont les Collection Eloquent), le
     * résultat est strictement identique à count().
     *
     * @param  mixed  $value
     */
    function count_of($value): int
    {
        if (is_array($value) || $value instanceof Countable) {
            return \count($value);
        }

        return is_null($value) ? 0 : 1;
    }
}

if (! function_exists('str_slug')) {
    /**
     * Generate a URL friendly "slug" from a given string.
     *
     * @param  string  $title
     * @param  string  $separator
     * @param  string|null  $language
     * @return string
     */
    function str_slug($title, $separator = '-', $language = 'en')
    {
        return Str::slug($title, $separator, $language);
    }
}

if (! function_exists('str_is')) {
    /**
     * Determine if a given string matches a given pattern.
     *
     * @param  string|array  $pattern
     * @param  string  $value
     * @return bool
     */
    function str_is($pattern, $value)
    {
        return Str::is($pattern, $value);
    }
}

if (! function_exists('str_finish')) {
    /**
     * Cap a string with a single instance of a given value.
     *
     * @param  string  $value
     * @param  string  $cap
     * @return string
     */
    function str_finish($value, $cap)
    {
        return Str::finish($value, $cap);
    }
}
