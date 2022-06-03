<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class distbeneavancesRequest extends FormRequest
{
    public function messages()
    {
        return [
            'periodo_id.required' => 'El periodo fiscal es obligatorio.',
            'prog_id.required'    => 'Programa y/o acción es obligatorio.',            
            'bene_avance.numeric' => 'Total de beneficios avance debe ser numerico.',            
            'bene_avance.required'=> 'Total de beneficios avance es obligatorio', 
            'bene_a01.numeric'    => 'Total de beneficios del mes de enero debe ser numerico.',            
            'bene_a01.required'   => 'Total de beneficios del mes de enero es obligatorio', 
            'bene_a02.numeric'    => 'Total de beneficios del mes de febrero debe ser numerico.',            
            'bene_a02.required'   => 'Total de beneficios del mes de febrero es obligatorio', 
            'bene_a03.numeric'    => 'Total de beneficios del mes de marzo debe ser numerico.',            
            'bene_a03.required'   => 'Total de beneficios del mes de marzo es obligatorio', 
            'bene_a04.numeric'    => 'Total de beneficios del mes de abril debe ser numerico.',            
            'bene_a04.required'   => 'Total de beneficios del mes de abril es obligatorio', 
            'bene_a05.numeric'    => 'Total de beneficios del mes de mayo debe ser numerico.',            
            'bene_a05.required'   => 'Total de beneficios del mes de mayo es obligatorio', 
            'bene_a06.numeric'    => 'Total de beneficios del mes de junio debe ser numerico.',            
            'bene_a06.required'   => 'Total de beneficios del mes de junio es obligatorio', 
            'bene_a07.numeric'    => 'Total de beneficios del mes de julio debe ser numerico.',            
            'bene_a07.required'   => 'Total de beneficios del mes de julio es obligatorio', 
            'bene_a08.numeric'    => 'Total de beneficios del mes de agosto debe ser numerico.',            
            'bene_a08.required'   => 'Total de beneficios del mes de agosto es obligatorio', 
            'bene_a09.numeric'    => 'Total de beneficios del mes de septiembre debe ser numerico.',            
            'bene_a09.required'   => 'Total de beneficios del mes de septiembre es obligatorio', 
            'bene_a10.numeric'    => 'Total de beneficios del mes de octubre debe ser numerico.',            
            'bene_a10.required'   => 'Total de beneficios del mes de octubre es obligatorio', 
            'bene_a11.numeric'    => 'Total de beneficios del mes de noviembre debe ser numerico.',            
            'bene_a11.required'   => 'Total de beneficios del mes de noviembre es obligatorio', 
            'bene_a12.numeric'    => 'Total de beneficios del mes de diciembre debe ser numerico.',            
            'bene_a12.required'   => 'Total de beneficios del mes de diciembre es obligatorio'                        
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
            'bene_avance'=> 'required',  
            'bene_a01'   => 'required',  
            'bene_a02'   => 'required',
            'bene_a03'   => 'required',
            'bene_a04'   => 'required',  
            'bene_a05'   => 'required',
            'bene_a06'   => 'required',            
            'bene_a07'   => 'required',  
            'bene_a08'   => 'required',
            'bene_a09'   => 'required',
            'bene_a10'   => 'required',  
            'bene_a11'   => 'required',
            'bene_a12'   => 'required'            
        ];
    }
}
