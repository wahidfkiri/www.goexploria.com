<?php

use Illuminate\Database\Seeder;

class ActivitiesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        
/*
        \DB::table('activities')->delete();
        
        \DB::table('activities')->insert(array (
            0 => 
            array (
                'id' => '1',
                'name' => 'Vélo de montagne',
                'slug' => 'velo-de-montagne',
                'category_id' => '3',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
            1 => 
            array (
                'id' => '2',
                'name' => 'VTT',
                'slug' => 'vtt',
                'category_id' => '3',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
            2 => 
            array (
                'id' => '3',
                'name' => 'Ski nautique',
                'slug' => 'ski-nautique',
                'category_id' => '3',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
            3 => 
            array (
                'id' => '4',
                'name' => 'Kite-surf',
                'slug' => 'kite-surf',
                'category_id' => '3',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
            4 => 
            array (
                'id' => '5',
                'name' => 'Spa',
                'slug' => 'spa',
                'category_id' => '4',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
            5 => 
            array (
                'id' => '6',
                'name' => 'Balnéothérapie',
                'slug' => 'balneotherapie',
                'category_id' => '4',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
            6 => 
            array (
                'id' => '7',
                'name' => 'Parcs nationaux',
                'slug' => 'parcs-nationaux',
                'category_id' => '5',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
            7 => 
            array (
                'id' => '8',
                'name' => 'Parcs régionaux',
                'slug' => 'parcs-regionaux',
                'category_id' => '5',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
            8 => 
            array (
                'id' => '9',
                'name' => 'Réserves',
                'slug' => 'reserves',
                'category_id' => '5',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
            9 => 
            array (
                'id' => '10',
                'name' => 'Parcs marins',
                'slug' => 'parcs-marins',
                'category_id' => '5',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
            10 => 
            array (
                'id' => '11',
                'name' => 'Zoo',
                'slug' => 'zoo',
                'category_id' => '6',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
            11 => 
            array (
                'id' => '12',
                'name' => 'Centre ornithologique',
                'slug' => 'centre-ornithologique',
                'category_id' => '6',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
            12 => 
            array (
                'id' => '13',
                'name' => 'Ferme',
                'slug' => 'ferme',
                'category_id' => '6',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
            13 => 
            array (
                'id' => '14',
                'name' => 'Aquarium',
                'slug' => 'aquarium',
                'category_id' => '6',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
            14 => 
            array (
                'id' => '15',
                'name' => 'Jardin botanique',
                'slug' => 'jardin-botanique',
                'category_id' => '7',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
            15 => 
            array (
                'id' => '16',
                'name' => 'Parcours découverte',
                'slug' => 'parcours-decouverte',
                'category_id' => '7',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
            16 => 
            array (
                'id' => '17',
                'name' => 'Musée historique',
                'slug' => 'musee-historique',
                'category_id' => '8',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
            17 => 
            array (
                'id' => '18',
                'name' => 'Musée d\'art',
                'slug' => 'musee-d-art',
                'category_id' => '8',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
            18 => 
            array (
                'id' => '19',
                'name' => 'Parc d\'attraction',
                'slug' => 'parc-d-attraction',
                'category_id' => '10',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
            19 => 
            array (
                'id' => '20',
                'name' => 'Centre de paléanthologie',
                'slug' => 'centre-de-paleanthologie',
                'category_id' => '11',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
            20 => 
            array (
                'id' => '21',
                'name' => 'Grotte',
                'slug' => 'grotte',
                'category_id' => '11',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
            21 => 
            array (
                'id' => '22',
                'name' => 'Vignoble',
                'slug' => 'vignoble',
                'category_id' => '12',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
            22 => 
            array (
                'id' => '23',
                'name' => 'Terroir',
                'slug' => 'terroir',
                'category_id' => '12',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
            23 => 
            array (
                'id' => '24',
                'name' => 'Monuments',
                'slug' => 'monuments',
                'category_id' => '12',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
            24 => 
            array (
                'id' => '25',
                'name' => 'Hotel',
                'slug' => 'hotel',
                'category_id' => '13',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
            25 => 
            array (
                'id' => '26',
                'name' => 'Gîte',
                'slug' => 'gite',
                'category_id' => '13',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
            26 => 
            array (
                'id' => '27',
                'name' => 'Camping',
                'slug' => 'camping',
                'category_id' => '13',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
            27 => 
            array (
                'id' => '28',
                'name' => 'Restaurant',
                'slug' => 'restaurant',
                'category_id' => '14',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
            28 => 
            array (
                'id' => '29',
                'name' => 'Fast-food',
                'slug' => 'fast-food',
                'category_id' => '14',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
            29 => 
            array (
                'id' => '30',
                'name' => 'Bar',
                'slug' => 'bar',
                'category_id' => '14',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
            30 => 
            array (
                'id' => '31',
                'name' => 'Brasserie',
                'slug' => 'brasserie',
                'category_id' => '14',
                'created_at' => '2016',
                'updated_at' => '2016',
            ),
        ));
        
*/        
    }
}
