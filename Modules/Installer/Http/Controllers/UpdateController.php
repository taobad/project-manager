<?php

namespace Modules\Installer\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Installer\Helpers\DatabaseManager;
use Modules\Installer\Helpers\InstalledFileManager;

class UpdateController extends Controller
{

    /**
     * Display the updater welcome page.
     *
     * @return \Illuminate\View\View
     */
    public function welcome()
    {
        return view('installer::update.welcome');
    }

    /**
     * Display the updater overview page.
     *
     * @return \Illuminate\View\View
     */
    public function overview()
    {
        $migrations   = $this->getMigrations();
        $dbMigrations = $this->getExecutedMigrations();

        return view('installer::update.overview', ['numberOfUpdatesPending' => count($migrations) - count($dbMigrations)]);
    }

    /**
     * Migrate and seed the database.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function database()
    {
        $databaseManager = new DatabaseManager;
        $response        = $databaseManager->migrateAndSeed();

        return redirect()->route('LaravelUpdater::final')
            ->with(['message' => $response]);
    }

    /**
     * Update installed file and display finished view.
     *
     * @param  InstalledFileManager $fileManager
     * @return \Illuminate\View\View
     */
    public function finish(InstalledFileManager $fileManager)
    {
        $fileManager->update();

        return view('installer::update.finished');
    }
}
