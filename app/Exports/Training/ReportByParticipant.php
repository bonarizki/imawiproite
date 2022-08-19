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
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ReportByParticipant implements WithHeadings,ShouldAutoSize,WithStyles,WithEvents,FromArray,WithStrictNullComparison
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
            1    => [
                'font' => ['bold' => true],
                'alignment' => [
                    'horizontal'=>'center',
                    'vertical'=>'center']
            ]
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $highestRow = $event->sheet->getDelegate()->getHighestRow();
                $event->sheet->getStyle('A1:M2')->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'E3E3E3',
                        ],
                    ],
                ]);
                
                $event->sheet->getStyle('A1:M'.$highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
                $event->sheet->getDelegate()->mergeCells('A1:A2');
                $event->sheet->getDelegate()->mergeCells('B1:D1');
                $event->sheet->getDelegate()->mergeCells('E1:G1');
                $event->sheet->getDelegate()->mergeCells('H1:J1');
                $event->sheet->getDelegate()->mergeCells('K1:M1');
            },
        ];
    }

    public function headings():array
    {
        return [
            [
               "Departement",
               "Workman - Staff",
               "",
               "",
               "Supervisor - Executive",
               "",
               "",
               "Manager - Senior Manager",
               "",
               "",
               "Total",
               "",
               "",
            ],[
                "",
                "Jumlah Karyawan",
                "Jumlah Participant",
                "%",
                "Jumlah Karyawan",
                "Jumlah Participant",
                "%",
                "Jumlah Karyawan",
                "Jumlah Participant",
                "%",
                "Jumlah Karyawan",
                "Jumlah Participant",
                "%",
            ]
        ];
    }

    public function array(): array
    {
        $data = $this->data;
        if ($data != null) {
            foreach ($data as $item) {
                $array[]= [
                    $item->department_name,
                    $item->total_karyawan_ws,
                    $item->total_participant_ws,
                    round(($item->total_participant_ws /  $item->total_karyawan_ws)*100)."%",
                    $item->total_karyawan_sm,
                    $item->total_participant_sm,
                    round(($item->total_participant_sm /  $item->total_karyawan_sm)*100)."%",
                    $item->total_karyawan_ms,
                    $item->total_participant_ms,
                    round(($item->total_participant_ms /  $item->total_karyawan_ms)*100)."%",
                    $item->total_karyawan,
                    $item->total_participant,
                    round(($item->total_participant /  $item->total_karyawan)*100)."%",
                ];
            }
            return $array;
        }else{
            throw new ModelNotFoundException('No Data for Download',500);
        }
        
    }
}
