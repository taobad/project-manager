<?php

namespace Modules\Deals\Helpers;

use Modules\Deals\Entities\Deal;

class DealCsvProcessor
{
    /**
     * Import deals from CSV.
     */
    public function import(\Illuminate\Http\Request $request)
    {
        $data = \App\Entities\CsvData::where('id', $request->csv_data_file_id)->first();
        $jsonStream = \JsonMachine\JsonMachine::fromString($data->csv_data);
        foreach ($jsonStream as $row) {
            $column = [];
            foreach ($request->fields as $csvfield => $dbfield) {
                if (!is_null($dbfield)) {
                    if (in_array($dbfield, config('db-fields.deal'))) {
                        $column[$dbfield] = $row[$csvfield];
                    }
                }
            }
            $column['status'] = strtolower($column['status']);
            $column['user_id'] = \Auth::id();
            $column['due_date'] = now()->parse($column['due_date'])->format(config('system.preferred_date_format'));
            $column['won_time'] = is_null($column['won_time']) ? null : now()->parse($column['won_time']);
            $column['lost_time'] = is_null($column['lost_time']) ? null : now()->parse($column['lost_time']);
            Deal::firstOrCreate(['title' => $column['title']], $column);
        }
    }
}
