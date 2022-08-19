<?php

namespace App\Http\Controllers\Ticketing;

use App\Http\Controllers\Controller;
use App\Model\Ticketing\ProductSubCategory;
use Illuminate\Http\Request;
use App\Services\Ticketing\ProductSubCategoryService;
use App\Http\Requests\Ticketing\ProductSubCategory as ProductSubCategoryRequest;

class ProductSubCategoryController extends Controller
{
    public $ProductSubCategoryService;

    public function __construct(ProductSubCategoryService $ProductSubCategoryService)
    {
        $this->ProductSubCategoryService = $ProductSubCategoryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->ProductSubCategoryService->getData();
        }
        return view('ticketing/productSubCategory');
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
    public function store(ProductSubCategoryRequest $request)
    {
        $this->ProductSubCategoryService->store($request);
        return \Response::success(["message"=>"Product Sub Category Added"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Ticketing\ProductSubCategory  $productSubCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ProductSubCategory $productSubCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Ticketing\ProductSubCategory  $productSubCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->ProductSubCategoryService->edit($id);
        return response()->json(["status" => "success", "data" => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Ticketing\ProductSubCategory  $productSubCategory
     * @return \Illuminate\Http\Response
     */
    public function update(ProductSubCategoryRequest $request, ProductSubCategory $productSubCategory)
    {
        $this->ProductSubCategoryService->update($request);
        return \Response::success(["message"=>"Product Sub Category Updated"]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Ticketing\ProductSubCategory  $productSubCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->ProductSubCategoryService->destroy($id);
        return \Response::success(["message"=>"Product Sub Category Deleted"]);
    }
}
