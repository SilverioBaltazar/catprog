<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regTipogastoModel extends Model
{
    protected $table      = "CP_CAT_CLASIF_TIPOGASTO";
    protected $primaryKey = 'CTGASTO_ID';
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'CTGASTO_ID',
        'CTGASTO_DESC',
        'CTGASTO_STATUS',
        'CTGASTO_FECREG'
    ];
}