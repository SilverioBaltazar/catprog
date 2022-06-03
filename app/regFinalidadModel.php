<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regFinalidadModel extends Model
{
protected $table      = "CP_CAT_FINALIDAD";
    protected $primaryKey = 'FIN_ID';
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
    'FIN_ID', 
    'FIN_DESC', 
    'FIN_STATUS', 
    'FIN_FECREG'     
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
