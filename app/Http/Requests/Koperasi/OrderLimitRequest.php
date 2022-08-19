<?php

namespace App\Http\Requests\Koperasi;

use Illuminate\Foundation\Http\FormRequest;

class OrderLimitRequest extends FormRequest
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
                    'category_id' => 'required|numeric|unique:App\Model\Koperasi\OrderLimit,category_id,NULL,category_id,deleted_at,NULL',
                    'order_limit' => 'required|numeric'
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'category_id' => 'required|numeric|unique:App\Model\Koperasi\OrderLimit,category_id,'.$this->category_id.',category_id,deleted_at,NULL',
                    'order_limit' => 'required|numeric'
                ];
            }
            default:break;
        }
    }

    public function messages()
    {
        return [
            "category_id.unique" => "The Category Already Has A Limit"
        ];
    }
}
