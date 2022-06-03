<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regFuncionesModel extends Model
{
    protected $table      = "CP_CAT_FUNCION";
    protected $primaryKey = 'FUNCION_ID';
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'FUNCION_ID',        
        'FUNCION_DESC',
        'FUNCION_STATUS', //S ACTIVO      N INACTIVO
        'FUNCION_FECREG'
        'FIN_ID'
    ];
}