<?php

namespace App\Http\Controllers\Appraisal;

use App\Model\Appraisal\Milestone;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth, DB;

class MilestoneController extends Controller
{
    public function index()
    {
        return view('appraisal.master.milestone');
    }

    public function store(Request $request)
    {
        $rules = [
            'milestone_eng' => 'required',
            'milestone_bhs' => 'required'
        ];

        $message = [
            'milestone_eng.required' => 'Please Type Milestone in English',
            'milestone_bhs.required' => 'Please Type Milestone in Bahasa'
        ];

        $this->validate($request, $rules, $message);

        DB::transaction(function() use ($request) {
            $milestone = new Milestone();
            $milestone->milestone_eng = $request->milestone_eng;
            $milestone->milestone_bhs = $request->milestone_bhs;
            $milestone->milestone_status = '1';
            $milestone->created_by = Auth::user()->user_name;
            $milestone->updated_by = Auth::user()->user_name;
            $milestone->save();

            $request->merge([
                'created_by' => Auth::user()->user_name,
                'updated_by' => Auth::user()->user_name
            ]);

            \Helper::instance()->log('CREATE', $request, 'App\Model\Appraisal\Milestone');
        });
    }

    public function update(Request $request)
    {
        $rules = [
            'milestone_eng' => 'required',
            'milestone_bhs' => 'required'
        ];

        $message = [
            'milestone_eng.required' => 'Please Type Milestone in English',
            'milestone_bhs.required' => 'Please Type Milestone in Bahasa'
        ];

        $this->validate($request, $rules, $message);

        DB::transaction(function() use ($request) {
            $request->merge([
                'milestone_id' => $request->id,
                'updated_by' => Auth::user()->user_name
            ]);
            $request->request->remove('id');

            \Helper::instance()->log('UPDATE', $request, 'App\Model\Appraisal\Milestone');

            $milestone = Milestone::find($request->milestone_id);
            $milestone->milestone_eng = $request->milestone_eng;
            $milestone->milestone_bhs = $request->milestone_bhs;
            $milestone->updated_by = Auth::user()->user_name;
            $milestone->save();
        });

        return response()->json();
    }

    public function activate(Request $request)
    {
        $data = (object) array();

        DB::transaction(function() use ($request, $data) {
            $request->merge([
                'milestone_id' => $request->id,
                'updated_by' => Auth::user()->user_name
            ]);
            $request->request->remove('id');

            \Helper::instance()->log('UPDATE', $request, 'App\Model\Appraisal\Milestone');

            $milestone = Milestone::find($request->milestone_id);
            if($milestone->milestone_status == '0') {
                $milestone->milestone_status = '1';

                $data->message = 'activated';
            } else if($milestone->milestone_status == '1') {
                $milestone->milestone_status = '0';

                $data->message = 'deactivated';
            }
            $milestone->updated_by = Auth::user()->user_name;
            $milestone->save();
        });

        return response()->json($data);
    }

    public function getMilestone(Request $request)
    {
    	$lang = 'eng';
        if($request->has('lang')) {
            $lang = $request->get('lang');
        }

        $milestone = Milestone::query();

        if($lang == 'eng') {
            $milestone = $milestone->selectRaw('milestone_id,
                milestone_eng AS milestone_name,
                milestone_eng,
                milestone_bhs,
                milestone_status');
        } else if($lang == 'ina') {
            $milestone = $milestone->selectRaw('milestone_id,
                milestone_bhs AS milestone_name,
                milestone_eng,
                milestone_bhs,
                milestone_status');
        }

        $milestone = $milestone->get();

        return datatables()->of($milestone)->addIndexColumn()
            ->addColumn('edit', function($milestone) {
                return '<a href="javascript:;" class="btn-edit" data-id="'.$milestone->milestone_id.'" data-eng="'.$milestone->milestone_eng.'" data-bhs="'.$milestone->milestone_bhs.'" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>';
            })
            ->addColumn('status', function($milestone) {
                return '<a href="javascript:;" class="btn-activate" data-id="'.$milestone->milestone_id.'" data-name="'.$milestone->milestone_eng.'" data-message="'.($milestone->milestone_status == '1' ? 'Deactivate' : 'Activate').'" data-toggle="tooltip" title="'.($milestone->milestone_status == '1' ? 'Deactivate' : 'Activate').'"><i class="fa fa-'.($milestone->milestone_status == '1' ? 'times' : 'check').'"></i></a>';
            })
            ->rawColumns(['edit', 'status'])
        ->toJson();
    }
    
}
