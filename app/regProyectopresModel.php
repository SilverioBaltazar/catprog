<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regProyectopresModel extends Model
{
    protected $table = "CP_PROYECTO_PRESUP";
    protected  $primaryKey = ['PROG_ID','PROY_ID'];
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
        'PERIODO_ID', 
        'PROG_ID', 
        'FIN_ID', 
        'FUNCION_ID', 
        'SUBFUN_ID', 
        'PROGRAM_ID', 
        'SUBPROG_ID', 
        'PROY_ID',
        'MONTO_PRESUP',
        'MONTO_AUTORIZADO',
        'PROY_ARC1',
        'PROY_ARC2',
        'PROY_ARC3',
        'PROY_OBS1',
        'PROY_OBS2',
        'PROY_STATUS1',
        'PROY_STATUS2',
        'FEC_REG',
        'FEC_REG2',
        'IP',
        'LOGIN',
        'FECHA_M',
        'FECHA_M2',
        'IP_M',
        'LOGIN_M',
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
            return $query->orwhere('OSC_ID', '=', "$idd");
    }    
    public function scopeNameiap($query, $nameiap)
    {
        if($nameiap) 
            return $query->orwhere('OSC_DESC', 'LIKE', "%$nameiap%");
    } 
      
}
