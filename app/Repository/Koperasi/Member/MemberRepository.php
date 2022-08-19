<?php

namespace App\Repository\Koperasi\Member;

use App\Repository\Koperasi\Member\Interfaces\MemberInterfaces;
use App\Model\Koperasi\Member;
use Illuminate\Support\Facades\DB; 

class MemberRepository implements MemberInterfaces
{
    public static function getMember()
    {
        return Member::with(['User','User.Department'])
                    ->whereHas('User',function($q){
                        return $q->whereNull('deleted_at');
                    })->get();
    }

    public static function insert($request)
    {
        DB::transaction(function () use($request) {
            $data = Member::create($request->except('_token'));
            $request->merge([
                'member_id' => $data->member_id
            ]);
            \Helper::instance()->log('CREATE',$request,'App\Model\Koperasi\Member');
        });
    }

    public static function edit($id)
    {
        return Member::find($id);
    }

    public static function update($request)
    {
        return DB::transaction(function () use($request) {
            \Helper::instance()->log('UPDATE',$request,'App\Model\Koperasi\Member');
            Member::find($request->member_id)->update($request->except('_token'));
        });
    }

    public static function delete($request)
    {
        return DB::transaction(function () use($request) {
            \Helper::instance()->log('DELETE',$request,'App\Model\Koperasi\Member');
            Member::find($request->member_id)
                ->delete();
        });
    }

    public static function upload($request,$row)
    {
        return DB::transaction(function () use ($request,$row) {
            $New = Member::updateOrCreate(['user_nik'=>$request['user_nik']],$request);
            // dd($New);
            $NewRequest = \Helper::instance()->MakeRequest(
                array_merge(
                    ["member_id"=>$New->member_id],$request
                )
            );
            $type = $New->wasRecentlyCreated == true ? "CREATE" : "UPDATE"; // menenetukan tipe apakah update atau create
            \Helper::instance()->log($type,$NewRequest,'App\Model\Koperasi\Member');
        });
    }

    public static function checkMemberCode($member_code)
    {
        return Member::where('member_code',$member_code)
            ->where()
            ->exists();
    }
}