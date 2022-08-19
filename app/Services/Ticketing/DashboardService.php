<?php

namespace App\Services\Ticketing;

use App\Repository\Ticketing\Dashboard\Interfaces\DashboardInterfaces;
use App\Helper\HelperService;
use App\Repository\Dashboard\User\Interfaces\UserInterfaces;
class DashboardService
{
    private $DashboardInterfaces,$HelperService,$UserInterfaces;

    public function __construct(DashboardInterfaces $DashboardInterfaces,HelperService $HelperService, UserInterfaces $UserInterfaces)
    {
        $this->DashboardInterfaces = $DashboardInterfaces;
        $this->HelperService = $HelperService;
        $this->UserInterfaces = $UserInterfaces;
    }
    
    /**
     * getBreadcum function ini untuk mendapatkan
     * detail menu dari menu (url) saat ini
     * 
     *
     * @param  mixed $request berisi paramater url saat ini
     * @return void
     */
    public function getBreadcum($request)
    {
        return $this->DashboardInterfaces->GetMenuByUrl($request);
    }

    public function getData($request)
    {
        return [
            "initial" => $this->DashboardInterfaces->getData('initial',$request)->count() ,
            "process" => $this->DashboardInterfaces->getData('process',$request)->count() ,
            "approve" => $this->DashboardInterfaces->getData('approve',$request)->count() ,
            "done" => $this->DashboardInterfaces->getData('done',$request)->count() 
        ];
    }

    public function getTable($request)
    {
        $data = $this->DashboardInterfaces->getData($request->status,$request);
        return $this->HelperService->DataTablesResponse($data);
    }

    public function getChart($request)
    {
        $data = [
            "donutChart" => [
                (object) [
                    "name" => "Approve",
                    "total" => $this->DashboardInterfaces->getData("approve",$request)->count()
                ],
                (object) [
                    "name" => "Cancel",
                    "total" => $this->DashboardInterfaces->getData("cancel",$request)->count()
                ],
                (object) [
                    "name" => "Reject",
                    "total" => $this->DashboardInterfaces->getData("reject",$request)->count()
                ],
            ],
            "barChart" => $this->DashboardInterfaces->getAllDepartmentTicket($request->period_id)
        ];
        return $data;
    }
}