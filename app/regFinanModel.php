<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regFinanModel extends Model
{
    protected $table      = "CP_FINANCIAMIENTO";
    protected $primaryKey = ['PERIODO_ID','PROG_ID','FTEFINAN_ID']; 
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'PERIODO_ID',
        'PROG_ID',
        'FTEFINAN_ID',
        'FINAN_META',
        'FINAN_AVANCE',
        'FINAN_M01',
        'FINAN_A01',
        'FINAN_M02',
        'FINAN_A02',
        'FINAN_M03',
        'FINAN_A03',
        'FINAN_M04',
        'FINAN_A04',
        'FINAN_M05',
        'FINAN_A05',
        'FINAN_M06',
        'FINAN_A06',
        'FINAN_M07',
        'FINAN_A07',
        'FINAN_M08',
        'FINAN_A08',
        'FINAN_M09',
        'FINAN_A09',
        'FINAN_M10',
        'FINAN_A10',
        'FINAN_M11',
        'FINAN_A11',
        'FINAN_M12',
        'FINAN_A12',
        'FINAN_MT01',
        'FINAN_AT01',
        'FINAN_MT02',
        'FINAN_AT02',
        'FINAN_MT03',
        'FINAN_AT03',
        'FINAN_MT04',
        'FINAN_AT04',
        'FINAN_MS01',
        'FINAN_AS01',
        'FINAN_MS02',
        'FINAN_AS02',
        'FINAN_MA01',
        'FINAN_AA01',
        'FINAN_P01',
        'FINAN_P02',
        'FINAN_P03',
        'FINAN_P04',
        'FINAN_P05',
        'FINAN_P06',
        'FINAN_P07',
        'FINAN_P08',
        'FINAN_P09',
        'FINAN_P10',
        'FINAN_P11',
        'FINAN_P12',
        'FINAN_PT01',
        'FINAN_PT02',
        'FINAN_PT03',
        'FINAN_PT04',
        'FINAN_PS01',
        'FINAN_PS02',
        'FINAN_PA01',
        'FINAN_S01',
        'FINAN_S02',
        'FINAN_S03',
        'FINAN_S04',
        'FINAN_S05',
        'FINAN_S06',
        'FINAN_S07',
        'FINAN_S08',
        'FINAN_S09',
        'FINAN_S10',
        'FINAN_S11',
        'FINAN_S12',
        'FINAN_ST01',
        'FINAN_ST02',
        'FINAN_ST03',
        'FINAN_ST04',
        'FINAN_SS01',
        'FINAN_SS02',
        'FINAN_SA01',
        'FINAN_SC01',
        'FINAN_SC02',
        'FINAN_SC03',
        'FINAN_SC04',
        'FINAN_SC05',
        'FINAN_SC06',
        'FINAN_SC07',
        'FINAN_SC08',
        'FINAN_SC09',
        'FINAN_SC10',
        'FINAN_SC11',
        'FINAN_SC12',
        'FINAN_SCT01',
        'FINAN_SCT02',
        'FINAN_SCT03',
        'FINAN_SCT04',
        'FINAN_SCS01',
        'FINAN_SCS02',
        'FINAN_SCA01',
        'FINAN_STATUS1',
        'FINAN_STATUS2',
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
    public static function Obtmesesprog($id, $id2, $id3){
        return regFinanModel::select('FINAN_META','FINAN_M01','FINAN_M02','FINAN_M03','FINAN_M04','FINAN_M05','FINAN_M06',
                                     'FINAN_M07','FINAN_M08','FINAN_M09','FINAN_M10','FINAN_M11','FINAN_M12',
                                     'FINAN_MT01','FINAN_MT02','FINAN_MT03','FINAN_MT04',
                                     'FINAN_MS01','FINAN_MS02','FINAN_MA01'
                                    )
                            ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2, 'FTEFINAN_ID' => $id3])
                            ->get();
    }    
 
}
