<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTaxPerItemToInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('invoices', function (Blueprint $table) {
            $table->tinyInteger('tax_per_item')->default(0);
            $table->tinyInteger('discount_per_item')->default(0);
            $table->text('tax_types')->nullable();
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
            $table->dropColumn('tax_per_item');
            $table->dropColumn('discount_per_item');
            $table->dropColumn('tax_types');
        });
    }
}
