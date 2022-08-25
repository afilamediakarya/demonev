<?php

namespace App\Http\Controllers\Pengaturan;

use App\Http\Controllers\Controller;
use App\Models\ProfileDaerah;

class ProfileDaerahController extends Controller
{
    public function index()
    {
        if (!$profile = ProfileDaerah::first()){
            $profile = new ProfileDaerah();
        }
        return view('pengaturan/profile_daerah',compact('profile'));
    }

}
