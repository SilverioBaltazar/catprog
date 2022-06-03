<?php
/*
Clase modelo: regMunicipioModel
Descripción: esta clase se creó para poder utilizar los datos de este catálogo de municipios
*/
namespace App;

use Illuminate\Database\Eloquent\Model;

class regMunicipiosModel extends Model
{
    protected $table      = "CP_CAT_MUNICIPIOS_SEDESEM";
    protected $primaryKey = ['ENTIDADFEDERATIVA_ID','MUNICIPIO_ID'];
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'ENTIDADFEDERATIVA_ID',
        'MUNICIPIO_ID',
        'MUNICIPIO', //S ACTIVO      N INACTIVO
        'REGION_ID',
        'GEOREF_LATDECIMAL',
        'GEOREF_LONGDECIMAL'
    ];

    /*****************************************************************************************************
    Función Municipios(): Obtiene todos los municipios pertenecientes a la clave de la entidad federativa 
                          igual al parámetro que viene en la función.
    *****************************************************************************************************/    
    public static function Municipios($id){
        return regMunicipioModel::where('ENTIDADFEDERATIVAID',$id)
                                  ->orderBy('MUNICIPIONOMBRE','asc')
                                  ->get();
    }


}