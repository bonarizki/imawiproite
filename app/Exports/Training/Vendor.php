<?php

namespace App\Exports\Training;

use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class Vendor implements WithHeadings,ShouldAutoSize,WithStyles,WithEvents,FromArray,WithColumnFormatting
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $highestRow = $event->sheet->getDelegate()->getHighestRow();
                $event->sheet->getStyle('A1:G1')->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'E3E3E3',
                        ],
                    ],
                ]);
                
                $event->sheet->getStyle('A1:G'.$highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);

                $event->sheet->getStyle('C1:F'.$highestRow)->applyFromArray([
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                    ],
                ]);
            },
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' =>NumberFormat::FORMAT_NUMBER,
            'D' =>NumberFormat::FORMAT_NUMBER,
            'E' =>NumberFormat::FORMAT_NUMBER,
            'F' =>NumberFormat::FORMAT_NUMBER,
        ];
    }

    public function headings():array
    {
        return [
            "Vendor Name",
            "Vendor Bank Name",
            "Vendor Bank Number",
            "Vendor SIUP",
            "Vendor NPWP",
            "Vendor TDP",
            "Vendor Type"
        ];
    }

    public function array(): array
    {
        $data = $this->data;
        if ($data != null) {
            foreach ($data as $item) {
                $array[]= [
                    $item->vendor_name,
                    $item->vendor_bank_name,
                    $item->vendor_bank_number,
                    $item->vendor_siup,
                    $item->vendor_npwp,
                    $item->vendor_tdp,
                    $item->vendor_type,
                ];
            }
            return $array;
        }else{
            throw new ModelNotFoundException('No Data for Download',500);
        }
        
    }
}
