<?php

namespace App\Http\Controllers\Api;

use App\Services\RealisasiServices;

class RealisasiController extends ApiController
{
    public function __construct(RealisasiServices $services)
    {
        parent::__construct($services);
    }
}
