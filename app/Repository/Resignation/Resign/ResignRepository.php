<?php 

namespace App\Repository\Resignation\Resign;

use App\Model\Resignation\Resign;
use App\Model\User;
use App\Repository\Resignation\Resign\Interfaces\ResignInterfaces;
use Illuminate\Support\Facades\DB;
use App\Model\ApprovalMatrix;
use Illuminate\Support\Facades\Auth;

class ResignRepository implements ResignInterfaces
{

    public function getUser($request)
    {
        return User::where('user_email',$request->user_email)
                    ->where('user_nik',$request->user_nik)
                    ->first();
    }

    public function insertResign($request)
    {
        $data = '';
        DB::transaction(function () use($request,&$data) {
            $data = Resign::create($request->except('_token'));
            \Helper::instance()->log('CREATE',$request,'App\Model\Resignation\Resign');
        });
        return $data;
    }

    public function DataApprovalMatrix($user_nik)
    {
        return ApprovalMatrix::where('user_nik',$user_nik)->first();
    }

    public function getLastId()
    {
        return Resign::latest()->first();
    }

    public function updateResign($request)
    {
        DB::transaction(function () use($request) {
            \Helper::instance()->log("UPDATE",$request,"App\Model\Resignation\Resign");
            Resign::find($request->resign_id)->update($request->except('_token'));
        });
    }
    
}