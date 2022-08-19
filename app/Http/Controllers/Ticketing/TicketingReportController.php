<?php

namespace App\Http\Controllers\Ticketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Ticketing\ReportService;

class TicketingReportController extends Controller
{
    public $ReportService;

    public function __construct(ReportService $ReportService)
    {
        $this->ReportService = $ReportService;
    }

    public function getData(Request $request)
    {
        return $this->ReportService->handle($request);
    }

    public function download(Request $request)
    {
        return $this->ReportService->handleDownload($request);
    }
}
