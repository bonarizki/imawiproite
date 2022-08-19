<?php

namespace App\Repository\Resignation\Clearance;

use App\Repository\Resignation\Clearance\Interfaces\ClearanceInterfaces;
use App\Model\Resignation\Clearance;
use App\Model\Resignation\ClearanceAnswer;
use Illuminate\Support\Facades\DB;

class ClearanceRepository implements ClearanceInterfaces
{
    public function getQuestionClearance()
    {
        return Clearance::with('Department')->get();
    }

    public function insertClearanceQuestion($request)
    {
        DB::transaction(function () use($request) {
            Clearance::create($request->except('_token'));
            \Helper::instance()->log('CREATE',$request,'App\Model\Resignation\Clearance');
        });
    }
    
    public function DetailClearanceQuestion($id)
    {
        return  Clearance::with('Department')->where('clearance_question_id',$id)->first();
    }
    
    public function updateClearanceQuestion($request)
    {
        DB::transaction(function () use($request) {
            \Helper::instance()->log('UPDATE',$request,'App\Model\Resignation\Clearance');
            Clearance::find($request->clearance_question_id)->update($request->except('_token'));
        });
    }

    public function deleteClearanceQuestion($request)
    {
        DB::transaction(function () use($request) {
            \Helper::instance()->log('DELETE',$request,'App\Model\Resignation\Clearance');
            Clearance::find($request->clearance_question_id)->delete();
        });
    }

    public function insertOrUpdateAnswer($request)
    {
        DB::transaction(function () use($request) {
            $data = ClearanceAnswer::updateOrCreate(
                ['resign_id' => $request->resign_id],
                $request->except('_token')
            );
            $type = $data->wasRecentlyCreated == true ? "CREATE" : "UPDATE"; // menenetukan tipe apakah update atau delete
            $newRequest = \Helper::instance()->MakeRequest($data->getOriginal()); //membuat data yang di insert menjadi request agar bisa digunakan di helper
            \Helper::instance()->log($type,$newRequest,'App\Model\Resignation\ClearanceAnswer');
        });
    }

    public function getAnswer($resign_id)
    {
        return ClearanceAnswer::where('resign_id',$resign_id)->first();
    }

    public function getDetailApprover($resign_id)
    {
        $query = "SELECT 		
                    resign_list.resign_approval_nik_clearance_hr,
                    user_hr.user_name as approval_name_hr,
                    resign_list.resign_approval_nik_clearance_it,
                    user_it.user_name as approval_name_it,
                    resign_list.resign_approval_nik_clearance_fa,
                    user_fa.user_name as approval_name_fa
                FROM mst_resignation_resign_list as resign_list
                    LEFT JOIN (SELECT 
                                user_name,user_nik
                            from mst_main_user) as user_hr
                        on resign_list.resign_approval_nik_clearance_hr = user_hr.user_nik
                    LEFT JOIN (SELECT 
                                    user_name,user_nik
                                from mst_main_user) as user_it
                        on resign_list.resign_approval_nik_clearance_it = user_it.user_nik
                    LEFT JOIN (SELECT 
                                    user_name,user_nik
                                from mst_main_user) as user_fa
                        on resign_list.resign_approval_nik_clearance_fa = user_fa.user_nik
                WHERE resign_list.resign_id = '".$resign_id."'";
        return DB::select($query)[0];
    }
}