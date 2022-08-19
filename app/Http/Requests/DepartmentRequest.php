<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartmentRequest extends FormRequest
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
        if ($this->department_id==null) {
            return [
                "department_name"=>"required|unique:App\Model\Departement,department_name,NULL,department_name,deleted_at,NULL"
            ];
        }else{
            return [
                "department_name"=>"required|unique:App\Model\Departement,department_name,".$this->department_name.",department_name,deleted_at,NULL"
            ];
        }
    }
}
