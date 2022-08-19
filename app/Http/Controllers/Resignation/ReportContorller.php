<?php

namespace App\Http\Controllers\Resignation;

use App\Model\Departement;
use App\Model\GradeGroup;
use App\Model\Plugin\PluginMonth;
use App\Model\Plugin\PluginPeriod;
use App\Model\Plugin\PluginYear;
use App\Model\Resignation\Feedback;
use App\Model\Resignation\Resign;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Resignation\ReportService;

use App\Exports\Resignation\AttritionBasedOnReasonExport;
use App\Exports\Resignation\AttritionBasedOnYearsExport;
use App\Exports\Resignation\AttritionDepartmentExport;
use Maatwebsite\Excel\Facades\Excel;

class ReportContorller extends Controller
{
    private $ReportService;

    public function __construct(ReportService $ReportService)
    {
        $this->ReportService = $ReportService;
    }

    public function ReferenceLetter($resign_id)
    {
        return $this->ReportService->ReferenceLetter($resign_id);
    }

    public function Clearance($resign_id)
    {
        return $this->ReportService->Clearance($resign_id);
    }

    public static function ValidationChecked($value,$answer)
    {
        return ReportService::ValidationChecked($value,$answer);
    }

    public function feedbackByID($resign_id)
    {
        return $this->ReportService->feedbackByID($resign_id);
    }

    public function getDataFeedbackForview(Request $request)
    {
        $data = $this->ReportService->getDataFeedbackForview($request);
        return \Response::success(["data"=>$data]);
    }

    public function downloadFeedback(Request $request)
    {
        return $this->ReportService->downloadFeedback($request);
    }

    public function getDataForview(Request $request)
    {
       $data = $this->ReportService->getDataForview($request);
       return \Response::success(["data"=>$data]);
    }

    public function ARDownload(Request $request)
    {
        return $this->ReportService->ARDownload($request);
    }

    public function ARTalentDownload(Request $request)
    {
        return $this->ReportService->ARTalentDownload($request);
    }

    public function getDataTalentForview(Request $request)
    {
        $data = $this->ReportService->getDataTalentForview($request);
        return \Response::success(["data"=>$data]);
    }

    public function getDataInitiationForview(Request $request)
    {
        $data = $this->ReportService->getDataInitiationForview($request);
        return \Response::success(["data"=>$data]);
    }

    public function ARInitiationDownload(Request $request)
    {
        return $this->ReportService->ARInitiationDownload($request);
    }
    
    public function AttritionBasedOnReason(Request $request)
    {
        $department = Departement::all();
        $month = PluginMonth::all();
        $year = PluginYear::where('year_status', '1')->get();

        $period_all = PluginPeriod::where('period_status', '1')->orderBy('period_name')->get();
        $period_name = date('m') <= 3 ? ((date('Y') - 1).'-'.date('Y')) : (date('Y').'-'.(date('Y') + 1));
        $period = PluginPeriod::where('period_name', $period_name)->first();

        return view('resignation.report.attrition_reason', compact('department', 'month', 'year', 'period_all', 'period'));
    }

