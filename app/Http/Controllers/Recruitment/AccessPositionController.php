<?php

namespace App\Http\Controllers\Recruitment;

use App\Model\Departement;
use App\Model\Recruitment\AccessPosition;
use App\Model\Recruitment\MenuParent;
use App\Model\Recruitment\MenuChild;
use App\Model\Recruitment\MenuGrandChild;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth, DB;

class AccessPositionController extends Controller
{
    public function index()
    {
        $department = Departement::all();

        $parent = MenuParent::all();
        $child = MenuChild::all();
        $grand_child = MenuGrandChild::all();

        return view('recruitment.access_position', compact('department', 'parent', 'child', 'grand_child'));
    }

    public function store(Request $request)
    {
        $rules = [
            'department_id' => 'required|unique:mst_recruitment_access_position,department_id'
        ];

        $message = [
            'department_id.required' => 'Please Select A Departement',
            'department_id.unique' => 'This Departement already have access'
        ];

        $this->validate($request, $rules, $message);

        $parent = '';
        if($request->menu_parent) {
            $parent = implode(',', $request->menu_parent);
        }

        $child = '';
        if($request->menu_child) {
            $child = implode(',', $request->menu_child);
        }

        $grand_child = '';
        if($request->menu_grand_child) {
            $grand_child = implode(',', $request->menu_grand_child);
        }

        $module = $parent.'#'.$child.'#'.$grand_child;

        DB::transaction(function() use ($request, $module) {
            $request->merge([
                'created_by' => Auth::user()->user_name,
                'updated_by' => Auth::user()->user_name
            ]);

            \Helper::instance()->log('CREATE', $request, 'App\Model\Recruitment\AccessPosition');

            $access = new AccessPosition();
            $access->department_id = $request->department_id;
            $access->menu = $module;
            $access->created_by = Auth::user()->user_name;
            $access->updated_by = Auth::user()->user_name;
            $access->save();
        });

        return response()->json();
    }

    public function update(Request $request)
    {
        $parent = '';
        if($request->menu_parent) {
            $parent = implode(',', $request->menu_parent);
        }

        $child = '';
        if($request->menu_child) {
            $child = implode(',', $request->menu_child);
        }

        $grand_child = '';
        if($request->menu_grand_child) {
            $grand_child = implode(',', $request->menu_grand_child);
        }

        $module = $parent.'#'.$child.'#'.$grand_child;

        DB::transaction(function() use ($request, $module) {
            $request->merge([
                'access_position_id' => $request->id,
                'updated_by' => Auth::user()->user_name
            ]);
            $request->request->remove('id');

            \Helper::instance()->log('UPDATE', $request, 'App\Model\Recruitment\AccessPosition');

            $access = AccessPosition::find($request->access_position_id);
            $access->menu = $module;
            $access->updated_by = Auth::user()->user_name;
            $access->save();
        });

        return response()->json();
    }

    public function getAccessPosition(Request $request)
    {
    	$access = AccessPosition::query()
            ->selectRaw('mst_recruitment_access_position.access_position_id,
                mst_recruitment_access_position.department_id,
                dept.department_name,
                mst_recruitment_access_position.menu')
            ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'mst_recruitment_access_position.department_id')
            ->orderBy('dept.department_id')
        ->get();

        return datatables()->of($access)->addIndexColumn()
            ->addColumn('view', function($access) {
                return '<a href="javascript:;" class="btn-view" data-dept="'.$access->department_name.'" data-mod="'.$access->menu.'" data-toggle="tooltip" title="View"><i class="feather icon-eye"></i></a>';
            })
            ->addColumn('edit', function($access) {
                return '<a href="javascript:;" class="btn-edit" data-id="'.$access->access_position_id.'" data-dept_id="'.$access->department_id.'" data-dept="'.$access->department_name.'" data-mod="'.$access->menu.'" data-toggle="tooltip" title="Edit"><i class="feather icon-edit"></i></a>';
            })
            ->rawColumns(['view', 'edit'])
        ->toJson();
    }
    
}
