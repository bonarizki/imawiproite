<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Dashboard\AgeCategoryService;

class AgeController extends Controller
{
    public $AgeCategoryService;

    public function __construct(AgeCategoryService $AgeCategoryService)
    {
        $this->AgeCategoryService = $AgeCategoryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->AgeCategoryService->getALlData();
        }

        return view('management/age');
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
        $this->AgeCategoryService->insert($request);
        return \Response::success(["status"=>"success","message"=>"Age Category Created"]);
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
        $data = $this->AgeCategoryService->edit($id);
        return \Response::success( $data);
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
        $this->AgeCategoryService->update($request);
        return \Response::success(["status"=>"success","message"=>"Age Category Update"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $this->AgeCategoryService->delete($request);
        return \Response::success(["status"=>"success","message"=>"Age Category Deleted"]);
    }
}
