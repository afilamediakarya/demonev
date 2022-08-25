<?php

namespace App\Http\Controllers\Pengaturan;

use App\Http\Controllers\Controller;

class BackupReportController extends Controller
{
    public function index()
    {
        return view('pengaturan/backup_report');
    }

}
