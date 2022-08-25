<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Services\BaseServices;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    protected $services;

    public function __construct(BaseServices $services)
    {
        $this->services = $services;
    }

    public function get()
    {
        return Response::json($this->services->get());
    }

    public function find($id)
    {
        return Response::json($this->services->find($id));
    }

    public function findByUuid($uuid)
    {
        return Response::json($this->services->findByUuid($uuid));
    }

    public function create(Request $request)
    {
     
        $validate = $this->services->validate($request->all());
        if ($validate->fails()) {
            return Response::validationError($validate->errors());
        }
        return Response::json($this->services->create($validate->validated()));
    }

    public function update(Request $request, $id)
    {
        $validate = $this->services->validate($request->all(), $id);
        if ($validate->fails()) {
            return Response::validationError($validate->errors());
        }
        return Response::successUpdate($this->services->update($id, $validate->validated()));
    }

    public function delete($id)
    {
        return Response::successDelete($this->services->delete($id));
    }

    public function deleteByUuid($uuid)
    {
        return Response::successDelete($this->services->deleteByUuid($uuid));
    }
}
