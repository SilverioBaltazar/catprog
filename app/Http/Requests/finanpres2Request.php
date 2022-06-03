<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class finanpres2Request extends FormRequest
{
    public function messages()
    {
        return [
            'finan_arc2.required' => 'Archivo digital del Matriz Marco Lógico MML es obligatorio.'
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
            'finan_arc2'   => 'mimes:pdf'
            //'iap_foto2'  => 'required|image'
            //'accion'     => 'required|regex:/(^([a-zA-z%()=.\s\d]+)?$)/i',
            //'medios'     => 'required|regex:/(^([a-zA-z\s\d]+)?$)/i'
            //'rubro_desc' => 'min:1|max:80|required|regex:/(^([a-zA-zñÑ%()=.\s\d]+)?$)/iñÑ'
        ];
    }
}
