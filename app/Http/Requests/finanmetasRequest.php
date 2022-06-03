<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class finanmetasRequest extends FormRequest
{
    public function messages()
    {
        return [
            'periodo_id.required'  => 'El periodo fiscal es obligatorio.',
            'prog_id.required'     => 'Programa y/o acción es obligatorio.',            
            'ftefinan_id.required' => 'Fuente de financiamiento es obligatorio.',
            'finan_meta.numeric'   => 'Monto de la meta del total presupuestado debe ser numerico.',            
            'finan_meta.required'  => 'Monto de la meta del total presupuestado es obligatorio', 
            'finan_m01.numeric'    => 'Monto de la meta del mes de enero debe ser numerico.',            
            'finan_m01.required'   => 'Monto de la meta del mes de enero es obligatorio', 
            'finan_m02.numeric'    => 'Monto de la meta del mes de febrero debe ser numerico.',            
            'finan_m02.required'   => 'Monto de la meta del mes de febrero es obligatorio', 
            'finan_m03.numeric'    => 'Monto de la meta del mes de marzo debe ser numerico.',            
            'finan_m03.required'   => 'Monto de la meta del mes de marzo es obligatorio', 
            'finan_m04.numeric'    => 'Monto de la meta del mes de abril debe ser numerico.',            
            'finan_m04.required'   => 'Monto de la meta del mes de abril es obligatorio', 
            'finan_m05.numeric'    => 'Monto de la meta del mes de mayo debe ser numerico.',            
            'finan_m05.required'   => 'Monto de la meta del mes de mayo es obligatorio', 
            'finan_m06.numeric'    => 'Monto de la meta del mes de junio debe ser numerico.',            
            'finan_m06.required'   => 'Monto de la meta del mes de junio es obligatorio', 
            'finan_m07.numeric'    => 'Monto de la meta del mes de julio debe ser numerico.',            
            'finan_m07.required'   => 'Monto de la meta del mes de julio es obligatorio', 
            'finan_m08.numeric'    => 'Monto de la meta del mes de agosto debe ser numerico.',            
            'finan_m08.required'   => 'Monto de la meta del mes de agosto es obligatorio', 
            'finan_m09.numeric'    => 'Monto de la meta del mes de septiembre debe ser numerico.',            
            'finan_m09.required'   => 'Monto de la meta del mes de septiembre es obligatorio', 
            'finan_m10.numeric'    => 'Monto de la meta del mes de octubre debe ser numerico.',            
            'finan_m10.required'   => 'Monto de la meta del mes de octubre es obligatorio', 
            'finan_m11.numeric'    => 'Monto de la meta del mes de noviembre debe ser numerico.',            
            'finan_m11.required'   => 'Monto de la meta del mes de noviembre es obligatorio', 
            'finan_m12.numeric'    => 'Monto de la meta del mes de diciembre debe ser numerico.',            
            'finan_m12.required'   => 'Monto de la meta del mes de diciembre es obligatorio'                        
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
            'periodo_id' => 'required',      
            'prog_id'    => 'required',  
            'finan_meta' => 'required',  
            'finan_m01'  => 'required',  
            'finan_m02'  => 'required',
            'finan_m03'  => 'required',
            'finan_m04'  => 'required',  
            'finan_m05'  => 'required',
            'finan_m06'  => 'required',            
            'finan_m07'  => 'required',  
            'finan_m08'  => 'required',
            'finan_m09'  => 'required',
            'finan_m10'  => 'required',  
            'finan_m11'  => 'required',
            'finan_m12'  => 'required'            
        ];
    }
}
