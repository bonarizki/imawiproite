<?php

namespace App\Http\Controllers\Koperasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Koperasi\MemberService;
use App\Http\Requests\Koperasi\MemberRequest;

class MemberController extends Controller
{
    public $MemberService;

    public function __construct(MemberService $MemberService)
    {
        $this->MemberService = $MemberService;
    }

    public function index(Request $request)
    {
        if($request->ajax()){
            return $this->MemberService->getUser();
        }

        return view('koperasi/member');
    }

    public function store(MemberRequest $request)
    {
        $this->MemberService->store($request);
        return \Response::success(["status"=>"success","message" => "Member Added"]);
    }

    public function edit(Request $request,$id)
    {
        $data = $this->MemberService->edit($id);
        return \Response::success($data);
    }

    public function update(MemberRequest $request)
    {
        $this->MemberService->update($request);
        return \Response::success(["status"=>"success","message" => "Member Updated"]);
    }

    public function destroy(Request $request,$id)
    {
        $this->MemberService->delete($request,$id);
        return \Response::success(["status"=>"success","message" => "Member Deleted"]);
    }

    public function upload(Request $request)
    {
        $data = $this->MemberService->upload($request);
        return \Response::success([
            "message"=>"Upload Success",
            "data"=>$data,
        ]);
    }
}
