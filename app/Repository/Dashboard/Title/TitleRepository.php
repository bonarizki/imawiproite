<?php

namespace App\Repository\Dashboard\Title;

use App\Repository\Dashboard\Title\Interfaces\TitleInterfaces;
use App\Model\Title;
use Illuminate\Support\Facades\DB;

class TitleRepository implements TitleInterfaces
{
    public function getAllTitle()
    {
        return Title::all();
    }

    public static function getTitleById($id)
    {
        return Title::find($id);
    }

    public function updateTitle($request)
    {
        DB::transaction(function () use ($request) {
            \Helper::instance()->log('UPDATE',$request,'App\Model\Title');
            Title::find($request->title_id)
                    ->update($request->except('_token'));
        });
    }

    public function deleteTitle($request)
    {
        DB::transaction(function () use($request) {
            \Helper::instance()->log('DELETE',$request,'App\Model\Title');
            Title::find($request->title_id)
                    ->delete();
            
        });
    }

    public function insertTitle($request)
    {
        DB::transaction(function () use($request) {
            Title::create($request->except('_token'));
            \Helper::instance()->log('CREATE',$request,'App\Model\Title');
        });
    }
    
    public function getDataByName($name)
    {
        return Title::select('title_id')
                        ->where('title_name',$name)
                        ->first();
    }


}