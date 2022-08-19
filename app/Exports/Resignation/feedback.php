<?php

namespace App\Exports\Resignation;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class feedback implements WithHeadings,ShouldAutoSize,FromArray,WithStyles,WithEvents
{
    private $ReportInterfaces,$request;

    public function __construct($ReportInterfaces,$request)
    {
        $this->ReportInterfaces = $ReportInterfaces;
        $this->request = $request;
    }
    
    public function headings():array
    {
        return [
            "Employee Name",
            "Department",
            "1. What is the biggest reason you are leaving our organization? (you can choose more than 1 answer)",
            "2. How would you rate your satisfaction working with us?",
            "3. You feel that the management is fair and implement the Wipro Values",
            "4. Were you satisfied with your remuneration and other benefits",
            "5. You feel that job role is suitable for you",
            "6. My manager/superior gave me clear objectives",
            "7. My manager/superior gave me appropriate guidance and help",
            "8. My manager/superior respect me and others",
            "9. My manager/superior ran the business fairly",
            "10. My manager/superior gave me an opportunity on my career development",
            "11. My manager/superior support teamwork and collaboration ",
            "12. My manager/superior was really open-minded and open with feedback ",
            "13. My manager/superior gave me work or performance evaluation regularly",
            "14. My manager/superior acknowledged my work result",
            "15. My manager/superior gave me trust in work",
            "16. Will you recommend this organization as a great place to belong?",
            "17. Will you recommend this organization to your colleague/family/friends ",
            "18. Will you reconsider to rejoin with our organization?",
            "19. What did you like most when you worked with us",
            "20. What did you dislike most when you worked with us",
            "21. If you can change something in our organization or the working experience with us, what would it be",
            "22. What skills and qualifications do you think we need to look for in your replacement?",
            "23. Suggestion for improvement (you can share it in Bahasa)",
            "24. Are you leaving here to join another organization? ",
            "25. If yes, is the company run in the same category/field as our organization?",
            "26. Is your new job is a promotion?",
            "27. How is your total benefit in the new company compared with us?",
        ];
    }

    public function array(): array
    {
        $data = $this->ReportInterfaces->feedback($this->request);
        if ($data != null) {
            foreach ($data as $item) {
                $array[]= [
                    $item->user_name,
                    $item->department_name,
                    str_replace("#",",",$item->resign_feedback_1),
                    $item->resign_feedback_2,
                    $item->resign_feedback_3,
                    $item->resign_feedback_4,
                    $item->resign_feedback_5,
                    $item->resign_feedback_6,
                    $item->resign_feedback_7,
                    $item->resign_feedback_8,
                    $item->resign_feedback_9,
                    $item->resign_feedback_10,
                    $item->resign_feedback_11,
                    $item->resign_feedback_12,
                    $item->resign_feedback_13,
                    $item->resign_feedback_14,
                    $item->resign_feedback_15,
                    $item->resign_feedback_16,
                    $item->resign_feedback_17,
                    $item->resign_feedback_18,
                    $item->resign_feedback_19,
                    $item->resign_feedback_20,
                    $item->resign_feedback_21,
                    $item->resign_feedback_22,
                    $item->resign_feedback_23,
                    $item->resign_feedback_24,
                    $item->resign_feedback_25,
                    $item->resign_feedback_26,
                    $item->resign_feedback_27,
                ];
            }
            return $array;
        }else{
            throw new ModelNotFoundException('No Data for Download',500);
        }
        
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
                $event->sheet->getStyle('A1:AC1')->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => [
                            'rgb' => 'E3E3E3',
                        ],
                    ],
                ]);
                
                $event->sheet->getStyle('A1:AC'.$highestRow)->applyFromArray([
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
}
