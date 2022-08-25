<?php


namespace App\Services;

use App\Models\Pegawai;
use App\Models\PegawaiPenanggungJawab;

class PegawaiServices extends BaseServices
{
    protected $allowSearch = [

    ];

    protected $relation = [
        'UnitKerja'
    ];

    public function __construct(Pegawai $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'nama' => $id ? 'filled' : 'required',
            'nip' => ($id ? 'filled' : 'required') . '|unique:pegawai,nip' . ($id ? ',' . $id : ''),
            'jabatan' => 'nullable',
            'alamat' => 'nullable',
            'tempat_lahir' => 'nullable',
            'tanggal_lahir' => 'nullable|date',
            'no_telp' => 'nullable',
            'id_unit_kerja' => 'nullable',
        ];
    }

    public function rulesWithUuid($uuid = null)
    {
        return [
            'uuid' => 'nullable',
            'nama' => $uuid ? 'filled' : 'required',
            'nip' => ($uuid ? 'filled' : 'required') . '|unique:pegawai,nip' . ($uuid ? ',' . $uuid . ',uuid' : ''),
            'jabatan' => 'nullable',
            'alamat' => 'nullable',
            'tempat_lahir' => 'nullable',
            'tanggal_lahir' => 'nullable|date',
            'no_telp' => 'nullable',
            'id_unit_kerja' => 'nullable',
        ];
    }

    public function get()
    {
        if (request()->has('penanggung_jawab')) {
            $penanggung_jawab = PegawaiPenanggungJawab::where(function ($q) {
                if (request()->has('uuid')) {
                    $q->where('uuid', '!=', request('uuid'));
                }

            })->pluck('id_pegawai')->toArray();
            $this->model = $this->model
                ->whereNotIn('id', $penanggung_jawab)
                ->where(function ($q) {
                    if (auth()->check()) {
                        if (auth()->user()->hasRole('opd')) {
                            if ($pegawai = auth()->user()) {
                                $id_unit_kerja = optional($pegawai->UnitKerja)->id;
                                $q->where('id_unit_kerja', $id_unit_kerja);
                            }
                        }
                    }
                });
        }
        return parent::get();
    }
}
