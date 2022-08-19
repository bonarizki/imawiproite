<?php

namespace App\Http\Controllers\Awards;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Model\Awards\Access;
use App\Model\Awards\Menu\Menu;

class AccessController extends Controller
{
    public function getAllAcces()
    {
        $query = User::with(['Grade','Title','Type','Department','SalesAwards'])->get();
        return DataTables::of($query)
                            ->addIndexColumn()
                            ->make(true);
    }

    public function show($id)
    {
        $dataUser = Access::with(['User','User.Department'])->find($id);
        return response()->json(["status"=>"success","data"=>$dataUser]);
    }

    public function getMenu()
    {
        $menu = Menu::with(['MenuChild','MenuChild.MenuGrandChild'])->get();
        return response()->json(["status"=>"success","data"=>$menu]);
    }

    public function update(Request $request)
    {
        $parent = $request->menu_parent == null ? '' : implode(',', $request->menu_parent);
        $child = $request->menu_child == null ? '' : implode(',' , $request->menu_child);
        $grand_child = $request->menu_grand_child == null ? '' : implode(',' , $request->menu_grand_child);
        $menu = $parent.'#'.$child.'#'.$grand_child;
        $request->merge(['updated_by' => Auth::user()->user_name,'menu'=>$menu]);
        $request->request->remove('menu_child');
        $request->request->remove('menu_parent');
        $request->request->remove('menu_grand_child');
        DB::transaction(function () use($request) {
            \Helper::instance()->log('UPDATE',$request,'App\Model\Awards\Access');
            Access::find($request->access_id)->update($request->except('_token'));
        });
        return response()->json(['status'=>'success','message'=>'Access Updated']);

    }
}
