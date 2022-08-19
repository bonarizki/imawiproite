<?php

namespace App\Repository\Ticketing\Approve\Interfaces;

interface ApproveInterfaces
{
    public static function getDataApproval($user_nik);

    public static function getTicketingApporval($ticket_id);

    public static function approvePo($request);

    public static function getHeader($ticket_id);

    public static function getDetailPO($ticket_id);

    public static function updateStatusHeader($type);

}