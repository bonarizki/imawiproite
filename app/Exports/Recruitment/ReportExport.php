<?php
 
namespace App\Exports\Recruitment;
 
use App\Model\Recruitment\Recruit;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
 
class ReportExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithEvents, WithTitle
{
    private $period;
    private $title;
    private $poh;

    public function __construct($period, $title, $poh)
    {
        $this->period = $period;
        $this->title = $title;
        $this->poh = $poh;
    }

    public function title(): string
    {
        return 'Report Fulfillment List';
    }

    public function headings(): array
    {
    	return [
            'NO',
    		'REFERENCE NO',
            'REQUESTED BY',
            'TITLE',
            'GRADE',
            'SEX',
            'MINIMUM AGE',
            'MAXIMUM AGE',
            'REASON FOR REQUEST',
            'POINT OF HIRE',
            'EMPLOYMENT STATUS',
            'CONTRACT LENGTH',
            'PROBATION LENGTH',
            'EXPECTED JOIN DATE',
            'STATUS OF RECRUITMENT',
            'EDUCATION',
            'GENERAL COMPETENCY',
            'SPECIFIC COMPETENCY',
            'JOB DESCRIPTION',
            'SPECIAL NOTE',
            'BASIC SALARY',
            'ALLOWANCES',
            'ORGANIZATION STRUCTURE',
            'REQUEST DATE',
            'PROCESSED DATE',
            'CLOSING DATE',
            'LEAD TIME',
            'STANDARD LEAD TIME',
            'HIRING RESOURCE',
            'JOIN DATE',
            'EXTERNAL COST',
            'INTERNAL COST',
            'ADVERTISING EXPENSES',
            'ASSESSMENT ONLINE',
            'MEDICAL CHECKUP',
            'TRAVEL EXPENSES',
            'HIRING BONUS',
            'REFERRAL BONUS',
            'GRAND TOTAL'
    	];
    }

    public function map($r): array
    {
        return [
            $r->recruit_id,
            $r->request_code,
            $r->user,
            $r->title_name,
            $r->grade,
            $r->sex,
            $r->minimum_age,
            $r->maximum_age,
            $r->reason_for_request,
            $r->point_of_hire,
            $r->employment_status,
            $r->contract_length,
            $r->probation_length,
            $r->expected_join_date_format,
            $r->recruitment_status,
            $r->edu,
            $r->general_competency,
            $r->specific_competency,
            $r->job_description,
            $r->special_note,
            $r->basic_salary,
            $r->allowances,
            $r->organization_structure,
            $r->request_date_format,
            $r->processed_date_format,
            $r->lead_time_end_format,
            $r->lead_time,
            $r->standard_lead_time,
            $r->hiring_resource,
            $r->join_date_format,
            $r->external_cost,
            $r->internal_cost,
            $r->advertising_expenses,
            $r->assessment_online,
            $r->medical_checkup,
            $r->travel_expenses,
            $r->hiring_bonus,
            $r->referral_bonus,
            $r->hiring_cost_total
        ];
    }

    public function query()
    {
        $recruit = Recruit::query()
            ->selectRaw('trans_recruitment_recruit.*,
                t.title_name,
                CONCAT("[", g.grade_code, "] ", g.grade_name) AS grade,
                poh.point_of_hire_name AS point_of_hire,
                CONCAT("[", u.user_nik, "] ", u.user_name) AS user,
                IF(trans_recruitment_recruit.education = "Other", trans_recruitment_recruit.education_other, trans_recruitment_recruit.education) AS edu,
                DATE_FORMAT(trans_recruitment_recruit.expected_join_date, "%b %e, %Y") AS expected_join_date_format,
                DATE_FORMAT(trans_recruitment_recruit.request_date, "%b %e, %Y") AS request_date_format,
                DATE_FORMAT(trans_recruitment_recruit.lead_time_start, "%b %e, %Y") AS processed_date_format,
                DATE_FORMAT(trans_recruitment_recruit.lead_time_end, "%b %e, %Y") AS lead_time_end_format,
                trans_recruitment_recruit.external_cost + trans_recruitment_recruit.internal_cost + trans_recruitment_recruit.advertising_expenses + trans_recruitment_recruit.assessment_online + trans_recruitment_recruit.medical_checkup + trans_recruitment_recruit.travel_expenses + trans_recruitment_recruit.hiring_bonus + trans_recruitment_recruit.referral_bonus AS hiring_cost_total,
                DATE_FORMAT(trans_recruitment_recruit.join_date, "%b %e, %Y") AS join_date_format,
                DATEDIFF(trans_recruitment_recruit.lead_time_end, trans_recruitment_recruit.lead_time_start) AS lead_time,
                slt.standard_lead_time')
            ->leftJoin('mst_main_user_title AS t', 't.title_id', 'trans_recruitment_recruit.title_id')
            ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
            ->leftJoin('mst_recruitment_point_of_hire AS poh', 'poh.point_of_hire_id', 'trans_recruitment_recruit.point_of_hire_id')
            ->leftJoin('mst_main_user AS u', 'u.user_id', 'trans_recruitment_recruit.user_id')
            ->leftJoin('mst_recruitment_standard_lead_time AS slt', 'slt.grade_group_id', 'g.grade_group_id')
            ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
            ->where('trans_recruitment_recruit.period_id', $this->period);

        if($this->title > 0) {
            $recruit = $recruit->where('trans_recruitment_recruit.title_id', $this->title);
        }

        if($this->poh > 0) {
            $recruit = $recruit->where('trans_recruitment_recruit.point_of_hire_id', $this->poh);
        }
            
        $recruit = $recruit->orderBy('trans_recruitment_recruit.request_code');

        return $recruit;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $highestRow = $event->sheet->getDelegate()->getHighestRow();
                $highestColumn = $event->sheet->getDelegate()->getHighestColumn();

                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(25);

                $event->sheet->getDelegate()->getStyle('A1:'.$highestColumn.'1')
                    ->applyFromArray([
                        'alignment' => [
                            'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                            'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                        ],
                        'fill' => [
                            'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                            'startColor' => [
                                'rgb' => 'E3E3E3',
                            ],
                        ],
                    ]);

                $event->sheet->getDelegate()->setAutoFilter('A1:'.$highestColumn.'1');

                $event->sheet->getDelegate()->getStyle('A2:A'.$highestRow)->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('AE2:AM'.$highestRow)->getNumberFormat()
                    ->setFormatCode('###,###,###');

                $event->sheet->getDelegate()->getStyle('A1:'.$highestColumn.$highestRow)->getBorders()->getAllBorders()
                    ->applyFromArray([
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => [
                            'rgb' => '000000',
                        ],
                    ]);

                for($i=1; $i<$highestRow; $i++) {
                    $event->sheet->getDelegate()->getCell('A'.($i+1))->setValue($i);

                    $slt = $event->sheet->getDelegate()->getCell('AB'.($i+1))->getValue();
                    $lt = $event->sheet->getDelegate()->getCell('AA'.($i+1))->getValue();

                    if($lt > $slt) {
                        $event->sheet->getDelegate()->getStyle('AA'.($i+1))
                            ->applyFromArray([
                                'fill' => [
                                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                                    'startColor' => [
                                        'rgb' => 'FF0000',
                                    ],
                                ],
                            ]);
                    }
                }

                $highestColumn++;
                $event->sheet->getDelegate()->freezePane('A2');
            },
        ];
    }
}