    public function getAttritionBasedOnReason(Request $request)
    {
        $department = NULL;
        if($request->has('department_id')) {
            $department = $request->get('department_id');
        }

        $type = NULL;
        if($request->has('type')) {
            $type = $request->get('type');
        }

        $month = NULL;
        if($request->has('month')) {
            $month = $request->get('month');
        }

        $quarter = NULL;
        if($request->has('quarter')) {
            $quarter = $request->get('quarter');
        }

        $year = NULL;
        if($request->has('year')) {
            $year = $request->get('year');
        }

        $period = NULL;
        if($request->has('period_id')) {
            $period = $request->get('period_id');
        }

        $data = array();

        $grade_group = GradeGroup::orderBy('grade_group_id', 'DESC')->get();
        $reason = [
            'li' => 'Leadership Issue',
            'wl' => 'Working Location',
            'bb' => 'Better benefit',
            'cd' => 'Career development',
            'pr' => 'Family or Personal reason',
            'wlo' => 'Work load',
            'mr' => 'Medical reason',
            'ec' => 'Environment and culture'
        ];

        foreach($grade_group as $gg) {
            $object = (object) array();
            $object->grade_group = $gg->grade_group_name;

            foreach($reason as $key => $val) {
                $object->$key = Feedback::query()
                    ->selectRaw('COUNT(mst_resignation_feedback.resign_feedback_id) AS count_feedback')
                    ->leftJoin('mst_resignation_resign_list AS rl', 'rl.resign_id', 'mst_resignation_feedback.resign_id')
                    ->leftJoin('mst_main_user AS u', 'u.user_nik', 'rl.user_nik')
                    ->leftJoin('mst_main_user_grade AS ug', 'ug.grade_id', 'u.grade_id')
                    ->where('ug.grade_group_id', $gg->grade_group_id)
                    ->where('mst_resignation_feedback.resign_feedback_1', 'LIKE', '%'.$val.'%');

                if($department > 0) {
                    $object->$key = $object->$key->where('u.department_id', $department);
                }

                if($type == 1) { // MONTHLY
                    if($month != NULL && $year != NULL) {
                        $object->$key = $object->$key->whereMonth('rl.resign_date', $month)->whereYear('rl.resign_date', $year);
                    }
                } else if($type == 2) { // QUARTERLY
                    if($quarter != NULL && $year != NULL) {
                        if($quarter == 'Q1') {
                            $object->$key = $object->$key->where(function($query) {
                                $query->whereRaw('MONTH(rl.resign_date) = 04')
                                    ->orWhereRaw('MONTH(rl.resign_date) = 05')
                                    ->orWhereRaw('MONTH(rl.resign_date) = 06');
                            })->whereYear('rl.resign_date', $year);
                        } else if($quarter == 'Q2') {
                            $object->$key = $object->$key->where(function($query) {
                                $query->whereRaw('MONTH(rl.resign_date) = 07')
                                    ->orWhereRaw('MONTH(rl.resign_date) = 08')
                                    ->orWhereRaw('MONTH(rl.resign_date) = 09');
                            })->whereYear('rl.resign_date', $year);
                        } else if($quarter == 'Q3') {
                            $object->$key = $object->$key->where(function($query) {
                                $query->whereRaw('MONTH(rl.resign_date) = 10')
                                    ->orWhereRaw('MONTH(rl.resign_date) = 11')
                                    ->orWhereRaw('MONTH(rl.resign_date) = 12');
                            })->whereYear('rl.resign_date', $year);
                        } else if($quarter == 'Q4') {
                            $object->$key = $object->$key->where(function($query) {
                                $query->whereRaw('MONTH(rl.resign_date) = 01')
                                    ->orWhereRaw('MONTH(rl.resign_date) = 02')
                                    ->orWhereRaw('MONTH(rl.resign_date) = 03');
                            })->whereYear('rl.resign_date', $year);
                        }
                    }
                } else if($type == 3) { // PERIODICALLY
                    if($period > 0) {
                        $object->$key = $object->$key->where('rl.period_id', $period);
                    }
                }

                $object->$key = $object->$key->first()->count_feedback;
            }

            array_push($data, $object);
        }

        return datatables()->of($data)->addIndexColumn()->toJson();
    }

    public function exportAttritionBasedOnReason(Request $request)
    {
        $department = NULL;
        if($request->has('dept')) {
            $department = $request->get('dept');
        }

        $type = NULL;
        if($request->has('type')) {
            $type = $request->get('type');
        }

        $month = NULL;
        if($request->has('month')) {
            $month = $request->get('month');
        }

        $quarter = NULL;
        if($request->has('quarter')) {
            $quarter = $request->get('quarter');
        }

        $year = NULL;
        if($request->has('year')) {
            $year = $request->get('year');
        }

        $period = NULL;
        if($request->has('period')) {
            $period = $request->get('period');
        }

        return Excel::download(new AttritionBasedOnReasonExport($department, $type, $month, $quarter, $year, $period), 'attrition_reason.xlsx');
    }

