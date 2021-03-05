<?php

use Illuminate\Database\Migrations\Migration;

class AddPdfEngine extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        update_option('pdf_engine', 'invoicr');
        update_option('gocardless_live', 'LIVE');
        update_option('gocardless_pub_key', '');
        update_option('gocardless_token', '');
        update_option('gocardless_webhook_secret', '');
        update_option('show_estimate_item_discount', 'TRUE');
        update_option('show_invoice_item_discount', 'TRUE');
        update_option('show_tax_number', 'TRUE');
        update_option('ticket_only_registered_users', 'TRUE');
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
