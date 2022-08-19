<?php

namespace App\Repository\Ticketing\Approve;

use App\Repository\Ticketing\Approve\Interfaces\ApproveInterfaces;
use App\Model\Ticketing\RequestTicketingApproval as Approve;
use App\Model\Ticketing\RequestTicketingHeader as Header;
use App\Model\Ticketing\RequestTicketingDetailPo  as Detail;
use Illuminate\Support\Facades\DB;

class ApproveRepository implements ApproveInterfaces
{
    public static function getDataApproval($user_nik)
    {
        $query = Header::With([
            'Type',
            'Priority',
            'Period',
            'RequestBy',
            'Approval',
            'DetailPo',
            'DetailRequestAccessUser',
            'DetailRequestCra',
            'DetailPo.Comparison',
            'DetailPo.SubCategory'
        ])
            ->whereIn('ticket_status', ['process', 'initial'])
            ->whereHas('Approval', function ($q) use ($user_nik) {
                $q->where('ticketing_approval_nik_1', $user_nik)
                    ->orWhere('ticketing_approval_nik_2', $user_nik)
                    ->orWhere('ticketing_approval_nik_3', $user_nik)
                    ->orWhere('ticketing_approval_nik_4', $user_nik)
                    ->orWhere('ticketing_approval_nik_5', $user_nik)
                    ->orWhere('ticketing_approval_nik_6', $user_nik)
                    ->orWhere('ticketing_approval_nik_it1', $user_nik)
                    ->orWhere('ticketing_approval_nik_it2', $user_nik);
            })
            ->orderBy('ticket_id', 'desc');
        return $query->get()->makeVisible('created_at');
    }


    public static function getTicketingApporval($ticket_id)
    {
        return Approve::where('ticket_id', $ticket_id)->first();
    }

    public static function approvePo($request)
    {
        return DB::transaction(function () use ($request) {
            \Helper::instance()->log('UPDATE', $request, 'App\Model\Ticketing\RequestTicketingApproval');
            Approve::find($request->ticketing_approval_id)
                ->update($request->except('_token'));
        });
    }

    public static function getHeader($ticket_id)
    {
        return Header::find($ticket_id);
    }

    public static function getDetailPO($ticket_id)
    {
        return Detail::where('ticket_id', $ticket_id)->get()->toArray();
    }

    public static function updateStatusHeader($request)
    {
        DB::transaction(function () use ($request) {
            \Helper::instance()->log('UPDATE', $request, 'App\Model\Ticketing\RequestTicketingHeader');
            Header::find($request->ticket_id)
                ->update($request->toArray());
        });
    }
}
