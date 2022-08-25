<?php

namespace App\Http\Controllers\MonitoringDanEvaluasi;

use App\Http\Controllers\Controller;

class RkpdController extends Controller
{
    public function index()
    {
        return view('monitoring/rkpd');
    }

    public function aturRkpd()
    {
        return view('monitoring/atur_rkpd');
    }
}
