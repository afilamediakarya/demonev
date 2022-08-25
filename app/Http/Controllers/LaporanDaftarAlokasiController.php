<?php

namespace App\Http\Controllers;

use App\Models\BackupReport;
use App\Models\BidangUrusan;
use App\Models\JenisBelanja;
use App\Models\MetodePelaksanaan;
use App\Models\ProfileDaerah;
use App\Models\SumberDana;
use App\Models\Kecamatan;
use App\Models\Desa;
use App\Models\UnitKerja;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\DB;


class LaporanDaftarAlokasiController extends Controller
{

    public function findByKecamatan($params){
        $data = Desa::select('id','nama')->where('id_kecamatan',$params)->get();
        return $data;
    }

    public function index()
    {
        $unit_kerja_selected = $metode_pelaksanaan_selected = $jenis_belanja_selected = $tabel = '';
        $sumber_dana = SumberDana::get();
        $unit_kerja = UnitKerja::where(function ($q) {
            if (hasRole('opd'))
                $q->where('id', auth()->user()->id_unit_kerja);
        })->get();
        $jenis_belanja = JenisBelanja::get();
        $kecamatan = Kecamatan::get();
        $desa = Desa::orderBy('nama','ASC')->get();
        $metode_pelaksanaan = MetodePelaksanaan::get();
        $sumber_dana_selected = request('sumber_dana', '');
        $kecamatan_selected = request('kecamatan', '');
        $desa_selected = request('desa', '');
        if (hasRole('admin')) {
            $unit_kerja_selected = request('unit_kerja', '');
        } else if (hasRole('opd')) {
            $unit_kerja_selected = auth()->user()->id_unit_kerja;
        }

        

        $periode_selected = request('periode', '');
        $jenis_belanja_selected = request('jenis_belanja', '');
        $metode_pelaksanaan_selected = request('metode_pelaksanaan', '');
        $tahun = session('tahun_penganggaran','');
        $data = array();
        $total_pagu_keseluruhan = 0;
        $total_realisasi_keuangan = 0;

        $where="";
        $where_paket="";
        $where_unit_kerja="";
         
        if(!empty($unit_kerja_selected)){
            $where_unit_kerja.=" AND id='$unit_kerja_selected'";
        }
        if(!empty($sumber_dana_selected)){
            if ($sumber_dana_selected !== '-') {
                $where.=" AND sumber_dana_dpa.sumber_dana='$sumber_dana_selected'";  
            }
            
        }
        if(!empty($desa_selected)){
            $where_paket.=" AND desa.id='$desa_selected'";
        }
        if(!empty($kecamatan_selected)){
            $where_paket.=" AND kecamatan.id='$kecamatan_selected'";
        }
        

        if ($sumber_dana_selected !== '') {
            $data = DB::table('unit_kerja')->select('id','nama_unit_kerja')->whereRaw("id<>'' $where_unit_kerja")->get();
         
         foreach($data as $unit_kerja_list){
            $unit_kerja_list->Dpa=DB::table('dpa')
            ->join('sub_kegiatan', 'dpa.id_sub_kegiatan', '=', 'sub_kegiatan.id')
            ->join('pegawai_penanggung_jawab', 'dpa.id_pegawai_penanggung_jawab', '=', 'pegawai_penanggung_jawab.id')
            ->select('dpa.id','dpa.nilai_pagu_dpa','sub_kegiatan.nama_sub_kegiatan','sub_kegiatan.kode_sub_kegiatan','pegawai_penanggung_jawab.nama_lengkap as ppk')
            ->where('dpa.tahun',$tahun)
            ->where('dpa.id_unit_kerja',$unit_kerja_list->id)
            ->get();

            foreach ( $unit_kerja_list->Dpa as $dpa ){
                
                $dpa->Paket1=DB::table('paket_dau')
                ->selectRaw("paket_dau.id,paket_dau.satuan,paket_dau.id_sumber_dana_dpa,paket_dau.nama_paket,paket_dau.volume,paket_dau.pagu,paket_dau.keterangan,@jenis_paket:='dau' as jenis_paket,sumber_dana_dpa.sumber_dana")
                ->join('sumber_dana_dpa','sumber_dana_dpa.id','=','paket_dau.id_sumber_dana_dpa')
                ->whereRaw("paket_dau.id_dpa='$dpa->id' $where");
                $dpa->Paket=DB::table('paket_dak')
                ->selectRaw("paket_dak.id,paket_dak.satuan,paket_dak.id_sumber_dana_dpa,paket_dak.nama_paket,paket_dak.volume,paket_dak.anggaran_dak as pagu,@keterangan:='' as keterangan,@jenis_paket:='dak' as jenis_paket,sumber_dana_dpa.sumber_dana")
                ->join('sumber_dana_dpa','sumber_dana_dpa.id','=','paket_dak.id_sumber_dana_dpa')
                ->whereRaw("paket_dak.id_dpa='$dpa->id' AND sumber_dana_dpa.jenis_belanja='Belanja Modal' $where")
                ->union($dpa->Paket1)->get();

                foreach($dpa->Paket as $paket){
                    if($paket->jenis_paket=='dau'){
                        $paket->Lokasi=DB::table('paket_dau_lokasi')
                        ->join('desa','paket_dau_lokasi.id_desa','=','desa.id')
                        ->join('kecamatan','desa.id_kecamatan','=','kecamatan.id')
                        ->select('desa.nama as nama_desa','kecamatan.nama as nama_kecamatan')
                        ->whereRaw("id_paket_dau='$paket->id' $where_paket")
                        ->get();
                    }else{
                        $paket->Lokasi=DB::table('paket_dak_lokasi')
                        ->join('desa','paket_dak_lokasi.id_desa','=','desa.id')
                        ->join('kecamatan','desa.id_kecamatan','=','kecamatan.id')
                        ->select('desa.nama as nama_desa','kecamatan.nama as nama_kecamatan')
                        ->whereRaw("id_paket_dak='$paket->id' $where_paket")
                        ->get();
                    }
                    $paket->Desa='';
                    $paket->Kecamatan='';
                    foreach($paket->Lokasi as $lokasi){
                        $paket->Desa.=$lokasi->nama_desa.'/';
                        $paket->Kecamatan=$lokasi->nama_kecamatan;

                    }
                }
            }

        }
            
      

        foreach ( $data as $unit_kerja_list ){
            $unit_kerja_list->subCount=0;
            $unit_kerja_list->Pagu=0;
            foreach ( $unit_kerja_list->Dpa as $dpa ){
                $dpa->Pagu=0;
                foreach($dpa->Paket as $paket){
                    if($paket->Desa=='' || $paket->Kecamatan==''){
                        $dpa->Pagu-=$paket->pagu;
                        $unit_kerja_list->subCount-=1;
                        $unit_kerja_list->Pagu-=$paket->pagu;
                     //    $unit_kerja_list->Desa .= $paket->Desa;
                    }else{
                        //$unit_kerja_list->subCount+=1;
                        //$unit_kerja_list->Pagu+=$paket->pagu;
                     //    $unit_kerja_list->Desa .= $paket->Desa;
                    }
                    $unit_kerja_list->subCount+=1;
                    $dpa->Pagu+=$paket->pagu;
                    $unit_kerja_list->Pagu+=$paket->pagu;
                }

            }
            //return $unit_kerja_list->Dpa;

        }

       
        
            $tabel = view('Laporan.tabel_daftar_alokasi.' . Str::slug( ($unit_kerja_selected ? ' index_dinas' : 'index_dinas'), '_'), compact('data', 'total_pagu_keseluruhan', 'total_realisasi_keuangan', 'sumber_dana_selected', 'periode_selected','desa','kecamatan','desa_selected','kecamatan_selected'))->render();
        }

       
        return view('Laporan/laporan_daftar_alokasi', compact('sumber_dana', 'unit_kerja', 'periode_selected', 'sumber_dana_selected', 'unit_kerja_selected', 'tabel', 'metode_pelaksanaan', 'jenis_belanja', 'metode_pelaksanaan_selected', 'jenis_belanja_selected','desa','kecamatan','desa_selected','kecamatan_selected'));
    }

