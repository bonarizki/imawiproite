<?php 

namespace App\Services\Koperasi;

use App\Repository\Koperasi\History\Interfaces\HistoryInterfaces;
use App\Helper\HelperService;
use Illuminate\Support\Facades\Auth;

class HistoryService
{
    public $HistoryInterfaces,$HelperService;

    public function __construct(HistoryInterfaces $HistoryInterfaces,HelperService $HelperService)
    {
        $this->HistoryInterfaces = $HistoryInterfaces;
        $this->HelperService = $HelperService;
    }
    
    public function HistoryUser()
    {
        return $this->HistoryInterfaces->getHistoryUser(Auth::user()->user_nik);
    }
}