<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tablesToCheck = [
                            'locations',
                            'continents', 
                            'countries', 
                            'locations_types', 
                            'coordinates', 
                            'users_types', 
                            'users',
                            'languages',
                            'activities_categories',
                            'activities',
                            'companies',
                            'pages',
                            'newsletters',
                            'modules',
                        ];

        ini_set('memory_limit','512M');
        
        if(DB::connection()->getName() == 'pgsql')  
        {
            foreach ($tablesToCheck as $key => $table) 
            {
                DB::statement('ALTER TABLE '.$table.' DISABLE TRIGGER ALL;');                
            }
        } 
        else if(DB::connection()->getName() == 'mysql')  
        {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        } 
        else 
        {
            $this->command->info('DRIVERS NON RECONNU');
        }
        
        Eloquent::unguard();
        
        $this->call('PagesTableSeeder');
        $this->call('ContinentsTableSeeder');        
        $this->call('CountriesTableSeeder');
        $this->call('LocationsTypesTableSeeder');
        #$this->call('LocationsTableSeeder');
        $this->call('CoordinatesTableSeeder');
        $this->call('UsersTypesTableSeeder'); 
        $this->call('UsersTableSeeder');
        $this->call('LanguagesTableSeeder');
        $this->call('ActivitiesCategoriesTableSeeder');
        $this->call('ActivitiesTableSeeder');        
        $this->call('CompaniesTableSeeder');
        $this->call('CompaniesActivitiesTableSeeder');
        $this->call('LocationsPagesTableSeeder');
        $this->call('CompaniesPagesTableSeeder');
        $this->call('NewslettersTableSeeder');
        $this->call('NewslettersHistoriesTableSeeder');
        $this->call('ModulesTableSeeder');
        
        //$this->call('LocationsLanguagesTableSeeder');

        if(DB::connection()->getName() == 'pgsql')  {
            foreach($tablesToCheck as $tableToCheck)    {
                DB::statement('ALTER TABLE '.$tableToCheck.' ENABLE TRIGGER ALL;');
                $this->command->info('Checking the next id sequence for '.$tableToCheck);
                $highestId = DB::table($tableToCheck)
                           ->select(DB::raw('MAX(id)'))
                           ->first();
                $nextId = DB::table($tableToCheck)
                        ->select(DB::raw('nextval(\''.$tableToCheck.'_id_seq\')'))
                        ->first();
                if($nextId && $nextId->nextval < $highestId->max)      {
                    DB::select('SELECT setval(\''.$tableToCheck.'_id_seq\', '.$highestId->max.')');
                    $highestId = DB::table($tableToCheck)
                                ->select(DB::raw('MAX(id)'))
                                ->first();
                     $nextId = DB::table($tableToCheck)
                            ->select(DB::raw('nextval(\''.$tableToCheck.'_id_seq\')'))
                            ->first();
                    if($nextId->nextval > $highestId->max) {
                        $this->command->info($tableToCheck.' autoincrement corrected');
                    } else {
                        $this->command->info('Arff! The nextval sequence is still all screwed up on '.$tableToCheck);
                    }
                }
            }
        } else if(DB::connection()->getName() == 'mysql')  {
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        }
    }
}
