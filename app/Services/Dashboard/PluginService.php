<?php

namespace App\Services\Dashboard;

use App\Repository\Dashboard\Plugin\Interfaces\PluginYearInterfaces as PYI;
use App\Repository\Dashboard\Plugin\Interfaces\PluginMonthInterfaces as PMI;
use App\Repository\Dashboard\Plugin\Interfaces\PluginPeriodInterfaces as PPI;
use App\Repository\Dashboard\Plugin\Interfaces\PluginVersionInterfaces as PVI;
use App\Repository\Dashboard\Plugin\Interfaces\PluginSettingSystemInterfaces as PSSI;
use App\Helper\HelperService;
use Illuminate\Support\Facades\Auth;

class PluginService
{
    private $PluginYearInterfaces;
    private $PluginMonthInterfaces;
    private $PluginPeriodInterfaces;
    private $PluginVersionInterfaces;
    private $PluginSettingSystemInterfaces;
    private $HelperService;

    public function __construct(PYI $PYI,PMI $PMI, PPI $PPI, PVI $PVI, PSSI $PSSI,HelperService $HelperService)
    {
        $this->PluginYearInterfaces = $PYI;
        $this->PluginMonthInterfaces = $PMI;
        $this->PluginPeriodInterfaces = $PPI;
        $this->PluginVersionInterfaces = $PVI;
        $this->PluginSettingSystemInterfaces = $PSSI;
        $this->HelperService = $HelperService;
    }

    public function getAllPluginYear($request)
    {
        $data = $this->PluginYearInterfaces->getDataAllYear($request);
        return $this->HelperService->DataTablesResponse($data);
    }

    public function getPluginYearById($id)
    {
        return $this->PluginYearInterfaces->getPluginYearById($id);
    }

    public function getAllPluginYearActive()
    {
        $data = $this->PluginYearInterfaces->getAllPluginYearActive();
        return $this->HelperService->DataTablesResponse($data);
    }

    public function updatePluginYear($request)
    {
        $request->merge(["updated_by"=>Auth::user()->user_name]);
        $request = $this->StatusPluginYear($request);
        return $this->PluginYearInterfaces->updatePluginYear($request);
    }

    public function insertPluginYear($request)
    {
        $request->merge(["year_status"=>'1',"created_by"=>Auth::user()->user_name,"updated_by"=>Auth::user()->user_name]);
        $request = $this->StatusPluginYear($request);
        return $this->PluginYearInterfaces->insertPluginYear($request);
    }

    public function deletePluginYear($request)
    {
        $request->merge(["year_id"=>$request->id]);
        $request->request->remove('id');
        return $this->PluginYearInterfaces->deletePluginYear($request);
    }

    public function StatusPluginYear($request)
    {
        if ($request->year_status==null) {
            $request->merge(['year_status'=>0]);
        }else{
            $request->merge(['year_status'=>1]);
        }

        return $request;
    }

    //Plugin Month
    public function getAllPluginMonth($request)
    {
        $data = $this->PluginMonthInterfaces->getAllPluginMonth($request);
        return $this->HelperService->DataTablesResponse($data);
    }

    public function getPluginMonthById($id)
    {
        return $this->PluginMonthInterfaces->getPluginMonthById($id);
    }

    public function updatePluginMonthId($request)
    {
        $request->merge(["updated_by"=>Auth::user()->user_name]);
        return $this->PluginMonthInterfaces->updatePluginMonthId($request);
    }

    public function insertPluginMonth($request)
    {
        $request->merge(["created_by"=>Auth::user()->user_name,"updated_by"=>Auth::user()->user_name]);
        return $this->PluginMonthInterfaces->insertPluginMonth($request);
    }

    public function deletePluginMonth($request)
    {
        $request->merge(["month_id"=>$request->id]);
        $request->request->remove('id');
        return $this->PluginMonthInterfaces->deletePluginMonth($request);
    }

    //Plugin Period
    public function getAllPluginPeriod($request)
    {
        $data = $this->PluginPeriodInterfaces->getAllPluginPeriod($request);
        return $this->HelperService->DataTablesResponse($data);
    }

