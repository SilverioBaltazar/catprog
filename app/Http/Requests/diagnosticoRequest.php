<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class diagnosticoRequest extends FormRequest
{ 
    public function messages()
    {
        return [
            'periodo_id.required' => 'Periodo es obligatorio.',
            'prog_id.required'    => 'Programa es es obligatorio.',
            'preg_id.required'    => 'Pregunta del diagnóstico es obligatoria.'
            //'preg_arc.required' => 'Archivo digital en formato PDF es obligatorio.'
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
            'prog_id'      => 'required',
            'preg_id'      => 'required'
            //'preg_arc'   => 'sometimes|mimetypes:application/pdf|max:2500'
            //'accion'     => 'required|regex:/(^([a-zA-z%()=.\s\d]+)?$)/i',
            //'medios'     => 'required|regex:/(^([a-zA-z\s\d]+)?$)/i'
            //'rubro_desc' => 'min:1|max:80|required|regex:/(^([a-zA-zñÑ%()=.\s\d]+)?$)/iñÑ'
        ];
    }
}
