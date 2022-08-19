<?php

namespace App\Http\Controllers\Appraisal;

use App\Model\Departement;
use App\Model\GradeGroup;
use App\Model\User;
use App\Model\Appraisal\AppraisalCompetency;
use App\Model\Appraisal\AppraisalMain;
use App\Model\Appraisal\AppraisalMilestone;
use App\Model\Appraisal\AppraisalMilestoneDetail;
use App\Model\Appraisal\AppraisalMilestoneNext;
use App\Model\Appraisal\AppraisalMilestoneNextDetail;
use App\Model\Appraisal\AppraisalStaffCompetency;
use App\Model\Appraisal\AppraisalStaffMain;
use App\Model\Appraisal\AppraisalStaffObjective;
use App\Model\Appraisal\AppraisalStaffObjectiveNext;
use App\Model\Appraisal\AppraisalPeriod;
use App\Model\Appraisal\FinalScoreTemp;
use App\Model\Plugin\PluginPeriod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Exports\Appraisal\CompletedExport;
use App\Exports\Appraisal\ScoreExport;
use App\Imports\Appraisal\FinalScoreImport;
use Maatwebsite\Excel\Facades\Excel;

use Auth, DB, PDF;

class ReportController extends Controller
{
    protected $super_admin;
    protected $ceo;
    protected $ceo_name;
    protected $hr;
    protected $hod;

    // GRADE GROUP APPRAISAL ACCESS
    protected $gg_access;
    protected $gg_spv_above;
    protected $gg_staff;

    public function __construct()
    {
        // SUPER ADMIN : CHRIS SIMON, HUSIN, MUHAMMAD BONA RIZKI
        $this->super_admin = array(221, 454, 477);

        // CEO : AMIT KUMAR DAWN
        $this->ceo = array(408);
        $this->ceo_name = 'Amit Kumar Dawn';

        // HR : NI MADE SRI ANDANI
        $this->hr = array(152);

        // HEAD OF DEPARTMENT
        $this->hod = array(
            480, // DHIAN ENDRA NURPATRIA LAKSMANA - HOD FINANCE & ACCOUNTING
            286, // CHARLES VICTOR B SARAGIH - HOD IT
            111, // CIN JU - HOD MANUFACTURING
            645, // ISABELLA SILALAHI - HOD MARKETING
            174, // KARMIKA INDARTI - HOD R & D
            345, // ADITIA WIBISONO - HOD SALES
            408, // AMIT KUMAR DAWN - HOD SKINCARE
        );

        $this->gg_access = array(3,4,5,6,7);
        $this->gg_spv_above = array(4,5,6,7);
        $this->gg_staff = array(3);
    }

    public function completed()
    {
        $period_all = PluginPeriod::where('period_status', '1')->orderBy('period_name')->get();
        $period_name = date('m') <= 5 ? ((date('Y') - 1).'-'.date('Y')) : (date('Y').'-'.(date('Y') + 1));
        $period = PluginPeriod::where('period_name', $period_name)->first();

        $department = Departement::all();
        $grade_group = GradeGroup::whereIn('grade_group_id', $this->gg_access)->get();

        return view('appraisal.completed', compact('period_all', 'period', 'department', 'grade_group'));
    }

    public function score()
    {
        $period_all = PluginPeriod::where('period_status', '1')->orderBy('period_name')->get();
        $period_name = date('m') <= 5 ? ((date('Y') - 1).'-'.date('Y')) : (date('Y').'-'.(date('Y') + 1));
        $period = PluginPeriod::where('period_name', $period_name)->first();

        $department = Departement::all();
        $grade_group = GradeGroup::all();

        $super_admin = $this->super_admin;
        $ceo = $this->ceo;
        $hr = $this->hr;
        $hod = $this->hod;

        return view('appraisal.score', compact('period_all', 'period', 'department', 'grade_group', 'super_admin', 'ceo', 'hr', 'hod'));
    }

    public function tempUpload(Request $request)
    {
        $import = new FinalScoreImport();
        $import->import($request->file('filepond'));

        $message_arr = array();

        if($import->failures()) {
            foreach($import->failures() as $failure) {
                $error = 'Error on row '.$failure->row().' : '.implode(', ', $failure->errors());

                array_push($message_arr, $error);
            }
        }

        $message = implode('#', $message_arr);

        return response()->json($message);
    }

