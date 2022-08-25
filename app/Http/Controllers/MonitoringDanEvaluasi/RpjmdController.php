<?php

namespace App\Http\Controllers\MonitoringDanEvaluasi;

use App\Http\Controllers\Controller;

class RpjmdController extends Controller
{
    public function index()
    {
        return view('monitoring/rpjmd');
    }

    public function aturRpjmd()
    {
        return view('monitoring/atur_rpjmd');
    }
}
