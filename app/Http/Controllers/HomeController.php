<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Dashboard\HomeService;
use App\Services\Resignation\DashboardService;
use App\Services\Training\DashboardService as DashboardTrainingService;
use App\Services\Ticketing\DashboardService as DashboardTicketingService;
use App\Services\Koperasi\DashboardService as DashboarKoperasiService;

class HomeController extends Controller
{
    private $HomeService;
    private $DashboardService;
    private $DashboardTrainingService;
    private $DashboardTicketingService;
    private $DashboarKoperasiService;

    public function __construct(
        HomeService $HomeService,
        DashboardService $DashboardService,
        DashboardTrainingService $DashboardTrainingService,
        DashboardTicketingService $DashboardTicketingService,
        DashboarKoperasiService $DashboarKoperasiService
        )
    {
        $this->HomeService = $HomeService;
        $this->DashboardService = $DashboardService;
        $this->DashboardTrainingService = $DashboardTrainingService;
        $this->DashboardTicketingService = $DashboardTicketingService;
        $this->DashboarKoperasiService = $DashboarKoperasiService;
    }

    public function index()
    {
        return view('dashboard');
    }

    public function breadcum(Request $request)
    {
        $data = $this->HomeService->getBreadcum($request);
        return response()->json(["message"=>"success","data"=>$data]);
    }

    public function breadcumResignation(Request $request)
    {
        $data = $this->DashboardService->getBreadcum($request);
        return response()->json(["message"=>"success","data"=>$data]);
    }

    public function breadcumTraining(Request $request)
    {
        $data = $this->DashboardTrainingService->getBreadcum($request);
        return response()->json(["message"=>"success","data"=>$data]);
    }

    public function breadcumTicketing(Request $request)
    {
        $data = $this->DashboardTicketingService->getBreadcum($request);
        return response()->json(["message"=>"success","data"=>$data]);
    }

    public function breadcumKoperasi(Request $request)
    {
        $data = $this->DashboarKoperasiService->getBreadcum($request);
        return response()->json(["message"=>"success","data"=>$data]);
    }
}
