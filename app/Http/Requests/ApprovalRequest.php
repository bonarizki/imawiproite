<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApprovalRequest extends FormRequest
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
        if ($this->approval_id==null) {
            return [
                "user_nik"=>"required|unique:App\Model\ApprovalMatrix,user_nik,NULL,user_nik,deleted_at,NULL"
            ];
        }else{
            return [
                "approval_id"=>"required|unique:App\Model\ApprovalMatrix,approval_id,".$this->approval_id.",approval_id,deleted_at,NULL"
            ];
        }
    }
}
