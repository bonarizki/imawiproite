<?php
 
namespace App\Exports\Appraisal;
 
use App\Model\User;
use App\Model\Appraisal\AppraisalMain;
use App\Model\Appraisal\AppraisalStaffMain;
use App\Model\Plugin\PluginPeriod;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
 
class CompletedExport implements FromView, ShouldAutoSize, WithTitle, WithEvents
{
    use Exportable;
    
    private $period;
    private $department;
    private $grade_group;

    public function __construct($period, $department, $grade_group)
    {
        $this->period = $period;
        $this->department = $department;
        $this->grade_group = $grade_group;
    }

    public function title(): string
    {
        return 'Report Appraisal Summary';
    }

    public function view(): View
    {
        $spv_above = AppraisalMain::query()
            ->selectRaw('trans_appraisal_main.appraisal_id,
                trans_appraisal_main.user_id,
                user.user_nik, user.user_name,
                dept.department_name, gg.grade_group_name,
                trans_appraisal_main.overall_milestone_score,
                trans_appraisal_main.overall_competency_score,
                trans_appraisal_main.overall_performance_score,
                IFNULL(trans_appraisal_main.final_score, "-") AS final_score,
                IFNULL(trans_appraisal_main.confidential_summary, "-") AS confidential_summary')
            ->leftJoin('mst_main_user AS user', 'user.user_id', 'trans_appraisal_main.user_id')
            ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'trans_appraisal_main.department_id')
            ->leftJoin('mst_main_user_grade_group AS gg', 'gg.grade_group_id', 'trans_appraisal_main.grade_group_id')
            ->where('trans_appraisal_main.appraisal_status', 'CLOSED');

        $staff = AppraisalStaffMain::query()
            ->selectRaw('trans_appraisal_staff_main.user_id,
                trans_appraisal_staff_main.appraisal_user_nik AS user_nik,
                trans_appraisal_staff_main.appraisal_user_name AS user_name,
                dept.department_name, "Staff" AS grade_group_name,
                trans_appraisal_staff_main.overall_objective_score AS overall_milestone_score,
                trans_appraisal_staff_main.overall_competency_score,
                trans_appraisal_staff_main.overall_performance_score,
                IFNULL(trans_appraisal_staff_main.final_score, "-") AS final_score,
                IFNULL(trans_appraisal_staff_main.confidential_summary, "-") AS confidential_summary')
            ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'trans_appraisal_staff_main.department_id')
            ->where('trans_appraisal_staff_main.appraisal_status', 'CLOSED');
        
        if($this->period > 0) {
            $spv_above = $spv_above->where('trans_appraisal_main.period_id', $this->period);
            $staff = $staff->where('trans_appraisal_staff_main.period_id', $this->period);
        }

        if($this->department > 0) {
            $spv_above = $spv_above->where('trans_appraisal_main.department_id', $this->department);
            $staff = $staff->where('trans_appraisal_staff_main.department_id', $this->department);
        }

        if($this->grade_group > 0) {
            $spv_above = $spv_above->where('trans_appraisal_main.grade_group_id', $this->grade_group);

            if(!in_array($this->grade_group, array(3))) {
                $staff = $staff->whereNull('trans_appraisal_staff_main.appraisal_staff_id');
            }
        }

        $spv_above = $spv_above->orderBy('trans_appraisal_main.grade_group_id', 'DESC')->orderBy('user.user_nik')->get();
        $staff = $staff->orderBy('trans_appraisal_staff_main.appraisal_user_nik')->get();

        $data = array();
        
        foreach($spv_above as $val) {
            $data[] = $val;
        }

        foreach($staff as $val) {
            $data[] = $val;
        }

        return view('appraisal.export.completed', ['data' => $data]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $highestRow = $event->sheet->getDelegate()->getHighestRow();
                $highestColumn = $event->sheet->getDelegate()->getHighestColumn();

                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(50);

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

                $event->sheet->getDelegate()->getStyle('A2:'.$highestColumn.$highestRow)->getAlignment()
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A2:A'.$highestRow)->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('F2:J'.$highestRow)->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('K2:K'.$highestRow)->getAlignment()->setWrapText(true);

                $event->sheet->getDelegate()->getStyle('A1:'.$highestColumn.$highestRow)->getBorders()->getAllBorders()
                    ->applyFromArray([
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => [
                            'rgb' => '000000',
                        ],
                    ]);

                for($i=1; $i<$highestRow; $i++) {
                    $event->sheet->getDelegate()->getCell('A'.($i+1))->setValue($i);
                }

                $highestColumn++;
                $event->sheet->getDelegate()->freezePane('A2');
            },
        ];
    }
}