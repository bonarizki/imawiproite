<?php

namespace App\Services\Dashboard;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use App\Repository\Dashboard\User\Interfaces\UserInterfaces as UI;
use App\Repository\Dashboard\Menu\Interfaces\MenuInterfaces as MI;
use App\Repository\Dashboard\Grade\Interfaces\GradeInterfaces as GI;
use App\Repository\Dashboard\Type\Interfaces\TypeInterfaces as TI;
use App\Repository\Dashboard\Title\Interfaces\TitleInterfaces as TitleInt;
use App\Repository\Dashboard\Department\Interfaces\DepartmentInterfaces as DI;
use App\Repository\Dashboard\Module\Interfaces\ModuleInterfaces as MOI;
use App\Repository\Dashboard\ApprovalMatrix\Interfaces\ApprovalMatrixInterfaces as AMI;
use App\Repository\Dashboard\AgeCategory\Interfaces\AgeCategoryInterfaces;
use App\Helper\HelperService;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\userExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Events\Dashboard\NewUserEvent;
use App\Model\User;
use Exception;

class UserService
{
    private $UserInterfaces;
    private $MenuInterfaces;
    private $ModuleInterfaces;
    private $HelperService;
    private $GI;
    private $TI;
    private $TitleInt;
    private $DI;
    private $request;
    private $ApprovalMatrixInterfaces;
    private $AgeCategoryInterfaces;

    public function __construct(UI $UI, MI $MI, MOI $MOI, HelperService $HelperService, GI $GI, TI $TI, TitleInt $TitleInt, DI $DI, Request $request, AMI $AMI,AgeCategoryInterfaces $AgeCategoryInterfaces)
    {
        $this->UserInterfaces = $UI;
        $this->MenuInterfaces = $MI;
        $this->ModuleInterfaces = $MOI;
        $this->HelperService = $HelperService;
        $this->GI = $GI;
        $this->TI = $TI;
        $this->TitleInt = $TitleInt;
        $this->DI = $DI;
        $this->request = $request;
        $this->ApprovalMatrixInterfaces = $AMI;
        $this->AgeCategoryInterfaces = $AgeCategoryInterfaces;
    }

    public function HandleIndex()
    {
        $data['module'] = $this->ModuleInterfaces->getAllModuleActive();
        $data['menu'] =  $this->MenuInterfaces->getAllMenu();
        $data['menu_child'] = $this->MenuInterfaces->getAllMenuChild();
        $data['menu_grand_child'] = $this->MenuInterfaces->getAllMenuGrandChild();

        return $data;
    }

    public function getAllUser($request)
    {
        $data = $this->UserInterfaces->getAllUser($request);
        return $this->HelperService->DataTablesResponse($data);
    }

    public function deleteUser($request)
    {
        return $this->UserInterfaces->deleteUser($request);
    }

    public function getDeleteUser()
    {
        $data = $this->UserInterfaces->getDeleteUser();
        return $this->HelperService->DataTablesResponse($data);
    }

    public function restoreUser($request)
    {
        return $this->UserInterfaces->restoreUser($request);
    }

    public function getUserById($user_id)
    {
        return $this->UserInterfaces->getUserById($user_id);
    }

    public function updateUser($request)
    {
        $request = $this->UserStatus($request);
        $this->checkType($request);
        $request->request->remove('type');
        return $this->UserInterfaces->updateUser($request);
    }

    public function checkType($request)
    {
        if ($request->user_type != 'user') {
            $user = User::where('user_type',$request->user_type)->first();
            if ($user != null) {
                User::find($user->user_id)
                    ->update(['user_type' => 'user']);
            }
        }
    }

    public function insertUser($request)
    {
        $request = $this->UserStatus($request);
        $array = [
            "created_by" => Auth::user()->user_name,
            "updated_by" => Auth::user()->user_name,
            "password" => md5(sha1(md5('unzavitalis'))), //default pass "unzavitalis";
        ];
        $request->merge($array);
        $request->request->remove('type');
        $data = $this->ArrayModelAccess();
        $this->UserInterfaces->insertUser($request, $data);

        try {
            event(new NewUserEvent($request));
        } catch (\Throwable $th) {
            throw new Exception("Can't Send Mail");
        }
    }

