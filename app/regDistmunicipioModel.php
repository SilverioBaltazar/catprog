<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regDistmunicipioModel extends Model
{
    protected $table      = "CP_DISTRIB_MUNICIPIOS";
    protected $primaryKey = ['PERIODO_ID','PROG_ID','MUNICIPIO_ID']; 
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'PERIODO_ID',
        'PROG_ID',
        'MUNICIPIO_ID',
        'MES_ID',
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
        'BENE_META', 
        'BENE_AVANCE',        
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
        'FIANAN_META', 
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
      'MUN_OBS1',
      'MUN_OBS2',
      'MUN_STATUS1',
      'MUN_STATUS2',
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
    public static function Obtmesesprogmuni($id, $id2, $id3){
        return regDistmunicipioModel::select('FINAN_META','FINAN_M01','FINAN_M02','FINAN_M03','FINAN_M04','FINAN_M05','FINAN_M06',
                                     'FINAN_M07','FINAN_M08','FINAN_M09','FINAN_M10','FINAN_M11','FINAN_M12',
                                     'FINAN_MT01','FINAN_MT02','FINAN_MT03','FINAN_MT04',
                                     'FINAN_MS01','FINAN_MS02','FINAN_MA01',
                                     'BENEF_META','BENEF_M01','BENEF_M02','BENEF_M03','BENEF_M04','BENEF_M05','BENEF_M06',
                                     'BENEF_M07','BENEF_M08','BENEF_M09','BENEF_M10','BENEF_M11','BENEF_M12',
                                     'BENEF_MT01','BENEF_MT02','BENEF_MT03','BENEF_MT04',
                                     'BENEF_MS01','BENEF_MS02','BENEF_MA01',
                                     'BENE_META','BENE_M01','BENE_M02','BENE_M03','BENE_M04','BENE_M05','BENE_M06',
                                     'BENE_M07','BENE_M08','BENE_M09','BENE_M10','BENE_M11','BENE_M12',
                                     'BENE_MT01','BENE_MT02','BENE_MT03','BENE_MT04',
                                     'BENE_MS01','BENE_MS02','BENE_MA01'
                                    )
                            ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2, 'MUNICIPIO_ID' => $id3])
                            ->get();
    }    
 
}
