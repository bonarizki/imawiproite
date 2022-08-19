<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminModuleRequest extends FormRequest
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
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            case 'POST':
            {
                return [
                    'admin_nik' => "required|numeric|unique:App\Model\ModuleAdmin,admin_nik,NULL,NULL,module_id,$this->module_id,deleted_at,NULL", 
                ];
            }
            case 'PUT':
            {
                return [
                    'admin_nik' => "required|numeric|unique:App\Model\ModuleAdmin,admin_nik,$this->admin_id,admin_id,module_id,$this->module_id,deleted_at,NULL",
                ];
            }
            case 'PATCH':
            default:break;
        }
    }
}
