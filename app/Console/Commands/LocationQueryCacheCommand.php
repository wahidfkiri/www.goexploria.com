<?php

namespace App\Console\Commands;

use App\Models\Continent;
use App\Models\Country;
use App\Services\CountryCacheService;
use App\Services\LocationCacheService;
use Illuminate\Console\Command;

class LocationQueryCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'location:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Location query Cache command';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $continents = Continent::all();
        foreach ($continents as $continent) {
            $this->info('Continet : ' . $continent);
            $countries = Country::where('continent_id', $continent->id)->where('is_activated', true)->get();
            foreach ($countries as $country) {
                $this->info('Country: ' . $country->name);
                $countryCache = new CountryCacheService($country);
                $countryCache->callAll();
                $locations = $country->locations;

                foreach ($locations as $location) {
                    $this->info('Location : ' . $location->name);
                    $cacheLocation = new LocationCacheService($location);
                    $cacheLocation->callAll();
                }
            }
        }

    }
}
