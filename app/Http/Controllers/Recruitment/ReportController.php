<?php

namespace App\Http\Controllers\Recruitment;

use App\Model\Departement;
use App\Model\Grade;
use App\Model\GradeGroup;
use App\Model\Title;
use App\Model\Plugin\PluginPeriod;
use App\Model\Recruitment\PointOfHire;
use App\Model\Recruitment\Recruit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Exports\Recruitment\RateExport;
use App\Exports\Recruitment\ReportExport;
use App\Exports\Recruitment\ResourceExport;
use Maatwebsite\Excel\Facades\Excel;

use Auth, DB;

class ReportController extends Controller
{
    public function index()
    {
        $grade = Grade::orderBy('grade_code')->get();
        $title = Title::orderBy('title_name')->get();
        $point_of_hire = PointOfHire::orderBy('point_of_hire_name')->get();

        $period_all = PluginPeriod::where('period_status', '1')->orderBy('period_name')->get();
        $period_name = date('m') <= 3 ? ((date('Y') - 1).'-'.date('Y')) : (date('Y').'-'.(date('Y') + 1));
        $period = PluginPeriod::where('period_name', $period_name)->first();

        return view('recruitment.report', compact('grade', 'title', 'point_of_hire', 'period_all', 'period'));
    }

    public function rate()
    {
        $department = Departement::orderBy('department_name')->get();
        $grade_group = GradeGroup::all();

        $period_all = PluginPeriod::where('period_status', '1')->orderBy('period_name')->get();
        $period_name = date('m') <= 3 ? ((date('Y') - 1).'-'.date('Y')) : (date('Y').'-'.(date('Y') + 1));
        $period = PluginPeriod::where('period_name', $period_name)->first();

        return view('recruitment.rate', compact('department', 'grade_group', 'period_all', 'period'));
    }

    public function resource()
    {
        $department = Departement::orderBy('department_name')->get();
        $grade_group = GradeGroup::all();

        $period_all = PluginPeriod::where('period_status', '1')->orderBy('period_name')->get();
        $period_name = date('m') <= 3 ? ((date('Y') - 1).'-'.date('Y')) : (date('Y').'-'.(date('Y') + 1));
        $period = PluginPeriod::where('period_name', $period_name)->first();

        return view('recruitment.resource', compact('department', 'grade_group', 'period_all', 'period'));
    }

