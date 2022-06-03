<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regSubsectoresModel extends Model
{
    protected $table      = "CP_CAT_SUBSECTORES";
    protected $primaryKey = '[SUBSECTOR_ID, SECTOR_ID]';
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'SUBSECTOR_ID',
        'SUBSECTOR_DESC',
        'SUBSECTOR_STATUS',
        'SUBSECTOR_FECREG',
        'SECTOR_ID'
    ];
}