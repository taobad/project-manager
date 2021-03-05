<?php
namespace App\Seeders;

use Illuminate\Database\Seeder;

class ContractTemplateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = storage_path() . "/json/clauses.json";
        $arr  = getArrFromJson($path);
        $str  = '';
        foreach ($arr['data'] as $key => $value) {
            $str .= '<h3 class="pb15"><strong>' . humanize($value['name']) . '</strong></h3>';
            $str .= '<p>' . $value['clause'] . '</p>';
        }
        \DB::table('contract_templates')->insert(
            [
                'name' => 'Standard Contract',
                'body' => $str,
            ]
        );
    }
}
