<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\Dashboard\ProfileService;
use App\Http\Requests\ProfileRequest;

class ProfileControlller extends Controller
{
    private $ProfileService;

    public function __construct(ProfileService $ProfileService)
    {
        $this->ProfileService = $ProfileService;
    }

    public function getDataProfile($nik)
    {
        $data = $this->ProfileService->getDataProfile($nik);
        return \Response::success(["profile"=>$data]);
    }

    public function updateProfile(ProfileRequest $profileRequest)
    {
        $this->ProfileService->updateProfile($profileRequest);
        return \Response::success(["message"=>"Profile Updated"]);
    }

    public function updatePassword(Request $request)
    {
        $this->ProfileService->updatePassword($request);
        return \Response::success(["message"=>"Password Changed"]);
    }
}
