<?php 

namespace App\Repository\Training\Vendor;

use App\Repository\Training\Vendor\Interfaces\VendorInterfaces;
use App\Model\Training\Vendor;
use Illuminate\Support\Facades\DB;

class VendorRepository implements VendorInterfaces
{
    public static function getAllData()
    {
        return Vendor::all();
    }

    public static function insert($request)
    {
        return DB::transaction(function () use ($request) {
            $data = Vendor::create($request->except('_token'));
            $request->merge([
                "vendor_id" => $data->vendor_id
            ]);
            \Helper::instance()->log('CREATE',$request,'App\Model\Training\Vendor');
        });
    }

    public static function getDetail($id)
    {
        return Vendor::find($id);
    }

    public static function update($request)
    {
        return DB::transaction(function () use ($request) {
            \Helper::instance()->log('UPDATE',$request,'App\Model\Training\Vendor');
            Vendor::find($request->vendor_id)->update($request->except('_token'));
        });
    }

    public static function destroy($request)
    {
        return DB::transaction(function () use($request) {
            \Helper::instance()->log('DELETE',$request,'App\Model\Training\Vendor');
            Vendor::find($request->vendor_id)->delete();
        });
    }

    public static function getBytype($vendor_type)
    {
        return Vendor::where('vendor_type',$vendor_type)->get();
    }

    public static function upload($request,$row)
    {
        return DB::transaction(function () use ($request,$row) {
            $New = Vendor::updateOrCreate(['vendor_name'=>$request['vendor_name']],$request);
            // dd($New);
            $NewRequest = \Helper::instance()->MakeRequest(
                array_merge(
                    ["vendor_id"=>$New->vendor_id],$request
                )
            );
            $type = $New->wasRecentlyCreated == true ? "CREATE" : "UPDATE"; // menenetukan tipe apakah update atau create
            \Helper::instance()->log($type,$NewRequest,'App\Model\Training\Vendor');
        });
    }
}