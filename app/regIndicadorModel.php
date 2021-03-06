<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class regIndicadorModel extends Model
{
    protected $table      = "CP_INDICADOR";
    protected $primaryKey = ['PERIODO_ID','PROG_ID','INDI_ID'];
    public $timestamps    = false;
    public $incrementing  = false;
    protected $fillable   = [
        'PERIODO_ID',
        'PROG_ID',
        'INDI_ID',
        'ITIPO_ID',
        'ICLASE_ID',
        'IDIMENSION_ID',
        'INDI_DESC',
        'INDI_FORMULA',
        'INDI_META',
        'INDI_AVANCE',
        'INDI_M01',
        'INDI_A01',
        'INDI_M02',
        'INDI_A02',
        'INDI_M03',
        'INDI_A03',
        'INDI_M04',
        'INDI_A04',
        'INDI_M05',
        'INDI_A05',
        'INDI_M06',
        'INDI_A06',
        'INDI_M07',
        'INDI_A07',
        'INDI_M08',
        'INDI_A08',
        'INDI_M09',
        'INDI_A09',
        'INDI_M10',
        'INDI_A10',
        'INDI_M11',
        'INDI_A11',
        'INDI_M12',
        'INDI_A12',
        'INDI_MT01',
        'INDI_AT01',
        'INDI_MT02',
        'INDI_AT02',
        'INDI_MT03',
        'INDI_AT03',
        'INDI_MT04',
        'INDI_AT04',
        'INDI_MS01',
        'INDI_AS01',
        'INDI_MS02',
        'INDI_AS02',
        'INDI_MA01',
        'INDI_AA01',
        'INDI_P01',
        'INDI_P02',
        'INDI_P03',
        'INDI_P04',
        'INDI_P05',
        'INDI_P06',
        'INDI_P07',
        'INDI_P08',
        'INDI_P09',
        'INDI_P10',
        'INDI_P11',
        'INDI_P12',
        'INDI_PT01',
        'INDI_PT02',
        'INDI_PT03',
        'INDI_PT04',
        'INDI_PS01',
        'INDI_PS02',
        'INDI_PA01',
        'INDI_S01',
        'INDI_S02',
        'INDI_S03',
        'INDI_S04',
        'INDI_S05',
        'INDI_S06',
        'INDI_S07',
        'INDI_S08',
        'INDI_S09',
        'INDI_S10',
        'INDI_S11',
        'INDI_S12',
        'INDI_ST01',
        'INDI_ST02',
        'INDI_ST03',
        'INDI_ST04',
        'INDI_SS01',
        'INDI_SS02',
        'INDI_SA01',
        'INDI_SC01',
        'INDI_SC02',
        'INDI_SC03',
        'INDI_SC04',
        'INDI_SC05',
        'INDI_SC06',
        'INDI_SC07',
        'INDI_SC08',
        'INDI_SC09',
        'INDI_SC10',
        'INDI_SC11',
        'INDI_SC12',
        'INDI_SCT01',
        'INDI_SCT02',
        'INDI_SCT03',
        'INDI_SCT04',
        'INDI_SCS01',
        'INDI_SCS02',
        'INDI_SCA01',
        'INDI_OBS1',
        'INDI_OBS2',
        'INDI_STATUS1',
        'INDI_STATUS2',
        'FEC_REG',
        'FEC_REG2',
        'IP',
        'LOGIN',
        'FECHA_M',
        'FECHA_M2',
        'IP_M',
        'LOGIN_M'
    ];
}