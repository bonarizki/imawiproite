<?php

namespace App\Http\Controllers\COBC;

use App\Model\User;
use App\Model\COBC\Access;
use App\Model\COBC\MenuParent;
use App\Model\COBC\MenuChild;
use App\Model\COBC\MenuGrandChild;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Auth, DB;

class AccessController extends Controller
{
    public function index()
    {
        $parent = MenuParent::all();
        $child = MenuChild::all();
        $grand_child = MenuGrandChild::all();

        return view('cobc.access', compact('parent', 'child', 'grand_child'));
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

        $menu = $parent.'#'.$child.'#'.$grand_child;

        DB::transaction(function() use ($request, $menu) {
            $request->merge([
                'access_id' => $request->id,
                'updated_by' => Auth::user()->user_name
            ]);
            $request->request->remove('id');

            \Helper::instance()->log('UPDATE', $request, 'App\Model\COBC\Access');

            $access = Access::find($request->access_id);
            $access->menu = $menu;
            $access->updated_by = Auth::user()->updated_by;
            $access->save();
        });

        return response()->json();
    }

    public function getAccess(Request $request)
    {
    	$access = Access::query()
            ->selectRaw('mst_cobc_access.access_id,
                mst_cobc_access.user_id,
                CONCAT("[", user.user_nik, "] - ", user.user_name) AS user,
                dept.department_name,
                mst_cobc_access.menu')
            ->join('mst_main_user AS user', 'user.user_id', 'mst_cobc_access.user_id')
            ->leftJoin('mst_main_department AS dept', 'dept.department_id', 'user.department_id')
            ->orderBy('user.user_id')
        ->get();

        return datatables()->of($access)->addIndexColumn()
            ->addColumn('view', function($access) {
                return '<a href="javascript:;" class="btn-view" data-user="'.$access->user.'" data-dept="'.$access->department_name.'" data-mod="'.$access->menu.'" data-toggle="tooltip" title="View"><i class="fa fa-eye"></i></a>';
            })
            ->addColumn('edit', function($access) {
                return '<a href="javascript:;" class="btn-edit" data-id="'.$access->access_id.'" data-user_id="'.$access->user_id.'" data-user="'.$access->user.'" data-dept="'.$access->department_name.'" data-mod="'.$access->menu.'" data-toggle="tooltip" title="Edit"><i class="fa fa-edit"></i></a>';
            })
            ->rawColumns(['view', 'edit'])
        ->toJson();
    }
    
}
