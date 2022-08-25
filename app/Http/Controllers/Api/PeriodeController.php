<?php

namespace App\Http\Controllers\Api;

use App\Services\PeriodeServices;

class PeriodeController extends ApiController
{
    public function __construct(PeriodeServices $services)
    {
        parent::__construct($services);
    }
}
