<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regPrioridadModel extends Model
{
    protected $table      = "CP_CAT_PRIORIDAD";
    protected $primaryKey = 'PRIORIDAD_ID';
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'PRIORIDAD_ID', 
        'PRIORIDAD_DESC'
    ];
}
