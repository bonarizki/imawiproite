<?php

namespace App\Repository\Ticketing\TicketingType\Interfaces;

interface TicketingTypeInterfaces
{
    public static function index();
    public static function store($request);
    public static function edit($request);
    public static function update($request);
    public static function destroy($request);
    public static function getTicketTypePIC($user_nik);
}