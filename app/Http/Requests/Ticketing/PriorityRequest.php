<?php

namespace App\Http\Requests\Ticketing;

use Illuminate\Foundation\Http\FormRequest;

class PriorityRequest extends FormRequest
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
                    'priority_name' => 'required|string|max:50', 
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'priority_name' => 'required|string|max:50', 
                    'priority_id' => 'required|numeric'
                ];
            }
            default:break;
        }
    }
}
