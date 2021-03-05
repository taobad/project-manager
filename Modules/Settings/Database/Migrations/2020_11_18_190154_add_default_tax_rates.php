<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Cache;

class AddDefaultTaxRates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        update_option('default_tax_rates', '[null]');
        update_option('company_address_format', "{company_name}\n {street}\n {city} {state}\n {country_code} {zip}\n {phone}\n {tax_number}");
        Cache::forget(settingsCacheName());
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
