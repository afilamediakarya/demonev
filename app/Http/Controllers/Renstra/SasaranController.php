<?php

namespace App\Http\Controllers\Renstra;

use App\Http\Controllers\Controller;

class SasaranController extends Controller
{
    public function index()
    {
        $id_unit_kerja=auth()->user()->id_unit_kerja;
        return view('master_kegiatan/sasaran',compact(('id_unit_kerja')));
    }

}
