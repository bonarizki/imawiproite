<?php

namespace App\Imports\Appraisal;

use App\Model\Appraisal\FinalScoreTemp;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

use Auth;

class FinalScoreImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
	use Importable, SkipsFailures;

	public function model(array $row)
	{
		return new FinalScoreTemp([
			'nik' => $row['nik'],
			'employee' => $row['employee'],
			'department' => $row['department'],
			'level' => $row['level'],
			'final_score' => $row['final_score'],
			'confidential_summary' => $row['confidential_summary'],
			'user_id' => Auth::user()->user_id
		]);
	}

	public function rules(): array
	{
		return [
			'nik' => 'required',
			'final_score' => 'required',
			'confidential_summary' => 'required'
		];
	}

	public function customValidationMessages()
	{
		return [
			'nik.required' => 'NIK is empty',
			'final_score.required' => 'Final Score is empty',
			'confidential_summary.required' => 'Confidential Summary is empty'
		];
	}
}