<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Request;

class loginRequest extends FormRequest
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
    public function rules(Request $request)
    {
        return [
            'g-recaptcha-response' => 'required|recaptchav3:login,0.1',
            'username'  => 'required',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'g-recaptcha-response' =>  'Captcha error message'
        ];
    }
}
