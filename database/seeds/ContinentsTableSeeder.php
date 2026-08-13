<?php

use Illuminate\Database\Seeder;

class ContinentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('continents')->delete();
        
        \DB::table('continents')->insert(array (
            0 => 
            array (
                'id' => '1',
                'code' => 'af',
                'name' => 'Afrique',
                'rank' => '1',
            ),
            1 => 
            array (
                'id' => '2',
                'code' => 'an',
                'name' => 'Antarctique',
                'rank' => '1',
            ),
            2 => 
            array (
                'id' => '3',
                'code' => 'as',
                'name' => 'Asie',
                'rank' => '1',
            ),
            3 => 
            array (
                'id' => '4',
                'code' => 'eu',
                'name' => 'Europe',
                'rank' => '1',
            ),
            4 => 
            array (
                'id' => '5',
                'code' => 'na',
                'name' => 'Amerique du Nord',
                'rank' => '1',
            ),
            5 => 
            array (
                'id' => '6',
                'code' => 'oc',
                'name' => 'Oceanie',
                'rank' => '1',
            ),
            6 => 
            array (
                'id' => '7',
                'code' => 'sa',
                'name' => 'Amerique du Sud',
                'rank' => '1',
            ),
            7 => 
            array (
                'id' => '8',
                'code' => 'ac',
                'name' => 'Amerique centrale',
                'rank' => '1',
            ),
            8 => 
            array (
                'id' => '9',
                'code' => 'cs',
                'name' => 'Caraïbes',
                'rank' => '1',
            ),
            9 => 
            array (
                'id' => '10',
                'code' => 'or',
                'name' => 'Moyen-orient',
                'rank' => '1',
            ),
        ));
        
        
    }
}
