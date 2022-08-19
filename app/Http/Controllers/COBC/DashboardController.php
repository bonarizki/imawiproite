<?php

namespace App\Http\Controllers\COBC;

use App\Model\Departement;
use App\Model\Grade;
use App\Model\GradeGroup;
use App\Model\User;
use App\Model\COBC\COBCPeriod;
use App\Model\COBC\UserAnswer;
use App\Model\Plugin\PluginPeriod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth;

class DashboardController extends Controller
{
    // GRADE GROUP COBC ACCESS
    protected $gg_access;

    public function __construct()
    {
        $this->gg_access = array(3,4,5,6,7);
    }

    public function index()
    {
        $period_all = PluginPeriod::where('period_status', '1')->orderBy('period_name')->get();
        $periodName = date('m') <= 3 ? ((date('Y') - 1).'-'.date('Y')) : (date('Y').'-'.(date('Y') + 1));
        $period = PluginPeriod::where('period_name', $periodName)->first();

        $department = Departement::all();

        return view('cobc.dashboard', compact('period_all', 'period', 'department'));
    }

    public function myScore(Request $request)
    {
        $period = NULL;
        if($request->has('period_id')) {
            $period = $request->get('period_id');
        }

        $score = array();
        $status = '';

        $gg = Grade::where('grade_id', Auth::user()->grade_id)->first();

        if(in_array($gg->grade_group_id, $this->gg_access)) {
            $cobc_period = COBCPeriod::where('period_id', $period)->first();
            if((date('Y-m-d') >= $cobc_period->cobc_period_start) && (date('Y-m-d') <= $cobc_period->cobc_period_end)) {
                $work_days = User::query()
                    ->selectRaw('DATEDIFF("'.$cobc_period->cobc_period_end.'", mst_main_user.user_join_date) AS work_days')
                    ->where('user_id', Auth::user()->user_id)
                ->first()->work_days;

                if($work_days > 180) {
                    $quiz_exist = UserAnswer::where('user_id', Auth::user()->user_id)
                        ->where('period_id', $period)
                    ->exists();

                    if($quiz_exist) {
                        $quiz = UserAnswer::query()
                            ->selectRaw('answer_id, phase, completed, score')
                            ->where('user_id', Auth::user()->user_id)
                            ->where('period_id', $period)
                            ->orderBy('phase', 'DESC')
                        ->get();

                        if($quiz[0]->completed == '1') {
                            if($quiz[0]->score >= 80) {
                                $status = 'completed';
                            } else {
                                if($quiz[0]->phase == 3) {
                                    $status = 'failed';
                                } else {
                                    $status = 'try again';
                                }
                            }
                        } else if($quiz[0]->completed == '0') {
                            $status = 'continue';
                        }

                        foreach($quiz as $q) {
                            if($q->score != null) {
                                array_push($score, number_format($q->score, 0, ',', '.'));
                            }
                        }
                    } else {
                        $status = 'new';
                    }
                } else {
                    $status = 'new_emp';
                }
            } else {
                if(date('Y-m-d') < $cobc_period->cobc_period_start) {
                    $status = 'before_time';
                } else if(date('Y-m-d') > $cobc_period->cobc_period_end) {
                    $quiz_exist = UserAnswer::where('user_id', Auth::user()->user_id)
                        ->where('period_id', $period)
                    ->exists();

                    if($quiz_exist) {
                        $quiz = UserAnswer::query()
                            ->selectRaw('answer_id, phase, completed, score')
                            ->where('user_id', Auth::user()->user_id)
                            ->where('period_id', $period)
                            ->orderBy('phase', 'DESC')
                        ->get();

                        if($quiz[0]->completed == '1') {
                            if($quiz[0]->score >= 80) {
                                $status = 'completed';
                            } else {
                                $status = 'failed';
                            }
                        } else if($quiz[0]->completed == '0') {
                            $status = 'failed';
                        }

                        foreach($quiz as $q) {
                            if($q->score != null) {
                                array_push($score, number_format($q->score, 0, ',', '.'));
                            }
                        }
                    } else {
                        $status = 'after_time_no_score';
                    }
                }
            }
        } else {
            $status = 'under_staff';
        }

        $data = (object) array();
        $data->status = $status;
        $data->score = $score;

        return response()->json($data);
    }

