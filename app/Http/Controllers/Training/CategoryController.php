<?php

namespace App\Http\Controllers\Training;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Training\CategoryService;
use App\Http\Requests\Training\CategoryRequest;

class CategoryController extends Controller
{
    private $CategoryService;

    public function __construct(CategoryService $CategoryService)
    {
        $this->CategoryService = $CategoryService;
    }

    public function show()
    {
        return $this->CategoryService->show();
    }

    public function create(CategoryRequest $request)
    {
        $this->CategoryService->create($request);
        return \Response::success(["message"=>"Category Add"]);
    }

    public function detail($id)
    {
        $data = $this->CategoryService->detail($id);
        return response()->json(["status" => "success", "data" => $data]);
    }

    public function update(CategoryRequest $request)
    {
        $this->CategoryService->update($request);
        return \Response::success(["message"=>"Category Updated"]);
    }

    public function destroy(CategoryRequest $request)
    {
        $this->CategoryService->destroy($request);
        return \Response::success(["message"=>"Category deleted"]);
    } 

}
