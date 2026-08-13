<?php

namespace App\Console\Commands;

use App\Models\Activity;
use App\Models\ActivityCategory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class NavComposerCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nav:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Navigation composer cache';

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
        $categories = ActivityCategory::where('type_id', 1)
            ->select("name", "id", 'slug')
            ->orderBy('name')
            ->get();

        foreach ($categories as $category) {
            $this->_getTourismActivities($category->slug);
        }
    }

    /**
     * Get Activities by Categories
     *
     * @param string $category Category slug
     * @return \Illuminate\Database\Eloquent\Collection
     */
    private function _getTourismActivities($category)
    {
        $key = 'tourism_activities_' . $category;

        $activities = Activity::join('activities_categories', 'activities_categories.id', '=', 'activities.category_id')
            ->where('activities_categories.type_id', 1)
            ->where('activities_categories.slug', $category)
            ->select("activities.name", "activities.id", "activities.slug")
            ->orderBy('name')
            ->get();
        Cache::put($key, $activities, 240);
        return $activities;
    }

}
