<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regProyectosModel extends Model
{
    protected $table = "CP_CAT_PROYECTOS";
    protected  $primaryKey = 'PROY_ID';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
	    'PROY_ID', 
        'PROY_DESC', 
        'PROY_STATUS', 
        'PROY_FECREG', 
        'FIN_ID', 
        'FUNCION_ID', 
        'SUBFUN_ID', 
        'PROG_ID', 
        'SUBPROG_ID', 
        'PROY'
    ];
}
