<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profession;

class ProfessionController extends Controller
{
    //
    public function create($data)
    {
        $newProfession = new Profession;
        $newProfession->profession_name = $data['profession_name'];
        $newProfession->role = $data['role'];
        $newProfession->save();
    }
}
