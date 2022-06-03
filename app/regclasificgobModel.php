<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regclasificgobModel extends Model
{
    protected $table = "CP_CAT_CLASIFICGOB";
    protected  $primaryKey = 'CLASIFICGGOB_ID';
    public $timestamps = false;
    public $incrementing = false;
    protected $fillable = [
	    'CLASIFICGOB_ID', 
	    'CLASIFICGOB_DESC'
    ];

    public static function ObtClasific($id){
    	return (estructurasModel::where('CLASIFICGOB_ID','like','%'.$id.'%')->get());
    }

    public static function Estructuras(){
        return (estructurasModel::select('ESTRUCGOB_ID','ESTRUCGOB_DESC')
                                    ->whereRaw("ESTRUCGOB_ID like '%22400%' OR ESTRUCGOB_ID like '%21500%' OR ESTRUCGOB_ID like '%21200%' OR ESTRUCGOB_ID like '%20400%' OR ESTRUCGOB_ID like '%21700%' OR ESTRUCGOB_ID like '%20700%'  OR ESTRUCGOB_ID like '%22500%'")
                                    ->get());
    }
}
