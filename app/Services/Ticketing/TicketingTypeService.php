<?php 

namespace App\Services\Ticketing;

use App\Repository\Ticketing\TicketingType\Interfaces\TicketingTypeInterfaces;
use App\Helper\HelperService;

class TicketingTypeService
{
    public $TicketingTypeInterfaces;
    public $HelperService;

    public function __construct(TicketingTypeInterfaces $TicketingTypeInterfaces,HelperService $HelperService)
    {
        $this->TicketingTypeInterfaces = $TicketingTypeInterfaces;
        $this->HelperService = $HelperService;
    }

    public function index()
    {
        $data = $this->TicketingTypeInterfaces->index();
        return $this->HelperService->DataTablesResponse($data);
    }

    public function store($request)
    {
        $request = $this->HelperService->addAuthUpdate($request);
        return $this->TicketingTypeInterfaces->store($request);
    }

    public function edit($id)
    {
        return $this->TicketingTypeInterfaces->edit($id);
    }

    public function update($request)
    {
        $request = $this->HelperService->addAuthUpdate($request);
        return $this->TicketingTypeInterfaces->update($request);
    }

    public function destroy($id)
    {
        $request = \Helper::instance()->MakeRequest(["type_id"=>$id]);
        return $this->TicketingTypeInterfaces->destroy($request);
    }
}