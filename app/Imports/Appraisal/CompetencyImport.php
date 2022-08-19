<?php

namespace App\Imports\Appraisal;

use App\Model\Appraisal\CompetencyTemp;

use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Validators\Failure;

use Auth;

class CompetencyImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
	use Importable, SkipsFailures;

	public function model(array $row)
	{
		return new CompetencyTemp([
			'department' => $row['department'],
			'level' => $row['level'],
			'competency_eng' => $row['competency_eng'],
			'competency_bhs' => $row['competency_bhs'],
			'user_id' => Auth::user()->user_id
		]);
	}

	public function rules(): array
	{
		return [
			'department' => 'required|exists:mst_main_department,department_name',
			'level' => 'required|exists:mst_main_user_grade_group,grade_group_name',
			'competency_eng' => 'required',
			'competency_bhs' => 'required'
		];
	}

	public function customValidationMessages()
	{
		return [
			'department.required' => 'Department is empty',
			'department.exists' => 'Department is not recognized',
			'level.required' => 'Level is empty',
			'level.exists' => 'Level is not recognized',
			'competency_eng.required' => 'Competency ENG is empty',
			'competency_bhs.required' => 'Competency BHS is empty'
		];
	}
}