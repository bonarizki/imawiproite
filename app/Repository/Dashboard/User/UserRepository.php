<?php

namespace App\Repository\Dashboard\User;

use App\Repository\Dashboard\User\Interfaces\UserInterfaces;
use App\Model\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Model\UserAccess;

class UserRepository implements UserInterfaces
{
    public static function getAllUser($request)
    {
        $query = User::with(['Grade','Title','Type','Department']);
        $request->department_id!=null ? $query->where('department_id','like','%'.$request->department_id.'%') : '';
        $request->grade_id!=null ? $query->where('grade_id','like','%'.$request->grade_id.'%') : '';
        $request->user_nik!=null ? $query->where('user_nik','like','%'.$request->user_nik.'%') : '';
        $request->user_name!=null ? $query->where('user_name','like','%'.$request->user_name.'%') : '';
        return $query->get();
    }

    public static function deleteUser($request)
    {
        DB::transaction(function () use ($request) {
            User::where('user_id', $request->user_id)->update(['user_status' => '0']);
            \Helper::instance()->log('DELETE', $request, 'App\Model\User');
            $user = User::find($request->user_id);
            $user->delete();
        });
    }

    public static function getDeleteUser()
    {
        return User::onlyTrashed()->get();
    }

    public static function restoreUser($request)
    {
        $user = User::onlyTrashed()->where('user_id', $request->user_id);
        $user->deleted_by = null;
        $user->restore();
    }

    public static function getUserById($user_id)
    {
        return User::with(['Grade','Title','Type','Department'])
            ->where('user_id',$user_id)
            ->first();
    }

    public static function updateUser($request)
    {
        DB::transaction(function () use ($request) {
            \Helper::instance()->log('UPDATE', $request, 'App\Model\User');
            User::where('user_nik', $request->user_nik)
                ->update($request->except(['_token']));
        });
    }

    public static function updateUserAccess($request,$data)
    {
        DB::transaction(function () use ($request,$data) {
            \Helper::instance()->log('UPDATE', $request, 'App\Model\User');
            User::where('user_nik', $request->user_nik)
                ->update($request->except(['_token']));
            foreach ($data as $AccessPosition) {
                if (!$AccessPosition['access']::where('user_id', $request->user_id)->exists()) { //check apakah user tersebut sudah memiliki access atau belum
                    $position = $AccessPosition['position']::where('department_id', $request->department_id)->first(); // jika belum maka ambil access defaultnya
                    $array = [
                        'menu' => $position->menu,
                        'user_id' => $request->user_id,
                        'created_by' => Auth::user()->user_name,
                        'updated_by' => Auth::user()->user_name
                    ];

                    $NewRequest = \Helper::instance()->MakeRequest($array);
                    if($AccessPosition['position'] == 'App\Model\UserAccessPosition') $NewRequest->merge(["module" => $position->module]) ;
                    $AccessPosition['access']::create($NewRequest->all());
                    \Helper::instance()->log('CREATE', $NewRequest, $AccessPosition['access']);
                }
            }
        });
    }

    public static function insertUser($request,$data)
    {
        DB::transaction(function () use ($request,$data) {
            $user = User::create($request->except(['_token', 'type']));
            \Helper::instance()->log('CREATE', $request, 'App\Model\User');

            foreach ($data as $AccessPosition) {
                $position = $AccessPosition['position']::where('department_id', $user->department_id)->first();
                $array = [
                    'menu' => $position->menu,
                    'user_id' => $user->user_id,
                    'created_by' => Auth::user()->user_name,
                    'updated_by' => Auth::user()->user_name
                ];

                $NewRequest = \Helper::instance()->MakeRequest($array);
                if($AccessPosition['position'] == 'App\Model\UserAccessPosition') $NewRequest->merge(["module" => $position->module]) ;
                $AccessPosition['access']::create($NewRequest->all());
                \Helper::instance()->log('CREATE', $NewRequest, $AccessPosition['access']);
            }
        });
    }

    public static function getUserAccess($request)
    {
        return User::query()
                    ->selectRaw('mst_main_user.user_id,
                        mst_main_user.user_nik,
                        mst_main_user.user_name,
                        d.department_name,
                        g.grade_name,
                        a.module,
                        a.menu')
                    ->leftJoin('mst_main_department AS d', 'd.department_id', 'mst_main_user.department_id')
                    ->leftJoin('mst_main_user_grade AS g', 'g.grade_id', 'mst_main_user.grade_id')
                    ->leftJoin('mst_main_user_access AS a', 'a.user_id', 'mst_main_user.user_id')
                    ->where('mst_main_user.user_id', $request->user_id)
                    ->first();
    }

    public static function saveUserAccess($request,$module,$menu)
    {
        UserAccess::where('user_id', $request->user_id)->delete();

        $access = new UserAccess();
        $access->user_id = $request->user_id;
        $access->module = $module;
        $access->menu = $menu;
        $access->created_by = Auth::user()->created_by;
        $access->updated_by = Auth::user()->updated_by;
        $access->save();
    }

    public static function getUserByNik($user_nik)
    {
        return User::with(['Grade','Grade.GradeGroup','Title','Type','Department'])
                    ->where("user_nik", $user_nik)->withTrashed()->first();
    }

    public static function getAlluserApproval()
    {
        return User::with(['Grade','Title','Type','Department','ApprovalMatrix','Grade.GradeGroup'])->get();
    }

    public static function getDataProfile($nik)
    {
        return User::with(['Grade','Title','Type','Department'])
                    ->where("user_nik",$nik)
                    ->first();
    }

    public static function getUserByDepartment($department_id)
    {
        return User::with(['Grade','Title','Type','Department'])
                    ->where('department_id',$department_id)
                    ->get();
    }

    public static function getUserByNikGet($data)
    {
        return User::with(['Grade','Grade.GradeGroup','Title','Type','Department'])
                    ->whereIN("user_nik",$data)->get();
    }

    public static function getUserUnderGradeGroup($department_id,$grade_group_id)
    {
        return User::with(['Grade','Grade.GradeGroup','Department','Title','Type'])
                    ->whereHas('Grade.GradeGroup',function ($q) use ($grade_group_id){
                        $q->where('grade_group_id','<=',$grade_group_id);
                    })
                    ->where('department_id',$department_id)
                    ->get();
    }

    public static function AccessRegven()
    {
        return User::with(['Grade','Title','Type','Department','AccessRegven'])->get();
    }

    public static function getHRHead()
    {
        return User::select('user_nik','user_type')
            ->where('user_type','hr_head')
            ->first();
    }

    public static function checkUserHEAD($request)
    {
        return User::where('user_type', $request->type)
            ->get();
    }
    
}