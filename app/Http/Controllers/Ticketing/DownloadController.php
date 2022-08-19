<?php

namespace App\Http\Controllers\Ticketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Ticketing\DownloadService;

class DownloadController extends Controller
{
    public $DownloadService;

    public function __construct(DownloadService $DownloadService)
    {
        $this->DownloadService = $DownloadService;
    }

    public function download(Request $request)
    {
        return $this->DownloadService->handle($request);
    }

    public function downloadByIdPDF($id)
    {
        return $this->DownloadService->downloadPDFById($id);
    }

    public function downloadRequestAccessUser($id)
    {
        return $this->DownloadService->downloadRequestAccessUser($id);
    }

    public function downloadRequestCRA($id)
    {
        return $this->DownloadService->downloadRequestCRA($id);
    }
}
