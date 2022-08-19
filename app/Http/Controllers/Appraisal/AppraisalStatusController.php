<?php

namespace App\Http\Controllers\Appraisal;

use App\Model\ApprovalMatrix;
use App\Model\Departement;
use App\Model\GradeGroup;
use App\Model\User;
use App\Model\Appraisal\AppraisalCompetency;
use App\Model\Appraisal\AppraisalCompetencyNew;
use App\Model\Appraisal\AppraisalMain;
use App\Model\Appraisal\AppraisalMilestone;
use App\Model\Appraisal\AppraisalMilestoneDetail;
use App\Model\Appraisal\AppraisalMilestoneNext;
use App\Model\Appraisal\AppraisalMilestoneNextDetail;
use App\Model\Appraisal\AppraisalPeriod;
use App\Model\Appraisal\AppraisalStaffCompetency;
use App\Model\Appraisal\AppraisalStaffMain;
use App\Model\Appraisal\AppraisalStaffObjective;
use App\Model\Appraisal\AppraisalStaffObjectiveNext;
use App\Model\Appraisal\Competency;
use App\Model\Appraisal\Objective;
use App\Model\Plugin\PluginPeriod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth, PDF;

class AppraisalStatusController extends Controller
{
    protected $super_admin;
    protected $super_admin_nik;
    protected $ceo;
    protected $ceo_name;
    protected $hr;
    protected $hr_admin;
    protected $hod;

    // GRADE GROUP APPRAISAL ACCESS
    protected $gg_access;
    protected $gg_spv_above;
    protected $gg_staff;
    protected $excluded_title;

    public function __construct()
    {
        // SUPER ADMIN : CHRIS SIMON, HUSIN, MUHAMMAD BONA RIZKI
        $this->super_admin = array(221, 454, 477);
        $this->super_admin_nik = array('65161410', '75862004', '76112008');

        // CEO : AMIT KUMAR DAWN
        $this->ceo = array(408);
        $this->ceo_name = 'Amit Kumar Dawn';

        // HR : NI MADE SRI ANDANI
        $this->hr = array(152);

        // HR ADMIN : ARDHINI RETNO PUTRI, YULIANA WIDYANTARI, HUSIN
        $this->hr_admin = array(279, 169, 454);

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
        $this->excluded_title = array(73); // Management Trainee
    }

    public function index()
    {
        $period_all = PluginPeriod::where('period_status', '1')->orderBy('period_name')->get();
        $period_name = date('m') <= 5 ? ((date('Y') - 1).'-'.date('Y')) : (date('Y').'-'.(date('Y') + 1));
        $period = PluginPeriod::where('period_name', $period_name)->first();

        $super_admin = $this->super_admin;
        $ceo = $this->ceo;
        $hr = $this->hr;
        $hr_admin = $this->hr_admin;
        $hod = $this->hod;

        $department = Departement::all();
        $grade_group = GradeGroup::whereIn('grade_group_id', $this->gg_access)->get();

        return view('appraisal.status', compact('period_all', 'period', 'super_admin', 'ceo', 'hr', 'hr_admin', 'hod', 'department', 'grade_group'));
    }

    public function feedback(Request $request)
    {
        if($request->type == 'staff') {
            $appraisal = AppraisalStaffMain::where('appraisal_staff_id', $request->id)->first();
            $appraisal->employee_feedback = $request->employee_feedback;
            $appraisal->updated_by = Auth::user()->user_name;
            $appraisal->save();
        } else {
            $appraisal = AppraisalMain::where('appraisal_id', $request->id)->first();
            $appraisal->employee_feedback = $request->employee_feedback;
            $appraisal->updated_by = Auth::user()->user_name;
            $appraisal->save();
        }

        return response()->json();
    }

