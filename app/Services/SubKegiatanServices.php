<?php


namespace App\Services;

use App\Models\BidangUrusan;
use App\Models\Kegiatan;
use App\Models\Program;
use App\Models\SubKegiatan;
use App\Models\Urusan;

class SubKegiatanServices extends BaseServices
{
    protected $allowSearch = [

    ];

    public function __construct(SubKegiatan $model)
    {
        $this->model = $model;
    }

    public function rules($id = null): array
    {
        return [
            'uuid' => 'nullable',
            'kode_sub_kegiatan' => ($id ? 'filled' : 'required'),
            'nama_sub_kegiatan' => ($id ? 'filled' : 'required'),
            'indikator' => ($id ? 'filled' : 'required'),
            'kinerja' => ($id ? 'filled' : 'required'),
            'satuan' => ($id ? 'filled' : 'required'),
            'id_kegiatan' => ($id ? 'filled' : 'required'),
            'tahun' => ($id ? 'filled' : 'required') . '|numeric',
        ];
    }

    public function generateKode(array $attributes)
    {
        if (isset($attributes['uuid']) && $attributes['uuid'] != '') {
            $sub_kegiatan = $this->model->where('id_kegiatan', $attributes['id_kegiatan'])->whereUuid($attributes['uuid'])->first();
            if ($sub_kegiatan)
                return [
                    'kode_sub_kegiatan' => $sub_kegiatan->kode_sub_kegiatan
                ];
        }
        $kode_urusan = optional(Urusan::find($attributes['id_urusan']))->kode_urusan;
        $kode_bidang_urusan = optional(BidangUrusan::find($attributes['id_bidang_urusan']))->kode_bidang_urusan;
        $kode_program = optional(Program::find($attributes['id_program']))->kode_program;
        $kode_kegiatan = optional(Kegiatan::find($attributes['id_kegiatan']))->kode_kegiatan;
        $count = SubKegiatan::where('id_kegiatan', $attributes['id_kegiatan'])->where('tahun', $attributes['tahun'])->count() + 1;
        $kode_sub_kegiatan = str_pad($count, 2, "0", STR_PAD_LEFT);
        return [
            'kode_sub_kegiatan' => "$kode_urusan.$kode_bidang_urusan.$kode_program.$kode_kegiatan.$kode_sub_kegiatan"
        ];
    }
}
