<?php

namespace Modules\Clients\Helpers;

use Modules\Clients\Entities\Client;
use Modules\Users\Entities\User;

class ClientsCsvProcessor
{
    /**
     * Import Contacts from CSV.
     */
    public function import(\Illuminate\Http\Request $request)
    {
        $data       = \App\Entities\CsvData::where('id', $request->csv_data_file_id)->first();
        $jsonStream = \JsonMachine\JsonMachine::fromString($data->csv_data);
        foreach ($jsonStream as $row) {
            $column = [];
            $client = new Client;
            foreach ($request->fields as $csvfield => $dbfield) {
                if (!is_null($dbfield)) {
                    if (in_array($dbfield, config('db-fields.client'))) {
                        $column[$dbfield] = $row[$csvfield];
                    }
                }
            }
            $contactEmail  = isset($column['contact_email']) ? $column['contact_email'] : 'NULL';
            $contactPerson = isset($column['contact_person']) ? $column['contact_person'] : 'NULL';
            unset($column['contact_email']);
            unset($column['contact_person']);
            $company = $client->firstOrCreate(['email' => $column['email']], $column);
            if (filter_var($contactEmail, FILTER_VALIDATE_EMAIL)) {
                $user = User::firstOrCreate(
                    ['email' => $contactEmail],
                    ['name' => $contactPerson]
                );
                $company->update(['primary_contact' => $user->id]);
                $user->profile()->update(['company' => $company->id]);
            }
        }
    }
}
