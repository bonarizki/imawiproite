<?php

namespace App\Http\Controllers\Recruitment;

use App\Model\GradeGroup;
use App\Model\User;
use App\Model\Recruitment\StandardLeadTime;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth, DB;

class LeadTimeController extends Controller
{
    public function index()
    {
        return view('recruitment.standard_lead_time');
    }

    public function update(Request $request)
    {
        $rules = [
            'standard_lead_time' => 'required'
        ];

        $message = [
            'standard_lead_time.required' => 'Please Fill Standard Lead Time'
        ];

        $this->validate($request, $rules, $message);

        DB::transaction(function() use ($request) {
            $request->merge([
                'standard_lead_time_id' => $request->id,
                'updated_by' => Auth::user()->user_name
            ]);
            $request->request->remove('id');

            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\StandardLeadTime');

            $leadtime = StandardLeadTime::find($request->standard_lead_time_id);
            $leadtime->standard_lead_time = $request->standard_lead_time;
            $leadtime->updated_by = Auth::user()->user_name;
            $leadtime->save();
        });

        return response()->json();
    }

    public function getLeadTime(Request $request)
    {
    	$leadtime = StandardLeadTime::query()
            ->selectRaw('mst_recruitment_standard_lead_time.standard_lead_time_id,
                mst_recruitment_standard_lead_time.grade_group_id,
                gg.grade_group_name,
                mst_recruitment_standard_lead_time.standard_lead_time')
            ->leftJoin('mst_main_user_grade_group AS gg', 'gg.grade_group_id', 'mst_recruitment_standard_lead_time.grade_group_id')
            ->orderBy('gg.grade_group_id')
        ->get();

        return datatables()->of($leadtime)->addIndexColumn()
            ->addColumn('edit', function($leadtime) {
                return '<a href="javascript:;" class="btn-edit" data-id="'.$leadtime->standard_lead_time_id.'" data-grade_group="'.$leadtime->grade_group_name.'" data-leadtime="'.$leadtime->standard_lead_time.'" data-toggle="tooltip" title="Edit"><i class="feather icon-edit"></i></a>';
            })
            ->rawColumns(['edit'])
        ->toJson();
    }
    
}
