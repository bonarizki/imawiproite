<?php 

namespace App\Repository\Ticketing\TicketingType;

use App\Repository\Ticketing\TicketingType\Interfaces\TicketingTypeInterfaces;
use App\Model\Ticketing\TypeTicketing;
use Illuminate\Support\Facades\DB;

class TicketingTypeRepository implements TicketingTypeInterfaces
{
    public static function index()
    {
        return TypeTicketing::with('User')->get()->makeVisible(['updated_by','updated_at']);
    }

    public static function store($request)
    {
        return DB::transaction(function () use($request) {
            $data = TypeTicketing::create($request->except('_token'));
            $request->merge([
                "priority_id" => $data->type_id
            ]);
            \Helper::instance()->log('CREATE',$request,'App\Model\Ticketing\TypeTicketing');
        });
    }

    public static function edit($id)
    {
        return TypeTicketing::find($id);
    }

    public static function update($request)
    {
        return DB::transaction(function () use($request) {
            \Helper::instance()->log('UPDATE',$request,'App\Model\Ticketing\TypeTicketing');
            TypeTicketing::find($request->type_id)->update($request->except('_token'));
        });
    }

    public static function destroy($request)
    {
        return DB::transaction(function () use($request) {
            \Helper::instance()->log('DELETE',$request,'App\Model\Ticketing\TypeTicketing');
            TypeTicketing::find($request->type_id)->delete();
        });
    }

    public static function getTicketTypePIC($user_nik)
    {
        return TypeTicketing::select('type_id')
            ->where('agent_nik',$user_nik)
            ->pluck('type_id');
    }
}