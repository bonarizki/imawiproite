<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class userExport implements FromArray, WithHeadings, ShouldAutoSize
{
    private $UserInterfaces, $request, $AgeCategoryInterfaces, $AgeArray;

    public function __construct($UserInterfaces, $request, $AgeCategoryInterfaces)
    {
        $this->UserInterfaces = $UserInterfaces;
        $this->request = $request;
        $this->AgeCategoryInterfaces = $AgeCategoryInterfaces;
    }
    /**
     * @return \Illuminate\Support\Collection
     */

    public function headings(): array
    {
        return [
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
    }

    public function array(): array
    {
        $this->AgeArray = $this->AgeCategoryInterfaces->allData();
        $data = $this->UserInterfaces->getAlluserApproval($this->request);
        $array = [];
        foreach ($data as $item) {
            $array[] = [
                $item->user_nik,
                $item->user_name,
                $item->user_email,
                $item->user_mobile,
                $item->user_birth_city,
                $item->user_birth_date,
                $this->findAgeCategory($item->user_birth_date),
                $item->user_sex,
                $item->user_join_date,
                isset($item->Department->department_name) ? $item->Department->department_name : '',
                isset($item->Grade->grade_name) ? $item->Grade->grade_name : '',
                isset($item->Grade->GradeGroup->grade_group_name) ? $item->Grade->grade_name : '',
                isset($item->Title->title_name) ? $item->Title->title_name : '',
                isset($item->Type->type_name) ? $item->Type->type_name : '',
                isset($item->ApprovalMatrix->approval_nik_1) ? $item->ApprovalMatrix->approval_nik_1 : '',
                isset($item->ApprovalMatrix->approval_nik_2) ? $item->ApprovalMatrix->approval_nik_2 : '',
                isset($item->ApprovalMatrix->approval_nik_3) ? $item->ApprovalMatrix->approval_nik_3 : '',
                isset($item->ApprovalMatrix->approval_nik_4) ? $item->ApprovalMatrix->approval_nik_4 : '',
                isset($item->ApprovalMatrix->approval_nik_5) ? $item->ApprovalMatrix->approval_nik_5 : '',
                isset($item->ApprovalMatrix->approval_nik_6) ? $item->ApprovalMatrix->approval_nik_6 : '',
            ];
        }
        return $array;
    }

    public function findAgeCategory($birth_date)
    {
        $generation = '';
        if ($birth_date != null || $birth_date != '') {
            $years = explode('-', $birth_date);
            foreach ($this->AgeArray as $age) {
                $years_age = explode('-', $age->age_years);
                if (count($years_age) == 1) { // untuk tahun yang tidak memiliki range
                    if ($years[0] >= $years_age[0]) {
                        $generation = $age->age_name;
                    }
                } else {
                    if (($years[0] >= $years_age[0] && $years[0] <= $years_age[1])) { // untuk age category yang memiliki range
                        $generation = $age->age_name;
                    }
                }
            }
            // $result = $this->AgeCategoryInterfaces
        }
        return $generation;
    }
}
