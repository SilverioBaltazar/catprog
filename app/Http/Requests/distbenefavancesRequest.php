<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class distbenefavancesRequest extends FormRequest
{
    public function messages()
    {
        return [
            'periodo_id.required'  => 'El periodo fiscal es obligatorio.',
            'prog_id.required'     => 'Programa y/o acción es obligatorio.',            
            'benef_avance.numeric' => 'Total de beneficiarios avance debe ser numerico.',            
            'benef_avance.required'=> 'Total de beneficiarios avance es obligatorio', 
            'benef_a01.numeric'    => 'Total de beneficiarios del mes de enero debe ser numerico.',            
            'benef_a01.required'   => 'Total de beneficiarios del mes de enero es obligatorio', 
            'benef_a02.numeric'    => 'Total de beneficiarios del mes de febrero debe ser numerico.',            
            'benef_a02.required'   => 'Total de beneficiarios del mes de febrero es obligatorio', 
            'benef_a03.numeric'    => 'Total de beneficiarios del mes de marzo debe ser numerico.',            
            'benef_a03.required'   => 'Total de beneficiarios del mes de marzo es obligatorio', 
            'benef_a04.numeric'    => 'Total de beneficiarios del mes de abril debe ser numerico.',            
            'benef_a04.required'   => 'Total de beneficiarios del mes de abril es obligatorio', 
            'benef_a05.numeric'    => 'Total de beneficiarios del mes de mayo debe ser numerico.',            
            'benef_a05.required'   => 'Total de beneficiarios del mes de mayo es obligatorio', 
            'benef_a06.numeric'    => 'Total de beneficiarios del mes de junio debe ser numerico.',            
            'benef_a06.required'   => 'Total de beneficiarios del mes de junio es obligatorio', 
            'benef_a07.numeric'    => 'Total de beneficiarios del mes de julio debe ser numerico.',            
            'benef_a07.required'   => 'Total de beneficiarios del mes de julio es obligatorio', 
            'benef_a08.numeric'    => 'Total de beneficiarios del mes de agosto debe ser numerico.',            
            'benef_a08.required'   => 'Total de beneficiarios del mes de agosto es obligatorio', 
            'benef_a09.numeric'    => 'Total de beneficiarios del mes de septiembre debe ser numerico.',            
            'benef_a09.required'   => 'Total de beneficiarios del mes de septiembre es obligatorio', 
            'benef_a10.numeric'    => 'Total de beneficiarios del mes de octubre debe ser numerico.',            
            'benef_a10.required'   => 'Total de beneficiarios del mes de octubre es obligatorio', 
            'benef_a11.numeric'    => 'Total de beneficiarios del mes de noviembre debe ser numerico.',            
            'benef_a11.required'   => 'Total de beneficiarios del mes de noviembre es obligatorio', 
            'benef_a12.numeric'    => 'Total de beneficiarios del mes de diciembre debe ser numerico.',            
            'benef_a12.required'   => 'Total de beneficiarios del mes de diciembre es obligatorio'                        
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
            'benef_avance'=> 'required',  
            'benef_a01'   => 'required',  
            'benef_a02'   => 'required',
            'benef_a03'   => 'required',
            'benef_a04'   => 'required',  
            'benef_a05'   => 'required',
            'benef_a06'   => 'required',            
            'benef_a07'   => 'required',  
            'benef_a08'   => 'required',
            'benef_a09'   => 'required',
            'benef_a10'   => 'required',  
            'benef_a11'   => 'required',
            'benef_a12'   => 'required'            
        ];
    }
}
