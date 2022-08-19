<?php

namespace App\Repository\Dashboard\GradeGroup;

use App\Repository\Dashboard\GradeGroup\Interfaces\GradeGroupInterfaces;
use App\Model\GradeGroup;
use Illuminate\Support\Facades\DB;

class GradeGroupRepository implements GradeGroupInterfaces
{
    public function getAllGradeGroup()
    {
        return GradeGroup::all();
    }

    public function getGradeGroupById($id)
    {
        return GradeGroup::find($id);
    }

    public function updateGradeGroup($request)
    {
        DB::transaction(function () use($request) {
            \Helper::instance()->log('UPDATE',$request,'App\Model\GradeGroup');
            GradeGroup::find($request->grade_group_id)
                            ->update($request->except('_token'));
        });
    }

    public function deleteGradeGroup($request)
    {
        DB::transaction(function () use($request) {
            \Helper::instance()->log('DELETE',$request,'App\Model\GradeGroup');
            GradeGroup::find($request->grade_group_id)
                            ->delete();
        });
    }

    public function insertGradeGroup($request)
    {
        DB::transaction(function () use($request)  {
            GradeGroup::create($request->except('_token'));
            \Helper::instance()->log('CREATE',$request,'App\Model\GradeGroup');
        });
    }
}