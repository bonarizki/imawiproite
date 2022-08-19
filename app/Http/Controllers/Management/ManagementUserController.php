<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Services\Dashboard\UserService;
use App\Helper\HelperService;
class ManagementUserController extends Controller
{
    private $UserService,$HelperService;

    public function __construct(UserService $UserService, HelperService $HelperService)
    {
        $this->UserService = $UserService;
        $this->HelperService = $HelperService;
    }
    public function index()
    {
        $data = $this->UserService->HandleIndex();
        $module = $data['module'];
        $menu = $data['menu'];
        $menu_child = $data['menu_child'];
        $menu_grand_child = $data['menu_grand_child'];
        return view('management/user', compact('module', 'menu', 'menu_child', 'menu_grand_child'));
    }

    public function getAllUser(Request $request)
    {   
        return $this->UserService->getAllUser($request);
    }

    public function deleteUser(Request $request)
    {
        $this->UserService->deleteUser($request);
        return response()->json(["status" => "success", "message" => "user deleted"], 200);
    }

    public function getDeleteUser()
    {
        return $this->UserService->getDeleteUser();
    }

    public function restoreUser(Request $request)
    {
        $this->UserService->restoreUser($request);
        return response()->json(["status" => "success", "message" => "user restored"], 200);
    }

    public function getUserById($user_id)
    {
        $user = $this->UserService->getUserById($user_id); 
        return response()->json(["status" => "success", "data" => $user]);
    }

    public function updateUser(UserRequest $request)
    {
        $this->UserService->updateUser($request);
        return response()->json(["status" => "success", "message" => "User updated"]);
    }

    public function insertUser(UserRequest $request)
    {
        $this->UserService->insertUser($request);
        return response()->json(["status" => "success", "message" => "User Inserted"]);
    }

    public function getAllOption()
    {
        $data = $this->UserService->getAllOption();
        return response()->json(["data" => ["grade" => $data['grade'], "type" => $data['type'], "title" => $data['title'], "department" => $data['department'] ]]);
    }

    public function getUserAccess(Request $request)
    {
        $access = $this->UserService->getUserAccess($request);
        return response()->json($access);
    }

    public function saveUserAccess(Request $request)
    {
        $this->UserService->saveUserAccess($request);
        return response()->json(["status" => "success", "message" => "User Access Updated"], 200);
    }

    public function uploadUser(Request $request)
    {
        $data = $this->UserService->userUploadProcess($request);
        $data["result"] = $this->HelperService->DataTablesResponse($data["result"]);
        return response()->json(["status" => "success","data"=>$data['result'],"failValidasi"=>$data["dataFail"],"successValidasi"=>$data['dataSuccess']]);
    }

    public function downloadUser()
    {
        return $this->UserService->download();
    }

    public function UploadUserSave(Request $request)
    {
        $message = $this->UserService->userUploadSave($request);
        return response()->json(["status" => "success", "data" =>["message"=>$message] ]);
    }

    public function RefreshPassword(Request $request)
    {
        $this->UserService->RefreshPassword($request);
        return response()->json(["status" => "success", "data" =>["message"=>"Password Refresh Success"] ]);
    }
}
