<?php

namespace App\Services\Koperasi;

use App\Repository\Koperasi\OrderLimit\Interfaces\OrderLimitInterfaces;
use App\Helper\HelperService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderLimitService
{
    private $OrderLimitInterfaces,$HelperService;

    public function __construct(OrderLimitInterfaces $OrderLimitInterfaces,HelperService $HelperService)
    {
        $this->HelperService = $HelperService;
        $this->OrderLimitInterfaces = $OrderLimitInterfaces;
    }

    public function index()
    {
        $data = $this->OrderLimitInterfaces->index();
        return $this->HelperService->DataTablesResponse($data);
    }

    public function store($request)
    {
        $request = $this->HelperService->addAuthInsert($request);
        return $this->OrderLimitInterfaces->insert($request);
    }

    public function edit($id)
    {
        return $this->OrderLimitInterfaces->edit($id);
    }

    public function update($request)
    {
        $request = $this->HelperService->addAuthUpdate($request);
        return $this->OrderLimitInterfaces->update($request);
    }

    public function delete($request,$id)
    {
        $request = $request->merge([
            'order_limit_id' => $id
        ]);
        return $this->OrderLimitInterfaces->delete($request);
    }
}