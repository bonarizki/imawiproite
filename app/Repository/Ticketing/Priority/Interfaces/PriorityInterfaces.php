<?php

namespace App\Repository\Ticketing\Priority\Interfaces;

interface PriorityInterfaces 
{
    public static function index();
    public static function store($request);
    public static function edit($request);
    public static function update($request);
    public static function destroy($request);
}