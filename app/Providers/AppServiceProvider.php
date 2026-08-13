<?php

namespace App\Providers;

use App\Services\Recaptcha;
use App\Services\Sitemap;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Remplace roumen/sitemap : résolu via App::make('sitemap').
        $this->app->bind('sitemap', fn () => new Sitemap);

        // Remplace greggilbert/recaptcha et albertcht/invisible-recaptcha.
        $this->app->singleton(Recaptcha::class, fn ($app) => new Recaptcha(
            $app['config']->get('recaptcha.site_key'),
            $app['config']->get('recaptcha.secret_key'),
            (int) $app['config']->get('recaptcha.timeout', 5),
        ));

        // Les vues appellent app('captcha')->render(...).
        $this->app->alias(Recaptcha::class, 'captcha');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerRecaptchaValidator();
    }

    /**
     * Les FormRequest utilisent les règles "captcha" et "recaptcha", fournies
     * auparavant par deux paquets distincts. Elles pointent désormais toutes
     * deux vers la même vérification serveur.
     */
    protected function registerRecaptchaValidator(): void
    {
        $validate = function ($attribute, $value) {
            return $this->app->make(Recaptcha::class)->verify(
                is_string($value) ? $value : null,
                request()->ip(),
            );
        };

        Validator::extend('captcha', $validate, 'La validation du captcha a échoué.');
        Validator::extend('recaptcha', $validate, 'La validation du captcha a échoué.');
    }
}