    public function finalScore(Request $request)
    {
        if($request->type == 'staff') {
            $appraisal = AppraisalStaffMain::where('appraisal_staff_id', $request->id)->first();
            $appraisal->final_score = $request->final_score;
            $appraisal->final_scorer = Auth::user()->user_name;
            $appraisal->confidential_summary = $request->confidential_summary;
            $appraisal->updated_by = Auth::user()->user_name;
            $appraisal->save();
        } else {
            $appraisal = AppraisalMain::where('appraisal_id', $request->id)->first();
            $appraisal->final_score = $request->final_score;
            $appraisal->final_scorer = Auth::user()->user_name;
            $appraisal->confidential_summary = $request->confidential_summary;
            $appraisal->updated_by = Auth::user()->user_name;
            $appraisal->save();
        }

        return response()->json();
    }

    public function appraisalDetail(Request $request)
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
                tam.milestone_id,
                tam.overall_score,
                mam.milestone_eng,
                mam.milestone_bhs')
            ->leftJoin('trans_appraisal_milestone AS tam', 'tam.appraisal_milestone_id', 'trans_appraisal_milestone_detail.appraisal_milestone_id')
            ->leftJoin('mst_appraisal_milestone AS mam', 'mam.milestone_id', 'tam.milestone_id')
            ->where('tam.appraisal_id', $appraisal->appraisal_id)
        ->get();

        $competency = AppraisalCompetencyNew::query()
            ->selectRaw('trans_appraisal_competency_new.*, acn.*')
            ->leftJoin('mst_appraisal_competency_new AS acn', 'acn.competency_new_id', 'trans_appraisal_competency_new.competency_new_id')
            ->where('trans_appraisal_competency_new.appraisal_id', $appraisal->appraisal_id)
            ->groupBy('trans_appraisal_competency_new.appraisal_competency_new_id')
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

        $approval_matrix = ApprovalMatrix::query()
            ->selectRaw('u1.user_nik AS approval_nik_1, u1.user_name AS approval_name_1,
                u2.user_nik AS approval_nik_2, u2.user_name AS approval_name_2')
            ->leftJoin('mst_main_user AS u1', 'u1.user_nik', 'mst_main_user_approval_matrix.approval_nik_1')
            ->leftJoin('mst_main_user AS u2', 'u2.user_nik', 'mst_main_user_approval_matrix.approval_nik_2')
            ->where('mst_main_user_approval_matrix.user_nik', $appraisal->appraisal_user_nik)
        ->first();

        return response()->json([
            'appraisal' => $appraisal,
            'period' => $period,
            'milestone' => $milestone,
            'competency' => $competency,
            'milestone_next' => $milestone_next,
            'approval_matrix' => $approval_matrix
        ]);
    }

    public function getAppraisal(Request $request)
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

        $period_name = date('m') <= 5 ? ((date('Y') - 1).'-'.date('Y')) : (date('Y').'-'.(date('Y') + 1));
        $period_now = PluginPeriod::where('period_name', $period_name)->first();
        $appraisal_period = AppraisalPeriod::where('period_id', $period_now->period_id)->first();

        $hirarki = ApprovalMatrix::query()
            ->selectRaw('user_nik')
            ->where('approval_nik_1', Auth::user()->user_nik)
            ->orWhere('approval_nik_2', Auth::user()->user_nik)
            ->orWhere('approval_nik_3', Auth::user()->user_nik)
            ->orWhere('approval_nik_4', Auth::user()->user_nik)
            ->orWhere('approval_nik_5', Auth::user()->user_nik)
            ->orWhere('approval_nik_6', Auth::user()->user_nik)
            ->orWhere('approval_nik_hr', Auth::user()->user_nik)
        ->pluck('user_nik')->toArray();