    public function employeeParticipation(Request $request)
    {
        $period = NULL;
        if($request->has('period_id')) {
            $period = $request->get('period_id');
        }

        $cobc_period = COBCPeriod::where('period_id', $period)->first();

        $user_participation = UserAnswer::query()
            ->selectRaw('COUNT(DISTINCT trans_cobc_user_answer.user_id) AS count_user')
            ->leftJoin('mst_main_user AS u', 'u.user_id', 'trans_cobc_user_answer.user_id')
            ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_cobc_user_answer.grade_id')
            ->leftJoin('mst_main_user_grade_group AS gg', 'gg.grade_group_id', 'g.grade_group_id')
            ->whereIn('gg.grade_group_id', $this->gg_access)
            ->where('trans_cobc_user_answer.period_id', $period)
            ->where('trans_cobc_user_answer.completed', '1')
            ->whereNull('u.deleted_at')
        ->first();

        $user_all = User::query()
            ->selectRaw('COUNT(mst_main_user.user_id) AS count_user')
            ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'mst_main_user.grade_id')
            ->leftJoin('mst_main_user_grade_group AS gg', 'gg.grade_group_id', 'g.grade_group_id')
            ->whereIn('gg.grade_group_id', $this->gg_access)
            ->whereRaw('DATEDIFF("'.$cobc_period->cobc_period_end.'", mst_main_user.user_join_date) > 180')
        ->first();

        $retraining = User::query()
            ->selectRaw('mst_main_user.user_id,
                IFNULL((SELECT p1.score
                    FROM trans_cobc_user_answer p1
                    WHERE p1.user_id = mst_main_user.user_id
                    AND p1.period_id = '.$period.'
                    AND p1.phase = 1
                    AND p1.completed = "1"
                    GROUP BY p1.answer_id), 0) AS phase_1,
                IFNULL((SELECT p2.score
                    FROM trans_cobc_user_answer p2
                    WHERE p2.user_id = mst_main_user.user_id
                    AND p2.period_id = '.$period.'
                    AND p2.phase = 2
                    AND p2.completed = "1"
                    GROUP BY p2.answer_id), 0) AS phase_2,
                IFNULL((SELECT p3.score
                    FROM trans_cobc_user_answer p3
                    WHERE p3.user_id = mst_main_user.user_id
                    AND p3.period_id = '.$period.'
                    AND p3.phase = 3
                    AND p3.completed = "1"
                    GROUP BY p3.answer_id), 0) AS phase_3')
            ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'mst_main_user.grade_id')
            ->leftJoin('mst_main_user_grade_group AS gg', 'gg.grade_group_id', 'g.grade_group_id')
            ->whereIn('gg.grade_group_id', $this->gg_access)
            ->whereRaw('DATEDIFF("'.$cobc_period->cobc_period_end.'", mst_main_user.user_join_date) > 180')
            ->groupBy('mst_main_user.user_id')
            ->havingRaw('phase_1 < 80 AND phase_3 != 0 AND phase_2 < 80 AND phase_2 != 0 AND phase_3 < 80 AND phase_3 != 0')
        ->get();

        $data = (object) array();
        $data->user_all = $user_all->count_user;
        $data->have_taken = $user_participation->count_user;
        $data->have_taken_percentage = number_format(($user_participation->count_user / $user_all->count_user * 100), 2, '.', ',');
        $data->havent_taken = $user_all->count_user - $user_participation->count_user;
        $data->havent_taken_percentage = number_format((($user_all->count_user - $user_participation->count_user) / $user_all->count_user * 100), 2, '.', ',');
        $data->retraining = count($retraining);
        $data->retraining_percentage = number_format((count($retraining) / $user_all->count_user * 100), 2, '.', ',');

        $department = Departement::all();
        $data->dept = array();
        foreach($department as $key => $d) {
            $data->dept[$key] = (object) array();

            $user_all_dept = User::query()
                ->selectRaw('COUNT(mst_main_user.user_id) AS count_user')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'mst_main_user.grade_id')
                ->leftJoin('mst_main_user_grade_group AS gg', 'gg.grade_group_id', 'g.grade_group_id')
                ->whereIn('gg.grade_group_id', $this->gg_access)
                ->whereRaw('DATEDIFF("'.$cobc_period->cobc_period_end.'", mst_main_user.user_join_date) > 180')
                ->where('mst_main_user.department_id', $d->department_id)
            ->first();

