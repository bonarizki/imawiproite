<?php

namespace App\Http\Requests\Plugins;

use Illuminate\Foundation\Http\FormRequest;

class VersionRequest extends FormRequest
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
        if ($this->version_id==null) {
            return [
                "version_code"=>"required|unique:App\Model\Plugin\PluginVersion,version_code,NULL,version_code,deleted_at,NULL",
                "version_name"=>"required",
                "version_status"=>"required",
            ];
        }else{
            return [
                "version_code"=>"required|unique:App\Model\Plugin\PluginVersion,version_code,".$this->version_code.',version_code,deleted_at,NULL',
                "version_name"=>"required",
                "version_status"=>"required",
            ];
        }
    }
}
