<?php

namespace App\Imports\Koperasi;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MemberUpload implements ToModel,WithHeadingRow,WithValidation,SkipsOnFailure
{
    use Importable;

    public $errors = [];
    public $data = [];
    public $success = 0;
    public $fail = 0;
    public $rows = 0;
    private $helper;
    private $MemberInterfaces;

    public function __construct($MemberInterfaces)
    {
        $this->helper = \Helper::instance();
        $this->MemberInterfaces = $MemberInterfaces;
    }

    public function model(array $row)
    {
        $data = [
            "user_nik" => trim($row['user_nik']),
            "member_status" => trim($row['member_type']),
            "member_code" => trim($row['member_code']),
            'created_by' => Auth::user()->user_name,
            'updated_by' => Auth::user()->user_name,
        ];
        $this->data[] = $data;
        ++$this->success;
        return DB::transaction(function () use($data,$row) {
            $this->MemberInterfaces->upload($data,$row);
        });
    }

    public function withValidator($validator)
    {
        // $data = $validator->getData();
        // $index = $this->rows + 1; // di tambah satu karena excel di mulai dari row ke dua
        // $validator->after(function ($validator) use($data,$index) {
        // //    $result = $this->MemberInterfaces->checkMemberCode($data[$index]['member_code']);
        //    dd($data[$index]['member_code']);
        // });
        // // dd($data,$this->rows);
       
        
    }

    public function rules(): array
	{
        ++$this->rows;
		return [
			'user_nik' => 'required|numeric|exists:App\Model\User,user_nik',
			'user_name' => 'required|string',
			'department' => 'required|string',
			'member_type' => 'required|in:member,non-member',
            'member_code' => [
                'required',
                // 'unique:App\Model\Koperasi\Member,member_code,,member_code,deleted_at,NULL',
                'min:5',
                'max:5'
            ]
		];
    }

    public function customValidationMessages()
    {
        return [
            'user_nik.required' => 'columns cannot be empty',
            'user_nik.exists' => 'User Not Exists On Wiproites',
            'user_name.required' => 'columns cannot be empty',
            'department.required' => 'columns cannot be empty',
            'member_type.required' => 'columns cannot be empty',
            'member_code.required' => 'columns cannot be empty',
            'member_type.in' => 'member type format not match',
            'member_code.unique' => 'member code has already been taken.'
        ];
    }
    
    public function onFailure(Failure ...$failures)
    {
        ++$this->fail;
        $this->errors[] = $failures[0];
    }
}
