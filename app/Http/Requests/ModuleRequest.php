<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ModuleRequest extends FormRequest
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
        if ($this->module_id==null) {
            return [
                "module_name"=>"required|unique:App\Model\Module,module_name,NULL,module_name,deleted_at,NULL",
                "module_url"=>"required",
                // "module_image"=>"required|image|mimes:jpeg,png,jpg"
            ];
        }else{
            return [
                "module_name"=>"required|unique:App\Model\Module,module_name,".$this->module_name.",module_name,deleted_at,NULL",
                "module_url"=>"required",
                // "module_image"=>"required|image|mimes:jpeg,png,jpg"
            ];
        }
        
    }
}
