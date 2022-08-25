<?php

namespace App\Http\Controllers\UnitKerja;

use App\Http\Controllers\Controller;
use App\Models\UnitKerja;

class ProfilUnitKerjaController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $unit_kerja = UnitKerja::with('BidangUrusan')->where(function ($q) {
                if (hasRole('opd'))
                    if ($user = auth()->user()) {
                        $q->where('id', $user->id_unit_kerja);
                    }
            })->get();
        }
        return view('unit_kerja/profil_unit_kerja', compact('unit_kerja'));
    }


}
