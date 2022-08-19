<?php

namespace App\Http\Controllers\COBC;

use App\Model\Departement;
use App\Model\User;
use App\Model\COBC\COBCPeriod;
use App\Model\COBC\UserAnswer;
use App\Model\Plugin\PluginPeriod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Exports\COBC\ReportExport;
use Maatwebsite\Excel\Facades\Excel;

use Auth;

class ReportController extends Controller
{
    // GRADE GROUP COBC ACCESS
    protected $gg_access;

    public function __construct()
    {
        $this->gg_access = array(3,4,5,6,7);
    }

    public function index()
    {
        $department = Departement::all();
        $period_all = PluginPeriod::where('period_status', '1')->orderBy('period_name')->get();
        $periodName = date('m') <= 3 ? ((date('Y') - 1).'-'.date('Y')) : (date('Y').'-'.(date('Y') + 1));
        $period = PluginPeriod::where('period_name', $periodName)->first();

        return view('cobc.report', compact('department', 'period_all', 'period'));
    }

    public function reportExport(Request $request)
    {
        $period = NULL;
        if($request->has('period')) {
            $period = $request->get('period');
        }

        $period_name = PluginPeriod::where('period_id', $period)->first()->period_name;

        return Excel::download(new ReportExport($period), 'cobc_report_'.$period_name.'.xlsx');
    }

    public function getReport(Request $request)
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

        $cobc_period = COBCPeriod::where('period_id', $period)->first();

