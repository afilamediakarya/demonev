<?php

use App\Models\Jadwal;

if (!function_exists('hasAkses')) {
    function hasAkses($akses)
    {
        if (auth()->check()) {
            return auth()->user()->hasAkses($akses);
        }
        return false;
    }
}

if (!function_exists('hasRole')) {
    function hasRole($role)
    {
        if (auth()->check()) {
            return auth()->user()->hasRole($role);
        }
        return false;
    }
}
if (!function_exists('integerToRoman')) {
    function integerToRoman($integer)
    {
        // Convert the integer into an integer (just to make sure)
        $integer = intval($integer);
        $result = '';

        // Create a lookup array that contains all of the Roman numerals.
        $lookup = array('M' => 1000,
            'CM' => 900,
            'D' => 500,
            'CD' => 400,
            'C' => 100,
            'XC' => 90,
            'L' => 50,
            'XL' => 40,
            'X' => 10,
            'IX' => 9,
            'V' => 5,
            'IV' => 4,
            'I' => 1);

        foreach ($lookup as $roman => $value) {
            // Determine the number of matches
            $matches = intval($integer / $value);

            // Add the same number of characters to the string
            $result .= str_repeat($roman, $matches);

            // Set the integer to be the remainder of the integer and the value
            $integer = $integer % $value;
        }

        // The Roman numeral should be built, return it
        return $result;
    }
}
if (!function_exists('cekJadwal')) {
    function cekJadwal($tahapan, $sub_tahapan)
    {
        if (Jadwal::where('tahapan', $tahapan)
            ->where('sub_tahapan', $sub_tahapan)
            ->whereDate('jadwal_mulai', '<=', now())
            ->whereDate('jadwal_selesai', '>=', now())
            ->first()) {
            return true;
        }
        return false;
    }
}

if (!function_exists('cekJadwalInput')) {
    function cekJadwalInput(...$check)
    {
        foreach ($check AS $c) {
            $guard = explode('|',$c);
            if (count($guard) == 2) {
                if (Jadwal::where('tahapan', $guard[0])
                    ->where('sub_tahapan', $guard[1])
                    ->whereDate('jadwal_mulai', '<=', now())
                    ->whereDate('jadwal_selesai', '>=', now())
                    ->first()) {
                    return true;
                }
            }
        }
        return false;
    }
}
if (!function_exists('numberToCurrency')){
    function numberToCurrency($number){
        return number_format($number,0,',','.');
    }
}
if (!function_exists('pembulatanDuaDecimal')){
    function pembulatanDuaDecimal($angka,$format = 1){
        if ($format === 1)
        return number_format($angka,2,',','.');
        if ($format === 2)
            return number_format($angka,2);
    }
}
if (!function_exists('tgl_indo')){
    function tglIndo($tanggal){
        $hari = [
            'Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'
        ];
        $bulan = array (
            1 =>   'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $pecahkan = explode('/', $tanggal);
        $weekday = date('w',strtotime(date($pecahkan[2].'-'.$pecahkan[1].'-'.$pecahkan[0])));
        // variabel pecahkan 0 = tanggal
        // variabel pecahkan 1 = bulan
        // variabel pecahkan 2 = tahun

        return $hari[$weekday].' '.$pecahkan[0] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[2];
    }
}
