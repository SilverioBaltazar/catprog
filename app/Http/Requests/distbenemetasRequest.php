<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class distbenemetasRequest extends FormRequest
{
    public function messages()
    {
        return [
            'periodo_id.required'  => 'El periodo fiscal es obligatorio.',
            'prog_id.required'     => 'Programa y/o acción es obligatorio.',            
            'bene_meta.numeric'   => 'Total de beneficios debe ser numerico.',            
            'bene_meta.required'  => 'Total de beneficios es obligatorio', 
            'bene_m01.numeric'    => 'Total de beneficios del mes de enero debe ser numerico.',            
            'bene_m01.required'   => 'Total de beneficios del mes de enero es obligatorio', 
            'bene_m02.numeric'    => 'Total de beneficios del mes de febrero debe ser numerico.',            
            'bene_m02.required'   => 'Total de beneficios del mes de febrero es obligatorio', 
            'bene_m03.numeric'    => 'Total de beneficios del mes de marzo debe ser numerico.',            
            'bene_m03.required'   => 'Total de beneficios del mes de marzo es obligatorio', 
            'bene_m04.numeric'    => 'Total de beneficios del mes de abril debe ser numerico.',            
            'bene_m04.required'   => 'Total de beneficios del mes de abril es obligatorio', 
            'bene_m05.numeric'    => 'Total de beneficios del mes de mayo debe ser numerico.',            
            'bene_m05.required'   => 'Total de beneficios del mes de mayo es obligatorio', 
            'bene_m06.numeric'    => 'Total de beneficios del mes de junio debe ser numerico.',            
            'bene_m06.required'   => 'Total de beneficios del mes de junio es obligatorio', 
            'bene_m07.numeric'    => 'Total de beneficios del mes de julio debe ser numerico.',            
            'bene_m07.required'   => 'Total de beneficios del mes de julio es obligatorio', 
            'bene_m08.numeric'    => 'Total de beneficios del mes de agosto debe ser numerico.',            
            'bene_m08.required'   => 'Total de beneficios del mes de agosto es obligatorio', 
            'bene_m09.numeric'    => 'Total de beneficios del mes de septiembre debe ser numerico.',            
            'bene_m09.required'   => 'Total de beneficios del mes de septiembre es obligatorio', 
            'bene_m10.numeric'    => 'Total de beneficios del mes de octubre debe ser numerico.',            
            'bene_m10.required'   => 'Total de beneficios del mes de octubre es obligatorio', 
            'bene_m11.numeric'    => 'Total de beneficios del mes de noviembre debe ser numerico.',            
            'bene_m11.required'   => 'Total de beneficios del mes de noviembre es obligatorio', 
            'bene_m12.numeric'    => 'Total de beneficios del mes de diciembre debe ser numerico.',            
            'bene_m12.required'   => 'Total de beneficios del mes de diciembre es obligatorio'                        
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
            'bene_meta' => 'required',  
            'bene_m01'  => 'required',  
            'bene_m02'  => 'required',
            'bene_m03'  => 'required',
            'bene_m04'  => 'required',  
            'bene_m05'  => 'required',
            'bene_m06'  => 'required',            
            'bene_m07'  => 'required',  
            'bene_m08'  => 'required',
            'bene_m09'  => 'required',
            'bene_m10'  => 'required',  
            'bene_m11'  => 'required',
            'bene_m12'  => 'required'            
        ];
    }
}
