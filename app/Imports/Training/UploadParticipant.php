<?php

namespace App\Imports\Training;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Auth;

class UploadParticipant implements ToModel,WithHeadingRow,WithValidation,SkipsOnFailure
{
    use Importable;

    public $errors = [];
    public $data = [];
    public $success = 0;
    public $fail = 0;
    public $rows = 0;
    private $helper;
    private $RequestInterfaces;
    public $type;
    public $training_id;

    public function __construct($RequestInterfaces,$type,$training_id = null)
    {
        $this->helper = \Helper::instance();
        $this->RequestInterfaces = $RequestInterfaces;
        $this->type = $type;
        $this->training_id = $training_id;
    }

    public function model(array $row)
    {
        if ($this->type == 'import') {
            $data = [
                "training_user_nik" => trim($row['user_nik']),
                "training_id" => $this->training_id,
                'created_by' => Auth::user()->user_name,
                'updated_by' => Auth::user()->user_name,
            ];
            
            return DB::transaction(function () use ($data) {
                $data = \Helper::instance()->MakeRequest($data);
                $this->RequestInterfaces->insertParticipant($data);
                $this->data[] = $data;
                ++$this->success;
            });
        }
    }

    public function rules(): array
	{
        ++$this->rows;
		return [
			'user_nik' => 'required|numeric|exists:App\Model\User,user_nik',
			'user_name' => 'required|string',
			
		];
    }

    public function customValidationMessages()
    {
        return [
            'user_nik.required' => 'columns cannot be empty',
            'user_name.required' => 'columns cannot be empty',
            'user_nik.exists' => 'User Not Exists On Wiproites'
        ];
    }
    
    
    public function onFailure(Failure ...$failures)
    {
        ++$this->fail;
        $this->errors[] = $failures[0];
    }
}
