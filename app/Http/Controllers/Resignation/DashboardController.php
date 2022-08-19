<?php

namespace App\Http\Controllers\Resignation;

use App\Model\Departement;
use App\Model\User;
use App\Model\Plugin\PluginPeriod;
use App\Model\Resignation\Access;
use App\Model\Resignation\Feedback;
use App\Model\Resignation\Resign;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\AgeCategory;
use App\Model\Plugin\PluginMonth;
use App\Model\Plugin\PluginYear;
use App\Helper\HelperService;

use Auth;

class DashboardController extends Controller
{
	public $Helper;

	public function __construct(HelperService $Helper)
	{
		$this->Helper = $Helper;
	}

    public function index()
    {
    	$period_all = PluginPeriod::where('period_status', '1')->orderBy('period_name')->get();
        $period_name = date('m') <= 3 ? ((date('Y') - 1).'-'.date('Y')) : (date('Y').'-'.(date('Y') + 1));
        $period = PluginPeriod::where('period_name', $period_name)->first();

    	return view('resignation.index', compact('period_all', 'period'));
    }

    public function analytics()
    {
        $period_all = PluginPeriod::where('period_status', '1')->orderBy('period_name')->get();
        $period_name = date('m') <= 3 ? ((date('Y') - 1).'-'.date('Y')) : (date('Y').'-'.(date('Y') + 1));
        $period = PluginPeriod::where('period_name', $period_name)->first();

		$month = PluginMonth::all();
        $year = PluginYear::where('year_status', '1')->orderBy('year_name')->get();

        return view('resignation.analytics', compact('period_all', 'period', 'month', 'year'));
    }

    public function getResignCount(Request $request)
    {
    	$filter_type = 'period';
        if($request->has('filter_type')) {
            $filter_type = $request->get('filter_type');
        }
        
        $period = $this->Helper->getIdPriodNow();
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

    	$data->resignation_request = Resign::query()
    		->selectRaw('COUNT(resign_id) AS count_resign')
			->where('resign_status','!=','reject')
			->where('resign_status','!=','cancel');

    	$data->resignation_approval = Resign::query()
    		->selectRaw('COUNT(resign_id) AS count_resign')
    		->where('resign_status','in progress');

    	$data->resignation_feedback = Resign::query()
    		->selectRaw('COUNT(mst_resignation_resign_list.resign_id) AS count_resign')
    		->leftJoin('mst_resignation_feedback AS rf', 'rf.resign_id', 'mst_resignation_resign_list.resign_id')
    		->where('mst_resignation_resign_list.resign_status', 'approve')
    		->whereNull('rf.resign_feedback_id');

    	$data->resignation_clearance = Resign::query()
    		->selectRaw('COUNT(mst_resignation_resign_list.resign_id) AS count_resign')
    		->leftJoin('mst_resignation_feedback AS rf', 'rf.resign_id', 'mst_resignation_resign_list.resign_id')
    		->where('mst_resignation_resign_list.resign_status', 'approve')
    		->whereNull('mst_resignation_resign_list.resign_clearance_status')
    		->whereNotNull('rf.resign_feedback_id');

    	$data->resignation_fulfilled = Resign::query()
    		->selectRaw('COUNT(resign_id) AS count_resign')
    		->where('resign_clearance_status', 'approve')
    		->where('resign_status', 'approve');

		if($filter_type == 'period') {
    		$data->resignation_request = $data->resignation_request->where('period_id', $period);
    		$data->resignation_approval = $data->resignation_approval->where('period_id', $period);
    		$data->resignation_feedback = $data->resignation_feedback->where('period_id', $period);
    		$data->resignation_clearance = $data->resignation_clearance->where('period_id', $period);
    		$data->resignation_fulfilled = $data->resignation_fulfilled->where('period_id', $period);
    	} else if($filter_type == 'month_year') {
            $data->resignation_request = $data->resignation_request->whereMonth('resign_date', $month)
                ->whereYear('resign_date', $year);
            $data->resignation_approval = $data->resignation_approval->whereMonth('resign_date', $month)
                ->whereYear('resign_date', $year);
            $data->resignation_feedback = $data->resignation_feedback->whereMonth('resign_date', $month)
                ->whereYear('resign_date', $year);
            $data->resignation_clearance = $data->resignation_clearance->whereMonth('resign_date', $month)
                ->whereYear('resign_date', $year);
            $data->resignation_fulfilled = $data->resignation_fulfilled->whereMonth('resign_date', $month)
                ->whereYear('resign_date', $year);
        }

		$data->resignation_request = $data->resignation_request->first()->count_resign;
		$data->resignation_approval = $data->resignation_approval->first()->count_resign;
		$data->resignation_feedback = $data->resignation_feedback->first()->count_resign;
		$data->resignation_clearance = $data->resignation_clearance->first()->count_resign;
		$data->resignation_fulfilled = $data->resignation_fulfilled->first()->count_resign;
    	
    	return response()->json($data);
    }

