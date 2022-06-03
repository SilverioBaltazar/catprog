<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regModalidadModel extends Model
{
    protected $table      = "CP_CAT_MODALIDAD";
    protected $primaryKey = 'MODALIDAD_ID';
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'MODALIDAD_ID', 
        'MODALIDAD_DESC'
    ];
}
