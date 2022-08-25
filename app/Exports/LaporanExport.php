<?php

namespace App\Exports;
use App\Models\Urusan;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Maatwebsite\Excel\Concerns\WithEvents;

class LaporanExport implements 
        ShouldAutoSize, 
        WithHeadings, 
        FromCollection, 
        WithStyles,
        WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function styles(Worksheet $sheet)
    {
        // $sheet->setFontFamily('Times New Roman');

        $sheet->getStyle('A1')->getFont()->setBold(true);
        $sheet->mergeCells('A1:M1');
        $sheet->mergeCells('A2:M2');
        $sheet->mergeCells('A3:M3');
        // $sheet->setStyle(array(
        //     'font' => array(
        //         'name'      =>  'Calibri',
        //         'size'      =>  12,
        //         'bold'      =>  true
        //     )
        // ));
    }

    public function headings(): array
    {
        return [
           ['LAPORAN REALISASI KEGIATAN PEMBANGUNAN'],
           ['TAHUN ANGGARAN 2020 KEADAAN BULAN JANUARI - MARET'],
           ['SUMBER DANA APBN'],
        ];
    }

    public function collection()
    {
        // $data = ;
        // dd($data);
        return Urusan::all();
    }

    // public function view(): View
    // {
    //     return view('export.apbn', [
    //         'invoices' => User::all()
    //     ]);
    // }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class=> function(AfterSheet $event) {
                $event->sheet->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $event->sheet->getStyle('A1')->applyFromArray([
                    'font' => [
                        'bold' => true
                    ]
                ]);
            },
        ];
    }
}
