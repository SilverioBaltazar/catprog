<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regPeriodicidadModel extends Model
{
    protected $table      = "CP_CAT_PERIODICIDAD";
    protected $primaryKey = 'PERIODICI_ID';
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'PERIODICI_ID',
        'PERIODICI_DESC',
        'PERIODICI_STATUS', //S ACTIVO      N INACTIVO
        'FECREG'
    ];

    public static function ObtFrec($id){
        return (regPerModel::select('PER_FREC')->where('PER_ID','=',$id)
                             ->get());
    }
}