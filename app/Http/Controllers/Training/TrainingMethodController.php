<?php

namespace App\Http\Controllers\Training;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Training\TrainingMethodService;
use App\Http\Requests\Training\MethodRequest;

class TrainingMethodController extends Controller
{
    public $TrainingMethodService;

    public function __construct(TrainingMethodService $TrainingMethodService)
    {
        $this->TrainingMethodService = $TrainingMethodService;
    }

    public function show()
    {
        return $this->TrainingMethodService->show();
    }

    public function create(MethodRequest $request)
    {
        $this->TrainingMethodService->create($request);
        return \Response::success(["message"=>"Method Add"]);
    }

    public function detail($id)
    {
        $data = $this->TrainingMethodService->detail($id);
        return response()->json(["status" => "success", "data" => $data]);
    }

    public function update(MethodRequest $request)
    {
        $this->TrainingMethodService->update($request);
        return \Response::success(["message"=>"Method Updated"]);
    }

    public function destroy(MethodRequest $request)
    {
        $this->TrainingMethodService->destroy($request);
        return \Response::success(["message"=>"Method deleted"]);
    } 
}
