<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;

class KecamatanController extends Controller
{
    public function index()
    {
        return view('master/kecamatan');
    }
}
