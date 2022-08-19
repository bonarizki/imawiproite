<?php

namespace App\Repository\Koperasi\Banner;

use App\Repository\Koperasi\Banner\Interfaces\BannerInterfaces;
use App\Model\Koperasi\Banner;
use Illuminate\Support\Facades\DB;

class BannerRepository implements BannerInterfaces
{
    public static function getAllData()
    {
        return Banner::get()
            ->makeVisible(['updated_at','updated_by']);;
    }

    public static function addBanner($request)
    {
        return DB::transaction(function () use($request) {
            $data = Banner::create($request->except('_token'));
            $request->merge([
                "banner_id" => $data->banner_id,
            ]);
            \Helper::instance()->log('CREATE',$request,'App\Model\Koperasi\Banner');
        });
    }

    public static function delete($request)
    {
        return DB::transaction(function () use($request) {
            \Helper::instance()->log('DELETE',$request,'App\Model\Koperasi\Banner');
            Banner::find($request->banner_id)
                ->delete();
        });
    }

    public static function edit($id)
    {
        return Banner::find($id);
    }

    public static function update($request)
    {
        dd($request);
        return DB::transaction(function () use($request) {
            \Helper::instance()->log('UPDATE',$request,'App\Model\Koperasi\Banner');
            Banner::find($request->banner_id)
                ->update($request->except('_token'));
        });
    }
}