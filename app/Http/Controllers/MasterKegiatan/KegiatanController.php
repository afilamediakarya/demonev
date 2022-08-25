<?php

namespace App\Http\Controllers\MasterKegiatan;

use App\Http\Controllers\Controller;

class KegiatanController extends Controller
{
    public function index()
    {
        return view('master_kegiatan/kegiatan');
    }

}
