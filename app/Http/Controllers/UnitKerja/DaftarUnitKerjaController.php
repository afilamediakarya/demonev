<?php

namespace App\Http\Controllers\UnitKerja;

use App\Http\Controllers\Controller;

class DaftarUnitKerjaController extends Controller
{
    public function index()
    {
        return view('unit_kerja/daftar_unit_kerja');
    }


}
