<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Helpers\Importer;

class ImportCompanies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'companies:import {file} {location} {activities}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import companies from an XML file.';

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
        if (!is_file($this->argument('file'))) {
            $this->error('Could not find file: ' . $this->argument('file') . '.');
            exit();
        }

        $activities = explode(',', $this->argument('activities'));

        $count = Importer::Companies($this->argument('file'), $this->argument('location'), $activities);

        $this->info('Successfully imported ' . $count . ' companies.');
    }
}
