<?php

namespace App\Http\Requests\Plugins;

use Illuminate\Foundation\Http\FormRequest;

class PeriodRequest extends FormRequest
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
        if ($this->period_id==null) {
            return [
                'period_name'=>'required|unique:App\Model\Plugin\PluginPeriod,period_name,NULL,period_name,deleted_at,NULL'
            ];
        }else{
            return [
                'period_name'=>'required|unique:App\Model\Plugin\PluginPeriod,period_name,'.$this->period_name.',period_name',
            ];
        }
    }
}
