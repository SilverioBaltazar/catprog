<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\proyectopRequest;

use App\regPeriodosModel;
use App\regFinalidadModel;
use App\regFuncionModel;
use App\regSubfunModel;
use App\regProgramasModel;
use App\regSubprogModel;
use App\regProyectosModel;
use App\regProyectopresModel;
use App\regBitacoraModel;

// Exportar a excel 
//use App\Exports\ExcelExportProg;
use Maatwebsite\Excel\Facades\Excel;
// Exportar a pdf
use PDF;
//use Options;

class proyectopresController extends Controller
{

    public function actionBuscarProyectop(Request $request)
    {
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $codigo       = session()->get('codigo');   

        $regprogramas   = regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->orderBy('PROG_ID','asc')
                          ->get();                                    
        $regproyectos   = regProyectosModel::select('PROY_ID','PROY_DESC')
                          ->orderBy('PROY_ID','asc')
                          ->get();                    
        //**************************************************************//
        // ***** busqueda https://github.com/rimorsoft/Search-simple ***//
        // ***** video https://www.youtube.com/watch?v=bmtD9GUaszw   ***//                            
        //**************************************************************//
        $name  = $request->get('name');    
        //$email = $request->get('email');  
        //$bio   = $request->get('bio');      
        if(session()->get('rango') !== '0'){            
            $regproyectopres = regProyectopresModel::orderBy('PROG_ID', 'ASC')
                       ->name($name)           //Metodos personalizados es equvalente a ->where('IAP_DESC', 'LIKE', "%$name%");
                       //->email($email)         //Metodos personalizados
                       //->bio($bio)             //Metodos personalizados
                       ->paginate(50);
        }else{           
            $regproyectopres = regProyectopresModel::where('PROG_ID',$codigo)
                       ->orderBy('PROG_ID', 'ASC')
                       ->name($name)           //Metodos personalizados es equvalente a ->where('IAP_DESC', 'LIKE', "%$name%");
                       //->email($email)         //Metodos personalizados
                       //->bio($bio)             //Metodos personalizados
                       ->paginate(50);          
        }
        if($regproyectopres->count() <= 0){
            toastr()->error('No existen proyectos presupuestarios','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }            
        return view('sicinar.proyectopresup.verProyectop', compact('nombre','usuario','codigo','regprogramas','regproyectos','regproyectopres'));
    }

    public function actionVerProyectop(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $codigo       = session()->get('codigo');         

        $regproyectos = regProyectosModel::select('PROY_ID','PROY_DESC')
                        ->orderBy('PROY_ID','asc')
                        ->get();          
        if(session()->get('rango') !== '0'){                                                       
            $regprogramas = regProgramasModel::select('PROG_ID','PROG_DESC')
                            ->orderBy('PROG_ID','asc')
                            ->get();                                    
            $regproyectopres=regProyectopresModel::join('CP_CAT_PROYECTOS','CP_CAT_PROYECTOS.PROY_ID', '=', 
                                                                           'CP_PROYECTO_PRESUP.PROY_ID')
                             ->select('CP_PROYECTO_PRESUP.PERIODO_ID',
                                      'CP_PROYECTO_PRESUP.PROG_ID',
                                      'CP_PROYECTO_PRESUP.FIN_ID',
                                      'CP_PROYECTO_PRESUP.FUNCION_ID',
                                      'CP_PROYECTO_PRESUP.SUBFUN_ID',
                                      'CP_PROYECTO_PRESUP.PROGRAM_ID',
                                      'CP_PROYECTO_PRESUP.SUBPROG_ID',
                                      'CP_PROYECTO_PRESUP.PROY_ID',
                                      'CP_CAT_PROYECTOS.PROY_DESC',
                                      'CP_PROYECTO_PRESUP.MONTO_PRESUP',
                                      'CP_PROYECTO_PRESUP.MONTO_AUTORIZADO'
                                      )
                         ->orderBy('CP_PROYECTO_PRESUP.PERIODO_ID','DESC')
                         ->orderBy('CP_PROYECTO_PRESUP.PROG_ID'   ,'DESC')
                         ->paginate(50);
        }else{           
            $regprogramas = regProgramasModel::select('PROG_ID','PROG_DESC')
                            ->where('PROG_ID',$codigo)
                            ->get();                        
            $regproyectopres=regProyectopresModel::join('CP_CAT_PROYECTOS','CP_CAT_PROYECTOS.PROY_ID', '=', 
                                                                           'CP_PROYECTO_PRESUP.PROY_ID')
                             ->select('CP_PROYECTO_PRESUP.PERIODO_ID',
                                      'CP_PROYECTO_PRESUP.PROG_ID',
                                      'CP_PROYECTO_PRESUP.FIN_ID',
                                      'CP_PROYECTO_PRESUP.FUNCION_ID',
                                      'CP_PROYECTO_PRESUP.SUBFUN_ID',
                                      'CP_PROYECTO_PRESUP.PROGRAM_ID',
                                      'CP_PROYECTO_PRESUP.SUBPROG_ID',
                                      'CP_PROYECTO_PRESUP.PROY_ID',
                                      'CP_CAT_PROYECTOS.PROY_DESC',
                                      'CP_PROYECTO_PRESUP.MONTO_PRESUP',
                                      'CP_PROYECTO_PRESUP.MONTO_AUTORIZADO'
                                      )
                       ->orderBy('CP_PROYECTO_PRESUP.PERIODO_ID','DESC')
                       ->where(  'CP_PROYECTO_PRESUP.PROG_ID',$codigo)
                       ->orderBy('CP_PROYECTO_PRESUP.PROG_ID','DESC')
                       ->paginate(50);          
        }                         
        if($regproyectopres->count() <= 0){
            toastr()->error('No existen proyectos presupuestarios','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.proyectopresup.verProyectop',compact('nombre','usuario','codigo','regprogramas','regproyectos','regproyectopres'));
    }

    public function actionNuevoProyectop(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $codigo       = session()->get('codigo');   

        $regperiodos    = regPeriodosModel::select('PERIODO_ID', 'PERIODO_DESC')
                          ->orderBy('PERIODO_ID','asc')
                          ->get();  
        $regproyectos   = regProyectosModel::select('PROY_ID','PROY_DESC')
                          ->orderBy('PROY_DESC','asc')
                          ->get();     
        if(session()->get('rango') !== '0'){                                                       
            $regprogramas = regProgramasModel::select('PROG_ID','PROG_DESC')
                            ->orderBy('PROG_ID','asc')
                            ->get();                                    
            $regproyectopres=regProyectopresModel::select('PERIODO_ID','PROG_ID','FIN_ID','FUNCION_ID','SUBFUN_ID',
                             'PROGRAM_ID','SUBPROG_ID','PROY_ID','MONTO_PRESUP','MONTO_AUTORIZADO',
                             'PROY_ARC1','PROY_ARC2','PROY_ARC3','PROY_OBS1','PROY_OBS2','PROY_STATUS1','PROY_STATUS2',
                             'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                             ->orderBy('PERIODO_ID','asc')
                             ->orderBy('PROG_ID'   ,'asc')
                             ->get();                            
        }else{           
            $regprogramas = regProgramasModel::select('PROG_ID','PROG_DESC')
                            ->where('PROG_ID',$codigo)
                            ->get();                        
            $regproyectopres=regProyectopresModel::select('PERIODO_ID','PROG_ID','FIN_ID','FUNCION_ID','SUBFUN_ID',
                             'PROGRAM_ID','SUBPROG_ID','PROY_ID','MONTO_PRESUP','MONTO_AUTORIZADO',
                             'PROY_ARC1','PROY_ARC2','PROY_ARC3','PROY_OBS1','PROY_OBS2','PROY_STATUS1','PROY_STATUS2',
                             'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                             ->where('PROG_ID',$codigo)
                             ->orderBy('PERIODO_ID','asc')
                             ->orderBy('PROG_ID'   ,'asc')
                             ->get();                            
        }
        return view('sicinar.proyectopresup.nuevoProyectop',compact('nombre','usuario','codigo','regprogramas','regperiodos','regproyectos','regproyectopres'));
    }

    public function actionAltaNuevoProyectop(Request $request){
        //dd($request->all());
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $codigo       = session()->get('codigo');   

        /************ Obtenemos la IP ***************************/                
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

        /********************** Alta  *****************************/ 
        //$prog_id = regProyectopresModel::max('PROG_ID');
        //$prog_id = $prog_id + 1;

        $nuevaiap = new regProyectopresModel();
        $name1 =null;
        //Comprobar  si el campo foto1 tiene un archivo asignado:
        if($request->hasFile('osc_foto1')){
           $name1 = $osc_id.'_'.$request->file('osc_foto1')->getClientOriginalName(); 
           //$file->move(public_path().'/images/', $name1);
           //sube el archivo a la carpeta del servidor public/images/
           $request->file('osc_foto1')->move(public_path().'/images/', $name1);
        }
 
        $nuevaiap->PERIODO_ID      = $request->periodo_id;
        $nuevaiap->PROG_ID         = $request->prog_id;
        $nuevaiap->FIN_ID          = $request->fin_id;
        $nuevaiap->FUNCION_ID      = $request->funcion_id;
        $nuevaiap->SUBFUN_ID       = $request->subfun_id;
        $nuevaiap->PROGRAM_ID      = $request->program_id;
        $nuevaiap->SUBPROG_ID      = $request->subprog_id;
        $nuevaiap->PROY_ID         = $request->proy_id;
        $nuevaiap->MONTO_PRESUP    = $request->monto_presup;        
        $nuevaiap->MONTO_AUTORIZADO= $request->monto_autorizado;        
        
        //$nuevaiap->OSC_FOTO1   = $name1;
        //$nuevaiap->OSC_FOTO2   = $name2;

        $nuevaiap->IP          = $ip;
        $nuevaiap->LOGIN       = $nombre;         // Usuario ;
        //dd($nuevaiap);
        $nuevaiap->save();
        if($nuevaiap->save() == true){
            toastr()->success('Proyecto presupuestal dado de alta.','ok!',['positionClass' => 'toast-bottom-right']);

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =         2;    //Alta

            $regbitacora = regBitacoraModel::select('PERIODO_ID', 'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
                                                    'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 
                                                    'FECHA_M', 'IP_M', 'LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id, 'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id, 
                                    'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                    'FOLIO'      => $request->prog_id])
                           ->get();
            if($regbitacora->count() <= 0){              // Alta
                $nuevoregBitacora = new regBitacoraModel();              
                $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                $nuevoregBitacora->FOLIO      = $request->prog_id;        // Folio    
                $nuevoregBitacora->NO_VECES   = 1;               // Numero de veces            
                $nuevoregBitacora->IP         = $ip;             // IP
                $nuevoregBitacora->LOGIN      = $nombre;         // Usuario 

                $nuevoregBitacora->save();
                if($nuevoregBitacora->save() == true)
                    toastr()->success('Trx de proyecto presupuestal dado de alta en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error de trx de proyecto presupuestal en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id,'MES_ID'     => $xmes_id, 
                                                      'PROCESO_ID' => $xproceso_id,'FUNCION_ID' => $xfuncion_id, 
                                                      'TRX_ID'     => $xtrx_id,    'FOLIO'      => $request->prog_id])
                             ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id,'PROCESO_ID'=> $xproceso_id, 
                                        'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO'     => $request->prog_id])
                               ->update([
                                         'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'     => $regbitacora->IP       = $ip,
                                         'LOGIN_M'  => $regbitacora->LOGIN_M  = $nombre,
                                         'FECHA_M'  => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                       ]);
                toastr()->success('Trx de proyecto presup. actualizado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }
            /************ Bitacora termina *************************************/ 

        }else{
            toastr()->error('Error de trx de proyecto presupuestal. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
        }
        return redirect()->route('verproyectop');
    }

    public function actionEditarProyectop($id, $id2){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        } 
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');
        $codigo        = session()->get('codigo');         

        $regperiodos    = regPeriodosModel::select('PERIODO_ID', 'PERIODO_DESC')
                          ->orderBy('PERIODO_ID','asc')
                          ->get();  
        $regprogramas   = regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->orderBy('PROG_ID','asc')
                          ->get();                                    
        $regproyectos   = regProyectosModel::select('PROY_ID','PROY_DESC')
                          ->orderBy('PROY_DESC','asc')
                          ->get();                         
        $regproyectopres=regProyectopresModel::select('PERIODO_ID','PROG_ID','FIN_ID','FUNCION_ID','SUBFUN_ID',
                         'PROGRAM_ID','SUBPROG_ID','PROY_ID','MONTO_PRESUP','MONTO_AUTORIZADO',
                         'PROY_ARC1','PROY_ARC2','PROY_ARC3','PROY_OBS1','PROY_OBS2','PROY_STATUS1','PROY_STATUS2',
                         'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                         ->where(['PERIODO_ID' => $id, 'PROG_ID' => $id2])
                         ->first();
        //dd($id,'segundo.....'.$id2, $regproyectopres->count() );
        if($regproyectopres->count() <= 0){
            toastr()->error('No existe proyecto presupuestario.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.proyectopresup.editarProyectop',compact('nombre','usuario','codigo','regperiodos','regprogramas','regproyectos','regproyectopres'));
    }

    public function actionActualizarProyectop(proyectopRequest $request, $id, $id2){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');
        $ip            = session()->get('ip');
        $arbol_id      = session()->get('arbol_id');        

        // **************** actualizar ******************************
        $regproyectopres = regProyectopresModel::where(['PERIODO_ID' => $id, 'PROG_ID' => $id2]);
        if($regproyectopres->count() <= 0)
            toastr()->error('No existe proyecto presupuestario.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            //*************** Actualizar ********************************/
            $name1 =null;
            $name2 =null;
            $name3 =null;
            //*********** Actualizarn items **********************
            $regproyectopres = regProyectopresModel::where(['PERIODO_ID' => $id, 'PROG_ID' => $id2])
                               ->update([                
                                         'FIN_ID'          => $request->fin_id,
                                         'FUNCION_ID'      => $request->funcion_id,
                                         'SUBFUN_ID'       => $request->subfun_id,
                                         'PROGRAM_ID'      => $request->program_id,
                                         'SUBPROG_ID'      => $request->subprog_id,
                                         'PROY_ID'         => $request->proy_id,                      
                                         'MONTO_PRESUP'    => $request->monto_presup,
                                         'MONTO_AUTORIZADO'=> $request->monto_autorizado,
                                         'IP_M'            => $ip,
                                         'LOGIN_M'         => $nombre,
                                         'FECHA_M2'  => date('Y/m/d'),   //date('d/m/Y')            
                                         'FECHA_M'         => date('Y/m/d')    //date('d/m/Y')   

                              ]);
            toastr()->success('Proyecto presupuestal actualizado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =         3;    //Actualizar     
            $regbitacora = regBitacoraModel::select('PERIODO_ID','MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
                                                    'TRX_ID',    'FOLIO',  'NO_VECES',   'FECHA_REG', 'IP', 
                                                    'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id,'PROGRAMA_ID' => $xprograma_id,'MES_ID' => $xmes_id, 
                                    'PROCESO_ID' => $xproceso_id,'FUNCION_ID'  => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                    'FOLIO'      => $id])
                           ->get();
            if($regbitacora->count() <= 0){              // Alta
                $nuevoregBitacora = new regBitacoraModel();              
                $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
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
                    toastr()->success('Trx de actualización de proyecto presupuestal registrado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error Trx de proyecto presupuestal  actualizado en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id,'MES_ID'     => $xmes_id, 
                                                      'PROCESO_ID' => $xproceso_id,'FUNCION_ID' => $xfuncion_id, 
                                                      'TRX_ID'     => $xtrx_id,    'FOLIO'      => $id])
                             ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 
                                        'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id, 'FOLIO'      => $id])
                               ->update([
                                         'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'     => $regbitacora->IP       = $ip,
                                         'LOGIN_M'  => $regbitacora->LOGIN_M  = $nombre,
                                         'FECHA_M'  => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('Trx de actualización de proyecto presupuestal registrado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                     
        }       /************ Actualizar *******************************************/
        return redirect()->route('verproyectop');
    }

    public function actionBorrarProyectop($id, $id2){
        //dd($request->all());
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $codigo       = session()->get('codigo');           

        /************ Elimina la OSC **************************************/
        $regproyectopres=regProyectopresModel::select('PERIODO_ID','PROG_ID','FIN_ID','FUNCION_ID','SUBFUN_ID',
                         'PROGRAM_ID','SUBPROG_ID','PROY_ID','MONTO_PRESUP','MONTO_AUTORIZADO',
                         'PROY_ARC1','PROY_ARC2','PROY_ARC3','PROY_OBS1','PROY_OBS2','PROY_STATUS1','PROY_STATUS2',
                         'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                         ->where(['PERIODO_ID' => $id, 'PROG_ID' => $id2]);
        if($regproyectopres->count() <= 0)
            toastr()->error('No existe proyecto presupuestario.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            $regproyectopres->delete();
            toastr()->success('Proyecto presupuestario eliminado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            //echo 'Ya entre a borrar registro..........';
            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =         4;     // Baja 

            $regbitacora = regBitacoraModel::select('PERIODO_ID','MES_ID', 'PROCESO_ID', 'FUNCION_ID', 'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id, 
                                    'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO'      => $id])
                           ->get();
            if($regbitacora->count() <= 0){              // Alta
                $nuevoregBitacora = new regBitacoraModel();              
                $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
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
                    toastr()->success('Trx de baja de proyecto presup. registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error en Trx de baja de proyecto presup. en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id, 
                                                      'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO' => $id])
                        ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 
                                        'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id, 'FOLIO'      => $id])
                               ->update([
                                         'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'     => $regbitacora->IP       = $ip,
                                         'LOGIN_M'  => $regbitacora->LOGIN_M  = $nombre,
                                         'FECHA_M'  => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('Trx de proyecto presupuestal registrado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                 
        }       /************* Termina de eliminar  la IAP **********************************/
        return redirect()->route('verproyectop');
    }    

    // exportar a formato catalogo de OSC a formato excel
    public function actionExportProgExcel(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $codigo       = session()->get('codigo');        
        
        /************ Bitacora inicia *************************************/ 
        setlocale(LC_TIME, "spanish");        
        $xip          = session()->get('ip');
        $xperiodo_id  = (int)date('Y');
        $xprograma_id = 1;
        $xmes_id      = (int)date('m');
        $xproceso_id  =         3;
        $xfuncion_id  =      3001;
        $xtrx_id      =         5;            // Exportar a formato Excel
        $id           =         0;

        $regbitacora = regBitacoraModel::select('PERIODO_ID','MES_ID', 'PROCESO_ID', 'FUNCION_ID', 'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
                        ->where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id,
                                 'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO'      => $id])
                        ->get();
        if($regbitacora->count() <= 0){              // Alta
            $nuevoregBitacora = new regBitacoraModel();              
            $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
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
               toastr()->success('Trx de exportar programas registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            else
               toastr()->error('Error de Trx de exportar programas en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
        }else{                   
            //*********** Obtine el no. de veces *****************************
            $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                        ->max('NO_VECES');
            $xno_veces  = $xno_veces+1;                        
            //*********** Termina de obtener el no de veces *****************************                
            $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                           ->where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 
                                    'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id, 'FOLIO'      => $id])
                           ->update([
                                     'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                     'IP_M'     => $regbitacora->IP       = $ip,
                                     'LOGIN_M'  => $regbitacora->LOGIN_M  = $nombre,
                                     'FECHA_M'  => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                    ]);
            toastr()->success('Trx de exportar programas registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
        }   /************ Bitacora termina *************************************/  
        return Excel::download(new ExcelExportProg, 'Cat_PROGRAMAS_'.date('d-m-Y').'.xlsx');
    } 

    // exportar a formato PDF
    public function actionExportProgPdf(){
        set_time_limit(0);
        ini_set("memory_limit",-1);
        ini_set('max_execution_time', 0);

        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');
        $ip           = session()->get('ip');
        $codigo       = session()->get('codigo');        

        /************ Bitacora inicia *************************************/ 
        setlocale(LC_TIME, "spanish");        
        $xip          = session()->get('ip');
        $xperiodo_id  = (int)date('Y');
        $xprograma_id = 1;
        $xmes_id      = (int)date('m');
        $xproceso_id  =         3;
        $xfuncion_id  =      3001;
        $xtrx_id      =         6;       //Exportar a formato PDF
        $id           =         0;

        $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
                       'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
                       ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 
                                'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                'FOLIO' => $id])
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
               toastr()->success('Trx de exportar a PDF registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            else
               toastr()->error('Error de Trx de exportar a PDF en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
        }else{                   
            //*********** Obtine el no. de veces *****************************
            $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id,'MES_ID'     => $xmes_id, 
                                                  'PROCESO_ID' => $xproceso_id,'FUNCION_ID' => $xfuncion_id, 
                                                  'TRX_ID'     => $xtrx_id,    'FOLIO'      => $id])
                        ->max('NO_VECES');
            $xno_veces = $xno_veces+1;                        
            //*********** Termina de obtener el no de veces *****************************         
            $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                           ->where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id, 
                                    'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO'      => $id])
                           ->update([
                                     'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                     'IP_M'     => $regbitacora->IP       = $ip,
                                     'LOGIN_M'  => $regbitacora->LOGIN_M  = $nombre,
                                     'FECHA_M'  => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                    ]);
            toastr()->success('Trx de exportación a PDF registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
        }   /************ Bitacora termina *************************************/ 

        $regproyectopres  = regProyectopresModel::select('PROG_ID','PROG_DESC','PROG_SIGLAS','PROG_VIGENTE', 
                                              'CLASIFICGOB_ID','PRIORIDAD_ID',
                                              'PROG_ORDEN','PROG_TIPO','PROG_SEPUBLICA','PROG_OBS1', 
                                              'PROG_OBS2','PROG_STATUS1','PROG_STATUS2','PROG_FECREG')
                                     ->orderBy('PROG_ID','ASC')
                                     ->get();                               
        if($regproyectopres->count() <= 0){
            toastr()->error('No existen registros de proyectos presupuestales','Uppss!',['positionClass' => 'toast-bottom-right']);
        }
        $pdf = PDF::loadView('sicinar.pdf.programasPDF', compact('nombre','usuario','regprog'));
        //$options = new Options();
        //$options->set('defaultFont', 'Courier');
        //$pdf->set_option('defaultFont', 'Courier');
        $pdf->setPaper('A4', 'landscape');      
        //$pdf->set('defaultFont', 'Courier');          
        //$pdf->setPaper('A4','portrait');

        // Output the generated PDF to Browser
        return $pdf->stream('CatalogoDeProgramas');
    }


}
