<?php

namespace App\Http\Requests\Ticketing;

use Illuminate\Foundation\Http\FormRequest;

class ProductCategory extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        // dd(Auth::user());
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
                    'category_name' => 'required|string', 
                    'category_rank' => 'required|numeric', 
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'category_name' => 'required|string', 
                    'category_rank' => 'required|numeric', 
                ];
            }
            default:break;
        }
    }
}
