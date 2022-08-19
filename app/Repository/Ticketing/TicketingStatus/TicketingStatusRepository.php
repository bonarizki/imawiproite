<?php

namespace App\Repository\Ticketing\TicketingStatus;

use App\Repository\Ticketing\TicketingStatus\Interfaces\TicketingStatusInterfaces;
use App\Model\Ticketing\RequestTicketingHeader as Header;
use App\Model\Ticketing\RequestTicketingDetailCRA as CRA;
use Illuminate\Support\Facades\DB;

class TicketingStatusRepository implements TicketingStatusInterfaces
{

    /**
     * [Description for getDataTicket]
     *
     * @param mixed $request
     * @param mixed $status is array from status type
     * 
     * @return [result query as object]
     * 
     */
    public static function getDataTicket($request, $status)
    {
        // dd($request->all());
        $query = Header::With(['Type', 'Priority', 'Period', 'RequestBy.Department', 'Approval', 'DetailPo.SubCategory',]);

        if ($request->department_id != null) $query->whereHas('RequestBy.Department', function ($q) use ($request) {
            $q->where('department_id', $request->department_id);
        });

        if ($request->ticket_status != null) {
            $query->where('ticket_status', $request->ticket_status);
        } else {
            $query->whereIN('ticket_status', $status);
    };

        if ($request->user_nik_auth != null) $query->where('user_ticketing_request', $request->user_nik_auth);

        if ($request->period_id != null) $query->where('period_id', $request->period_id);

        if ($request->type_id != null) $query->where('type_id', $request->type_id);

        return $query->orderBy('created_at', 'desc')
            ->get()
            ->makeVisible(['created_at','updated_at','updated_by']);
    }

    public static function CancelTicketing($request)
    {
        DB::transaction(function () use ($request) {
            \Helper::instance()->log('UPDATE', $request, 'App\Model\Ticketing\RequestTicketingHeader');
            Header::where('ticket_id', $request->ticket_id)
                ->update($request->except('_token'));
        });
    }

    public static function GetDetailTicketing($ticket_id)
    {
        return Header::With([
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
            ->where('ticket_id', $ticket_id)
            ->first()
            ->makeVisible('created_at');
    }

    public static function updateStatus($request)
    {
        DB::transaction(function () use ($request) {
            \Helper::instance()->log('UPDATE', $request, 'App\Model\Ticketing\RequestTicketingHeader');
            Header::where('ticket_id', $request->ticket_id)
                ->update($request->except('_token'));
        });
    }

    public static function updateDetailTicket($request)
    {
        DB::transaction(function () use ($request) {
            \Helper::instance()->log('UPDATE', $request, 'App\Model\Ticketing\RequestTicketingDetailCRA');
            CRA::find($request->cra_id)
                ->update($request->except('_token'));
        });
    }
}
