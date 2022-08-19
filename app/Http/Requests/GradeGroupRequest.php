<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GradeGroupRequest extends FormRequest
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
        if($this->grade_group_id==null){
            return [
                "grade_group_name"=>"required|unique:App\Model\GradeGroup,grade_group_name,NULL,grade_group_name,deleted_at,NULL",
            ];
        }else{
            return [
                "grade_group_name"=>"required|unique:App\Model\GradeGroup,grade_group_name,".$this->grade_group_name.",grade_group_name,deleted_at,NULL",
            ];
        }
    }
}
