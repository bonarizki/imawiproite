<?php

namespace App\Repository\Dashboard\Grade;

use App\Repository\Dashboard\Grade\Interfaces\GradeInterfaces;
use App\Model\Grade;
use Illuminate\Support\Facades\DB;

class GradeRepository implements GradeInterfaces
{
    public function getAllGrade()
    {
        return Grade::all();
    }

    public function getGradeById($id)
    {
        return Grade::find($id);
    }

    public function updateGrade($request)
    {
        DB::transaction(function () use ($request) {
            \Helper::instance()->log('UPDATE',$request,'App\Model\Grade');
            Grade::find($request->grade_id)
                    ->update($request->except('_token'));
        });
    }

    public function deleteGrade($request)
    {
        DB::transaction(function () use ($request) {
            \Helper::instance()->log('DELETE',$request,'App\Model\Grade');
            Grade::find($request->grade_id)
                    ->delete();
        });
    }

    public function insertGrade($request)
    {
        DB::transaction(function () use ($request) {
            Grade::create($request->except('_token'));
            \Helper::instance()->log('CREATE',$request,'App\Model\Grade');
        });
    }

    public function getDataByName($nama)
    {
        return Grade::select('grade_id')
                    ->where('grade_name',$nama)
                    ->first();
    }
}