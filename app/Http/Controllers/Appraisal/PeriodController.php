<?php

namespace App\Http\Controllers\Appraisal;

use App\Model\User;
use App\Model\Appraisal\AppraisalPeriod;
use App\Model\Plugin\PluginPeriod;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth, DB;

class PeriodController extends Controller
{
    public function index()
    {
        $period = PluginPeriod::query()
            ->selectRaw('mst_plugin_period.period_id')
            ->leftJoin('mst_appraisal_period AS ap', 'ap.period_id', 'mst_plugin_period.period_id')
            ->whereNull('ap.period_id')
        ->get();

        foreach($period as $p) {
            $period = new AppraisalPeriod();
            $period->period_id = $p->period_id;
            $period->save();
        }

        return view('appraisal.master.period', compact('period'));
    }

    public function update(Request $request)
    {
        $rules = [
            'appraisal_staff_period_start' => 'required',
            'appraisal_staff_period_end' => 'required',
            'appraisal_period_start' => 'required',
            'appraisal_period_end' => 'required'
        ];

        $message = [
            'appraisal_staff_period_start.required' => 'Please Choose A Start Period',
            'appraisal_staff_period_end.required' => 'Please Choose An End Period',
            'appraisal_period_start.required' => 'Please Choose A Start Period',
            'appraisal_period_end.required' => 'Please Choose An End Period'
        ];

        $this->validate($request, $rules, $message);

        DB::transaction(function() use ($request) {
            $request->merge([
                'appraisal_period_id' => $request->id,
                'updated_by' => Auth::user()->user_name
            ]);
            $request->request->remove('id');

            \Helper::instance()->log('UPDATE', $request, 'App\Model\Appraisal\AppraisalPeriod');

            $period = AppraisalPeriod::find($request->appraisal_period_id);
            $period->appraisal_period_start = $request->appraisal_period_start;
            $period->appraisal_period_end = $request->appraisal_period_end;
            $period->appraisal_staff_period_start = $request->appraisal_staff_period_start;
            $period->appraisal_staff_period_end = $request->appraisal_staff_period_end;
            $period->updated_by = Auth::user()->user_name;
            $period->save();
        });

        return response()->json();
    }

    public function getPeriod(Request $request)
    {
    	$period = AppraisalPeriod::query()
            ->selectRaw('mst_appraisal_period.appraisal_period_id,
                mst_appraisal_period.appraisal_period_start,
                mst_appraisal_period.appraisal_period_end,
                CONCAT(DATE_FORMAT(mst_appraisal_period.appraisal_period_start, "%e %b %Y"), " - ", DATE_FORMAT(mst_appraisal_period.appraisal_period_end, "%e %b %Y")) AS appraisal_period,
                mst_appraisal_period.appraisal_staff_period_start,
                mst_appraisal_period.appraisal_staff_period_end,
                CONCAT(DATE_FORMAT(mst_appraisal_period.appraisal_staff_period_start, "%e %b %Y"), " - ", DATE_FORMAT(mst_appraisal_period.appraisal_staff_period_end, "%e %b %Y")) AS appraisal_staff_period,
                mst_appraisal_period.period_id,
                p.period_name')
            ->leftJoin('mst_plugin_period AS p', 'p.period_id', 'mst_appraisal_period.period_id')
            ->orderBy('mst_appraisal_period.appraisal_period_id')
        ->get();

        return datatables()->of($period)->addIndexColumn()
            ->addColumn('edit', function($period) {
                return '<a href="javascript:;" class="btn-edit" data-id="'.$period->appraisal_period_id.'" data-start="'.$period->appraisal_period_start.'" data-end="'.$period->appraisal_period_end.'" data-staff_start="'.$period->appraisal_staff_period_start.'" data-staff_end="'.$period->appraisal_staff_period_end.'" data-period="'.$period->period_name.'" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>';
            })
            ->rawColumns(['edit'])
        ->toJson();
    }
    
}
