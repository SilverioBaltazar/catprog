<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class indimetasRequest extends FormRequest
{
    public function messages()
    {
        return [
            'periodo_id.required'   => 'El periodo fiscal es obligatorio.',
            'prog_id.required'      => 'Programa y/o acción es obligatorio.',            
            //'indi_id.required'    => 'Indicador es obligatorio.',
            'indi_desc.required'    => 'Nombre del indicador es obligatorio.',
            'iclase_id.required'    => 'Clase de indicador es obligatorio.',
            'itipo_id.required'     => 'Tipo de indicador es obligatorio.',
            'idimension_id.required'=> 'Dimensión del indicador es obligatorio.',
            'indi_meta.numeric'     => 'Monto de la meta del total presupuestado debe ser numerico.',            
            'indi_meta.required'    => 'Monto de la meta del total presupuestado es obligatorio', 
            'indi_m01.numeric'      => 'Monto de la meta del mes de enero debe ser numerico.',            
            'indi_m01.required'     => 'Monto de la meta del mes de enero es obligatorio', 
            'indi_m02.numeric'      => 'Monto de la meta del mes de febrero debe ser numerico.',            
            'indi_m02.required'     => 'Monto de la meta del mes de febrero es obligatorio', 
            'indi_m03.numeric'      => 'Monto de la meta del mes de marzo debe ser numerico.',            
            'indi_m03.required'     => 'Monto de la meta del mes de marzo es obligatorio', 
            'indi_m04.numeric'      => 'Monto de la meta del mes de abril debe ser numerico.',            
            'indi_m04.required'     => 'Monto de la meta del mes de abril es obligatorio', 
            'indi_m05.numeric'      => 'Monto de la meta del mes de mayo debe ser numerico.',            
            'indi_m05.required'     => 'Monto de la meta del mes de mayo es obligatorio', 
            'indi_m06.numeric'      => 'Monto de la meta del mes de junio debe ser numerico.',            
            'indi_m06.required'     => 'Monto de la meta del mes de junio es obligatorio', 
            'indi_m07.numeric'      => 'Monto de la meta del mes de julio debe ser numerico.',            
            'indi_m07.required'     => 'Monto de la meta del mes de julio es obligatorio', 
            'indi_m08.numeric'      => 'Monto de la meta del mes de agosto debe ser numerico.',            
            'indi_m08.required'     => 'Monto de la meta del mes de agosto es obligatorio', 
            'indi_m09.numeric'      => 'Monto de la meta del mes de septiembre debe ser numerico.',            
            'indi_m09.required'     => 'Monto de la meta del mes de septiembre es obligatorio', 
            'indi_m10.numeric'      => 'Monto de la meta del mes de octubre debe ser numerico.',            
            'indi_m10.required'     => 'Monto de la meta del mes de octubre es obligatorio', 
            'indi_m11.numeric'      => 'Monto de la meta del mes de noviembre debe ser numerico.',            
            'indi_m11.required'     => 'Monto de la meta del mes de noviembre es obligatorio', 
            'indi_m12.numeric'      => 'Monto de la meta del mes de diciembre debe ser numerico.',            
            'indi_m12.required'     => 'Monto de la meta del mes de diciembre es obligatorio'                        
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
            'indi_desc'    => 'required',  
            'iclase_id'    => 'required',  
            'itipo_id'     => 'required',  
            'idimension_id'=> 'required',  
            'indi_meta'    => 'required',  
            'indi_m01'     => 'required',  
            'indi_m02'     => 'required',
            'indi_m03'     => 'required',
            'indi_m04'     => 'required',  
            'indi_m05'     => 'required',
            'indi_m06'     => 'required',            
            'indi_m07'     => 'required',  
            'indi_m08'     => 'required',
            'indi_m09'     => 'required',
            'indi_m10'     => 'required',  
            'indi_m11'     => 'required',
            'indi_m12'     => 'required'            
        ];
    }
}