    public function resetFinalScoreTemp()
    {
        FinalScoreTemp::where('user_id', Auth::user()->user_id)->delete();

        return response()->json();
    }

    public function submitFinalScore(Request $request)
    {
        $period_name = date('m') <= 5 ? ((date('Y') - 1).'-'.date('Y')) : (date('Y').'-'.(date('Y') + 1));
        $period = PluginPeriod::where('period_name', $period_name)->first();

        $message = array();

        $final_score_temp = FinalScoreTemp::where('user_id', Auth::user()->user_id)->get();

        foreach($final_score_temp as $temp) {
            $user_exist = User::where('user_nik', $temp->nik)->exists();

            if($user_exist) {
                $user = User::where('user_nik', $temp->nik)->first();

                $appraisal_exist = AppraisalMain::where('user_id', $user->user_id)->where('period_id', $period->period_id)->exists();

                if($appraisal_exist) {
                    $appraisal = AppraisalMain::where('user_id', $user->user_id)->where('period_id', $period->period_id)->first();
                    $appraisal->final_score = $temp->final_score;
                    $appraisal->final_scorer = Auth::user()->user_name;
                    $appraisal->confidential_summary = $temp->confidential_summary;
                    $appraisal->updated_by = Auth::user()->user_name;
                    $appraisal->save();
                } else {
                    $appraisal_staff_exist = AppraisalStaffMain::where('user_id', $user->user_id)->where('period_id', $period->period_id)->exists();

                    if($appraisal_staff_exist) {
                        $appraisal = AppraisalStaffMain::where('user_id', $user->user_id)->where('period_id', $period->period_id)->first();
                        $appraisal->final_score = $temp->final_score;
                        $appraisal->final_scorer = Auth::user()->user_name;
                        $appraisal->confidential_summary = $temp->confidential_summary;
                        $appraisal->updated_by = Auth::user()->user_name;
                        $appraisal->save();
                    } else {
                        array_push($message, 'Appraisal Not Found');
                    }
                }

                FinalScoreTemp::where('id', $temp->id)->delete();
            } else {
                array_push($message, 'Employee NIK Not Found');
            }
        }

        return response()->json($message);
    }

