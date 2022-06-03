<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regFuentesModel extends Model
{
    protected $table      = "CP_CAT_FUENTES";
    protected $primaryKey = 'FUENTE_ID';
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'FUENTE_ID',
        'FUENTE_DESC',
        'FUENTE_STATUS', //S ACTIVO      N INACTIVO
        'FUENTE_FECREG'
    ];
}