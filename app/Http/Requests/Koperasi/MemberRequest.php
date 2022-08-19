<?php

namespace App\Http\Requests\Koperasi;

use Illuminate\Foundation\Http\FormRequest;

class MemberRequest extends FormRequest
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
                    'user_nik' => 'required|numeric|unique:App\Model\Koperasi\Member,user_nik,NULL,user_nik,deleted_at,NULL',
                    'member_status' => 'required|string',
                    'member_code' => 'required|string|unique:App\Model\Koperasi\Member,member_code,NULL,member_code,deleted_at,NULL|min:5|max:5'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'user_nik' => 'required|string|unique:App\Model\Koperasi\Member,user_nik,'.$this->user_nik.',user_nik,deleted_at,NULL',
                    'member_status' => 'required|string',
                    'member_code' => 'required|string|unique:App\Model\Koperasi\Member,member_code,'.$this->user_nik.',member_code,deleted_at,NULL|min:5|max:5'
                ];
            }
            default:break;
        }
    }

    public function messages()
    {
        return [
            "user_nik.unique" => "the user already has a member",
            "member_code.unique" => "member code already has been used",
        ];
    }
}
