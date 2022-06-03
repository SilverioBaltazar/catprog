<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regFinanpresModel extends Model
{
    protected $table      = "CP_FINAN_PRESUP";
    protected $primaryKey = '[PERIODO_ID, PROG_ID]';
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'PERIODO_ID', 
        'PROG_ID', 
        'FIN_ID', 
        'FUNCION_ID', 
        'SUBFUN_ID', 
        'PROGRAM_ID', 
        'SUBPROG_ID', 
        'PROY_ID', 
        'FINAN_ARC1', 
        'FINAN_ARC2', 
        'FINAN_ARC3', 
        'FINAN_ARC4', 
        'FINAN_ARC5', 
        'FINAN_OBS1', 
        'FINAN_OBS2', 
        'FINAN_OBS3', 
        'FINAN_STATUS1', 
        'FINAN_STATUS2', 
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
    public function scopeFolio($query, $folio)
    {
        if($folio)
            return $query->where('FOLIO', '=', $folio);
    }

    public function scopeName($query, $name)
    {
        if($name)
            return $query->where('PROGRAMA_DESC', 'LIKE', "%$name%");
    }

    public function scopeActi($query, $acti)
    {
        if($acti)
            return $query->where('ACTIVIDAD_DESC', 'LIKE', "%$acti%");
    }

    public function scopeBio($query, $bio)
    {
        if($bio)
            return $query->where('OBJETIVO_DESC', 'LIKE', "%$bio%");
    }  
    public function scopeNameiap($query, $nameiap)
    {
        if($nameiap) 
            return $query->where('OSC_DESC', 'LIKE', "%$nameiap%");
    }      
       
}
