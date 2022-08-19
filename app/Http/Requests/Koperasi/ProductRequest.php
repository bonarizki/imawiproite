<?php

namespace App\Http\Requests\Koperasi;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductRequest extends FormRequest
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
                    'product_id' => 'required|numeric|unique:App\Model\Koperasi\OrderDetail,product_id,NULL,product_id,deleted_at,NULL,order_header_id,NULL,user_nik,'.Auth::user()->user_nik, 
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'order_detail_id' => 'required|numeric', 
                    'qty' => 'required|numeric',
                ];
            }
            default:break;
        }
    }

    public function messages()
    {
        return [
            "product_id.unique" => "The Item Is Already In Your Cart" 
        ];
    }
}
