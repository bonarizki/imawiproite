<?php

namespace App\Http\Controllers\Resignation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Resignation\Menu\Menu;
use App\Model\Resignation\Menu\MenuChild;
use App\Model\Resignation\Menu\MenuGrandChild;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MenuRequest;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{

    public function getAllMenu()
    {
        return DataTables::of(Menu::all())
            ->editColumn('menu_parent_icon', function (Menu $Menu) {
                return '<center>
                            <badge>
                                <i class="' . $Menu->menu_parent_icon . '"></i> - ' . $Menu->menu_parent_icon . '
                            </badge>
                        </center>';
            })
            ->addColumn('edit', function (Menu $Menu) {
                return '<center>
                            <button class="btn btn-sm btn-success" onclick="modalShow(' . "'edit','menu_parent','" . $Menu->menu_parent_id . "'" . ')" title="Edit"><i class="feather icon-edit"></i>Edit</button>
                        </center>';
            })
            ->addColumn('delete', function (Menu $Menu) {
                return '<center>
                            <button class="btn btn-sm btn-danger" onclick="deleteMenu(' . "'menu_parent','" . $Menu->menu_parent_id . "'" . ')" title="Delete"><i class="feather icon-trash-2"></i>Delete</button>
                        </center>';
            })
            ->addColumn('extend', function (Menu $Menu) {
                return '<center>
                            <button class="badge badge-sm badge-info details-control"><i class="feather icon-plus-circle"></i></button>
                        </center>';
            })
            ->addIndexColumn()
            ->rawColumns(['edit','delete', 'menu_parent_icon', 'extend'])
            ->make(true);
    }

    public function getChildMenu($id)
    {
        $data = MenuChild::where('menu_parent_id', $id)->get();
        return DataTables::of($data)
            ->editColumn('menu_child_icon', function ($data) {
                return '<center>
                            <badge>
                                <i class="' . $data->menu_child_icon . '"></i> - ' . $data->menu_child_icon . '
                            </badge>
                        </center>';
            })
            ->addColumn('edit', function ($data) {
                return '<center>
                            <button class="btn btn-sm btn-success" onclick="modalShow(' . "'edit','menu_child','" . $data->menu_child_id . "'" . ')"><i class="feather icon-edit"></i> Edit</button>
                        </center>';
            })
            ->addColumn('delete', function ($data) {
                return '<center>
                            <button class="btn btn-sm btn-danger" onclick="deleteMenu(' . "'menu_child','" . $data->menu_child_id . "'" . ')"><i class="feather icon-trash"></i> Delete</button>
                        </center>';
            })
            ->addColumn('extend', function ($data) {
                return '<center>
                            <button class="badge badge-sm badge-info details-control"><i class="feather icon-plus-circle"></i></button>
                        </center>';
            })
            ->addIndexColumn()
            ->rawColumns(['edit','delete', 'menu_child_icon', 'extend'])
            ->make(true);
    }

    public function getGrandChildMenu($id)
    {
        $data = MenuGrandChild::where('menu_child_id', $id)->get();
        return DataTables::of($data)
            ->editColumn('menu_grand_child_icon', function ($data) {
                return '<center>
                            <badge>
                                <i class="' . $data->data_grand_child_icon . '"></i> - ' . $data->data_grand_child_icon . '
                            </badge>
                        </center>';
            })
            ->addColumn('edit', function ($data) {
                return '<center>
                            <badge class="btn btn-sm btn-success" onclick="modalShow(' . "'edit','menu_grand_child','" . $data->menu_grand_child_id . "'" . ')"><i class="feather icon-edit"></i>Edit</badge>
                        </center>';
            })
            ->addColumn('delete', function ($data) {
                return '<center>
                            <badge class="btn btn-sm btn-danger" onclick="deleteMenu(' . "'menu_grand_child','" . $data->menu_grand_child_id . "'" . ')"><i class="feather icon-trash"></i> Delete</badge>
                        </center>';
            })
            ->addColumn('extend', function ($data) {
                return '<center>
                            <button class="badge badge-sm badge-info details-control"><i class="feather icon-plus-circle"></i></button>
                        </center>';
            })
            ->addIndexColumn()
            ->rawColumns(['edit','delete', 'menu_grand_child_icon', 'extend'])
            ->make(true);
    }

    public function store(MenuRequest $request)
    {
        $model = $this->getModel($request);
        $array = [
            "created_by" => Auth::user()->user_name,
            "updated_by" => Auth::user()->user_name,
        ];
        $request->TypeMenu == 'menu_parent' ? $array = array_merge($array, [$request->TypeMenu . "_status" => 1]) : "";
        $request->merge($array);
        $request->request->remove('TypeMenu');
        DB::transaction(function () use ($request, $model) {
            $model::create($request->except('_token'));
            \Helper::instance()->log('CREATE', $request, $model);
        });
        return response()->json(["status" => "success", "message" => "Menu Added"]);
    }

    public function show(Request $request)
    {
        $model = $this->getModel($request);
        if ($request->TypeMenu == 'menu_grand_child') {
            $data = $model::with('MenuChild')->find($request->id);
        } else {
            $data = $model::find($request->id);
        }
        return response()->json(["statu" => "success", "data" => $data]);
    }

    function getModel($request)
    {
        if ($request->TypeMenu == 'menu_parent') {
            $model = 'App\Model\Resignation\Menu\Menu';
        } elseif ($request->TypeMenu == 'menu_child') {
            $model = 'App\Model\Resignation\Menu\MenuChild';
        } elseif ($request->TypeMenu == 'menu_grand_child') {
            $model = 'App\Model\Resignation\Menu\MenuGrandChild';
        }

        return $model;
    }

    function update(MenuRequest $request)
    {
        $model = $this->getModel($request);
        $id = $request->TypeMenu . '_id';
        $request->merge(["updated_by" => Auth::user()->user_name]);
        $newRequest = $request;
        $request->request->remove('TypeMenu');
        DB::transaction(function () use ($request, $newRequest, $model, $id) {
            \Helper::instance()->log('UPDATE', $request, $model);
            $model::find($newRequest->$id)
                ->update($newRequest->except('_token', 'TypeMenu'));
        });
        return response()->json(["status" => "success", "message" => "Menu Updated"]);
    }

    public function destroy(Request $request)
    {
        $model = $this->getModel($request);
        $request->merge([$request->TypeMenu . '_id' => $request->id]);
        DB::transaction(function () use ($request, $model) {
            \Helper::instance()->log('DELETE', $request, $model);
            $model::find($request->id)
                ->delete();
        });
        return response()->json(["status" => "success", "message" => "Menu Deleted"]);
    }

}
