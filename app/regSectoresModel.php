<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regSectoresModel extends Model
{
    protected $table = "CP_CAT_SECTORES";
    protected  $primaryKey = '[SECTOR_ID, TGASTO_ID]';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
	    'SECTOR_ID',
        'SECTOR_DESC',
        'SECTOR_STATUS',
        'SECTOR_FECREG',
        'TGASTO_ID'
    ];
}
