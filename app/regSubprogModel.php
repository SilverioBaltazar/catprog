<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regSubprogModel extends Model
{
    protected $table      = "CP_CAT_SUBPROG";
    protected $primaryKey = 'SUBPROG_ID';
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'SUBPROG_ID', 
        'SUBPROG_DESC', 
        'SUBPROG_STATUS', 
        'SUBPROG_FECREG', 
        'FIN_ID', 
        'FUNCION_ID', 
        'SUBFUN_ID', 
        'PROG_ID'
    ];
}
