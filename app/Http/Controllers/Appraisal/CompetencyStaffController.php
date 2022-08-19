<?php

namespace App\Http\Controllers\Appraisal;

use App\Model\Appraisal\CompetencyStaff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth, DB;

class CompetencyStaffController extends Controller
{
    public function index()
    {
        return view('appraisal.master.competency_staff');
    }

    public function store(Request $request)
    {
        $rules = [
            'competency_title_eng' => 'required',
            'competency_title_bhs' => 'required',
            'competency_eng' => 'required',
            'competency_bhs' => 'required',
            'proficiency_1_eng' => 'required',
            'proficiency_1_bhs' => 'required',
            'proficiency_2_eng' => 'required',
            'proficiency_2_bhs' => 'required',
            'proficiency_3_eng' => 'required',
            'proficiency_3_bhs' => 'required',
            'proficiency_4_eng' => 'required',
            'proficiency_4_bhs' => 'required',
        ];

        $message = [
            'competency_title_eng.required' => 'Please Type Competency Title in English',
            'competency_title_bhs.required' => 'Please Type Competency Title in Bahasa',
            'competency_eng.required' => 'Please Type Competency in English',
            'competency_bhs.required' => 'Please Type Competency in Bahasa',
            'proficiency_1_eng.required' => 'Please Type Proficiency Level 1 in English',
            'proficiency_1_bhs.required' => 'Please Type Proficiency Level 1 in Bahasa',
            'proficiency_2_eng.required' => 'Please Type Proficiency Level 2 in English',
            'proficiency_2_bhs.required' => 'Please Type Proficiency Level 2 in Bahasa',
            'proficiency_3_eng.required' => 'Please Type Proficiency Level 3 in English',
            'proficiency_3_bhs.required' => 'Please Type Proficiency Level 3 in Bahasa',
            'proficiency_4_eng.required' => 'Please Type Proficiency Level 4 in English',
            'proficiency_4_bhs.required' => 'Please Type Proficiency Level 4 in Bahasa'
        ];

        $this->validate($request, $rules, $message);

        DB::transaction(function() use ($request) {
            $competency = new CompetencyStaff();
            $competency->competency_title_eng = $request->competency_title_eng;
            $competency->competency_title_bhs = $request->competency_title_bhs;
            $competency->competency_eng = $request->competency_eng;
            $competency->competency_bhs = $request->competency_bhs;
            $competency->proficiency_1_eng = $request->proficiency_1_eng;
            $competency->proficiency_1_bhs = $request->proficiency_1_bhs;
            $competency->proficiency_2_eng = $request->proficiency_2_eng;
            $competency->proficiency_2_bhs = $request->proficiency_2_bhs;
            $competency->proficiency_3_eng = $request->proficiency_3_eng;
            $competency->proficiency_3_bhs = $request->proficiency_3_bhs;
            $competency->proficiency_4_eng = $request->proficiency_4_eng;
            $competency->proficiency_4_bhs = $request->proficiency_4_bhs;
            $competency->created_by = Auth::user()->user_name;
            $competency->updated_by = Auth::user()->user_name;
            $competency->save();

            $request->merge([
                'created_by' => Auth::user()->user_name,
                'updated_by' => Auth::user()->user_name
            ]);

            \Helper::instance()->log('CREATE', $request, 'App\Model\Appraisal\CompetencyStaff');
        });
    }

    public function update(Request $request)
    {
        $rules = [
            'competency_title_eng' => 'required',
            'competency_title_bhs' => 'required',
            'competency_eng' => 'required',
            'competency_bhs' => 'required',
            'proficiency_1_eng' => 'required',
            'proficiency_1_bhs' => 'required',
            'proficiency_2_eng' => 'required',
            'proficiency_2_bhs' => 'required',
            'proficiency_3_eng' => 'required',
            'proficiency_3_bhs' => 'required',
            'proficiency_4_eng' => 'required',
            'proficiency_4_bhs' => 'required',
        ];

        $message = [
            'competency_title_eng.required' => 'Please Type Competency Title in English',
            'competency_title_bhs.required' => 'Please Type Competency Title in Bahasa',
            'competency_eng.required' => 'Please Type Competency in English',
            'competency_bhs.required' => 'Please Type Competency in Bahasa',
            'proficiency_1_eng.required' => 'Please Type Proficiency Level 1 in English',
            'proficiency_1_bhs.required' => 'Please Type Proficiency Level 1 in Bahasa',
            'proficiency_2_eng.required' => 'Please Type Proficiency Level 2 in English',
            'proficiency_2_bhs.required' => 'Please Type Proficiency Level 2 in Bahasa',
            'proficiency_3_eng.required' => 'Please Type Proficiency Level 3 in English',
            'proficiency_3_bhs.required' => 'Please Type Proficiency Level 3 in Bahasa',
            'proficiency_4_eng.required' => 'Please Type Proficiency Level 4 in English',
            'proficiency_4_bhs.required' => 'Please Type Proficiency Level 4 in Bahasa'
        ];

        $this->validate($request, $rules, $message);

        DB::transaction(function() use ($request) {
            $request->merge([
                'competency_staff_id' => $request->id,
                'updated_by' => Auth::user()->user_name
            ]);
            $request->request->remove('id');

            \Helper::instance()->log('UPDATE', $request, 'App\Model\Appraisal\CompetencyStaff');

            $competency = CompetencyStaff::find($request->competency_staff_id);
            $competency->competency_title_eng = $request->competency_title_eng;
            $competency->competency_title_bhs = $request->competency_title_bhs;
            $competency->competency_eng = $request->competency_eng;
            $competency->competency_bhs = $request->competency_bhs;
            $competency->proficiency_1_eng = $request->proficiency_1_eng;
            $competency->proficiency_1_bhs = $request->proficiency_1_bhs;
            $competency->proficiency_2_eng = $request->proficiency_2_eng;
            $competency->proficiency_2_bhs = $request->proficiency_2_bhs;
            $competency->proficiency_3_eng = $request->proficiency_3_eng;
            $competency->proficiency_3_bhs = $request->proficiency_3_bhs;
            $competency->proficiency_4_eng = $request->proficiency_4_eng;
            $competency->proficiency_4_bhs = $request->proficiency_4_bhs;
            $competency->updated_by = Auth::user()->user_name;
            $competency->save();
        });

        return response()->json();
    }

