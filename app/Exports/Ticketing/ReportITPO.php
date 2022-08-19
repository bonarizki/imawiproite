<?php

namespace App\Exports\Ticketing;

use Carbon\Carbon;
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
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class ReportITPO implements WithHeadings,ShouldAutoSize,FromArray,WithStyles,WithEvents,WithColumnFormatting,WithStrictNullComparison
{
    public $data;

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

    public function columnFormats(): array
    {
        return [
            // 'C' => NumberFormat::FORMAT_PERCENTAGE,
            'H' => NumberFormat::FORMAT_NUMBER,
            'K' => NumberFormat::FORMAT_NUMBER,
            'N' => NumberFormat::FORMAT_NUMBER,
            'Q' => NumberFormat::FORMAT_NUMBER,
            'T' => NumberFormat::FORMAT_NUMBER,
            'W' => NumberFormat::FORMAT_NUMBER,
            'Z' => NumberFormat::FORMAT_NUMBER,
            'AC' => NumberFormat::FORMAT_NUMBER,
            'AD' => NumberFormat::FORMAT_NUMBER,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $highestRow = $event->sheet->getDelegate()->getHighestRow();
                $event->sheet->getStyle('A1:AG1')->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'E3E3E3',
                        ],
                    ],
                ]);
                
                $event->sheet->getStyle('A1:AG'.$highestRow)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }

    public function headings():array
    {
        return [
            "Ticket ID",
            "Ticket Type",
            "Ticket Created By",
            "Ticket Created At",
            "Ticket Status",
            "Approval Nik 1",
            "Approval Nik 1 Date",
            "Approval Nik 1 Lead Time",
            "Approval Nik 2",
            "Approval Nik 2 Date",
            "Approval Nik 2 Lead Time",
            "Approval Nik 3",
            "Approval Nik 3 Date",
            "Approval Nik 3 Lead Time",
            "Approval Nik 4",
            "Approval Nik 4 Date",
            "Approval Nik 4 Lead Time",
            "Approval Nik 5",
            "Approval Nik 5 Date",
            "Approval Nik 5 Lead Time",
            "Approval Nik 6",
            "Approval Nik 6 Date",
            "Approval Nik 6 Lead Time",
            "Approval Nik IT 1",
            "Approval Nik IT 1 Date",
            "Approval Nik IT 1 Lead Time",
            "Approval Nik IT 2",
            "Approval Nik IT 2 Date",
            "Approval Nik IT 2 Lead Time",
            "Approval Nik Done",
            "Approval Nik Done Date",
            "Approval Nik Done Lead Time",
            "Total Lead Time"
            
        ];
    }

    public function array(): array
    {
        $data = $this->data;
        // dd($data);
        if ($data != null) {
            foreach ($data as $header) {
                $array[] = [
                    $header["ticket_id"],
                    $header["type"]["type_name"],
                    $header["request_by"]["user_nik"] . " - " .$header["request_by"]["user_name"],
                    $header["created_at"],
                    ucfirst($header["ticket_status"]),
                    $header["approval"]["ticketing_approval_nik_1"] == null ? "-" : $header["approval"]["ticketing_approval_nik_1"],
                    $header["approval"]["ticketing_approval_nik_1_date"] == null ? "-" : $header["approval"]["ticketing_approval_nik_1_date"],
                    $header["lead_time_1"],
                    $header["approval"]["ticketing_approval_nik_2"] == null ? "-" : $header["approval"]["ticketing_approval_nik_2"],
                    $header["approval"]["ticketing_approval_nik_2_date"] == null ? "-" : $header["approval"]["ticketing_approval_nik_2_date"],
                    $header["lead_time_2"],
                    $header["approval"]["ticketing_approval_nik_3"] == null ? "-" : $header["approval"]["ticketing_approval_nik_3"],
                    $header["approval"]["ticketing_approval_nik_3_date"] == null ? "-" : $header["approval"]["ticketing_approval_nik_3_date"],
                    $header["lead_time_3"],
                    $header["approval"]["ticketing_approval_nik_4"] == null ? "-" : $header["approval"]["ticketing_approval_nik_4"],
                    $header["approval"]["ticketing_approval_nik_4_date"] == null ? "-" : $header["approval"]["ticketing_approval_nik_4_date"],
                    $header["lead_time_4"],
                    $header["approval"]["ticketing_approval_nik_5"] == null ? "-" : $header["approval"]["ticketing_approval_nik_5"],
                    $header["approval"]["ticketing_approval_nik_5_date"] == null ? "-" : $header["approval"]["ticketing_approval_nik_5_date"],
                    $header["lead_time_5"],
                    $header["approval"]["ticketing_approval_nik_6"] == null ? "-" : $header["approval"]["ticketing_approval_nik_6"],
                    $header["approval"]["ticketing_approval_nik_6_date"] == null ? "-" : $header["approval"]["ticketing_approval_nik_6_date"],
                    $header["lead_time_6"],
                    $header["approval"]["ticketing_approval_nik_it1"] == null ? "-" : $header["approval"]["ticketing_approval_nik_it1"],
                    $header["approval"]["ticketing_approval_nik_it1_date"] == null ? "-" : $header["approval"]["ticketing_approval_nik_it1_date"],
                    $header["lead_time_it1"],
                    $header["approval"]["ticketing_approval_nik_it2"] == null ? "-" : $header["approval"]["ticketing_approval_nik_it2"],
                    $header["approval"]["ticketing_approval_nik_it2_date"] == null ? "-" : $header["approval"]["ticketing_approval_nik_it2_date"],
                    $header["lead_time_it2"],
                    $header["ticket_status"] != 'done' ? "-" : $header["updated_by"],
                    $header["ticket_status"] != 'done' ? "-" : $header["updated_at"],
                    $header["lead_time_done"],
                    $header["total_lead_time"],
                ];
            }
            return $array;
        }else{
            throw new ModelNotFoundException('No Data for Download',500);
        }
        
    }
}
