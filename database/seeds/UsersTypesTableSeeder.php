<?php

use Illuminate\Database\Seeder;

class UsersTypesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users_types')->delete();
        
        \DB::table('users_types')->insert(array (
            1 => 
            array (
                'id' => '1',
                'name' => 'Entreprise',
                'slug' => 'company',
                'libelle' => 'Votre entreprise n’est pas affichée dans votre secteur d’activité ? Inscrivez-vous et voir nos plans d’affichage.',
            ),
            2 => 
            array (
                'id' => '2',
                'name' => 'Voyageur / Reporter',
                'slug' => 'reporter',
                'libelle' => 'Publiez vos photos et vidéos de vos voyages à travers le monde ou tout simplement de votre coin de pays.',
            ),
            3 => 
            array (
                'id' => '3',
                'name' => 'Commerce / Service',
                'slug' => 'commerce',
                'libelle' => 'Vous avez des produits à vendre ou à promouvoir ? Inscrivez-vous et postez votre liste de produits.',
            ),
        ));
        
        
    }
}
