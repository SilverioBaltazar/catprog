<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\progRequest;

use App\regclasificgobModel;

use App\regPrioridadModel;

use App\regProgramasModel;
use App\regDepprogsModel;
use App\regBitacoraModel;

// Exportar a excel 
use App\Exports\ExcelExportProg;
use Maatwebsite\Excel\Facades\Excel;
// Exportar a pdf
use PDF;
//use Options;

class programasController extends Controller
{

    public function actionBuscarProg(Request $request)
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

        $regtotactivas= regProgramasModel::selectRaw('COUNT(*) AS TOTAL_ACTIVAS')
                        ->where('PROG_STATUS1','S')
                        ->get();
        $regtotinactivas=regProgramasModel::selectRaw('COUNT(*) AS TOTAL_INACTIVAS')
                        ->where('PROG_STATUS1','N')
                        ->get();                                                                       
        //**************************************************************//
        // ***** busqueda https://github.com/rimorsoft/Search-simple ***//
        // ***** video https://www.youtube.com/watch?v=bmtD9GUaszw   ***//                            
        //**************************************************************//
        $name  = $request->get('name');    
        //$email = $request->get('email');  
        //$bio   = $request->get('bio');      
        if(session()->get('rango') !== '0'){            
            $regprog = regProgramasModel::orderBy('PROG_ID', 'ASC')
                       ->name($name)           //Metodos personalizados es equvalente a ->where('IAP_DESC', 'LIKE', "%$name%");
                       //->email($email)         //Metodos personalizados
                       //->bio($bio)             //Metodos personalizados
                       ->paginate(50);
        }else{           
            $regprog = regProgramasModel::where('PROG_ID',$codigo)
                       ->orderBy('PROG_ID', 'ASC')
                       ->name($name)           //Metodos personalizados es equvalente a ->where('IAP_DESC', 'LIKE', "%$name%");
                       //->email($email)         //Metodos personalizados
                       //->bio($bio)             //Metodos personalizados
                       ->paginate(50);          
        }
        if($regprog->count() <= 0){
            toastr()->error('No existen programas.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }            
        return view('sicinar.programa.verprog', compact('nombre','usuario','codigo','regprog','regtotactivas','regtotinactivas'));
    }

    public function actionVerProg(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $codigo       = session()->get('codigo');         

        $regtotactivas= regProgramasModel::selectRaw('COUNT(*) AS TOTAL_ACTIVAS')
                        ->where('PROG_STATUS1','S')
                        ->get();
        $regtotinactivas=regProgramasModel::selectRaw('COUNT(*) AS TOTAL_INACTIVAS')
                        ->where('PROG_STATUS1','N')
                        ->get();     
        if(session()->get('rango') !== '0'){                                                       
            $regprog    =regProgramasModel::select('PROG_ID','PROG_DESC','PROG_VERTI','PROG_SIGLAS','PROG_VIGENTE', 
                                                   'CLASIFICGOB_ID','PRIORIDAD_ID',
                                                   'PROG_ORDEN','PROG_TIPO','PROG_SEPUBLICA','PROG_OBS1', 
                                                   'PROG_OBS2','PROG_STATUS1','PROG_STATUS2','PROG_FECREG')
                         ->orderBy('PROG_ID','DESC')
                         ->paginate(50);
        }else{           
            $regprog    =regProgramasModel::select('PROG_ID','PROG_DESC','PROG_VERTI','PROG_SIGLAS','PROG_VIGENTE', 
                                                   'CLASIFICGOB_ID','PRIORIDAD_ID',
                                                   'PROG_ORDEN','PROG_TIPO','PROG_SEPUBLICA','PROG_OBS1', 
                                                   'PROG_OBS2','PROG_STATUS1','PROG_STATUS2','PROG_FECREG')
                       ->where(  'PROG_ID',$codigo)
                       ->orderBy('PROG_ID','DESC')
                       ->paginate(50);          
        }            
        //dd($regprog,' Clave programa......'.$codigo);
        if($regprog->count() <= 0){
            toastr()->error('No existen programas.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.programa.verProg',compact('nombre','usuario','codigo','regprog','regtotactivas','regtotinactivas'));
    }

    public function actionNuevoProg(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $codigo       = session()->get('codigo');   

        $regclasific  = regClasificgobModel::select('CLASIFICGOB_ID','CLASIFICGOB_DESC')
                        ->get(); 
        $regprioridad = regPrioridadModel::select('PRIORIDAD_ID','PRIORIDAD_DESC')
                        ->get();                         
        $regdepprogs  = regDepprogsModel::select('DEPEN_ID1','DEPEN_ID2','DEPEN_ID3','PROG_ID','ESTRUCGOB_ID',
                                                 'CLASIFICGOB_ID','FECHA_REG','FECHA_REG2','IP','LOGIN',
                                                 'FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                        ->get();                      
        $regprog      = regProgramasModel::select('PROG_ID','PROG_DESC','PROG_VERTI','PROG_SIGLAS','PROG_VIGENTE', 
                                                  'CLASIFICGOB_ID','PRIORIDAD_ID',
                                                  'PROG_ORDEN','PROG_TIPO','PROG_SEPUBLICA','PROG_OBS1', 
                                                  'PROG_OBS2','PROG_STATUS1','PROG_STATUS2','PROG_FECREG')
                        ->orderBy('PROG_ID','asc')
                        ->get();
        //dd($unidades);
        return view('sicinar.programa.nuevoProg',compact('nombre','usuario','codigo','regprog','regdepprogs','regclasific','regprioridad'));
    }

    public function actionAltaNuevoProg(Request $request){
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
        $prog_id = regProgramasModel::max('PROG_ID');
        $prog_id = $prog_id + 1;

        $nuevaiap = new regProgramasModel();
        $name1 =null;
        //Comprobar  si el campo foto1 tiene un archivo asignado:
        if($request->hasFile('osc_foto1')){
           $name1 = $osc_id.'_'.$request->file('osc_foto1')->getClientOriginalName(); 
           //$file->move(public_path().'/images/', $name1);
           //sube el archivo a la carpeta del servidor public/images/
           $request->file('osc_foto1')->move(public_path().'/images/', $name1);
        }
        $name2 =null;
        //Comprobar  si el campo foto2 tiene un archivo asignado:        
        if($request->hasFile('osc_foto2')){
           $name2 = $osc_id.'_'.$request->file('osc_foto2')->getClientOriginalName(); 
           //sube el archivo a la carpeta del servidor public/images/
           $request->file('osc_foto2')->move(public_path().'/images/', $name2);
        }
 
        $nuevaiap->PROG_ID       = $prog_id;
        $nuevaiap->PROG_DESC     = substr(trim(strtoupper($request->prog_desc))  ,0,149);
        $nuevaiap->PROG_VERTI    = substr(trim(strtoupper($request->prog_verti)) ,0,149);
        $nuevaiap->PROG_SIGLAS   = substr(trim(strtoupper($request->prog_siglas)),0,149);
        $nuevaiap->PROG_TIPO     = $request->prog_tipo;
        $nuevaiap->PROG_OBS1     = substr(trim(strtoupper($request->prog_obs1))  ,0,199);
        $nuevaiap->CLASIFICGOB_ID= $request->clasificgob_id;        
        $nuevaiap->PRIORIDAD_ID  = $request->prioridad_id;        
        
        //$nuevaiap->OSC_FOTO1   = $name1;
        //$nuevaiap->OSC_FOTO2   = $name2;

        //$nuevaiap->IP          = $ip;
        //$nuevaiap->LOGIN       = $nombre;         // Usuario ;
        //dd($nuevaiap);
        $nuevaiap->save();
        if($nuevaiap->save() == true){
            toastr()->success('Programa dado de alta.','ok!',['positionClass' => 'toast-bottom-right']);

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =       145;    //Alta

            $regbitacora = regBitacoraModel::select('PERIODO_ID', 'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
                                                    'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 
                                                    'FECHA_M', 'IP_M', 'LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id, 'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id, 
                                    'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                    'FOLIO'      => $prog_id])
                           ->get();
            if($regbitacora->count() <= 0){              // Alta
                $nuevoregBitacora = new regBitacoraModel();              
                $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                $nuevoregBitacora->FOLIO      = $prog_id;        // Folio    
                $nuevoregBitacora->NO_VECES   = 1;               // Numero de veces            
                $nuevoregBitacora->IP         = $ip;             // IP
                $nuevoregBitacora->LOGIN      = $nombre;         // Usuario 

                $nuevoregBitacora->save();
                if($nuevoregBitacora->save() == true)
                    toastr()->success('Trx de programa dado de alta en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error de trx de programa en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id,'MES_ID'     => $xmes_id, 
                                                      'PROCESO_ID' => $xproceso_id,'FUNCION_ID' => $xfuncion_id, 
                                                      'TRX_ID'     => $xtrx_id,    'FOLIO'      => $prog_id])
                             ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id, 
                                        'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO'      => $prog_id])
                               ->update([
                                         'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M' => $regbitacora->IP           = $ip,
                                         'LOGIN_M' => $regbitacora->LOGIN_M   = $nombre,
                                         'FECHA_M' => $regbitacora->FECHA_M   = date('Y/m/d')  //date('d/m/Y')
                                       ]);
                toastr()->success('Trx de programa actualizado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }
            /************ Bitacora termina *************************************/ 

        }else{
            toastr()->error('Error de trx de programa. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
        }

        //'*************** Alta de programa - dependencia **************'
        $nuevopd = new regDepprogsModel();
        $nuevopd->PROG_ID  = $prog_id;

        $nuevopd->IP       = $ip;
        $nuevopd->LOGIN    = $nombre;         // Usuario ;        

        $nuevopd->save();
        if($nuevopd->save() == true){
            toastr()->success('Programa - depen. dado de alta.','ok!',['positionClass' => 'toast-bottom-right']);

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =       150;    //Alta

            $regbitacora = regBitacoraModel::select('PERIODO_ID', 'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
                                                    'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 
                                                    'FECHA_M', 'IP_M', 'LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id, 'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id, 
                                    'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                    'FOLIO'      => $prog_id])
                           ->get();
            if($regbitacora->count() <= 0){              // Alta
                $nuevoregBitacora = new regBitacoraModel();              
                $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                $nuevoregBitacora->FOLIO      = $prog_id;        // Folio    
                $nuevoregBitacora->NO_VECES   = 1;               // Numero de veces            
                $nuevoregBitacora->IP         = $ip;             // IP
                $nuevoregBitacora->LOGIN      = $nombre;         // Usuario 

                $nuevoregBitacora->save();
                if($nuevoregBitacora->save() == true)
                    toastr()->success('Trx de programa - depen. registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error de trx de programa - depen. en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id,'MES_ID'     => $xmes_id, 
                                                      'PROCESO_ID' => $xproceso_id,'FUNCION_ID' => $xfuncion_id, 
                                                      'TRX_ID'     => $xtrx_id,    'FOLIO'      => $prog_id])
                             ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id, 
                                        'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO'      => $prog_id])
                               ->update([
                                         'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M' => $regbitacora->IP           = $ip,
                                         'LOGIN_M' => $regbitacora->LOGIN_M   = $nombre,
                                         'FECHA_M' => $regbitacora->FECHA_M   = date('Y/m/d')  //date('d/m/Y')
                                       ]);
                toastr()->success('Trx de programa - depen. actualizado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }
            /************ Bitacora termina *************************************/ 
        }else{
            toastr()->error('Error de trx de programa - depen. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
        }
        return redirect()->route('verprog');
    }

    public function actionEditarProg($id){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');
        $codigo        = session()->get('codigo');         

        $regclasific  = regClasificgobModel::select('CLASIFICGOB_ID','CLASIFICGOB_DESC')
                        ->get(); 
        $regprioridad = regPrioridadModel::select('PRIORIDAD_ID','PRIORIDAD_DESC')
                        ->get();                         
        $regprog      = regProgramasModel::select('PROG_ID','PROG_DESC','PROG_VERTI','PROG_SIGLAS','PROG_VIGENTE', 
                                                  'CLASIFICGOB_ID','PRIORIDAD_ID',
                                                  'PROG_ORDEN','PROG_TIPO','PROG_SEPUBLICA','PROG_OBS1', 
                                                  'PROG_OBS2','PROG_STATUS1','PROG_STATUS2','PROG_FECREG')
                        ->where(  'PROG_ID',$id)
                        ->orderBy('PROG_ID','ASC')
                        ->first();
        if($regprog->count() <= 0){
            toastr()->error('No existe programa.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.programa.editarProg',compact('nombre','usuario','codigo','regprog','regclasific','regprioridad'));
    }

    public function actionActualizarProg(progRequest $request, $id){
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
        $regprog = regProgramasModel::where('PROG_ID',$id);
        if($regprog->count() <= 0)
            toastr()->error('No existe programa.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            //*************** Actualizar ********************************/
            $name1 =null;
            $name2 =null;
            $name3 =null;
            //*********** Actualizarn items **********************
            $regprog = regProgramasModel::where('PROG_ID',$id)        
                      ->update([                
                                'PROG_DESC'     => substr(trim(strtoupper($request->prog_desc))  ,0,149),
                                'PROG_VERTI'    => substr(trim(strtoupper($request->prog_verti)) ,0,149),
                                'PROG_SIGLAS'   => substr(trim(strtoupper($request->prog_siglas)),0,149),
                                'PROG_TIPO'     => $request->prog_tipo,
                                'PROG_OBS1'     => substr(trim(strtoupper($request->prog_obs1))  ,0,199),
                                'CLASIFICGOB_ID'=> $request->clasificgob_id,
                                'PRIORIDAD_ID'  => $request->prioridad_id,                      
                                'PROG_STATUS1'  => $request->prog_status1
                              ]);
            toastr()->success('Programa actualizado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =       146;    //Actualizar OSC        
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
                    toastr()->success('Trx de actualización de programa registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error Trx de actualización de programa en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
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
                toastr()->success('Trx de actualización de programa registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                     
        }       /************ Actualizar *******************************************/
        return redirect()->route('verprog');
    }

    public function actionBorrarProg($id){
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
        $regprog      = regProgramasModel::select('PROG_ID','PROG_DESC','PROG_VERTI','PROG_SIGLAS','PROG_VIGENTE', 
                                                  'CLASIFICGOB_ID','PRIORIDAD_ID',
                                                  'PROG_ORDEN','PROG_TIPO','PROG_SEPUBLICA','PROG_OBS1', 
                                                  'PROG_OBS2','PROG_STATUS1','PROG_STATUS2','PROG_FECREG')
                        ->where('PROG_ID',$id);
        if($regprog->count() <= 0)
            toastr()->error('No existe programa.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            $regprog->delete();
            toastr()->success('Programa eliminado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            //echo 'Ya entre a borrar registro..........';
            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =       147;     // Baja de IAP

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
                    toastr()->success('Trx de baja de programa registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error en Trx de baja de programa en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
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
                toastr()->success('Trx de actualizar programa registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                 
        }       /************* Termina de eliminar  la IAP **********************************/
        return redirect()->route('verprog');
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
        $xtrx_id      =       148;            // Exportar a formato Excel
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
        $xtrx_id      =       149;       //Exportar a formato PDF
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

        $regprog  = regProgramasModel::select('PROG_ID','PROG_DESC','PROG_VERTI','PROG_SIGLAS','PROG_VIGENTE', 
                                              'CLASIFICGOB_ID','PRIORIDAD_ID',
                                              'PROG_ORDEN','PROG_TIPO','PROG_SEPUBLICA','PROG_OBS1', 
                                              'PROG_OBS2','PROG_STATUS1','PROG_STATUS2','PROG_FECREG')
                                     ->orderBy('PROG_ID','ASC')
                                     ->get();                               
        if($regprog->count() <= 0){
            toastr()->error('No existen registros de programas.','Uppss!',['positionClass' => 'toast-bottom-right']);
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

    //*********************************************************************************//
    //************************* Estadísticas ******************************************//
    //*********************************************************************************//
    // Gráfica por estado
    public function OscxEdo(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip'); 
        $arbol_id     = session()->get('arbol_id');               

        $regtotxedo=regProgramasModel::join('CP_CAT_ENTIDADES_FED',[['CP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_ID','=','CP_OSC.ENTIDADFEDERATIVA_ID'],['CP_OSC.OSC_ID','<>',0]])
                         ->selectRaw('COUNT(*) AS TOTALXEDO')
                               ->get();

        $regprog=regProgramasModel::join('CP_CAT_ENTIDADES_FED',[['CP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_ID','=','CP_OSC.ENTIDADFEDERATIVA_ID'],['CP_OSC.OSC_ID','<>',0]])
                      ->selectRaw('CP_OSC.ENTIDADFEDERATIVA_ID, CP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_DESC AS ESTADO, COUNT(*) AS TOTAL')
                        ->groupBy('CP_OSC.ENTIDADFEDERATIVA_ID', 'CP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_DESC')
                        ->orderBy('CP_OSC.ENTIDADFEDERATIVA_ID','asc')
                        ->get();
        //$procesos = procesosModel::join('SCI_TIPO_PROCESO','SCI_PROCESOS.CVE_TIPO_PROC','=','SCI_TIPO_PROCESO.CVE_TIPO_PROC')
        //    ->selectRaw('SCI_TIPO_PROCESO.DESC_TIPO_PROC AS TIPO, COUNT(SCI_PROCESOS.CVE_TIPO_PROC) AS TOTAL')
        //    ->groupBy('SCI_TIPO_PROCESO.DESC_TIPO_PROC')
        //    ->get();
        //dd($procesos);
        return view('sicinar.numeralia.iapxedo',compact('regprog','regtotxedo','nombre','usuario','rango'));
    }

    // Filtro de estadistica de la bitacora
    public function actionVerBitacora(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');

        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')->get();   
        $regperiodos  = regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')->get();        
        if($regperiodos->count() <= 0){
            toastr()->error('No existen periodos fiscales.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevaIap');
        }
        return view('sicinar.programa.verBitacora',compact('nombre','usuario','regmeses','regperiodos'));
    }

    // Gráfica de transacciones (Bitacora)
    public function Bitacora(Request $request){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip'); 
        $arbol_id     = session()->get('arbol_id');

        // http://www.chartjs.org/docs/#bar-chart
        $regperiodos  = regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')->get();                
        $regbitatxmes=regBitacoraModel::join('CP_CAT_PROCESOS' ,'CP_CAT_PROCESOS.PROCESO_ID' ,'=','CP_BITACORA.PROCESO_ID')
                                      ->join('CP_CAT_FUNCIONES','CP_CAT_FUNCIONES.FUNCION_ID','=','CP_BITACORA.FUNCION_ID')
                                      ->join('CP_CAT_TRX'      ,'CP_CAT_TRX.TRX_ID'          ,'=','CP_BITACORA.TRX_ID')
                                      ->join('CP_CAT_MESES'    ,'CP_CAT_MESES.MES_ID'        ,'=','CP_BITACORA.MES_ID')
                                 ->select(   'CP_BITACORA.MES_ID','CP_CAT_MESES.MES_DESC')
                                 ->selectRaw('COUNT(*) AS TOTALGENERAL')
                                 ->where(    'CP_BITACORA.PERIODO_ID',$request->periodo_id)
                                 ->groupBy(  'CP_BITACORA.MES_ID','CP_CAT_MESES.MES_DESC')
                                 ->orderBy(  'CP_BITACORA.MES_ID','asc')
                                 ->get();        
        $regbitatot=regBitacoraModel::join('CP_CAT_PROCESOS','CP_CAT_PROCESOS.PROCESO_ID' ,'=','CP_BITACORA.PROCESO_ID')
                                   ->join('CP_CAT_FUNCIONES','CP_CAT_FUNCIONES.FUNCION_ID','=','CP_BITACORA.FUNCION_ID')
                                   ->join('CP_CAT_TRX'      ,'CP_CAT_TRX.TRX_ID'          ,'=','CP_BITACORA.TRX_ID')
                         ->selectRaw('SUM(CASE WHEN CP_BITACORA.MES_ID = 1 THEN 1 END) AS M01')  
                         ->selectRaw('SUM(CASE WHEN CP_BITACORA.MES_ID = 2 THEN 1 END) AS M02')
                         ->selectRaw('SUM(CASE WHEN CP_BITACORA.MES_ID = 3 THEN 1 END) AS M03')
                         ->selectRaw('SUM(CASE WHEN CP_BITACORA.MES_ID = 4 THEN 1 END) AS M04')
                         ->selectRaw('SUM(CASE WHEN CP_BITACORA.MES_ID = 5 THEN 1 END) AS M05')
                         ->selectRaw('SUM(CASE WHEN CP_BITACORA.MES_ID = 6 THEN 1 END) AS M06')
                         ->selectRaw('SUM(CASE WHEN CP_BITACORA.MES_ID = 7 THEN 1 END) AS M07')
                         ->selectRaw('SUM(CASE WHEN CP_BITACORA.MES_ID = 8 THEN 1 END) AS M08')
                         ->selectRaw('SUM(CASE WHEN CP_BITACORA.MES_ID = 9 THEN 1 END) AS M09')
                         ->selectRaw('SUM(CASE WHEN CP_BITACORA.MES_ID =10 THEN 1 END) AS M10')
                         ->selectRaw('SUM(CASE WHEN CP_BITACORA.MES_ID =11 THEN 1 END) AS M11')
                         ->selectRaw('SUM(CASE WHEN CP_BITACORA.MES_ID =12 THEN 1 END) AS M12')
                         ->selectRaw('COUNT(*) AS TOTALGENERAL')
                         ->where(    'CP_BITACORA.PERIODO_ID',$request->periodo_id)
                         ->get();

        $regbitacora=regBitacoraModel::join('CP_CAT_PROCESOS' ,'CP_CAT_PROCESOS.PROCESO_ID' ,'=','CP_BITACORA.PROCESO_ID')
                                     ->join('CP_CAT_FUNCIONES','CP_CAT_FUNCIONES.FUNCION_ID','=','CP_BITACORA.FUNCION_ID')
                                     ->join('CP_CAT_TRX'      ,'CP_CAT_TRX.TRX_ID'          ,'=','CP_BITACORA.TRX_ID')
                    ->select(   'CP_BITACORA.PERIODO_ID', 'CP_BITACORA.PROCESO_ID','CP_CAT_PROCESOS.PROCESO_DESC', 
                                'CP_BITACORA.FUNCION_ID', 'CP_CAT_FUNCIONES.FUNCION_DESC', 
                                'CP_BITACORA.TRX_ID',     'CP_CAT_TRX.TRX_DESC')
                    ->selectRaw('SUM(CASE WHEN CP_BITACORA.MES_ID = 1 THEN 1 END) AS ENE')  
                    ->selectRaw('SUM(CASE WHEN CP_BITACORA.MES_ID = 2 THEN 1 END) AS FEB')
                    ->selectRaw('SUM(CASE WHEN CP_BITACORA.MES_ID = 3 THEN 1 END) AS MAR')
                    ->selectRaw('SUM(CASE WHEN CP_BITACORA.MES_ID = 4 THEN 1 END) AS ABR')
                    ->selectRaw('SUM(CASE WHEN CP_BITACORA.MES_ID = 5 THEN 1 END) AS MAY')
                    ->selectRaw('SUM(CASE WHEN CP_BITACORA.MES_ID = 6 THEN 1 END) AS JUN')
                    ->selectRaw('SUM(CASE WHEN CP_BITACORA.MES_ID = 7 THEN 1 END) AS JUL')
                    ->selectRaw('SUM(CASE WHEN CP_BITACORA.MES_ID = 8 THEN 1 END) AS AGO')
                    ->selectRaw('SUM(CASE WHEN CP_BITACORA.MES_ID = 9 THEN 1 END) AS SEP')
                    ->selectRaw('SUM(CASE WHEN CP_BITACORA.MES_ID =10 THEN 1 END) AS OCT')
                    ->selectRaw('SUM(CASE WHEN CP_BITACORA.MES_ID =11 THEN 1 END) AS NOV')
                    ->selectRaw('SUM(CASE WHEN CP_BITACORA.MES_ID =12 THEN 1 END) AS DIC')                   
                    ->selectRaw('COUNT(*) AS SUMATOTAL')
                    ->where(    'CP_BITACORA.PERIODO_ID',$request->periodo_id)
                    ->groupBy(  'CP_BITACORA.PERIODO_ID','CP_BITACORA.PROCESO_ID','CP_CAT_PROCESOS.PROCESO_DESC',
                                'CP_BITACORA.FUNCION_ID','CP_CAT_FUNCIONES.FUNCION_DESC', 
                                'CP_BITACORA.TRX_ID'    ,'CP_CAT_TRX.TRX_DESC')
                    ->orderBy(  'CP_BITACORA.PERIODO_ID','asc')
                    ->orderBy(  'CP_BITACORA.PROCESO_ID','asc')
                    ->orderBy(  'CP_BITACORA.FUNCION_ID','asc')
                    ->orderBy(  'CP_BITACORA.TRX_ID'    ,'asc')
                    ->get();
        //dd($procesos);
        return view('sicinar.numeralia.bitacora',compact('regbitatxmes','regbitacora','regbitatot','regperiodos','nombre','usuario','rango'));
    }

    // Georefrenciación por municipio
    public function actiongeorefxmpio(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');  
        $arbol_id     = session()->get('arbol_id');              

        $regprog=regProgramasModel::join(  'CP_CAT_ENTIDADES_FED',     'CP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_ID','=',
                                                                'CP_OSC.ENTIDADFEDERATIVA_ID')
                           ->join(  'CP_CAT_MUNICIPIOS_SEDESEM',[['CP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','=',
                                                                'CP_OSC.ENTIDADFEDERATIVA_ID'],
                                                               ['CP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIOID'        ,'=',
                                                                'CP_OSC.MUNICIPIO_ID'],
                                                               ['CP_OSC.OSC_ID','<>',0]
                                                              ])
                        ->select(   'CP_OSC.ENTIDADFEDERATIVA_ID','CP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_DESC AS ENTIDAD',
                                    'CP_OSC.MUNICIPIO_ID',        'CP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE AS MUNICIPIO', 
                                    'CP_CAT_MUNICIPIOS_SEDESEM.GEOREF_CABMPIO_LATDECIMAL', 
                                    'CP_CAT_MUNICIPIOS_SEDESEM.GEOREF_CABMPIO_LONGDECIMAL')
                        ->selectRaw('COUNT(*) AS TOTAL')
                        ->groupBy(  'CP_OSC.ENTIDADFEDERATIVA_ID','CP_CAT_ENTIDADES_FED.ENTIDADFEDERATIVA_DESC',
                                    'CP_OSC.MUNICIPIO_ID',        'CP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE', 
                                    'CP_CAT_MUNICIPIOS_SEDESEM.GEOREF_CABMPIO_LATDECIMAL', 
                                    'CP_CAT_MUNICIPIOS_SEDESEM.GEOREF_CABMPIO_LONGDECIMAL')
                        ->orderBy('CP_OSC.ENTIDADFEDERATIVA_ID','asc')
                        ->orderBy('CP_OSC.MUNICIPIO_ID'        ,'asc')
                        ->get();
        //dd($procesos);
        return view('sicinar.numeralia.mapaxmpio',compact('regprog','nombre','usuario','rango'));
    }


    // Estadistica por municipio    
    public function OscxMpio(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');  
        $arbol_id     = session()->get('arbol_id');              

        $regtotxmpio=regProgramasModel::join('CP_CAT_MUNICIPIOS_SEDESEM',[['CP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','=',15],
                                                            ['CP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIOID','=','CP_OSC.MUNICIPIO_ID'],['CP_OSC.OSC_ID','<>',0]])
                         ->selectRaw('COUNT(*) AS TOTALXMPIO')
                               ->get();
        $regprog=regProgramasModel::join('CP_CAT_MUNICIPIOS_SEDESEM',[['CP_CAT_MUNICIPIOS_SEDESEM.ENTIDADFEDERATIVAID','=',15],
                                                            ['CP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIOID','=','CP_OSC.MUNICIPIO_ID'],['CP_OSC.OSC_ID','<>',0]])
                      ->selectRaw('CP_OSC.MUNICIPIO_ID, CP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE AS MUNICIPIO,COUNT(*) AS TOTAL')
                        ->groupBy('CP_OSC.MUNICIPIO_ID', 'CP_CAT_MUNICIPIOS_SEDESEM.MUNICIPIONOMBRE')
                        ->orderBy('CP_OSC.MUNICIPIO_ID','asc')
                        ->get();
        //dd($procesos);
        return view('sicinar.numeralia.oscxmpio',compact('regprog','regtotxmpio','nombre','usuario','rango'));
    }    

    // Gráfica por Rubro social
    public function OscxRubro(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip'); 
        $arbol_id     = session()->get('arbol_id');               

        $regtotxrubro=regProgramasModel::join('CP_CAT_RUBROS','CP_CAT_RUBROS.RUBRO_ID','=','CP_OSC.RUBRO_ID')
                      ->selectRaw('COUNT(*) AS TOTALXRUBRO')
                            ->get();
        $regprog=regProgramasModel::join('CP_CAT_RUBROS','CP_CAT_RUBROS.RUBRO_ID','=','CP_OSC.RUBRO_ID')
                      ->selectRaw('CP_OSC.RUBRO_ID,  CP_CAT_RUBROS.RUBRO_DESC AS RUBRO, COUNT(*) AS TOTAL')
                        ->groupBy('CP_OSC.RUBRO_ID','CP_CAT_RUBROS.RUBRO_DESC')
                        ->orderBy('CP_OSC.RUBRO_ID','asc')
                        ->get();
        //$procesos = procesosModel::join('SCI_TIPO_PROCESO','SCI_PROCESOS.CVE_TIPO_PROC','=','SCI_TIPO_PROCESO.CVE_TIPO_PROC')
        //    ->selectRaw('SCI_TIPO_PROCESO.DESC_TIPO_PROC AS TIPO, COUNT(SCI_PROCESOS.CVE_TIPO_PROC) AS TOTAL')
        //    ->groupBy('SCI_TIPO_PROCESO.DESC_TIPO_PROC')
        //    ->get();
        //dd($procesos);
        return view('sicinar.numeralia.oscxrubro',compact('regprog','regtotxrubro','nombre','usuario','rango'));
    }

    // Gráfica por Rubro social
    public function OscxRubro2(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip'); 
        $arbol_id     = session()->get('arbol_id');               

        $regtotxrubro=regProgramasModel::join('CP_CAT_RUBROS','CP_CAT_RUBROS.RUBRO_ID','=','CP_OSC.RUBRO_ID')
                      ->selectRaw('COUNT(*) AS TOTALXRUBRO')
                            ->get();
        $regprog=regProgramasModel::join('CP_CAT_RUBROS','CP_CAT_RUBROS.RUBRO_ID','=','CP_OSC.RUBRO_ID')
                      ->selectRaw('CP_OSC.RUBRO_ID,  CP_CAT_RUBROS.RUBRO_DESC AS RUBRO, COUNT(*) AS TOTAL')
                        ->groupBy('CP_OSC.RUBRO_ID','CP_CAT_RUBROS.RUBRO_DESC')
                        ->orderBy('CP_OSC.RUBRO_ID','asc')
                        ->get();
        //$procesos = procesosModel::join('SCI_TIPO_PROCESO','SCI_PROCESOS.CVE_TIPO_PROC','=','SCI_TIPO_PROCESO.CVE_TIPO_PROC')
        //    ->selectRaw('SCI_TIPO_PROCESO.DESC_TIPO_PROC AS TIPO, COUNT(SCI_PROCESOS.CVE_TIPO_PROC) AS TOTAL')
        //    ->groupBy('SCI_TIPO_PROCESO.DESC_TIPO_PROC')
        //    ->get();
        //dd($procesos);
        return view('sicinar.numeralia.graficadeprueba',compact('regprog','regtotxrubro','nombre','usuario','rango'));
    }

    // Mapas
    public function Mapas(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip'); 
        $arbol_id     = session()->get('arbol_id');               

        $regtotxrubro=regProgramasModel::join('CP_CAT_RUBROS','CP_CAT_RUBROS.RUBRO_ID','=','CP_OSC.RUBRO_ID')
                      ->selectRaw('COUNT(*) AS TOTALXRUBRO')
                            ->get();

        $regprog=regProgramasModel::join('CP_CAT_RUBROS','CP_CAT_RUBROS.RUBRO_ID','=','CP_OSC.RUBRO_ID')
                      ->selectRaw('CP_OSC.RUBRO_ID,  CP_CAT_RUBROS.RUBRO_DESC AS RUBRO, COUNT(*) AS TOTAL')
                        ->groupBy('CP_OSC.RUBRO_ID','CP_CAT_RUBROS.RUBRO_DESC')
                        ->orderBy('CP_OSC.RUBRO_ID','asc')
                        ->get();
        //$procesos = procesosModel::join('SCI_TIPO_PROCESO','SCI_PROCESOS.CVE_TIPO_PROC','=','SCI_TIPO_PROCESO.CVE_TIPO_PROC')
        //    ->selectRaw('SCI_TIPO_PROCESO.DESC_TIPO_PROC AS TIPO, COUNT(SCI_PROCESOS.CVE_TIPO_PROC) AS TOTAL')
        //    ->groupBy('SCI_TIPO_PROCESO.DESC_TIPO_PROC')
        //    ->get();
        //dd($procesos);
        return view('sicinar.numeralia.mapasdeprueba',compact('regprog','regtotxrubro','nombre','usuario','rango'));
    }

    // Mapas
    public function Mapas2(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $arbol_id     = session()->get('arbol_id');                

        $regtotxrubro=regProgramasModel::join('CP_CAT_RUBROS','CP_CAT_RUBROS.RUBRO_ID','=','CP_OSC.RUBRO_ID')
                      ->selectRaw('COUNT(*) AS TOTALXRUBRO')
                            ->get();

        $regprog=regProgramasModel::join('CP_CAT_RUBROS','CP_CAT_RUBROS.RUBRO_ID','=','CP_OSC.RUBRO_ID')
                      ->selectRaw('CP_OSC.RUBRO_ID,  CP_CAT_RUBROS.RUBRO_DESC AS RUBRO, COUNT(*) AS TOTAL')
                        ->groupBy('CP_OSC.RUBRO_ID','CP_CAT_RUBROS.RUBRO_DESC')
                        ->orderBy('CP_OSC.RUBRO_ID','asc')
                        ->get();
        //$procesos = procesosModel::join('SCI_TIPO_PROCESO','SCI_PROCESOS.CVE_TIPO_PROC','=','SCI_TIPO_PROCESO.CVE_TIPO_PROC')
        //    ->selectRaw('SCI_TIPO_PROCESO.DESC_TIPO_PROC AS TIPO, COUNT(SCI_PROCESOS.CVE_TIPO_PROC) AS TOTAL')
        //    ->groupBy('SCI_TIPO_PROCESO.DESC_TIPO_PROC')
        //    ->get();
        //dd($procesos);
        return view('sicinar.numeralia.mapasdeprueba2',compact('regprog','regtotxrubro','nombre','usuario','rango'));
    }

    // Mapas
    public function Mapas3(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $arbol_id     = session()->get('arbol_id');                

        $regtotxrubro=regProgramasModel::join('CP_CAT_RUBROS','CP_CAT_RUBROS.RUBRO_ID','=','CP_OSC.RUBRO_ID')
                      ->selectRaw('COUNT(*) AS TOTALXRUBRO')
                            ->get();
        $regprog=regProgramasModel::join('CP_CAT_RUBROS','CP_CAT_RUBROS.RUBRO_ID','=','CP_OSC.RUBRO_ID')
                      ->selectRaw('CP_OSC.RUBRO_ID,  CP_CAT_RUBROS.RUBRO_DESC AS RUBRO, COUNT(*) AS TOTAL')
                        ->groupBy('CP_OSC.RUBRO_ID','CP_CAT_RUBROS.RUBRO_DESC')
                        ->orderBy('CP_OSC.RUBRO_ID','asc')
                        ->get();
        //dd($procesos);
        return view('sicinar.numeralia.mapasdeprueba3',compact('regprog','regtotxrubro','nombre','usuario','rango'));
    }

}
