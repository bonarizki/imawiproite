<?php

namespace App\Repository\Ticketing\ApprovalType\Interfaces;

interface ApprovalTypeInterfaces 
{
    public static function index();
    public static function store($request);
    public static function edit($request);
    public static function update($request);
    public static function destroy($request);
}