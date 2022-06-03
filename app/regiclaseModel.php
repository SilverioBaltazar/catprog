<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regiclaseModel extends Model
{
    protected $table      = "CP_CAT_INDICADOR_CLASE";
    protected $primaryKey = 'ICLASE_ID';
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'ICLASE_ID',
        'ICLASE_DESC',
        'ICLASE_STATUS',
        'FECREG'
    ];
}