    //array  model untuk modul access dan module acces position
    //jika ada penambahan modul baru tinggal masukan saja nama model
    //kedalam array access dan position
    public function ArrayModelAccess()
    {
        return [
            ["access" => "App\Model\UserAccess", "position" => "App\Model\UserAccessPosition"],
            ["access" => "App\Model\COBC\Access", "position" => "App\Model\COBC\AccessPosition"],
            ["access" => "App\Model\Resignation\Access", "position" => "App\Model\Resignation\AccessPosition"],
            ["access" => "App\Model\Recruitment\Access", "position" => "App\Model\Recruitment\AccessPosition"],
            ["access" => "App\Model\Training\Access", "position" => "App\Model\Training\AccessPosition"],
            ["access" => "App\Model\Koperasi\Access", "position" => "App\Model\Koperasi\AccessPosition"],
            ["access" => "App\Model\Appraisal\Access", "position" => "App\Model\Appraisal\AccessPosition"],
            ["access" => "App\Model\Ticketing\Access", "position" => "App\Model\Ticketing\AccessPosition"],
        ];
    }

    public function getAllOption()
    {
        $data['grade'] = $this->GI->getAllGrade();
        $data['type'] = $this->TI->getAllType();
        $data['title'] = $this->TitleInt->getAllTitle();
        $data['department'] = $this->DI->getAllDepartment();
        return $data;
    }

    public function getUserAccess($request)
    {
        return $this->UserInterfaces->getUserAccess($request);
    }

    public function saveUserAccess($request)
    {
        $data = $this->HelperService->Module($request);
        return $this->UserInterfaces->saveUserAccess($request, $data['module'], $data['menu']);
    }

    public function UserStatus($request)
    {
        if ($request->user_status == null || $request->user_status == 0) {
            $request->merge(['user_status' => 0]);
        } else {
            $request->user_status = 1;
        }

        return $request;
    }

    public function userUploadProcess($request)
    {
        $file = $request->file('file_upload');
        $data = Excel::toArray([], $file);
        $this->validateTemplate($data[0][0]);
        $array = $this->validasiDataUpload($data[0]);
        $response['result'] = $this->changeKeysIndex($array, $data[0][0]);
        $response['dataFail'] = '0';
        for ($i = 0; $i < count($response['result']); $i++) {
            // melakukan pencarian data yang gagal dengan membaca index errror
            if (array_search("error", $response['result'][$i]) == true) $response['dataFail'] = $response['dataFail'] + 1;
        }
        $response['dataSuccess'] = count($array) - $response['dataFail'];
        return $response;
    }

    //validasi apakah template sesuai dengan yang sudah di tentukan atau tidak
    public function validateTemplate($data)
    {
        $key = [
            "NIK",
            "Name",
            "Email",
            "Mobile Number",
            "Birth City",
            "Birth Date",
            "Age Category",
            "Gender",
            "Join Date",
            "Department",
            "Grade",
            "Grade Group",
            "Title",
            "Type",
            "Approval Nik 1",
            "Approval Nik 2",
            "Approval Nik 3",
            "Approval Nik 4",
            "Approval Nik 5",
            "Approval Nik 6",
        ];
        $diff = array_diff($key, $data);
        if (!empty($diff)) {
            abort(500, 'Use Template');
        }
        return true;
    }

    // melakukan validasi dari tiap field excel null atau tidak
    public function validasiDataUpload($data)
    {
        $array = [];
        for ($i = 1; $i < count($data); $i++) { // loopung array , i=1 karena i=0 itu header
            $message = [];
            $checkNull = [];
            for ($x = 0; $x < count($data[$i]); $x++) { //loopin index dari array
                if (!isset($data[$i][$x]) || $data[$i][$x] == null) { // jika ada index maka di chek
                    if ($x < 15 && $x != 6 && $x != 11) {
                        array_push($checkNull, $x); //x = index, menyimpan index yang null 
                        $data[$i] = array_merge($data[$i], ["validasi" => "error"]); // membuat index validasi error data
                        $message[] = ["row" => $i + 1, "error_field" => $data[0][$x]];
                    }
                }

                if (!isset($data[$i]['validasi'])) {
                    $data[$i] = array_merge($data[$i], ["validasi" => "valid"]);
                }
            }
            $data[$i] = array_merge($data[$i], ["message" => $message]);
            //jika checknull >= 13 maka array itu null sebenarnya maka harus di hapus dengan unset
            if (count($checkNull) >= 15) unset($data[$i]);
            //jika checknull != 13 maka array di masukan ke dalam array baru untuk di return
            if (count($checkNull) != 15) $array[] = $data[$i];
        }
        return $array;
    }

    public function download()
    {
        return Excel::download(new userExport($this->UserInterfaces, $this->request,$this->AgeCategoryInterfaces), 'user.xlsx');
    }

