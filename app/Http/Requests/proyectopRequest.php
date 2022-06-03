<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class proyectopRequest extends FormRequest
{
    public function messages()
    {
        return [
            'periodo_id.required'   => 'Seleccionar el periodo',
            'prog_id.required'      => 'Seleccionar programa', 
            'proy_id.required'      => 'Seleccionar proyecto presupuestario'
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
            'proy_id'      => 'required'
            //'trx_desc' => 'min:1|max:100|required|regex:/(^([a-zA-z%()=.\s\d]+)?$)/i'
        ];
    }
}
