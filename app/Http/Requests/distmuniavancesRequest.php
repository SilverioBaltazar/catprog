<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class distmuniavancesRequest extends FormRequest
{
    public function messages()
    {
        return [
            'periodo_id.required'  => 'Periodo fiscal es obligatorio.',
            'prog_id.required'     => 'Programa y/o acción es obligatorio.',            
            'municipio_id.required'=> 'Municipio es obligatorio.',
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
            'finan_a12.required'   => 'Monto del avance del mes de diciembre es obligatorio',

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
            'benef_a12.required'   => 'Total de beneficiarios del mes de diciembre es obligatorio',

            'bene_avance.numeric'  => 'Total de beneficios avance debe ser numerico.',            
            'bene_avance.required' => 'Total de beneficios avance es obligatorio', 
            'bene_a01.numeric'     => 'Total de beneficios del mes de enero debe ser numerico.',            
            'bene_a01.required'    => 'Total de beneficios del mes de enero es obligatorio', 
            'bene_a02.numeric'     => 'Total de beneficios del mes de febrero debe ser numerico.',            
            'bene_a02.required'    => 'Total de beneficios del mes de febrero es obligatorio', 
            'bene_a03.numeric'     => 'Total de beneficios del mes de marzo debe ser numerico.',            
            'bene_a03.required'    => 'Total de beneficios del mes de marzo es obligatorio', 
            'bene_a04.numeric'     => 'Total de beneficios del mes de abril debe ser numerico.',            
            'bene_a04.required'    => 'Total de beneficios del mes de abril es obligatorio', 
            'bene_a05.numeric'     => 'Total de beneficios del mes de mayo debe ser numerico.',            
            'bene_a05.required'    => 'Total de beneficios del mes de mayo es obligatorio', 
            'bene_a06.numeric'     => 'Total de beneficios del mes de junio debe ser numerico.',            
            'bene_a06.required'    => 'Total de beneficios del mes de junio es obligatorio', 
            'bene_a07.numeric'     => 'Total de beneficios del mes de julio debe ser numerico.',            
            'bene_a07.required'    => 'Total de beneficios del mes de julio es obligatorio', 
            'bene_a08.numeric'     => 'Total de beneficios del mes de agosto debe ser numerico.',            
            'bene_a08.required'    => 'Total de beneficios del mes de agosto es obligatorio', 
            'bene_a09.numeric'     => 'Total de beneficios del mes de septiembre debe ser numerico.',            
            'bene_a09.required'    => 'Total de beneficios del mes de septiembre es obligatorio', 
            'bene_a10.numeric'     => 'Total de beneficios del mes de octubre debe ser numerico.',            
            'bene_a10.required'    => 'Total de beneficios del mes de octubre es obligatorio', 
            'bene_a11.numeric'     => 'Total de beneficios del mes de noviembre debe ser numerico.',            
            'bene_a11.required'    => 'Total de beneficios del mes de noviembre es obligatorio', 
            'bene_a12.numeric'     => 'Total de beneficios del mes de diciembre debe ser numerico.',            
            'bene_a12.required'    => 'Total de beneficios del mes de diciembre es obligatorio'
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
            'finan_a12'   => 'required',

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
            'benef_a12'   => 'required',  

            'bene_avance' => 'required',  
            'bene_a01'    => 'required',  
            'bene_a02'    => 'required',
            'bene_a03'    => 'required',
            'bene_a04'    => 'required',  
            'bene_a05'    => 'required',
            'bene_a06'    => 'required',            
            'bene_a07'    => 'required',  
            'bene_a08'    => 'required',
            'bene_a09'    => 'required',
            'bene_a10'    => 'required',  
            'bene_a11'    => 'required',
            'bene_a12'    => 'required'                               
        ];
    }
}
