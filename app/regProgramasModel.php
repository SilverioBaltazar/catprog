<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regProgramasModel extends Model
{
    protected $table      = "CP_CAT_PROGRAMAS ";
    protected $primaryKey = 'PROG_ID';
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'PROG_ID', 
        'PROG_DESC', 
        'PROG_VERTI', 
        'PROG_SIGLAS', 
        'PROG_VIGENTE', 
        'PROG_ORDEN', 
        'PROG_TIPO', 
        'PROG_SEPUBLICA', 
        'PROG_OBS1', 
        'PROG_OBS2', 
        'CLASIFICGOB_ID', 
        'PRIORIDAD_ID',         
        'PROG_STATUS1', 
        'PROG_STATUS2', 
        'PROG_FECREG'
    ];

    //***************************************//
    // *** Como se usa el query scope  ******//
    //***************************************//
    public function scopeName($query, $name)
    {
        if($name)
            return $query->where('PROG_DESC', 'LIKE', "%$name%");
    }  
      
    
}
