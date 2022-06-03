<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\depenprogsRequest;
use App\regProgramasModel;
use App\regDepenModel;
use App\regDepprogsModel;
use App\regBitacoraModel;
use App\regMesesModel;
use App\regDiasModel;
// Exportar a excel 
//use App\Exports\ExcelExportCatFunciones;
use Maatwebsite\Excel\Facades\Excel;
// Exportar a pdf
use PDF;

class depenProgsController extends Controller
{
 
    public function actionVerDepprog(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $codigo       = session()->get('codigo');   
 
        $regdepen   = regDepenModel::select( 'DEPEN_ID','DEPEN_DESC')
                                   ->orderBy('DEPEN_ID','ASC')
                                   ->get();                                              
        if(session()->get('rango') !== '0'){                                        
            $regprograma=regProgramasModel::select( 'PROG_ID','PROG_DESC')
                                          ->orderBy('PROG_ID','ASC')
                                          ->get();                               
            $regdepprogs=regDepprogsModel::select('PROG_ID','DEPEN_ID1','DEPEN_ID2','DEPEN_ID3',
                                                  'ESTRUCGOB_ID','CLASIFICGOB_ID','FECHA_REG')
                                        ->orderBy('PROG_ID'  ,'ASC')
                                        ->orderBy('DEPEN_ID1','ASC')
                                        ->paginate(50);
        }else{           
            $regprograma=regProgramasModel::select( 'PROG_ID','PROG_DESC')
                                          ->where(  'PROG_ID',$codigo)                       
                                          //->orderBy('PROG_ID','ASC')
                                          ->get();                                           
            $regdepprogs=regDepprogsModel::select('PROG_ID','DEPEN_ID1','DEPEN_ID2','DEPEN_ID3',
                                                  'ESTRUCGOB_ID','CLASIFICGOB_ID','FECHA_REG')
                                        ->where(  'PROG_ID'  ,$codigo)            
                                        ->orderBy('PROG_ID'  ,'ASC')
                                        ->orderBy('DEPEN_ID1','ASC')
                                        ->paginate(50);          
        }                                 
        if($regdepprogs->count() <= 0){
            toastr()->error('No existen registros.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.programa.verDepprog',compact('nombre','usuario','codigo','regprograma','regdepen','regdepprogs'));
    }

    public function actionNuevaDepprog(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        
        $regprograma= regProgramasModel::select('PROG_ID','PROG_DESC')
                      ->orderBy('PROG_ID','asc')
                      ->get();
        $regdepen   = regDepenModel::select('DEPEN_ID','DEPEN_DESC','ESTRUCGOB_ID','CLASIFICGOB_ID')
                      ->orderBy('DEPEN_ID','asc')
                      ->get();
        if(session()->get('rango') !== '0'){                                                              
            $regprograma=regProgramasModel::select( 'PROG_ID','PROG_DESC')
                                          ->orderBy('PROG_ID','ASC')
                                          ->get();                                           
            $regdepprogs =regDepprogsModel::select('DEPEN_ID1','DEPEN_ID2','DEPEN_ID3','PROG_ID','ESTRUCGOB_ID',
                                               'CLASIFICGOB_ID','FECHA_REG','FECHA_REG2','IP','LOGIN',
                                               'FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                          ->orderBy('PROG_ID'   ,'asc')
                          ->orderBy('CVE_DEPEN1','asc')
                          ->get();     
        }else{
            $regprograma=regProgramasModel::select( 'PROG_ID','PROG_DESC')
                                          ->where(  'PROG_ID',$codigo)      
                                          ->get();                                           
            $regdepprogs =regDepprogsModel::select('DEPEN_ID1','DEPEN_ID2','DEPEN_ID3','PROG_ID','ESTRUCGOB_ID',
                                               'CLASIFICGOB_ID','FECHA_REG','FECHA_REG2','IP','LOGIN',
                                               'FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                          ->where(  'PROG_ID',$codigo)                       
                          ->orderBy('PROG_ID'   ,'asc')
                          ->orderBy('CVE_DEPEN1','asc')
                          ->get();                         
        }
        if($regdepprogs->count() <= 0){
            toastr()->error('No existen registros.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }        
        //dd($unidades);
        return view('sicinar.catalogos.nuevaFuncion',compact('regdepprogs','regproceso','nombre','usuario'));
    }

    public function actionAltaNuevaDepprog(Request $request){
        //dd($request->all());
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');

        //$ip           = session()->get('ip');
        if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $ip = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ip = getenv('HTTP_FORWARDED_FOR');
            } elseif (getenv('HTTP_FORWARDED')) {
            $ip = getenv('HTTP_FORWARDED');
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        //$plan = progtrabModel::select('STATUS_1')
        //    ->where('N_PERIODO',date('Y'))
        //    ->where('ESTRUCGOB_ID','like',$request->estructura.'%')
        //    ->where('CVE_DEPENDENCIA','like',$request->unidad.'%')
        //    ->get();
        //if($plan->count() > 0){
        //    toastr()->error('El Plan de Trabajo para esta Unidad Administrativa ya ha sido creado.','Plan de Trabajo Duplicado!',['positionClass' => 'toast-bottom-right']);
        //    return back();
        //}
        //$proceso_id = regProgramasModel::max('PROCESO_ID');
        //$proceso_id = $proceso_id+1;
        /* ALTA DEl proceso ****************************/
        $nuevaFuncion = new regDepprogsModel();
        $nuevaFuncion->PROCESO_ID    = $request->proceso_id;
        $nuevaFuncion->FUNCION_ID    = $request->funcion_id;
        $nuevaFuncion->FUNCION_DESC  = strtoupper($request->funcion_desc);
        //$nuevaFuncion->FUNCION_STATUS= $request->funcion_status;        
        $nuevaFuncion->save();

        if($nuevaFuncion->save() == true){
            toastr()->success('La función del Proceso dada de alta.','ok!',['positionClass' => 'toast-bottom-right']);

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =       150;    //Alta 

            $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
                          'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $request->funcion_id])
                           ->get();
            if($regbitacora->count() <= 0){              // Alta
                $nuevoregBitacora = new regBitacoraModel();              
                $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                $nuevoregBitacora->PROGRAMA_ID= $xprograma_id;   // Proyecto JAPEM 
                $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                $nuevoregBitacora->FOLIO      = $request->funcion_id;     // Folio    
                $nuevoregBitacora->NO_VECES   = 1;               // Numero de veces            
                $nuevoregBitacora->IP         = $ip;             // IP
                $nuevoregBitacora->LOGIN      = $nombre;         // Usuario 

                $nuevoregBitacora->save();
                if($nuevoregBitacora->save() == true)
                    toastr()->success('Bitacora dada de alta correctamente.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error inesperado al dar de alta la bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                                                      'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 
                                                      'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                                      'FOLIO' => $request->funcion_id])
                             ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id,
                                        'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,
                                        'FOLIO' => $request->funcion_id])
                               ->update([
                                         'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'     => $regbitacora->IP       = $ip,
                                         'LOGIN_M'  => $regbitacora->LOGIN_M  = $nombre,
                                         'FECHA_M'  => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/ 
        }else{
            toastr()->error('Error inesperado al dar de alta la función del Proceso. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
        }
        return redirect()->route('verFuncion');
    }

    
    public function actionEditarDepprog($id){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');
        $ip            = session()->get('ip');        
        $codigo        = session()->get('codigo');           

        $regmes     = regMesesModel::select('MES_ID','MES_DESC')
                      ->orderBy('MES_ID','asc')
                      ->get();   
        $regdia     = regDiasModel::select('DIA_ID','DIA_DESC')
                      ->orderBy('DIA_ID','asc')
                      ->get();   
        $regdepen   = regDepenModel::select( 'DEPEN_ID','DEPEN_DESC')
                                   ->orderBy('DEPEN_ID'  ,'ASC')
                                   ->orderBy('DEPEN_DESC','ASC')
                                   ->get();                                              
        $regprograma=regProgramasModel::select( 'PROG_ID','PROG_DESC')
                                      ->where(  'PROG_ID',$id)                       
                                      ->get();                                           
        $regdepprogs=regDepprogsModel::select('PROG_ID','DEPEN_ID1','DEPEN_ID2','DEPEN_ID3','CLASIFICGOB_ID','ESTRUCGOB_ID',
                                              'FECHA_REG','FECHA_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                                    ->where(  'PROG_ID',$id)                       
                                    ->first();
        if($regdepprogs->count() <= 0){
            toastr()->error('No existe programa - dependencia.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.programa.editarDepprog',compact('nombre','usuario','codigo','regdepen','regprograma','regdepprogs','regmes','regdia'));
    }

    public function actionActualizarDepprog(depenprogsRequest $request, $id){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');
        $codigo        = session()->get('codigo');           

        if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('HTTP_X_FORWARDED')) {
            $ip = getenv('HTTP_X_FORWARDED');
        } elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ip = getenv('HTTP_FORWARDED_FOR');
            } elseif (getenv('HTTP_FORWARDED')) {
            $ip = getenv('HTTP_FORWARDED');
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }        

        $yperiodo_id  = (int)date('Y');
        $ymes_id      = (int)date('m');
        $ydia_id      = (int)date('d');
        $mes = regMesesModel::ObtMes($ymes_id);
        $dia = regDiasModel::ObtDia($ydia_id);

        $regdepprogs = regDepprogsModel::where('PROG_ID',$id);
        if($regdepprogs->count() <= 0)
            toastr()->error('No existe programa- dependencia.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            $regdepprogs = regDepprogsModel::where('PROG_ID',$id)        
                           ->update([
                                     'DEPEN_ID1' => strtoupper($request->depen_id1),
                                     'DEPEN_ID2' => strtoupper($request->depen_id2),
                                     
                                     'IP_M'      => $ip,
                                     'LOGIN_M'   => $nombre,
                                     'FECHA_M2'  => trim($dia[0]->dia_desc.'/'.$mes[0]->mes_mes.'/'.$yperiodo_id), 
                                     'FECHA_M'   => date('Y/m/d')    //date('d/m/Y')      
                                    ]);
            toastr()->success('Programa - depen. actualizado.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            
            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =       151;    //Actualizar        

            $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                           ->get();
            if($regbitacora->count() <= 0){              // Alta
                $nuevoregBitacora = new regBitacoraModel();              
                $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                $nuevoregBitacora->PROGRAMA_ID= $xprograma_id;   // Proyecto JAPEM 
                $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                $nuevoregBitacora->FOLIO      = $id;             // Folio    
                $nuevoregBitacora->NO_VECES   = 1;               // Numero de veces            
                $nuevoregBitacora->IP         = $ip;             // IP
                $nuevoregBitacora->LOGIN      = $nombre;         // Usuario 

                $nuevoregBitacora->save();
                if($nuevoregBitacora->save() == true)
                    toastr()->success('programa - dep. registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error en programa - dep.. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                                                      'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 
                                                      'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                             ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id,
                                        'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                        'FOLIO' => $id])
                               ->update([
                                         'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M' => $regbitacora->IP           = $ip,
                                         'LOGIN_M' => $regbitacora->LOGIN_M   = $nombre,
                                         'FECHA_M' => $regbitacora->FECHA_M   = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('programa - dependencia actualizado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                     
        }       /************ Termina de actualizar ********************************/
        return redirect()->route('verdepprog');
    }

public function actionBorrarDepprog($id){
        //dd($request->all());
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        //echo 'Ya entre aboorar registro..........';

        $regdepprogs=regDepprogsModel::select('PROG_ID','DEPEN_ID1','DEPEN_ID2','DEPEN_ID3','CLASIFICGOB_ID','ESTRUCGOB_ID',
                                              'FECHA_REG','FECHA_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                                     ->where('PROG_ID',$id);
        if($regdepprogs->count() <= 0)
            toastr()->error('No existe programa - dep.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            $regdepprogs->delete();
            toastr()->success('programa - dep. eliminado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =       152;     // Baja 

            $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                           ->get();
            if($regbitacora->count() <= 0){              // Alta
                $nuevoregBitacora = new regBitacoraModel();              
                $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                $nuevoregBitacora->PROGRAMA_ID= $xprograma_id;   // Proyecto JAPEM 
                $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                $nuevoregBitacora->FOLIO      = $id;             // Folio    
                $nuevoregBitacora->NO_VECES   = 1;               // Numero de veces            
                $nuevoregBitacora->IP         = $ip;             // IP
                $nuevoregBitacora->LOGIN      = $nombre;         // Usuario 

                $nuevoregBitacora->save();
                if($nuevoregBitacora->save() == true)
                    toastr()->success('trx de eliminar programa - dep. registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error de trx de eliminar programa - dep. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                                                      'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 
                                                      'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                             ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id,
                                        'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                        'FOLIO' => $id])
                               ->update([
                                         'NO_VECES'=> $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'    => $regbitacora->IP           = $ip,
                                         'LOGIN_M' => $regbitacora->LOGIN_M   = $nombre,
                                         'FECHA_M' => $regbitacora->FECHA_M   = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('trx de eliminar programa - dep. registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                            
        }       /************ Termina la baja **************************************/

        return redirect()->route('verdepprog');
    }    

    // exportar a formato catalogo de funciones de procesos a formato excel
    public function exportCatFuncionesExcel(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =       153;     // excel
            $id           =         0;

            $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                           ->get();
            if($regbitacora->count() <= 0){              // Alta
                $nuevoregBitacora = new regBitacoraModel();              
                $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                $nuevoregBitacora->PROGRAMA_ID= $xprograma_id;   // Proyecto JAPEM 
                $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                $nuevoregBitacora->FOLIO      = $id;             // Folio    
                $nuevoregBitacora->NO_VECES   = 1;               // Numero de veces            
                $nuevoregBitacora->IP         = $ip;             // IP
                $nuevoregBitacora->LOGIN      = $nombre;         // Usuario 

                $nuevoregBitacora->save();
                if($nuevoregBitacora->save() == true)
                    toastr()->success('Bitacora dada de alta correctamente.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error inesperado al dar de alta la bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                                                      'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 
                                                      'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                             ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id,
                                        'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                        'FOLIO' => $id])
                               ->update([
                                         'NO_VECES'=> $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'    => $regbitacora->IP           = $ip,
                                         'LOGIN_M' => $regbitacora->LOGIN_M   = $nombre,
                                         'FECHA_M' => $regbitacora->FECHA_M   = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                            

        return Excel::download(new ExcelExportCatFunciones, 'Cat_Funciones_'.date('d-m-Y').'.xlsx');
    }

    // exportar a formato catalogo de funciones de procesos a formato PDF
    public function exportCatFuncionesPdf(){
        set_time_limit(0);
        ini_set("memory_limit",-1);
        ini_set('max_execution_time', 0);

        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');

        $regproceso = regProgramasModel::select('PROCESO_ID','PROCESO_DESC','PROCESO_STATUS','PROCESO_FECREG')
                      ->orderBy('PROCESO_ID','DESC')->get();
        if($regproceso->count() <= 0){
            toastr()->error('No existen registros en el catalogo de procesos.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('verProceso');
        }

        $regdepprogs = regDepprogsModel::join('CP_CAT_PROGRAMAS','CP_CAT_PROGRAMAS.PROCESO_ID','=','CP_DEPEN_PROGRAMAS.PROCESO_ID')
                                   ->select('CP_DEPEN_PROGRAMAS.PROCESO_ID','CP_CAT_PROGRAMAS.PROCESO_DESC','CP_DEPEN_PROGRAMAS.FUNCION_ID','CP_DEPEN_PROGRAMAS.FUNCION_DESC','CP_DEPEN_PROGRAMAS.FUNCION_STATUS','CP_DEPEN_PROGRAMAS.FUNCION_FECREG')
                                   ->orderBy('CP_DEPEN_PROGRAMAS.PROCESO_ID','ASC')
                                   ->orderBy('CP_DEPEN_PROGRAMAS.FUNCION_ID','ASC')
                                   ->get();
        if($regdepprogs->count() <= 0){
            toastr()->error('No existen registros en catalogo de funciones de procesos.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            return redirect()->route('verFuncion');
        }else{

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =       154;     // pdf 
            $id           =         0;

            $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                           ->get();
            if($regbitacora->count() <= 0){              // Alta
                $nuevoregBitacora = new regBitacoraModel();              
                $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                $nuevoregBitacora->PROGRAMA_ID= $xprograma_id;   // Proyecto JAPEM 
                $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                $nuevoregBitacora->FOLIO      = $id;             // Folio    
                $nuevoregBitacora->NO_VECES   = 1;               // Numero de veces            
                $nuevoregBitacora->IP         = $ip;             // IP
                $nuevoregBitacora->LOGIN      = $nombre;         // Usuario 

                $nuevoregBitacora->save();
                if($nuevoregBitacora->save() == true)
                    toastr()->success('Bitacora dada de alta correctamente.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error inesperado al dar de alta la bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                                                      'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 
                                                      'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                             ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id,
                                        'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                        'FOLIO' => $id])
                               ->update([
                                         'NO_VECES'=> $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'    => $regbitacora->IP           = $ip,
                                         'LOGIN_M' => $regbitacora->LOGIN_M   = $nombre,
                                         'FECHA_M' => $regbitacora->FECHA_M   = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                                       

            $pdf = PDF::loadView('sicinar.pdf.catfuncionesPDF', compact('nombre','usuario','regdepprogs','regproceso'));
            //******** Horizontal ***************
            //$pdf->setPaper('A4', 'landscape');      
            //******** vertical *************** 
            //El tamaño de hoja se especifica en page_size puede ser letter, legal, A4, etc.         
            $pdf->setPaper('letter','portrait');   
            return $pdf->stream('CatalogoDeFuncionesDeProcesos');

        }       /********** Termina de exportar ************************************/ 

    }

}
