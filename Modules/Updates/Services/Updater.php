<?php
namespace Modules\Updates\Services;

use Exception;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Modules\Updates\Events\UpdateSuccessful;
use Modules\Updates\Traits\SiteRemote;
use ZipArchive;

class Updater
{
    use SiteRemote;

    public static function download($new_version)
    {
        $data = null;
        $path = null;
        $code = strlen(get_option('purchase_code')) ? get_option('purchase_code') : 'null';
        $url = config('updater.update_baseurl') . '/' . $code . '/' . $new_version;
        if (env('APP_ENV') === 'development') {
            $url = $url . '?type=update&is_dev=1';
        } else {
            $url = $url . '?type=update';
        }

        $response = static::getRemote($url, ['timeout' => 100, 'track_redirects' => true]);
        // Exception
        if ($response instanceof RequestException || ($response->getStatusCode() == 500)) {
            Log::error($response->getBody()->getContents());
            return [
                'success' => false,
                'error' => 'Failed to download updates. Ensure you have set the purchase code',
                'data' => [
                    'path' => $path,
                ],
            ];
        }

        if ($response && ($response->getStatusCode() == 200)) {
            $data = $response->getBody()->getContents();
        }

        // Create temp directory
        $temp_dir = storage_path('app/temp-' . md5(mt_rand()));

        if (!File::isDirectory($temp_dir)) {
            File::makeDirectory($temp_dir);
        }

        $zip_file_path = $temp_dir . '/upload.zip';

        // Add content to the Zip file
        $uploaded = is_int(file_put_contents($zip_file_path, $data)) ? true : false;

        if (!$uploaded) {
            return false;
        }

        return $zip_file_path;
    }

    public static function unzip($zip_file_path)
    {
        if (!file_exists($zip_file_path)) {
            throw new \Exception('Zip file not found');
        }

        $temp_extract_dir = storage_path('app/temp2-' . md5(mt_rand()));

        if (!File::isDirectory($temp_extract_dir)) {
            File::makeDirectory($temp_extract_dir);
        }
        // Unzip the file
        $zip = new ZipArchive();

        if ($zip->open($zip_file_path)) {
            $zip->extractTo($temp_extract_dir);
        }

        $zip->close();

        // Delete zip file
        File::delete($zip_file_path);

        return $temp_extract_dir;
    }

    public static function copyFiles($temp_extract_dir)
    {
        if (!File::copyDirectory($temp_extract_dir . '/', base_path())) {
            return false;
        }

        // Delete temp directory
        File::deleteDirectory($temp_extract_dir);

        return true;
    }

    public static function migrateUpdate()
    {
        Artisan::call('migrate --force');

        return true;
    }

    public static function finishUpdate($user, $installed, $old_version)
    {
        event(new UpdateSuccessful($user, $installed, $old_version));

        return [
            'success' => true,
            'error' => false,
            'data' => [],
        ];
    }

}
