<?php

namespace App\Http\Controllers\Appraisal;

use App\Model\Departement;
use App\Model\Grade;
use App\Model\GradeGroup;
use App\Model\User;
use App\Model\Appraisal\AppraisalMain;
use App\Model\Appraisal\AppraisalStaffMain;
use App\Model\Appraisal\AppraisalPeriod;
use App\Model\Plugin\PluginPeriod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

class DashboardController extends Controller
{
    protected $super_admin;
    // GRADE GROUP APPRAISAL ACCESS
    protected $gg_spv_above;
    protected $gg_staff;
    protected $ceo;
    protected $excluded_title;

    public function __construct()
    {
        // SUPER ADMIN : CHRIS SIMON, HUSIN, MUHAMMAD BONA RIZKI
        $this->super_admin = array(221, 454, 477);

        $this->gg_spv_above = array(4,5,6,7);
        $this->gg_staff = array(3);
        $this->ceo = array(408);
        $this->excluded_title = array(73); // Management Trainee
    }

    public function index()
    {
    	$period_all = PluginPeriod::where('period_status', '1')->orderBy('period_name')->get();
        $period_name = date('m') <= 5 ? ((date('Y') - 1).'-'.date('Y')) : (date('Y').'-'.(date('Y') + 1));
        $period = PluginPeriod::where('period_name', $period_name)->first();

        $grade_group = Grade::where('grade_id', Auth::user()->grade_id)->first()->grade_group_id;
        $gg_spv_above = $this->gg_spv_above;
        $gg_staff = $this->gg_staff;
        $super_admin = $this->super_admin;

        return view('appraisal.dashboard', compact('period_all', 'period', 'grade_group', 'gg_spv_above', 'gg_staff', 'super_admin'));
    }

