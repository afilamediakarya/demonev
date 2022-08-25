<?php

namespace App\Http\Controllers\MasterKegiatanDak;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubBidangDakController extends Controller
{
    public function index()
    {
        return view('master_kegiatan_dak.sub_bidang_dak.index');
    }
}
