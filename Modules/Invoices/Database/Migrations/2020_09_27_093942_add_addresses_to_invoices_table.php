<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAddressesToInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->string('billing_street')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_zip')->nullable();
            $table->string('billing_country')->nullable();
            $table->string('shipping_street')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('shipping_zip')->nullable();
            $table->string('shipping_country')->nullable();
            $table->tinyInteger('show_shipping_on_invoice')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->dropColumn('billing_street');
            $table->dropColumn('billing_city');
            $table->dropColumn('billing_state');
            $table->dropColumn('billing_zip');
            $table->dropColumn('billing_country');
            $table->dropColumn('shipping_street');
            $table->dropColumn('shipping_city');
            $table->dropColumn('shipping_state');
            $table->dropColumn('shipping_zip');
            $table->dropColumn('shipping_country');
            $table->dropColumn('show_shipping_on_invoice');
        });
    }
}
