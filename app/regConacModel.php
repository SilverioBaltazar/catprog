<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regConacModel extends Model
{
    protected $table      = "CP_CAT_CONAC";
    protected $primaryKey = 'CONAC_ID';
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'CONAC_ID', 
        'CONAC_DESC', 
        'CONAC_STATUS',
        'CONAC_FECREG'
    ];

    //***************************************//
    // *** Como se usa el query scope  ******//
    //***************************************//
    public function scopeName($query, $name)
    {
        if($name)
            return $query->where('CONAC_DESC', 'LIKE', "%$name%");
    }    
    
}
