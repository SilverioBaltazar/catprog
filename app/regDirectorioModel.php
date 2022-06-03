<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regDirectorioModel extends Model
{
    protected $table = "CP_DIRECTORIO";
    protected  $primaryKey = ['PERIODO_ID','PROG_ID'];
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
	    'PERIODO_ID',
		'PROG_ID',
		'DIR_NOMBRE_1',
		'DIR_CARGO_1',
		'DIR_EMAIL_1',
		'DIR_TEL_1',
		'DIR_NOMBRE_2',
		'DIR_CARGO_2',
		'DIR_EMAIL_2',
		'DIR_TEL_2',
		'DIR_NOMBRE_3',
		'DIR_CARGO_3',
		'DIR_EMAIL_3',
		'DIR_TEL_3',
		'DIR_NOMBRE_4',
		'DIR_CARGO_4',
		'DIR_EMAIL_4',
		'DIR_TEL_4',
		'DIR_NOMBRE_5',
		'DIR_CARGO_5',
		'DIR_EMAIL_5',
		'DIR_TEL_5',
		'DIR_OBS_1',
		'DIR_OBS_2',
		'DIR_STATUS1',
		'DIR_STATUS2',
		'FEC_REG',
		'FEC_REG2',
		'IP',
		'LOGIN',
		'FECHA_M',
		'FECHA_M2',
		'IP_M',
		'LOGIN_M'
    ];
}
