<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\Tickets\Entities\Ticket;

class AddResponseStatusToTickets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('tickets', 'response_status')) {
            Schema::table('tickets', function (Blueprint $table) {
                $table->string('response_status')->default('awaiting_agent');
            });
            foreach (Ticket::get() as $ticket) {
                $ticket->afterModelSaved();
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
        Schema::table('tickets', function (Blueprint $table) {
            $table->dropColumn('response_status');
        });
    }
}
