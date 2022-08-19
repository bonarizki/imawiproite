<?php

namespace App\Http\Controllers\Ticketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Ticketing\SystemApplicationService;
use App\Http\Requests\Ticketing\SystemApplicationRequest;

class SystemApplicationsController extends Controller
{
    public $SystemApplicationService;

    public function __construct(SystemApplicationService $SystemApplicationService)
    {
        $this->SystemApplicationService = $SystemApplicationService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->SystemApplicationService->getData();
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
    public function store(SystemApplicationRequest $request)
    {
        $this->SystemApplicationService->store($request);
        return \Response::success(["message"=>"System Application Added"]); 
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
        $data = $this->SystemApplicationService->edit($id);
        return response()->json(["status" => "success", "data" => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SystemApplicationRequest $request, $id)
    {
        $this->SystemApplicationService->update($request);
        return \Response::success(["message"=>"System Application Updated"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->SystemApplicationService->destroy($id);
        return \Response::success(["message"=>"System Application Deleted"]);
    }

    public function getPIC($system_name)
    {
        $data = $this->SystemApplicationService->getPIC($system_name);
        return response()->json(["status" => "success", "data" => $data]);
    }
}
