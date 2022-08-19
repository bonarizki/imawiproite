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

class ReportAllTicketRequestUser implements WithHeadings,ShouldAutoSize,FromArray,WithStyles,WithEvents
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

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $highestRow = $event->sheet->getDelegate()->getHighestRow();
                $event->sheet->getStyle('A1:I1')->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'E3E3E3',
                        ],
                    ],
                ]);
                
                $event->sheet->getStyle('A1:I'.$highestRow)->applyFromArray([
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
            "Ticket Priority",
            "Ticket Status",
            "Request By",
            "Request Date",
            "Period",
            "Detail",
            "Description"
        ];
    }

    public function array(): array
    {
        $data = $this->data;
        if ($data != null) {
            foreach ($data as $header) {
                // dd($header->RequestBy->user_name);
                foreach ($header->DetailRequestAccessUser as $item) {
                    $array[] = [
                        $header->ticket_id,
                        $header->Type->type_name .'-' . $header->other_information .'('. $header->request_type.')',
                        $header->Priority->priority_name,
                        ucfirst($header->ticket_status),
                        $header->RequestBy->user_name,
                        Carbon::parse($header->created_at)->format('Y-m-d'),
                        $header->Period->period_name, 
                        $header->reason,
                        $header->description
                    ];
                }
            }
            return $array;
        }else{
            throw new ModelNotFoundException('No Data for Download',500);
        }
        
    }
}
