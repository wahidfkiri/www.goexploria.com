<?php

use Illuminate\Database\Seeder;

class ModulesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('modules')->delete();
        
        \DB::table('modules')->insert(array (
            0 => 
            array (
                'id' => 2,
                'name' => 'Activités',
                'key' => 'activity',
            ),
            1 => 
            array (
                'id' => 3,
                'name' => 'Catégorie d\'activités',
                'key' => 'activity/category',
            ),
            2 => 
            array (
                'id' => 4,
                'name' => 'Lieux',
                'key' => 'location',
            ),
            3 => 
            array (
                'id' => 5,
                'name' => 'Types de lieux',
                'key' => 'location/type',
            ),
            4 => 
            array (
                'id' => 6,
                'name' => 'Pages de lieux',
                'key' => 'location/page',
            ),
            5 => 
            array (
                'id' => 7,
                'name' => 'Entreprises',
                'key' => 'company',
            ),
            6 => 
            array (
                'id' => 8,
                'name' => 'Newsletter',
                'key' => 'newsletter',
            ),
            7 => 
            array (
                'id' => 10,
                'name' => 'Continents',
                'key' => 'continent',
            ),
            8 => 
            array (
                'id' => 11,
                'name' => 'Pays',
                'key' => 'country',
            ),
            11 => 
            array (
                'id' => 12,
                'name' => 'Pages de entreprises',
                'key' => 'company/page',
            ),
        ));
        
        
    }
}
