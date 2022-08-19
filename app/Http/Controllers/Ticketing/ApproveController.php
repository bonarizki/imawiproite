<?php

namespace App\Http\Controllers\Ticketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Ticketing\ApproveService;
use App\Model\Ticketing\RequestTicketingDetailPo;

class ApproveController extends Controller
{
    private $ApproveService;

    public function __construct(ApproveService $ApproveService)
    {
        $this->ApproveService = $ApproveService;
    }

    public function index()
    {
        return $this->ApproveService->getDataApproval();
    }

    public function update(Request $request)
    {
        $type = $request->type;
        $this->ApproveService->update($request);
        return \Response::success(["message"=>"Ticketing " . ucwords($type) . "d"]);
    }

    public function updateAccept(Request $request)
    {
        RequestTicketingDetailPo::find($request->id)
            ->update($request->except('id'));
        return \Response::success(["message"=>"success"]);
    }
}
