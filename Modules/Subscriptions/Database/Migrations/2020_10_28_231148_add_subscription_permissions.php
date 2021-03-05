<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class AddSubscriptionPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $permissions = [
            'subscriptions_send' => 'Allow user to send subscriptions to customers',
            'subscriptions_update' => 'Allow user to modify subscriptions',
            'subscriptions_delete' => 'Allow user to delete subscriptions',
            'subscriptions_all' => 'Allow user to view all subscriptions',
        ];
        $admin = Role::where(['name' => 'admin'])->first();
        if (isset($admin->id)) {
            foreach ($permissions as $name => $description) {
                $perm = Permission::firstOrCreate(['name' => $name], ['description' => $description]);
                $admin->givePermissionTo($perm->name);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
