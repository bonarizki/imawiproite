<?php

namespace App\Http\Controllers\COBC;

use App\Model\User;
use App\Model\COBC\COBCPeriod;
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
            ->leftJoin('mst_cobc_period AS cp', 'cp.period_id', 'mst_plugin_period.period_id')
            ->whereNull('cp.period_id')
        ->get();

        foreach($period as $p) {
            $period = new COBCPeriod();
            $period->period_id = $p->period_id;
            $period->save();
        }

        return view('cobc.period', compact('period'));
    }

    public function update(Request $request)
    {
        $rules = [
            'cobc_period_start' => 'required',
            'cobc_period_end' => 'required'
        ];

        $message = [
            'cobc_period_start.required' => 'Please Choose A Start Period',
            'cobc_period_end.required' => 'Please Choose An End Period'
        ];

        $this->validate($request, $rules, $message);

        DB::transaction(function() use ($request) {
            $request->merge([
                'cobc_period_id' => $request->id,
                'updated_by' => Auth::user()->user_name
            ]);
            $request->request->remove('id');

            \Helper::instance()->log('UPDATE', $request, 'App\Model\COBC\COBCPeriod');

            $period = COBCPeriod::find($request->cobc_period_id);
            $period->cobc_period_start = $request->cobc_period_start;
            $period->cobc_period_end = $request->cobc_period_end;
            $period->updated_by = Auth::user()->user_name;
            $period->save();
        });

        return response()->json();
    }

    public function getPeriod(Request $request)
    {
    	$period = COBCPeriod::query()
            ->selectRaw('mst_cobc_period.cobc_period_id,
                mst_cobc_period.cobc_period_start,
                mst_cobc_period.cobc_period_end,
                mst_cobc_period.period_id,
                p.period_name')
            ->leftJoin('mst_plugin_period AS p', 'p.period_id', 'mst_cobc_period.period_id')
            ->orderBy('mst_cobc_period.cobc_period_id')
        ->get();

        return datatables()->of($period)->addIndexColumn()
            ->addColumn('edit', function($period) {
                return '<a href="javascript:;" class="btn-edit" data-id="'.$period->cobc_period_id.'" data-start="'.$period->cobc_period_start.'" data-end="'.$period->cobc_period_end.'" data-period="'.$period->period_name.'" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>';
            })
            ->rawColumns(['edit'])
        ->toJson();
    }
    
}
