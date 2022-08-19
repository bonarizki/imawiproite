<?php

namespace App\Http\Requests\Ticketing;

use Illuminate\Foundation\Http\FormRequest;

class SystemApplicationRequest extends FormRequest
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
                        'system_name' => 'required|string|min:3', 
                        'system_pic_nik' => 'required|string|min:3', 
                    ];
                }
                case 'PUT':
                case 'PATCH':
                {
                    return [
                        'system_name' => 'required|string|min:3', 
                        'system_pic_nik' => 'required|string|min:3', 
                    ];
                }
                default:break;
            }
    }
}
