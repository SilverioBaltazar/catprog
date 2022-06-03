<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regFuentesfinanModel extends Model
{
    protected $table      = "CP_CAT_FUENTES_FINAN";
    protected $primaryKey = 'FTEFINAN_ID';
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'FTEFINAN_ID',
        'FTEFINAN_DESC',
        'FTEFINAN_STATUS', //S ACTIVO      N INACTIVO
        'FTEFINAN_FECREG'
    ];
}