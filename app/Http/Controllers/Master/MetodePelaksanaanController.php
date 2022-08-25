<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;

class MetodePelaksanaanController extends Controller
{
    public function index()
    {
        return view('master/metode_pelaksanaan');
    }

}
