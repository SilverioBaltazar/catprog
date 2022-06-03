<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class indiavanRequest extends FormRequest
{
    public function messages()
    {
        return [
            'periodo_id.required'   => 'El periodo fiscal es obligatorio.',
            'prog_id.required'      => 'Programa y/o acción es obligatorio.',            
            'indi_id.required'      => 'Indicador es obligatorio.',
            'iclase_id.required'    => 'Clase de indicador es obligatorio.',
            'itipo_id.required'     => 'Tipo de indicador es obligatorio.',
            'idimension_id.required'=> 'Dimensión del indicador es obligatorio.',
            'indi_avance.numeric'   => 'Total de avance presupuestado debe ser numerico.',            
            'indi_avance.required'  => 'Total de avance presupuestado es obligatorio', 
            'indi_a01.numeric'      => 'Total de avance del mes de enero debe ser numerico.',            
            'indi_a01.required'     => 'Total de avance del mes de enero es obligatorio', 
            'indi_a02.numeric'      => 'Total de avance del mes de febrero debe ser numerico.',            
            'indi_a02.required'     => 'Total de avance del mes de febrero es obligatorio', 
            'indi_a03.numeric'      => 'Total de avance del mes de marzo debe ser numerico.',            
            'indi_a03.required'     => 'Total de avance del mes de marzo es obligatorio', 
            'indi_a04.numeric'      => 'Total de avance del mes de abril debe ser numerico.',            
            'indi_a04.required'     => 'Total de avance del mes de abril es obligatorio', 
            'indi_a05.numeric'      => 'Total de avance del mes de mayo debe ser numerico.',            
            'indi_a05.required'     => 'Total de avance del mes de mayo es obligatorio', 
            'indi_a06.numeric'      => 'Total de avance del mes de junio debe ser numerico.',            
            'indi_a06.required'     => 'Total de avance del mes de junio es obligatorio', 
            'indi_a07.numeric'      => 'Total de avance del mes de julio debe ser numerico.',            
            'indi_a07.required'     => 'Total de avance del mes de julio es obligatorio', 
            'indi_a08.numeric'      => 'Total de avance del mes de agosto debe ser numerico.',            
            'indi_a08.required'     => 'Total de avance del mes de agosto es obligatorio', 
            'indi_a09.numeric'      => 'Total de avance del mes de septiembre debe ser numerico.',            
            'indi_a09.required'     => 'Total de avance del mes de septiembre es obligatorio', 
            'indi_a10.numeric'      => 'Total de avance del mes de octubre debe ser numerico.',            
            'indi_a10.required'     => 'Total de avance del mes de octubre es obligatorio', 
            'indi_a11.numeric'      => 'Total de avance del mes de noviembre debe ser numerico.',            
            'indi_a11.required'     => 'Total de avance del mes de noviembre es obligatorio', 
            'indi_a12.numeric'      => 'Total de avance del mes de diciembre debe ser numerico.',            
            'indi_a12.required'     => 'Total de avance del mes de diciembre es obligatorio'                        
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
            'indi_id'      => 'required',  
            'iclase_id'    => 'required',  
            'itipo_id'     => 'required',  
            'idimension_id'=> 'required',  
            'indi_avance'  => 'required',  
            'indi_a01'     => 'required',  
            'indi_a02'     => 'required',
            'indi_a03'     => 'required',
            'indi_a04'     => 'required',  
            'indi_a05'     => 'required',
            'indi_a06'     => 'required',            
            'indi_a07'     => 'required',  
            'indi_a08'     => 'required',
            'indi_a09'     => 'required',
            'indi_a10'     => 'required',  
            'indi_a11'     => 'required',
            'indi_a12'     => 'required'            
        ];
    }
}
