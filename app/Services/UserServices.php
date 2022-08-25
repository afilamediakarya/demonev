<?php


namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Validator;

class UserServices extends BaseServices
{
    protected $allowSearch = [

    ];
    protected $hasPassword = true;

    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'nama_lengkap' => ($id ? 'filled' : 'required'),
            'username' => ($id ? 'filled' : 'required') . '|unique:user,username' . ($id ? ',' . $id : ''),
            'password' => ($id ? 'filled' : 'required') . '|confirmed',
//            'id_pegawai' => '',
            'nip' => '',
            'jabatan' => '',
            'no_telp' => '',
            'id_unit_kerja' => '',
            'id_role' => ($id ? 'filled' : 'required'),
            'status' => ($id ? 'filled' : 'required'),
        ];
    }

    public function rulesWithUuid($uuid = null)
    {
        return [
            'uuid' => 'nullable',
            'nama_lengkap' => ($uuid ? 'filled' : 'required'),
            'username' => ($uuid ? 'filled' : 'required') . '|unique:user,username' . ($uuid ? ',' . $uuid . ',uuid' : ''),
            'password' => ($uuid ? '' : 'required') . '|confirmed',
//            'id_pegawai' => '',
            'nip' => '',
            'jabatan' => '',
            'no_telp' => '',
            'id_unit_kerja' => '',
            'id_role' => ($uuid ? 'filled' : 'required'),
            'status' => ($uuid ? 'filled' : 'required'),
        ];
    }

    private function rulesUpdate(){
        $id = auth()->user()->id;
        return [
            'username' => 'required|unique:user,username,'.$id,
            'nama_lengkap' => 'required',
            'nip' => '',
            'old_password' => 'nullable|password:api',
            'password' => 'confirmed'
        ];
    }

    public function validateUpdate(array $attribute){
        return Validator::make($attribute,$this->rulesUpdate(),$this->ruleMessages);
    }
}
