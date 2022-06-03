<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class diagnosticopregsRequest extends FormRequest
{
    public function messages()
    {
        return [
            'periodo_id.required' => 'Periodo fiscal es obligatorio',
            'prog_id.required'    => 'Programa y/o acción es obligatorio'
            //'osc_foto1.required' => 'La fotografía 1 es obligatoria'
        ];
    }
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
            'periodo_id'   => 'required',
            'prog_id'      => 'required'
            //'osc_foto1'  => 'mimes:jpg,jpeg,png'
            //'iap_foto2'  => 'required|image'
            //'accion'     => 'required|regex:/(^([a-zA-z%()=.\s\d]+)?$)/i',
            //'medios'     => 'required|regex:/(^([a-zA-z\s\d]+)?$)/i'
            //'rubro_desc' => 'min:1|max:80|required|regex:/(^([a-zA-zñÑ%()=.\s\d]+)?$)/iñÑ'
        ];
    }
}
