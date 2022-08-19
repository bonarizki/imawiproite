<?php

namespace App\Http\Controllers\Awards;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\Awards\ManagementQuestion;
use App\Helper\HelperService;

class ManagementQuestionController extends Controller
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
            $data = ManagementQuestion::all();
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
        ManagementQuestion::create($request->except('_token'));
        return \Response::success(["message"=>"Question Created"]);
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
        $data = ManagementQuestion::find($id);
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
        ManagementQuestion::find($request->question_id)
            ->update($request->except('_token'));
        return \Response::success(["message"=>"Question Updated"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        ManagementQuestion::find($id)->delete();
        return \Response::success(["message"=>"Question Deleted"]);
    }
}