    public function getAttritionTalent(Request $request)
    {
    	$filter_type = 'period';
        if($request->has('filter_type')) {
            $filter_type = $request->get('filter_type');
        }
        
        $period = $this->Helper->getIdPriodNow();
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

    	$talent = (object) array();
    	$talent->name = 'Talent';
    	$talent->value = Resign::query()
    		->selectRaw('COUNT(resign_id) AS count_resign')
    		->where('resign_user_talent', 'talent')
    		->where('resign_clearance_status', 'approve')
    		->where('resign_status', 'approve');

    	$non_talent = (object) array();
    	$non_talent->name = 'Non Talent';
    	$non_talent->value = Resign::query()
    		->selectRaw('COUNT(resign_id) AS count_resign')
    		->where('resign_user_talent', 'non-talent')
    		->where('resign_clearance_status', 'approve')
    		->where('resign_status', 'approve');


		if($filter_type == 'period') {
    		$talent->value->where('period_id', $period);
    		$non_talent->value->where('period_id', $period);
    	} else if($filter_type == 'month_year') {
            $talent->value->whereMonth('resign_date', $month)
                ->whereYear('resign_date', $year);
            $non_talent->value->whereMonth('resign_date', $month)
                ->whereYear('resign_date', $year);
        }

		$talent->value = $talent->value->first()->count_resign;
		$non_talent->value = $non_talent->value->first()->count_resign;
    	
    	array_push($data, $talent);
    	array_push($data, $non_talent);

    	return response()->json($data);
    }

    public function getAttritionInitiation(Request $request)
    {
        $filter_type = 'period';
        if($request->has('filter_type')) {
            $filter_type = $request->get('filter_type');
        }
        
        $period = $this->Helper->getIdPriodNow();
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

        $voluntary = (object) array();
        $voluntary->name = 'Voluntary';
        $voluntary->value = Resign::query()
            ->selectRaw('COUNT(resign_id) AS count_resign')
            ->where('resign_user_initation', 'volunteer')
            ->where('resign_clearance_status', 'approve')
            ->where('resign_status', 'approve');
        
        $non_voluntary = (object) array();
        $non_voluntary->name = 'Non Voluntary';
        $non_voluntary->value = Resign::query()
            ->selectRaw('COUNT(resign_id) AS count_resign')
            ->where('resign_user_initation', 'non-volunteer')
            ->where('resign_clearance_status', 'approve')
            ->where('resign_status', 'approve');
        
		if($filter_type == 'period') {
    		$voluntary->value->where('period_id', $period);
    		$non_voluntary->value->where('period_id', $period);
    		
    	} else if($filter_type == 'month_year') {
            $voluntary->value->whereMonth('resign_date', $month)
                ->whereYear('resign_date', $year);
            $non_voluntary->value->whereMonth('resign_date', $month)
                ->whereYear('resign_date', $year);
        }

		$voluntary->value = $voluntary->value->first()->count_resign;
		$non_voluntary->value = $non_voluntary->value->first()->count_resign;

        array_push($data, $voluntary);
        array_push($data, $non_voluntary);

        return response()->json($data);
    }