    public function getAppraisalCompleted(Request $request)
    {
        $period = NULL;
        if($request->has('period_id')) {
            $period = $request->get('period_id');
        }

        $department = NULL;
        if($request->has('department_id')) {
            $department = $request->get('department_id');
        }

        $grade_group = NULL;
        if($request->has('grade_group_id')) {
            $grade_group = $request->get('grade_group_id');
        }

        $spv_above = AppraisalMain::query()
            ->selectRaw('trans_appraisal_main.appraisal_id,
                trans_appraisal_main.user_id, user.user_nik, user.user_name,
                CONCAT("[", user.user_nik, "] ", user.user_name) AS user_nik_name,
                trans_appraisal_main.department_id, dept.department_name,
                trans_appraisal_main.grade_group_id, gg.grade_group_name,
                trans_appraisal_main.overall_milestone_score,
                trans_appraisal_main.overall_competency_score,
                trans_appraisal_main.overall_performance_score,
                IFNULL(trans_appraisal_main.final_score, "-") AS final_score,
                trans_appraisal_main.final_scorer')
            ->leftJoin('mst_main_user AS user', 'user.user_id', 'trans_appraisal_main.user_id')
            ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'trans_appraisal_main.department_id')
            ->leftJoin('mst_main_user_grade_group AS gg', 'gg.grade_group_id', 'trans_appraisal_main.grade_group_id')
            ->where('trans_appraisal_main.appraisal_status', 'CLOSED');

        $staff = AppraisalStaffMain::query()
            ->selectRaw('trans_appraisal_staff_main.appraisal_staff_id,
                trans_appraisal_staff_main.user_id, trans_appraisal_staff_main.appraisal_user_nik, trans_appraisal_staff_main.appraisal_user_name,
                CONCAT("[", trans_appraisal_staff_main.appraisal_user_nik, "] ", trans_appraisal_staff_main.appraisal_user_name) AS user_nik_name,
                trans_appraisal_staff_main.department_id, dept.department_name,
                "Staff" AS grade_group_name,
                trans_appraisal_staff_main.overall_objective_score AS overall_milestone_score,
                trans_appraisal_staff_main.overall_competency_score,
                trans_appraisal_staff_main.overall_performance_score,
                IFNULL(trans_appraisal_staff_main.final_score, "-") AS final_score,
                trans_appraisal_staff_main.final_scorer')
            ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'trans_appraisal_staff_main.department_id')
            ->where('trans_appraisal_staff_main.appraisal_status', 'CLOSED');

        if($period > 0) {
            $spv_above = $spv_above->where('trans_appraisal_main.period_id', $period);
            $staff = $staff->where('trans_appraisal_staff_main.period_id', $period);
        }

        if($department > 0) {
            $spv_above = $spv_above->where('trans_appraisal_main.department_id', $department);
            $staff = $staff->where('trans_appraisal_staff_main.department_id', $department);
        }

        if($grade_group > 0) {
            $spv_above = $spv_above->where('trans_appraisal_main.grade_group_id', $grade_group);

            if(!in_array($grade_group, $this->gg_staff)) {
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

        return datatables()->of($data)->addIndexColumn()
            ->addColumn('edit', function($data) {
                if($data->user_id != Auth::user()->user_id && $data->final_scorer != $this->ceo_name && (in_array(Auth::user()->user_id, $this->hr) || in_array(Auth::user()->user_id, $this->hod) || in_array(Auth::user()->user_id, $this->ceo))) {
                    return '<a href="javascript:;" class="btn-final-score" data-id="'.($data->grade_group_name == 'Staff' ? $data->appraisal_staff_id : $data->appraisal_id).'" data-type="'.($data->grade_group_name == 'Staff' ? 'staff' : 'spv_above').'" data-toggle="tooltip" title="Final Score"><i class="fa fa-edit"></i></a>';
                } else {
                    return '<a href="javascript:;" data-toggle="tooltip" title="Final Score"><i class="fa fa-lock"></i></a>';
                }
            })
            ->addColumn('view', function($data) {
                return '<a href="javascript:;" class="'.($data->grade_group_name == 'Staff' ? 'btn-view_confidential_staff' : 'btn-view_closed').'" data-id="'.($data->grade_group_name == 'Staff' ? $data->appraisal_staff_id : $data->appraisal_id).'" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></a>';
            })
            ->addColumn('export', function($data) {
                return '<form target="_blank" action="'.url('/appraisal/export').'" method="post"><input type="hidden" name="_token" value="'.csrf_token().'"><input type="hidden" name="type" value="'.($data->grade_group_name == 'Staff' ? 'staff' : 'spv_above').'"><input type="hidden" name="id" value="'.($data->grade_group_name == 'Staff' ? $data->appraisal_staff_id : $data->appraisal_id).'"><a href="javascript:;" class="btn-export-pdf"><i class="fa fa-file-pdf"></i></a></form>';
            })
            ->rawColumns(['edit', 'view', 'export'])
        ->toJson();
    }

    public function exportAppraisalCompleted(Request $request)
    {
        $period = NULL;
        if($request->has('period_id')) {
            $period = $request->get('period_id');
        }

        $department = NULL;
        if($request->has('department_id')) {
            $department = $request->get('department_id');
        }

        $grade_group = NULL;
        if($request->has('grade_group_id')) {
            $grade_group = $request->get('grade_group_id');
        }

        $period_name = PluginPeriod::where('period_id', $period)->first()->period_name;

        if($department > 0) {
            $department_name = Departement::where('department_id', $department)->first()->department_name;
        } else {
            $department_name = 'ALL DEPARTMENT';
        }

        if($grade_group > 0) {
            $grade_group_name = GradeGroup::where('grade_group_id', $grade_group)->first()->grade_group_name;
        } else {
            $grade_group_name = 'ALL LEVEL';
        }

        return Excel::download(new CompletedExport($period, $department, $grade_group), 'APR '.$period_name.' '.$department_name.' & '.$grade_group_name.'.xlsx');
    }

    public function getAppraisalScore(Request $request)
    {
        $period = NULL;
        if($request->has('period_id')) {
            $period = $request->get('period_id');
        }

        $department = NULL;
        if($request->has('department_id')) {
            $department = $request->get('department_id');
        }

        $status = NULL;
        if($request->has('appraisal_status')) {
            $status = $request->get('appraisal_status');
        }

        $appraisal_period = AppraisalPeriod::where('period_id', $period)->first();
        $grade_group = GradeGroup::whereIn('grade_group_id', $this->gg_access)->get();

        $data = array();

        foreach($grade_group as $key => $gg) {
            $data[$key] = (object) array();

            $data[$key]->grade_group_id = $gg->grade_group_id;
            $data[$key]->grade_group_name = $gg->grade_group_name;

            if($gg->grade_group_name == 'Staff') {
                $data[$key]->headcount = User::query()
                    ->selectRaw('COUNT(mst_main_user.user_id) AS count_user')
                    ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'mst_main_user.grade_id')
                    ->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_staff_period_start.'", mst_main_user.user_join_date) > 180')
                    ->where('g.grade_group_id', $gg->grade_group_id);

                $data[$key]->not_scored = AppraisalStaffMain::query()
                    ->selectRaw('COUNT(appraisal_staff_id) AS count_user')
                    ->whereNull('overall_performance_score')
                    ->where('period_id', $period);

                $data[$key]->osc = AppraisalStaffMain::query()
                    ->selectRaw('COUNT(appraisal_staff_id) AS count_appraisal')
                    ->where('overall_performance_score', 'LIKE', '%OSC%')
                    ->where('period_id', $period);

                $data[$key]->ecc = AppraisalStaffMain::query()
                    ->selectRaw('COUNT(appraisal_staff_id) AS count_appraisal')
                    ->where('overall_performance_score', 'LIKE', '%ECC%')
                    ->where('period_id', $period);

                $data[$key]->hvc = AppraisalStaffMain::query()
                    ->selectRaw('COUNT(appraisal_staff_id) AS count_appraisal')
                    ->where('overall_performance_score', 'LIKE', '%HVC%')
                    ->where('period_id', $period);

                $data[$key]->mce = AppraisalStaffMain::query()
                    ->selectRaw('COUNT(appraisal_staff_id) AS count_appraisal')
                    ->where('overall_performance_score', 'LIKE', '%MCE%')
                    ->where('period_id', $period);

                $data[$key]->usc = AppraisalStaffMain::query()
                    ->selectRaw('COUNT(appraisal_staff_id) AS count_appraisal')
                    ->where('overall_performance_score', 'LIKE', '%USC%')
                    ->where('period_id', $period);
            } else {
                $data[$key]->headcount = User::query()
                    ->selectRaw('COUNT(mst_main_user.user_id) AS count_user')
                    ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'mst_main_user.grade_id')
                    ->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_period_start.'", mst_main_user.user_join_date) > 180')
                    ->where('g.grade_group_id', $gg->grade_group_id);

                $data[$key]->not_scored = AppraisalMain::query()
                    ->selectRaw('COUNT(appraisal_id) AS count_user')
                    ->whereNull('overall_performance_score')
                    ->where('period_id', $period)
                    ->where('grade_group_id', $gg->grade_group_id);

                $data[$key]->osc = AppraisalMain::query()
                    ->selectRaw('COUNT(appraisal_id) AS count_appraisal')
                    ->where('overall_performance_score', 'LIKE', '%OSC%')
                    ->where('period_id', $period)
                    ->where('grade_group_id', $gg->grade_group_id);

                $data[$key]->ecc = AppraisalMain::query()
                    ->selectRaw('COUNT(appraisal_id) AS count_appraisal')
                    ->where('overall_performance_score', 'LIKE', '%ECC%')
                    ->where('period_id', $period)
                    ->where('grade_group_id', $gg->grade_group_id);

                $data[$key]->hvc = AppraisalMain::query()
                    ->selectRaw('COUNT(appraisal_id) AS count_appraisal')
                    ->where('overall_performance_score', 'LIKE', '%HVC%')
                    ->where('period_id', $period)
                    ->where('grade_group_id', $gg->grade_group_id);

                $data[$key]->mce = AppraisalMain::query()
                    ->selectRaw('COUNT(appraisal_id) AS count_appraisal')
                    ->where('overall_performance_score', 'LIKE', '%MCE%')
                    ->where('period_id', $period)
                    ->where('grade_group_id', $gg->grade_group_id);

                $data[$key]->usc = AppraisalMain::query()
                    ->selectRaw('COUNT(appraisal_id) AS count_appraisal')
                    ->where('overall_performance_score', 'LIKE', '%USC%')
                    ->where('period_id', $period)
                    ->where('grade_group_id', $gg->grade_group_id);
            }

