<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class MenuRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $model = $this->getModelName($request);
        $name = $this->TypeMenu."_name";
        $id = $this->TypeMenu . '_id';
        $this->$id == NULL ? $this->$name = NULL : '';
        return [
            $this->TypeMenu."_name" => "required|unique:" . $model . ",".$name."," . $this->$name . ",".$name.",deleted_at,NULL",
            // $this->TypeMenu."_icon" => "required",
            $this->TypeMenu."_url" => "required",
        ];
    }

    public function gettingModel($request)
    {
        $reqURL = $request->requestUri;
        $model = '';
        if ($request->method == 'PUT') {
            $data = [
                "/resignation/update/menu" => "App\Model\Resignation\Menu\Menu",
                "/training/update/menu" => "App\Model\Training\Menu\Menu",
                "/ticketing/update/menu" => "App\Model\Ticketing\Menu\Menu", 
                "/koperasi/update/menu" => "App\Model\Koperasi\Menu\Menu", 
                "/update/data/menu" => "App\Model\Menu\Menu"
            ];
            $model = $data[$reqURL];
        } elseif ($request->method == 'POST') {
            $data = [
                "/resignation/insert/menu" => "App\Model\Resignation\Menu\Menu",
                "/training/insert/menu" => "App\Model\Training\Menu\Menu",
                "/ticketing/insert/menu" => "App\Model\Ticketing\Menu\Menu",
                "/koperasi/insert/menu" => "App\Model\Koperasi\Menu\Menu",
                "/insert/Menu" => "App\Model\Menu\Menu"
            ];
            $model = $data[$reqURL];
        }
        return $model;
    }

    public function getModelName($request)
    {
        $model = $this->gettingModel($request);
        if ($request->TypeMenu=='menu_parent') {
            $modelName = $model;
        } elseif ($request->TypeMenu=='menu_child'){
            $modelName = $model.'Child';
        } elseif ($request->TypeMenu=='menu_grand_child'){
            $modelName = $model.'GrandChild';
        }
        return $modelName;
    }
}
