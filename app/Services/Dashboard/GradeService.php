<?php

namespace App\Services\Dashboard;

use App\Repository\Dashboard\Grade\Interfaces\GradeInterfaces;
use Illuminate\Support\Facades\Auth;
use App\Helper\HelperService;

class GradeService
{
    private $GradeInterfaces,$HelperService;

    public function __construct(GradeInterfaces $GradeInterfaces,HelperService $HelperService)
    {
        $this->GradeInterfaces = $GradeInterfaces;
        $this->HelperService = $HelperService;
    }

    public function getAllGrade()
    {
        $data = $this->GradeInterfaces->getAllGrade();
        return $this->HelperService->DataTablesResponse($data);
    }

    public function getGradeById($id)
    {
        return $this->GradeInterfaces->getGradeById($id);
    }

    public function updateGrade($request)
    {
        $request->merge(["updated_by"=>Auth::user()->user_name]);
        return $this->GradeInterfaces->updateGrade($request);
    }

    public function deleteGrade($request)
    {
        return $this->GradeInterfaces->deleteGrade($request);
    }

    public function insertGrade($request)
    {
        $request->merge(["created_by"=>Auth::user()->user_name,"updated_by"=>Auth::user()->user_name]);
        return $this->GradeInterfaces->insertGrade($request);
    }
}