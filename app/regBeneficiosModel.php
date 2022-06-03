<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regBeneficiosModel extends Model
{
    protected $table      = "CP_CAT_BENEFICIOS";
    protected $primaryKey = 'BENEF_ID'; 
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'BENEF_ID',
        'BENEF_DESC',
        'BENEF_DESC2',
        'BENEF_APOYO',
        'BENEF_PERIODICI',
        'BENEF_TIPO',
        'BENEF_CANT',
        'BENEF_COSTOUNIT',
        'BENEF_COSTOMENSUAL',
        'BENEF_COSTOANUAL',
        'UMEDIDA_DESC',
        'SEPUBLICA',
        'STATUS_1',
        'STATUS_2',
        'FEC_REG',
        'FEC_REG2',
        'LOGIN',
        'FECHA_M',
        'FECHA_M2',
        'IP_M',
        'IP'
    ];

    //***************************************//
    // *** Como se usa el query scope  ******//
    //***************************************// 
    public function scopefPer($query, $fper)
    {
        if($fper)
            return $query->orwhere('PERIODO_ID', '=', "$fper");
    }

    public function scopeIdd($query, $idd)
    {
        if($idd)
            return $query->orwhere('IAP_ID', '=', "$idd");
    }    
    public function scopeNameiap($query, $nameiap)
    {
        if($nameiap) 
            return $query->orwhere('IAP_DESC', 'LIKE', "%$nameiap%");
    } 
 
}