    public function getResignationByDept(Request $request)
    {
    	$filter_type = 'period';
        if($request->has('filter_type')) {
            $filter_type = $request->get('filter_type');
        }
        
        $period = $this->Helper->getIdPriodNow();
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

    	$department = Departement::all();

    	$data = array();

    	foreach($department as $d) {
    		$object = (object) array();
    		$object->name = $d->department_name;
    		$object->value = Resign::query()
    			->selectRaw('COUNT(mst_resignation_resign_list.resign_id) AS count_resign')
    			->leftJoin('mst_main_user AS u', 'u.user_nik', 'mst_resignation_resign_list.user_nik')
    			->where('mst_resignation_resign_list.resign_status', 'approve')
    			->where('mst_resignation_resign_list.resign_clearance_status', 'approve')
    			->where('u.department_id', $d->department_id);

			if($filter_type == 'period') {
				$object->value->where('mst_resignation_resign_list.period_id', $period);
			} else if($filter_type == 'month_year') {
				$object->value->whereMonth('mst_resignation_resign_list.resign_date', $month)
					->whereYear('mst_resignation_resign_list.resign_date', $year);
			}

			$object->value = $object->value->first()->count_resign;

    		array_push($data, $object);
    	}

    	return response()->json($data);
    }

    public function getResignationByGradeGroup(Request $request)
    {
    	$filter_type = 'period';
        if($request->has('filter_type')) {
            $filter_type = $request->get('filter_type');
        }
        
        $period = $this->Helper->getIdPriodNow();
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

		if($filter_type == 'period') {
			$queryCondition = "AND mrrl.period_id = '$period'" ;
		} else if($filter_type == 'month_year') {
			$queryCondition = "AND MONTH(mrrl.resign_date) = '$month'
								AND YEAR(mrrl.resign_date) = '$year'";
		}

		$query = "SELECT 
					mmugg.grade_group_name as name,
					count(mrrl.resign_id) as value
				FROM 
					mst_main_user_grade_group as mmugg
				LEFT JOIN mst_main_user_grade as mmug 
					ON mmug.grade_group_id = mmugg.grade_group_id
					AND mmug.deleted_at IS NULL 
				LEFT JOIN mst_main_user as mmu
					ON mmu.grade_id = mmug.grade_id
				-- 	AND mmu.deleted_at IS NULL
				left JOIN mst_resignation_resign_list as mrrl
					ON mrrl.user_nik = mmu.user_nik
					AND mrrl.deleted_at IS null
					$queryCondition
					AND mrrl.resign_status = 'approve'
				WHERE mmugg.deleted_at IS NULL
				GROUP BY mmugg.grade_group_name";

    	$data = DB::select($query);

    	return response()->json($data);
    }

	public function getResignationByAgeCategory(Request $request)
	{
		$filter_type = 'period';
        if($request->has('filter_type')) {
            $filter_type = $request->get('filter_type');
        }
        
        $period = $this->Helper->getIdPriodNow();
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

		$age_category = AgeCategory::all(); //mendapatkan seluruh age category

		$data = array();

		$user = Resign::with('User') //mendapatkan seleruh user yang resign
			->where('resign_status','approve');

		if($filter_type == 'period') {
			$user->where('period_id', $period);
		} else if($filter_type == 'month_year') {
			$user->whereMonth('resign_date', $month)
				->whereYear('resign_date', $year);
		}

		$user = $user->get();

		foreach ($age_category as $age) { //mengulang age category
			$object = (object) array();
    		$object->name = $age->age_name; // set name age category
			$object->value = 0; // set default value age category

			$years_age = explode('-', $age->age_years);
			foreach ($user as $item) {
				$years_birth = explode('-',$item->User->user_birth_date);
				if (count($years_age) == 1) { // untuk tahun yang tidak memiliki range
                    if ($years_birth[0] >= $years_age[0]) {
                        $object->value = $object->value + 1;
                    }
                } else {
                    if (($years_birth[0] >= $years_age[0] && $years_birth[0] <= $years_age[1])) { // untuk age category yang memiliki range
						$object->value = $object->value + 1;
                    }
                }
			}
            array_push($data, $object); 
		}

		return response()->json($data);
	}

