<?php

namespace App\Http\Controllers\MasterKegiatan;

use App\Http\Controllers\Controller;

class SubKegiatanController extends Controller
{
    public function index()
    {
        return view('master_kegiatan/sub_kegiatan');
    }

}
