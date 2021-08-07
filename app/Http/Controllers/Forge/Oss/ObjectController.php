<?php

namespace App\Http\Controllers\Forge\Oss;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\Autodesk\DataManagement;

class ObjectController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dataManagement = new DataManagement();
        return $dataManagement->uploadFile();
    }
}
