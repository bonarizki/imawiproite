<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GradeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if ($this->grade_id==null) {
            return [
                "grade_code"=>"required|unique:App\Model\Grade,grade_code,NULL,grade_code,deleted_at,NULL",
                "grade_name"=>"required|unique:App\Model\Grade,grade_name,NULL,grade_code,deleted_at,NULL",
                "grade_group_id"=>"required"
            ];
        }else{
            return [
                "grade_code"=>"required|unique:App\Model\Grade,grade_code,".$this->grade_code.",grade_code,deleted_at,NULL",
                "grade_name"=>"required|unique:App\Model\Grade,grade_name,".$this->grade_name.",grade_name,deleted_at,NULL",
                "grade_group_id"=>"required"
            ];
        }
    }
}
