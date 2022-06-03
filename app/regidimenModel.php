<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regidimenModel extends Model
{
    protected $table      = "CP_CAT_INDICADOR_DIMENSION";
    protected $primaryKey = 'IDIMENSION_ID';
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'IDIMENSION_ID',
		'IDIMENSION_DESC',
		'IDIMENSION_STATUS',
		'FECREG'
    ];
}