    public function activate(Request $request)
    {
        $data = (object) array();

        DB::transaction(function() use ($request, $data) {
            $request->merge([
                'competency_staff_id' => $request->id,
                'updated_by' => Auth::user()->user_name
            ]);
            $request->request->remove('id');

            \Helper::instance()->log('UPDATE', $request, 'App\Model\Appraisal\CompetencyStaff');

            $competency = CompetencyStaff::find($request->competency_staff_id);
            if($competency->competency_status == '0') {
                $competency->competency_status = '1';

                $data->message = 'activated';
            } else if($competency->competency_status == '1') {
                $competency->competency_status = '0';

                $data->message = 'deactivated';
            }
            $competency->updated_by = Auth::user()->user_name;
            $competency->save();
        });

        return response()->json($data);
    }

    public function getCompetencyStaff(Request $request)
    {
    	$lang = NULL;
        if($request->has('lang')) {
            $lang = $request->get('lang');
        }

        $competency_id = NULL;
        if($request->has('competency_id')) {
            $competency_id = $request->get('competency_id');
        }

        if($competency_id != NULL) {
            $competency = CompetencyStaff::find($competency_id);

            return response()->json($competency);
        } else {
            $competency = CompetencyStaff::all();

            return datatables()->of($competency)->addIndexColumn()
                ->addColumn('competency_text', function($competency) use ($lang) {
                    if($lang == 'eng') {
                        return '<b>'.$competency->competency_title_eng.'</b><br>'.str_replace("\n", '<br>', $competency->competency_eng);
                    } else if($lang == 'ina') {
                        return '<b>'.$competency->competency_title_bhs.'</b><br>'.str_replace("\n", '<br>', $competency->competency_bhs);
                    }
                })
                ->addColumn('proficiency_1', function($competency) use ($lang) {
                    return str_replace("\n", '<br>', ($lang == 'eng' ? $competency->proficiency_1_eng : $competency->proficiency_1_bhs));
                })
                ->addColumn('proficiency_2', function($competency) use ($lang) {
                    return str_replace("\n", '<br>', ($lang == 'eng' ? $competency->proficiency_2_eng : $competency->proficiency_2_bhs));
                })
                ->addColumn('proficiency_3', function($competency) use ($lang) {
                    return str_replace("\n", '<br>', ($lang == 'eng' ? $competency->proficiency_3_eng : $competency->proficiency_3_bhs));
                })
                ->addColumn('proficiency_4', function($competency) use ($lang) {
                    return str_replace("\n", '<br>', ($lang == 'eng' ? $competency->proficiency_4_eng : $competency->proficiency_4_bhs));
                })
                ->addColumn('edit', function($competency) {
                    return '<a href="javascript:;" class="btn-edit" data-id="'.$competency->competency_staff_id.'" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>';
                })
                ->addColumn('status', function($competency) {
                    return '<a href="javascript:;" class="btn-activate" data-id="'.$competency->competency_staff_id.'" data-message="'.($competency->competency_status == '1' ? 'Deactivate' : 'Activate').'" data-toggle="tooltip" title="'.($competency->competency_status == '1' ? 'Deactivate' : 'Activate').'"><i class="fa fa-'.($competency->competency_status == '1' ? 'times' : 'check').'"></i></a>';
                })
                ->rawColumns(['competency_text', 'edit', 'status'])
            ->toJson();
        }
    }
    
}
