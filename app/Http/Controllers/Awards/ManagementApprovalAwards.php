<?php

namespace App\Http\Controllers\Awards;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Awards\ManagemenApprovalAwards as AMA;
use App\Helper\HelperService;

class ManagementApprovalAwards extends Controller
{
    public $HelperService;

    public function __construct(HelperService $HelperService)
    {
        $this->HelperService = $HelperService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = AMA::all();
            return $this->HelperService->DataTablesResponse($data);
        }
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
        $this->HelperService->addAuthInsert($request);
        AMA::create($request->except('_token'));
        return \Response::success(["message"=>"Approval Position Created"]);
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
        $data = AMA::find($id);
        return response()->json(["status"=>"success","data"=>$data]);
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
        $this->HelperService->addAuthUpdate($request);
        AMA::find($request->approval_id)
            ->update($request->except('_token'));
        return \Response::success(["message"=>"Approval Position Updated"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        AMA::find($id)->delete();
        return \Response::success(["message"=>"Approval Position Deleted"]);
    }
}
