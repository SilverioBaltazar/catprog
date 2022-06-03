<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regDistbenefModel extends Model
{
    protected $table      = "CP_DISTRIB_BENEFICIARIOS";
    protected $primaryKey = ['PERIODO_ID','PROG_ID']; 
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'PERIODO_ID',
        'PROG_ID',
        'BENEF_META',
        'BENEF_AVANCE',
        'BENEF_M01',
        'BENEF_A01',
        'BENEF_M02',
        'BENEF_A02',
        'BENEF_M03',
        'BENEF_A03',
        'BENEF_M04',
        'BENEF_A04',
        'BENEF_M05',
        'BENEF_A05',
        'BENEF_M06',
        'BENEF_A06',
        'BENEF_M07',
        'BENEF_A07',
        'BENEF_M08',
        'BENEF_A08',
        'BENEF_M09',
        'BENEF_A09',
        'BENEF_M10',
        'BENEF_A10',
        'BENEF_M11',
        'BENEF_A11',
        'BENEF_M12',
        'BENEF_A12',
        'BENEF_MT01',
        'BENEF_AT01',
        'BENEF_MT02',
        'BENEF_AT02',
        'BENEF_MT03',
        'BENEF_AT03',
        'BENEF_MT04',
        'BENEF_AT04',
        'BENEF_MS01',
        'BENEF_AS01',
        'BENEF_MS02',
        'BENEF_AS02',
        'BENEF_MA01',
        'BENEF_AA01',
        'BENEF_P01',
        'BENEF_P02',
        'BENEF_P03',
        'BENEF_P04',
        'BENEF_P05',
        'BENEF_P06',
        'BENEF_P07',
        'BENEF_P08',
        'BENEF_P09',
        'BENEF_P10',
        'BENEF_P11',
        'BENEF_P12',
        'BENEF_PT01',
        'BENEF_PT02',
        'BENEF_PT03',
        'BENEF_PT04',
        'BENEF_PS01',
        'BENEF_PS02',
        'BENEF_PA01',
        'BENEF_S01',
        'BENEF_S02',
        'BENEF_S03',
        'BENEF_S04',
        'BENEF_S05',
        'BENEF_S06',
        'BENEF_S07',
        'BENEF_S08',
        'BENEF_S09',
        'BENEF_S10',
        'BENEF_S11',
        'BENEF_S12',
        'BENEF_ST01',
        'BENEF_ST02',
        'BENEF_ST03',
        'BENEF_ST04',
        'BENEF_SS01',
        'BENEF_SS02',
        'BENEF_SA01',
        'BENEF_SC01',
        'BENEF_SC02',
        'BENEF_SC03',
        'BENEF_SC04',
        'BENEF_SC05',
        'BENEF_SC06',
        'BENEF_SC07',
        'BENEF_SC08',
        'BENEF_SC09',
        'BENEF_SC10',
        'BENEF_SC11',
        'BENEF_SC12',
        'BENEF_SCT01',
        'BENEF_SCT02',
        'BENEF_SCT03',
        'BENEF_SCT04',
        'BENEF_SCS01',
        'BENEF_SCS02',
        'BENEF_SCA01',
        'BENEF_STATUS1',
        'BENEF_STATUS2',
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
    public static function ObtmesesprogBenef($id, $id2){
        return regFinanModel::select('BENEF_META','BENEF_M01','BENEF_M02','BENEF_M03','BENEF_M04','BENEF_M05','BENEF_M06',
                                     'BENEF_M07','BENEF_M08','BENEF_M09','BENEF_M10','BENEF_M11','BENEF_M12',
                                     'BENEF_MT01','BENEF_MT02','BENEF_MT03','BENEF_MT04',
                                     'BENEF_MS01','BENEF_MS02','BENEF_MA01'
                                    )
                            ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2])
                            ->get();
    }    
 
}
