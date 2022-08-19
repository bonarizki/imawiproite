<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TypeRequest extends FormRequest
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
        if($this->type_id==null) {
            return [
                "type_name"=>"required|unique:App\Model\Type,type_name,NULL,type_name,deleted_at,NULL",
            ];
        }else{
            return [
                "type_name"=>"required|unique:App\Model\Type,type_name,".$this->type_name.",type_name,deleted_at,NULL",
            ];
        }
        
    }
}
