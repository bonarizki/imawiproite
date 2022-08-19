<?php

namespace App\Http\Controllers\Ticketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Ticketing\TicketingStatusService;
use App\Model\Ticketing\RequestTicketingDetailPo as Detail;

class StatusController extends Controller
{
    private $TicketingStatusService;

    public function __construct(TicketingStatusService $TicketingStatusService)
    {
        $this->TicketingStatusService = $TicketingStatusService;
    }

    /**
     * TicketingAll semua data ticketing berdasarkan period id dan tanpa ticketing status
     *
     * @return void
     */
    // public function TicketingAll($period_id)
    // {
    //     return $this->TicketingStatusService->TicketingAll($period_id);
    // }
    
    /**
     * TicketingAllData semua data ticketing dengan status in_progress dan done
     *
     * @param  mixed $request
     * @return void
     */
    public function TicketingAllData(Request $request)
    {
        return $this->TicketingStatusService->getTicketingAllData($request);
    }
    
    /**
     * TicketingDataById semua data ticketing dengan status in_progress dan approve berdasarkan id user
     *
     * @param  mixed $request
     * @return void
     */
    public function TicketingDataById(Request $request)
    {
        return $this->TicketingStatusService->getTicketingDataById($request);
    }

    public function DetailTicketing(Request $request)
    {
        $data = $this->TicketingStatusService->getTicketingStatusID($request);
        return \Response::success($data);
    }
    
    /**
     * TicketingAllDataUnproceed semua data ticketing dengan status reject dan cancel
     *
     * @param  mixed $request
     * @return void
     */
    public function TicketingAllDataUnproceed(Request $request)
    {
        return $this->TicketingStatusService->getTicketingAllDataUnproceed($request);
    }
    
    /**
     * TicketingDataByIdUnproceed semua data ticketing dengan status reject dan cancel berdasarkan id user
     *
     * @param  mixed $request
     * @return void
     */
    public function TicketingDataByIdUnproceed(Request $request)
    {
        return $this->TicketingStatusService->getTicketingDataByIdUnproceed($request);
    }

    public function CancelTicketing(Request $request)
    {
        $this->TicketingStatusService->CancelTicketing($request);
        return \Response::success(["message"=>"Ticketing Canceled"]);
    }

    public function update(Request $request)
    {
        $this->TicketingStatusService->update($request);
        return \Response::success(["message"=>"Ticketing Updated"]);
    }

    public function DetailPOById(Detail $id)
    {
        $id->load('Comparison');
        return \Response::success($id);
    }
}
