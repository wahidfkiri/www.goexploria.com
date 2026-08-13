<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

/**
 * Vérifie que les principales pages répondent après la migration vers
 * Laravel 11 / PHP 8.2. Lecture seule : aucune donnée n'est modifiée.
 */
class SmokeTest extends TestCase
{
    /**
     * Pages publiques.
     */
    public static function publicRoutes(): array
    {
        return [
            'accueil' => ['/'],
            'accueil fr' => ['/fr'],
            'accueil en' => ['/en'],
            'connexion' => ['/auth/user/login'],
            'mot de passe oublié' => ['/auth/password/email'],
            'robots.txt' => ['/robots.txt'],
            'recherche lieu' => ['/search/location'],
            'erreur 404' => ['/404'],
            'erreur 503' => ['/503'],
        ];
    }

    /**
     * Pages d'administration (nécessitent un compte administrateur).
     */
    public static function adminRoutes(): array
    {
        return [
            'tableau de bord' => ['/admin'],
            'liste utilisateurs' => ['/admin/user/mod/index'],
            'ajout utilisateur' => ['/admin/user/mod/add'],
            'continents' => ['/admin/continent/mod/index'],
            'ajout continent' => ['/admin/continent/mod/add'],
            'pays' => ['/admin/country/mod/index'],
            'ajout pays' => ['/admin/country/mod/add'],
            'recherche activités' => ['/admin/activity/mod/search'],
            'ajout activité' => ['/admin/activity/mod/add'],
            'catégories activités' => ['/admin/activity/category/mod/search'],
            'recherche entreprises' => ['/admin/company/mod/search'],
            'ajout entreprise' => ['/admin/company/mod/add'],
            'newsletters' => ['/admin/newsletter/mod/index'],
            'historique newsletters' => ['/admin/newsletter/mod/history/index'],
            'contenus' => ['/admin/config/content/index'],
            'modules' => ['/admin/config/module/mod/index'],
            'galeries entreprise' => ['/admin/gallery/mod/company/search'],
            'galeries lieu' => ['/admin/gallery/mod/location/search'],
            'galeries pays' => ['/admin/gallery/mod/pays/search'],
        ];
    }

    /**
     * @dataProvider publicRoutes
     */
    public function test_public_page_responds(string $uri): void
    {
        $response = $this->get($uri);

        $this->assertContains(
            $response->getStatusCode(),
            [200, 302],
            "GET $uri a répondu ".$response->getStatusCode()
        );
    }

    /**
     * @dataProvider adminRoutes
     */
    public function test_admin_page_responds(string $uri): void
    {
        $admin = User::where('is_admin', 1)->where('is_activated', 1)->first();

        $this->assertNotNull($admin, 'Aucun administrateur actif dans la base.');

        $response = $this->actingAs($admin)->get($uri);

        $this->assertContains(
            $response->getStatusCode(),
            [200, 302],
            "GET $uri a répondu ".$response->getStatusCode()
        );
    }

    /**
     * Balaie toutes les routes GET d'administration sans paramètre d'URL et
     * vérifie qu'aucune ne retourne une erreur serveur. C'est le filet de
     * sécurité principal de la migration : il couvre l'ensemble du back-office
     * sans avoir à lister les URL une par une.
     */
    public function test_no_admin_route_returns_a_server_error(): void
    {
        $admin = User::where('is_admin', 1)->where('is_activated', 1)->first();
        $this->assertNotNull($admin, 'Aucun administrateur actif dans la base.');

        $uris = [];

        foreach (app('router')->getRoutes() as $route) {
            if (! in_array('GET', $route->methods(), true)) {
                continue;
            }

            $uri = $route->uri();

            // Routes du back-office uniquement, sans paramètre à deviner.
            if (! str_starts_with($uri, 'admin/') || str_contains($uri, '{')) {
                continue;
            }

            // Écarte les actions destructrices ou coûteuses.
            if (preg_match('#/(delete|remove|send|import|export|truncate)#', $uri)) {
                continue;
            }

            $uris[] = $uri;
        }

        $this->assertNotEmpty($uris, 'Aucune route admin découverte.');

        $failures = [];

        foreach ($uris as $uri) {
            $status = $this->actingAs($admin)->get('/'.$uri)->getStatusCode();

            if ($status >= 500) {
                $failures[] = "$uri -> $status";
            }
        }

        $this->assertSame(
            [],
            $failures,
            count($failures).' route(s) admin en erreur serveur sur '.count($uris).' :'.PHP_EOL
                .implode(PHP_EOL, $failures)
        );
    }

    public function test_home_page_renders_real_content(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('GoExploria', false);
    }

    public function test_unauthenticated_admin_is_redirected_to_login(): void
    {
        $this->get('/admin')->assertRedirect();
    }
}
