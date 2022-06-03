<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class finanavancesRequest extends FormRequest
{
    public function messages()
    {
        return [
            'periodo_id.required'  => 'El periodo fiscal es obligatorio.',
            'prog_id.required'     => 'Programa y/o acción es obligatorio.',            
            'ftefinan_id.required' => 'Fuente de financiamiento es obligatorio.',
            'finan_avance.numeric' => 'Monto del avance presupuestado debe ser numerico.',            
            'finan_avance.required'=> 'Monto del avance presupuestado es obligatorio', 
            'finan_a01.numeric'    => 'Monto del avance del mes de enero debe ser numerico.',            
            'finan_a01.required'   => 'Monto del avance del mes de enero es obligatorio', 
            'finan_a02.numeric'    => 'Monto del avance del mes de febrero debe ser numerico.',            
            'finan_a02.required'   => 'Monto del avance del mes de febrero es obligatorio', 
            'finan_a03.numeric'    => 'Monto del avance del mes de marzo debe ser numerico.',            
            'finan_a03.required'   => 'Monto del avance del mes de marzo es obligatorio', 
            'finan_a04.numeric'    => 'Monto del avance del mes de abril debe ser numerico.',            
            'finan_a04.required'   => 'Monto del avance del mes de abril es obligatorio', 
            'finan_a05.numeric'    => 'Monto del avance del mes de mayo debe ser numerico.',            
            'finan_a05.required'   => 'Monto del avance del mes de mayo es obligatorio', 
            'finan_a06.numeric'    => 'Monto del avance del mes de junio debe ser numerico.',            
            'finan_a06.required'   => 'Monto del avance del mes de junio es obligatorio', 
            'finan_a07.numeric'    => 'Monto del avance del mes de julio debe ser numerico.',            
            'finan_a07.required'   => 'Monto del avance del mes de julio es obligatorio', 
            'finan_a08.numeric'    => 'Monto del avance del mes de agosto debe ser numerico.',            
            'finan_a08.required'   => 'Monto del avance del mes de agosto es obligatorio', 
            'finan_a09.numeric'    => 'Monto del avance del mes de septiembre debe ser numerico.',            
            'finan_a09.required'   => 'Monto del avance del mes de septiembre es obligatorio', 
            'finan_a10.numeric'    => 'Monto del avance del mes de octubre debe ser numerico.',            
            'finan_a10.required'   => 'Monto del avance del mes de octubre es obligatorio', 
            'finan_a11.numeric'    => 'Monto del avance del mes de noviembre debe ser numerico.',            
            'finan_a11.required'   => 'Monto del avance del mes de noviembre es obligatorio', 
            'finan_a12.numeric'    => 'Monto del avance del mes de diciembre debe ser numerico.',            
            'finan_a12.required'   => 'Monto del avance del mes de diciembre es obligatorio'                        
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
            'periodo_id'  => 'required',      
            'prog_id'     => 'required',  
            'finan_avance'=> 'required',  
            'finan_a01'   => 'required',  
            'finan_a02'   => 'required',
            'finan_a03'   => 'required',
            'finan_a04'   => 'required',  
            'finan_a05'   => 'required',
            'finan_a06'   => 'required',            
            'finan_a07'   => 'required',  
            'finan_a08'   => 'required',
            'finan_a09'   => 'required',
            'finan_a10'   => 'required',  
            'finan_a11'   => 'required',
            'finan_a12'   => 'required'            
        ];
    }
}
