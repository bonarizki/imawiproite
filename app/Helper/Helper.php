<?php

namespace App\Helper;

use App\Model\UserLog as Log;
use App\Repository\Dashboard\Module\ModuleRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Repository\Dashboard\ModuleAdmin\ModuleAdminRepository;

class Helper
{

    public static function instance()
    {
        return new Helper();
    }

    public function log($method, $request, $model)
    {
        $status = $this->makeData($method, $request, $model);
        $data = [
            'user_log_mac' => $request->ip(),
            'user_log_menu' => url()->current(),
            'user_log_status' => $method,
            'user_log_info' => json_encode($status),
            'created_by' =>  Auth::user()->user_name,
            'updated_by' =>  Auth::user()->user_name,
            'user_id' => Auth::user()->user_id,
        ];
        Log::create($data);
        return true;
    }

    public function makeData($method, $request, $model)
    {
        if ($method == 'CREATE') :
            return $request->except('_token');
        elseif ($method == 'UPDATE') :
            $data = $this->makeDataBefore($model, $request);
            $array = $this->makeArrayUpdate($data, $request);
            return $array;
        elseif ($method == 'DELETE') :
            $data = $this->makeDataBefore($model, $request);
            return $data;
        endif;
    }

    public function makeArrayUpdate($data, $request)
    {
        $array = [
            "before" => $data->toArray(),
            "after" => $request->except('_token')
        ];

        return $array;
    }

    public function makeDataBefore($model, $request)
    {
        $primaryKey = app($model)->getKeyName();
        $data = $model::withTrashed()->find($request->$primaryKey);
        return $data;
    }

    public function MakeRequest($array)
    {
        $request = new Request($array);
        $request->setMethod('POST');
        $request->server->add(['REMOTE_ADDR' => $_SERVER['REMOTE_ADDR']]);
        return $request;
    }

    public function checkNIK()
    {
        $module_id = session()->get('module_active');
        $admin = ModuleAdminRepository::getAdminByModuleId($module_id)->toArray();
        $admin = $this->CreateAdminNIK($admin);
        return json_encode($admin);
    }
    
    /**
     * checkNIKByAPI
     *
     * @param  mixed $request is module_name
     * @return void
     */
    public function checkNIKByAPI(Request $request)
    {
        $module_id = ModuleRepository::getModuleByName($request->module_name);
        $admin = ModuleAdminRepository::getAdminByModuleId($module_id->module_id)->toArray();
        $admin = $this->CreateAdminNIK($admin);
        return  in_array(Auth::user()->user_nik, $admin); // return true if user admin and return false is user not admin
    }

    public function CreateAdminNIK($admin)
    {
        $array = [];
        array_filter($admin, function ($item) use (&$array) {
            $array = array_merge($array, [(int) $item['admin_nik']]);
        });
        return $array;
    }
}
