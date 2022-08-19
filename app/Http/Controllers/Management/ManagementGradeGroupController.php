<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\GradeGroupRequest;
use App\Services\Dashboard\GradeGroupService;

class ManagementGradeGroupController extends Controller
{
    private $GradeGroupService;

    public function __construct(GradeGroupService $GradeGroupService)
    {
        $this->GradeGroupService = $GradeGroupService;
    }
    public function index()
    {
        return view('management/gradeGroup');
    }

    public function AllGradeGroup()
    {
        return $this->GradeGroupService->getAllGradeGroup();
    }

    public function getGradeGroupById($id)
    {
        $data = $this->GradeGroupService->getGradeGroupById($id);
        return response()->json(["statu"=>"success","data"=>$data]);
    }

    public function updateGradeGroup(GradeGroupRequest $request)
    {
        $this->GradeGroupService->updateGradeGroup($request);
        return response()->json(["status"=>"success","message"=>"Grade Group Updated"]);
    }

    public function deleteGradeGroup(Request $request)
    {
        $this->GradeGroupService->deleteGradeGroup($request);
        return response()->json(["status"=>"success","message"=>"Grade Group Deleted"]);
    }

    public function insertGradeGroup(GradeGroupRequest $request){
        $this->GradeGroupService->insertGradeGroup($request);
        return response()->json(["status"=>"success","message"=>"Grade Group Added"]);
    }
}
