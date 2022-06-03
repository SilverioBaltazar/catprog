<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class distbenefmetasRequest extends FormRequest
{
    public function messages()
    {
        return [
            'periodo_id.required'  => 'El periodo fiscal es obligatorio.',
            'prog_id.required'     => 'Programa y/o acción es obligatorio.',            
            'benef_meta.numeric'   => 'Total de beneficiarios debe ser numerico.',            
            'benef_meta.required'  => 'Total de beneficiarios es obligatorio', 
            'benef_m01.numeric'    => 'Total de beneficiarios del mes de enero debe ser numerico.',            
            'benef_m01.required'   => 'Total de beneficiarios del mes de enero es obligatorio', 
            'benef_m02.numeric'    => 'Total de beneficiarios del mes de febrero debe ser numerico.',            
            'benef_m02.required'   => 'Total de beneficiarios del mes de febrero es obligatorio', 
            'benef_m03.numeric'    => 'Total de beneficiarios del mes de marzo debe ser numerico.',            
            'benef_m03.required'   => 'Total de beneficiarios del mes de marzo es obligatorio', 
            'benef_m04.numeric'    => 'Total de beneficiarios del mes de abril debe ser numerico.',            
            'benef_m04.required'   => 'Total de beneficiarios del mes de abril es obligatorio', 
            'benef_m05.numeric'    => 'Total de beneficiarios del mes de mayo debe ser numerico.',            
            'benef_m05.required'   => 'Total de beneficiarios del mes de mayo es obligatorio', 
            'benef_m06.numeric'    => 'Total de beneficiarios del mes de junio debe ser numerico.',            
            'benef_m06.required'   => 'Total de beneficiarios del mes de junio es obligatorio', 
            'benef_m07.numeric'    => 'Total de beneficiarios del mes de julio debe ser numerico.',            
            'benef_m07.required'   => 'Total de beneficiarios del mes de julio es obligatorio', 
            'benef_m08.numeric'    => 'Total de beneficiarios del mes de agosto debe ser numerico.',            
            'benef_m08.required'   => 'Total de beneficiarios del mes de agosto es obligatorio', 
            'benef_m09.numeric'    => 'Total de beneficiarios del mes de septiembre debe ser numerico.',            
            'benef_m09.required'   => 'Total de beneficiarios del mes de septiembre es obligatorio', 
            'benef_m10.numeric'    => 'Total de beneficiarios del mes de octubre debe ser numerico.',            
            'benef_m10.required'   => 'Total de beneficiarios del mes de octubre es obligatorio', 
            'benef_m11.numeric'    => 'Total de beneficiarios del mes de noviembre debe ser numerico.',            
            'benef_m11.required'   => 'Total de beneficiarios del mes de noviembre es obligatorio', 
            'benef_m12.numeric'    => 'Total de beneficiarios del mes de diciembre debe ser numerico.',            
            'benef_m12.required'   => 'Total de beneficiarios del mes de diciembre es obligatorio'                        
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
            'benef_meta' => 'required',  
            'benef_m01'  => 'required',  
            'benef_m02'  => 'required',
            'benef_m03'  => 'required',
            'benef_m04'  => 'required',  
            'benef_m05'  => 'required',
            'benef_m06'  => 'required',            
            'benef_m07'  => 'required',  
            'benef_m08'  => 'required',
            'benef_m09'  => 'required',
            'benef_m10'  => 'required',  
            'benef_m11'  => 'required',
            'benef_m12'  => 'required'            
        ];
    }
}
