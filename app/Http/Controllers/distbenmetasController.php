<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\distbenemetasRequest;

use App\regPeriodosModel;
use App\regProgramasModel;
use App\regBitacoraModel;
use App\regDistbeneModel;

// Exportar a excel 
//use App\Exports\ExcelExportProg;
use Maatwebsite\Excel\Facades\Excel;
// Exportar a pdf
use PDF;
//use Options;

class distbenmetasController extends Controller
{

    public function actionBuscarDistbenemetas(Request $request)
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
        //**************************************************************//
        // ***** busqueda https://github.com/rimorsoft/Search-simple ***//
        // ***** video https://www.youtube.com/watch?v=bmtD9GUaszw   ***//                            
        //**************************************************************//
        $name  = $request->get('name');    
        //$email = $request->get('email');  
        //$bio   = $request->get('bio');      
        if(session()->get('rango') !== '0'){            
            $regdistbene = regDistbeneModel::orderBy('PROG_ID', 'ASC')
                       ->name($name)           //Metodos personalizados es equvalente a ->where('IAP_DESC', 'LIKE', "%$name%");
                       //->email($email)         //Metodos personalizados
                       //->bio($bio)             //Metodos personalizados
                       ->paginate(50);
        }else{           
            $regdistbene = regDistbeneModel::where('PROG_ID',$codigo)
                       ->orderBy('PROG_ID', 'ASC')
                       ->name($name)           //Metodos personalizados es equvalente a ->where('IAP_DESC', 'LIKE', "%$name%");
                       //->email($email)         //Metodos personalizados
                       //->bio($bio)             //Metodos personalizados
                       ->paginate(50);          
        }
        if($regdistbene->count() <= 0){
            toastr()->error('No existen distribución de beneficios','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }            
        return view('sicinar.distribucion_beneficios.verDistbenmetas', compact('nombre','usuario','codigo','regprogramas','regperiodos','regdistbene'));
    }

    public function actionVerDistbenemetas(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $codigo       = session()->get('codigo');         

        if(session()->get('rango') !== '0'){                                                       
            $regdistbene=regDistbeneModel::join('CP_CAT_PROGRAMAS','CP_CAT_PROGRAMAS.PROG_ID', '=', 
                                                                   'CP_DISTRIB_BENEFICIOS.PROG_ID')
                          ->select('CP_DISTRIB_BENEFICIOS.PERIODO_ID',
                                   'CP_DISTRIB_BENEFICIOS.PROG_ID',
                                   'CP_CAT_PROGRAMAS.PROG_DESC',
                                   'CP_DISTRIB_BENEFICIOS.BENE_META',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M01', 
                                   'CP_DISTRIB_BENEFICIOS.BENE_M02',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M03',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M04',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M05',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M06', 
                                   'CP_DISTRIB_BENEFICIOS.BENE_M07',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M08',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M09',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M10', 
                                   'CP_DISTRIB_BENEFICIOS.BENE_M11',                              
                                   'CP_DISTRIB_BENEFICIOS.BENE_M12'
                                   )
                          ->orderBy('CP_DISTRIB_BENEFICIOS.PERIODO_ID','DESC')
                          ->orderBy('CP_DISTRIB_BENEFICIOS.PROG_ID'   ,'DESC')
                          ->paginate(50);
        }else{            
            $regdistbene=regDistbeneModel::join('CP_CAT_PROGRAMAS','CP_CAT_PROGRAMAS.PROG_ID', '=', 
                                                                     'CP_DISTRIB_BENEFICIOS.PROG_ID')
                          ->select('CP_DISTRIB_BENEFICIOS.PERIODO_ID',
                                   'CP_DISTRIB_BENEFICIOS.PROG_ID',
                                   'CP_CAT_PROGRAMAS.PROG_DESC',
                                   'CP_DISTRIB_BENEFICIOS.BENE_META',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M01', 
                                   'CP_DISTRIB_BENEFICIOS.BENE_M02',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M03',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M04',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M05',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M06', 
                                   'CP_DISTRIB_BENEFICIOS.BENE_M07',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M08',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M09',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M10', 
                                   'CP_DISTRIB_BENEFICIOS.BENE_M11',                              
                                   'CP_DISTRIB_BENEFICIOS.BENE_M12'
                                  )
                          ->where(  'CP_DISTRIB_BENEFICIOS.PROG_ID'   ,$codigo)                              
                          ->orderBy('CP_DISTRIB_BENEFICIOS.PERIODO_ID','DESC')
                          ->orderBy('CP_DISTRIB_BENEFICIOS.PROG_ID'   ,'DESC')
                          ->paginate(50);
        }                         
        if($regdistbene->count() <= 0){
            toastr()->error('No existen distribución de beneficios','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }          
        return view('sicinar.distrib_beneficios.verDistbenmetas',compact('nombre','usuario','codigo','regprogramas','regdistbene'));
    }

    public function actionNuevoDistbenemetas(){
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
                        ->orderBy('PERIODO_ID','asc')
                        ->get();  
        if(session()->get('rango') !== '0'){                              
            $regprogramas=regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->orderBy('PROG_ID','asc')
                          ->get();                                    
            $regdistbene =regDistbeneModel::select('PERIODO_ID','PROG_ID','BENE_META',
                          'BENE_M01','BENE_M02','BENE_M03','BENE_M04','BENE_M05','BENE_M06',
                          'BENE_M07','BENE_M08','BENE_M09','BENE_M10','BENE_M11','BENE_M12',
                          'BENE_MT01','BENE_MT02','BENE_MT03','BENE_MT04','BENE_MS01','BENE_MS02','BENE_MA01')
                          ->orderBy('PERIODO_ID','asc')
                          ->orderBy('PROG_ID'   ,'asc')
                          ->get();
        }else{ 
            $regprogramas=regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->where('PROG_ID',$codigo) 
                          ->get();                                    
            $regdistbene =regDistbeneModel::select('PERIODO_ID','PROG_ID','BENE_META',
                          'BENE_M01','BENE_M02','BENE_M03','BENE_M04','BENE_M05','BENE_M06',
                          'BENE_M07','BENE_M08','BENE_M09','BENE_M10','BENE_M11','BENE_M12',
                          'BENE_MT01','BENE_MT02','BENE_MT03','BENE_MT04','BENE_MS01','BENE_MS02','BENE_MA01')
                          ->where(  'PROG_ID'   ,$codigo) 
                          ->orderBy('PERIODO_ID','asc')
                          ->orderBy('PROG_ID'   ,'asc')
                          ->get();          
        }
        //dd($unidades);
        return view('sicinar.distrib_beneficios.nuevoDistbenmetas',compact('nombre','usuario','codigo','regprogramas','regperiodos','regdistbene'));
    }

    public function actionAltaNuevoDistbenemetas(Request $request){
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

        // **************** validar duplicados ******************************
        $regdistbene = regDistbeneModel::where(['PERIODO_ID' => $request->periodo_id,'PROG_ID' => $request->prog_id]);
        if($regdistbene->count() > 0)
            toastr()->error('Ya existe distribución de beneficios.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{   
            //*********** Calculamos valores ************************//
            $bene_m01 = 0;
            if(isset($request->bene_m01)){
                if(!empty($request->bene_m01)) 
                    $bene_m01 = (float)$request->bene_m01;
            }          
            $bene_m02 = 0;
            if(isset($request->bene_m02)){
                if(!empty($request->bene_m02)) 
                    $bene_m02 = (float)$request->bene_m02;
            }  
            $bene_m03 = 0;
            if(isset($request->bene_m03)){
                if(!empty($request->bene_m03)) 
                    $bene_m03 = (float)$request->bene_m03;
            }  
            $bene_m04 = 0;
            if(isset($request->bene_m04)){
                if(!empty($request->bene_m04)) 
                    $bene_m04 = (float)$request->bene_m04;
            }  
            $bene_m05 = 0;
            if(isset($request->bene_m05)){
                if(!empty($request->bene_m05)) 
                    $bene_m05 = (float)$request->bene_m05;
            }                                                  
            $bene_m06 = 0;
            if(isset($request->bene_m06)){
                if(!empty($request->bene_m06)) 
                    $bene_m06 = (float)$request->bene_m06;
            }               
            $bene_m07 = 0;
            if(isset($request->bene_m07)){
                if(!empty($request->bene_m07)) 
                    $bene_m07 = (float)$request->bene_m07;
            }          
            $bene_m08 = 0;
            if(isset($request->bene_m08)){
                if(!empty($request->bene_m08)) 
                    $bene_m08 = (float)$request->bene_m08;
            }  
            $bene_m09 = 0;
            if(isset($request->bene_m09)){
                if(!empty($request->bene_m09)) 
                    $bene_m09 = (float)$request->bene_m09;
            }  
            $bene_m10 = 0;
            if(isset($request->bene_m10)){
                if(!empty($request->bene_m10)) 
                    $bene_m10 = (float)$request->bene_m10;
            }  
            $bene_m11 = 0;
            if(isset($request->bene_m11)){
                if(!empty($request->bene_m11)) 
                    $bene_m11 = (float)$request->bene_m11;
            }                                                  
            $bene_m12 = 0;
            if(isset($request->bene_m12)){
                if(!empty($request->bene_m12)) 
                    $bene_m12 = (float)$request->bene_m12;
            }                           
            $bene_mt01 = (float)$bene_m01 + (float)$bene_m02 + (float)$bene_m03;
            $bene_mt02 = (float)$bene_m04 + (float)$bene_m05 + (float)$bene_m06;
            $bene_mt03 = (float)$bene_m07 + (float)$bene_m08 + (float)$bene_m09;
            $bene_mt04 = (float)$bene_m10 + (float)$bene_m11 + (float)$bene_m12;

            $bene_ms01 =(float)$bene_mt01+(float)$bene_mt02;
            $bene_ms02 =(float)$bene_mt03+(float)$bene_mt04;            

            $bene_ma01  = (float)$bene_ms01 + (float)$bene_ms02;             
 
            /********************** Alta  *****************************/ 
            //$iid = regDistbeneModel::count(*);
            //$iid = $iid + 1;
            $nuevaiap = new regDistbeneModel();
            $name1 =null;
            //Comprobar  si el campo foto1 tiene un archivo asignado:
            if($request->hasFile('osc_foto1')){
               $name1 = $osc_id.'_'.$request->file('osc_foto1')->getClientOriginalName(); 
               $request->file('osc_foto1')->move(public_path().'/images/', $name1);
            }
 
            $nuevaiap->PERIODO_ID      = $request->periodo_id;
            $nuevaiap->PROG_ID         = $request->prog_id;
            $nuevaiap->BENE_META      = $request->bene_meta;
            $nuevaiap->BENE_M01       = $bene_m01;
            $nuevaiap->BENE_M02       = $bene_m02;
            $nuevaiap->BENE_M03       = $bene_m03;
            $nuevaiap->BENE_M04       = $bene_m04;
            $nuevaiap->BENE_M05       = $bene_m05;
            $nuevaiap->BENE_M06       = $bene_m06;
            $nuevaiap->BENE_M07       = $bene_m07;
            $nuevaiap->BENE_M08       = $bene_m08;
            $nuevaiap->BENE_M09       = $bene_m09;
            $nuevaiap->BENE_M10       = $bene_m10;
            $nuevaiap->BENE_M11       = $bene_m11;
            $nuevaiap->BENE_M12       = $bene_m12;

            $nuevaiap->BENE_MT01      = $bene_mt01;
            $nuevaiap->BENE_MT02      = $bene_mt02;
            $nuevaiap->BENE_MT03      = $bene_mt03;
            $nuevaiap->BENE_MT04      = $bene_mt04;
            $nuevaiap->BENE_MS01      = $bene_ms01;
            $nuevaiap->BENE_MS02      = $bene_ms02;
            $nuevaiap->BENE_MA01      = $bene_ma01;

            $nuevaiap->IP              = $ip;
            $nuevaiap->LOGIN           = $nombre;         // Usuario ;
            //dd($nuevaiap);
            $nuevaiap->save();
            if($nuevaiap->save() == true){
                toastr()->success('distribución de beneficios dada de alta.','ok!',['positionClass' => 'toast-bottom-right']);

                /************ Bitacora inicia *************************************/ 
                setlocale(LC_TIME, "spanish");        
                $xip          = session()->get('ip');
                $xperiodo_id  = (int)date('Y');
                $xprograma_id = 1;
                $xmes_id      = (int)date('m');
                $xproceso_id  =         3;
                $xfuncion_id  =      3001;
                $xtrx_id      =        37;    //Alta
                $regbitacora=regBitacoraModel::select('PERIODO_ID', 'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
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
                        toastr()->success('Trx de distribución de beneficios dada de alta en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                    else
                        toastr()->error('Error de trx de distribución de beneficios en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
                }else{                   
                    //*********** Obtine el no. de veces *****************************
                    $xno_veces=regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id,'MES_ID'     => $xmes_id, 
                                                        'PROCESO_ID' => $xproceso_id,'FUNCION_ID' => $xfuncion_id, 
                                                        'TRX_ID'     => $xtrx_id,    'FOLIO'      => $request->prog_id])
                               ->max('NO_VECES');
                    $xno_veces = $xno_veces+1;                        
                    //*********** Termina de obtener el no de veces *****************************         
                    $regbitacora=regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                                 ->where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id,'PROCESO_ID'=> $xproceso_id, 
                                          'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO'     => $request->prog_id])
                                 ->update([
                                           'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                           'IP_M'     => $regbitacora->IP       = $ip,
                                           'LOGIN_M'  => $regbitacora->LOGIN_M  = $nombre,
                                           'FECHA_M'  => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                          ]);
                    toastr()->success('Trx de distribución de beneficios actualizado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                }   /************ Bitacora termina *************************************/ 
            }else{
                toastr()->error('Error de trx de distribución de beneficios. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }
        }
        return redirect()->route('verdistbenemetas');
    }

    public function actionEditarDistbenemetas($id, $id2){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        } 
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');
        $codigo        = session()->get('codigo');         

        $regperiodos  = regPeriodosModel::select('PERIODO_ID', 'PERIODO_DESC')
                        ->orderBy('PERIODO_ID','asc')
                        ->get();  
        $regprogramas = regProgramasModel::select('PROG_ID','PROG_DESC')
                        ->orderBy('PROG_ID','asc')
                        ->get();                                 
        $regdistbene     = regDistbeneModel::select('PERIODO_ID','PROG_ID','BENE_META',
                        'BENE_M01','BENE_M02','BENE_M03','BENE_M04','BENE_M05','BENE_M06',
                        'BENE_M07','BENE_M08','BENE_M09','BENE_M10','BENE_M11','BENE_M12',
                        'BENE_MT01','BENE_MT02','BENE_MT03','BENE_MT04','BENE_MS01','BENE_MS02','BENE_MA01')
                         ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2])
                         ->first();
        //dd($id,'segundo.....'.$id2, $regdistbene->count() );
        if($regdistbene->count() <= 0){
            toastr()->error('No existe distribución de beneficios.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.distrib_beneficios.editarDistbenmetas',compact('nombre','usuario','codigo','regprogramas','regperiodos','regdistbene'));
    }

    public function actionActualizarDistbenemetas(distbenemetasRequest $request, $id, $id2){
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
        $regdistbene = regDistbeneModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2]);
        //dd('hola.....',$regdistbene);
        if($regdistbene->count() <= 0)
            toastr()->error('No existe distribución de beneficios.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            //*********** Calculamos valores ************************
            $bene_m01 = 0;
            if(isset($request->bene_m01)){
                if(!empty($request->bene_m01)) 
                    $bene_m01 = (float)$request->bene_m01;
            }          
            $bene_m02 = 0;
            if(isset($request->bene_m02)){
                if(!empty($request->bene_m02)) 
                    $bene_m02 = (float)$request->bene_m02;
            }  
            $bene_m03 = 0;
            if(isset($request->bene_m03)){
                if(!empty($request->bene_m03)) 
                    $bene_m03 = (float)$request->bene_m03;
            }  
            $bene_m04 = 0;
            if(isset($request->bene_m04)){
                if(!empty($request->bene_m04)) 
                    $bene_m04 = (float)$request->bene_m04;
            }  
            $bene_m05 = 0;
            if(isset($request->bene_m05)){
                if(!empty($request->bene_m05)) 
                    $bene_m05 = (float)$request->bene_m05;
            }                                                  
            $bene_m06 = 0;
            if(isset($request->bene_m06)){
                if(!empty($request->bene_m06)) 
                    $bene_m06 = (float)$request->bene_m06;
            }               
            $bene_m07 = 0;
            if(isset($request->bene_m07)){
                if(!empty($request->bene_m07)) 
                    $bene_m07 = (float)$request->bene_m07;
            }          
            $bene_m08 = 0;
            if(isset($request->bene_m08)){
                if(!empty($request->bene_m08)) 
                    $bene_m08 = (float)$request->bene_m08;
            }  
            $bene_m09 = 0;
            if(isset($request->bene_m09)){
                if(!empty($request->bene_m09)) 
                    $bene_m09 = (float)$request->bene_m09;
            }  
            $bene_m10 = 0;
            if(isset($request->bene_m10)){
                if(!empty($request->bene_m10)) 
                    $bene_m10 = (float)$request->bene_m10;
            }  
            $bene_m11 = 0;
            if(isset($request->bene_m11)){
                if(!empty($request->bene_m11)) 
                    $bene_m11 = (float)$request->bene_m11;
            }                                                  
            $bene_m12 = 0;
            if(isset($request->bene_m12)){
                if(!empty($request->bene_m12)) 
                    $bene_m12 = (float)$request->bene_m12;
            }                           
            $bene_mt01 = (float)$bene_m01 + (float)$bene_m02 + (float)$bene_m03;
            $bene_mt02 = (float)$bene_m04 + (float)$bene_m05 + (float)$bene_m06;
            $bene_mt03 = (float)$bene_m07 + (float)$bene_m08 + (float)$bene_m09;
            $bene_mt04 = (float)$bene_m10 + (float)$bene_m11 + (float)$bene_m12;

            $bene_ms01 =(float)$bene_mt01+(float)$bene_mt02;
            $bene_ms02 =(float)$bene_mt03+(float)$bene_mt04;            

            $bene_ma01  = (float)$bene_ms01 + (float)$bene_ms02;             
            //*********** Actualizarn items **********************
            $regdistbene = regDistbeneModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2])
                               ->update([                
                                         'BENE_META'    => $request->bene_meta,
                                         'BENE_M01'     => $bene_m01,
                                         'BENE_M02'     => $bene_m02,
                                         'BENE_M03'     => $bene_m03,
                                         'BENE_M04'     => $bene_m04,
                                         'BENE_M05'     => $bene_m05,
                                         'BENE_M06'     => $bene_m06,
                                         'BENE_M07'     => $bene_m07,
                                         'BENE_M08'     => $bene_m08,
                                         'BENE_M09'     => $bene_m09,
                                         'BENE_M10'     => $bene_m10,
                                         'BENE_M11'     => $bene_m11,
                                         'BENE_M12'     => $bene_m12,   

                                         'BENE_MT01'    => $bene_mt01,
                                         'BENE_MT02'    => $bene_mt02,
                                         'BENE_MT03'    => $bene_mt03,
                                         'BENE_MT04'    => $bene_mt04,
                                         'BENE_MS01'    => $bene_ms01,
                                         'BENE_MS02'    => $bene_ms02,
                                         'BENE_MA01'    => $bene_ma01,

                                         'IP_M'          => $ip,
                                         'LOGIN_M'       => $nombre,
                                         'FECHA_M2'      => date('Y/m/d'),   //date('d/m/Y')            
                                         'FECHA_M'       => date('Y/m/d')    //date('d/m/Y')   
                              ]);
            toastr()->success('distribución de beneficios actualizado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =        38;    //Actualizar 
            $regbitacora = regBitacoraModel::select('PERIODO_ID','MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
                                                    'TRX_ID',    'FOLIO',  'NO_VECES',   'FECHA_REG', 'IP', 
                                                    'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id,'PROGRAMA_ID' => $xprograma_id,'MES_ID' => $xmes_id, 
                                    'PROCESO_ID' => $xproceso_id,'FUNCION_ID'  => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                    'FOLIO'      => $id2])
                           ->get();
            if($regbitacora->count() <= 0){              // Alta
                $nuevoregBitacora = new regBitacoraModel();              
                $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
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
                    toastr()->success('Trx de actualización de distribución de beneficios registrado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error Trx de distribución de beneficios  actualizado en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id,'MES_ID'     => $xmes_id, 
                                                      'PROCESO_ID' => $xproceso_id,'FUNCION_ID' => $xfuncion_id, 
                                                      'TRX_ID'     => $xtrx_id,    'FOLIO'      => $id2])
                             ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 
                                        'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id, 'FOLIO'      => $id2])
                               ->update([
                                         'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'     => $regbitacora->IP       = $ip,
                                         'LOGIN_M'  => $regbitacora->LOGIN_M  = $nombre,
                                         'FECHA_M'  => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('Trx de actualización de distribución de beneficios registrado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                     
        }       /************ Actualizar *******************************************/
        return redirect()->route('verdistbenemetas');
    }

    public function actionBorrarDistbenemetas($id, $id2){
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
        $regdistbene = regDistbeneModel::select('PERIODO_ID','PROG_ID','BENE_META',
                        'BENE_M01','BENE_M02','BENE_M03','BENE_M04','BENE_M05','BENE_M06',
                        'BENE_M07','BENE_M08','BENE_M09','BENE_M10','BENE_M11','BENE_M12',
                        'BENE_MT01','BENE_MT02','BENE_MT03','BENE_MT04','BENE_MS01','BENE_MS02','BENE_MA01')
                         ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2]);
        if($regdistbene->count() <= 0)
            toastr()->error('No existe distribución de beneficios.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            $regdistbene->delete();
            toastr()->success('distribución de beneficios eliminado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            //echo 'Ya entre a borrar registro..........';
            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =        39;     // Baja 

            $regbitacora = regBitacoraModel::select('PERIODO_ID','MES_ID', 'PROCESO_ID', 'FUNCION_ID', 'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id, 
                                    'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO'      => $id2])
                           ->get();
            if($regbitacora->count() <= 0){              // Alta
                $nuevoregBitacora = new regBitacoraModel();              
                $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
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
                    toastr()->success('Trx de baja de distribución de beneficios registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error en Trx de baja de distribución de beneficios en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID'=>$xperiodo_id,'MES_ID'=>$xmes_id,'PROCESO_ID'=>$xproceso_id, 
                                                      'FUNCION_ID'=>$xfuncion_id,'TRX_ID'=>$xtrx_id,'FOLIO' => $id2])
                        ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 
                                        'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id, 'FOLIO'      => $id2])
                               ->update([
                                         'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'     => $regbitacora->IP       = $ip,
                                         'LOGIN_M'  => $regbitacora->LOGIN_M  = $nombre,
                                         'FECHA_M'  => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('Trx de baja de distribución de beneficios registrado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                 
        }       /************* Termina de eliminar **********************************/
        return redirect()->route('verdistbenmetas');
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
        $xtrx_id      =        40;            // Exportar a formato Excel
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
        $xtrx_id      =        41;       //Exportar a formato PDF
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

        $regdistbene  = regDistbeneModel::select('PROG_ID','PROG_DESC','PROG_SIGLAS','PROG_VIGENTE', 
                                              'CLASIFICGOB_ID','PRIORIDAD_ID',
                                              'PROG_ORDEN','PROG_TIPO','PROG_SEPUBLICA','PROG_OBS1', 
                                              'PROG_OBS2','PROG_STATUS1','PROG_STATUS2','PROG_FECREG')
                                     ->orderBy('PROG_ID','ASC')
                                     ->get();                               
        if($regdistbene->count() <= 0){
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
