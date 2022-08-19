<?php 

namespace App\Services\Dashboard;

use App\Repository\Dashboard\GradeGroup\Interfaces\GradeGroupInterfaces;
use Illuminate\Support\Facades\Auth;
use App\Helper\HelperService;

class GradeGroupService
{
    private $GradeGroupInterfaces,$HelperService;

    public function __construct(GradeGroupInterfaces $GradeGroupInterfaces,HelperService $HelperService)
    {
        $this->GradeGroupInterfaces = $GradeGroupInterfaces;
        $this->HelperService = $HelperService;
    }

    public function getAllGradeGroup()
    {
        $data = $this->GradeGroupInterfaces->getAllGradeGroup();
        return $this->HelperService->DataTablesResponse($data);
    }

    public function getGradeGroupById($id)
    {
        return $this->GradeGroupInterfaces->getGradeGroupById($id);
    }

    public function updateGradeGroup($request)
    {
        $request->merge(["updated_by"=>Auth::user()->user_name]);
        return $this->GradeGroupInterfaces->updateGradeGroup($request);
    }

    public function deleteGradeGroup($request)
    {
        return $this->GradeGroupInterfaces->deleteGradeGroup($request);
    }

    public function insertGradeGroup($request)
    {
        $request->merge(["created_by"=>Auth::user()->user_name,"updated_by"=>Auth::user()->user_name]);
        return $this->GradeGroupInterfaces->insertGradeGroup($request);
    }
}