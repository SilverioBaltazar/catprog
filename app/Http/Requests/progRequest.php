<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class progRequest extends FormRequest
{
    public function messages()
    {
        return [
            'prog_desc.min'          => 'El nombre del programa es de mínimo 1 caracter.',
            'prog_desc.max'          => 'El nombre del programa es de máximo 150 caracteres.',
            'prog_desc.required'     => 'El nombre del programa es obligatorio.',
            //'prog_siglas.min'      => 'Las siglas del programa es de mínimo 1 caracter.',
            //'prog_siglas.max'      => 'Las siglas del programa es de máximo 150 caracteres.',
            //'prog_siglas.required' => 'Las siglas del programa es obligatorio.',            
            'prog_tipo.required'     => 'El tipo programa y/o acción es obligatorio.',
            'clasificgob_id.required'=> 'El nivel gubernamental es obligatorio.',
            'prioridad_id.required'  => 'La prioridad es obligatoria.'
            //'osc_foto1.required'   => 'La imagen es obligatoria'
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
            'prog_desc'      => 'required|min:1|max:150',
            //'prog_siglas'  => 'required|min:1|max:150',
            'prog_tipo'      => 'required',
            'clasificgob_id' => 'required',
            'prioridad_id'   => 'required'
            //'rubro_desc'   => 'min:1|max:80|required|regex:/(^([a-zA-zñÑ%()=.\s\d]+)?$)/iñÑ'
        ];
    }
}