    public function getReport(Request $request)
    {
        $title = NULL;
        if($request->has('title_id')) {
            $title = $request->get('title_id');
        }

        $poh = NULL;
        if($request->has('point_of_hire')) {
            $poh = $request->get('point_of_hire');
        }

        $period = NULL;
        if($request->has('period_id')) {
            $period = $request->get('period_id');
        }

        $recruit = Recruit::query()
            ->selectRaw('trans_recruitment_recruit.recruit_id,
                trans_recruitment_recruit.request_code,
                t.title_name,
                CONCAT("[", g.grade_code, "] ", g.grade_name) AS grade,
                poh.point_of_hire_name AS point_of_hire,
                CONCAT("[", u.user_nik, "] ", u.user_name) AS user,
                DATE_FORMAT(trans_recruitment_recruit.request_date, "%b %e, %Y") AS request_date,
                DATE_FORMAT(trans_recruitment_recruit.lead_time_end, "%b %e, %Y") AS lead_time_end,
                trans_recruitment_recruit.hiring_resource,
                FORMAT(trans_recruitment_recruit.external_cost + trans_recruitment_recruit.internal_cost + trans_recruitment_recruit.advertising_expenses + trans_recruitment_recruit.assessment_online + trans_recruitment_recruit.medical_checkup + trans_recruitment_recruit.travel_expenses + trans_recruitment_recruit.hiring_bonus + trans_recruitment_recruit.referral_bonus, 0, "en_US") AS hiring_cost,
                DATE_FORMAT(trans_recruitment_recruit.join_date, "%b %e, %Y") AS join_date,
                DATEDIFF(trans_recruitment_recruit.lead_time_end, trans_recruitment_recruit.lead_time_start) AS lead_time,
                slt.standard_lead_time')
            ->leftJoin('mst_main_user_title AS t', 't.title_id', 'trans_recruitment_recruit.title_id')
            ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
            ->leftJoin('mst_recruitment_point_of_hire AS poh', 'poh.point_of_hire_id', 'trans_recruitment_recruit.point_of_hire_id')
            ->leftJoin('mst_main_user AS u', 'u.user_id', 'trans_recruitment_recruit.user_id')
            ->leftJoin('mst_recruitment_standard_lead_time AS slt', 'slt.grade_group_id', 'g.grade_group_id')
            ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED');

        if($title > 0) {
            $recruit = $recruit->where('trans_recruitment_recruit.title_id', $title);
        }

        if($poh > 0) {
            $recruit = $recruit->where('trans_recruitment_recruit.point_of_hire_id', $poh);
        }

        if($period > 0) {
            $recruit = $recruit->where('trans_recruitment_recruit.period_id', $period);
        }

        $recruit = $recruit->orderBy('trans_recruitment_recruit.request_code')->get();

        return datatables()->of($recruit)->addIndexColumn()
            ->addColumn('view', function($recruit) {
                return '<a href="javascript:;" class="btn-view" data-id="'.$recruit->recruit_id.'" data-toggle="tooltip" title="View"><i class="feather icon-eye"></i></a>';
            })
            ->addColumn('export', function($recruit){
                return '<a href="'.url('/recruitment/export-fulfilled/'.$recruit->recruit_id).'" target="_blank" data-toggle="tooltip" title="Export"><i class="feather icon-file-text"></i></a>';
            })
            ->rawColumns(['view', 'export'])
        ->toJson();
    }

    public function getRateByLevel(Request $request)
    {
        $department = NULL;
        if($request->has('department_id')) {
            $department = $request->get('department_id');
        }

        $period = NULL;
        if($request->has('period_id')) {
            $period = $request->get('period_id');
        }

        $data = array();

        $grade_group = GradeGroup::all();

        foreach($grade_group as $gg) {
            $object = (object) array();
            $object->grade_group = $gg->grade_group_name;

            $object->request = Recruit::query()
                ->selectRaw('COUNT(trans_recruitment_recruit.recruit_id) AS count_request')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                ->where('g.grade_group_id', $gg->grade_group_id);

            $object->fulfilled = Recruit::query()
                ->selectRaw('COUNT(trans_recruitment_recruit.recruit_id) AS count_request')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                ->where('g.grade_group_id', $gg->grade_group_id)
                ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED');

            $object->lead_time = Recruit::query()
                ->selectRaw('IFNULL(FORMAT(AVG(DATEDIFF(trans_recruitment_recruit.lead_time_end, trans_recruitment_recruit.lead_time_start)), 2, "en_US"), 0) AS lead_time')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                ->where('g.grade_group_id', $gg->grade_group_id)
                ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED');

            $object->cost_hire = Recruit::query()
                ->selectRaw('IFNULL(FORMAT(AVG(trans_recruitment_recruit.external_cost + trans_recruitment_recruit.internal_cost + trans_recruitment_recruit.advertising_expenses + trans_recruitment_recruit.assessment_online + trans_recruitment_recruit.medical_checkup + trans_recruitment_recruit.travel_expenses + trans_recruitment_recruit.hiring_bonus + trans_recruitment_recruit.referral_bonus), 2, "en_US"), 0) AS cost_hire')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                ->where('g.grade_group_id', $gg->grade_group_id)
                ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED');

            if($department > 0) {
                $object->request = $object->request->where('trans_recruitment_recruit.department_id', $department);
                $object->fulfilled = $object->fulfilled->where('trans_recruitment_recruit.department_id', $department);
                $object->lead_time = $object->lead_time->where('trans_recruitment_recruit.department_id', $department);
                $object->cost_hire = $object->cost_hire->where('trans_recruitment_recruit.department_id', $department);
            }

            if($period > 0) {
                $object->request = $object->request->where('trans_recruitment_recruit.period_id', $period);
                $object->fulfilled = $object->fulfilled->where('trans_recruitment_recruit.period_id', $period);
                $object->lead_time = $object->lead_time->where('trans_recruitment_recruit.period_id', $period);
                $object->cost_hire = $object->cost_hire->where('trans_recruitment_recruit.period_id', $period);
            }

            $object->request = $object->request->first()->count_request;
            $object->fulfilled = $object->fulfilled->first()->count_request;
            $object->lead_time = $object->lead_time->first()->lead_time;
            $object->cost_hire = $object->cost_hire->first()->cost_hire;

            array_push($data, $object);
        }

        return datatables()->of($data)->addIndexColumn()->toJson();
    }

    public function getRateByDepartment(Request $request)
    {
        $grade_group = NULL;
        if($request->has('grade_group_id')) {
            $grade_group = $request->get('grade_group_id');
        }

        $period = NULL;
        if($request->has('period_id')) {
            $period = $request->get('period_id');
        }

        $data = array();

        $department = Departement::all();

        foreach($department as $d) {
            $object = (object) array();
            $object->department = $d->department_name;

            $object->request = Recruit::query()
                ->selectRaw('COUNT(trans_recruitment_recruit.recruit_id) AS count_request')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                ->where('trans_recruitment_recruit.department_id', $d->department_id);

            $object->fulfilled = Recruit::query()
                ->selectRaw('COUNT(trans_recruitment_recruit.recruit_id) AS count_request')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                ->where('trans_recruitment_recruit.department_id', $d->department_id)
                ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED');

            $object->lead_time = Recruit::query()
                ->selectRaw('IFNULL(FORMAT(AVG(DATEDIFF(trans_recruitment_recruit.lead_time_end, trans_recruitment_recruit.lead_time_start)), 2, "en_US"), 0) AS lead_time')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                ->where('trans_recruitment_recruit.department_id', $d->department_id)
                ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED');

            $object->cost_hire = Recruit::query()
                ->selectRaw('IFNULL(FORMAT(AVG(trans_recruitment_recruit.external_cost + trans_recruitment_recruit.internal_cost + trans_recruitment_recruit.advertising_expenses + trans_recruitment_recruit.assessment_online + trans_recruitment_recruit.medical_checkup + trans_recruitment_recruit.travel_expenses + trans_recruitment_recruit.hiring_bonus + trans_recruitment_recruit.referral_bonus), 2, "en_US"), 0) AS cost_hire')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                ->where('trans_recruitment_recruit.department_id', $d->department_id)
                ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED');

            if($grade_group > 0) {
                $object->request = $object->request->where('g.grade_group_id', $grade_group);
                $object->fulfilled = $object->fulfilled->where('g.grade_group_id', $grade_group);
                $object->lead_time = $object->lead_time->where('g.grade_group_id', $grade_group);
                $object->cost_hire = $object->cost_hire->where('g.grade_group_id', $grade_group);
            }

            if($period > 0) {
                $object->request = $object->request->where('trans_recruitment_recruit.period_id', $period);
                $object->fulfilled = $object->fulfilled->where('trans_recruitment_recruit.period_id', $period);
                $object->lead_time = $object->lead_time->where('trans_recruitment_recruit.period_id', $period);
                $object->cost_hire = $object->cost_hire->where('trans_recruitment_recruit.period_id', $period);
            }

            $object->request = $object->request->first()->count_request;
            $object->fulfilled = $object->fulfilled->first()->count_request;
            $object->lead_time = $object->lead_time->first()->lead_time;
            $object->cost_hire = $object->cost_hire->first()->cost_hire;

            array_push($data, $object);
        }

        return datatables()->of($data)->addIndexColumn()->toJson();
    }
    
    public function getResourceByLevel(Request $request)
    {
        $department = NULL;
        if($request->has('department_id')) {
            $department = $request->get('department_id');
        }

        $period = NULL;
        if($request->has('period_id')) {
            $period = $request->get('period_id');
        }

        $data = array();

        $grade_group = GradeGroup::all();

        foreach($grade_group as $gg) {
            $object = (object) array();
            $object->grade_group = $gg->grade_group_name;

            $object->fulfilled = Recruit::query()
                ->selectRaw('COUNT(trans_recruitment_recruit.recruit_id) AS count_request')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                ->where('g.grade_group_id', $gg->grade_group_id)
                ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED');

            $object->head_hunter = Recruit::query()
                ->selectRaw('COUNT(trans_recruitment_recruit.recruit_id) AS count_request')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                ->where('g.grade_group_id', $gg->grade_group_id)
                ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
                ->where('trans_recruitment_recruit.hiring_resource', 'Head Hunter');

            $object->job_fair = Recruit::query()
                ->selectRaw('COUNT(trans_recruitment_recruit.recruit_id) AS count_request')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                ->where('g.grade_group_id', $gg->grade_group_id)
                ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
                ->where('trans_recruitment_recruit.hiring_resource', 'Job Fair');

            $object->job_ads = Recruit::query()
                ->selectRaw('COUNT(trans_recruitment_recruit.recruit_id) AS count_request')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                ->where('g.grade_group_id', $gg->grade_group_id)
                ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
                ->where('trans_recruitment_recruit.hiring_resource', 'Job Ads');

            $object->linkedin = Recruit::query()
                ->selectRaw('COUNT(trans_recruitment_recruit.recruit_id) AS count_request')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                ->where('g.grade_group_id', $gg->grade_group_id)
                ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
                ->where('trans_recruitment_recruit.hiring_resource', 'LinkedIn');

            $object->outsourcing = Recruit::query()
                ->selectRaw('COUNT(trans_recruitment_recruit.recruit_id) AS count_request')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                ->where('g.grade_group_id', $gg->grade_group_id)
                ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
                ->where('trans_recruitment_recruit.hiring_resource', 'Outsourcing');

            $object->reference = Recruit::query()
                ->selectRaw('COUNT(trans_recruitment_recruit.recruit_id) AS count_request')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                ->where('g.grade_group_id', $gg->grade_group_id)
                ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
                ->where('trans_recruitment_recruit.hiring_resource', 'Reference');

            if($department > 0) {
                $object->fulfilled = $object->fulfilled->where('trans_recruitment_recruit.department_id', $department);
                $object->head_hunter = $object->head_hunter->where('trans_recruitment_recruit.department_id', $department);
                $object->job_fair = $object->job_fair->where('trans_recruitment_recruit.department_id', $department);
                $object->job_ads = $object->job_ads->where('trans_recruitment_recruit.department_id', $department);
                $object->linkedin = $object->linkedin->where('trans_recruitment_recruit.department_id', $department);
                $object->outsourcing = $object->outsourcing->where('trans_recruitment_recruit.department_id', $department);
                $object->reference = $object->reference->where('trans_recruitment_recruit.department_id', $department);
            }

            if($period > 0) {
                $object->fulfilled = $object->fulfilled->where('trans_recruitment_recruit.period_id', $period);
                $object->head_hunter = $object->head_hunter->where('trans_recruitment_recruit.period_id', $period);
                $object->job_fair = $object->job_fair->where('trans_recruitment_recruit.period_id', $period);
                $object->job_ads = $object->job_ads->where('trans_recruitment_recruit.period_id', $period);
                $object->linkedin = $object->linkedin->where('trans_recruitment_recruit.period_id', $period);
                $object->outsourcing = $object->outsourcing->where('trans_recruitment_recruit.period_id', $period);
                $object->reference = $object->reference->where('trans_recruitment_recruit.period_id', $period);
            }

            $object->fulfilled = $object->fulfilled->first()->count_request;
            $object->head_hunter = $object->head_hunter->first()->count_request;
            $object->job_fair = $object->job_fair->first()->count_request;
            $object->job_ads = $object->job_ads->first()->count_request;
            $object->linkedin = $object->linkedin->first()->count_request;
            $object->outsourcing = $object->outsourcing->first()->count_request;
            $object->reference = $object->reference->first()->count_request;

            array_push($data, $object);
        }

        return datatables()->of($data)->addIndexColumn()->toJson();
    }

    public function getResourceByDepartment(Request $request)
    {
        $grade_group = NULL;
        if($request->has('grade_group_id')) {
            $grade_group = $request->get('grade_group_id');
        }

        $period = NULL;
        if($request->has('period_id')) {
            $period = $request->get('period_id');
        }

        $data = array();

        $department = Departement::all();

        foreach($department as $d) {
            $object = (object) array();
            $object->department = $d->department_name;

            $object->fulfilled = Recruit::query()
                ->selectRaw('COUNT(trans_recruitment_recruit.recruit_id) AS count_request')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                ->where('trans_recruitment_recruit.department_id', $d->department_id)
                ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED');

            $object->head_hunter = Recruit::query()
                ->selectRaw('COUNT(trans_recruitment_recruit.recruit_id) AS count_request')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                ->where('trans_recruitment_recruit.department_id', $d->department_id)
                ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
                ->where('trans_recruitment_recruit.hiring_resource', 'Head Hunter');

            $object->job_fair = Recruit::query()
                ->selectRaw('COUNT(trans_recruitment_recruit.recruit_id) AS count_request')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                ->where('trans_recruitment_recruit.department_id', $d->department_id)
                ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
                ->where('trans_recruitment_recruit.hiring_resource', 'Job Fair');

            $object->job_ads = Recruit::query()
                ->selectRaw('COUNT(trans_recruitment_recruit.recruit_id) AS count_request')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                ->where('trans_recruitment_recruit.department_id', $d->department_id)
                ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
                ->where('trans_recruitment_recruit.hiring_resource', 'Job Ads');

            $object->linkedin = Recruit::query()
                ->selectRaw('COUNT(trans_recruitment_recruit.recruit_id) AS count_request')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                ->where('trans_recruitment_recruit.department_id', $d->department_id)
                ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
                ->where('trans_recruitment_recruit.hiring_resource', 'LinkedIn');

            $object->outsourcing = Recruit::query()
                ->selectRaw('COUNT(trans_recruitment_recruit.recruit_id) AS count_request')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                ->where('trans_recruitment_recruit.department_id', $d->department_id)
                ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
                ->where('trans_recruitment_recruit.hiring_resource', 'Outsourcing');

            $object->reference = Recruit::query()
                ->selectRaw('COUNT(trans_recruitment_recruit.recruit_id) AS count_request')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                ->where('trans_recruitment_recruit.department_id', $d->department_id)
                ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
                ->where('trans_recruitment_recruit.hiring_resource', 'Reference');

            if($grade_group > 0) {
                $object->fulfilled = $object->fulfilled->where('g.grade_group_id', $grade_group);
                $object->head_hunter = $object->head_hunter->where('g.grade_group_id', $grade_group);
                $object->job_fair = $object->job_fair->where('g.grade_group_id', $grade_group);
                $object->job_ads = $object->job_ads->where('g.grade_group_id', $grade_group);
                $object->linkedin = $object->linkedin->where('g.grade_group_id', $grade_group);
                $object->outsourcing = $object->outsourcing->where('g.grade_group_id', $grade_group);
                $object->reference = $object->reference->where('g.grade_group_id', $grade_group);
            }

            if($period > 0) {
                $object->fulfilled = $object->fulfilled->where('trans_recruitment_recruit.period_id', $period);
                $object->head_hunter = $object->head_hunter->where('trans_recruitment_recruit.period_id', $period);
                $object->job_fair = $object->job_fair->where('trans_recruitment_recruit.period_id', $period);
                $object->job_ads = $object->job_ads->where('trans_recruitment_recruit.period_id', $period);
                $object->linkedin = $object->linkedin->where('trans_recruitment_recruit.period_id', $period);
                $object->outsourcing = $object->outsourcing->where('trans_recruitment_recruit.period_id', $period);
                $object->reference = $object->reference->where('trans_recruitment_recruit.period_id', $period);
            }

            $object->fulfilled = $object->fulfilled->first()->count_request;
            $object->head_hunter = $object->head_hunter->first()->count_request;
            $object->job_fair = $object->job_fair->first()->count_request;
            $object->job_ads = $object->job_ads->first()->count_request;
            $object->linkedin = $object->linkedin->first()->count_request;
            $object->outsourcing = $object->outsourcing->first()->count_request;
            $object->reference = $object->reference->first()->count_request;

            array_push($data, $object);
        }

        return datatables()->of($data)->addIndexColumn()->toJson();
    }

    public function reportExport(Request $request)
    {
        $period = NULL;
        if($request->has('period')) {
            $period = $request->get('period');
        }

        $title = NULL;
        if($request->has('title')) {
            $title = $request->get('title');
        }

        $poh = NULL;
        if($request->has('poh')) {
            $poh = $request->get('poh');
        }

        return Excel::download(new ReportExport($period, $title, $poh), 'report.xlsx');
    }

    public function rateExport(Request $request)
    {
        $period = NULL;
        if($request->has('period')) {
            $period = $request->get('period');
        }

        $department = NULL;
        if($request->has('dept')) {
            $department = $request->get('dept');
        }

        $grade_group = NULL;
        if($request->has('gg')) {
            $grade_group = $request->get('gg');
        }

        return Excel::download(new RateExport($period, $department, $grade_group), 'rate.xlsx');
    }

    public function resourceExport(Request $request)
    {
        $period = NULL;
        if($request->has('period')) {
            $period = $request->get('period');
        }

        $department = NULL;
        if($request->has('dept')) {
            $department = $request->get('dept');
        }

        $grade_group = NULL;
        if($request->has('gg')) {
            $grade_group = $request->get('gg');
        }

        return Excel::download(new ResourceExport($period, $department, $grade_group), 'resource.xlsx');
    }

}
