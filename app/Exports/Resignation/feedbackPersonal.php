<?php

namespace App\Exports\Resignation;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;

class feedbackPersonal implements WithHeadings,FromArray,ShouldAutoSize,WithStyles
{
    private $StatusInterfaces,$resign_id;

    public function __construct($StatusInterfaces,$resign_id)
    {
        $this->StatusInterfaces = $StatusInterfaces;
        $this->resign_id = $resign_id;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array
    {
        return [
            "Resign Code",
            "Employee Name",
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
        $data = $this->StatusInterfaces->DetailFeedbackPersonal($this->resign_id);
        $array []= [
            $data->Resign->resign_id,
            $data->Resign->User->user_name,
            str_replace("#",",",$data->resign_feedback_1),
            $data->resign_feedback_2,
            $data->resign_feedback_3,
            $data->resign_feedback_4,
            $data->resign_feedback_5,
            $data->resign_feedback_6,
            $data->resign_feedback_7,
            $data->resign_feedback_8,
            $data->resign_feedback_9,
            $data->resign_feedback_10,
            $data->resign_feedback_11,
            $data->resign_feedback_12,
            $data->resign_feedback_13,
            $data->resign_feedback_14,
            $data->resign_feedback_15,
            $data->resign_feedback_16,
            $data->resign_feedback_17,
            $data->resign_feedback_18,
            $data->resign_feedback_19,
            $data->resign_feedback_20,
            $data->resign_feedback_21,
            $data->resign_feedback_22,
            $data->resign_feedback_23,
            $data->resign_feedback_24,
            $data->resign_feedback_25,
            $data->resign_feedback_26,
            $data->resign_feedback_27,
        ];
        return $array;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
