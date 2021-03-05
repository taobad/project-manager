<?php

use App\Entities\Hook;
use Illuminate\Database\Migrations\Migration;

class AddModulesSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Hook::create([
            'module' => 'settings_module',
            'parent' => '',
            'hook' => 'settings_menu_admin',
            'icon' => 'fas fa-layer-group',
            'name' => 'module_settings',
            'route' => 'modules',
            'order' => 11,
            'access' => 1,
            'core' => 1,
            'visible' => 1,
            'permission' => '',
            'enabled' => 1,
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Hook::where('name', 'module_settings')->delete();
    }
}
