<?php

namespace App\Http\Requests\Plugins;

use Illuminate\Foundation\Http\FormRequest;

class MonthRequest extends FormRequest
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
        if ($this->month_id==null) {
            return [
                "month_name"=>"required|unique:App\Model\Plugin\PluginMonth,month_name,NULL,month_name,deleted_at,NULL",
                "month_sequence"=>"required"
            ];
        }else{
            return [
                "month_name"=>"required|unique:App\Model\Plugin\PluginMonth,month_name,".$this->month_name.",month_name,deleted_at,NULL",
                "month_sequence"=>"required"
            ];
        }
    }
}
