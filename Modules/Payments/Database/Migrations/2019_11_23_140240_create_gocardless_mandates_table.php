<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGocardlessMandatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gocardless_mandates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('invoice_id');
            $table->integer('client_id');
            $table->string('gocardless_flow_id')->nullable();
            $table->string('gocardless_mandate')->nullable();
            $table->string('gocardless_customer')->nullable();
            $table->string('idempotency_key')->nullable();
            $table->string('payment_id')->nullable();
            $table->integer('amount')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('gocardless_mandates');
    }
}
