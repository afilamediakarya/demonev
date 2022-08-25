<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;

class JenisBelanjaController extends Controller
{
    public function index()
    {
        return view('master/jenis_belanja');

    }

}