    public function appraisalCount(Request $request)
    {
    	$period = NULL;
    	if($request->has('period_id')) {
    		$period = $request->get('period_id');
    	}
        $appraisal_period = AppraisalPeriod::where('period_id', $period)->first();

        // SPV ABOVE
    	$user_spv_above = User::query()
            ->selectRaw('COUNT(mst_main_user.user_id) AS count_user')
            ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'mst_main_user.grade_id')
            ->leftJoin('mst_main_user_grade_group AS gg', 'gg.grade_group_id', 'g.grade_group_id')
            ->whereIn('gg.grade_group_id', $this->gg_spv_above)
            ->whereNotIn('mst_main_user.user_id', $this->ceo)
            ->whereNotIn('mst_main_user.title_id', $this->excluded_title)
            ->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_period_start.'", mst_main_user.user_join_date) > 180')
        ->first()->count_user;

        $milestone_in_progress = AppraisalMain::query()
            ->selectRaw('COUNT(user_id) AS count_user')
            ->where('period_id', $period)
            ->where('appraisal_milestone_status', 'PENDING')
            ->whereIn('grade_group_id', $this->gg_spv_above)
        ->first();

        $milestone_approved = AppraisalMain::query()
            ->selectRaw('COUNT(user_id) AS count_user')
            ->where('period_id', $period)
            ->where('appraisal_milestone_status', 'APPROVED')
            ->whereIn('grade_group_id', $this->gg_spv_above)
        ->first();

        $milestone_open = $user_spv_above - ($milestone_in_progress == null ? 0 : $milestone_in_progress->count_user) - ($milestone_approved == null ? 0 : $milestone_approved->count_user);

        $appraisal_open = AppraisalMain::query()
            ->selectRaw('COUNT(user_id) AS count_user')
            ->where('period_id', $period)
            ->where('appraisal_milestone_status', 'APPROVED')
            ->whereIn('appraisal_status', ['DRAFT', 'OPEN'])
            ->whereIn('grade_group_id', $this->gg_spv_above)
        ->first();

        $appraisal_in_progress = AppraisalMain::query()
        	->selectRaw('COUNT(user_id) AS count_user')
        	->where('period_id', $period)
        	->where('appraisal_status', 'IN PROGRESS')
        	->whereIn('grade_group_id', $this->gg_spv_above)
        ->first();

        $appraisal_closed = AppraisalMain::query()
        	->selectRaw('COUNT(user_id) AS count_user')
        	->where('period_id', $period)
        	->where('appraisal_status', 'CLOSED')
        	->whereIn('grade_group_id', $this->gg_spv_above)
        ->first();

        $appraisal_waiting_feedback = AppraisalMain::query()
        	->selectRaw('COUNT(user_id) AS count_user')
        	->where('period_id', $period)
        	->where('appraisal_status', 'CLOSED')
        	->whereNull('employee_feedback')
        	->whereIn('grade_group_id', $this->gg_spv_above)
        ->first();

        $appraisal_feedback_completed = AppraisalMain::query()
        	->selectRaw('COUNT(user_id) AS count_user')
        	->where('period_id', $period)
        	->where('appraisal_status', 'CLOSED')
        	->whereNotNull('employee_feedback')
        	->whereIn('grade_group_id', $this->gg_spv_above)
        ->first();

        // STAFF
        $user_staff = User::query()
            ->selectRaw('COUNT(mst_main_user.user_id) AS count_user')
            ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'mst_main_user.grade_id')
            ->leftJoin('mst_main_user_grade_group AS gg', 'gg.grade_group_id', 'g.grade_group_id')
            ->whereIn('gg.grade_group_id', $this->gg_staff)
            ->whereNotIn('mst_main_user.user_id', $this->ceo)
            ->whereNotIn('mst_main_user.title_id', $this->excluded_title)
            ->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_staff_period_start.'", mst_main_user.user_join_date) > 180')
        ->first()->count_user;

        $appraisal_staff_in_progress = AppraisalStaffMain::query()
        	->selectRaw('COUNT(user_id) AS count_user')
        	->where('period_id', $period)
        	->where('appraisal_status', 'IN PROGRESS')
        ->first();

        $appraisal_staff_closed = AppraisalStaffMain::query()
        	->selectRaw('COUNT(user_id) AS count_user')
        	->where('period_id', $period)
        	->where('appraisal_status', 'CLOSED')
        ->first();

        $appraisal_staff_open = $user_staff - ($appraisal_staff_in_progress == null ? 0 : $appraisal_staff_in_progress->count_user) - ($appraisal_staff_closed == null ? 0 : $appraisal_staff_closed->count_user);

        $appraisal_staff_waiting_feedback = AppraisalStaffMain::query()
        	->selectRaw('COUNT(user_id) AS count_user')
        	->where('period_id', $period)
        	->where('appraisal_status', 'CLOSED')
        	->whereNull('employee_feedback')
        ->first();

        $appraisal_staff_feedback_completed = AppraisalStaffMain::query()
        	->selectRaw('COUNT(user_id) AS count_user')
        	->where('period_id', $period)
        	->where('appraisal_status', 'CLOSED')
        	->whereNotNull('employee_feedback')
        ->first();

        $data = (object) array();
        $data->milestone_open = ($milestone_open < 0 ? 0 : $milestone_open);
        $data->milestone_in_progress = ($milestone_in_progress == null ? 0 : $milestone_in_progress->count_user);
        $data->milestone_approved = ($milestone_approved == null ? 0 : $milestone_approved->count_user);
        $data->appraisal_open = ($appraisal_open == null ? 0 : $appraisal_open->count_user);
        $data->appraisal_in_progress = ($appraisal_in_progress == null ? 0 : $appraisal_in_progress->count_user);
        $data->appraisal_closed = ($appraisal_closed == null ? 0 : $appraisal_closed->count_user);
        $data->appraisal_waiting_feedback = ($appraisal_waiting_feedback == null ? 0 : $appraisal_waiting_feedback->count_user);
        $data->appraisal_feedback_completed = ($appraisal_feedback_completed == null ? 0 : $appraisal_feedback_completed->count_user);

        $data->appraisal_staff_open = ($appraisal_staff_open < 0 ? 0 : $appraisal_staff_open);
        $data->appraisal_staff_in_progress = ($appraisal_staff_in_progress == null ? 0 : $appraisal_staff_in_progress->count_user);
        $data->appraisal_staff_closed = ($appraisal_staff_closed == null ? 0 : $appraisal_staff_closed->count_user);
        $data->appraisal_staff_waiting_feedback = ($appraisal_staff_waiting_feedback == null ? 0 : $appraisal_staff_waiting_feedback->count_user);
        $data->appraisal_staff_feedback_completed = ($appraisal_staff_feedback_completed == null ? 0 : $appraisal_staff_feedback_completed->count_user);

        return response()->json($data);
    }

    public function getAppraisalInfo(Request $request)
    {
        $period = NULL;
        if($request->has('period_id')) {
            $period = $request->get('period_id');
        }

        $status = 'open';
        if($request->has('status')) {
            $status = $request->get('status');
        }

        $appraisal_period = AppraisalPeriod::where('period_id', $period)->first();

        $appraisal = array();

        if($status == 'milestone open') {
            $appraisal = array();

            $open = AppraisalMain::query()
                ->selectRaw('user.user_id,
                    user.user_nik,
                    user.user_name,
                    CONCAT("[", user.user_nik, "] ", user.user_name) AS employee,
                    dept.department_name,
                    gg.grade_group_name')
                ->leftJoin('mst_main_user AS user', 'user.user_id', 'trans_appraisal_main.user_id')
                ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'user.department_id')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'user.grade_id')
                ->leftJoin('mst_main_user_grade_group AS gg', 'gg.grade_group_id', 'g.grade_group_id')
                ->where('trans_appraisal_main.appraisal_milestone_status', 'DRAFT')
                ->where('trans_appraisal_main.appraisal_status', 'DRAFT')
                ->where('trans_appraisal_main.period_id', $period)
                ->whereIn('trans_appraisal_main.grade_group_id', $this->gg_spv_above)
                ->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_period_start.'", user.user_join_date) > 180')
                ->where(function($query) use ($appraisal_period) {
                    $query->where('user.deleted_at', '>', $appraisal_period->appraisal_period_start)
                        ->orWhereNull('user.deleted_at');
                })
            ->get();

            $user_arr = array();
            foreach($open as $o) {
                array_push($user_arr, $o->user_id);
            }

            $not_open = AppraisalMain::query()
                ->selectRaw('user.user_id')
                ->leftJoin('mst_main_user AS user', 'user.user_id', 'trans_appraisal_main.user_id')
                ->where('trans_appraisal_main.appraisal_milestone_status', '!=', 'DRAFT')
                ->where('trans_appraisal_main.period_id', $period)
            ->pluck('user_id')->toArray();

            $user = User::query()
                ->selectRaw('mst_main_user.user_id,
                    mst_main_user.user_nik,
                    mst_main_user.user_name,
                    CONCAT("[", mst_main_user.user_nik, "] ", mst_main_user.user_name) AS employee,
                    dept.department_name,
                    gg.grade_group_name')
                ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'mst_main_user.department_id')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'mst_main_user.grade_id')
                ->leftJoin('mst_main_user_grade_group AS gg', 'gg.grade_group_id', 'g.grade_group_id')
                ->whereIn('g.grade_group_id', $this->gg_spv_above)
                ->whereNotIn('mst_main_user.user_id', $this->ceo)
                ->whereNotIn('mst_main_user.title_id', $this->excluded_title)
                ->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_period_start.'", mst_main_user.user_join_date) > 180')
                ->whereNotIn('mst_main_user.user_id', $user_arr)
                ->whereNotIn('mst_main_user.user_id', $not_open)
                ->where(function($query) use ($appraisal_period) {
                    $query->where('mst_main_user.deleted_at', '>', $appraisal_period->appraisal_period_start)
                        ->orWhereNull('mst_main_user.deleted_at');
                })
            ->get();

            foreach($open as $o) {
                $obj = (object) array();
                $obj->user_id = $o->user_id;
                $obj->user_nik = $o->user_nik;
                $obj->user_name = $o->user_name;
                $obj->employee = $o->employee;
                $obj->department_name = $o->department_name;
                $obj->grade_group_name = $o->grade_group_name;

                array_push($appraisal, $obj);
            }

            foreach($user as $u) {
                $obj = (object) array();
                $obj->user_id = $u->user_id;
                $obj->user_nik = $u->user_nik;
                $obj->user_name = $u->user_name;
                $obj->employee = $u->employee;
                $obj->department_name = $u->department_name;
                $obj->grade_group_name = $u->grade_group_name;

                array_push($appraisal, $obj);
            }
        } else if($status == 'milestone in progress') {
            $appraisal = AppraisalMain::query()
                ->selectRaw('user.user_id,
                    user.user_nik,
                    user.user_name,
                    CONCAT("[", user.user_nik, "] ", user.user_name) AS employee,
                    dept.department_name,
                    gg.grade_group_name')
                ->leftJoin('mst_main_user AS user', 'user.user_id', 'trans_appraisal_main.user_id')
                ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'user.department_id')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'user.grade_id')
                ->leftJoin('mst_main_user_grade_group AS gg', 'gg.grade_group_id', 'g.grade_group_id')
                ->where('trans_appraisal_main.appraisal_milestone_status', 'PENDING')
                ->where('trans_appraisal_main.period_id', $period)
            ->get();
        } else if($status == 'milestone approved') {
            $appraisal = AppraisalMain::query()
                ->selectRaw('user.user_id,
                    user.user_nik,
                    user.user_name,
                    CONCAT("[", user.user_nik, "] ", user.user_name) AS employee,
                    dept.department_name,
                    gg.grade_group_name')
                ->leftJoin('mst_main_user AS user', 'user.user_id', 'trans_appraisal_main.user_id')
                ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'user.department_id')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'user.grade_id')
                ->leftJoin('mst_main_user_grade_group AS gg', 'gg.grade_group_id', 'g.grade_group_id')
                ->where('trans_appraisal_main.appraisal_milestone_status', 'APPROVED')
                ->where('trans_appraisal_main.period_id', $period)
            ->get();
        } else if($status == 'open') {
            $appraisal = AppraisalMain::query()
                ->selectRaw('user.user_id,
                    user.user_nik,
                    user.user_name,
                    CONCAT("[", user.user_nik, "] ", user.user_name) AS employee,
                    dept.department_name,
                    gg.grade_group_name')
                ->leftJoin('mst_main_user AS user', 'user.user_id', 'trans_appraisal_main.user_id')
                ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'user.department_id')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'user.grade_id')
                ->leftJoin('mst_main_user_grade_group AS gg', 'gg.grade_group_id', 'g.grade_group_id')
                ->where('trans_appraisal_main.appraisal_milestone_status', 'APPROVED')
                ->whereIn('trans_appraisal_main.appraisal_status', ['DRAFT', 'OPEN'])
                ->where('trans_appraisal_main.period_id', $period)
            ->get();
        } else if($status == 'in progress') {
            $appraisal = AppraisalMain::query()
                ->selectRaw('user.user_id,
                    user.user_nik,
                    user.user_name,
                    CONCAT("[", user.user_nik, "] ", user.user_name) AS employee,
                    dept.department_name,
                    gg.grade_group_name')
                ->leftJoin('mst_main_user AS user', 'user.user_id', 'trans_appraisal_main.user_id')
                ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'user.department_id')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'user.grade_id')
                ->leftJoin('mst_main_user_grade_group AS gg', 'gg.grade_group_id', 'g.grade_group_id')
                ->where('trans_appraisal_main.appraisal_status', 'IN PROGRESS')
                ->where('trans_appraisal_main.period_id', $period)
            ->get();
        } else if($status == 'closed') {
            $appraisal = AppraisalMain::query()
                ->selectRaw('user.user_id,
                    user.user_nik,
                    user.user_name,
                    CONCAT("[", user.user_nik, "] ", user.user_name) AS employee,
                    dept.department_name,
                    gg.grade_group_name')
                ->leftJoin('mst_main_user AS user', 'user.user_id', 'trans_appraisal_main.user_id')
                ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'user.department_id')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'user.grade_id')
                ->leftJoin('mst_main_user_grade_group AS gg', 'gg.grade_group_id', 'g.grade_group_id')
                ->where('trans_appraisal_main.appraisal_status', 'CLOSED')
                ->where('trans_appraisal_main.period_id', $period)
            ->get();
        } else if($status == 'waiting feedback') {
            $appraisal = AppraisalMain::query()
                ->selectRaw('user.user_id,
                    user.user_nik,
                    user.user_name,
                    CONCAT("[", user.user_nik, "] ", user.user_name) AS employee,
                    dept.department_name,
                    gg.grade_group_name')
                ->leftJoin('mst_main_user AS user', 'user.user_id', 'trans_appraisal_main.user_id')
                ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'user.department_id')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'user.grade_id')
                ->leftJoin('mst_main_user_grade_group AS gg', 'gg.grade_group_id', 'g.grade_group_id')
                ->where('trans_appraisal_main.appraisal_status', 'CLOSED')
                ->whereNull('trans_appraisal_main.employee_feedback')
                ->where('trans_appraisal_main.period_id', $period)
            ->get();
        } else if($status == 'feedback completed') {
            $appraisal = AppraisalMain::query()
                ->selectRaw('user.user_id,
                    user.user_nik,
                    user.user_name,
                    CONCAT("[", user.user_nik, "] ", user.user_name) AS employee,
                    dept.department_name,
                    gg.grade_group_name')
                ->leftJoin('mst_main_user AS user', 'user.user_id', 'trans_appraisal_main.user_id')
                ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'user.department_id')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'user.grade_id')
                ->leftJoin('mst_main_user_grade_group AS gg', 'gg.grade_group_id', 'g.grade_group_id')
                ->where('trans_appraisal_main.appraisal_status', 'CLOSED')
                ->whereNotNull('trans_appraisal_main.employee_feedback')
                ->where('trans_appraisal_main.period_id', $period)
            ->get();
        } else if($status == 'staff open') {
            $appraisal = array();

            $open = AppraisalStaffMain::query()
                ->selectRaw('trans_appraisal_staff_main.user_id,
                    trans_appraisal_staff_main.appraisal_user_nik AS user_nik,
                    trans_appraisal_staff_main.appraisal_user_name AS user_name,
                    CONCAT("[", trans_appraisal_staff_main.appraisal_user_nik, "] ", trans_appraisal_staff_main.appraisal_user_name) AS employee,
                    dept.department_name, "Staff" AS grade_group_name')
                ->leftJoin('mst_main_user AS user', 'user.user_id', 'trans_appraisal_staff_main.user_id')
                ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'user.department_id')
                ->whereIn('trans_appraisal_staff_main.appraisal_status', ['DRAFT', 'OPEN', 'REJECTED'])
                ->where('trans_appraisal_staff_main.period_id', $period)
                ->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_staff_period_start.'", user.user_join_date) > 180')
                ->where(function($query) use ($appraisal_period) {
                    $query->where('user.deleted_at', '>', $appraisal_period->appraisal_staff_period_start)
                        ->orWhereNull('user.deleted_at');
                })
            ->get();

            $user_arr = array();
            foreach($open as $o) {
                array_push($user_arr, $o->user_id);
            }

            $not_open = AppraisalStaffMain::query()
                ->selectRaw('user_id')
                ->where('trans_appraisal_staff_main.appraisal_status', '!=', 'DRAFT')
                ->where('trans_appraisal_staff_main.appraisal_status', '!=', 'OPEN')
                ->where('trans_appraisal_staff_main.appraisal_status', '!=', 'REJECTED')
                ->where('trans_appraisal_staff_main.period_id', $period)
            ->pluck('user_id')->toArray();

            $user = User::query()
                ->selectRaw('mst_main_user.user_id, mst_main_user.user_nik, mst_main_user.user_name,
                    CONCAT("[", mst_main_user.user_nik, "] ", mst_main_user.user_name) AS employee,
                    dept.department_name, gg.grade_group_name')
                ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'mst_main_user.department_id')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'mst_main_user.grade_id')
                ->leftJoin('mst_main_user_grade_group AS gg', 'gg.grade_group_id', 'g.grade_group_id')
                ->whereIn('g.grade_group_id', $this->gg_staff)
                ->whereNotIn('mst_main_user.user_id', $this->ceo)
                ->whereNotIn('mst_main_user.title_id', $this->excluded_title)
                ->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_staff_period_start.'", mst_main_user.user_join_date) > 180')
                ->whereNotIn('mst_main_user.user_id', $user_arr)
                ->whereNotIn('mst_main_user.user_id', $not_open)
                ->where(function($query) use ($appraisal_period) {
                    $query->where('mst_main_user.deleted_at', '>', $appraisal_period->appraisal_staff_period_start)
                        ->orWhereNull('mst_main_user.deleted_at');
                })
            ->get();

            foreach($open as $o) {
                $obj = (object) array();
                $obj->user_id = $o->user_id;
                $obj->user_nik = $o->user_nik;
                $obj->user_name = $o->user_name;
                $obj->employee = $o->employee;
                $obj->department_name = $o->department_name;
                $obj->grade_group_name = $o->grade_group_name;

                array_push($appraisal, $obj);
            }

            foreach($user as $u) {
                $obj = (object) array();
                $obj->user_id = $u->user_id;
                $obj->user_nik = $u->user_nik;
                $obj->user_name = $u->user_name;
                $obj->employee = $u->employee;
                $obj->department_name = $u->department_name;
                $obj->grade_group_name = $u->grade_group_name;

                array_push($appraisal, $obj);
            }
        } else if($status == 'staff in progress') {
            $appraisal = AppraisalStaffMain::query()
                ->selectRaw('user.user_id, user.user_nik, user.user_name,
                    CONCAT("[", user.user_nik, "] ", user.user_name) AS employee,
                    dept.department_name, gg.grade_group_name')
                ->leftJoin('mst_main_user AS user', 'user.user_id', 'trans_appraisal_staff_main.user_id')
                ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'user.department_id')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'user.grade_id')
                ->leftJoin('mst_main_user_grade_group AS gg', 'gg.grade_group_id', 'g.grade_group_id')
                ->where('trans_appraisal_staff_main.appraisal_status', 'IN PROGRESS')
                ->where('trans_appraisal_staff_main.period_id', $period)
            ->get();
        } else if($status == 'staff closed') {
            $appraisal = AppraisalStaffMain::query()
                ->selectRaw('user.user_id, user.user_nik, user.user_name,
                    CONCAT("[", user.user_nik, "] ", user.user_name) AS employee,
                    dept.department_name, gg.grade_group_name')
                ->leftJoin('mst_main_user AS user', 'user.user_id', 'trans_appraisal_staff_main.user_id')
                ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'user.department_id')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'user.grade_id')
                ->leftJoin('mst_main_user_grade_group AS gg', 'gg.grade_group_id', 'g.grade_group_id')
                ->where('trans_appraisal_staff_main.appraisal_status', 'CLOSED')
                ->where('trans_appraisal_staff_main.period_id', $period)
            ->get();
        } else if($status == 'staff waiting feedback') {
            $appraisal = AppraisalStaffMain::query()
                ->selectRaw('user.user_id, user.user_nik, user.user_name,
                    CONCAT("[", user.user_nik, "] ", user.user_name) AS employee,
                    dept.department_name, gg.grade_group_name')
                ->leftJoin('mst_main_user AS user', 'user.user_id', 'trans_appraisal_staff_main.user_id')
                ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'user.department_id')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'user.grade_id')
                ->leftJoin('mst_main_user_grade_group AS gg', 'gg.grade_group_id', 'g.grade_group_id')
                ->where('trans_appraisal_staff_main.appraisal_status', 'CLOSED')
                ->whereNull('trans_appraisal_staff_main.employee_feedback')
                ->where('trans_appraisal_staff_main.period_id', $period)
            ->get();
        } else if($status == 'staff feedback completed') {
            $appraisal = AppraisalStaffMain::query()
                ->selectRaw('user.user_id, user.user_nik, user.user_name,
                    CONCAT("[", user.user_nik, "] ", user.user_name) AS employee,
                    dept.department_name, gg.grade_group_name')
                ->leftJoin('mst_main_user AS user', 'user.user_id', 'trans_appraisal_staff_main.user_id')
                ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'user.department_id')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'user.grade_id')
                ->leftJoin('mst_main_user_grade_group AS gg', 'gg.grade_group_id', 'g.grade_group_id')
                ->where('trans_appraisal_staff_main.appraisal_status', 'CLOSED')
                ->whereNotNull('trans_appraisal_staff_main.employee_feedback')
                ->where('trans_appraisal_staff_main.period_id', $period)
            ->get();
        }

        return datatables()->of($appraisal)->addIndexColumn()->toJson();
    }

    public function getEmployeeParticipation(Request $request)
    {
        $period = NULL;
        if($request->has('period_id')) {
            $period = $request->get('period_id');
        }

        $data = (object) array();

        $data->department = Departement::all()->pluck('department_name')->toArray();
        $data->participation = array();

        $department = Departement::all();

        foreach($department as $d) {
            $count = AppraisalMain::query()
                ->selectRaw('COUNT(appraisal_id) AS count_appraisal')
                ->where('appraisal_status', 'CLOSED')
                ->where('period_id', $period)
                ->where('department_id', $d->department_id)
                ->whereIn('grade_group_id', $this->gg_spv_above)
            ->first()->count_appraisal;

            array_push($data->participation, $count);
        }

        return response()->json($data);
    }

    public function getStaffParticipation(Request $request)
    {
        $period = NULL;
        if($request->has('period_id')) {
            $period = $request->get('period_id');
        }

        $data = (object) array();

        $data->department = Departement::all()->pluck('department_name')->toArray();
        $data->participation = array();

        $department = Departement::all();

        foreach($department as $d) {
            $count = AppraisalStaffMain::query()
                ->selectRaw('COUNT(appraisal_staff_id) AS count_appraisal')
                ->where('appraisal_status', 'CLOSED')
                ->where('period_id', $period)
                ->where('department_id', $d->department_id)
            ->first()->count_appraisal;

            array_push($data->participation, $count);
        }

        return response()->json($data);
    }

    public function getEmployeeLevel(Request $request)
    {
        $period = NULL;
        if($request->has('period_id')) {
            $period = $request->get('period_id');
        }
        $appraisal_period = AppraisalPeriod::where('period_id', $period)->first();

        $data = (object) array();

        $data->level = GradeGroup::whereIn('grade_group_id', $this->gg_spv_above)->pluck('grade_group_name')->toArray();
        $data->count = array();

        $grade_group = GradeGroup::whereIn('grade_group_id', $this->gg_spv_above)->get();

        foreach($grade_group as $gg) {
            $user = User::query()
                ->selectRaw('COUNT(mst_main_user.user_id) AS count_user')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'mst_main_user.grade_id')
                ->where('g.grade_group_id', $gg->grade_group_id)
                ->whereNotIn('mst_main_user.user_id', $this->ceo)
                ->whereNotIn('mst_main_user.title_id', $this->excluded_title)
                ->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_period_start.'", mst_main_user.user_join_date) > 180')
                ->where(function($query) use ($appraisal_period) {
                    $query->where('mst_main_user.deleted_at', '>', $appraisal_period->appraisal_period_start)
                        ->orWhereNull('mst_main_user.deleted_at');
                })
            ->first()->count_user;

            array_push($data->count, $user);
        }

        return response()->json($data);
    }

    public function getStaffGender(Request $request)
    {
        $period = NULL;
        if($request->has('period_id')) {
            $period = $request->get('period_id');
        }
        $appraisal_period = AppraisalPeriod::where('period_id', $period)->first();

        $data = (object) array();

        $data->gender = array('Male', 'Female');
        $data->count = array();

        // MALE STAFF
        $data->count[] = User::query()
            ->selectRaw('COUNT(mst_main_user.user_id) AS count_user')
            ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'mst_main_user.grade_id')
            ->where('mst_main_user.user_sex', 'M')
            ->whereIn('g.grade_group_id', $this->gg_staff)
            ->whereNotIn('mst_main_user.user_id', $this->ceo)
            ->whereNotIn('mst_main_user.title_id', $this->excluded_title)
            ->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_staff_period_start.'", mst_main_user.user_join_date) > 180')
            ->where(function($query) use ($appraisal_period) {
                $query->where('mst_main_user.deleted_at', '>', $appraisal_period->appraisal_staff_period_start)
                    ->orWhereNull('mst_main_user.deleted_at');
            })
        ->first()->count_user;

        // FEMALE STAFF
        $data->count[] = User::query()
            ->selectRaw('COUNT(mst_main_user.user_id) AS count_user')
            ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'mst_main_user.grade_id')
            ->where('mst_main_user.user_sex', 'F')
            ->whereIn('g.grade_group_id', $this->gg_staff)
            ->whereNotIn('mst_main_user.user_id', $this->ceo)
            ->whereNotIn('mst_main_user.title_id', $this->excluded_title)
            ->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_staff_period_start.'", mst_main_user.user_join_date) > 180')
            ->where(function($query) use ($appraisal_period) {
                $query->where('mst_main_user.deleted_at', '>', $appraisal_period->appraisal_staff_period_start)
                    ->orWhereNull('mst_main_user.deleted_at');
            })
        ->first()->count_user;

        return response()->json($data);
    }

    public function getStaffYearsService(Request $request)
    {
    	$period = NULL;
        if($request->has('period_id')) {
            $period = $request->get('period_id');
        }
        $appraisal_period = AppraisalPeriod::where('period_id', $period)->first();

    	$data = array();

    	$work_years = [
    		'1' => 'Less than 1 year',
            '2' => '1 to 3 years',
            '3' => '3 to 10 years',
            '4' => 'More than 10 years'
    	];

    	foreach($work_years as $key => $value) {
    		$count_user = User::query()
                ->selectRaw('COUNT(mst_main_user.user_id) AS count_user')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'mst_main_user.grade_id')
                ->whereIn('g.grade_group_id', $this->gg_staff)
                ->whereNotIn('mst_main_user.user_id', $this->ceo)
                ->whereNotIn('mst_main_user.title_id', $this->excluded_title);

            if($key == '1') {
                $count_user = $count_user->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_staff_period_start.'", mst_main_user.user_join_date) < 365');
            } else if($key == '2') {
                $count_user = $count_user->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_staff_period_start.'", mst_main_user.user_join_date) >= 365')->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_staff_period_start.'", mst_main_user.user_join_date) < 1095');
            } else if($key == '3') {
                $count_user = $count_user->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_staff_period_start.'", mst_main_user.user_join_date) >= 1095')->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_staff_period_start.'", mst_main_user.user_join_date) <= 3650');
            } else if($key == '4') {
                $count_user = $count_user->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_staff_period_start.'", mst_main_user.user_join_date) > 3650');
            }

            $count_user = $count_user->first()->count_user;

            array_push($data, $count_user);
    	}

    	return response()->json($data);
    }

    public function getEmployeeYearsService(Request $request)
    {
    	$period = NULL;
        if($request->has('period_id')) {
            $period = $request->get('period_id');
        }
        $appraisal_period = AppraisalPeriod::where('period_id', $period)->first();

    	$data = array();

    	$work_years = [
    		'1' => 'Less than 1 year',
            '2' => '1 to 3 years',
            '3' => '3 to 10 years',
            '4' => 'More than 10 years'
    	];

    	foreach($work_years as $key => $value) {
    		$count_user = User::query()
                ->selectRaw('COUNT(mst_main_user.user_id) AS count_user')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'mst_main_user.grade_id')
                ->whereIn('g.grade_group_id', $this->gg_spv_above)
                ->whereNotIn('mst_main_user.user_id', $this->ceo)
                ->whereNotIn('mst_main_user.title_id', $this->excluded_title);

            if($key == '1') {
                $count_user = $count_user->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_period_start.'", mst_main_user.user_join_date) < 365');
            } else if($key == '2') {
                $count_user = $count_user->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_period_start.'", mst_main_user.user_join_date) >= 365')->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_period_start.'", mst_main_user.user_join_date) < 1095');
            } else if($key == '3') {
                $count_user = $count_user->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_period_start.'", mst_main_user.user_join_date) >= 1095')->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_period_start.'", mst_main_user.user_join_date) <= 3650');
            } else if($key == '4') {
                $count_user = $count_user->whereRaw('DATEDIFF("'.$appraisal_period->appraisal_period_start.'", mst_main_user.user_join_date) > 3650');
            }

            $count_user = $count_user->first()->count_user;

            array_push($data, $count_user);
    	}

    	return response()->json($data);
    }
}
