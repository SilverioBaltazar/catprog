<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class objprogRequest extends FormRequest
{
    public function messages()
    {
        return [
            'periodo_id.required'          => 'El periodo es obligatorio',
            'prog_id.required'             => 'El programa es obligatorio',        
            'obj_prog.min'                 => 'El objetivo(os) del programa y/o acción es de mínimo 1 caracter.',
            'obj_prog.max'                 => 'El objetivo(os) del programa y/o acción es de máximo 4,000 caracteres.',
            'obj_prog.required'            => 'El objetivo(os) del programa y/o acción es obligatorio.',
            'obj_meta.min'                 => 'Meta, propósito y componentes del programa y/o acción es de mínimo 1 caracter.',
            'obj_meta.max'                 => 'Meta, propósito y componentes del programa y/o acción es de máximo 4,000 caracteres.',
            'obj_meta.required'            => 'Meta, propósito y componentes del programa y/o acción es obligatorio.',            
            'obj_zona_aten.min'            => 'Las zonas de atención del programa y/o acción es de mínimo 1 caracter.',
            'obj_zona_aten.max'            => 'Las zonas de atención del programa y/o acción es de máximo 4,000 caracteres.',
            'obj_zona_aten.required'       => 'Las zonas de atención del programa y/o acción es obligatoria.',
            'periodo_id1.required'         => 'El año de inicio es obligatorio',
            'mes_id1.required'             => 'El mes de inicio es obligatorio',
            'dia_id1.required'             => 'El de inicio día es obligatorio'
            //'obj_sectores_apoya.min'     => 'Los sectores que se benefician es de mínimo 1 caracter.',
            //'obj_sectores_apoya.max'     => 'Los sectores que se benefician es de máximo 150 caracteres.',
            //'obj_sectores_apoya.required'=> 'Los sectores que se benefician es obligatorio.'
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
            'periodo_id'        => 'required',
            'prog_id'           => 'required',
            'obj_prog'          => 'required|min:1|max:4000',
            'obj_meta'          => 'required|min:1|max:4000',
            'obj_zona_aten'     => 'required|min:1|max:4000',
            'periodo_id1'       => 'required',
            'mes_id1'           => 'required',
            'dia_id1'           => 'required'
        ];
    }
}
