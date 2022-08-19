<?php

namespace App\Repository\Ticketing\TicketingStatus\Interfaces;

interface TicketingStatusInterfaces
{

    public static function GetDetailTicketing($id); // detail ticketing

    public static function CancelTicketing($request); // cancel ticketing

    // public static function GetAllTicketing($period_id); // semua data ticketing berdasarkan periode id

    public static function updateStatus($request);

    public static function getDataTicket($request, $status);

    public static function updateDetailTicket($request);
}