    public function getAttritionReason(Request $request)
    {
    	$filter_type = 'period';
        if($request->has('filter_type')) {
            $filter_type = $request->get('filter_type');
        }
        
        $period = $this->Helper->getIdPriodNow();
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

    	$reason = [
    		'Leadership Issue',
    		'Working Location',
    		'Better benefit',
    		'Career development',
    		'Family or Personal reason',
    		'Work load',
    		'Medical reason',
    		'Environment and culture'
    	];

    	foreach($reason as $r) {
    		$count_resign = Feedback::query()
                ->selectRaw('COUNT(mst_resignation_feedback.resign_feedback_id) AS count_resign')
                ->leftJoin('mst_resignation_resign_list AS rl', 'rl.resign_id', 'mst_resignation_feedback.resign_id')
                ->where('mst_resignation_feedback.resign_feedback_1', 'LIKE', '%'.$r.'%');

			if($filter_type == 'period') {
				$count_resign->where('rl.period_id', $period);
			} else if($filter_type == 'month_year') {
				$count_resign->whereMonth('rl.resign_date', $month)
					->whereYear('rl.resign_date', $year);
			}

			$count_resign = $count_resign->first()->count_resign;

            array_push($data, $count_resign);
    	}

    	return response()->json($data);
    }

    public function getAttritionYears(Request $request)
    {
    	$filter_type = 'period';
        if($request->has('filter_type')) {
            $filter_type = $request->get('filter_type');
        }
        
        $period = $this->Helper->getIdPriodNow();
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

    	$work_years = [
    		'1' => 'Less than 1 year',
            '2' => '1 to 3 years',
            '3' => '3 to 10 years',
            '4' => 'More than 10 years'
    	];

    	foreach($work_years as $key => $value) {
    		$count_resign = Resign::query()
                ->selectRaw('COUNT(mst_resignation_resign_list.resign_id) AS count_resign')
                ->leftJoin('mst_main_user AS u', 'u.user_nik', 'mst_resignation_resign_list.user_nik')
                ->leftJoin('mst_main_user_grade AS ug', 'ug.grade_id', 'u.grade_id');

            if($key == '1') {
                $count_resign = $count_resign->whereRaw('DATEDIFF(mst_resignation_resign_list.resign_date, u.user_join_date) < 365');
            } else if($key == '2') {
                $count_resign = $count_resign->whereRaw('DATEDIFF(mst_resignation_resign_list.resign_date, u.user_join_date) >= 365')->whereRaw('DATEDIFF(mst_resignation_resign_list.resign_date, u.user_join_date) < 1095');
            } else if($key == '3') {
                $count_resign = $count_resign->whereRaw('DATEDIFF(mst_resignation_resign_list.resign_date, u.user_join_date) >= 1095')->whereRaw('DATEDIFF(mst_resignation_resign_list.resign_date, u.user_join_date) <= 3650');
            } else if($key == '4') {
                $count_resign = $count_resign->whereRaw('DATEDIFF(mst_resignation_resign_list.resign_date, u.user_join_date) > 3650');
            }

			if($filter_type == 'period') {
				$count_resign->where('mst_resignation_resign_list.period_id', $period);
			} else if($filter_type == 'month_year') {
				$count_resign->whereMonth('mst_resignation_resign_list.resign_date', $month)
					->whereYear('mst_resignation_resign_list.resign_date', $year);
			}

            $count_resign = $count_resign->first()->count_resign;

            array_push($data, $count_resign);
    	}

    	return response()->json($data);
    }
}
