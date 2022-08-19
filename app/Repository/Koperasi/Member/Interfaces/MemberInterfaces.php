<?php 

namespace App\Repository\Koperasi\Member\Interfaces;

interface MemberInterfaces
{
    public static function getMember();

    public static function insert($request);

    public static function edit($id);

    public static function update($request);

    public static function delete($request);

    public static function upload($request,$row);

    public static function checkMemberCode($member_code);
}