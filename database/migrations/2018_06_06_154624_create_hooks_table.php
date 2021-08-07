<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration auto-generated by Sequel Pro Laravel Export
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateHooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hooks', function (Blueprint $table) {
            $table->string('module', 128);
            $table->string('parent', 128)->nullable();
            $table->string('hook', 128);
            $table->string('icon', 100)->nullable();
            $table->string('name', 100);
            $table->string('route', 255)->nullable();
            $table->tinyInteger('order')->nullable();
            $table->tinyInteger('access');
            $table->integer('core')->nullable();
            $table->integer('visible')->default(1);
            $table->string('permission', 255)->nullable();
            $table->tinyInteger('enabled')->default(1);
            $table->timestamp('last_run')->useCurrent();

            // $table->primary(['module']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hooks');
    }
}