    	$spv_above = User::query()
    		->selectRaw('am.*, mst_main_user.user_id, mst_main_user.user_nik, mst_main_user.user_name,
    			CONCAT("[", mst_main_user.user_nik, "] ", mst_main_user.user_name) AS user,
                dept.department_name, ugg.grade_group_name,
                matrix.approval_nik_1, matrix.approval_nik_2, matrix.approval_nik_3,
                matrix.approval_nik_4, matrix.approval_nik_5, matrix.approval_nik_6,
                matrix.approval_nik_hr')
    		->leftJoin('trans_appraisal_main AS am', function($join) use ($period) {
    			$join->on('am.user_id', 'mst_main_user.user_id')
    				->where('am.period_id', $period);
    		})
            ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'mst_main_user.department_id')
            ->leftJoin('mst_main_user_grade AS ug', 'ug.grade_id', 'mst_main_user.grade_id')
            ->leftJoin('mst_main_user_grade_group AS ugg', 'ugg.grade_group_id', 'ug.grade_group_id')
            ->leftJoin('mst_main_user_approval_matrix AS matrix', 'matrix.user_nik', 'mst_main_user.user_nik')
            ->whereIn('ug.grade_group_id', $this->gg_spv_above)
            ->whereNotIn('mst_main_user.title_id', $this->excluded_title)
            ->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_period_start.'", mst_main_user.user_join_date) > 180');

        $staff = User::query()
    		->selectRaw('asm.*, mst_main_user.user_id, mst_main_user.user_nik, mst_main_user.user_name,
    			CONCAT("[", mst_main_user.user_nik, "] ", mst_main_user.user_name) AS user,
                dept.department_name, ugg.grade_group_name,
                matrix.approval_nik_1, matrix.approval_nik_2, matrix.approval_nik_hr')
    		->leftJoin('trans_appraisal_staff_main AS asm', function($join) use ($period) {
    			$join->on('asm.user_id', 'mst_main_user.user_id')
    				->where('asm.period_id', $period);
    		})
            ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'mst_main_user.department_id')
            ->leftJoin('mst_main_user_grade AS ug', 'ug.grade_id', 'mst_main_user.grade_id')
            ->leftJoin('mst_main_user_grade_group AS ugg', 'ugg.grade_group_id', 'ug.grade_group_id')
            ->leftJoin('mst_main_user_approval_matrix AS matrix', 'matrix.user_nik', 'mst_main_user.user_nik')
            ->whereIn('ug.grade_group_id', $this->gg_staff)
            ->whereNotIn('mst_main_user.title_id', $this->excluded_title)
            ->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_staff_period_start.'", mst_main_user.user_join_date) > 180');

        if($department > 0) {
            $spv_above = $spv_above->where('mst_main_user.department_id', $department);
            $staff = $staff->where('mst_main_user.department_id', $department);
        }

        if($grade_group > 0) {
            $spv_above = $spv_above->where('ug.grade_group_id', $grade_group);
            $staff = $staff->where('ug.grade_group_id', $grade_group);
        }

        if(!in_array(Auth::user()->user_id, $this->hr_admin)) {
            $spv_above = $spv_above->where(function($query) use ($hirarki) {
                $query->where('mst_main_user.user_id', Auth::user()->user_id)
                    ->orWhereIn('mst_main_user.user_nik', $hirarki);
            });
        }

        if(!in_array(Auth::user()->user_id, $this->hr_admin)) {
            $staff = $staff->where(function($query) use ($hirarki) {
                $query->where('mst_main_user.user_id', Auth::user()->user_id)
                    ->orWhereIn('mst_main_user.user_nik', $hirarki);
            });
        }

        $spv_above = $spv_above->groupBy('mst_main_user.user_id')
            ->orderBy('mst_main_user.grade_id', 'DESC')
            ->orderBy('mst_main_user.user_nik')
    	->get();

        $staff = $staff->groupBy('mst_main_user.user_id')
            ->orderBy('mst_main_user.grade_id', 'DESC')
            ->orderBy('mst_main_user.user_nik')
        ->get();

        $data = array();

        foreach($spv_above as $val) {
            $data[] = $val;
        }

        foreach($staff as $val) {
            $data[] = $val;
        }

    	return datatables()->of($data)->addIndexColumn()
    		->addColumn('status', function($data) {
                if($data->appraisal_status == null || $data->appraisal_status == 'DRAFT') {
                    return 'OPEN';
                } else if($data->appraisal_status == 'REJECTED') {
                    return '<span class="text-danger"> REJECTED </span>';
                } else {
                    return $data->appraisal_status;
                }
            })
            ->addColumn('action_needed', function($data) use ($period, $period_now) {
                if($data->appraisal_status == null || $data->appraisal_status == 'DRAFT' || $data->appraisal_status == 'REJECTED') {
                    if($data->grade_group_name != 'Staff' && $data->appraisal_milestone_status == 'DRAFT') {
                        if($data->user_nik == Auth::user()->user_nik && $period == $period_now->period_id) {
                            return '<a href="'.url('/appraisal/form').'" class="btn btn-sm btn-primary">Submit Your Appraisal Milestone</a>';
                        } else {
                            return '<small>Employee need to submit Appraisal Milestone</small>';
                        }
                    } else if($data->grade_group_name != 'Staff' && $data->appraisal_milestone_status == 'PENDING') {
                        if($data->appraisal_approval_status_milestone == NULL && $data->approval_nik_1 == Auth::user()->user_nik) {
                            return '<form action="'.url('/appraisal/approval').'" method="post"><input type="hidden" name="_token" value="'.csrf_token().'"><input type="hidden" name="id" value="'.$data->appraisal_id.'"><button type="submit" class="btn btn-sm btn-primary">Need Your Approval</button></form>';
                        } else {
                            return '<small>Need <b>'.User::where('user_nik', $data->approval_nik_1)->withTrashed()->first()->user_name.'</b> Approval on Milestone</small>';
                        }
                    } else {
                        if($data->user_nik == Auth::user()->user_nik && $period == $period_now->period_id) {
                            return '<a href="'.url('/appraisal/form').'" class="btn btn-sm btn-primary">Submit Your Appraisal Form</a>';
                        } else {
                            return '<small>Employee need to submit Appraisal Form</small>';
                        }
                    }
                } else {
                    if($data->grade_group_name == 'Staff') {
                        if($data->appraisal_status == 'OPEN' || $data->appraisal_status == 'IN PROGRESS') {
                            if($data->appraisal_approval_status_1 == NULL && $data->approval_nik_1 != NULL) {
                                if($data->approval_nik_1 == Auth::user()->user_nik) {
                                    return '<form action="'.url('/appraisal/approval').'" method="post"><input type="hidden" name="_token" value="'.csrf_token().'"><input type="hidden" name="type" value="'.($data->grade_group_name == 'Staff' ? 'staff' : 'spv_above').'"><input type="hidden" name="id" value="'.($data->grade_group_name == 'Staff' ? $data->appraisal_staff_id : $data->appraisal_id).'"><button type="submit" class="btn btn-sm btn-primary">Need Your Approval</button></form>';
                                } else {
                                    return '<small>Need <b>'.User::where('user_nik', $data->approval_nik_1)->withTrashed()->first()->user_name.'</b> Approval</small>';
                                }
                            } else if($data->appraisal_approval_status_2 == NULL && $data->approval_nik_2 != NULL) {
                                if($data->appraisal_approval_status_1 == '1' && $data->approval_nik_2 == Auth::user()->user_nik) {
                                    return '<form action="'.url('/appraisal/approval').'" method="post"><input type="hidden" name="_token" value="'.csrf_token().'"><input type="hidden" name="type" value="'.($data->grade_group_name == 'Staff' ? 'staff' : 'spv_above').'"><input type="hidden" name="id" value="'.($data->grade_group_name == 'Staff' ? $data->appraisal_staff_id : $data->appraisal_id).'"><button type="submit" class="btn btn-sm btn-primary">Need Your Approval</button></form>';
                                } else {
                                    return '<small>Need <b>'.User::where('user_nik', $data->approval_nik_2)->withTrashed()->first()->user_name.'</b> Approval</small>';
                                }
                            } else if($data->appraisal_approval_status_hr == NULL && $data->approval_nik_hr != NULL) {
                                if($data->appraisal_approval_status_2 == '1' && $data->approval_nik_hr == Auth::user()->user_nik) {
                                    return '<form action="'.url('/appraisal/approval').'" method="post"><input type="hidden" name="_token" value="'.csrf_token().'"><input type="hidden" name="type" value="'.($data->grade_group_name == 'Staff' ? 'staff' : 'spv_above').'"><input type="hidden" name="id" value="'.($data->grade_group_name == 'Staff' ? $data->appraisal_staff_id : $data->appraisal_id).'"><button type="submit" class="btn btn-sm btn-primary">Need Your Approval</button></form>';
                                } else {
                                    return '<small>Need <b>HR Department</b> Approval</small>';
                                }
                            }
                        } else {
                            if($data->employee_feedback == null) {
                                if($data->user_nik == Auth::user()->user_nik) {
                                    return '<a href="javascript:;" class="btn btn-sm btn-primary btn-feedback" data-id="'.($data->grade_group_name == 'Staff' ? $data->appraisal_staff_id : $data->appraisal_id).'" data-type="'.($data->grade_group_name == 'Staff' ? 'staff' : 'spv_above').'">Give Feedback</a>';
                                } else {
                                    return '<small>Appraisal Done - Waiting Feedback</small>';
                                }
                            } else {
                                return '<small>Appraisal Done</small>';
                            }
                        }
                    } else {
                        if($data->appraisal_status == 'OPEN' || $data->appraisal_status == 'IN PROGRESS') {
                            if($data->appraisal_approval_status_1 == NULL && $data->approval_nik_1 != NULL) {
                                if($data->approval_nik_1 == Auth::user()->user_nik) {
                                    return '<form action="'.url('/appraisal/approval').'" method="post"><input type="hidden" name="_token" value="'.csrf_token().'"><input type="hidden" name="type" value="'.($data->grade_group_name == 'Staff' ? 'staff' : 'spv_above').'"><input type="hidden" name="id" value="'.($data->grade_group_name == 'Staff' ? $data->appraisal_staff_id : $data->appraisal_id).'"><button type="submit" class="btn btn-sm btn-primary">Need Your Approval</button></form>';
                                } else {
                                    return '<small>Need <b>'.User::where('user_nik', $data->approval_nik_1)->withTrashed()->first()->user_name.'</b> Approval</small>';
                                }
                            } else if($data->appraisal_approval_status_2 == NULL && $data->approval_nik_2 != NULL) {
                                if($data->approval_nik_2 == Auth::user()->user_nik) {
                                    return '<form action="'.url('/appraisal/approval').'" method="post"><input type="hidden" name="_token" value="'.csrf_token().'"><input type="hidden" name="type" value="'.($data->grade_group_name == 'Staff' ? 'staff' : 'spv_above').'"><input type="hidden" name="id" value="'.($data->grade_group_name == 'Staff' ? $data->appraisal_staff_id : $data->appraisal_id).'"><button type="submit" class="btn btn-sm btn-primary">Need Your Approval</button></form>';
                                } else {
                                    return '<small>Need <b>'.User::where('user_nik', $data->approval_nik_2)->withTrashed()->first()->user_name.'</b> Approval</small>';
                                }
                            } else if($data->appraisal_approval_status_3 == NULL && $data->approval_nik_3 != NULL) {
                                if($data->approval_nik_3 == Auth::user()->user_nik) {
                                    return '<form action="'.url('/appraisal/approval').'" method="post"><input type="hidden" name="_token" value="'.csrf_token().'"><input type="hidden" name="type" value="'.($data->grade_group_name == 'Staff' ? 'staff' : 'spv_above').'"><input type="hidden" name="id" value="'.($data->grade_group_name == 'Staff' ? $data->appraisal_staff_id : $data->appraisal_id).'"><button type="submit" class="btn btn-sm btn-primary">Need Your Approval</button></form>';
                                } else {
                                    return '<small>Need <b>'.User::where('user_nik', $data->approval_nik_3)->withTrashed()->first()->user_name.'</b> Approval</small>';
                                }
                            } else if($data->appraisal_approval_status_4 == NULL && $data->approval_nik_4 != NULL) {
                                if($data->approval_nik_4 == Auth::user()->user_nik) {
                                    return '<form action="'.url('/appraisal/approval').'" method="post"><input type="hidden" name="_token" value="'.csrf_token().'"><input type="hidden" name="type" value="'.($data->grade_group_name == 'Staff' ? 'staff' : 'spv_above').'"><input type="hidden" name="id" value="'.($data->grade_group_name == 'Staff' ? $data->appraisal_staff_id : $data->appraisal_id).'"><button type="submit" class="btn btn-sm btn-primary">Need Your Approval</button></form>';
                                } else {
                                    return '<small>Need <b>'.User::where('user_nik', $data->approval_nik_4)->withTrashed()->first()->user_name.'</b> Approval</small>';
                                }
                            } else if($data->appraisal_approval_status_5 == NULL && $data->approval_nik_5 != NULL) {
                                if($data->approval_nik_5 == Auth::user()->user_nik) {
                                    return '<form action="'.url('/appraisal/approval').'" method="post"><input type="hidden" name="_token" value="'.csrf_token().'"><input type="hidden" name="type" value="'.($data->grade_group_name == 'Staff' ? 'staff' : 'spv_above').'"><input type="hidden" name="id" value="'.($data->grade_group_name == 'Staff' ? $data->appraisal_staff_id : $data->appraisal_id).'"><button type="submit" class="btn btn-sm btn-primary">Need Your Approval</button></form>';
                                } else {
                                    return '<small>Need <b>'.User::where('user_nik', $data->approval_nik_5)->withTrashed()->first()->user_name.'</b> Approval</small>';
                                }
                            } else if($data->appraisal_approval_status_6 == NULL && $data->approval_nik_6 != NULL) {
                                if($data->approval_nik_6 == Auth::user()->user_nik) {
                                    return '<form action="'.url('/appraisal/approval').'" method="post"><input type="hidden" name="_token" value="'.csrf_token().'"><input type="hidden" name="type" value="'.($data->grade_group_name == 'Staff' ? 'staff' : 'spv_above').'"><input type="hidden" name="id" value="'.($data->grade_group_name == 'Staff' ? $data->appraisal_staff_id : $data->appraisal_id).'"><button type="submit" class="btn btn-sm btn-primary">Need Your Approval</button></form>';
                                } else {
                                    return '<small>Need <b>'.User::where('user_nik', $data->approval_nik_6)->withTrashed()->first()->user_name.'</b> Approval</small>';
                                }
                            } else if($data->appraisal_approval_status_hr == NULL && $data->approval_nik_hr != NULL) {
                                if($data->approval_nik_hr == Auth::user()->user_nik) {
                                    return '<form action="'.url('/appraisal/approval').'" method="post"><input type="hidden" name="_token" value="'.csrf_token().'"><input type="hidden" name="type" value="'.($data->grade_group_name == 'Staff' ? 'staff' : 'spv_above').'"><input type="hidden" name="id" value="'.($data->grade_group_name == 'Staff' ? $data->appraisal_staff_id : $data->appraisal_id).'"><button type="submit" class="btn btn-sm btn-primary">Need Your Approval</button></form>';
                                } else {
                                    return '<small>Need <b>HR Department</b> Approval</small>';
                                }
                            }
                        } else {
                            if($data->employee_feedback == null) {
                                if($data->user_nik == Auth::user()->user_nik) {
                                    return '<a href="javascript:;" class="btn btn-sm btn-primary btn-feedback" data-id="'.($data->grade_group_name == 'Staff' ? $data->appraisal_staff_id : $data->appraisal_id).'" data-type="'.($data->grade_group_name == 'Staff' ? 'staff' : 'spv_above').'">Give Feedback</a>';
                                } else {
                                    return '<small>Appraisal Done - Waiting Feedback</small>';
                                }
                            } else {
                                return '<small>Appraisal Done</small>';
                            }
                        }
                    }
                }
            })
            ->addColumn('edit', function($data) {
                if($data->appraisal_status == 'CLOSED') {
                    if($data->user_id != Auth::user()->user_id && $data->final_scorer != $this->ceo_name && (in_array(Auth::user()->user_id, $this->hr) || in_array(Auth::user()->user_id, $this->hod))) {
                        return '<a href="javascript:;" class="btn-final-score" data-id="'.($data->grade_group_name == 'Staff' ? $data->appraisal_staff_id : $data->appraisal_id).'" data-type="'.($data->grade_group_name == 'Staff' ? 'staff' : 'spv_above').'" data-toggle="tooltip" title="Final Score"><i class="fa fa-edit"></i></a>';
                    } else {
                        return '<a href="javascript:;" data-toggle="tooltip" title="Final Score"><i class="fa fa-lock"></i></a>';
                    }
                } else {
                    return '<a href="javascript:;" data-toggle="tooltip" title="Final Score"><i class="fa fa-lock"></i></a>';
                }
            })
            ->addColumn('view', function($data) {
                if($data->appraisal_status == null || $data->appraisal_status == 'DRAFT') {
                    return '<a href="javascript:;" data-toggle="tooltip" title="Lock"><i class="fa fa-lock"></i></a>';
                } else if($data->appraisal_status == 'IN PROGRESS' || $data->appraisal_status == 'REJECTED') {
                    return '<a href="javascript:;" class="'.($data->grade_group_name == 'Staff' ? 'btn-view_in_progress_staff' : 'btn-view_in_progress').'" data-id="'.($data->grade_group_name == 'Staff' ? $data->appraisal_staff_id : $data->appraisal_id).'" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></a>';
                } else if($data->appraisal_status == 'CLOSED') {
                    return '<a href="javascript:;" class="'.($data->grade_group_name == 'Staff' ? 'btn-view_closed_staff' : 'btn-view_closed').'" data-id="'.($data->grade_group_name == 'Staff' ? $data->appraisal_staff_id : $data->appraisal_id).'" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></a>';
                }
            })
            ->addColumn('export', function($data) {
                if($data->appraisal_status == 'CLOSED') {
                    return '<form target="_blank" action="'.url('/appraisal/export').'" method="post"><input type="hidden" name="_token" value="'.csrf_token().'"><input type="hidden" name="type" value="'.($data->grade_group_name == 'Staff' ? 'staff' : 'spv_above').'"><input type="hidden" name="id" value="'.($data->grade_group_name == 'Staff' ? $data->appraisal_staff_id : $data->appraisal_id).'"><a href="javascript:;" class="btn-export"><i class="fa fa-file-pdf"></i></a></form>';
                } else {
                    return '<a href="javascript:;" data-toggle="tooltip" title="Lock"><i class="fa fa-lock"></i></a>';
                }
            })
            ->rawColumns(['status', 'action_needed', 'edit', 'view', 'export'])
        ->toJson();
    }

    public function export(Request $request)
    {
        if($request->type == 'spv_above') {
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

            $competency = AppraisalCompetencyNew::query()
                ->selectRaw('trans_appraisal_competency_new.*, acn.*')
                ->leftJoin('mst_appraisal_competency_new AS acn', 'acn.competency_new_id', 'trans_appraisal_competency_new.competency_new_id')
                ->where('trans_appraisal_competency_new.appraisal_id', $appraisal->appraisal_id)
                ->groupBy('trans_appraisal_competency_new.appraisal_competency_new_id')
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

            $pdf = PDF::loadView('appraisal.export.export', ['appraisal' => $appraisal, 'period' => $period, 'milestone' => $milestone, 'competency' => $competency, 'milestone_next' => $milestone_next]);

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

            return $pdf->inline('APR '.$period->period_name.' '.$appraisal->user_nik.' - '.$appraisal->user_name.'.pdf');
        } else if($request->type == 'staff') {
            $appraisal = AppraisalStaffMain::query()
                ->selectRaw('trans_appraisal_staff_main.*,
                    dept.department_name, "Staff" AS grade_group_name')
                ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'trans_appraisal_staff_main.department_id')
                ->where('trans_appraisal_staff_main.appraisal_staff_id', $request->id)
            ->first();

            $period = PluginPeriod::where('period_id', $appraisal->period_id)->first();

            $objective = AppraisalStaffObjective::where('appraisal_staff_id', $request->id)->get();

            $competency = AppraisalStaffCompetency::query()
                ->selectRaw('trans_appraisal_staff_competency.*, acs.*')
                ->leftJoin('mst_appraisal_competency_staff AS acs', 'acs.competency_staff_id', 'trans_appraisal_staff_competency.competency_staff_id')
                ->where('trans_appraisal_staff_competency.appraisal_staff_id', $request->id)
                ->groupBy('trans_appraisal_staff_competency.appraisal_staff_competency_id')
            ->get();

            $objective_next = AppraisalStaffObjectiveNext::where('appraisal_staff_id', $request->id)->get();

            $pdf = PDF::loadView('appraisal.export.export_staff_bhs', [
                'appraisal' => $appraisal,
                'period' => $period,
                'objective' => $objective,
                'competency' => $competency,
                'objective_next' => $objective_next
            ]);

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

            return $pdf->inline('APR '.$period->period_name.' '.$appraisal->user_nik.' - '.$appraisal->user_name.'.pdf');
        }
    }

    public function appraisalDetailStaff(Request $request)
    {
        $appraisal = AppraisalStaffMain::query()
            ->selectRaw('trans_appraisal_staff_main.*,
                dept.department_name, "Staff" AS grade_group_name')
            ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'trans_appraisal_staff_main.department_id')
            ->where('trans_appraisal_staff_main.appraisal_staff_id', $request->id)
        ->first();

        $period = PluginPeriod::where('period_id', $appraisal->period_id)->first();

        $objective = AppraisalStaffObjective::where('appraisal_staff_id', $request->id)->get();

        $competency = AppraisalStaffCompetency::query()
            ->selectRaw('trans_appraisal_staff_competency.*, acs.*')
            ->leftJoin('mst_appraisal_competency_staff AS acs', 'acs.competency_staff_id', 'trans_appraisal_staff_competency.competency_staff_id')
            ->where('trans_appraisal_staff_competency.appraisal_staff_id', $request->id)
            ->groupBy('trans_appraisal_staff_competency.appraisal_staff_competency_id')
        ->get();

        $objective_next = AppraisalStaffObjectiveNext::where('appraisal_staff_id', $request->id)->get();

        $approval_matrix = ApprovalMatrix::query()
            ->selectRaw('u1.user_nik AS approval_nik_1, u1.user_name AS approval_name_1,
                u2.user_nik AS approval_nik_2, u2.user_name AS approval_name_2')
            ->leftJoin('mst_main_user AS u1', 'u1.user_nik', 'mst_main_user_approval_matrix.approval_nik_1')
            ->leftJoin('mst_main_user AS u2', 'u2.user_nik', 'mst_main_user_approval_matrix.approval_nik_2')
            ->where('mst_main_user_approval_matrix.user_nik', $appraisal->appraisal_user_nik)
        ->first();

        if($request->type == 'view') {
            return response()->json([
                'appraisal' => $appraisal,
                'period' => $period,
                'objective' => $objective,
                'competency' => $competency,
                'objective_next' => $objective_next,
                'approval_matrix' => $approval_matrix
            ]);
        }
    }
}
