<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class benefprogRequest extends FormRequest
{
    public function messages()
    {
        return [
            'periodo_id.required'     => 'El periodo es obligatorio.',
            'prog_id.required'        => 'El programa es obligatorio.',
            'benef_id.required'       => 'El beneficio es obligatorio',
            'periodici_id.required'   => 'La periodicidad es obligatoria.',
            'benef_costounit.required'=> 'El costo unitario es obligatorio',
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
            'periodo_id'      => 'required',
            'prog_id'         => 'required',            
            'benef_id'        => 'required',          
            'periodici_id'    => 'required',
            'benef_costounit' => 'required'
            //'rubro_desc'    => 'min:1|max:80|required|regex:/(^([a-zA-zñÑ%()=.\s\d]+)?$)/iñÑ'
        ];
    }
}
