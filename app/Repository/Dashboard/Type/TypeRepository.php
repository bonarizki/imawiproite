<?php

namespace App\Repository\Dashboard\Type;

use App\Repository\Dashboard\Type\Interfaces\TypeInterfaces;
use App\Model\Type;
use Illuminate\Support\Facades\DB;

class TypeRepository implements TypeInterfaces
{
    public function getAllType()
    {
        return Type::all();
    }

    public function getTypeById($id)
    {
        return Type::find($id);
    }

    public function updateType($request)
    {
        DB::transaction(function () use ($request) {
            \Helper::instance()->log('UPDATE',$request,'App\Model\Type');
            Type::find($request->type_id)
                ->update($request->except('_token'));
        });
    }

    public function deleteType($request)
    {
        DB::transaction(function () use($request) {
            \Helper::instance()->log('DELETE',$request,'App\Model\Type');
            Type::find($request->type_id)
                ->delete();
        });
    }

    public function insertType($request)
    {
        DB::transaction(function () use($request){
            \Helper::instance()->log('CREATE',$request,'App\Model\Type');
            Type::create($request->except('_token'));
        });
    }

    public function getDataByName($name)
    {
        return Type::select('type_id')
                    ->where('type_name',$name)
                    ->first();
    }
}