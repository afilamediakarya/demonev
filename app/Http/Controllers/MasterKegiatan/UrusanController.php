<?php

namespace App\Http\Controllers\MasterKegiatan;

use App\Http\Controllers\Controller;

class UrusanController extends Controller
{
    public function index()
    {
        return view('master_kegiatan/urusan');
    }

}
