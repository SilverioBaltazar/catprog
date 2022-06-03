<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regSubfunModel extends Model
{
    protected $table      = "CP_CAT_SUBFUNCION";
    protected $primaryKey = 'SUBFUN_ID';
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'SUBFUN_ID', 
        'SUBFUN_DESC', 
        'SUBFUN_STATUS', 
        'SUBFUN_FECREG', 
        'FIN_ID', 
        'FUNCION_ID'
    ];
}