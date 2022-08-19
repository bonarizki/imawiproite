<?php

namespace App\Http\Requests\Training;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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
            {
                return [
                    'vendor_id' => 'required|numeric'
                ];
            }
            case 'POST':
            {
                return [
                    'vendor_name' => 'required|string|max:50', 
                    'vendor_npwp' => 'nullable|numeric', 
                    'vendor_bank_name' => 'nullable|string|max:50|min:3', 
                    'vendor_bank_number' => 'nullable|numeric',
                    'vendor_siup' => 'nullable|numeric',
                    'vendor_tdp' => 'nullable|numeric',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'vendor_name' => 'required|string|max:50', 
                    'vendor_npwp' => 'required|numeric', 
                    'vendor_bank_name' => 'required|string|max:50|min:3', 
                    'vendor_bank_number' => 'required|numeric',
                    'vendor_siup' => 'nullable|numeric',
                    'vendor_tdp' => 'nullable|numeric',
                    'vendor_id' => 'required|numeric'
                ];
            }
            default:break;
        }
        
    }
}
