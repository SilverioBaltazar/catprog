<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class finanpresdetRequest extends FormRequest
{
    public function messages()
    {
        return [
            'periodo_id.required'     => 'Periodo es obligatorio.',
            'prog_id.required'        => 'Programa y/o acción es obligatorio.',
            'periodo_id2.required'    => 'Periodo fiscal es es obligatorio.',
            'fuente_id.required'      => 'Fuente de financiamiento presupuestal anual es es obligatorio.',
            'ctgasto_id.required'     => 'Clasificación del tipo de gasto es es obligatorio.',
            'conac_id.required'       => 'Clasificación CONAC es es obligatorio.',
            'subsector_id.required'   => 'Subsector programático presupuestal es obligatorio.'            
            //'programa_desc.min'     => 'Programa es de mínimo 1 caracter.',
            //'programa_desc.max'     => 'Programa es de máximo 500 caracteres.',
            //'programa_desc.required'=> 'Programa es obligatorio.',
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
            'periodo_id'    => 'required',
            'prog_id'       => 'required',
            'periodo_id2'   => 'required',
            'fuente_id'     => 'required',
            'ctgasto_id'    => 'required',
            'conac_id'      => 'required',
            'subsector_id'  => 'required'
            //'medios'      => 'required|regex:/(^([a-zA-z\s\d]+)?$)/i'
            //'rubro_desc'  => 'min:1|max:80|required|regex:/(^([a-zA-zñÑ%()=.\s\d]+)?$)/iñÑ'
        ];
    }
}
