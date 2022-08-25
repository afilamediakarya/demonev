<?php

namespace App\Http\Controllers\MasterKegiatan;

use App\Http\Controllers\Controller;

class ProgramController extends Controller
{
    public function index()
    {
        return view('master_kegiatan/program');
    }

}