    public function export($tipe)
    {

        $unit_kerja_selected = $metode_pelaksanaan_selected = $jenis_belanja_selected = $tabel = '';
        $sumber_dana = SumberDana::get();
        $unit_kerja = UnitKerja::where(function ($q) {
            if (hasRole('opd'))
                $q->where('id', auth()->user()->id_unit_kerja);
        })->get();
        $jenis_belanja = JenisBelanja::get();
        $kecamatan = Kecamatan::get();
        $desa = Desa::orderBy('nama','ASC')->get();
        $metode_pelaksanaan = MetodePelaksanaan::get();
        $sumber_dana_selected = request('sumber_dana', '');
        $kecamatan_selected = request('kecamatan', '');
        $desa_selected = request('desa', '');
        if (hasRole('admin')) {
            $unit_kerja_selected = request('unit_kerja', '');
        } else if (hasRole('opd')) {
            $unit_kerja_selected = auth()->user()->id_unit_kerja;
        }

        

        $periode_selected = request('periode', '');
        $jenis_belanja_selected = request('jenis_belanja', '');
        $metode_pelaksanaan_selected = request('metode_pelaksanaan', '');
        $tahun = session('tahun_penganggaran','');
        $data = array();
        $total_pagu_keseluruhan = 0;
        $total_realisasi_keuangan = 0;

        $where="";
        $where_paket="";
        $where_unit_kerja="";
         
        if(!empty($unit_kerja_selected)){
            $where_unit_kerja.=" AND id='$unit_kerja_selected'";
        }
        if(!empty($sumber_dana_selected)){
            if ($sumber_dana_selected !== '-') {
                $where.=" AND sumber_dana_dpa.sumber_dana='$sumber_dana_selected'";  
            }
            
        }
        if(!empty($desa_selected)){
            $where_paket.=" AND desa.id='$desa_selected'";
        }
        if(!empty($kecamatan_selected)){
            $where_paket.=" AND kecamatan.id='$kecamatan_selected'";
        }
        
        $desa_ = [];

        if ($sumber_dana_selected !== '') {
            $data = DB::table('unit_kerja')->select('id','nama_unit_kerja')->whereRaw("id<>'' $where_unit_kerja")->get();
         
            foreach($data as $unit_kerja_list){
               $unit_kerja_list->Dpa=DB::table('dpa')
               ->join('sub_kegiatan', 'dpa.id_sub_kegiatan', '=', 'sub_kegiatan.id')
               ->join('pegawai_penanggung_jawab', 'dpa.id_pegawai_penanggung_jawab', '=', 'pegawai_penanggung_jawab.id')
               ->select('dpa.id','dpa.nilai_pagu_dpa','sub_kegiatan.nama_sub_kegiatan','sub_kegiatan.kode_sub_kegiatan','pegawai_penanggung_jawab.nama_lengkap as ppk')
               ->where('dpa.tahun',$tahun)
               ->where('dpa.id_unit_kerja',$unit_kerja_list->id)
               ->get();
   
               foreach ( $unit_kerja_list->Dpa as $dpa ){
                   
                $dpa->Paket1=DB::table('paket_dau')
                   ->selectRaw("paket_dau.id,paket_dau.satuan,paket_dau.id_sumber_dana_dpa,paket_dau.nama_paket,paket_dau.volume,paket_dau.pagu,paket_dau.keterangan,@jenis_paket:='dau' as jenis_paket,sumber_dana_dpa.sumber_dana")
                   ->join('sumber_dana_dpa','sumber_dana_dpa.id','=','paket_dau.id_sumber_dana_dpa')
                   ->whereRaw("paket_dau.id_dpa='$dpa->id' $where");
                   $dpa->Paket=DB::table('paket_dak')
                   ->selectRaw("paket_dak.id,paket_dak.satuan,paket_dak.id_sumber_dana_dpa,paket_dak.nama_paket,paket_dak.volume,paket_dak.anggaran_dak as pagu,@keterangan:='' as keterangan,@jenis_paket:='dak' as jenis_paket,sumber_dana_dpa.sumber_dana")
                   ->join('sumber_dana_dpa','sumber_dana_dpa.id','=','paket_dak.id_sumber_dana_dpa')
                   ->whereRaw("paket_dak.id_dpa='$dpa->id' AND sumber_dana_dpa.jenis_belanja='Belanja Modal' $where")
                   ->union($dpa->Paket1)->get();
   
                   foreach($dpa->Paket as $paket){
                       if($paket->jenis_paket=='dau'){
                           $paket->Lokasi=DB::table('paket_dau_lokasi')
                           ->join('desa','paket_dau_lokasi.id_desa','=','desa.id')
                           ->join('kecamatan','desa.id_kecamatan','=','kecamatan.id')
                           ->select('desa.nama as nama_desa','kecamatan.nama as nama_kecamatan')
                           ->whereRaw("id_paket_dau='$paket->id' $where_paket")
                           ->get();
                       }else{
                           $paket->Lokasi=DB::table('paket_dak_lokasi')
                           ->join('desa','paket_dak_lokasi.id_desa','=','desa.id')
                           ->join('kecamatan','desa.id_kecamatan','=','kecamatan.id')
                           ->select('desa.nama as nama_desa','kecamatan.nama as nama_kecamatan')
                           ->whereRaw("id_paket_dak='$paket->id' $where_paket")
                           ->get();
                       }
                       $paket->Desa='';
                       $paket->Kecamatan='';
                       foreach($paket->Lokasi as $lokasi){
                           $paket->Desa.=$lokasi->nama_desa.PHP_EOL;
                           $paket->Kecamatan.=$lokasi->nama_kecamatan.PHP_EOL;
   
                       }
                   }
               }
   
           }
               
         
   
               foreach ( $data as $unit_kerja_list ){
                   $unit_kerja_list->subCount=0;
                   $unit_kerja_list->Pagu=0;
                   foreach ( $unit_kerja_list->Dpa as $dpa ){
                       $dpa->Pagu=0;
                       foreach($dpa->Paket as $paket){
                           if($paket->Desa=='' || $paket->Kecamatan==''){
                               $dpa->Pagu-=$paket->pagu;
                               $unit_kerja_list->subCount-=1;
                               $unit_kerja_list->Pagu-=$paket->pagu;
                            //    $unit_kerja_list->Desa .= $paket->Desa;
                           }else{
                               //$unit_kerja_list->subCount+=1;
                               //$unit_kerja_list->Pagu+=$paket->pagu;
                            //    $unit_kerja_list->Desa .= $paket->Desa;
                           }
                           $unit_kerja_list->subCount+=1;
                           $dpa->Pagu+=$paket->pagu;
                           $unit_kerja_list->Pagu+=$paket->pagu;
                       }

                   }
                   //return $unit_kerja_list->Dpa;

               }
        }       

        $fungsi = Str::slug(($unit_kerja_selected ? 'semua unit kerja' : 'semua'), '_');
        $dinas = '';
        $periode = '';
        if ($unit_kerja_selected) {
            $dinas = UnitKerja::find($unit_kerja_selected)->nama_unit_kerja;
        }
        else
            $dinas = "Semua Perangkat Daerah";
    
        if ($fungsi) {
            $fungsi = "export_daftar_alokasi_semua_unit_kerja";
        }
        return $this->{$fungsi}($tipe, $data, $total_pagu_keseluruhan, $total_realisasi_keuangan, $periode, $dinas, $tahun, $periode_selected, $sumber_dana_selected,$kecamatan_selected,$desa_selected);
    }


