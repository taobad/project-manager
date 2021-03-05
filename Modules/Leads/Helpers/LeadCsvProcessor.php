<?php

namespace Modules\Leads\Helpers;

use Modules\Leads\Entities\Lead;

class LeadCsvProcessor
{
    /**
     * Import leads from CSV.
     */
    public function import(\Illuminate\Http\Request $request)
    {
        session(['lock_assigned_alert' => true]);
        $data = \App\Entities\CsvData::where('id', $request->csv_data_file_id)->first();
        $jsonStream = \JsonMachine\JsonMachine::fromString($data->csv_data);
        foreach ($jsonStream as $row) {
            $column = [];
            foreach ($request->fields as $csvfield => $dbfield) {
                if (!is_null($dbfield)) {
                    if (in_array($dbfield, config('db-fields.lead'))) {
                        $column[$dbfield] = $row[$csvfield];
                    }
                }
            }
            Lead::firstOrCreate(['email' => $column['email']], $column);
        }
        session(['lock_assigned_alert' => false]);
    }
}
