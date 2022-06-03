<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\directorioRequest;
use App\regBitacoraModel;
use App\regPeriodosModel;
use App\regProgramasModel;
use App\regDirectorioModel;


// Exportar a excel 
//use App\Exports\ExportPadronExcel;
use Maatwebsite\Excel\Facades\Excel;
// Exportar a pdf
use PDF;
//use Options;

class directorioController extends Controller
{

    public function actionBuscarDirectorio(Request $request)
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

        $regperiodos  = regPeriodosModel::select('PERIODO_ID', 'PERIODO_DESC')
                        ->get();  
        $regprogramas = regProgramasModel::select('PROG_ID','PROG_DESC')
                        ->orderBy('PROG_ID','asc')
                        ->get();                                
        //**************************************************************//
        // ***** busqueda https://github.com/rimorsoft/Search-simple ***//
        // ***** video https://www.youtube.com/watch?v=bmtD9GUaszw   ***//                            
        //**************************************************************//
        //********* Validar rol de usuario **********************/
        $name    = $request->get('name');   
        $nameiap = $request->get('nameiap');           
        //$email = $request->get('email');  
        //$bio   = $request->get('bio');             
        if(session()->get('rango') !== '0'){    
            $regdirectorio= regDirectorioModel::join('PE_OSC','PE_OSC.OSC_ID','=','PE_METADATO_PADRON.OSC_ID')
                        ->select( 'PE_OSC.OSC_DESC','PE_METADATO_PADRON.*')
                        ->orderBy('PE_METADATO_PADRON.OSC_ID', 'ASC')
                        ->name($name)           //Metodos personalizados es equvalente a ->where('OSC_DESC', 'LIKE', "%$name%");
                        ->nameiap($nameiap)     //Metodos personalizados
                        //->bio($bio)           //Metodos personalizados
                        ->paginate(30);                 
        }else{                
            $regdirectorio= regDirectorioModel::join('PE_OSC','PE_OSC.OSC_ID','=','PE_METADATO_PADRON.OSC_ID')
                        ->select( 'PE_OSC.OSC_DESC','PE_METADATO_PADRON.*')
                        ->where(  'PE_METADATO_PADRON.OSC_ID',$codigo)
                        ->orderBy('PE_METADATO_PADRON.OSC_ID','ASC')
                        ->name($name)           //Metodos personalizados es equvalente a ->where('OSC_DESC', 'LIKE', "%$name%");
                        ->nameiap($nameiap)       //Metodos personalizados
                        //->bio($bio)             //Metodos personalizados
                        ->paginate(30);                         
        }
        if($regdirectorio->count() <= 0){
            toastr()->error('No existen directorio.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }            
        return view('sicinar.directorio.verDirectorio', compact('nombre','usuario','regdirectorio','regprogramas','regperiodos'));
    }

    public function actionverDirectorio(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $codigo       = session()->get('codigo');          

        $regperiodos  = regPeriodosModel::select('PERIODO_ID', 'PERIODO_DESC')
                        ->get();                                  
        //********* Validar rol de usuario **********************/
        if(session()->get('rango') !== '0'){    
            $regprogramas=regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->orderBy('PROG_ID','asc')
                          ->get();        
            $regdirectorio=regDirectorioModel::select('PERIODO_ID','PROG_ID','DIR_NOMBRE_1','DIR_CARGO_1','DIR_EMAIL_1',
                           'DIR_TEL_1','DIR_NOMBRE_2','DIR_CARGO_2','DIR_EMAIL_2','DIR_TEL_2',
                           'DIR_NOMBRE_3','DIR_CARGO_3','DIR_EMAIL_3','DIR_TEL_3',
                           'DIR_NOMBRE_4','DIR_CARGO_4','DIR_EMAIL_4','DIR_TEL_4',
                           'DIR_NOMBRE_5','DIR_CARGO_5','DIR_EMAIL_5','DIR_TEL_5',
                           'DIR_OBS_1','DIR_OBS_2','DIR_STATUS1','DIR_STATUS2',
                           'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                           ->orderBy('PERIODO_ID','asc')
                           ->orderBy('PROG_ID'   ,'asc')
                           ->paginate(30);
        }else{            
            $regprogramas=regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->where('PROG_ID',$codigo)
                          ->get();                    
            $regdirectorio=regDirectorioModel::select('PERIODO_ID','PROG_ID',
                           'DIR_NOMBRE_1','DIR_CARGO_1','DIR_EMAIL_1','DIR_TEL_1',
                           'DIR_NOMBRE_2','DIR_CARGO_2','DIR_EMAIL_2','DIR_TEL_2',
                           'DIR_NOMBRE_3','DIR_CARGO_3','DIR_EMAIL_3','DIR_TEL_3',
                           'DIR_NOMBRE_4','DIR_CARGO_4','DIR_EMAIL_4','DIR_TEL_4',
                           'DIR_NOMBRE_5','DIR_CARGO_5','DIR_EMAIL_5','DIR_TEL_5',
                           'DIR_OBS_1','DIR_OBS_2','DIR_STATUS1','DIR_STATUS2',
                           'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                           ->where('PROG_ID',$codigo)
                           ->paginate(30);            
        }
        if($regdirectorio->count() <= 0){
            toastr()->error('No existe directorio.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevoPadron');
        }
        return view('sicinar.directorio.verDirectorio',compact('nombre','usuario','regprogramas','regperiodos','regdirectorio'));
    }

    public function actionnuevoDirectorio(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $codigo       = session()->get('codigo');   

        $regperiodos  = regPeriodosModel::select('PERIODO_ID', 'PERIODO_DESC')
                        ->get();                       
        if(session()->get('rango') !== '0'){                           
            $regprogramas=regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->orderBy('PROG_ID','asc')
                          ->get();                           
            $regdirectorio=regDirectorioModel::select('PERIODO_ID','PROG_ID',
                           'DIR_NOMBRE_1','DIR_CARGO_1','DIR_EMAIL_1','DIR_TEL_1',
                           'DIR_NOMBRE_2','DIR_CARGO_2','DIR_EMAIL_2','DIR_TEL_2',
                           'DIR_NOMBRE_3','DIR_CARGO_3','DIR_EMAIL_3','DIR_TEL_3',
                           'DIR_NOMBRE_4','DIR_CARGO_4','DIR_EMAIL_4','DIR_TEL_4',
                           'DIR_NOMBRE_5','DIR_CARGO_5','DIR_EMAIL_5','DIR_TEL_5',
                           'DIR_OBS_1','DIR_OBS_2','DIR_STATUS1','DIR_STATUS2',
                           'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                           ->orderBy('PERIODO_ID','asc')
                           ->orderBy('PROG_ID'   ,'asc')
                           ->get();                                      
        }else{
            $regprogramas =regProgramasModel::select('PROG_ID','PROG_DESC')
                           ->where('PROG_ID',$codigo)
                           ->get();                
            $regdirectorio=regDirectorioModel::select('PERIODO_ID','PROG_ID',
                           'DIR_NOMBRE_1','DIR_CARGO_1','DIR_EMAIL_1','DIR_TEL_1',
                           'DIR_NOMBRE_2','DIR_CARGO_2','DIR_EMAIL_2','DIR_TEL_2',
                           'DIR_NOMBRE_3','DIR_CARGO_3','DIR_EMAIL_3','DIR_TEL_3',
                           'DIR_NOMBRE_4','DIR_CARGO_4','DIR_EMAIL_4','DIR_TEL_4',
                           'DIR_NOMBRE_5','DIR_CARGO_5','DIR_EMAIL_5','DIR_TEL_5',
                           'DIR_OBS_1','DIR_OBS_2','DIR_STATUS1','DIR_STATUS2',
                           'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                           ->where(  'PROG_ID'   ,$codigo)
                           ->orderBy('PERIODO_ID','asc')
                           ->orderBy('PROG_ID'   ,'asc')
                           ->get();                          
        }                                                
        return view('sicinar.directorio.nuevoDirectorio',compact('nombre','usuario','regperiodos','regdirectorio','regprogramas'));
    }

    public function actionAltanuevoDirectorio(Request $request){
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

        // **************** validar duplicidad ******************************/
        setlocale(LC_TIME, "spanish");        
        $xperiodo_id  = (int)date('Y');        

        // *************** Validar triada ***********************************/
        $triada = regDirectorioModel::where(['PERIODO_ID' => $request->periodo_id,'PROG_ID' => $request->prog_id])
                  ->get();
        if($triada->count() >= 1)
            return back()->withInput()->withErrors(['PROG_ID' => 'Programa '.$request->prog_id.' Ya existe. Por favor verificar.']);
        else{        
            //**************************** Alta ********************************/
            //$folio = regDirectorioModel::max('FOLIO');
            //$folio = $folio + 1;
            $nuevoPadron = new regDirectorioModel();

            $nuevoPadron->PERIODO_ID       = $request->periodo_id;
            $nuevoPadron->PROG_ID          = $request->prog_id;

            $nuevoPadron->DIR_NOMBRE_1     = substr(strtoupper(trim($request->dir_nombre_1)) ,0,149);
            $nuevoPadron->DIR_CARGO_1      = substr(strtoupper(trim($request->dir_cargo_1))  ,0, 99);
            $nuevoPadron->DIR_TEL_1        = substr(strtoupper(trim($request->dir_tel_1))    ,0, 99);
            $nuevoPadron->DIR_EMAIL_1      = substr(strtolower(trim($request->dir_email_1))  ,0, 99);  

            $nuevoPadron->DIR_NOMBRE_2     = substr(strtoupper(trim($request->dir_nombre_2)) ,0,149);
            $nuevoPadron->DIR_CARGO_2      = substr(strtoupper(trim($request->dir_cargo_2))  ,0, 99);
            $nuevoPadron->DIR_TEL_2        = substr(strtoupper(trim($request->dir_tel_2))    ,0, 99);
            $nuevoPadron->DIR_EMAIL_2      = substr(strtolower(trim($request->dir_email_2))  ,0, 99);

            $nuevoPadron->DIR_NOMBRE_3     = substr(strtoupper(trim($request->dir_nombre_3)) ,0,149);
            $nuevoPadron->DIR_CARGO_3      = substr(strtoupper(trim($request->dir_cargo_3))  ,0, 99);
            $nuevoPadron->DIR_TEL_3        = substr(strtoupper(trim($request->dir_tel_3))    ,0, 99);
            $nuevoPadron->DIR_EMAIL_3      = substr(strtolower(trim($request->dir_email_3))  ,0, 99);                                

            $nuevoPadron->DIR_NOMBRE_4     = substr(strtoupper(trim($request->dir_nombre_4)) ,0,149);
            $nuevoPadron->DIR_CARGO_4      = substr(strtoupper(trim($request->dir_cargo_4))  ,0, 99);
            $nuevoPadron->DIR_TEL_4        = substr(strtoupper(trim($request->dir_tel_4))    ,0, 99);
            $nuevoPadron->DIR_EMAIL_4      = substr(strtolower(trim($request->dir_email_4))  ,0, 99);

            $nuevoPadron->IP          = $ip;
            $nuevoPadron->LOGIN       = $nombre;         // Usuario ;

            $nuevoPadron->save();
            if($nuevoPadron->save() == true){
                    toastr()->success('Directorio dado de alta.','ok!',['positionClass' => 'toast-bottom-right']);

                    /************ Bitacora inicia *************************************/ 
                    setlocale(LC_TIME, "spanish");        
                    $xip          = session()->get('ip');
                    $xperiodo_id  = (int)date('Y');
                    $xprograma_id = 1;
                    $xmes_id      = (int)date('m');
                    $xproceso_id  =         3;
                    $xfuncion_id  =      3001;
                    $xtrx_id      =        72;    //Alta
                    $regbitacora = regBitacoraModel::select('PERIODO_ID','MES_ID','PROCESO_ID','FUNCION_ID', 
                                                    'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 
                                                    'FECHA_M', 'IP_M', 'LOGIN_M')
                               ->where(['PERIODO_ID' => $xperiodo_id, 'MES_ID' => $xmes_id,
                                        'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 
                                        'TRX_ID' => $xtrx_id,'FOLIO' => $request->prog_id])
                               ->get();
                    if($regbitacora->count() <= 0){              // Alta
                        $nuevoregBitacora = new regBitacoraModel();              
                        $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                        $nuevoregBitacora->PROGRAMA_ID= $xprograma_id;   // Proyecto JAPEM 
                        $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                        $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                        $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                        $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                        $nuevoregBitacora->FOLIO      = $request->prog_id;          // Folio    
                        $nuevoregBitacora->NO_VECES   = 1;               // Numero de veces            
                        $nuevoregBitacora->IP         = $ip;          // Folio
                        $nuevoregBitacora->LOGIN      = $nombre;         // Usuario 
                        $nuevoregBitacora->save();
                        if($nuevoregBitacora->save() == true)
                            toastr()->success('Directorio dado de alta en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                        else
                            toastr()->error('Error en directorio. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
                    }else{                   
                        //*********** Obtine el no. de veces *****************************
                        $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id,'MES_ID'     => $xmes_id, 
                                                              'PROCESO_ID' => $xproceso_id,'FUNCION_ID' => $xfuncion_id, 
                                                              'TRX_ID'     => $xtrx_id,    'FOLIO'      => $request->prog_id])
                                     ->max('NO_VECES');
                        $xno_veces = $xno_veces+1;                        
                        //*********** Termina de obtener el no de veces *****************************         
                        $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                                   ->where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id, 
                                            'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO'      => $request->prog_id])
                                   ->update([
                                         'NO_VECES'=> $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'    => $regbitacora->IP       = $ip,
                                         'LOGIN_M' => $regbitacora->LOGIN_M  = $nombre,
                                         'FECHA_M' => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                       ]);
                        toastr()->success('directorio actualizado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                    }   /************ Bitacora termina *************************************/ 
            }else{
                toastr()->error('Error en directorio. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }   /**************** Termina de dar de alta ********************************/           
        }       /**************** Termina de validar duplicidad triada *****************/
        return redirect()->route('verdirectorio');
    }

    
    public function actionEditarDirectorio($id, $id2){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $codigo       = session()->get('codigo');   

        $regperiodos  = regPeriodosModel::select('PERIODO_ID', 'PERIODO_DESC')
                        ->get();                
        //********* Validar rol de usuario **********************/
        if(session()->get('rango') !== '0'){                          
            $regprogramas=regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->orderBy('PROG_ID','asc')
                          ->get();                           
        }else{
            $regprogramas=regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->where('PROG_ID',$codigo)
                          ->get();                   
        }                        
        $regdirectorio = regDirectorioModel::select('PERIODO_ID','PROG_ID',
                           'DIR_NOMBRE_1','DIR_CARGO_1','DIR_EMAIL_1','DIR_TEL_1',
                           'DIR_NOMBRE_2','DIR_CARGO_2','DIR_EMAIL_2','DIR_TEL_2',
                           'DIR_NOMBRE_3','DIR_CARGO_3','DIR_EMAIL_3','DIR_TEL_3',
                           'DIR_NOMBRE_4','DIR_CARGO_4','DIR_EMAIL_4','DIR_TEL_4',
                           'DIR_NOMBRE_5','DIR_CARGO_5','DIR_EMAIL_5','DIR_TEL_5',
                           'DIR_OBS_1','DIR_OBS_2','DIR_STATUS1','DIR_STATUS2',
                           'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                         ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2])
                         ->first();
        if($regdirectorio->count() <= 0){
            toastr()->error('No existe directorio.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.directorio.editarDirectorio',compact('nombre','usuario','regprogramas','regperiodos','regdirectorio'));

    }

    public function actionActualizarDirectorio(directorioRequest $request, $id, $id2){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $codigo       = session()->get('codigo');   

        // **************** actualizar ******************************
        $regdirectorio = regDirectorioModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2]);
        if($regdirectorio->count() <= 0)
            toastr()->error('No existe directorio.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            //*************** Actualizar ********************************/
            $regdirectorio = regDirectorioModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2])
                             ->update([     
                                       'DIR_NOMBRE_1' => substr(strtoupper(trim($request->dir_nombre_1)) ,0,149),
                                       'DIR_CARGO_1'  => substr(strtoupper(trim($request->dir_cargo_1))  ,0, 99),
                                       'DIR_TEL_1'    => substr(strtoupper(trim($request->dir_tel_1))    ,0, 99),
                                       'DIR_EMAIL_1'  => substr(strtolower(trim($request->dir_email_1))  ,0, 99),

                                       'DIR_NOMBRE_2' => substr(strtoupper(trim($request->dir_nombre_2)) ,0,149),
                                       'DIR_CARGO_2'  => substr(strtoupper(trim($request->dir_cargo_2))  ,0, 99),
                                       'DIR_TEL_2'    => substr(strtoupper(trim($request->dir_tel_2))    ,0, 99),
                                       'DIR_EMAIL_2'  => substr(strtolower(trim($request->dir_email_2))  ,0, 99),

                                       'DIR_NOMBRE_3' => substr(strtoupper(trim($request->dir_nombre_3)) ,0,149),
                                       'DIR_CARGO_3'  => substr(strtoupper(trim($request->dir_cargo_3))  ,0, 99),
                                       'DIR_TEL_3'    => substr(strtoupper(trim($request->dir_tel_3))    ,0, 99),
                                       'DIR_EMAIL_3'  => substr(strtolower(trim($request->dir_email_3))  ,0, 99),                                

                                       'DIR_NOMBRE_4' => substr(strtoupper(trim($request->dir_nombre_4)) ,0,149),
                                       'DIR_CARGO_4'  => substr(strtoupper(trim($request->dir_cargo_4))  ,0, 99),
                                       'DIR_TEL_4'    => substr(strtoupper(trim($request->dir_tel_4))    ,0, 99),
                                       'DIR_EMAIL_4'  => substr(strtolower(trim($request->dir_email_4))  ,0, 99),

                                       'IP_M'         => $ip,
                                       'LOGIN_M'      => $nombre,
                                       'FECHA_M2'     => date('Y/m/d'),    //date('d/m/Y')                    
                                       'FECHA_M'      => date('Y/m/d')    //date('d/m/Y')                                
                                     ]);
            toastr()->success('Directorio actualizado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =        73;    //Actualizar         
            $regbitacora = regBitacoraModel::select('PERIODO_ID',  'MES_ID', 'PROCESO_ID', 
                                                    'FUNCION_ID', 'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 
                                                    'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 
                                    'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                    'FOLIO' => $id2])
                           ->get();
            if($regbitacora->count() <= 0){              // Alta
                $nuevoregBitacora = new regBitacoraModel();              
                $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                $nuevoregBitacora->PROGRAMA_ID= $xprograma_id;   // Proyecto JAPEM 
                $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                $nuevoregBitacora->FOLIO      = $id2;             // Folio    
                $nuevoregBitacora->NO_VECES   = 1;               // Numero de veces            
                $nuevoregBitacora->IP         = $ip;             // IP
                $nuevoregBitacora->LOGIN      = $nombre;         // Usuario 

                $nuevoregBitacora->save();
                if($nuevoregBitacora->save() == true)
                    toastr()->success('Directorio actulizado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error al actualizar directorio en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id,'MES_ID'     => $xmes_id,
                                                      'PROCESO_ID' => $xproceso_id,'FUNCION_ID' => $xfuncion_id, 
                                                       'TRX_ID'    => $xtrx_id,    'FOLIO'      => $id2])
                             ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id, 
                                        'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO'      => $id2])
                               ->update([
                                         'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'     => $regbitacora->IP       = $ip,
                                         'LOGIN_M'  => $regbitacora->LOGIN_M  = $nombre,
                                         'FECHA_M'  => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('Trx de directorio actulizada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                     
        }       /************ Actualizar *******************************************/
        return redirect()->route('verdirectorio');
    }


    public function actionBorrarDirectorio($id,$id2){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $codigo       = session()->get('codigo');   

        /************ Elimina la IAP **************************************/
        $regdirectorio = regDirectorioModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2]);
        if($regdirectorio->count() <= 0)
            toastr()->error('No existe directorio.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            $regdirectorio->delete();
            toastr()->success('directorio eliminado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            //echo 'Ya entre a borrar registro..........';
            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =        74;     // Baja 
            $regbitacora = regBitacoraModel::select('PERIODO_ID',  'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
                           'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id, 
                                    'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO'      => $id2])
                           ->get();
            if($regbitacora->count() <= 0){              // Alta
                $nuevoregBitacora = new regBitacoraModel();              
                $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                $nuevoregBitacora->PROGRAMA_ID= $xprograma_id;   // Proyecto JAPEM 
                $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                $nuevoregBitacora->FOLIO      = $id2;             // Folio    
                $nuevoregBitacora->NO_VECES   = 1;               // Numero de veces            
                $nuevoregBitacora->IP         = $ip;             // IP
                $nuevoregBitacora->LOGIN      = $nombre;         // Usuario 

                $nuevoregBitacora->save();
                if($nuevoregBitacora->save() == true)
                    toastr()->success('Trx de eliminar directorio dada de alta en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error en trx de eliminar directorio. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id,'MES_ID'     => $xmes_id, 
                                                      'PROCESO_ID' => $xproceso_id,'FUNCION_ID' => $xfuncion_id, 
                                                      'TRX_ID'     => $xtrx_id,    'FOLIO' => $id2])
                        ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id,
                                        'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO'      => $id2])
                               ->update([
                                         'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'     => $regbitacora->IP       = $ip,
                                         'LOGIN_M'  => $regbitacora->LOGIN_M  = $nombre,
                                         'FECHA_M'  => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('trx de eliminar directorio actualizada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                 
        }       /************* Termina de eliminar *********************************/
        return redirect()->route('verdirectorio');
    }    

    // exportar a formato excel
    public function actionExportPadronExcel(){
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
        $xtrx_id      =        75;            // Exportar a formato Excel
        $id           =         0;
        $regbitacora = regBitacoraModel::select('PERIODO_ID',  'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
                                                'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 
                                                'IP_M', 'LOGIN_M')
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
                                     'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                     'IP_M' => $regbitacora->IP           = $ip,
                                     'LOGIN_M' => $regbitacora->LOGIN_M   = $nombre,
                                     'FECHA_M' => $regbitacora->FECHA_M   = date('Y/m/d')  //date('d/m/Y')
                                    ]);
            toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
        }   /************ Bitacora termina *************************************/  

        return Excel::download(new ExportPadronExcel, 'Padron_'.date('d-m-Y').'.xlsx');
    }

    // exportar a formato PDF
    public function actionExportPadronPdf(){
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
        $codigo       = session()->get('codigo');   

        /************ Bitacora inicia *************************************/ 
        setlocale(LC_TIME, "spanish");        
        $xip          = session()->get('ip');
        $xperiodo_id  = (int)date('Y');
        $xprograma_id = 1;
        $xmes_id      = (int)date('m');
        $xproceso_id  =         3;
        $xfuncion_id  =      3001;
        $xtrx_id      =        76;       //Exportar a formato PDF
        $id           =         0;
        $regbitacora = regBitacoraModel::select('PERIODO_ID',  'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
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
               toastr()->success('Bitacora dada de alta correctamente.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            else
               toastr()->error('Error inesperado al dar de alta la bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
        }else{                   
            //*********** Obtine el no. de veces *****************************
            $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                         'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 
                         'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
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
            toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
        }   /************ Bitacora termina *************************************/ 

        $regentidades = regEntidadesModel::select('ENTIDADFEDERATIVA_ID','ENTIDADFEDERATIVA_DESC')     
                                           ->get();
        $regmunicipio = regMunicipioModel::select('ENTIDADFEDERATIVAID', 'MUNICIPIOID', 'MUNICIPIONOMBRE')
                                           ->wherein('ENTIDADFEDERATIVAID',[9, 11, 15, 22])
                                           ->get(); 
        $regperiodos  = regPeriodosaniosModel::select('PERIODO_ID','PERIODO_DESC')
                        ->get();  
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')->get();      
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')->get();                          
        $regservicios = regServicioModel::join('PE_CAT_RUBROS','PE_CAT_RUBROS.RUBRO_ID', '=', 
                                                               'PE_CAT_SERVICIOS.RUBRO_ID')
                        ->select('PE_CAT_SERVICIOS.SERVICIO_ID','PE_CAT_SERVICIOS.SERVICIO_DESC',
                                 'PE_CAT_RUBROS.RUBRO_DESC')
                        ->orderBy('PE_CAT_SERVICIOS.SERVICIO_DESC','ASC')
                        ->orderBy('PE_CAT_RUBROS.RUBRO_DESC','ASC')
                        ->get();                                                                                    
        $regosc       = regOscModel::select('OSC_ID', 'OSC_DESC','OSC_STATUS')
                        ->get();                                                        
        $regdirectorio    = regDirectorioModel::select('PERIODO_ID','FOLIO','OSC_ID','PRIMER_APELLIDO',
                        'SEGUNDO_APELLIDO','NOMBRES','NOMBRE_COMPLETO','CURP','FECHA_NACIMIENTO',
                        'FECHA_NACIMIENTO2','SEXO',
                        'RFC','ID_OFICIAL','DOMICILIO','COLONIA','CP','ENTRE_CALLE','Y_CALLE','OTRA_REFERENCIA',
                        'TELEFONO','CELULAR','E_MAIL','ENTIDAD_NAC_ID','ENTIDAD_FED_ID','MUNICIPIO_ID',
                        'LOCALIDAD_ID','LOCALIDAD','EDO_CIVIL_ID','GRADO_ESTUDIOS_ID','FECHA_INGRESO','FECHA_INGRESO2',
                        'MOTIVO_ING','INTEG_FAM','SERVICIO_ID','CUOTA_RECUP','QUIEN_CANALIZO',
                        'PERIODO_ID1','MES_ID1','DIA_ID1','PERIODO_ID2','MES_ID2','DIA_ID2',
                        'STATUS_1','STATUS_2','FECHA_REG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                        ->orderBy('PERIODO_ID','asc')
                        ->orderBy('OSC_ID','asc')
                        ->get();                               
        if($regdirectorio->count() <= 0){
            toastr()->error('No existen beneficiarios.','Uppss!',['positionClass' => 'toast-bottom-right']);
            return redirect()->route('verPadron');
        }
        $pdf = PDF::loadView('sicinar.pdf.padronPdf', compact('nombre','usuario','regentidades','regmunicipio','regosc','regperiodos','regdirectorio','regservicios','regmeses','regdias'));
        //$options = new Options();
        //$options->set('defaultFont', 'Courier');
        //$pdf->set_option('defaultFont', 'Courier');
        $pdf->setPaper('A4', 'landscape');      
        //$pdf->set('defaultFont', 'Courier');          
        //$pdf->setPaper('A4','portrait');

        // Output the generated PDF to Browser
        return $pdf->stream('PadronBeneficiarios');
    }


}
