<?php

use Illuminate\Database\Migrations\Migration;
use Modules\Contracts\Entities\Clause;
use Modules\Contracts\Entities\ContractTemplate;

class MoveClausesToTemplates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (ContractTemplate::count() <= 0) {
            $clauses  = Clause::orderByRaw('FIELD(id,11,26,1,27,6,20,5,18,17,23,25,3,21,12,13,7,22,10,4,14,2,30,8,15,19,28,16,9,29,24)')->get();
            $template = ContractTemplate::create([
                'name' => 'Sample Contract',
            ]);
            $str = '';
            foreach ($clauses as $clause) {
                $str .= '<h3 class="pb15"><strong>' . humanize($clause->name) . '</strong></h3>';
                $str .= '<p>' . $clause->clause . '</p>';
            }
            $template->body = $str;
            $template->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
