<?php

namespace App\Http\Controllers\Api;

use App\Services\JabatanServices;

class JabatanController extends ApiController
{
    public function __construct(JabatanServices $services)
    {
        parent::__construct($services);
    }
}
