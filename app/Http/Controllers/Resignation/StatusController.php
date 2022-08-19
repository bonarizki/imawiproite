<?php

namespace App\Http\Controllers\Resignation;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Resignation\StatusService;
use App\Helper\HelperService;
class StatusController extends Controller
{
    private $StatusService;
    private $HelperService;

    public function __construct(StatusService $StatusService,HelperService $HelperService)
    {
        $this->StatusService = $StatusService;
        $this->HelperService = $HelperService;
    }

    public function getData(Request $request) // mendapatkan data resign personal
    {
        $data = $this->StatusService->getDataResignByIdProceed($request);
        return $this->HelperService->DataTablesResponse($data);
    }

    public function geDataAll(Request $request) // mendapatkan semua data resign
    {
        $data = $this->StatusService->geDataAllProceed($request);
        return $this->HelperService->DataTablesResponse($data);
    }

    public function geDataAllUnproceed(Request $request) // mendapatkan semua data resign
    {
        $data = $this->StatusService->geDataAllUnproceed($request);
        return $this->HelperService->DataTablesResponse($data);
    }

    public function getDataUnproceed(Request $request)
    {
        $data = $this->StatusService->getDataResignByIdUnproceed($request);
        return $this->HelperService->DataTablesResponse($data);
    }

    public function cancelResign(Request $request)
    {
        $this->StatusService->cancelResign($request);
        return \Response::success(["message"=>"Cancel Success"]);
    }

    public function insertFeedback(Request $request)
    {
        $this->StatusService->insertFeedback($request);
        return \Response::success(["message"=>"Feedback Send"]);
    }

    public function getUserByDepartment(Request $request)
    {
        $data = $this->StatusService->getUserByDepartment();
        return \Response::success(["message"=>"success","data"=>$data]);
    }

    public function getUserAll(Request $request)
    {
        $data = $this->StatusService->getUserAll($request);
        return \Response::success(["message"=>"success","data"=>$data]);
    }

    public function handoverResign(Request $request)
    {
        $this->StatusService->handoverResign($request);
        return \Response::success(["message"=>"Handover Updated"]);
    }

    public function getUserByNik(Request $request)
    {
        $data = $this->StatusService->getUserByNik($request->user_nik);
        return \Response::success(["message"=>"success","data"=>$data]);
    }

    public function remindFeedBack($resign_id)
    {
        $this->StatusService->remindFeedBack($resign_id);
        return \Response::success(["message"=>"Remind To User Send"]);
    }
}
