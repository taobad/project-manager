<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupportController extends Controller
{
    public function ticket()
    {
        return view('modal.support');
    }

    public function catpro($id){
        $category['data'] = DB::table('profession_role')->where('role_id', $id)->get();
        return response()->json($category);
    }

    public function team($profession){
        $users['data'] = DB::table('users')->where('profession', $profession)->get();
        return response()->json($users);
    }
}
