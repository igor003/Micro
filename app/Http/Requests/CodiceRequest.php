<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CodiceRequest extends FormRequest
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
        return [
            'project'=>'required',
            'codice_name'=>'required|unique:part,name'
        ];
    }

    public function messages()
    {
        return [
            'codice_name.unique' => 'Codice name already exist!!!',
            'codice_name.required' => 'Name of codice is required!!!',
            'project.required' => 'Name of project is required!!!',

        ];
    }
}
