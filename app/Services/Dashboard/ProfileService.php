<?php

namespace App\Services\Dashboard;

use App\Repository\Dashboard\User\Interfaces\UserInterfaces;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class ProfileService 
{
    private $UserInterfaces;

    public function __construct(UserInterfaces $UserInterfaces)
    {
        $this->UserInterfaces= $UserInterfaces;
    }

    public function getDataProfile($nik)
    {
        return $this->UserInterfaces->getDataProfile($nik); //ambil data user dengan nik
    }

    public function updateProfile($request)
    {
        return $this->UserInterfaces->updateUser($request); // proses update dengan user interfaces update user
    }

    public function updatePassword($request)
    {
        $data = $this->UserInterfaces->getDataProfile($request->user_nik) //ambil data user dengan nik
                    ->makeVisible(['password']); //membuat password yang di hidden dapat digunakan
        $password = md5(sha1(md5('Hr' . $request->password . 'syst3m'))); //hasing password lama
        if ($data->password == $password) {
            //custom request
            $request->request->remove('password'); //hapus paramater password dari request (password lama)
            $request->merge([ //menambahkan paramater password menggunakan parameter password baru yang sudah di hash
                'password' => md5(sha1(md5('Hr' . $request->password_new . 'syst3m'))), //hasing password baru
            ]);
            $request->request->remove('password_new'); // hapus parameter password baru
            //endcustom request
            return $this->UserInterfaces->updateUser($request); // proses update dengan user interfaces update user
        }else{
            throw new ModelNotFoundException('Old Password Worng');
        }
    }
}