    public function AttritionDepartment(Request $request)
    {
        $department = Departement::all();
        $month = PluginMonth::all();
        $year = PluginYear::where('year_status', '1')->get();

        $period_all = PluginPeriod::where('period_status', '1')->orderBy('period_name')->get();
        $period_name = date('m') <= 3 ? ((date('Y') - 1).'-'.date('Y')) : (date('Y').'-'.(date('Y') + 1));
        $period = PluginPeriod::where('period_name', $period_name)->first();

        return view('resignation.report.attrition_department', compact('department', 'month', 'year', 'period_all', 'period'));
    }

    public function getAttritionDepartment(Request $request)
    {
        $type = NULL;
        if($request->has('type')) {
            $type = $request->get('type');
        }

        $month = NULL;
        if($request->has('month')) {
            $month = $request->get('month');
        }

        $quarter = NULL;
        if($request->has('quarter')) {
            $quarter = $request->get('quarter');
        }

        $year = NULL;
        if($request->has('year')) {
            $year = $request->get('year');
        }

        $period = NULL;
        if($request->has('period_id')) {
            $period = $request->get('period_id');
        }

        $data = array();

        $grade_group = GradeGroup::orderBy('grade_group_id', 'DESC')->get();
        $department = Departement::pluck('department_id');

        foreach($grade_group as $gg) {
            $object = (object) array();
            $object->grade_group = $gg->grade_group_name;

            foreach($department as $key => $val) {
                $object->$val = Resign::query()
                    ->selectRaw('COUNT(mst_resignation_resign_list.resign_id) AS count_resign')
                    ->leftJoin('mst_main_user AS u', 'u.user_nik', 'mst_resignation_resign_list.user_nik')
                    ->leftJoin('mst_main_user_grade AS ug', 'ug.grade_id', 'u.grade_id')
                    ->where('mst_resignation_resign_list.resign_clearance_status', 'approve')
                    ->where('mst_resignation_resign_list.resign_status', 'approve')
                    ->where('ug.grade_group_id', $gg->grade_group_id)
                    ->where('u.department_id', $val);

                if($type == 1) { // MONTHLY
                    if($month != NULL && $year != NULL) {
                        $object->$val = $object->$val->whereMonth('mst_resignation_resign_list.resign_date', $month)->whereYear('mst_resignation_resign_list.resign_date', $year);
                    }
                } else if($type == 2) { // QUARTEmst_resignation_resign_listY
                    if($quarter != NULL && $year != NULL) {
                        if($quarter == 'Q1') {
                            $object->$val = $object->$val->where(function($query) {
                                $query->whereRaw('MONTH(mst_resignation_resign_list.resign_date) = 04')
                                    ->orWhereRaw('MONTH(mst_resignation_resign_list.resign_date) = 05')
                                    ->orWhereRaw('MONTH(mst_resignation_resign_list.resign_date) = 06');
                            })->whereYear('mst_resignation_resign_list.resign_date', $year);
                        } else if($quarter == 'Q2') {
                            $object->$val = $object->$val->where(function($query) {
                                $query->whereRaw('MONTH(mst_resignation_resign_list.resign_date) = 07')
                                    ->orWhereRaw('MONTH(mst_resignation_resign_list.resign_date) = 08')
                                    ->orWhereRaw('MONTH(mst_resignation_resign_list.resign_date) = 09');
                            })->whereYear('mst_resignation_resign_list.resign_date', $year);
                        } else if($quarter == 'Q3') {
                            $object->$val = $object->$val->where(function($query) {
                                $query->whereRaw('MONTH(mst_resignation_resign_list.resign_date) = 10')
                                    ->orWhereRaw('MONTH(mst_resignation_resign_list.resign_date) = 11')
                                    ->orWhereRaw('MONTH(mst_resignation_resign_list.resign_date) = 12');
                            })->whereYear('mst_resignation_resign_list.resign_date', $year);
                        } else if($quarter == 'Q4') {
                            $object->$val = $object->$val->where(function($query) {
                                $query->whereRaw('MONTH(mst_resignation_resign_list.resign_date) = 01')
                                    ->orWhereRaw('MONTH(mst_resignation_resign_list.resign_date) = 02')
                                    ->orWhereRaw('MONTH(mst_resignation_resign_list.resign_date) = 03');
                            })->whereYear('mst_resignation_resign_list.resign_date', $year);
                        }
                    }
                } else if($type == 3) { // PERIODICALLY
                    if($period > 0) {
                        $object->$val = $object->$val->where('mst_resignation_resign_list.period_id', $period);
                    }
                }

                $object->$val = $object->$val->first()->count_resign;
            }

            array_push($data, $object);
        }

        return datatables()->of($data)->addIndexColumn()->toJson();
    }

