<?php

namespace App\Services\Dashboard;
use App\Repository\Dashboard\Title\Interfaces\TitleInterfaces;
use Illuminate\Support\Facades\Auth;
use App\Helper\HelperService;

class TitleService
{
    private $TitleInterfaces,$HelperService;

    public function __construct(TitleInterfaces $TitleInterfaces,HelperService $HelperService)
    {
        $this->TitleInterfaces = $TitleInterfaces;
        $this->HelperService = $HelperService;
    }

    public function getAllTitle()
    {
        $data = $this->TitleInterfaces->getAllTitle();
        return $this->HelperService->DataTablesResponse($data);
    }

    public function getTitleById($id)
    {
        return $this->TitleInterfaces->getTitleById($id);
    }

    public function updateTitle($request)
    {
        $request->merge(["updated_by"=>Auth::user()->user_name]);
        return $this->TitleInterfaces->updateTitle($request);
    }

    public function deleteTitle($request)
    {
        return $this->TitleInterfaces->deleteTitle($request);
    }

    public function insertTitle($request)
    {
        $request->merge(["created_by"=>Auth::user()->user_name,"updated_by"=>Auth::user()->user_name]);
        return $this->TitleInterfaces->insertTitle($request);
    }
}