            $user_participation_dept = UserAnswer::query()
                ->selectRaw('COUNT(DISTINCT trans_cobc_user_answer.user_id) AS count_user')
                ->leftJoin('mst_main_user AS u', 'u.user_id', 'trans_cobc_user_answer.user_id')
                ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_cobc_user_answer.grade_id')
                ->leftJoin('mst_main_user_grade_group AS gg', 'gg.grade_group_id', 'g.grade_group_id')
                ->whereIn('gg.grade_group_id', $this->gg_access)
                ->where('trans_cobc_user_answer.period_id', $period)
                ->where('trans_cobc_user_answer.department_id', $d->department_id)
                ->where('trans_cobc_user_answer.completed', '1')
                ->whereNull('u.deleted_at')
            ->first();

            $data->dept[$key]->user_all = $user_all_dept->count_user;
            $data->dept[$key]->have_taken = $user_participation_dept->count_user;
            $data->dept[$key]->have_taken_percentage = number_format(($user_participation_dept->count_user / $user_all_dept->count_user * 100), 2, '.', ',');
            $data->dept[$key]->havent_taken = $user_all_dept->count_user - $user_participation_dept->count_user;
            $data->dept[$key]->havent_taken_percentage = number_format((($user_all_dept->count_user - $user_participation_dept->count_user) / $user_all_dept->count_user * 100), 2, '.', ',');
        }

        return response()->json($data);
    }

    public function passingRate(Request $request)
    {
        $period = NULL;
        if($request->has('period_id')) {
            $period = $request->get('period_id');
        }

        $data = (object) array();

        $department = Departement::all();

        $data->department = Departement::orderBy('department_id')->pluck('department_name')->toArray();
        $data->grade_group = GradeGroup::whereIn('grade_group_id', $this->gg_access)->orderBy('grade_group_id', 'DESC')->pluck('grade_group_name')->toArray();

        $data->passing = array();

        for($i=0; $i<count($data->department); $i++) {
            for($j=0; $j<count($data->grade_group); $j++) {
                $pass = UserAnswer::query()
                    ->selectRaw('IFNULL(COUNT(DISTINCT trans_cobc_user_answer.user_id), 0) AS pass')
                    ->leftJoin('mst_main_user AS u', 'u.user_id', 'trans_cobc_user_answer.user_id')
                    ->leftJoin('mst_main_department AS d', 'd.department_id', 'trans_cobc_user_answer.department_id')
                    ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'trans_cobc_user_answer.grade_id')
                    ->leftJoin('mst_main_user_grade_group AS gg', 'gg.grade_group_id', 'g.grade_group_id')
                    ->whereIn('gg.grade_group_id', $this->gg_access)
                    ->where('trans_cobc_user_answer.period_id', $period)
                    ->where('d.department_name', $data->department[$i])
                    ->where('gg.grade_group_name', $data->grade_group[$j])
                    ->where('trans_cobc_user_answer.score', '>=', 80)
                    ->whereNull('u.deleted_at')
                    ->groupBy('trans_cobc_user_answer.department_id', 'g.grade_group_id')
                ->first();

                if(!empty($pass)) {
                    $data->passing[$i][$j] = $pass->pass;
                } else {
                    $data->passing[$i][$j] = 0;
                }
            }
        }

        return response()->json($data);
    }

    public function topScore(Request $request)
    {
        $period = NULL;
        if($request->has('period_id')) {
            $period = $request->get('period_id');
        }

        $department = Departement::all();

        $data = array();

        foreach($department as $d) {
            $top = UserAnswer::query()
                ->selectRaw('IFNULL(FORMAT(MAX(score), 0), "-") AS top_score')
                ->where('period_id', $period)
                ->where('department_id', $d->department_id)
            ->first();

            $data[$d->department_id] = $top->top_score;
        }

        return response()->json($data);
    }

}
