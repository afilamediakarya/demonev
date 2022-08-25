<?php

namespace App\Http\Controllers\Pengaturan;

use App\Http\Controllers\Controller;

class AkunController extends Controller
{
    public function index()
    {
        return view('pengaturan/akun');
    }

}
