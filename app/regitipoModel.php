<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regitipoModel extends Model
{
    protected $table      = "CP_CAT_INDICADOR_TIPO";
    protected $primaryKey = 'ITIPO_ID';
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'ITIPO_ID',
        'TIPO_DESC',
        'ITIPO_STATUS',
        'FECREG'
    ];

    
}
