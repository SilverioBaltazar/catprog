<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regPreguntasModel extends Model
{
    protected $table      = "CP_CAT_PREGUNTAS";
    protected $primaryKey = 'PREG_ID'; 
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'PREG_ID',
        'PREG_DESC',
        'PREG_TIPO',
        'PREG_OBS1',
        'PREG_OBS2',
        'PREG_STATUS1',
        'PREG_STATUS2',
        'FEC_REG',
        'FEC_REG2',
        'IP',
        'LOGIN',
        'FECHA_M',
        'FECHA_M2',
        'IP_M',
        'LOGIN_M'
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
