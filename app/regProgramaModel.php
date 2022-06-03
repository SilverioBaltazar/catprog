<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regProgramaModel extends Model
{
    protected $table      = "CP_CAT_PROGRAMA";
    protected $primaryKey = 'PROG_ID';
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
    'PROG_ID', 
    'PROG_DESC', 
    'PROG_STATUS', 
    'PROG_FECREG', 
    'PDEM_ID', 
    'FIN_ID', 
    'FUNCION_ID', 
    'SUBFUN_ID'     
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
