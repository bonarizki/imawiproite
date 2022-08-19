<?php

namespace App\Repository\Ticketing\RequestTicketing\Interfaces;

interface RequestTicketingInterfaces
{
    public static function createHeader($header_data);

    public static function getLastId();

    public static function insertDetailPo($data);

    public static function insertApproval($data);

    public static function GetApprovalRequest($ticket_id);

    public static function insertDetailRequestUser($request);

    public static function insertDetailRequestCRA($request);

}