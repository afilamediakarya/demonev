<?php

namespace App\Http\Controllers\Api;

use App\Services\SubTahapanServices;

class SubTahapanController extends ApiController
{
    public function __construct(SubTahapanServices $services)
    {
        parent::__construct($services);
    }
}
