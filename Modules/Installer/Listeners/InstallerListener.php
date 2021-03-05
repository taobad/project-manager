<?php

namespace Modules\Installer\Listeners;

use Exception;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Modules\Users\Entities\User;

class InstallerListener
{

    /**
     * Handle the event.
     *
     * @param  object $event
     * @return void
     */
    public function handle($event)
    {
        Artisan::call('passport:install');

        DB::beginTransaction();
        try {
            $user = User::create(cache()->get('user_account'));
            $user->profile->update(cache()->get('profile_account'));
            DB::commit();
            $user->syncRoles('admin');
        } catch (Exception $exception) {
            DB::rollBack();
        }
        try {
            Artisan::call('storage:link');
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
        }
    }
}
