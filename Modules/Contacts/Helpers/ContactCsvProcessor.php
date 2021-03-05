<?php

namespace Modules\Contacts\Helpers;

use Modules\Users\Entities\User;

class ContactCsvProcessor
{
    /**
     * Import Contacts from CSV.
     */
    public function import(\Illuminate\Http\Request $request)
    {
        $data = \App\Entities\CsvData::where('id', $request->csv_data_file_id)->first();
        $jsonStream = \JsonMachine\JsonMachine::fromString($data->csv_data);
        foreach ($jsonStream as $row) {
            $column = [];
            $user = new User;
            foreach ($request->fields as $csvfield => $dbfield) {
                if (!is_null($dbfield)) {
                    if (in_array($dbfield, config('db-fields.contact'))) {
                        $column[$dbfield] = $row[$csvfield];
                    }
                }
            }
            $user->unsetEventDispatcher();
            $user->firstOrCreate(
                [
                        'email' => $column['email']
                    ],
                [
                    'username' => $column['email'],
                    'email' => $column['email'],
                    'created' => now(),
                    'last_login' => now(),
                    ]
            );
            unset($column['email']);
            unset($column['name']);
            $user->profile()->update($column);
        }
    }
}
