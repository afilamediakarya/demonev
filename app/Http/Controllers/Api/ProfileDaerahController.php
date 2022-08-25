<?php

namespace App\Http\Controllers\Api;

use App\Models\ProfileDaerah;
use App\Services\ProfileDaerahServices;
use Illuminate\Http\Request;

class ProfileDaerahController extends ApiController
{
    public function __construct(ProfileDaerahServices $services)
    {
        parent::__construct($services);
    }

    public function create(Request $request)
    {
        if ($profile = ProfileDaerah::first()){
            return parent::update($request,$profile->id);
        }
        return parent::create($request);
    }
}
