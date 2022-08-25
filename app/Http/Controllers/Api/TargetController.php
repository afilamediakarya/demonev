<?php

namespace App\Http\Controllers\Api;

use App\Services\TargetServices;

class TargetController extends ApiController
{
    public function __construct(TargetServices $services)
    {
        parent::__construct($services);
    }
}
