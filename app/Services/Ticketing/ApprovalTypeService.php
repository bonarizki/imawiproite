<?php

namespace App\Services\Ticketing;

use App\Repository\Ticketing\ApprovalType\Interfaces\ApprovalTypeInterfaces;
use App\Helper\HelperService;
class ApprovalTypeService
{
    public $ApprovalTypeInterfaces;
    public $HelperService;

    public function __construct(ApprovalTypeInterfaces $ApprovalTypeInterfaces,HelperService $HelperService)
    {
        $this->ApprovalTypeInterfaces = $ApprovalTypeInterfaces;
        $this->HelperService = $HelperService;
    }

    public function index()
    {
        $data = $this->ApprovalTypeInterfaces->index();
        return $this->HelperService->DataTablesResponse($data);
    }

    public function store($request)
    {
        $request = $this->HelperService->addAuthUpdate($request);
        return $this->ApprovalTypeInterfaces->store($request);
    }

    public function edit($id)
    {
        return $this->ApprovalTypeInterfaces->edit($id);
    }

    public function update($request)
    {
        $request = $this->HelperService->addAuthUpdate($request);
        return $this->ApprovalTypeInterfaces->update($request);
    }

    public function destroy($id)
    {
        $request = \Helper::instance()->MakeRequest(["approval_type_id"=>$id]);
        return $this->ApprovalTypeInterfaces->destroy($request);
    }
}