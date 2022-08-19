<?php

namespace App\Http\Controllers\Ticketing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Ticketing\ApprovalTypeService;


class ApprovalTypeController extends Controller
{
    public $ApprovalTypeService;

    public function __construct(ApprovalTypeService $ApprovalTypeService)
    {
        $this->ApprovalTypeService = $ApprovalTypeService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->ApprovalTypeService->index();
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
    public function store(TicketingTypeRequest $request)
    {
        $this->ApprovalTypeService->store($request);
        return \Response::success(["message"=>"Ticket Type Added"]);
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
        $data = $this->ApprovalTypeService->edit($id);
        return response()->json(["status" => "success", "data" => $data]);
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
        $this->ApprovalTypeService->update($request);
        return \Response::success(["message"=>"Ticket Type Updated"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->ApprovalTypeService->destroy($id);
        return \Response::success(["message"=>"Ticket Type Deleted"]);
    }
}
