<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        commands: __DIR__.'/../routes/console.php',
        using: function () {
            // Routage multilingue : un préfixe de langue ("/fr", "/en") est
            // ajouté seulement quand le premier segment est une locale connue.
            $locale = request()->segment(1);
            $locales = array_keys(config('app.locales', []));

            $registrar = Route::namespace('App\Http\Controllers');

            if (in_array($locale, $locales, true)) {
                app()->setLocale($locale);
                $registrar = $registrar->prefix($locale);
            }

            // Le groupe "web" est déjà appliqué à l'intérieur de routes/web.php.
            $registrar->group(base_path('routes/web.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->replace(
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \App\Http\Middleware\EncryptCookies::class,
        );

        // CSRF « maison » : conserve la liste d'exclusions de l'application.
        $middleware->replace(
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
            \App\Http\Middleware\VerifyCsrf::class,
        );

        $middleware->append(\App\Http\Middleware\Locale::class);
        $middleware->web(append: [
            \App\Http\Middleware\Locale::class,
        ]);

        $middleware->alias([
            'auth' => \App\Http\Middleware\Authenticate::class,
            'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
            'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
            'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
            'country.code' => \App\Http\Middleware\CountryCodeMiddleware::class,
            'location.slug' => \App\Http\Middleware\LocationSlugMiddleware::class,
            'company.slug' => \App\Http\Middleware\CompanySlugMiddleware::class,
            'admin' => \App\Http\Middleware\Admin::class,
            'access' => \App\Http\Middleware\AccessControl::class,
            'domain' => \App\Http\Middleware\Domain::class,
            'company.member' => \App\Http\Middleware\CompanyMemberMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Rend errors/404 (ou errors/{code}) pour toute HttpException, comme
        // le faisait App\Exceptions\Handler en 5.2.
        $exceptions->render(function (HttpExceptionInterface $e) {
            $status = $e->getStatusCode();

            if (view()->exists('errors.'.$status)) {
                return response(view('errors.'.$status), $status);
            }

            return response(view('errors.404'), 404);
        });
    })->create();
