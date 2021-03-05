<?php

namespace Modules\Updates\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Modules\Updates\Events\LatestVersion;
use Modules\Updates\Services\Updater;

class UpdateSystemJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 1;

    /**
     * The number of seconds the job can run before timing out.
     *
     * @var int
     */
    public $timeout = 600;

    protected $tmp_backup_dir = null;
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user_id)
    {
        $this->user = $user_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Artisan::call('app:pre-update');
        Artisan::call('app:updates');

        $this->update();

        Artisan::call('app:post-update');
    }

    /*
     * Download and Install Update.
     */
    public function update()
    {
        $latestVersion = getLastVersion();
        if (is_null($latestVersion)) {
            return;
        }
        if ($latestVersion['attributes']['build'] <= getCurrentVersion()['build']) {
            event(new LatestVersion($this->user));
            return;
        }
        //download_zip_file
        $path = $this->download($latestVersion['attributes']['filename']);
        if ($path === false) {
            throw new \Exception('Could not download updates');
        }
        //unzipping_package

        $path = $this->unzip($path);

        //copying_files
        $this->copyFiles($path);

        //running_migrations

        $this->migrate();

        //finishing_update

        $this->finishUpdate(getCurrentVersion()['version'], $latestVersion['attributes']['version']);

        Storage::disk('local')->put(
            'version.json',
            json_encode(
                [
                    'version' => $latestVersion['attributes']['version'],
                    'build' => $latestVersion['attributes']['build'],
                ]
            )
        );
        return true;
    }

    public function download($updateFileName)
    {
        try {
            $path = Updater::download($updateFileName);
            if (!is_string($path)) {
                Log::error('Downloading updates failed. Remember to enter your purchase code in settings.');
                return false;
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }

        return $path;
    }

    public function unzip($path)
    {
        try {
            $path = Updater::unzip($path);
            if (!is_string($path)) {
                throw new \Exception("Unzipping exception");
                return false;
            }
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
            return false;
        }
        return $path;
    }

    public function copyFiles($path)
    {
        try {
            Updater::copyFiles($path);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
            return false;
        }
        return true;
    }
    public function migrate()
    {
        try {
            Updater::migrateUpdate();
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
            return false;
        }

        return true;
    }

    public function finishUpdate($installed, $version)
    {
        try {
            Updater::finishUpdate($this->user, $version, $installed);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
            return false;
        }
        return true;
    }
    /*
     * Check if a new Update exist.
     */
    public function check()
    {
        $lastVersionInfo = getLastVersion();
        if (version_compare($lastVersionInfo['attributes']['version'], getCurrentVersion()['version'], ">")) {
            return $lastVersionInfo['attributes']['version'];
        }
        return '';
    }
}
