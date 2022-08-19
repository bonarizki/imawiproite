<?php

namespace App\Http\Controllers\Ticketing;

use App\Http\Controllers\Controller;
use App\Model\Ticketing\ProductCategory;
use Illuminate\Http\Request;
use App\Services\Ticketing\ProductCategoryService;
use App\Http\Requests\Ticketing\ProductCategory as ProductCategoryRequest;


class ProductCategoryController extends Controller
{
    public $ProductCategoryService;

    public function __construct(ProductCategoryService $ProductCategoryService)
    {
        $this->ProductCategoryService = $ProductCategoryService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->ProductCategoryService->getData();
        }
        return view('ticketing/productCategory');
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
    public function store(ProductCategoryRequest $request)
    {
        $this->ProductCategoryService->store($request);
        return \Response::success(["message"=>"Product Category Added"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Model\Ticketing\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Ticketing\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->ProductCategoryService->edit($id);
        return response()->json(["status" => "success", "data" => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Ticketing\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function update(ProductCategoryRequest $request, ProductCategory $productCategory)
    {
        $this->ProductCategoryService->update($request);
        return \Response::success(["message"=>"Product Category Updated"]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Ticketing\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->ProductCategoryService->destroy($id);
        return \Response::success(["message"=>"Product Category Deleted"]);
    }
}
