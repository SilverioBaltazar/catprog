<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
 
class regObjprogModel extends Model
{
    protected $table      = "CP_OBJ_PROGRAMA";
    protected $primaryKey = ['PERIODO_ID','PROG_ID'];
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'PERIODO_ID',
        'PROG_ID',
        'OBJ_PROG',
        'OBJ_META',
        'OBJ_UNI_ATEN',
        'OBJ_COBERTURA',
        'OBJ_REQ_CRITER',
        'OBJ_DOCTOS',
        'OBJ_CRIT_PRIORI',        
        'OBJ_ZONA_ATEN',
        'OBJ_SECTORES_APOYA',
        'OBJ_SEC_01',
        'OBJ_SEC_02',
        'OBJ_SEC_03',
        'OBJ_SEC_04',
        'OBJ_SEC_05',
        'OBJ_SEC_06',
        'OBJ_SEC_07',
        'OBJ_SEC_08',
        'OBJ_SEC_09',
        'OBJ_SEC_10',
        'OBJ_SEC_11',
        'OBJ_SEC_12',
        'OBJ_SEC_13',
        'OBJ_SEC_14',
        'OBJ_SEC_15',
        'OBJ_SEC_16',
        'OBJ_SEC_17',
        'OBJ_SEC_18',
        'OBJ_SEC_19',
        'OBJ_SEC_20',
        'OBJ_SEC_21',
        'OBJ_SEC_22',
        'OBJ_OPER_EJEC1',
        'OBJ_OPER_EJEC2',
        'OBJ_OPER_EJEC3',
        'OBJ_OPER_EJEC4',
        'OBJ_OPER_EJEC5',
        'OBJ_OPER_EJEC6',
        'OBJ_ODS01',
        'OBJ_ODS02',
        'OBJ_ODS03',
        'OBJ_ODS04',
        'OBJ_ODS05',
        'OBJ_ODS06',
        'OBJ_ODS07',
        'OBJ_ODS08',
        'OBJ_ODS09',
        'OBJ_ODS10',
        'OBJ_ODS11',
        'OBJ_ODS12',
        'OBJ_ODS13',
        'OBJ_ODS14',
        'OBJ_ODS15',
        'OBJ_ODS16',
        'OBJ_ODS17',
        'OBJ_PDEM01',
        'OBJ_PDEM02',
        'OBJ_PDEM03',
        'OBJ_PDEM04',
        'OBJ_PDEM05',
        'OBJ_PDEM06',
        'OBJ_PDEM07', 
        'OBJ_PDEM08',
        'PERIODO_ID1',        
        'MES_ID1',
        'DIA_ID1',
        'OBJ_OBS1',
        'OBJ_OBS2',
        'OBJ_ARC1',
        'OBJ_ARC2',
        'OBJ_STATUS1',
        'OBJ_STATUS2',
        'FEC_REG',
        'FEC_REG2',
        'IP',
        'LOGIN',
        'FECHA_M',
        'FECHA_M2',
        'IP_M',
        'LOGIN_M'
    ];

    //***************************************//
    // *** Como se usa el query scope  ******//
    //***************************************//
    public function scopeName($query, $name)
    {
        if($name) 
            return $query->where('OSC_DESC', 'LIKE', "%$name%");
    }
    public function scopeIdd($query, $idd)
    {
        if($idd)
            return $query->where('PROG_ID', '=', "$idd");
    }    

    public function scopeEmail($query, $email)
    {
        if($email)
            return $query->where('OSC_EMAIL', 'LIKE', "%$email%");
    }

    public function scopeBio($query, $bio)
    {
        if($bio)
            return $query->where('OSC_OBJSOC', 'LIKE', "%$bio%");
    } 

}