            if($department > 0) {
                $data[$key]->headcount = $data[$key]->headcount->where('department_id', $department);
                $data[$key]->not_scored = $data[$key]->not_scored->where('department_id', $department);
                $data[$key]->osc = $data[$key]->osc->where('department_id', $department);
                $data[$key]->ecc = $data[$key]->ecc->where('department_id', $department);
                $data[$key]->hvc = $data[$key]->hvc->where('department_id', $department);
                $data[$key]->mce = $data[$key]->mce->where('department_id', $department);
                $data[$key]->usc = $data[$key]->usc->where('department_id', $department);
            }

            if($status > 0) {
                if($status == '1') {
                    $data[$key]->osc = $data[$key]->osc->where('appraisal_status', 'CLOSED');
                    $data[$key]->ecc = $data[$key]->ecc->where('appraisal_status', 'CLOSED');
                    $data[$key]->hvc = $data[$key]->hvc->where('appraisal_status', 'CLOSED');
                    $data[$key]->mce = $data[$key]->mce->where('appraisal_status', 'CLOSED');
                    $data[$key]->usc = $data[$key]->usc->where('appraisal_status', 'CLOSED');
                } else if($status == '2') {
                    $data[$key]->osc = $data[$key]->osc->where('appraisal_status', 'IN PROGRESS');
                    $data[$key]->ecc = $data[$key]->ecc->where('appraisal_status', 'IN PROGRESS');
                    $data[$key]->hvc = $data[$key]->hvc->where('appraisal_status', 'IN PROGRESS');
                    $data[$key]->mce = $data[$key]->mce->where('appraisal_status', 'IN PROGRESS');
                    $data[$key]->usc = $data[$key]->usc->where('appraisal_status', 'IN PROGRESS');
                }
            }

