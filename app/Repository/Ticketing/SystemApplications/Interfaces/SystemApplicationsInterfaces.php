<?php

namespace App\Repository\Ticketing\SystemApplications\Interfaces;

interface SystemApplicationsInterfaces 
{
    public static function getAllData();
    public static function insert($request);
    public static function update($request);
    public static function edit($id);
    public static function destroy($request);
    public static function getPIC($system_name);
}