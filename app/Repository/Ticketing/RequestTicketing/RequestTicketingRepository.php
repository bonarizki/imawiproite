<?php

namespace App\Repository\Ticketing\RequestTicketing;

use App\Repository\Ticketing\RequestTicketing\Interfaces\RequestTicketingInterfaces;
use App\Model\Ticketing\RequestTicketingHeader;
use App\Model\Ticketing\RequestTicketingDetailPo;
use App\Model\Ticketing\RequestTicketingApproval;
use App\Model\Ticketing\RequestTicketingUser;
use App\Model\Ticketing\RequestTicketingDetailCRA;
use Illuminate\Support\Facades\DB;

class RequestTicketingRepository implements RequestTicketingInterfaces
{
    public static function createHeader($header_data)
    {
        return RequestTicketingHeader::create($header_data);
    }

    public static function getLastId()
    {
        return RequestTicketingHeader::latest()->first();
    }

    public static function insertDetailPo($data)
    {
        return RequestTicketingDetailPo::insert($data);
    }

    public static function insertApproval($data)
    {
        return RequestTicketingApproval::create($data);
    }

    public static function GetApprovalRequest($ticket_id)
    {
        return RequestTicketingApproval::where('ticket_id', $ticket_id)->first();
    }

    public static function insertDetailRequestUser($data)
    {
        return RequestTicketingUser::insert($data);
    }

    public static function insertDetailRequestCRA($data)
    {
        return RequestTicketingDetailCRA::create($data->except('_token'));
    }
}
