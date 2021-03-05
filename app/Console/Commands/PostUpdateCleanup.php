<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class PostUpdateCleanup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */

    protected $signature = 'app:post-update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command to perform updates cleanups';
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * A filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    private $disk;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Filesystem $disk)
    {
        parent::__construct();
        $this->disk = $disk;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $cmd = app_path("Console/Commands/WorkCommand.php");
        if (File::exists($cmd)) {
            unlink($cmd);
        }
        $this->removeCacheFiles();
        Artisan::call('cache:clear');
        $this->info('Post update action completed successfully');
    }

    public function removeCacheFiles()
    {
        $files = $this->getCacheFiles();
        $deleted = $this->delete($files->except('.gitignore', 'index.html'));
        if (!$deleted) {
            $this->info('There was no cache file to delete in bootstrap/cache folder');
        } elseif ($deleted == 1) {
            $this->info('1 cache file has been deleted');
        } else {
            $this->info($deleted . ' log files have been deleted');
        }
    }

    /**
     * Get a collection of cache files sorted by their last modification date.
     *
     * @return \Illuminate\Support\Collection
     */
    private function getCacheFiles()
    {
        if (file_exists('bootstrap/cache')) {
            return collect(
                $this->disk->allFiles('bootstrap/cache')
            )->sortBy('mtime');
        }
        return collect([]);
    }
    /**
     * Delete the given files.
     *
     * @param  \Illuminate\Support\Collection $files
     * @return int
     */
    private function delete(Collection $files)
    {
        return $files->each(
            function ($file) {
                $this->disk->delete($file);
            }
        )->count();
    }
}
