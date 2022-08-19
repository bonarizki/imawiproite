<?php

namespace App\Http\Controllers\Ticketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Ticketing\DashboardService;
use App\Helper\HelperService;

class DashboardController extends Controller
{
    public $DashboardService,$HelperService;

    public function __construct(DashboardService $DashboardService,HelperService $HelperService)
    {
        $this->DashboardService = $DashboardService;
        $this->HelperService = $HelperService;
    }

    public function getData(Request $request)
    {
        return \Response::success(["result"=>$this->DashboardService->getData($request)]);
    }

    public function getTable(Request $request)
    {
        $data = $this->DashboardService->getTable($request);
        return $data;
    }

    public function getChart(Request $request)
    {
        return \Response::success(["result"=>$this->DashboardService->getChart($request)]);
    }
}
