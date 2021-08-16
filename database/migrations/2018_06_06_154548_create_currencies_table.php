<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Migration auto-generated by Sequel Pro Laravel Export
 * @see https://github.com/cviebrock/sequel-pro-laravel-export
 */
class CreateCurrenciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('currencies', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 10)->nullable();
            $table->string('title', 100)->nullable();
            $table->string('symbol', 64)->nullable();
            $table->string('native', 64)->nullable();
            $table->string('thousands_sep', 10)->default(',');
            $table->string('decimal_sep', 10)->default('.');
            $table->tinyInteger('symbol_left')->default(1);
            $table->tinyInteger('space_between')->default(0);
            $table->integer('exp')->default(2);
            $table->decimal('xrate', 12, 5)->default(0.00000);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('currencies');
    }
}
