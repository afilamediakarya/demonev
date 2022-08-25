<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;

class DaftarPegawaiController extends Controller
{
    public function index()
    {
        return view('users/daftar_pegawai');
    }

}
