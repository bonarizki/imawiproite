<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Request;

class UserRequest extends FormRequest
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
        // dd($request);
        if ($request->type=='update') {
            return [
                'user_nik'=>'required|numeric|unique:App\Model\User,user_nik,'.$request->user_nik.',user_nik',
                'user_name'  => 'required',
                'user_email' => 'required|email|unique:App\Model\User,user_email,'.$request->user_nik.',user_nik',
                'user_mobile' => 'required|numeric',
                'user_birth_city' => 'required',
                'user_birth_date' => 'required|date|date_format:Y-m-d',
                'user_sex' => 'required',
                'user_join_date' => 'required|date|date_format:Y-m-d',
                'grade_id'=>'required',
                'type_id'=>'required',
                'title_id'=>'required',
                'department_id'=>'required'
            ];
        }else{
            return [
                'user_nik'=>'required|numeric|unique:App\Model\User,user_nik',
                'user_name'  => 'required',
                'user_email' => 'required|email|unique:App\Model\User,user_email',
                'user_mobile' => 'required|numeric',
                'user_birth_city' => 'required',
                'user_birth_date' => 'required|date|date_format:Y-m-d',
                'user_sex' => 'required',
                'user_join_date' => 'required|date|date_format:Y-m-d',
                'grade_id'=>'required',
                'type_id'=>'required',
                'title_id'=>'required',
                'department_id'=>'required'
            ];
        }
    }

    public function messages()
    {
        return [
            'user_birth_date.date_format' => 'Date not valid',
            'user_join_date.date_format' => 'Date not valid'
        ];
    }
}
