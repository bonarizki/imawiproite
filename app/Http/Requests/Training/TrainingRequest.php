<?php

namespace App\Http\Requests\Training;

use Illuminate\Foundation\Http\FormRequest;

class TrainingRequest extends FormRequest
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
                    'training_topic' => 'required|string', 
                    'vendor_type' => 'required|string', 
                    'vendor_id' => 'required|string', 
                    'method_id' => 'required|string', 
                    'training_date' => 'required',
                    'training_hour' => 'required',
                    'training_fee' => 'required|string',
                    'training_participants' => 'nullable|numeric',
                    'method_participant' => 'required',
                    'participant_name.*' => 'required|numeric',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'training_id' => 'required|string', 
                    'category_id' => 'required|numeric',
                    'training_date_actual' => 'nullable|string',
                    'training_total' => 'nullable|numeric'
                ];
            }
            default:break;
        }
    }

    public function messages()
    {
        return [
            "method_participant.required" => 'The training of participant field is required.'
        ];
    }
}
