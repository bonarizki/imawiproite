<?php

namespace App\Http\Requests\Training;

use Illuminate\Foundation\Http\FormRequest;

class MethodRequest extends FormRequest
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
            {
                return [
                    'method_id' => 'required|numeric'
                ];
            }
            case 'POST':
            {
                return [
                    'method_name' => 'required|string|max:50', 
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'method_name' => 'required|string|max:50', 
                    'method_id' => 'required|numeric'
                ];
            }
            default:break;
        }
    }
}
