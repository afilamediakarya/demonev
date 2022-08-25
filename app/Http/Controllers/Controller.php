<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        session(['tahun_penganggaran' => date('Y')]);
    }

    public function setTahunAnggaran()
    {
        session(['tahun_penganggaran' => request('tahun', date('Y'))]);
        return redirect()->back();
    }
}
