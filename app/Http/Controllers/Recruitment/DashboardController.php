<?php

namespace App\Http\Controllers\Recruitment;

use App\Model\Departement;
use App\Model\Grade;
use App\Model\GradeGroup;
use App\Model\Title;
use App\Model\User;
use App\Model\Plugin\PluginMonth;
use App\Model\Plugin\PluginPeriod;
use App\Model\Plugin\PluginYear;
use App\Model\Recruitment\PointOfHire;
use App\Model\Recruitment\Recruit;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $period_all = PluginPeriod::where('period_status', '1')->orderBy('period_name')->get();
        $period_name = date('m') <= 3 ? ((date('Y') - 1).'-'.date('Y')) : (date('Y').'-'.(date('Y') + 1));
        $period = PluginPeriod::where('period_name', $period_name)->first();

        return view('recruitment.dashboard', compact('period_all', 'period'));
    }

    public function analytics()
    {
        $period_all = PluginPeriod::where('period_status', '1')->orderBy('period_name')->get();
        $period_name = date('m') <= 3 ? ((date('Y') - 1).'-'.date('Y')) : (date('Y').'-'.(date('Y') + 1));
        $period = PluginPeriod::where('period_name', $period_name)->first();
        
        $month = PluginMonth::all();
        $year = PluginYear::where('year_status', '1')->orderBy('year_name')->get();

        return view('recruitment.analytics', compact('period_all', 'period', 'month', 'year'));
    }

    public function getRecruitCount(Request $request)
    {
    	$filter_type = 'period';
        if($request->has('filter_type')) {
            $filter_type = $request->get('filter_type');
        }
        
        $period = NULL;
    	if($request->has('period_id')) {
    		$period = $request->get('period_id');
    	}

        $month = NULL;
        if($request->has('month')) {
            $month = $request->get('month');
        }

        $year = NULL;
        if($request->has('year')) {
            $year = $request->get('year');
        }

    	$data = (object) array();

    	$data->recruitment_request = Recruit::query()
    		->selectRaw('COUNT(trans_recruitment_recruit.recruit_id) AS count_request');

    	$data->recruitment_process = Recruit::query()
    		->selectRaw('COUNT(trans_recruitment_recruit.recruit_id) AS count_request')
    		->where('trans_recruitment_recruit.recruit_status', 'ON PROCESS');

    	$data->recruitment_fulfilled = Recruit::query()
    		->selectRaw('COUNT(trans_recruitment_recruit.recruit_id) AS count_request')
    		->where('trans_recruitment_recruit.recruit_status', 'FULFILLED');

    	if($filter_type == 'period') {
    		$data->recruitment_request = $data->recruitment_request->where('trans_recruitment_recruit.period_id', $period);
    		$data->recruitment_process = $data->recruitment_process->where('trans_recruitment_recruit.period_id', $period);
    		$data->recruitment_fulfilled = $data->recruitment_fulfilled->where('trans_recruitment_recruit.period_id', $period);
    	} else if($filter_type == 'month_year') {
            $data->recruitment_request = $data->recruitment_request->whereMonth('trans_recruitment_recruit.request_date', $month)
                ->whereYear('trans_recruitment_recruit.request_date', $year);
            $data->recruitment_process = $data->recruitment_process->whereMonth('trans_recruitment_recruit.lead_time_start', $month)
                ->whereYear('trans_recruitment_recruit.lead_time_start', $year);
            $data->recruitment_fulfilled = $data->recruitment_fulfilled->whereMonth('trans_recruitment_recruit.lead_time_end', $month)
                ->whereYear('trans_recruitment_recruit.lead_time_end', $year);
        }

    	$data->recruitment_request = $data->recruitment_request->first()->count_request;
    	$data->recruitment_process = $data->recruitment_process->first()->count_request;
    	$data->recruitment_fulfilled = $data->recruitment_fulfilled->first()->count_request;

    	return response()->json($data);
    }

    public function getHiringResource(Request $request)
    {
    	$filter_type = 'period';
        if($request->has('filter_type')) {
            $filter_type = $request->get('filter_type');
        }
        
        $period = NULL;
    	if($request->has('period_id')) {
    		$period = $request->get('period_id');
    	}

        $month = NULL;
        if($request->has('month')) {
            $month = $request->get('month');
        }

        $year = NULL;
        if($request->has('year')) {
            $year = $request->get('year');
        }

        $data = array();

        $head_hunter = (object) array();
		$head_hunter->value = Recruit::query()
            ->selectRaw('COUNT(trans_recruitment_recruit.recruit_id) AS count_request')
            ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
            ->where('trans_recruitment_recruit.hiring_resource', 'Head Hunter');
        $head_hunter->name = 'Head Hunter';

        $job_fair = (object) array();
        $job_fair->value = Recruit::query()
            ->selectRaw('COUNT(trans_recruitment_recruit.recruit_id) AS count_request')
            ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
            ->where('trans_recruitment_recruit.hiring_resource', 'Job Fair');
        $job_fair->name = 'Job Fair';

        $job_ads = (object) array();
        $job_ads->value = Recruit::query()
            ->selectRaw('COUNT(trans_recruitment_recruit.recruit_id) AS count_request')
            ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
            ->where('trans_recruitment_recruit.hiring_resource', 'Job Ads');
        $job_ads->name = 'Job Ads';

        $linkedin = (object) array();
        $linkedin->value = Recruit::query()
            ->selectRaw('COUNT(trans_recruitment_recruit.recruit_id) AS count_request')
            ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
            ->where('trans_recruitment_recruit.hiring_resource', 'LinkedIn');
        $linkedin->name = 'LinkedIn';

        $outsourcing = (object) array();
        $outsourcing->value = Recruit::query()
            ->selectRaw('COUNT(trans_recruitment_recruit.recruit_id) AS count_request')
            ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
            ->where('trans_recruitment_recruit.hiring_resource', 'Outsourcing');
        $outsourcing->name = 'Outsourcing';

        $reference = (object) array();
        $reference->value = Recruit::query()
            ->selectRaw('COUNT(trans_recruitment_recruit.recruit_id) AS count_request')
            ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
            ->where('trans_recruitment_recruit.hiring_resource', 'Reference');
        $reference->name = 'Reference';

        if($filter_type == 'period') {
            $head_hunter->value = $head_hunter->value->where('trans_recruitment_recruit.period_id', $period);
            $job_fair->value = $job_fair->value->where('trans_recruitment_recruit.period_id', $period);
            $job_ads->value = $job_ads->value->where('trans_recruitment_recruit.period_id', $period);
            $linkedin->value = $linkedin->value->where('trans_recruitment_recruit.period_id', $period);
            $outsourcing->value = $outsourcing->value->where('trans_recruitment_recruit.period_id', $period);
            $reference->value = $reference->value->where('trans_recruitment_recruit.period_id', $period);
        } else if($filter_type == 'month_year') {
            $head_hunter->value = $head_hunter->value->whereMonth('trans_recruitment_recruit.lead_time_end', $month)
                ->whereYear('trans_recruitment_recruit.lead_time_end', $year);
            $job_fair->value = $job_fair->value->whereMonth('trans_recruitment_recruit.lead_time_end', $month)
                ->whereYear('trans_recruitment_recruit.lead_time_end', $year);
            $job_ads->value = $job_ads->value->whereMonth('trans_recruitment_recruit.lead_time_end', $month)
                ->whereYear('trans_recruitment_recruit.lead_time_end', $year);
            $linkedin->value = $linkedin->value->whereMonth('trans_recruitment_recruit.lead_time_end', $month)
                ->whereYear('trans_recruitment_recruit.lead_time_end', $year);
            $outsourcing->value = $outsourcing->value->whereMonth('trans_recruitment_recruit.lead_time_end', $month)
                ->whereYear('trans_recruitment_recruit.lead_time_end', $year);
            $reference->value = $reference->value->whereMonth('trans_recruitment_recruit.lead_time_end', $month)
                ->whereYear('trans_recruitment_recruit.lead_time_end', $year);
        }

        $head_hunter->value = $head_hunter->value->first()->count_request;
        $job_fair->value = $job_fair->value->first()->count_request;
        $job_ads->value = $job_ads->value->first()->count_request;
        $linkedin->value = $linkedin->value->first()->count_request;
        $outsourcing->value = $outsourcing->value->first()->count_request;
        $reference->value = $reference->value->first()->count_request;

        array_push($data, $head_hunter);
        array_push($data, $job_fair);
        array_push($data, $job_ads);
        array_push($data, $linkedin);
        array_push($data, $outsourcing);
        array_push($data, $reference);

        return response()->json($data);
    }

    public function getRequestByDept(Request $request)
    {
    	$filter_type = 'period';
        if($request->has('filter_type')) {
            $filter_type = $request->get('filter_type');
        }
        
        $period = NULL;
    	if($request->has('period_id')) {
    		$period = $request->get('period_id');
    	}

        $month = NULL;
        if($request->has('month')) {
            $month = $request->get('month');
        }

        $year = NULL;
        if($request->has('year')) {
            $year = $request->get('year');
        }

        $data = array();

        $department = Departement::all();

        foreach($department as $d) {
        	$object = (object) array();
        	$object->value = Recruit::query()
	            ->selectRaw('COUNT(trans_recruitment_recruit.recruit_id) AS count_request')
	            ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED')
	            ->where('trans_recruitment_recruit.department_id', $d->department_id);

	        if($filter_type == 'period') {
	            $object->value = $object->value->where('trans_recruitment_recruit.period_id', $period);
	        } else if($filter_type == 'month_year') {
                $object->value = $object->value->whereMonth('trans_recruitment_recruit.request_date', $month)
                    ->whereYear('trans_recruitment_recruit.request_date', $year);
            }

	        $object->value = $object->value->first()->count_request;
	        $object->name = $d->department_name;

	        array_push($data, $object);
        }

        return response()->json($data);
    }

    public function getAverageLeadTime(Request $request)
    {
    	$filter_type = 'period';
        if($request->has('filter_type')) {
            $filter_type = $request->get('filter_type');
        }
        
        $period = NULL;
    	if($request->has('period_id')) {
    		$period = $request->get('period_id');
    	}

        $month = NULL;
        if($request->has('month')) {
            $month = $request->get('month');
        }

        $year = NULL;
        if($request->has('year')) {
            $year = $request->get('year');
        }

        $data = array();

        $grade_group = GradeGroup::all();

        foreach($grade_group as $gg) {
        	$lead_time = Recruit::query()
                ->selectRaw('IFNULL(FORMAT(AVG(DATEDIFF(trans_recruitment_recruit.lead_time_end, trans_recruitment_recruit.lead_time_start)), 2, "en_US"), 0) AS lead_time')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                ->where('g.grade_group_id', $gg->grade_group_id)
                ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED');

            if($filter_type == 'period') {
            	$lead_time = $lead_time->where('trans_recruitment_recruit.period_id', $period);
            } else if($filter_type == 'month_year') {
                $lead_time = $lead_time->whereMonth('trans_recruitment_recruit.lead_time_end', $month)
                    ->whereYear('trans_recruitment_recruit.lead_time_end', $year);
            }

            $lead_time = $lead_time->first()->lead_time;

            array_push($data, $lead_time);
        }

        return response()->json($data);
    }

    public function getAverageCostHire(Request $request)
    {
        $filter_type = 'period';
        if($request->has('filter_type')) {
            $filter_type = $request->get('filter_type');
        }
        
        $period = NULL;
    	if($request->has('period_id')) {
    		$period = $request->get('period_id');
    	}

        $month = NULL;
        if($request->has('month')) {
            $month = $request->get('month');
        }

        $year = NULL;
        if($request->has('year')) {
            $year = $request->get('year');
        }

        $data = array();

        $grade_group = GradeGroup::all();

        foreach($grade_group as $gg) {
            $cost_hire = Recruit::query()
                ->selectRaw('ROUND(AVG(trans_recruitment_recruit.external_cost + trans_recruitment_recruit.internal_cost + trans_recruitment_recruit.advertising_expenses + trans_recruitment_recruit.assessment_online + trans_recruitment_recruit.medical_checkup + trans_recruitment_recruit.travel_expenses + trans_recruitment_recruit.hiring_bonus + trans_recruitment_recruit.referral_bonus), 0) AS cost_hire')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_recruitment_recruit.grade_id')
                ->where('g.grade_group_id', $gg->grade_group_id)
                ->where('trans_recruitment_recruit.recruit_status', 'FULFILLED');

            if($filter_type == 'period') {
                $cost_hire = $cost_hire->where('trans_recruitment_recruit.period_id', $period);
            } else if($filter_type == 'month_year') {
                $cost_hire = $cost_hire->whereMonth('trans_recruitment_recruit.lead_time_end', $month)
                    ->whereYear('trans_recruitment_recruit.lead_time_end', $year);
            }

            $cost_hire = $cost_hire->first()->cost_hire;

            array_push($data, $cost_hire);
        }

        return response()->json($data);
    }
}