    //merubah key index from number to string
    public function changeKeysIndex($data, $keys)
    {
        for ($i = 0; $i < count($data); $i++) {
            for ($x = 0; $x < count($keys); $x++) {
                if ($x == '5' or $x == '8') $data[$i][$x] = $this->transformDate($data[$i][$x]); //merubah format date dari excel ke format date php
                if ($x == '3') $data[$i][$x] = $this->HelperService->removeCharSpasi($data[$i][$x]); // menghapus - dan space pada nomor hp
                $data[$i][$this->HelperService->lowerAndReplace($keys[$x])] = $data[$i][$x] == NULL ? NULL : trim($data[$i][$x]);
                unset($data[$i][$x]);
            }
        }
        return $data;
    }

    public function userUploadSave($request)
    {
        $message = [];
        $data = $this->userUploadProcess($request)['result']; //result karena datanya ada di dalam result
        $array = $this->splitArray($data); // memisahkan array dan membuat jadi dua yaitu approval dan user
        $array = $this->changeKeysDB($array); // merubah index yang ada di dalam array approval dan user sesuai db
        $array["user"] = $this->validateID($array["user"]); //melakuan validasi ke database untuk mengecek apakah data benar atau tidak
        DB::transaction(function () use ($array, &$message) {
            $message = $this->loopingInsertUser($array["user"]); //data yang dikirim bentuk array dan ada messagenya
            $this->loopingInsertApproval($array["approval"], $message);
        });
        return $message;
    }

    public function loopingInsertApproval($data, $message)
    {
        DB::transaction(function () use ($data, $message) {
            foreach ($data as $item) {
                $item = array_merge($item, ["approval_nik_hr" => "45121101", "approval_nik_ceo" => "75101908"]);
                if ($message[$item["user_nik"]] == null) { //jika message dari user nik null lakukan insert / update
                    $NewRequest = \Helper::instance()->MakeRequest($item);
                    $approval = $this->ApprovalMatrixInterfaces->getApprovalByNik($NewRequest->user_nik);
                    if ($approval == null) {
                        $NewRequest->merge(["created_by" => Auth::user()->user_name]);
                        $this->ApprovalMatrixInterfaces->insertApprovalUser($NewRequest);
                    } else {
                        $NewRequest->merge([
                            "approval_id" => $approval->approval_id,
                            "updated_by" => Auth::user()->user_name
                        ]);
                        $this->ApprovalMatrixInterfaces->updateApprovalUser($NewRequest);
                    }
                }
            }
        });
    }

    //looping insert user
    public function loopingInsertUser($request)
    {
        $resultMessage = [];
        DB::transaction(function () use ($request, &$resultMessage) {
            for ($i = 0; $i < count($request); $i++) {
                $message = [];
                if ($request[$i]["message"] == null) {
                    unset($request[$i]["message"]); // hapus message yang ada di array
                    $NewRequest = \Helper::instance()->MakeRequest($request[$i]); //merubah array agar menjadi request laravel
                    $NewRequest->merge(['user_status' => "1"]); //set user status
                    $user = $this->UserInterfaces->getUserByNik($NewRequest->user_nik); //mengambil user nik
                    if ($user != null) {  //mengecek apak user nik sudah ada atau belum
                        $NewRequest->merge(["user_id" => $user->user_id]);
                        $data = $this->ArrayModelAccess();
                        $this->updateUser($NewRequest); // menjalankan fungsi update user
                        $this->UserInterfaces->updateUserAccess($NewRequest,$data);
                    } else {
                        $this->insertUser($NewRequest); //menjalankan fungsi insert user
                    }

                    
                } else {
                    foreach ($request[$i]["message"] as $item) {
                        $message[] = ["row" => $i + 2, "error_field" => $item]; //membuat message error
                    }
                }
                $resultMessage[$request[$i]["user_nik"]] = $message; //memasukan message kedalam resul message
            }
        });
        return $resultMessage;
    }


    public function validateID($data)
    {
        $message = [];
        $array = [];
        foreach ($data as $item) {
            $info = [];
            // mencari department id
            $department_id = $this->getID(trim($item['department_id']), "DI"); //parameter pertama adalah name, kedua interface
            if ($department_id == null) $info = array_merge($info, ["department"]); //pembuatan info jika data tidak di temukan
            $item['department_id'] = $department_id != null ? $department_id->department_id : NULL;

            //mencari  grade id
            $grade_id = $this->getID(trim($item['grade_id']), "GI"); //parameter pertama adalah name, kedua interface
            if ($grade_id == null) $info = array_merge($info, ["grade_id"]); //pembuatan info jika data tidak di temukan
            $item['grade_id'] = $grade_id != null ? $grade_id->grade_id : NULL;

            //mencari title_id
            $title_id = $this->getID(trim($item['title_id']), "TitleInt"); //parameter pertama adalah name, kedua interface
            if ($title_id == null) $info = array_merge($info, ["title_id"]); //pembuatan info jika data tidak di temukan
            $item['title_id'] = $title_id != null ? $title_id->title_id : NULL;

            // mencari type_id
            $type_id = $this->getID(trim($item['type_id']), "TI"); //parameter pertama adalah name, kedua interface
            if ($type_id == null) $info = array_merge($info, ["type_id"]); //pembuatan info jika data tidak di temukan
            $item['type_id'] = $type_id != null ? $type_id->type_id : NULL;

            $item["message"] = $info; //membuat array message dengan data info
            $array[] = $item;
        }
        return $array;
    }

