<?php 

namespace App\Services\Ticketing;

use App\Repository\Ticketing\Priority\Interfaces\PriorityInterfaces;
use App\Helper\HelperService;

class PriorityService 
{
    public $PriorityInterfaces;
    
    /**
     * __construct
     *
     * @param  mixed $PriorityInterfaces
     * @param  mixed $HelperService
     * @return void
     */
    public function __construct(PriorityInterfaces $PriorityInterfaces,HelperService $HelperService)
    {
        $this->PriorityInterfaces = $PriorityInterfaces;
        $this->HelperService = $HelperService;
    }

    public function index()
    {
        $data = $this->PriorityInterfaces->index();
        return $this->HelperService->DataTablesResponse($data);
    }

    public function store($request)
    {
        $request = $this->HelperService->addAuthInsert($request);
        return $this->PriorityInterfaces->store($request);
    }

    public function edit($id)
    {
        return $this->PriorityInterfaces->edit($id);
    }

    public function update($request)
    {
        $request = $this->HelperService->addAuthUpdate($request);
        return $this->PriorityInterfaces->update($request);
    }

    public function destroy($id)
    {
        $request = \Helper::instance()->MakeRequest(["priority_id"=>$id]);
        return $this->PriorityInterfaces->destroy($request);
    }
}