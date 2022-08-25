<?php

namespace App\Http\Controllers\MasterKegiatanDak;

use App\Http\Controllers\Controller;

class BidangDakController extends Controller
{
    public function index()
    {
        return view('master_kegiatan_dak.bidang_dak.index');
    }
}
