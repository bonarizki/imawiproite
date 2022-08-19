<?php

namespace App\Http\Controllers\Appraisal;

use App\Model\Departement;
use App\Model\GradeGroup;
use App\Model\Appraisal\Competency;
use App\Model\Appraisal\CompetencyTemp;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Imports\Appraisal\CompetencyImport;
use Maatwebsite\Excel\Facades\Excel;

use Auth, DB;

class CompetencyController extends Controller
{
    public function index()
    {
        $department = Departement::all();
        $grade_group = GradeGroup::all();

        return view('appraisal.master.competency', compact('department', 'grade_group'));
    }

    public function store(Request $request)
    {
        $rules = [
            'department_id' => 'required',
            'grade_group_id' => 'required',
            'competency_eng' => 'required',
            'competency_bhs' => 'required'
        ];

        $message = [
            'department_id.required' => 'Please Select A Department',
            'grade_group_id.required' => 'Please Select A Level',
            'competency_eng.required' => 'Please Type Competency in English',
            'competency_bhs.required' => 'Please Type Competency in Bahasa'
        ];

        $this->validate($request, $rules, $message);

        DB::transaction(function() use ($request) {
            $competency = new Competency();
            $competency->department_id = $request->department_id;
            $competency->grade_group_id = $request->grade_group_id;
            $competency->competency_eng = $request->competency_eng;
            $competency->competency_bhs = $request->competency_bhs;
            $competency->created_by = Auth::user()->user_name;
            $competency->updated_by = Auth::user()->user_name;
            $competency->save();

            $request->merge([
                'created_by' => Auth::user()->user_name,
                'updated_by' => Auth::user()->user_name
            ]);

            \Helper::instance()->log('CREATE', $request, 'App\Model\Appraisal\Competency');
        });
    }

    public function update(Request $request)
    {
        $rules = [
            'department_id' => 'required',
            'grade_group_id' => 'required',
            'competency_eng' => 'required',
            'competency_bhs' => 'required'
        ];

        $message = [
            'department_id.required' => 'Please Select A Department',
            'grade_group_id.required' => 'Please Select A Level',
            'competency_eng.required' => 'Please Type Competency in English',
            'competency_bhs.required' => 'Please Type Competency in Bahasa'
        ];

        $this->validate($request, $rules, $message);

        DB::transaction(function() use ($request) {
            $request->merge([
                'competency_id' => $request->id,
                'updated_by' => Auth::user()->user_name
            ]);
            $request->request->remove('id');

            \Helper::instance()->log('UPDATE', $request, 'App\Model\Appraisal\Competency');

            $competency = Competency::find($request->competency_id);
            $competency->department_id = $request->department_id;
            $competency->grade_group_id = $request->grade_group_id;
            $competency->competency_eng = $request->competency_eng;
            $competency->competency_bhs = $request->competency_bhs;
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
                'competency_id' => $request->id,
                'updated_by' => Auth::user()->user_name
            ]);
            $request->request->remove('id');

            \Helper::instance()->log('UPDATE', $request, 'App\Model\Appraisal\Competency');

            $competency = Competency::find($request->competency_id);
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

    public function tempUpload(Request $request)
    {
        $import = new CompetencyImport();
        $import->import($request->file('filepond'));

        $message_arr = array();

        if($import->failures()) {
            foreach($import->failures() as $failure) {
                $error = 'Error on row '.$failure->row().' : '.implode(', ', $failure->errors());

                array_push($message_arr, $error);
            }
        }

        $message = implode('#', $message_arr);

        return response()->json($message);
    }

    public function resetCompetencyTemp()
    {
        CompetencyTemp::where('user_id', Auth::user()->user_id)->delete();

        return response()->json();
    }

    public function submitCompetency(Request $request)
    {
        $message = array();

        $competency_temp = CompetencyTemp::where('user_id', Auth::user()->user_id)->get();

        foreach($competency_temp as $ct) {
            $department = Departement::where('department_name', $ct->department)->first();
            $grade_group = GradeGroup::where('grade_group_name', $ct->level)->first();

            $competency = new Competency();
            $competency->competency_eng = $ct->competency_eng;
            $competency->competency_bhs = $ct->competency_bhs;
            $competency->competency_status = '1';
            $competency->department_id = $department->department_id;
            $competency->grade_group_id = $grade_group->grade_group_id;
            $competency->created_by = Auth::user()->user_name;
            $competency->updated_by = Auth::user()->user_name;
            $competency->save();

            CompetencyTemp::where('id', $ct->id)->delete();
        }

        return response()->json();
    }

    public function getCompetency(Request $request)
    {
    	$lang = NULL;
        if($request->has('lang')) {
            $lang = $request->get('lang');
        }

        $department = NULL;
        if($request->has('department_id')) {
            $department = $request->get('department_id');
        }

        $grade_group = NULL;
        if($request->has('grade_group_id')) {
            $grade_group = $request->get('grade_group_id');
        }

        $competency = Competency::query()
            ->selectRaw('mst_appraisal_competency.competency_id,
                mst_appraisal_competency.competency_eng,
                mst_appraisal_competency.competency_bhs,
                mst_appraisal_competency.competency_status,
                mst_appraisal_competency.department_id,
                dept.department_name,
                mst_appraisal_competency.grade_group_id,
                gg.grade_group_name')
            ->join('mst_main_department AS dept', 'dept.department_id', 'mst_appraisal_competency.department_id')
            ->join('mst_main_user_grade_group AS gg', 'gg.grade_group_id', 'mst_appraisal_competency.grade_group_id');

        if($department > 0) {
            $competency = $competency->where('mst_appraisal_competency.department_id', $department);
        }

        if($grade_group > 0) {
            $competency = $competency->where('mst_appraisal_competency.grade_group_id', $grade_group);
        }

        $competency = $competency->orderBy('mst_appraisal_competency.department_id')
            ->orderBy('mst_appraisal_competency.grade_group_id')
        ->get();

        return datatables()->of($competency)->addIndexColumn()
            ->addColumn('competency_text', function($competency) use ($lang) {
                if($lang == 'eng') {
                    return str_replace("\n", '<br>', $competency->competency_eng);
                } else if($lang == 'ina') {
                    return str_replace("\n", '<br>', $competency->competency_bhs);
                }
            })
            ->addColumn('edit', function($competency) {
                return '<a href="javascript:;" class="btn-edit" data-id="'.$competency->competency_id.'" data-eng="'.$competency->competency_eng.'" data-bhs="'.$competency->competency_bhs.'" data-dept="'.$competency->department_id.'" data-gg="'.$competency->grade_group_id.'" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>';
            })
            ->addColumn('status', function($competency) {
                return '<a href="javascript:;" class="btn-activate" data-id="'.$competency->competency_id.'" data-message="'.($competency->competency_status == '1' ? 'Deactivate' : 'Activate').'" data-toggle="tooltip" title="'.($competency->competency_status == '1' ? 'Deactivate' : 'Activate').'"><i class="fa fa-'.($competency->competency_status == '1' ? 'times' : 'check').'"></i></a>';
            })
            ->rawColumns(['competency_text', 'edit', 'status'])
        ->toJson();
    }

    public function getCompetencyTemp(Request $request)
    {
        $competency = CompetencyTemp::where('user_id', Auth::user()->user_id)->get();

        return datatables()->of($competency)->addIndexColumn()->toJson();
    }
    
}