    public function getAllPluginPeriodActive()
    {
        $data = $this->PluginPeriodInterfaces->getAllPluginPeriodActive();
        return $this->HelperService->DataTablesResponse($data);
    }

    public function getPluginPeriodById($id)
    {
        return $this->PluginPeriodInterfaces->getPluginPeriodById($id);
    }

    public function updatePluginPeriodById($request)
    {
        $request->merge(["updated_by"=>Auth::user()->user_name]);
        $request = $this->StatusPluginPeriod($request);
        return $this->PluginPeriodInterfaces->updatePluginPeriodById($request);
    }

    public function insertPluginPeriod($request)
    {
        $request->merge(["period_status"=>"1","created_by"=>Auth::user()->user_name,"updated_by"=>Auth::user()->user_name]);
        $request = $this->StatusPluginPeriod($request);
        return $this->PluginPeriodInterfaces->insertPluginPeriod($request);
    }

    public function deletePluginPeriod($request)
    {
        $request->merge(["period_id"=>$request->id]);
        $request->request->remove('id');
        return $this->PluginPeriodInterfaces->deletePluginPeriod($request);
    }

    public function StatusPluginPeriod($request)
    {
        if ($request->period_status==null) {
            $request->merge(['period_status'=>0]);
        }else{
            $request->merge(['period_status'=>1]);
        }

        return $request;
    }

    //Plugin Version
    public function getAllPluginVersion($request)
    {
        $data = $this->PluginVersionInterfaces->getAllPluginVersion($request);
        return $this->HelperService->DataTablesResponse($data);
    }

    public function getPluginVersionId($id)
    {
        return $this->PluginVersionInterfaces->getPluginVersionId($id);
    }

    public function updatePluginVersionId($request)
    {
        $request->merge(["updated_by"=>Auth::user()->user_name]);
        $request = $this->StatusPluginVersion($request);
        return $this->PluginVersionInterfaces->updatePluginVersionId($request);
    }

    public function insertPluginVersion($request)
    {
        $request->merge(["created_by"=>Auth::user()->user_name,"updated_by"=>Auth::user()->user_name]);
        $request = $this->StatusPluginVersion($request);
        return $this->PluginVersionInterfaces->insertPluginVersion($request);
    }

    public function deletePluginVersion($request)
    {
        $request->merge(["version_id"=>$request->id]);
        $request->request->remove('id');
        return $this->PluginVersionInterfaces->deletePluginVersion($request);
    }

    public function StatusPluginVersion($request)
    {
        if ($request->version_status==null) {
            $request->merge(['version_status'=>0]);
        }else{
            $request->merge(['version_status'=>1]);
        }
        return $request;
    }

    //plugin system setting
    public function getAllSystemSetting($request)
    {
        $data = $this->PluginSettingSystemInterfaces->getAllSystemSetting($request);
        return $this->HelperService->DataTablesResponse($data);
    }

    public function getPluginSystemSettingById($id)
    {
        return $this->PluginSettingSystemInterfaces->getPluginSystemSettingById($id);
    }

    public function updatePluginSystemSettingById($request)
    {
        $request = $this->StatusPluginSystemSetiing($request);
        $request->merge(["updated_by"=>Auth::user()->user_name]);
        return $this->PluginSettingSystemInterfaces->updatePluginSystemSettingById($request);
    }

    public function insertPluginSystemSetting($request)
    {
        $request = $this->StatusPluginSystemSetiing($request);
        $request->merge(["setting_system_status"=>"1","created_by"=>Auth::user()->user_name,"updated_by"=>Auth::user()->user_name]);
        return $this->PluginSettingSystemInterfaces->insertPluginSystemSetting($request);
    }

    public function deletePluginSystemSetting($request)
    {
        $request->merge(["setting_system_id"=>$request->id]);
        $request->request->remove('id');
        return $this->PluginSettingSystemInterfaces->deletePluginSystemSetting($request);
    }

    public function StatusPluginSystemSetiing($request)
    {
        if ($request->setting_system_status==null) {
            $request->merge(['setting_system_status'=>0]);
        }else{
            $request->merge(['setting_system_status'=>1]);
        }
        return $request;
    }

}