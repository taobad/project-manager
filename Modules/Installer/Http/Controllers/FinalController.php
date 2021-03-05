<?php

namespace Modules\Installer\Http\Controllers;

use Exception;
use Illuminate\Routing\Controller;
use Modules\Installer\Helpers\FinalInstallManager;
use Modules\Installer\Helpers\InstalledFileManager;

class FinalController extends Controller
{
    /**
     * Update installed file and display finished view.
     *
     * @param  InstalledFileManager $fileManager
     * @return \Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager, FinalInstallManager $finalInstall)
    {
        $finalInstall->runFinal();
        $fileManager->update();
        $this->postInstallAction();

        return view('installer::finished');
    }
    /**
     * Save the form content to the .env file.
     *
     * @return string
     */
    public function postInstallAction()
    {
        $results = 'Your .env file settings has been updated';

        try {
            setEnvironmentValue([
                'CACHE_DRIVER' => 'database',
                'SESSION_DRIVER' => 'database',
            ]);
        } catch (Exception $exception) {
            $results = 'Unable to save the .env file, Please create it manually.';
        }

        return $results;
    }
}
