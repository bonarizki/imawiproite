<?php

namespace App\Http\Controllers\Koperasi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Koperasi\OrderLimitRequest;
use App\Services\Koperasi\OrderLimitService;
use App\Services\Koperasi\ProductService;
use Illuminate\Http\Request;

class OrderLimitController extends Controller
{
    private $OrderLimitService,$ProductService;

    public function __construct(OrderLimitService $OrderLimitService,ProductService $ProductService)
    {
        $this->OrderLimitService = $OrderLimitService;
        $this->ProductService = $ProductService;
    }

    public function index()
    {
        return $this->OrderLimitService->index();
    }

    public function getCategory(Request $request)
    {
        return $this->ProductService->getCategoryProduct($request);
    }

    public function store(OrderLimitRequest $request)
    {
        $this->OrderLimitService->store($request);
        return \Response::success(["status"=>"success","message" => "Order Limit Added"]);
    }

    public function edit(Request $request,$id)
    {
        $data = $this->OrderLimitService->edit($id);
        return \Response::success($data);
    }

    public function update(OrderLimitRequest $request)
    {
        $this->OrderLimitService->update($request);
        return \Response::success(["status"=>"success","message" => "Order Limit Updated"]);
    }

    public function destroy(Request $request,$id)
    {
        $this->OrderLimitService->delete($request,$id);
        return \Response::success(["status"=>"success","message" => "Order Limit Deleted"]);
    }
    
}
