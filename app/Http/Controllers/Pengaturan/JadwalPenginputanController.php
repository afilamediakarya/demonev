<?php

namespace App\Http\Controllers\Pengaturan;

use App\Http\Controllers\Controller;

class JadwalPenginputanController extends Controller
{
    public function index()
    {
        return view('pengaturan/jadwal_penginputan');
    }

}
