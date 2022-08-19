<?php

namespace App\Http\Requests\Ticketing;

use Illuminate\Foundation\Http\FormRequest;

class ApprovalTypeRequest extends FormRequest
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
                    'type_name' => 'required|string|max:50', 
                    'approval_nik' => 'required|string|max:50', 
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'type_name' => 'required|string|max:50', 
                    'type_id' => 'required|numeric',
                    'approval_nik' => 'required|string|max:50',
                ];
            }
            default:break;
        }
    }
}