        $report = User::query()
            ->selectRaw('mst_main_user.user_id,
                mst_main_user.user_nik,
                mst_main_user.user_name,
                CONCAT("[", mst_main_user.user_nik, "] ", mst_main_user.user_name) AS user,
                mst_main_user.department_id,
                dept.department_name,
                IFNULL((SELECT FORMAT(p1.score, 0)
                    FROM trans_cobc_user_answer p1
                    WHERE p1.user_id = mst_main_user.user_id
                    AND p1.period_id = '.$period.'
                    AND p1.phase = 1
                    AND p1.completed = "1"
                    GROUP BY p1.answer_id), "-") AS phase_1,
                IFNULL((SELECT p1.score
                    FROM trans_cobc_user_answer p1
                    WHERE p1.user_id = mst_main_user.user_id
                    AND p1.period_id = '.$period.'
                    AND p1.phase = 1
                    AND p1.completed = "1"
                    GROUP BY p1.answer_id), 0) AS phase_1_raw,
                IFNULL((SELECT FORMAT(p2.score, 0)
                    FROM trans_cobc_user_answer p2
                    WHERE p2.user_id = mst_main_user.user_id
                    AND p2.period_id = '.$period.'
                    AND p2.phase = 2
                    AND p2.completed = "1"
                    GROUP BY p2.answer_id), "-") AS phase_2,
                IFNULL((SELECT p2.score
                    FROM trans_cobc_user_answer p2
                    WHERE p2.user_id = mst_main_user.user_id
                    AND p2.period_id = '.$period.'
                    AND p2.phase = 2
                    AND p2.completed = "1"
                    GROUP BY p2.answer_id), 0) AS phase_2_raw,
                IFNULL((SELECT FORMAT(p3.score, 0)
                    FROM trans_cobc_user_answer p3
                    WHERE p3.user_id = mst_main_user.user_id
                    AND p3.period_id = '.$period.'
                    AND p3.phase = 3
                    AND p3.completed = "1"
                    GROUP BY p3.answer_id), "-") AS phase_3,
                IFNULL((SELECT p3.score
                    FROM trans_cobc_user_answer p3
                    WHERE p3.user_id = mst_main_user.user_id
                    AND p3.period_id = '.$period.'
                    AND p3.phase = 3
                    AND p3.completed = "1"
                    GROUP BY p3.answer_id), 0) AS phase_3_raw')
            ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'mst_main_user.department_id')
            ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'mst_main_user.grade_id')
            ->leftJoin('mst_main_user_grade_group AS gg', 'gg.grade_group_id', 'g.grade_group_id')
            ->whereRaw('DATEDIFF("'.$cobc_period->cobc_period_end.'", mst_main_user.user_join_date) > 180')
            ->whereIn('gg.grade_group_id', $this->gg_access);

        if($department > 0) {
            $report = $report->where('mst_main_user.department_id', $department);
        }

        $report = $report->groupBy('mst_main_user.user_id');

        if($status > 0) {
            if($status == 1) {
                $report = $report->havingRaw('phase_1_raw >= 80 OR phase_2_raw >= 80 OR phase_3_raw >= 80');
            } else if($status == 2) {
                $report = $report->havingRaw('phase_1_raw < 80 AND phase_3_raw != 0 AND phase_2_raw < 80 AND phase_2_raw != 0 AND phase_3_raw < 80 AND phase_3_raw != 0');
            } else if($status == 3) {
                $report = $report->havingRaw('phase_1 = "-"');
            } else if($status == 4) {
                $report = $report->havingRaw('phase_1_raw < 80 AND phase_1 != "-" AND phase_2 = "-"');
            } else if($status == 5) {
                $report = $report->havingRaw('phase_1_raw < 80 AND phase_1 != "-" AND phase_2_raw < 80 AND phase_2 != "-" AND phase_3 = "-"');
            }
        }

        $report = $report->orderBy('mst_main_user.user_id')
        ->get();

        return datatables()->of($report)->addIndexColumn()
            ->addColumn('status', function($report) {
                if($report->phase_1 == '-') {
                    return '<span class="tx-gray-600">Haven\'t Taken the Test</span>';
                } else if(((int) $report->phase_1 < 80) && ($report->phase_2 == '-')) {
                    return '<span class="tx-orange">Failed Phase 1, Trying Again</span>';
                } else if(((int) $report->phase_1 < 80) && ((int) $report->phase_2 < 80) && ($report->phase_3 == '-')) {
                    return '<span class="tx-orange">Failed Phase 2, Trying Again</span>';
                } else if(((int) $report->phase_1 < 80) && ((int) $report->phase_2 < 80) && ((int) $report->phase_3 < 80)) {
                    return '<span class="tx-danger">Failed</span>';
                } else {
                    return '<span class="tx-success">Success</span>';
                }

                return 'Status';
            })
            ->addColumn('view', function($report) use ($period) {
                return '<a href="javascript:;" class="btn-view" data-id="'.$report->user_id.'" data-period="'.$period.'" data-name="'.$report->user_name.'" data-nik="'.$report->user_nik.'" data-dept="'.$report->department_name.'" data-p1="'.$report->phase_1.'" data-p2="'.$report->phase_2.'" data-p3="'.$report->phase_3.'" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></a>';
            })
            ->addColumn('export', function($report) {
                return '<a href="javascript:;" class="btn-export" data-id="'.$report->user_id.'" data-period="'.$report->period_id.'" data-toggle="tooltip" title="Export"><i class="far fa-file-pdf"></i></a>';
            })
            ->rawColumns(['status', 'view', 'export'])
        ->toJson();
    }

    public function getReportDetail(Request $request)
    {
        $user = NULL;
        if($request->has('user_id')) {
            $user = $request->get('user_id');
        }

        $period = NULL;
        if($request->has('period_id')) {
            $period = $request->get('period_id');
        }

        $report = UserAnswer::query()
            ->selectRaw('trans_cobc_user_answer.answer_id,
                trans_cobc_user_answer.user_id,
                trans_cobc_user_answer.phase,
                uad.answer_detail_id,
                q.question_text_eng,
                q.question_text_bhs,
                q.question_option_1_eng,
                q.question_option_1_bhs,
                q.question_option_2_eng,
                q.question_option_2_bhs,
                q.question_option_3_eng,
                q.question_option_3_bhs,
                q.question_answer,
                uad.question_user_answer,
                uad.question_check')
            ->leftJoin('trans_cobc_user_answer_detail AS uad', 'uad.answer_id', 'trans_cobc_user_answer.answer_id')
            ->leftJoin('mst_cobc_question AS q', 'q.question_id', 'uad.question_id')
            ->where('trans_cobc_user_answer.user_id', $user)
            ->where('trans_cobc_user_answer.period_id', $period)
            ->where('trans_cobc_user_answer.completed', '1')
            ->orderBy('uad.answer_detail_id')
        ->get();

        return response()->json($report);
    }

}
