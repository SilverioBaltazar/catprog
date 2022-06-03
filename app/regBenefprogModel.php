<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regBenefprogModel extends Model
{
    protected $table      = "CP_BENEFICIOS_PROGRAMA";
    protected $primaryKey = ['PERIODO_ID','PROG_ID','BENEF_ID'];
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'PERIODO_ID',
        'PROG_ID',
        'BENEF_ID',
        'BENEF_DESC',
        'PERIODICI_ID',
        'BENEF_COSTOUNIT',
        'OBJ_STATUS1',
        'OBJ_STATUS2',
        'FEC_REG',
        'FEC_REG2',
        'IP',
        'LOGIN',
        'FECHA_M',
        'FECHA_M2',
        'IP_M',
        'LOGIN_M',
        'ID'
    ];

    
}