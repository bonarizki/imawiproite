<?php

namespace App\Http\Requests\Plugins;

use Illuminate\Foundation\Http\FormRequest;

class YearRequest extends FormRequest
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
        if($this->year_id!=null){
            return [
                "year_name"=>"required|unique:App\Model\Plugin\PluginYear,year_name,".$this->year_name.",year_name,deleted_at,NULL|integer|digits_between:4,4"
            ];
        }else{
            return [
                "year_name"=>"required|unique:App\Model\Plugin\PluginYear,year_name,NULL,year_name,deleted_at,NULL|integer|digits_between:4,4"
            ];
        }
    }

    public function messages()
    {
        return [
            'year_name.digits_between' => 'Only 4 digits',
        ];
    } 
}
