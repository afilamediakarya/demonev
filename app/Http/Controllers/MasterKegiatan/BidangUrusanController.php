<?php

namespace App\Http\Controllers\MasterKegiatan;

use App\Http\Controllers\Controller;

class BidangUrusanController extends Controller
{
    public function index()
    {
        return view('master_kegiatan/bidang_urusan');
    }

}
