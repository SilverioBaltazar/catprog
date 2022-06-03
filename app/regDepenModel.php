<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regDepenModel extends Model
{
    protected $table = "CP_CAT_DEPENDENCIAS";
    protected  $primaryKey = 'DEPEN_ID';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
	    'DEPEN_ID', 
      'DEPEN_DESC', 
      'ESTRUCTURA_GEM', 
      'CLASIFICACION', 
      'DEPEN_PADRE', 
      'DEPEN_HIJO', 
      'DEPEN_STATUS', 
      'ESTRUCGOB_ID', 
      'CLASIFICGOB_ID', 
      'DEPEN_FECREG', 
      'DEPEN_FECACT'
    ];

    public static function ObtDepen($id){
        return (regDepenModel::select('DEPEN_ID')->where('DEPEN_ID','=',$id)
                             ->get());
    }

    public static function Unidades($id){
        return regDepenModel::select('DEPEN_ID','DEPEN_DESC')
                              ->where('DEPEN_ID','like','%211C04%')
        						          ->where('ESTRUCGOB_ID','like','%'.$id.'%')
                              ->orderBy('DEPEN_ID','asc')
                              ->get();
    }
}
