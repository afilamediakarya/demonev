<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Models\SubTahapan;
use App\Services\TahapanServices;

class TahapanController extends ApiController
{
    public function __construct(TahapanServices $services)
    {
        parent::__construct($services);
    }

    public function getSubTahapan($tahapan)
    {
        $sub_tahapan = SubTahapan::whereHas('Tahapan', function ($query) use ($tahapan) {
            $query->where('tahapan', $tahapan);
        })->get();
        return Response::json($sub_tahapan);
    }
}
