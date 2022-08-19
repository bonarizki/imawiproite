<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ResignRequest extends FormRequest
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
        // $this->request->add(['user_nik' => Auth::user()->user_nik]);
        return [
            "user_nik" => "required|unique:App\Model\Resignation\Resign,user_nik,NULL,user_nik,deleted_at,NULL,resign_status,in progress",
            "user_email" => "required",
            "password" => "required"
        ];
    }

    public function messages()
    {
        return [
            'user_nik.unique' => 'you have submitted a previous resign, please wait for your submission until the process is complete'
        ];
    }
}
