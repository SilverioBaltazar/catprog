<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class distmunimetasRequest extends FormRequest
{
    public function messages()
    {
        return [
            'periodo_id.required'  => 'El periodo fiscal es obligatorio.',
            'prog_id.required'     => 'Programa y/o acción es obligatorio.',            
            'municipio_id.required'=> 'El municipio es obligatorio.',
            //'mes_id.required'    => 'El mes es obligatorio.',         
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
            'finan_m12.required'   => 'Monto de la meta del mes de diciembre es obligatorio', 

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
            'benef_m12.required'   => 'Total de beneficiarios del mes de diciembre es obligatorio',

            'bene_meta.numeric'    => 'Total de beneficios debe ser numerico.',            
            'bene_meta.required'   => 'Total de beneficios es obligatorio', 
            'bene_m01.numeric'     => 'Total de beneficios del mes de enero debe ser numerico.',            
            'bene_m01.required'    => 'Total de beneficios del mes de enero es obligatorio', 
            'bene_m02.numeric'     => 'Total de beneficios del mes de febrero debe ser numerico.',            
            'bene_m02.required'    => 'Total de beneficios del mes de febrero es obligatorio', 
            'bene_m03.numeric'     => 'Total de beneficios del mes de marzo debe ser numerico.',            
            'bene_m03.required'    => 'Total de beneficios del mes de marzo es obligatorio', 
            'bene_m04.numeric'     => 'Total de beneficios del mes de abril debe ser numerico.',            
            'bene_m04.required'    => 'Total de beneficios del mes de abril es obligatorio', 
            'bene_m05.numeric'     => 'Total de beneficios del mes de mayo debe ser numerico.',            
            'bene_m05.required'    => 'Total de beneficios del mes de mayo es obligatorio', 
            'bene_m06.numeric'     => 'Total de beneficios del mes de junio debe ser numerico.',            
            'bene_m06.required'    => 'Total de beneficios del mes de junio es obligatorio', 
            'bene_m07.numeric'     => 'Total de beneficios del mes de julio debe ser numerico.',            
            'bene_m07.required'    => 'Total de beneficios del mes de julio es obligatorio', 
            'bene_m08.numeric'     => 'Total de beneficios del mes de agosto debe ser numerico.',            
            'bene_m08.required'    => 'Total de beneficios del mes de agosto es obligatorio', 
            'bene_m09.numeric'     => 'Total de beneficios del mes de septiembre debe ser numerico.',            
            'bene_m09.required'    => 'Total de beneficios del mes de septiembre es obligatorio', 
            'bene_m10.numeric'     => 'Total de beneficios del mes de octubre debe ser numerico.',            
            'bene_m10.required'    => 'Total de beneficios del mes de octubre es obligatorio', 
            'bene_m11.numeric'     => 'Total de beneficios del mes de noviembre debe ser numerico.',            
            'bene_m11.required'    => 'Total de beneficios del mes de noviembre es obligatorio', 
            'bene_m12.numeric'     => 'Total de beneficios del mes de diciembre debe ser numerico.',            
            'bene_m12.required'    => 'Total de beneficios del mes de diciembre es obligatorio'                        
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
            'municipio_id'=> 'required',      
            //'mes_id'    => 'required',
            'finan_meta'  => 'required',  
            'finan_m01'   => 'required',  
            'finan_m02'   => 'required',
            'finan_m03'   => 'required',
            'finan_m04'   => 'required',  
            'finan_m05'   => 'required',
            'finan_m06'   => 'required',            
            'finan_m07'   => 'required',  
            'finan_m08'   => 'required',
            'finan_m09'   => 'required',
            'finan_m10'   => 'required',  
            'finan_m11'   => 'required',
            'finan_m12'   => 'required',

            'benef_meta'  => 'required',  
            'benef_m01'   => 'required',  
            'benef_m02'   => 'required',
            'benef_m03'   => 'required',
            'benef_m04'   => 'required',  
            'benef_m05'   => 'required',
            'benef_m06'   => 'required',            
            'benef_m07'   => 'required',  
            'benef_m08'   => 'required',
            'benef_m09'   => 'required',
            'benef_m10'   => 'required',  
            'benef_m11'   => 'required',
            'benef_m12'   => 'required',

            'bene_meta'   => 'required',  
            'bene_m01'    => 'required',  
            'bene_m02'    => 'required',
            'bene_m03'    => 'required',
            'bene_m04'    => 'required',  
            'bene_m05'    => 'required',
            'bene_m06'    => 'required',            
            'bene_m07'    => 'required',  
            'bene_m08'    => 'required',
            'bene_m09'    => 'required',
            'bene_m10'    => 'required',  
            'bene_m11'    => 'required',
            'bene_m12'    => 'required'            
        ];
    }
}
