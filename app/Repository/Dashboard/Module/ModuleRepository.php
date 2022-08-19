<?php

namespace App\Repository\Dashboard\Module;

use App\Repository\Dashboard\Module\Interfaces\ModuleInterfaces;
use Illuminate\Support\Facades\DB;
use App\Model\Module;
use App\Model\UserAccess;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ModuleRepository implements ModuleInterfaces
{
     public function insertModule($newRequest)
     {
          DB::transaction(function () use ($newRequest) {
               Module::create($newRequest->all());
               \Helper::instance()->log('CREATE', $newRequest, 'App\Model\Module');
          });
     }

     public function updateModule($newRequest)
     {
          DB::transaction(function () use ($newRequest) {
               \Helper::instance()->log('UPDATE', $newRequest, 'App\Model\Module');
               Module::where('module_id', $newRequest->module_id)
                    ->update($newRequest->all());
          });
     }

     public function  getUserAccess()
     {
          return UserAccess::where('user_id', Auth::user()->user_id)->first();
     }

     public function getModuleByid($id)
     {
          return Module::find($id);
     }

     public function deleteModule($request)
     {
          DB::transaction(function () use ($request) {
               \Helper::instance()->log('DELETE', $request, 'App\Model\Module');
               Module::find($request->module_id)
                    ->delete();
          });
     }

     public function getAllModule()
     {
          return Module::all();
     }

     public function getAllModuleActive()
     {
          return Module::where('module_status', 1)->get();
     }

     public function getActiveModuleByName($module_name) //for check is module exists or not
     {
          return Module::where('module_name', $module_name)
               ->where('module_status', '1')
               ->exists();
     }

     public static function getModuleByName($module_name)
     {
          return Module::where('module_name', $module_name)
               ->where('module_status', '1')
               ->first();
     }

     public static function getModuleWhereIn($module_id)
     {
          return Module::whereIn('module_id',$module_id)
               ->where('module_status', '1')
               ->get();
     }
}
