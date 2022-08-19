<?php

namespace App\Http\Requests\Ticketing;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RequestTicketing extends FormRequest
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
        if ($this->type_id == '8') { // it po
            switch($this->method())
            {
                case 'GET':
                case 'DELETE':
                case 'POST':
                {
                    return [
                        'nama_barang' => 'required|array', 
                        'nama_barang.*' => 'required|string|min:3', 
                        'qty' => 'required|array', 
                        'qty.*' => 'required|numeric', 
                        'harga' => 'required|array', 
                        'harga.*' => 'required|string', 
                    ];
                }
                case 'PUT':
                case 'PATCH':
                {
                    return [
                        'nama_barang' => 'required|array', 
                        'nama_barang.*' => 'required|string|min:3', 
                        'qty' => 'required|array', 
                        'qty.*' => 'required|numeric', 
                        'harga' => 'required|array', 
                        'harga.*' => 'required|string', 
                    ];
                }
                default:break;
            }
        }elseif ($this->type_id == '6') { // request user
            switch($this->method())
            {
                case 'GET':
                case 'DELETE':
                case 'POST':
                {
                    return [
                        'user_nik' => 'required|array', 
                        'user_nik.*' => 'required|numeric', 
                    ];
                }
                case 'PUT':
                case 'PATCH':
                {
                    return [
                        'user_nik' => 'required|array', 
                        'user_nik.*' => 'required|numeric',
                    ];
                }
                default:break;
            }
        }elseif ($this->type_id == '10') {
            switch($this->method())
            {
                case 'GET':
                case 'DELETE':
                case 'POST':
                {
                    return [
                        'request_type' => 'required|string', 
                        'application_for' => 'required|string', 
                    ];
                }
                case 'PUT':
                case 'PATCH':
                {
                    return [
                        'request_type' => 'required|string', 
                        'application_for' => 'required|string', 
                    ];
                }
                default:break;
            }
        }
        
    }
}
