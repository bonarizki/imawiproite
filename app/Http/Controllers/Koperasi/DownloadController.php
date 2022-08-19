<?php

namespace App\Http\Controllers\Koperasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Koperasi\DownloadService;

class DownloadController extends Controller
{
    public $DownloadService;

    public function __construct(DownloadService $DownloadService)
    {
        $this->DownloadService = $DownloadService;
    }

    public function downloadHistory($id)
    {
        return $this->DownloadService->downloadHistory($id);
    }

    public function downloadOrder(Request $request)
    {
        return $this->DownloadService->downloadOrder($request);
    }
}
