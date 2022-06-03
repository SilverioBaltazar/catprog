<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regDepprogsModel extends Model
{
    protected $table      = "CP_DEPEN_PROGRAMAS";
    protected $primaryKey = 'PROG_ID';
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'DEPEN_ID1', 
        'DEPEN_ID2', 
        'DEPEN_ID3',
        'PROG_ID', 
        'ESTRUCGOB_ID', 
        'CLASIFICGOB_ID',
        'FECHA_REG',
        'FECHA_REG2',
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
    public function scopePer($query, $per)
    {
        if($per)
            return $query->where('PERIODO_ID', '=', "$per");
    }

    public function scopeIapp($query, $iapp)
    {
        if($iapp)
            return $query->where('IAP_ID', '=', "$iapp");
    }

    public function scopeBio($query, $bio)
    {
        if($bio)
            return $query->where('IAP_OBJSOC', 'LIKE', "%$bio%");
    } 

}