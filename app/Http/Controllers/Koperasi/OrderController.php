<?php

namespace App\Http\Controllers\Koperasi;

use App\Http\Controllers\Controller;
use App\Services\Koperasi\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $OrderService;
    
    /**
     * __construct
     *
     * @param  mixed $OrderService
     * @return void
     */
    public function __construct(OrderService $OrderService)
    {
        $this->OrderService = $OrderService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->ajax()){
            return $this->OrderService->allOrder($request);
        }
        
        return view('koperasi/order');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->OrderService->CreateOrder();
        return \Response::success(["message" => "Order Created"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->OrderService->edit($id);
        return \Response::success($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->OrderService->updateOrderHeader($request);
        return \Response::success(["message" => "Order Updated"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
       $this->OrderService->deleteOrder($request);
       return \Response::success(["message" => "Order Cancel"]);
    }

    public function reverse(Request $request)
    {
        $this->OrderService->reverseOrder($request);
        return \Response::success(["message" => "Order Reversed"]);
    }

    public function UpdateOrder(Request $request)
    {
        $this->OrderService->HandleUpdateOrder($request);
        return \Response::success(["message" => "Order Updated"]);
    }
}
