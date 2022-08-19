<?php 

namespace App\Repository\Koperasi\Menu;

use App\Repository\Koperasi\Menu\Interfaces\MenuInterfaces;
use App\Model\Koperasi\Menu\Menu;
use App\Model\Koperasi\Menu\MenuChild;
use App\Model\Koperasi\Menu\MenuGrandChild;
use Illuminate\Support\Facades\DB;

class MenuRepository implements MenuInterfaces
{
    public function getAllMenu()
    {
        return Menu::all();
    }

    public function getAllMenuChild()
    {
        return MenuChild::orderBy('menu_child_name','asc')->get();
    }

    public function getAllMenuGrandChild()
    {
        return MenuGrandChild::all();
    }

    public function getChildMenu($id)
    {
        return MenuChild::where('menu_parent_id', $id)->get();

    }

    public function getGrandChildMenu($id)
    {
        return MenuGrandChild::where('menu_child_id', $id)->get();
    }

    public function insertMenu($request,$model)
    {
        DB::transaction(function () use ($request, $model) {
            $model::create($request->except('_token'));
            \Helper::instance()->log('CREATE', $request, $model);
        });
    }

    public function DetailUsewith($request,$model)
    {
        return $model::with('MenuChild')->find($request->id);
    }

    public function DetailUseFind($request,$model)
    {
        return $model::find($request->id);
    }

    public function UpdateMenu($request, $newRequest, $model, $id)
    {
        DB::transaction(function () use ($request, $newRequest, $model, $id) {
            \Helper::instance()->log('UPDATE', $request, $model);
            $model::find($newRequest->$id)
                ->update($newRequest->except('_token', 'TypeMenu'));
        });
    }

    public function deleteMenu($request, $model)
    {
        DB::transaction(function () use ($request, $model) {
            \Helper::instance()->log('DELETE', $request, $model);
            $model::find($request->id)
                ->delete();
        });
    }

    public function GetMenuByUrl($request)
    {
        return DB::table('mst_main_menu_parent')
                    ->leftJoin('mst_main_menu_child', 'mst_main_menu_child.menu_parent_id', '=', 'mst_main_menu_parent.menu_parent_id')
                    ->leftJoin('mst_main_menu_grand_child', 'mst_main_menu_grand_child.menu_child_id', '=', 'mst_main_menu_child.menu_child_id')
                    ->Where('mst_main_menu_parent.menu_parent_url','=',$request->path)
                    ->orWhere('mst_main_menu_child.menu_child_url','=',$request->path)
                    ->orWhere('mst_main_menu_grand_child.menu_grand_child_url','=',$request->path)
                    ->first();
    }
}