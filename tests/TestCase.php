<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * ATTENTION : ces tests s'exécutent sur la base configurée dans .env, qui
 * contient les données réelles importées. N'utilisez donc jamais les traits
 * RefreshDatabase / DatabaseMigrations ici : ils videraient la base.
 * Les tests fournis se limitent à des requêtes GET en lecture seule.
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
}
