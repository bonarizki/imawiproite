<?php
 
namespace App\Exports\Appraisal;
 
use App\Model\User;
use App\Model\GradeGroup;
use App\Model\Appraisal\AppraisalMain;
use App\Model\Appraisal\AppraisalStaffMain;
use App\Model\Appraisal\AppraisalPeriod;
use App\Model\Plugin\PluginPeriod;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
 
class ScoreExport implements FromView, ShouldAutoSize, WithTitle, WithEvents
{
    private $period;
    private $department;
    private $status;

    public function __construct($period, $department, $status)
    {
        $this->period = $period;
        $this->department = $department;
        $this->status = $status;
    }

    public function title(): string
    {
        return 'Report Appraisal Score Summary';
    }

    public function view(): View
    {
        $appraisal_period = AppraisalPeriod::where('period_id', $this->period)->first();
        $grade_group = GradeGroup::whereIn('grade_group_id', [3,4,5,6,7])->get();
        $gg_spv_above = array(4,5,6,7);
        $gg_staff = array(3);

        $data1 = array();

        foreach($grade_group as $key => $gg) {
            $data1[$key] = (object) array();

            $data1[$key]->grade_group_id = $gg->grade_group_id;
            $data1[$key]->grade_group_name = $gg->grade_group_name;

            if($gg->grade_group_name == 'Staff') {
                $data1[$key]->headcount = User::query()
                    ->selectRaw('COUNT(mst_main_user.user_id) AS count_user')
                    ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'mst_main_user.grade_id')
                    ->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_staff_period_start.'", mst_main_user.user_join_date) > 90')
                    ->where('g.grade_group_id', $gg->grade_group_id);

                $data1[$key]->not_scored = AppraisalStaffMain::query()
                    ->selectRaw('COUNT(appraisal_staff_id) AS count_user')
                    ->whereNull('overall_performance_score')
                    ->where('period_id', $this->period);

                $data1[$key]->osc = AppraisalStaffMain::query()
                    ->selectRaw('COUNT(appraisal_staff_id) AS count_appraisal')
                    ->where('overall_performance_score', 'LIKE', '%OSC%')
                    ->where('period_id', $this->period);

                $data1[$key]->ecc = AppraisalStaffMain::query()
                    ->selectRaw('COUNT(appraisal_staff_id) AS count_appraisal')
                    ->where('overall_performance_score', 'LIKE', '%ECC%')
                    ->where('period_id', $this->period);

                $data1[$key]->hvc = AppraisalStaffMain::query()
                    ->selectRaw('COUNT(appraisal_staff_id) AS count_appraisal')
                    ->where('overall_performance_score', 'LIKE', '%HVC%')
                    ->where('period_id', $this->period);

                $data1[$key]->mce = AppraisalStaffMain::query()
                    ->selectRaw('COUNT(appraisal_staff_id) AS count_appraisal')
                    ->where('overall_performance_score', 'LIKE', '%MCE%')
                    ->where('period_id', $this->period);

                $data1[$key]->usc = AppraisalStaffMain::query()
                    ->selectRaw('COUNT(appraisal_staff_id) AS count_appraisal')
                    ->where('overall_performance_score', 'LIKE', '%USC%')
                    ->where('period_id', $this->period);
            } else {
                $data1[$key]->headcount = User::query()
                    ->selectRaw('COUNT(mst_main_user.user_id) AS count_user')
                    ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'mst_main_user.grade_id')
                    ->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_period_start.'", mst_main_user.user_join_date) > 90')
                    ->where('g.grade_group_id', $gg->grade_group_id);

                $data1[$key]->not_scored = AppraisalMain::query()
                    ->selectRaw('COUNT(appraisal_id) AS count_user')
                    ->whereNull('overall_performance_score')
                    ->where('period_id', $this->period)
                    ->where('grade_group_id', $gg->grade_group_id);

                $data1[$key]->osc = AppraisalMain::query()
                    ->selectRaw('COUNT(appraisal_id) AS count_appraisal')
                    ->where('overall_performance_score', 'LIKE', '%OSC%')
                    ->where('period_id', $this->period)
                    ->where('grade_group_id', $gg->grade_group_id);

                $data1[$key]->ecc = AppraisalMain::query()
                    ->selectRaw('COUNT(appraisal_id) AS count_appraisal')
                    ->where('overall_performance_score', 'LIKE', '%ECC%')
                    ->where('period_id', $this->period)
                    ->where('grade_group_id', $gg->grade_group_id);

                $data1[$key]->hvc = AppraisalMain::query()
                    ->selectRaw('COUNT(appraisal_id) AS count_appraisal')
                    ->where('overall_performance_score', 'LIKE', '%HVC%')
                    ->where('period_id', $this->period)
                    ->where('grade_group_id', $gg->grade_group_id);

                $data1[$key]->mce = AppraisalMain::query()
                    ->selectRaw('COUNT(appraisal_id) AS count_appraisal')
                    ->where('overall_performance_score', 'LIKE', '%MCE%')
                    ->where('period_id', $this->period)
                    ->where('grade_group_id', $gg->grade_group_id);

                $data1[$key]->usc = AppraisalMain::query()
                    ->selectRaw('COUNT(appraisal_id) AS count_appraisal')
                    ->where('overall_performance_score', 'LIKE', '%USC%')
                    ->where('period_id', $this->period)
                    ->where('grade_group_id', $gg->grade_group_id);
            }

            if($this->department > 0) {
                $data1[$key]->headcount = $data1[$key]->headcount->where('department_id', $this->department);
                $data1[$key]->not_scored = $data1[$key]->not_scored->where('department_id', $this->department);
                $data1[$key]->osc = $data1[$key]->osc->where('department_id', $this->department);
                $data1[$key]->ecc = $data1[$key]->ecc->where('department_id', $this->department);
                $data1[$key]->hvc = $data1[$key]->hvc->where('department_id', $this->department);
                $data1[$key]->mce = $data1[$key]->mce->where('department_id', $this->department);
                $data1[$key]->usc = $data1[$key]->usc->where('department_id', $this->department);
            }

            if($this->status > 0) {
                if($this->status == 1) {
                    $data1[$key]->osc = $data1[$key]->osc->where('appraisal_status', 'CLOSED');
                    $data1[$key]->ecc = $data1[$key]->ecc->where('appraisal_status', 'CLOSED');
                    $data1[$key]->hvc = $data1[$key]->hvc->where('appraisal_status', 'CLOSED');
                    $data1[$key]->mce = $data1[$key]->mce->where('appraisal_status', 'CLOSED');
                    $data1[$key]->usc = $data1[$key]->usc->where('appraisal_status', 'CLOSED');
                } else if($this->status == 2) {
                    $data1[$key]->osc = $data1[$key]->osc->where('appraisal_status', 'IN PROGRESS');
                    $data1[$key]->ecc = $data1[$key]->ecc->where('appraisal_status', 'IN PROGRESS');
                    $data1[$key]->hvc = $data1[$key]->hvc->where('appraisal_status', 'IN PROGRESS');
                    $data1[$key]->mce = $data1[$key]->mce->where('appraisal_status', 'IN PROGRESS');
                    $data1[$key]->usc = $data1[$key]->usc->where('appraisal_status', 'IN PROGRESS');
                }
            }

            $data1[$key]->headcount = $data1[$key]->headcount->first()->count_user;
            $data1[$key]->not_scored = $data1[$key]->not_scored->first()->count_user;
            $data1[$key]->osc = $data1[$key]->osc->first()->count_appraisal;
            $data1[$key]->ecc = $data1[$key]->ecc->first()->count_appraisal;
            $data1[$key]->hvc = $data1[$key]->hvc->first()->count_appraisal;
            $data1[$key]->mce = $data1[$key]->mce->first()->count_appraisal;
            $data1[$key]->usc = $data1[$key]->usc->first()->count_appraisal;
        }

        $user_staff = User::query()
            ->selectRaw('COUNT(mst_main_user.user_id) AS count_user')
            ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'mst_main_user.grade_id')
            ->whereIn('g.grade_group_id', $gg_staff)
            ->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_staff_period_start.'", mst_main_user.user_join_date) > 90');

        $user_spv_above = User::query()
            ->selectRaw('COUNT(mst_main_user.user_id) AS count_user')
            ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'mst_main_user.grade_id')
            ->whereIn('g.grade_group_id', $gg_spv_above)
            ->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_period_start.'", mst_main_user.user_join_date) > 90');

        $osc_staff = AppraisalStaffMain::query()
            ->selectRaw('COUNT(appraisal_staff_id) AS count_appraisal')
            ->where('overall_performance_score', 'LIKE', '%OSC%')
            ->where('appraisal_status', 'CLOSED')
            ->where('period_id', $this->period);
        
        $osc_spv_above = AppraisalMain::query()
            ->selectRaw('COUNT(appraisal_id) AS count_appraisal')
            ->where('overall_performance_score', 'LIKE', '%OSC%')
            ->where('appraisal_status', 'CLOSED')
            ->where('period_id', $this->period);

        $ecc_staff = AppraisalStaffMain::query()
            ->selectRaw('COUNT(appraisal_staff_id) AS count_appraisal')
            ->where('overall_performance_score', 'LIKE', '%ECC%')
            ->where('appraisal_status', 'CLOSED')
            ->where('period_id', $this->period);
        
        $ecc_spv_above = AppraisalMain::query()
            ->selectRaw('COUNT(appraisal_id) AS count_appraisal')
            ->where('overall_performance_score', 'LIKE', '%ECC%')
            ->where('appraisal_status', 'CLOSED')
            ->where('period_id', $this->period);

        $hvc_staff = AppraisalStaffMain::query()
            ->selectRaw('COUNT(appraisal_staff_id) AS count_appraisal')
            ->where('overall_performance_score', 'LIKE', '%HVC%')
            ->where('appraisal_status', 'CLOSED')
            ->where('period_id', $this->period);
        
        $hvc_spv_above = AppraisalMain::query()
            ->selectRaw('COUNT(appraisal_id) AS count_appraisal')
            ->where('overall_performance_score', 'LIKE', '%HVC%')
            ->where('appraisal_status', 'CLOSED')
            ->where('period_id', $this->period);

        $mce_staff = AppraisalStaffMain::query()
            ->selectRaw('COUNT(appraisal_staff_id) AS count_appraisal')
            ->where('overall_performance_score', 'LIKE', '%MCE%')
            ->where('appraisal_status', 'CLOSED')
            ->where('period_id', $this->period);
        
        $mce_spv_above = AppraisalMain::query()
            ->selectRaw('COUNT(appraisal_id) AS count_appraisal')
            ->where('overall_performance_score', 'LIKE', '%MCE%')
            ->where('appraisal_status', 'CLOSED')
            ->where('period_id', $this->period);

        $usc_staff = AppraisalStaffMain::query()
            ->selectRaw('COUNT(appraisal_staff_id) AS count_appraisal')
            ->where('overall_performance_score', 'LIKE', '%USC%')
            ->where('appraisal_status', 'CLOSED')
            ->where('period_id', $this->period);
        
        $usc_spv_above = AppraisalMain::query()
            ->selectRaw('COUNT(appraisal_id) AS count_appraisal')
            ->where('overall_performance_score', 'LIKE', '%USC%')
            ->where('appraisal_status', 'CLOSED')
            ->where('period_id', $this->period);

        if($this->department > 0) {
            $user_staff = $user_staff->where('mst_main_user.department_id', $this->department);
            $user_spv_above = $user_spv_above->where('mst_main_user.department_id', $this->department);
            $osc_staff = $osc_staff->where('department_id', $this->department);
            $osc_spv_above = $osc_spv_above->where('department_id', $this->department);
            $ecc_staff = $ecc_staff->where('department_id', $this->department);
            $ecc_spv_above = $ecc_spv_above->where('department_id', $this->department);
            $hvc_staff = $hvc_staff->where('department_id', $this->department);
            $hvc_spv_above = $hvc_spv_above->where('department_id', $this->department);
            $mce_staff = $mce_staff->where('department_id', $this->department);
            $mce_spv_above = $mce_spv_above->where('department_id', $this->department);
            $usc_staff = $usc_staff->where('department_id', $this->department);
            $usc_spv_above = $usc_spv_above->where('department_id', $this->department);
        }

        $user_staff = $user_staff->first()->count_user;
        $user_spv_above = $user_spv_above->first()->count_user;
        $osc_staff = $osc_staff->first()->count_appraisal;
        $osc_spv_above = $osc_spv_above->first()->count_appraisal;
        $ecc_staff = $ecc_staff->first()->count_appraisal;
        $ecc_spv_above = $ecc_spv_above->first()->count_appraisal;
        $hvc_staff = $hvc_staff->first()->count_appraisal;
        $hvc_spv_above = $hvc_spv_above->first()->count_appraisal;
        $mce_staff = $mce_staff->first()->count_appraisal;
        $mce_spv_above = $mce_spv_above->first()->count_appraisal;
        $usc_staff = $usc_staff->first()->count_appraisal;
        $usc_spv_above = $usc_spv_above->first()->count_appraisal;

        $data2 = (object) array();
        $data2->osc = number_format((($osc_staff + $osc_spv_above) / ($user_staff + $user_spv_above) * 100), 2, '.', ',').' %';
        $data2->ecc = number_format((($ecc_staff + $ecc_spv_above) / ($user_staff + $user_spv_above) * 100), 2, '.', ',').' %';
        $data2->hvc = number_format((($hvc_staff + $hvc_spv_above) / ($user_staff + $user_spv_above) * 100), 2, '.', ',').' %';
        $data2->mce = number_format((($mce_staff + $mce_spv_above) / ($user_staff + $user_spv_above) * 100), 2, '.', ',').' %';
        $data2->usc = number_format((($usc_staff + $usc_spv_above) / ($user_staff + $user_spv_above) * 100), 2, '.', ',').' %';

        return view('appraisal.export.export_score', [
            'data1' => $data1,
            'data2' => $data2
        ]);
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $highestRow = $event->sheet->getDelegate()->getHighestRow();
                $highestColumn = $event->sheet->getDelegate()->getHighestColumn();

                $event->sheet->getDelegate()->getRowDimension(1)->setRowHeight(30);
                $event->sheet->getDelegate()->getRowDimension(11)->setRowHeight(30);

                $event->sheet->getDelegate()->getStyle('A1:I2')
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

                $event->sheet->getDelegate()->getStyle('A11:E12')
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

                $event->sheet->getDelegate()->getStyle('A2:'.$highestColumn.$highestRow)->getAlignment()
                    ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A2:A'.$highestRow)->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('C3:I'.$highestRow)->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('B12:B13')->getAlignment()
                    ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

                $event->sheet->getDelegate()->getStyle('A1:I7')->getBorders()->getAllBorders()
                    ->applyFromArray([
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => [
                            'rgb' => '000000',
                        ],
                    ]);

                $event->sheet->getDelegate()->getStyle('A11:E13')->getBorders()->getAllBorders()
                    ->applyFromArray([
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        'color' => [
                            'rgb' => '000000',
                        ],
                    ]);

                $highestColumn++;
            },
        ];
    }
}