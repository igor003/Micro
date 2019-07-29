<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ConfigurationRequest extends FormRequest
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
            'project_configuration'=>'required',
            'codice_configuration'=>'required',
            'components'=>'required',
            'sez_components'=>'required',
            'amount_strands'=>'required',
            'height'=>'required',
            'width'=>'required',
        ];
    }
}