    public function getID($val, $interface)
    {
        $result = $this->$interface->getDataByName(trim($val));
        if ($result != null) {
            return $result;
        } else {
            return null;
        }
    }

    //merubah index array menjadi sesuai dengan nama field db
    public function changeKeysDB($array, $type = ["user", "approval"])
    {
        $newArray = [];
        $keysDB = $this->keysFieldDb(); //mendapatkan array dengan penamaan yang ada di field db
        $keysArray = $this->KeysArray(); //mendapatkan array dengan penamaan yang ada di field / header excel
        foreach ($type as $keys) {
            foreach ($array[$keys] as $item) {
                foreach ($keysArray[$keys] as $keyA) {
                    if ($keyA != $keysDB[$keys][$keyA]) {
                        $item[$keysDB[$keys][$keyA]] = $item[$keyA];
                        unset($item[$keyA]);
                    }
                }
                $newArray[$keys][] = $item;
            }
        }
        return $newArray;
    }

    //memecah array menjadi dua yaitu array user dan array approval
    public function splitArray($data)
    {
        $array = [];
        foreach ($data as $item) {
            $array['user'][] = $this->arrayFormating($item, "user"); //memecah array menjadi array user
            $array['approval'][] = $this->arrayFormating($item, "approval"); //memecah array menjadi array approval
        }
        return $array;
    }

    public function KeysArray()
    {
        $keys["user"] = [
            "nik" => "nik",
            "name" => "name",
            "email" => "email",
            "mobile_number" => "mobile_number",
            "birth_city" => "birth_city",
            "birth_date" => "birth_date",
            "gender" => "gender",
            "join_date" => "join_date",
            "department" => "department",
            "grade" => "grade",
            "title" => "title",
            "type" => "type",
        ];

        $keys["approval"] = [
            "nik" => "nik",
            "approval_nik_1" => "approval_nik_1",
            "approval_nik_2" => "approval_nik_2",
            "approval_nik_3" => "approval_nik_3",
            "approval_nik_4" => "approval_nik_4",
            "approval_nik_5" => "approval_nik_5",
            "approval_nik_6" => "approval_nik_6",
        ];
        return $keys;
    }

    public function keysFieldDb()
    {
        $keys["user"] = [
            "nik" => "user_nik",
            "name" => "user_name",
            "email" => "user_email",
            "mobile_number" => "user_mobile",
            "birth_city" => "user_birth_city",
            "birth_date" => "user_birth_date",
            "gender" => "user_sex",
            "join_date" => "user_join_date",
            "department" => "department_id",
            "grade" => "grade_id",
            "title" => "title_id",
            "type" => "type_id",
        ];

        $keys["approval"] = [
            "nik" => "user_nik",
            "approval_nik_1" => "approval_nik_1",
            "approval_nik_2" => "approval_nik_2",
            "approval_nik_3" => "approval_nik_3",
            "approval_nik_4" => "approval_nik_4",
            "approval_nik_5" => "approval_nik_5",
            "approval_nik_6" => "approval_nik_6",
        ];
        return $keys;
    }

    public function arrayFormating($data, $indexs)
    {
        $keys = $this->KeysArray(); //mendapatkan array dengan penamaan yang ada di field / header excel
        return array_intersect_key($data, $keys[$indexs]); //mengambil array yang cocok dan mengembalikannya
    }

    public function RefreshPassword($request)
    {
        // $2y$10$3of1pSz2InfKDfuePaIyBOrJSE5RWMYDeJiY0hIhbvQg6dLFopyGC default password
        $request = $request->merge([
            "updated_by" => Auth::user()->user_name,
            "password" => md5(sha1(md5('Hrunzavitalissyst3m'))), //default pass "unzavitalis";
            // "password" => Hash::make('Hrunzavitalissyst3m'), //default pass "unzavitalis";
            "user_status" => 1,
        ]);
        return $this->updateUser($request);
    }

    public function transformDate($value, $format = 'Y-m-d')
    {
        try {
            $date = \Carbon\Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value));
            return date('Y-m-d', strtotime($date));
        } catch (\ErrorException $e) {
            return \Carbon\Carbon::createFromFormat($format, $value);
        }
    }
}
