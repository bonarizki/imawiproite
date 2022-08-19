<?php 

namespace App\Repository\Dashboard\User\Interfaces;

interface UserInterfaces
{
    public static function getAllUser($request);

    public static function deleteUser($request);

    public static function getDeleteUser();

    public static function restoreUser($request);

    public static function getUserById($user_id);

    public static function updateUser($request);

    public static function insertUser($request,$data);

    public static function getUserAccess($request);

    public static function saveUserAccess($request,$module,$menu);

    public static function getUserByNik($user_nik); // get user by nik with return first()

    public static function getAlluserApproval();

    public static function getDataProfile($nik);

    public static function getUserByDepartment($department_id);

    public static function getUserByNikGet($data); // get user by nik with return get()

    public static function getUserUnderGradeGroup($department_id,$grade_group_id);

    public static function AccessRegven();

    public static function getHRHead();

    public static function updateUserAccess($NewRequest,$data);

    public static function checkUserHEAD($request);
}