<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class RemoveSystemGeneratedFile extends Job implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $files = [];

    /**
     * Create a new job instance.
     *
     * @param $files
     */
    public function __construct($files)
    {
        $this->files = is_array($files) ? $files : [$files];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        foreach ($this->files as $file) {
            try {
                if (file_exists($file) && is_dir($file)) {
                    $it = new \RecursiveDirectoryIterator($file, \RecursiveDirectoryIterator::SKIP_DOTS);
                    $files = new \RecursiveIteratorIterator($it,
                        \RecursiveIteratorIterator::CHILD_FIRST);
                    foreach ($files as $file) {
                        if ($file->isDir()) {
                            rmdir($file->getRealPath());
                        } else {
                            unlink($file->getRealPath());
                        }
                    }
                    if (file_exists($file)) {
                        rmdir($file);
                    }
                } else {
                    if (file_exists($file)) {
                        unlink($file);
                    }

                }
            } catch (\Exception $e) {
                continue;
            }
        }
    }
}