            $data[$key]->headcount = $data[$key]->headcount->first()->count_user;
            $data[$key]->not_scored = $data[$key]->not_scored->first()->count_user;
            $data[$key]->osc = $data[$key]->osc->first()->count_appraisal;
            $data[$key]->ecc = $data[$key]->ecc->first()->count_appraisal;
            $data[$key]->hvc = $data[$key]->hvc->first()->count_appraisal;
            $data[$key]->mce = $data[$key]->mce->first()->count_appraisal;
            $data[$key]->usc = $data[$key]->usc->first()->count_appraisal;
        }

        return datatables()->of($data)->addIndexColumn()->toJson();
    }

    public function getAppraisalScoreSum(Request $request)
    {
        $period = NULL;
        if($request->has('period_id')) {
            $period = $request->get('period_id');
        }

        $department = NULL;
        if($request->has('department_id')) {
            $department = $request->get('department_id');
        }

        $appraisal_period = AppraisalPeriod::where('period_id', $period)->first();

        $user_staff = User::query()
            ->selectRaw('COUNT(mst_main_user.user_id) AS count_user')
            ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'mst_main_user.grade_id')
            ->whereIn('g.grade_group_id', $this->gg_staff)
            ->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_staff_period_start.'", mst_main_user.user_join_date) > 180');

        $user_spv_above = User::query()
            ->selectRaw('COUNT(mst_main_user.user_id) AS count_user')
            ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'mst_main_user.grade_id')
            ->whereIn('g.grade_group_id', $this->gg_spv_above)
            ->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_period_start.'", mst_main_user.user_join_date) > 180');

        $osc_staff = AppraisalStaffMain::query()
            ->selectRaw('COUNT(appraisal_staff_id) AS count_appraisal')
            ->where('overall_performance_score', 'LIKE', '%OSC%')
            ->where('appraisal_status', 'CLOSED')
            ->where('period_id', $period);

        $osc_spv_above = AppraisalMain::query()
            ->selectRaw('COUNT(appraisal_id) AS count_appraisal')
            ->where('overall_performance_score', 'LIKE', '%OSC%')
            ->where('appraisal_status', 'CLOSED')
            ->where('period_id', $period);

        $ecc_staff = AppraisalStaffMain::query()
            ->selectRaw('COUNT(appraisal_staff_id) AS count_appraisal')
            ->where('overall_performance_score', 'LIKE', '%ECC%')
            ->where('appraisal_status', 'CLOSED')
            ->where('period_id', $period);

        $ecc_spv_above = AppraisalMain::query()
            ->selectRaw('COUNT(appraisal_id) AS count_appraisal')
            ->where('overall_performance_score', 'LIKE', '%ECC%')
            ->where('appraisal_status', 'CLOSED')
            ->where('period_id', $period);

        $hvc_staff = AppraisalStaffMain::query()
            ->selectRaw('COUNT(appraisal_staff_id) AS count_appraisal')
            ->where('overall_performance_score', 'LIKE', '%HVC%')
            ->where('appraisal_status', 'CLOSED')
            ->where('period_id', $period);

        $hvc_spv_above = AppraisalMain::query()
            ->selectRaw('COUNT(appraisal_id) AS count_appraisal')
            ->where('overall_performance_score', 'LIKE', '%HVC%')
            ->where('appraisal_status', 'CLOSED')
            ->where('period_id', $period);

        $mce_staff = AppraisalStaffMain::query()
            ->selectRaw('COUNT(appraisal_staff_id) AS count_appraisal')
            ->where('overall_performance_score', 'LIKE', '%MCE%')
            ->where('appraisal_status', 'CLOSED')
            ->where('period_id', $period);

        $mce_spv_above = AppraisalMain::query()
            ->selectRaw('COUNT(appraisal_id) AS count_appraisal')
            ->where('overall_performance_score', 'LIKE', '%MCE%')
            ->where('appraisal_status', 'CLOSED')
            ->where('period_id', $period);

        $usc_staff = AppraisalStaffMain::query()
            ->selectRaw('COUNT(appraisal_staff_id) AS count_appraisal')
            ->where('overall_performance_score', 'LIKE', '%USC%')
            ->where('appraisal_status', 'CLOSED')
            ->where('period_id', $period);

        $usc_spv_above = AppraisalMain::query()
            ->selectRaw('COUNT(appraisal_id) AS count_appraisal')
            ->where('overall_performance_score', 'LIKE', '%USC%')
            ->where('appraisal_status', 'CLOSED')
            ->where('period_id', $period);

        if($department > 0) {
            $user_staff = $user_staff->where('mst_main_user.department_id', $department);
            $user_spv_above = $user_spv_above->where('mst_main_user.department_id', $department);
            $osc_staff = $osc_staff->where('department_id', $department);
            $osc_spv_above = $osc_spv_above->where('department_id', $department);
            $ecc_staff = $ecc_staff->where('department_id', $department);
            $ecc_spv_above = $ecc_spv_above->where('department_id', $department);
            $hvc_staff = $hvc_staff->where('department_id', $department);
            $hvc_spv_above = $hvc_spv_above->where('department_id', $department);
            $mce_staff = $mce_staff->where('department_id', $department);
            $mce_spv_above = $mce_spv_above->where('department_id', $department);
            $usc_staff = $usc_staff->where('department_id', $department);
            $usc_spv_above = $usc_spv_above->where('department_id', $department);
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

        $data = array();
        $data[0] = (object) array();
        $data[0]->osc = number_format((($osc_staff + $osc_spv_above) / ($user_staff + $user_spv_above) * 100), 2, '.', ',').' %';
        $data[0]->ecc = number_format((($ecc_staff + $ecc_spv_above) / ($user_staff + $user_spv_above) * 100), 2, '.', ',').' %';
        $data[0]->hvc = number_format((($hvc_staff + $hvc_spv_above) / ($user_staff + $user_spv_above) * 100), 2, '.', ',').' %';
        $data[0]->mce = number_format((($mce_staff + $mce_spv_above) / ($user_staff + $user_spv_above) * 100), 2, '.', ',').' %';
        $data[0]->usc = number_format((($usc_staff + $usc_spv_above) / ($user_staff + $user_spv_above) * 100), 2, '.', ',').' %';

        return datatables()->of($data)->toJson();
    }

    public function exportAppraisalScore(Request $request)
    {
        $period = NULL;
        if($request->has('period_id')) {
            $period = $request->get('period_id');
        }

        $department = NULL;
        if($request->has('department_id')) {
            $department = $request->get('department_id');
        }

        $status = NULL;
        if($request->has('status')) {
            $status = $request->get('status');
        }

        $period_name = PluginPeriod::where('period_id', $period)->first()->period_name;

        if($department > 0) {
            $department_name = Departement::where('department_id', $department)->first()->department_name;
        } else {
            $department_name = 'ALL DEPARTMENT';
        }

        if($status == 0) {
            $status_name = 'ALL STATUS';
        } else if($status == 1) {
            $status_name = 'APPROVED';
        } else if($status == 2) {
            $status_name = 'WAITING APPROVAL';
        }

        return Excel::download(new ScoreExport($period, $department, $status), 'APR SCORE '.$period_name.' '.$department_name.' '.$status_name.'.xlsx');
    }

    public function exportConfidential(Request $request)
    {
        $appraisal = AppraisalMain::query()
            ->selectRaw('trans_appraisal_main.*,
                user.user_nik,
                user.user_name,
                dept.department_name,
                ugg.grade_group_name,
                ut.title_name AS user_title,
                ut1.title_name AS approval1_title,
                ut2.title_name AS approval2_title,
                ut3.title_name AS approval3_title,
                ut4.title_name AS approval4_title,
                ut5.title_name AS approval5_title,
                ut6.title_name AS approval6_title,
                ut_hr.title_name AS hr_title')
            ->leftJoin('mst_main_user AS user', 'user.user_id', 'trans_appraisal_main.user_id')
            ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'user.department_id')
            ->leftJoin('mst_main_user_grade AS ug', 'ug.grade_id', 'user.grade_id')
            ->leftJoin('mst_main_user_grade_group AS ugg', 'ugg.grade_group_id', 'ug.grade_group_id')
            ->leftJoin('mst_main_user_title AS ut', 'ut.title_id', 'user.title_id')
            ->leftJoin('mst_main_user AS u1', 'u1.user_nik', 'trans_appraisal_main.appraisal_approval_nik_1')
            ->leftJoin('mst_main_user_title AS ut1', 'ut1.title_id', 'u1.title_id')
            ->leftJoin('mst_main_user AS u2', 'u2.user_nik', 'trans_appraisal_main.appraisal_approval_nik_2')
            ->leftJoin('mst_main_user_title AS ut2', 'ut2.title_id', 'u2.title_id')
            ->leftJoin('mst_main_user AS u3', 'u3.user_nik', 'trans_appraisal_main.appraisal_approval_nik_3')
            ->leftJoin('mst_main_user_title AS ut3', 'ut3.title_id', 'u3.title_id')
            ->leftJoin('mst_main_user AS u4', 'u4.user_nik', 'trans_appraisal_main.appraisal_approval_nik_4')
            ->leftJoin('mst_main_user_title AS ut4', 'ut4.title_id', 'u4.title_id')
            ->leftJoin('mst_main_user AS u5', 'u5.user_nik', 'trans_appraisal_main.appraisal_approval_nik_5')
            ->leftJoin('mst_main_user_title AS ut5', 'ut5.title_id', 'u5.title_id')
            ->leftJoin('mst_main_user AS u6', 'u6.user_nik', 'trans_appraisal_main.appraisal_approval_nik_6')
            ->leftJoin('mst_main_user_title AS ut6', 'ut6.title_id', 'u6.title_id')
            ->leftJoin('mst_main_user AS user_hr', 'user_hr.user_nik', 'trans_appraisal_main.appraisal_approval_nik_hr')
            ->leftJoin('mst_main_user_title AS ut_hr', 'ut_hr.title_id', 'user_hr.title_id')
            ->where('trans_appraisal_main.appraisal_id', $request->id)
        ->first();

        $period = PluginPeriod::where('period_id', $appraisal->period_id)->first();

        $milestone = AppraisalMilestoneDetail::query()
            ->selectRaw('trans_appraisal_milestone_detail.appraisal_milestone_detail_id,
                IFNULL(trans_appraisal_milestone_detail.milestone_description, "-") AS milestone_description,
                IFNULL(trans_appraisal_milestone_detail.milestone_measurement, "-") AS milestone_measurement,
                IFNULL(trans_appraisal_milestone_detail.employee_assessment, "-") AS employee_assessment,
                IFNULL(trans_appraisal_milestone_detail.superior_assessment, "-") AS superior_assessment,
                trans_appraisal_milestone_detail.superior_score,
                trans_appraisal_milestone_detail.appraisal_milestone_id,
                tao.milestone_id,
                tao.overall_score,
                mao.milestone_eng,
                mao.milestone_bhs')
            ->leftJoin('trans_appraisal_milestone AS tao', 'tao.appraisal_milestone_id', 'trans_appraisal_milestone_detail.appraisal_milestone_id')
            ->leftJoin('mst_appraisal_milestone AS mao', 'mao.milestone_id', 'tao.milestone_id')
            ->where('tao.appraisal_id', $appraisal->appraisal_id)
        ->get();

        $competency = AppraisalCompetency::query()
            ->selectRaw('trans_appraisal_competency.appraisal_competency_id,
                trans_appraisal_competency.employee_rating,
                trans_appraisal_competency.superior_rating,
                trans_appraisal_competency.superior_comment,
                trans_appraisal_competency.competency_id,
                ac.competency_eng,
                ac.competency_bhs')
            ->leftJoin('mst_appraisal_competency AS ac', 'ac.competency_id', 'trans_appraisal_competency.competency_id')
            ->where('trans_appraisal_competency.appraisal_id', $appraisal->appraisal_id)
            ->groupBy('trans_appraisal_competency.appraisal_competency_id')
        ->get();

        $milestone_next = AppraisalMilestoneNextDetail::query()
            ->selectRaw('trans_appraisal_milestone_next_detail.appraisal_milestone_next_detail_id,
                IFNULL(trans_appraisal_milestone_next_detail.milestone_description, "-") AS milestone_description,
                IFNULL(trans_appraisal_milestone_next_detail.milestone_measurement, "-") AS milestone_measurement,
                trans_appraisal_milestone_next_detail.appraisal_milestone_next_id,
                tamn.milestone_id,
                mam.milestone_eng,
                mam.milestone_bhs')
            ->leftJoin('trans_appraisal_milestone_next AS tamn', 'tamn.appraisal_milestone_next_id', 'trans_appraisal_milestone_next_detail.appraisal_milestone_next_id')
            ->leftJoin('mst_appraisal_milestone AS mam', 'mam.milestone_id', 'tamn.milestone_id')
            ->where('tamn.appraisal_id', $appraisal->appraisal_id)
        ->get();

        $pdf = PDF::loadView('appraisal.export.export_confidential', ['appraisal' => $appraisal, 'period' => $period, 'milestone' => $milestone, 'competency' => $competency, 'milestone_next' => $milestone_next]);

        $pdf->setOptions([
            'enable-local-file-access' => true,
            'enable-javascript' => true,
            'header-html' => view('appraisal.export.export_header'),
            'header-spacing' => 7,
            'footer-html' => view('appraisal.export.export_footer'),
            'footer-spacing' => 7,
            'margin-left' => '0mm',
            'margin-right' => '0mm',
            'margin-top' => '40mm',
            'margin-bottom' => '40mm'
        ]);

        return $pdf->inline('APR CONF '.$period->period_name.' '.$appraisal->user_nik.' - '.$appraisal->user_name.'.pdf');
    }

    public function getFinalScoreTemp(Request $request)
    {
        $temp = FinalScoreTemp::where('user_id', Auth::user()->user_id)->get();

        return datatables()->of($temp)->addIndexColumn()
            ->addColumn('confidential_summary', function($temp) {
                return str_replace("\r\n", '<br>', $temp->confidential_summary);
            })
            ->rawColumns(['confidential_summary'])
        ->toJson();
    }

}