    public function exportAttritionDepartment(Request $request)
    {
        $type = NULL;
        if($request->has('type')) {
            $type = $request->get('type');
        }

        $month = NULL;
        if($request->has('month')) {
            $month = $request->get('month');
        }

        $quarter = NULL;
        if($request->has('quarter')) {
            $quarter = $request->get('quarter');
        }

        $year = NULL;
        if($request->has('year')) {
            $year = $request->get('year');
        }

        $period = NULL;
        if($request->has('period')) {
            $period = $request->get('period');
        }

        return Excel::download(new AttritionDepartmentExport($type, $month, $quarter, $year, $period), 'attrition_department.xlsx');
    }

    public function AttritionBasedOnYears(Request $request)
    {
        $department = Departement::all();
        $month = PluginMonth::all();
        $year = PluginYear::where('year_status', '1')->get();

        $period_all = PluginPeriod::where('period_status', '1')->orderBy('period_name')->get();
        $period_name = date('m') <= 3 ? ((date('Y') - 1).'-'.date('Y')) : (date('Y').'-'.(date('Y') + 1));
        $period = PluginPeriod::where('period_name', $period_name)->first();

        return view('resignation.report.attrition_years', compact('department', 'month', 'year', 'period_all', 'period'));
    }

    public function getAttritionBasedOnYears(Request $request)
    {
        $department = NULL;
        if($request->has('department_id')) {
            $department = $request->get('department_id');
        }

        $type = NULL;
        if($request->has('type')) {
            $type = $request->get('type');
        }

        $month = NULL;
        if($request->has('month')) {
            $month = $request->get('month');
        }

        $quarter = NULL;
        if($request->has('quarter')) {
            $quarter = $request->get('quarter');
        }

        $year = NULL;
        if($request->has('year')) {
            $year = $request->get('year');
        }

        $period = NULL;
        if($request->has('period_id')) {
            $period = $request->get('period_id');
        }

        $data = array();

        $grade_group = GradeGroup::orderBy('grade_group_id', 'DESC')->get();
        $work_year = [
            '1' => 'Less than 1 year',
            '2' => '1 to 3 years',
            '3' => '3 to 10 years',
            '4' => 'More than 10 years'
        ];

        foreach($grade_group as $gg) {
            $object = (object) array();
            $object->grade_group = $gg->grade_group_name;

            foreach($work_year as $key => $val) {
                $object->$key = Resign::query()
                    ->selectRaw('COUNT(mst_resignation_resign_list.resign_id) AS count_resign')
                    ->leftJoin('mst_main_user AS u', 'u.user_nik', 'mst_resignation_resign_list.user_nik')
                    ->leftJoin('mst_main_user_grade AS ug', 'ug.grade_id', 'u.grade_id')
                    ->where('ug.grade_group_id', $gg->grade_group_id);

                if($key == '1') {
                    $object->$key = $object->$key->whereRaw('DATEDIFF(mst_resignation_resign_list.resign_date, u.user_join_date) < 365');
                } else if($key == '2') {
                    $object->$key = $object->$key->whereRaw('DATEDIFF(mst_resignation_resign_list.resign_date, u.user_join_date) >= 365')->whereRaw('DATEDIFF(mst_resignation_resign_list.resign_date, u.user_join_date) < 1095');
                } else if($key == '3') {
                    $object->$key = $object->$key->whereRaw('DATEDIFF(mst_resignation_resign_list.resign_date, u.user_join_date) >= 1095')->whereRaw('DATEDIFF(mst_resignation_resign_list.resign_date, u.user_join_date) <= 3650');
                } else if($key == '4') {
                    $object->$key = $object->$key->whereRaw('DATEDIFF(mst_resignation_resign_list.resign_date, u.user_join_date) > 3650');
                }

                if($department > 0) {
                    $object->$key = $object->$key->where('u.department_id', $department);
                }

                if($type == 1) { // MONTHLY
                    if($month != NULL && $year != NULL) {
                        $object->$key = $object->$key->whereMonth('mst_resignation_resign_list.resign_date', $month)->whereYear('mst_resignation_resign_list.resign_date', $year);
                    }
                } else if($type == 2) { // QUARTERLY
                    if($quarter != NULL && $year != NULL) {
                        if($quarter == 'Q1') {
                            $object->$key = $object->$key->where(function($query) {
                                $query->whereRaw('MONTH(mst_resignation_resign_list.resign_date) = 04')
                                    ->orWhereRaw('MONTH(mst_resignation_resign_list.resign_date) = 05')
                                    ->orWhereRaw('MONTH(mst_resignation_resign_list.resign_date) = 06');
                            })->whereYear('mst_resignation_resign_list.resign_date', $year);
                        } else if($quarter == 'Q2') {
                            $object->$key = $object->$key->where(function($query) {
                                $query->whereRaw('MONTH(mst_resignation_resign_list.resign_date) = 07')
                                    ->orWhereRaw('MONTH(mst_resignation_resign_list.resign_date) = 08')
                                    ->orWhereRaw('MONTH(mst_resignation_resign_list.resign_date) = 09');
                            })->whereYear('mst_resignation_resign_list.resign_date', $year);
                        } else if($quarter == 'Q3') {
                            $object->$key = $object->$key->where(function($query) {
                                $query->whereRaw('MONTH(mst_resignation_resign_list.resign_date) = 10')
                                    ->orWhereRaw('MONTH(mst_resignation_resign_list.resign_date) = 11')
                                    ->orWhereRaw('MONTH(mst_resignation_resign_list.resign_date) = 12');
                            })->whereYear('mst_resignation_resign_list.resign_date', $year);
                        } else if($quarter == 'Q4') {
                            $object->$key = $object->$key->where(function($query) {
                                $query->whereRaw('MONTH(mst_resignation_resign_list.resign_date) = 01')
                                    ->orWhereRaw('MONTH(mst_resignation_resign_list.resign_date) = 02')
                                    ->orWhereRaw('MONTH(mst_resignation_resign_list.resign_date) = 03');
                            })->whereYear('mst_resignation_resign_list.resign_date', $year);
                        }
                    }
                } else if($type == 3) { // PERIODICALLY
                    if($period > 0) {
                        $object->$key = $object->$key->where('mst_resignation_resign_list.period_id', $period);
                    }
                }

                $object->$key = $object->$key->first()->count_resign;
            }

            array_push($data, $object);
        }

        return datatables()->of($data)->addIndexColumn()->toJson();
    }

    public function exportAttritionBasedOnYears(Request $request)
    {
        $department = NULL;
        if($request->has('dept')) {
            $department = $request->get('dept');
        }

        $type = NULL;
        if($request->has('type')) {
            $type = $request->get('type');
        }

        $month = NULL;
        if($request->has('month')) {
            $month = $request->get('month');
        }

        $quarter = NULL;
        if($request->has('quarter')) {
            $quarter = $request->get('quarter');
        }

        $year = NULL;
        if($request->has('year')) {
            $year = $request->get('year');
        }

        $period = NULL;
        if($request->has('period')) {
            $period = $request->get('period');
        }

        return Excel::download(new AttritionBasedOnYearsExport($department, $type, $month, $quarter, $year, $period), 'attrition_years.xlsx');
    }
}
