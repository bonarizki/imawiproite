<?php

namespace App\Http\Controllers\COBC;

use App\Model\COBC\UserAnswer;
use App\Model\COBC\UserAnswerDetail;
use App\Model\COBC\Question;
use App\Model\Plugin\PluginPeriod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth, DB;

class QuizController extends Controller
{
    public function index()
    {
        return view('cobc.quiz');
    }

    public function saveQuiz(Request $request)
    {
        DB::transaction(function() use ($request) {
            $request->merge([
                'answer_detail_id' => $request->id
            ]);
            $request->request->remove('id');

            \Helper::instance()->log('UPDATE', $request, 'App\Model\COBC\UserAnswerDetail');

            UserAnswerDetail::where('answer_detail_id', $request->answer_detail_id)
                ->update(['question_user_answer' => $request->answer]);
        });

        return response()->json();
    }

    public function submitQuiz(Request $request)
    {
        $data = (object) array();

        DB::transaction(function() use ($request, $data) {
            $answer_check = UserAnswer::query()
                ->selectRaw('trans_cobc_user_answer.answer_id,
                    uad.answer_detail_id,
                    uad.question_user_answer')
                ->leftJoin('trans_cobc_user_answer_detail AS uad', 'uad.answer_id', 'trans_cobc_user_answer.answer_id')
                ->where('trans_cobc_user_answer.answer_id', $request->answer_id)
            ->get();

            $empty = 0;
            foreach($answer_check as $key => $ac) {
                if($ac->question_user_answer == null) {
                    $empty += 1;
                    $answer_detail_id = $key+1;
                    break;
                }
            }

            if($empty > 0) {
                $data->message = 'empty';
                $data->answer_detail_id = $answer_detail_id;
            } else {
                $quiz_result = UserAnswer::query()
                    ->selectRaw('trans_cobc_user_answer.answer_id,
                        uad.answer_detail_id,
                        uad.question_user_answer,
                        q.question_answer')
                    ->leftJoin('trans_cobc_user_answer_detail AS uad', 'uad.answer_id', 'trans_cobc_user_answer.answer_id')
                    ->join('mst_cobc_question AS q', 'q.question_id', 'uad.question_id')
                    ->where('trans_cobc_user_answer.answer_id', $request->answer_id)
                ->get();

                foreach($quiz_result as $q) {
                    if($q->question_user_answer == $q->question_answer) {
                        UserAnswerDetail::where('answer_detail_id', $q->answer_detail_id)
                            ->update(['question_check' => '1']);
                    } else {
                        UserAnswerDetail::where('answer_detail_id', $q->answer_detail_id)
                            ->update(['question_check' => '0']);
                    }
                }

                $answer_true = UserAnswerDetail::query()
                    ->selectRaw('COUNT(answer_detail_id) AS answer_true')
                    ->where('answer_id', $request->answer_id)
                    ->where('question_check', '1')
                    ->groupBy('answer_id')
                ->first();

                $answer_false = 25 - $answer_true->answer_true;

                $score = $answer_true->answer_true / 25 * 100;

                UserAnswer::where('answer_id', $request->answer_id)
                    ->update([
                        'answer_true' => $answer_true->answer_true,
                        'answer_false' => $answer_false,
                        'score' => $score,
                        'completed' => '1'
                    ]);

                $data->message = 'success';
            }
        });

        return response()->json($data);
    }

    public function generateQuestion(Request $request)
    {
        $periodName = date('m') <= 3 ? ((date('Y') - 1).'-'.date('Y')) : (date('Y').'-'.(date('Y') + 1));
        $period = PluginPeriod::where('period_name', $periodName)->first();

        $phase_exist = UserAnswer::where('user_id', Auth::user()->user_id)
            ->where('period_id', $period->period_id)
        ->exists();

        if($phase_exist) {
            $phase = UserAnswer::query()
                ->selectRaw('answer_id, phase, completed, score')
                ->where('user_id', Auth::user()->user_id)
                ->where('period_id', $period->period_id)
                ->orderBy('phase', 'DESC')
            ->first();

            if($phase->completed == '0') {
                $package = $phase->answer_id;
            } else if($phase->completed == '1') {
                if($phase->score <= 80) {
                    if($phase->phase == 3) {
                        return false;
                    } else {
                        $user_answer = new UserAnswer();
                        $user_answer->phase = $phase->phase + 1;
                        $user_answer->completed = '0';
                        $user_answer->user_id = Auth::user()->user_id;
                        $user_answer->period_id = $period->period_id;
                        $user_answer->department_id = Auth::user()->department_id;
                        $user_answer->grade_id = Auth::user()->grade_id;
                        $user_answer->created_by = Auth::user()->user_name;
                        $user_answer->updated_by = Auth::user()->user_name;
                        $user_answer->save();

                        $question_before = UserAnswer::query()
                            ->selectRaw('uad.question_id')
                            ->leftJoin('trans_cobc_user_answer_detail AS uad', 'uad.answer_id', 'trans_cobc_user_answer.answer_id')
                            ->where('user_id', Auth::user()->user_id)
                            ->where('period_id', $period->period_id)
                        ->pluck('question_id')->toArray();
                        $question_all = Question::pluck('question_id')->toArray();
                        shuffle($question_all);

                        $question = array_diff($question_all, $question_before);

                        $phase_now = array_splice($question, 0, 25);

                        foreach($phase_now as $pn) {
                            $answer_detail = new UserAnswerDetail();
                            $answer_detail->answer_id = $user_answer->answer_id;
                            $answer_detail->question_id = $pn;
                            $answer_detail->created_by = Auth::user()->user_name;
                            $answer_detail->updated_by = Auth::user()->user_name;
                            $answer_detail->save();
                        }

                        $package = $user_answer->answer_id;
                    }
                } else {
                    return false;
                }
            }

        } else {
            $user_answer = new UserAnswer();
            $user_answer->phase = 1;
            $user_answer->completed = '0';
            $user_answer->user_id = Auth::user()->user_id;
            $user_answer->period_id = $period->period_id;
            $user_answer->department_id = Auth::user()->department_id;
            $user_answer->grade_id = Auth::user()->grade_id;
            $user_answer->created_by = Auth::user()->user_name;
            $user_answer->updated_by = Auth::user()->user_name;
            $user_answer->save();

            $question = Question::pluck('question_id')->toArray();
            shuffle($question);

            $phase_1 = array_splice($question, 0, 25);

            foreach($phase_1 as $p1) {
                $answer_detail = new UserAnswerDetail();
                $answer_detail->answer_id = $user_answer->answer_id;
                $answer_detail->question_id = $p1;
                $answer_detail->created_by = Auth::user()->user_name;
                $answer_detail->updated_by = Auth::user()->user_name;
                $answer_detail->save();
            }

            $package = $user_answer->answer_id;
        }

        $quiz = UserAnswer::query()
            ->selectRaw('trans_cobc_user_answer.answer_id,
                uad.answer_detail_id,
                uad.question_id,
                uad.question_user_answer,
                q.question_text_eng,
                q.question_option_1_eng,
                q.question_option_2_eng,
                q.question_option_3_eng,
                q.question_text_bhs,
                q.question_option_1_bhs,
                q.question_option_2_bhs,
                q.question_option_3_bhs')
            ->leftJoin('trans_cobc_user_answer_detail AS uad', 'uad.answer_id', 'trans_cobc_user_answer.answer_id')
            ->join('mst_cobc_question AS q', 'q.question_id', 'uad.question_id')
            ->where('trans_cobc_user_answer.answer_id', $package)
        ->get();

        return response()->json($quiz);
    }

}
