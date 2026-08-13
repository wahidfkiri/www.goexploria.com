<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\HtmlString;

/**
 * Service reCAPTCHA v2.
 *
 * Remplace les paquets greggilbert/recaptcha et albertcht/invisible-recaptcha,
 * tous deux abandonnés et incompatibles avec Laravel 11. Il expose la même
 * surface que celle utilisée par l'application :
 *
 *   - app('captcha')->render($lang)   (vues front / site)
 *   - Recaptcha::render()             (vue front/user/create)
 *   - règles de validation "captcha" et "recaptcha"
 */
class Recaptcha
{
    const VERIFY_URL = 'https://www.google.com/recaptcha/api/siteverify';

    public function __construct(
        protected ?string $siteKey,
        protected ?string $secretKey,
        protected int $timeout = 5,
    ) {
    }

    /**
     * Rend le widget reCAPTCHA.
     */
    public function render(?string $lang = null): HtmlString
    {
        if (empty($this->siteKey)) {
            return new HtmlString('');
        }

        $lang = $lang ?: app()->getLocale();

        $src = self::scriptUrl($lang);

        return new HtmlString(
            '<div class="g-recaptcha" data-sitekey="'.e($this->siteKey).'"></div>'
            .'<script src="'.e($src).'" async defer></script>'
        );
    }

    /**
     * Vérifie la réponse renvoyée par le widget auprès de Google.
     */
    public function verify(?string $response, ?string $ip = null): bool
    {
        if (empty($this->secretKey) || empty($response)) {
            return false;
        }

        try {
            $result = Http::asForm()
                ->timeout($this->timeout)
                ->post(self::VERIFY_URL, array_filter([
                    'secret' => $this->secretKey,
                    'response' => $response,
                    'remoteip' => $ip,
                ]))
                ->json();
        } catch (\Throwable $e) {
            report($e);

            return false;
        }

        return (bool) ($result['success'] ?? false);
    }

    public function siteKey(): ?string
    {
        return $this->siteKey;
    }

    protected static function scriptUrl(string $lang): string
    {
        return 'https://www.google.com/recaptcha/api.js?hl='.urlencode($lang);
    }
}
