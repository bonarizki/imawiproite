<?php

namespace App\Http\Controllers\Koperasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Koperasi\HistoryService;

class HistoryController extends Controller
{
    public $HistoryService;

    public function __construct(HistoryService $HistoryService)
    {
        $this->HistoryService = $HistoryService;
    }

    public function index()
    {
        $history = $this->HistoryService->HistoryUser();
        return view('koperasi/history',compact('history'));
    }
}