    public function export_daftar_alokasi_semua_unit_kerja($tipe, $data, $total_pagu_keseluruhan, $total_realisasi_keuangan, $periode, $dinas, $tahun, $periode_selected, $sumber_dana_selected,$kecamatan_selected,$desa_selected, $query = [])
    {

        $spreadsheet = new Spreadsheet();

        $spreadsheet->getProperties()->setCreator('AFILA')
            ->setLastModifiedBy('AFILA')
            ->setTitle('DAFTAR ALOKASI ' . strtoupper($dinas) . '')
            ->setSubject('DAFTAR ALOKASI ' . strtoupper($dinas) . '')
            ->setDescription('DAFTAR ALOKASI ' . strtoupper($dinas) . '')
            ->setKeywords('pdf php')
            ->setCategory('KEMAJUAN');
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_FOLIO);
        $sheet->getRowDimension(5)->setRowHeight(25);
        $sheet->getRowDimension(1)->setRowHeight(17);
        $sheet->getRowDimension(2)->setRowHeight(17);
        $sheet->getRowDimension(3)->setRowHeight(17);
        $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
        $spreadsheet->getDefaultStyle()->getFont()->setSize(10);
        $spreadsheet->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);
        $spreadsheet->getActiveSheet()->getPageSetup()->setVerticalCentered(false);

        //Margin PDF
        $spreadsheet->getActiveSheet()->getPageMargins()->setTop(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setRight(0.3);
        $spreadsheet->getActiveSheet()->getPageMargins()->setLeft(0.5);
        $spreadsheet->getActiveSheet()->getPageMargins()->setBottom(0.3);
        if ($sumber_dana_selected == 'semua') {
            $sumber_dana_selected = 'DAK FISIK & NON FISIK';
        } else {
            $sumber_dana_selected = strtoupper($sumber_dana_selected);
        }
        
        // Header Text
        $sheet->setCellValue('A1', 'LAPORAN DAFTAR ALOKASI PEMBANGUNAN');
        $sheet->setCellValue('A2', strtoupper($dinas));
        $sheet->setCellValue('A3', 'PEMERINTAH KABUPATEN ENREKANG TAHUN ANGGARAN ' . $tahun );
        $sheet->mergeCells('A1:I1');
        $sheet->mergeCells('A2:I2');
        $sheet->mergeCells('A3:I3');
        $sheet->getStyle('A1')->getFont()->setSize(12);

        

        $sheet->getStyle('A:I')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A1:I6')->getFont()->setBold(true);

        $sheet->setCellValue('A5', 'NO')->mergeCells('A5:A6');
        $sheet->setCellValue('B5', 'URAIAN KEGIATAN')->mergeCells('B5:B6')->getColumnDimension('B')->setWidth(50);
        $sheet->setCellValue('C5', 'PAGU')->mergeCells('C5:C6')->getColumnDimension('C')->setWidth(15);
        $sheet->setCellValue('D5', 'LOKASI')->mergeCells('D5:E5');
        $sheet->setCellValue('F5', 'VOLUME')->mergeCells('F5:F6')->getColumnDimension('F')->setWidth(12);
        $sheet->setCellValue('G5', 'PPK/PPTK')->mergeCells('G5:G6')->getColumnDimension('G')->setWidth(25);
        $sheet->setCellValue('H5', 'SUMBER DANA')->mergeCells('H5:H6')->getColumnDimension('H')->setWidth(20);
        $sheet->setCellValue('I5', 'KET')->mergeCells('I5:I6')->getColumnDimension('I')->setWidth(20);


        $sheet->setCellValue('D6', 'DESA/KEL')->mergeCells('D6:D6')->getColumnDimension('D')->setWidth(15);
        $sheet->setCellValue('E6', 'KECAMATAN')->mergeCells('E6:E6')->getColumnDimension('E')->setWidth(15);
        
        

        
        $sheet->getStyle('A5:I6')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('C6E0B4');
        $cell = 7;
        $tot_pagu=0;
        foreach ( $data as $res ){
            if($res->subCount==0){
                continue;
            }
            $sheet->getRowDimension($cell)->setRowHeight(25);
            $sheet->getStyle('A'.$cell.':I'.$cell)->getFont()->setBold(true);
            $sheet->setCellValue('B'.$cell,$res->nama_unit_kerja)->mergeCells('B'.$cell.':B'.$cell);
            $sheet->setCellValue('C'.$cell,numberToCurrency($res->Pagu))->mergeCells('C'.$cell.':C'.$cell);
            $sheet->setCellValue('D'.$cell,'')->mergeCells('D'.$cell.':I'.$cell);
            $sheet->getStyle('A' . $cell . ':I' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('CC99FF');
            $tot_pagu+=$res->Pagu;
            $cell++;
            $i = 0;
            foreach ($res->Dpa as $dpa ){
                   if (count($dpa->Paket) !== 0) {
                      if ($dpa->Pagu > 0) {
                        $sheet->getRowDimension($cell)->setRowHeight(20);
                        $sheet->getStyle('A'.$cell.':I'.$cell)->getFont()->setBold(true);
                        $sheet->setCellValue('A' . $cell, ++$i);
                        $sheet->setCellValue('B' . $cell, $dpa->nama_sub_kegiatan);
                        $sheet->setCellValue('C' . $cell, numberToCurrency($dpa->Pagu));
                        $sheet->setCellValue('D' . $cell, '');
                        $sheet->setCellValue('E' . $cell, '');
                        $sheet->setCellValue('F' . $cell, '');
                        $sheet->setCellValue('G' . $cell, '');
                        $sheet->setCellValue('H' . $cell, '');
                        $sheet->setCellValue('I' . $cell, '');
                        $sheet->getStyle('A' . $cell . ':I' . $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('D9E1F2');
                        $cell++;
                      }
                   }
                    $j=0;
                    foreach ( $dpa->Paket as $paket ){
                            if($paket->Desa=='' || $paket->Kecamatan==''){
                                continue; 
                            }

                                $sheet->setCellValue('A' . $cell, $i.'.'.++$j);
                                $sheet->setCellValue('B' . $cell, $paket->nama_paket);
                                $sheet->setCellValue('C' . $cell, numberToCurrency($paket->pagu));
                                if (!empty($paket->Desa)) {
                                    $sheet->setCellValue('D' . $cell, $paket->Desa);
                                    
                                    $sheet->setCellValue('E' . $cell, rtrim($paket->Kecamatan, ", "));
                                }else{
                                    $sheet->setCellValue('D' . $cell, '');
                                    $sheet->setCellValue('E' . $cell, '');
                                }   
                                $sheet->setCellValue('F' . $cell, $paket->volume.' '.$paket->satuan);
                                $sheet->setCellValue('G' . $cell, $dpa->ppk);
                                $sheet->setCellValue('H' . $cell, $paket->sumber_dana);
                                $sheet->setCellValue('I' . $cell, $paket->keterangan);
                                $cell++;
    
                    }
            }
        }
        $sheet->getRowDimension($cell)->setRowHeight(25);
        $sheet->getStyle('A'.$cell.':I'.$cell)->getFont()->setBold(true);
        $sheet->setCellValue('B'.$cell,'TOTAL ')->mergeCells('B'.$cell.':B'.$cell);
        $sheet->setCellValue('C'.$cell,numberToCurrency($tot_pagu))->mergeCells('C'.$cell.':C'.$cell);
        $sheet->setCellValue('D'.$cell,'')->mergeCells('D'.$cell.':I'.$cell);
        $sheet->getStyle('A'.$cell.':I'. $cell)->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setRGB('C6E0B4');
        

        
    //    return $tes;


        $sheet->getStyle('A1:I' . $cell)->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
        $sheet->getStyle('A1:I' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A4:A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('B7:B' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C7:C' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);
        $sheet->getStyle('D7:D' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('E7:E' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('G7:G' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('H7:H' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        $sheet->getStyle('C7:C' . $cell)->getNumberFormat()->setFormatCode('#.##0');
        // $sheet->getStyle('G8:G' . $cell)->getNumberFormat()->setFormatCode('#.##0');
        // $sheet->getStyle('H8:H' . $cell)->getNumberFormat()->setFormatCode('#.##0');
        // $sheet->getStyle('I8:I' . $cell)->getNumberFormat()->setFormatCode('#.##0');

        // Total

       
        $sheet->getStyle('A' . $cell . ':I' . $cell)->getFont()->setBold(true);
        $sheet->getRowDimension($cell)->setRowHeight(30);
        $sheet->getStyle('A' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $border = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '0000000'],
                ],
            ],
        ];

        $sheet->getStyle('A5:I' . $cell)->applyFromArray($border);
        $cell++;
        $profile = ProfileDaerah::first();
        $tgl_cetak = tglIndo(request('tgl_cetak', date('d/m/Y')));
        if (hasRole('admin')) {
        } else if (hasRole('opd')) {
            $sheet->setCellValue('E' . ++$cell, optional($profile)->nama_daerah . ', ' . $tgl_cetak)->mergeCells('E' . $cell . ':I' . $cell);
            $sheet->getStyle('E' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet->setCellValue('E' . ++$cell, request('nama_jabatan_kepala', ''))->mergeCells('E' . $cell . ':I' . $cell);
            $sheet->getStyle('E' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $cell = $cell + 3;
            $sheet->setCellValue('E' . ++$cell, request('nama', ''))->mergeCells('E' . $cell . ':I' . $cell);
            $sheet->getStyle('E' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet->setCellValue('E' . ++$cell, 'Pangkat/Golongan : ' . request('jabatan', ''))->mergeCells('E' . $cell . ':I' . $cell);
            $sheet->getStyle('E' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet->setCellValue('E' . ++$cell, 'NIP : ' . request('nip', ''))->mergeCells('E' . $cell . ':I' . $cell);
            $sheet->getStyle('E' . $cell)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
        }
        if ($tipe == 'excel') {
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="DAFTAR ALOKASI ' . $dinas . '.xlsx"');

        } else {
            $sheet->setCellValue('A' . ++$cell, 'Dicetak melalui ' . url()->current())->mergeCells('A' . $cell . ':L' . $cell);
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddHeader('&C&H' . url()->current());
            $spreadsheet->getActiveSheet()->getHeaderFooter()
                ->setOddFooter('&L&B &RPage &P of &N');
            $class = \PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf::class;
            \PhpOffice\PhpSpreadsheet\IOFactory::registerWriter('Pdf', $class);
            header('Content-Type: application/pdf');
            // header('Content-Disposition: attachment;filename="DAFTAR ALOKASI '.$dinas.'.pdf"');
            header('Cache-Control: max-age=0');
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Pdf');
        }
        $writer->save('php://output');
        exit;
    }

   

}
