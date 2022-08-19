<?php

namespace App\Http\Controllers\Ticketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Ticketing\PriorityService;
use App\Http\Requests\Ticketing\PriorityRequest;

class PriorityController extends Controller
{
    public $PriorityService;
    
    /**
     * __construct
     *
     * @param  mixed $PriorityService
     * @return void
     */
    public function __construct(PriorityService $PriorityService)
    {
        $this->PriorityService = $PriorityService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->PriorityService->index();
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
     * @param  \App\Http\Requests\Ticketing\PriorityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PriorityRequest $request)
    {
        $this->PriorityService->store($request);
        return \Response::success(["message"=>"Priority Added"]);
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
        $data = $this->PriorityService->edit($id);
        return response()->json(["status" => "success", "data" => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Ticketing\PriorityRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PriorityRequest $request, $id)
    {
        $this->PriorityService->update($request);
        return \Response::success(["message"=>"Priority Updated"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->PriorityService->destroy($id);
        return \Response::success(["message"=>"Priority Deleted"]);
    }
}
