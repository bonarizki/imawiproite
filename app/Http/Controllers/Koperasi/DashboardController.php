<?php

namespace App\Http\Controllers\Koperasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Koperasi\DashboardService;

class DashboardController extends Controller
{
    public $DashboardService;

    public function __construct(DashboardService $DashboardService)
    {
        $this->DashboardService = $DashboardService;
    }

    public function index()
    {
        $banner = $this->DashboardService->banner();
        return view('koperasi/dashboard',compact('banner'));
    }

    public function data(Request $request)
    {
        $data = $this->DashboardService->data($request);
        return \Response::success(["data"=>$data]);
    }
}
