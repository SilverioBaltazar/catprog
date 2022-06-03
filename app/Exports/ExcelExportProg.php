<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\regProgramasModel;

use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExcelExportProg implements FromCollection, /*FromQuery,*/ WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings(): array
    {
        return [
            'ID',
            'PROGRAMA',
            'SIGLAS',
            'TIPO',
            'FEC_REG',
            'STATUS'            
        ];
    }

    public function collection()
    {
       // return regOscModel::join('PE_CAT_MUNICIPIOS_SEDESEM',[['PE_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','=',15],
       //                                                    ['PE_CAT_MUNICIPIOS_SEDESEM.MUNICIPIOID','=','PE_OSC.MUNICIPIO_ID']])
       //                    ->wherein('PE_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID',[9,15,22])
        return regProgramasModel::select('PROG_ID',
                                         'PROG_DESC', 
                                         'PROG_SIGLAS',
                                         'PROG_TIPO',
                                         'PROG_FECREG',
                                         'PROG_STATUS1')
                                  ->orderBy('PROG_ID','ASC')
                                  ->get();    
    //dd($regOscModel);                           
    }
}
