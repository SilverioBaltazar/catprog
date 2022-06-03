<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\regFuncionModel;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExcelExportCatFunciones implements FromCollection, /*FromQuery,*/ WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'ID_PROCESO',
            'PROCESO',            
            'ID_FUNCION',
            'FUNCION',
            'ESTADO',
            'FECHA_REG'
        ];
    }

    public function collection()
    {
         return regfuncionModel::join('CP_CAT_PROCESOS','CP_CAT_PROCESOS.PROCESO_ID','=','CP_CAT_FUNCIONES.PROCESO_ID')
                             ->select('CP_CAT_FUNCIONES.PROCESO_ID',
                                      'CP_CAT_PROCESOS.PROCESO_DESC',
                                      'CP_CAT_FUNCIONES.FUNCION_ID',
                                      'CP_CAT_FUNCIONES.FUNCION_DESC',
                                      'CP_CAT_FUNCIONES.FUNCION_STATUS',
                                      'CP_CAT_FUNCIONES.FUNCION_FECREG')
                            ->orderBy('CP_CAT_FUNCIONES.PROCESO_ID','ASC')
                            ->orderBy('CP_CAT_FUNCIONES.FUNCION_ID','ASC')
                            ->get();                               
    }
}
