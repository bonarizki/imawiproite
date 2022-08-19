<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TitleRequest extends FormRequest
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
        if($this->title_id==null){
            return [
                "title_name"=>"required|unique:App\Model\Title,title_name,NULL,title_name,deleted_at,NULL"
            ];
        }else{
            return [
                "title_name"=>"required|unique:App\Model\Title,title_name,".$this->title_name.",title_name,deleted_at,NULL"
            ];
        }
        
    }
}
