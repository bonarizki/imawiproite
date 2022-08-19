<?php

namespace App\Http\Controllers\COBC;

use App\Model\COBC\Question;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth, DB;

class QuestionController extends Controller
{
    public function index()
    {
        return view('cobc.question');
    }

    public function store(Request $request)
    {
    	$rules = [
    		'question_text_eng' => 'required',
            'question_text_bhs' => 'required',
            'question_option_1_eng' => 'required',
            'question_option_1_bhs' => 'required',
            'question_option_2_eng' => 'required',
            'question_option_2_bhs' => 'required',
            'question_option_3_eng' => 'required',
            'question_option_3_bhs' => 'required',
            'question_answer' => 'required'
    	];

    	$message = [
    		'question_text_eng.required' => 'Please Fill Question',
            'question_text_bhs.required' => 'Isi Pertanyaan',
            'question_option_1_eng.required' => 'Please Fill Option 1',
            'question_option_1_bhs.required' => 'Isi Pilihan 1',
            'question_option_2_eng.required' => 'Please Fill Option 2',
            'question_option_2_bhs.required' => 'Isi Pilihan 2',
            'question_option_3_eng.required' => 'Please Fill Option 3',
            'question_option_3_bhs.required' => 'Isi Pilihan 3',
            'question_answer.required' => 'Please Select An Answer'
    	];

    	$this->validate($request, $rules, $message);

    	DB::transaction(function() use ($request) {
            $request->merge([
                'created_by' => Auth::user()->user_name,
                'updated_by' => Auth::user()->user_name
            ]);

            \Helper::instance()->log('CREATE', $request, 'App\Model\COBC\Question');

            $question = new Question();
            $question->question_text_eng = $request->question_text_eng;
            $question->question_text_bhs = $request->question_text_bhs;
            $question->question_option_1_eng = $request->question_option_1_eng;
            $question->question_option_1_bhs = $request->question_option_1_bhs;
            $question->question_option_2_eng = $request->question_option_2_eng;
            $question->question_option_2_bhs = $request->question_option_2_bhs;
            $question->question_option_3_eng = $request->question_option_3_eng;
            $question->question_option_3_bhs = $request->question_option_3_bhs;
            $question->question_answer = $request->question_answer;
            $question->created_by = Auth::user()->user_name;
            $question->updated_by = Auth::user()->user_name;
            $question->save();
        });

    	return response()->json();
    }

    public function update(Request $request)
    {
    	$rules = [
            'question_text_eng' => 'required',
            'question_text_bhs' => 'required',
            'question_option_1_eng' => 'required',
            'question_option_1_bhs' => 'required',
            'question_option_2_eng' => 'required',
            'question_option_2_bhs' => 'required',
            'question_option_3_eng' => 'required',
            'question_option_3_bhs' => 'required',
            'question_answer' => 'required'
        ];

        $message = [
            'question_text_eng.required' => 'Please Fill Question',
            'question_text_bhs.required' => 'Isi Pertanyaan',
            'question_option_1_eng.required' => 'Please Fill Option 1',
            'question_option_1_bhs.required' => 'Isi Pilihan 1',
            'question_option_2_eng.required' => 'Please Fill Option 2',
            'question_option_2_bhs.required' => 'Isi Pilihan 2',
            'question_option_3_eng.required' => 'Please Fill Option 3',
            'question_option_3_bhs.required' => 'Isi Pilihan 3',
            'question_answer.required' => 'Please Select An Answer'
        ];

        $this->validate($request, $rules, $message);

        DB::transaction(function() use ($request) {
            $request->merge([
                'question_id' => $request->id,
                'updated_by' => Auth::user()->user_name
            ]);
            $request->request->remove('id');

            \Helper::instance()->log('UPDATE', $request, 'App\Model\COBC\Question');

            $question = Question::find($request->question_id);
            $question->question_text_eng = $request->question_text_eng;
            $question->question_text_bhs = $request->question_text_bhs;
            $question->question_option_1_eng = $request->question_option_1_eng;
            $question->question_option_1_bhs = $request->question_option_1_bhs;
            $question->question_option_2_eng = $request->question_option_2_eng;
            $question->question_option_2_bhs = $request->question_option_2_bhs;
            $question->question_option_3_eng = $request->question_option_3_eng;
            $question->question_option_3_bhs = $request->question_option_3_bhs;
            $question->question_answer = $request->question_answer;
            $question->updated_by = Auth::user()->user_name;
            $question->save();
        });

        return response()->json();
    }

    public function delete(Request $request)
    {
        DB::transaction(function() use ($request) {
            $request->merge([
                'question_id' => $request->id
            ]);
            $request->request->remove('id');

            \Helper::instance()->log('DELETE', $request, 'App\Model\COBC\Question');

            Question::find($request->question_id)->delete();
        });

        return response()->json();
    }

    public function getQuestion(Request $request)
    {
    	$lang = NULL;
        if($request->has('lang')) {
            $lang = $request->get('lang');
        }

        $question = Question::query();

        if($lang == 'eng') {
            $question = $question->selectRaw('question_id,
                question_text_eng AS question_text,
                question_option_1_eng AS question_option_1,
                question_option_2_eng AS question_option_2,
                question_option_3_eng AS question_option_3,
                question_answer');
        } else if($lang == 'ina') {
            $question = $question->selectRaw('question_id,
                question_text_bhs AS question_text,
                question_option_1_bhs AS question_option_1,
                question_option_2_bhs AS question_option_2,
                question_option_3_bhs AS question_option_3,
                question_answer');
        }

        $question = $question->get();

    	return datatables()->of($question)->addIndexColumn()
    		->addColumn('edit', function($question) {
    			return '<a href="javascript:;" class="btn-edit" data-id="'.$question->question_id.'" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>';
    		})
            ->addColumn('delete', function($question) {
                return '<a href="javascript:;" class="btn-delete" data-id="'.$question->question_id.'" data-toggle="tooltip" title="Delete"><i class="fa fa-trash"></i></a>';
            })
    		->rawColumns(['edit', 'delete'])
    	->toJson();
    }

    public function getQuestionById(Request $request)
    {
        $question = Question::where('question_id', $request->id)->first();

        return response()->json($question);
    }
    
}
