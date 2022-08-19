<?php

namespace App\Imports\Training;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VendorUpload implements ToModel,WithHeadingRow,WithValidation,SkipsOnFailure
{
    use Importable;

    public $errors = [];
    public $data = [];
    public $success = 0;
    public $fail = 0;
    public $rows = 0;
    private $helper;
    private $VendorInterfaces;

    public function __construct($VendorInterfaces)
    {
        $this->helper = \Helper::instance();
        $this->VendorInterfaces = $VendorInterfaces;
    }

    public function model(array $row)
    {
        $data = [
            "vendor_name" => trim($row['vendor_name']),
            "vendor_bank_name" => trim($row['vendor_bank_name']),
            "vendor_bank_number" => trim($row['vendor_bank_number']),
            "vendor_siup" => trim($row['vendor_siup']),
            "vendor_npwp" => trim($row['vendor_npwp']),
            "vendor_tdp" => trim($row['vendor_tdp']),
            "vendor_type" => trim($row['vendor_type']),
            'created_by' => Auth::user()->user_name,
            'updated_by' => Auth::user()->user_name,
        ];
        $this->data[] = $data;
        ++$this->success;
        return DB::transaction(function () use($data,$row) {
            $this->VendorInterfaces->upload($data,$row);
        });
    }

    public function rules(): array
	{
        ++$this->rows;
		return [
			'vendor_name' => 'required|string',
			'vendor_bank_name' => 'required',
			'vendor_bank_number' => 'required',
			'vendor_type' => 'required|string',
		];
    }

    public function customValidationMessages()
    {
        return [
            'vendor_name.required' => 'columns cannot be empty',
            'vendor_bank_name.required' => 'columns cannot be empty',
            'vendor_bank_number.required' => 'columns cannot be empty',
            'vendor_type.required' => 'columns cannot be empty',
        ];
    }
    
    public function onFailure(Failure ...$failures)
    {
        ++$this->fail;
        $this->errors[] = $failures[0];
    }
}
