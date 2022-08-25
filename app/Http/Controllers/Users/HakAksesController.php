<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;

class HakAksesController extends Controller
{
    public function index()
    {
        return view('users/hak_akses');
    }

}
