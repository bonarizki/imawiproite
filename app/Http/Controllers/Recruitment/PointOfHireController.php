<?php

namespace App\Http\Controllers\Recruitment;

use App\Model\Recruitment\PointOfHire;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth, DB;

class PointOfHireController extends Controller
{
    public function index()
    {
        return view('recruitment.point_of_hire');
    }

    public function store(Request $request)
    {
        $rules = [
            'point_of_hire_name' => 'required'
        ];

        $message = [
            'point_of_hire_name.required' => 'Please Fill Point of Hire'
        ];

        $this->validate($request, $rules, $message);

        DB::transaction(function() use ($request) {
            $request->merge([
                'created_by' => Auth::user()->user_name,
                'updated_by' => Auth::user()->user_name
            ]);

            \Helper::instance()->log('CREATE', $request, 'App\Model\Recruitment\PointOfHire');

            $poh = new PointOfHire();
            $poh->point_of_hire_name = $request->point_of_hire_name;
            $poh->created_by = Auth::user()->user_name;
            $poh->updated_by = Auth::user()->user_name;
            $poh->save();
        });

        return response()->json();
    }

    public function update(Request $request)
    {
        $rules = [
            'point_of_hire_name' => 'required'
        ];

        $message = [
            'point_of_hire_name.required' => 'Please Fill Point of Hire'
        ];

        $this->validate($request, $rules, $message);

        DB::transaction(function() use ($request) {
            $request->merge([
                'point_of_hire_id' => $request->id,
                'updated_by' => Auth::user()->user_name
            ]);
            $request->request->remove('id');

            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\PointOfHire');

            $poh = PointOfHire::find($request->point_of_hire_id);
            $poh->point_of_hire_name = $request->point_of_hire_name;
            $poh->updated_by = Auth::user()->user_name;
            $poh->save();
        });

        return response()->json();
    }

    public function delete(Request $request)
    {
        DB::transaction(function() use ($request) {
            $request->merge([
                'point_of_hire_id' => $request->id
            ]);
            $request->request->remove('id');

            \Helper::instance()->log('DELETE', $request, 'App\Model\Recruitment\PointOfHire');

            PointOfHire::find($request->point_of_hire_id)->delete();
        });

        return response()->json();
    }

    public function getPoH(Request $request)
    {
    	$poh = PointOfHire::orderBy('point_of_hire_name')->get();

        return datatables()->of($poh)->addIndexColumn()
            ->addColumn('edit', function($poh) {
                return '<a href="javascript:;" class="btn-edit" data-id="'.$poh->point_of_hire_id.'" data-name="'.$poh->point_of_hire_name.'" data-toggle="tooltip" title="Edit"><i class="feather icon-edit"></i></a>';
            })
            ->addColumn('delete', function($poh) {
                return '<a href="javascript:;" class="btn-delete" data-id="'.$poh->point_of_hire_id.'" data-name="'.$poh->point_of_hire_name.'" data-toggle="tooltip" title="Delete"><i class="feather icon-trash"></i></a>';
            })
            ->rawColumns(['edit', 'delete'])
        ->toJson();
    }
    
}
