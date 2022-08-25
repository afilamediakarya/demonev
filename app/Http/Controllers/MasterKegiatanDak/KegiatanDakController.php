<?php

namespace App\Http\Controllers\MasterKegiatanDak;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class KegiatanDakController extends Controller
{
    public function index()
    {
        return view('master_kegiatan_dak.kegiatan_dak.index');
    }
}
