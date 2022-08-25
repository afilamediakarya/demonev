<?php

namespace App\Http\Controllers\MasterKegiatanDak;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TematikDakController extends Controller
{
    public function index()
    {
        return view('master_kegiatan_dak.tematik_dak.index');
    }
}
