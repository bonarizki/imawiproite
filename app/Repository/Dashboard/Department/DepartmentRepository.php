<?php

namespace App\Repository\Dashboard\Department;

use App\Repository\Dashboard\Department\Interfaces\DepartmentInterfaces;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Model\Departement;
use App\Model\UserAccessPosition;

class DepartmentRepository implements DepartmentInterfaces
{
    public function getAllDepartment()
    {
        return Departement::all();
    }

    public function getDepartmentById($id)
    {
        return Departement::find($id);
    }

    public function updateDepartment($request,$data)
    {
        DB::transaction(function () use($request,$data) {
            \Helper::instance()->log('UPDATE',$request,'App\Model\Departement');
            Departement::find($request->department_id)
                            ->update($data);
        });
    }

    public function deleteDepartment($request)
    {
        DB::transaction(function () use ($request) {
            \Helper::instance()->log('DELETE',$request,'App\Model\Departement');
            Departement::find($request->department_id)
                            ->delete();
        });
    }

    public function insertDepartment($request)
    {
        DB::transaction(function () use($request) {
            Departement::create($request->except('_token'));
            \Helper::instance()->log('CREATE',$request,'App\Model\Departement');
        });
    }

    public function getAccessDepartment($request)
    {
        return Departement::query()
                            ->selectRaw('mst_main_department.department_id,
                                mst_main_department.department_name,
                                ap.module, ap.menu')
                            ->leftJoin('mst_main_user_access_position AS ap', 'ap.department_id', 'mst_main_department.department_id')
                            ->where('mst_main_department.department_id', $request->department_id)
                            ->first();
    }

    public function saveAccessDepartment($request,$module,$menu)
    {
        DB::transaction(function () use($request,$module,$menu) {
            UserAccessPosition::where('department_id', $request->department_id)->delete();
            $access = new UserAccessPosition();
            $access->department_id = $request->department_id;
            $access->module = $module;
            $access->menu = $menu;
            $access->created_by = Auth::user()->created_by;
            $access->updated_by = Auth::user()->updated_by;
            $access->save();
        });
    }

    public function getDataByName($name)
    {
        return Departement::select("department_id")
                            ->where("department_name",$name)
                            ->first();
    }

    public function AccessPositionRegven()
    {
        return Departement::with(['AccessPositionRegven'])->get();
    }
}