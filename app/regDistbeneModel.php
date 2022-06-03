<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regDistbeneModel extends Model
{
    protected $table      = "CP_DISTRIB_BENEFICIOS";
    protected $primaryKey = ['PERIODO_ID','PROG_ID']; 
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'PERIODO_ID',
        'PROG_ID',
        'BENE_META',
        'BENE_AVANCE',
        'BENE_M01',
        'BENE_A01',
        'BENE_M02',
        'BENE_A02',
        'BENE_M03',
        'BENE_A03',
        'BENE_M04',
        'BENE_A04',
        'BENE_M05',
        'BENE_A05',
        'BENE_M06',
        'BENE_A06',
        'BENE_M07',
        'BENE_A07',
        'BENE_M08',
        'BENE_A08',
        'BENE_M09',
        'BENE_A09',
        'BENE_M10',
        'BENE_A10',
        'BENE_M11',
        'BENE_A11',
        'BENE_M12',
        'BENE_A12',
        'BENE_MT01',
        'BENE_AT01',
        'BENE_MT02',
        'BENE_AT02',
        'BENE_MT03',
        'BENE_AT03',
        'BENE_MT04',
        'BENE_AT04',
        'BENE_MS01',
        'BENE_AS01',
        'BENE_MS02',
        'BENE_AS02',
        'BENE_MA01',
        'BENE_AA01',
        'BENE_P01',
        'BENE_P02',
        'BENE_P03',
        'BENE_P04',
        'BENE_P05',
        'BENE_P06',
        'BENE_P07',
        'BENE_P08',
        'BENE_P09',
        'BENE_P10',
        'BENE_P11',
        'BENE_P12',
        'BENE_PT01',
        'BENE_PT02',
        'BENE_PT03',
        'BENE_PT04',
        'BENE_PS01',
        'BENE_PS02',
        'BENE_PA01',
        'BENE_S01',
        'BENE_S02',
        'BENE_S03',
        'BENE_S04',
        'BENE_S05',
        'BENE_S06',
        'BENE_S07',
        'BENE_S08',
        'BENE_S09',
        'BENE_S10',
        'BENE_S11',
        'BENE_S12',
        'BENE_ST01',
        'BENE_ST02',
        'BENE_ST03',
        'BENE_ST04',
        'BENE_SS01',
        'BENE_SS02',
        'BENE_SA01',
        'BENE_SC01',
        'BENE_SC02',
        'BENE_SC03',
        'BENE_SC04',
        'BENE_SC05',
        'BENE_SC06',
        'BENE_SC07',
        'BENE_SC08',
        'BENE_SC09',
        'BENE_SC10',
        'BENE_SC11',
        'BENE_SC12',
        'BENE_SCT01',
        'BENE_SCT02',
        'BENE_SCT03',
        'BENE_SCT04',
        'BENE_SCS01',
        'BENE_SCS02',
        'BENE_SCA01',
        'BENE_OBS1',
        'BENE_OBS2',
        'BENE_STATUS1',
        'BENE_STATUS2',
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
    public function scopefPer($query, $fper)
    {
        if($fper)
            return $query->orwhere('PERIODO_ID', '=', "$fper");
    }

    public function scopeIdd($query, $idd)
    {
        if($idd)
            return $query->orwhere('IAP_ID', '=', "$idd");
    }    
    public function scopeNameiap($query, $nameiap)
    {
        if($nameiap) 
            return $query->orwhere('IAP_DESC', 'LIKE', "%$nameiap%");
    } 

    //********* Obtiene valores de meses programados **********************//
    public static function ObtmesesprogBene($id, $id2){
        return regFinanModel::select('BENE_META','BENE_M01','BENE_M02','BENE_M03','BENE_M04','BENE_M05','BENE_M06',
                                     'BENE_M07','BENE_M08','BENE_M09','BENE_M10','BENE_M11','BENE_M12',
                                     'BENE_MT01','BENE_MT02','BENE_MT03','BENE_MT04',
                                     'BENE_MS01','BENE_MS02','BENE_MA01'
                                    )
                            ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2])
                            ->get();
    }    
 
}
