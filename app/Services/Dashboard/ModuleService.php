<?php

namespace App\Services\Dashboard;

use App\Repository\Dashboard\Module\Interfaces\ModuleInterfaces;
use Illuminate\Support\Facades\Auth;
use App\Helper\HelperService;

class ModuleService 
{
     private $ModuleInterfaces,$HelperService;
     private $path;

    public function  __construct(ModuleInterfaces $ModuleInterfaces,HelperService $HelperService)
    {
        $this->ModuleInterfaces = $ModuleInterfaces;
        $this->HelperService = $HelperService;
        $this->path = public_path();
    }

    public function insertModule($request)
    {
        $newRequest = $this->upload_image($request);
        $this->ModuleInterfaces->insertModule($newRequest);
        return true;
    }

    public function upload_image($request)
    {
        $file = $request->file('module_image');
        $file_name = [];

        if($request->hasfile('module_image')): // kondisi jika ada gambar yang di upload
            for ($i=0; $i < count($file); $i++) { 
                $file[$i]->move($this->path.'/file_uploads/images/module',$file[$i]->getClientOriginalName());
                $file_name = array_merge($file_name,[$file[$i]->getClientOriginalName()]);
            }
        else: // kodisi jika tidak ada gambar yang di upload maka akan menggunakan default gambar
            $file_name = array_merge($file_name,[$request->module_image]);
        endif;

        $newRequest = \Helper::instance()->MakeRequest($request->except(['module_image','_token']));
        $status = $newRequest->module_status == null ? 0 : $newRequest->module_status;
        $newRequest->merge([
            'module_image'=>json_encode($file_name),
            "created_by"=>Auth::user()->user_name,
            "updated_by"=>Auth::user()->user_name,
            "module_status"=>$status
        ]);
        return \Helper::instance()->MakeRequest($newRequest->except(''));
    }

    public function updateModule($request)
    {
        $newRequest = $this->upload_image($request);
        $this->ModuleInterfaces->updateModule($newRequest);
        return true;
    }

    public function getModuleAccess()
    {   
        $data_module_access = [];
        $access = $this->ModuleInterfaces->getUserAccess();
        if($access!=null) {
            if($access->module != '' || $access->module != NULL) {
                $module = explode('#', $access->module);
                $data_module_access= $this->ModuleInterfaces->getModuleWhereIn($module);
            }
        }

        return $data_module_access;
    }

    public function getModuleById($id)
    {
        $data = $this->ModuleInterfaces->getModuleById($id);
        return $data;
    }

    public function deleteModule($request)
    {
        $this->ModuleInterfaces->deleteModule($request);
        return true;
    }

    public function getAllModule()
    {
        $data = $this->ModuleInterfaces->getAllModule();
        return $this->HelperService->DataTablesResponse($data);
    }
}