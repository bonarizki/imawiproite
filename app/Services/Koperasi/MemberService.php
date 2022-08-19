<?php

namespace App\Services\Koperasi;

use App\Repository\Koperasi\Member\Interfaces\MemberInterfaces;
use App\Repository\Dashboard\User\Interfaces\UserInterfaces;
use App\Helper\HelperService;
use Illuminate\Support\Facades\Auth;
use App\Imports\Koperasi\MemberUpload;
use Maatwebsite\Excel\Facades\Excel;

class MemberService 
{
    public $MemberInterfaces,$HelperService,$UserInterfaces;

    public function __construct(
        MemberInterfaces $MemberInterfaces,
        HelperService $HelperService,
        UserInterfaces $UserInterfaces
    )
    {
        $this->MemberInterfaces = $MemberInterfaces;
        $this->HelperService = $HelperService;
        $this->UserInterfaces = $UserInterfaces;
    }

    public function getUser()
    {
        $data = $this->MemberInterfaces->getMember();
        return $this->HelperService->DataTablesResponse($data);
    }

    public function store($request)
    {
        $request = $this->HelperService->addAuthInsert($request);
        return $this->MemberInterfaces->insert($request);
    }

    public function edit($id)
    {
        return $this->MemberInterfaces->edit($id);
    }

    public function update($request)
    {
        $request = $this->HelperService->addAuthUpdate($request);
        return $this->MemberInterfaces->update($request);
    }

    public function delete($request,$id)
    {
        $request = $request->merge([
            'member_id' => $id
        ]);
        return $this->MemberInterfaces->delete($request);
    }

    public function upload($request)
    {
        $import = new MemberUpload($this->MemberInterfaces);
        Excel::import($import, $request->file('file'), null, \Maatwebsite\Excel\Excel::XLSX);
        $data = Excel::toArray([], $request->file('file'));
        $rows = (int)$import->rows - 1 ; // dikurang 1 karean headingnya ikut terhitung
        unset($data[0][0]); // dihapus dulu array pertama karena itu header
        // dd($data[0],$import->success,$import->rows - 1,$import->fail);
        return $data = [
            "message"=>"Total Data = {$rows} , 
                        Success Upload = {$import->success}, 
                        Fail Upload = {$import->fail}",
            "dataTable"=>$this->HelperService->DataTablesResponse(($data[0])),
            "detailFail"=>$import->errors
        ];
    }
}