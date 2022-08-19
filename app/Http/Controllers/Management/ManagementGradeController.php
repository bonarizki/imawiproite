<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Model\Grade;
use App\Http\Requests\GradeRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Services\Dashboard\GradeService;
class ManagementGradeController extends Controller
{
    private $GradeService;
    
    public function __construct(GradeService $GradeService)
    {
        $this->GradeService = $GradeService;
    }

    public function index()
    {
        return view('management/grade');
    }

    public function AllGrade()
    {
        return $this->GradeService->getAllGrade();
        
    }

    public function getGradeById($id)
    {
        $data = $this->GradeService->getGradeById($id);
        return response()->json(["statu"=>"success","data"=>$data]);
    }

    public function updateGrade(GradeRequest $request)
    {
        $this->GradeService->updateGrade($request);
        return response()->json(["status"=>"success","message"=>"Grade Updated"]);
    }

    public function deleteGrade(Request $request)
    {
        $this->GradeService->deleteGrade($request);
        return response()->json(["status"=>"success","message"=>"Grade Deleted"]);
    }

    public function insertGrade(GradeRequest $request){
        $this->GradeService->insertGrade($request);
        return response()->json(["status"=>"success","message"=>"Grade Added"]);
    }
}
