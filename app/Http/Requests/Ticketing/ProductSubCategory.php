<?php

namespace App\Http\Requests\Ticketing;

use Illuminate\Foundation\Http\FormRequest;

class ProductSubCategory extends FormRequest
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
                    'sub_category_name' => 'required|string', 
                    'sub_category_rank' => 'required|numeric', 
                    'category_id' => 'required|numeric|exists:\App\Model\Ticketing\ProductCategory,category_id', 
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'sub_category_name' => 'required|string', 
                    'sub_category_rank' => 'required|numeric', 
                    'category_id' => 'required|numeric|exists:\App\Model\Ticketing\ProductCategory,category_id',  
                ];
            }
            default:break;
        }
    }
}
