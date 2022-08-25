<?php


namespace App\Services;

use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleServices extends BaseServices
{
    protected $allowSearch = [

    ];

    protected $relation = [
        'Akses'
    ];

    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'nama_role' => ($id ? 'filled' : 'required') . '|unique:role,nama_role' . ($id ? ',' . $id : ''),
            'deskripsi' => 'nullable',
            'akses' => 'array',
        ];
    }

    public function rulesWithUuid($uuid = null)
    {
        return [
            'uuid' => 'nullable',
            'nama_role' => ($uuid ? 'filled' : 'required') . '|unique:role,nama_role' . ($uuid ? ',' . $uuid . ',uuid' : ''),
            'deskripsi' => 'nullable',
            'akses' => 'array',
        ];
    }

    public function create(array $attributes)
    {
        DB::beginTransaction();
        try {
            $role = parent::create($attributes);
            $role->Akses()->detach();
            if (isset($attributes['akses']))
                $role->Akses()->attach($attributes['akses']);
            DB::commit();
            return $role;
        } catch (\Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
