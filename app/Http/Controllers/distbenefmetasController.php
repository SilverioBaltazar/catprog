<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\distbenefmetasRequest;

use App\regPeriodosModel;
use App\regProgramasModel;
use App\regBitacoraModel;
use App\regDistbenefModel;

// Exportar a excel 
//use App\Exports\ExcelExportProg;
use Maatwebsite\Excel\Facades\Excel;
// Exportar a pdf
use PDF;
//use Options;

class distbenefmetasController extends Controller
{

    public function actionBuscarDistbenefmetas(Request $request)
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
            $regdistbenef = regDistbenefModel::orderBy('PROG_ID', 'ASC')
                       ->name($name)           //Metodos personalizados es equvalente a ->where('IAP_DESC', 'LIKE', "%$name%");
                       //->email($email)         //Metodos personalizados
                       //->bio($bio)             //Metodos personalizados
                       ->paginate(50);
        }else{           
            $regdistbenef = regDistbenefModel::where('PROG_ID',$codigo)
                       ->orderBy('PROG_ID', 'ASC')
                       ->name($name)           //Metodos personalizados es equvalente a ->where('IAP_DESC', 'LIKE', "%$name%");
                       //->email($email)         //Metodos personalizados
                       //->bio($bio)             //Metodos personalizados
                       ->paginate(50);          
        }
        if($regdistbenef->count() <= 0){
            toastr()->error('No existen distribución de beneficiarios','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }            
        return view('sicinar.distrib_beneficiarios.verDistbenefmetas', compact('nombre','usuario','codigo','regprogramas','regperiodos','regdistbenef'));
    }

    public function actionVerDistbenefmetas(){
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
            $regdistbenef=regDistbenefModel::join('CP_CAT_PROGRAMAS','CP_CAT_PROGRAMAS.PROG_ID', '=', 
                                                                     'CP_DISTRIB_BENEFICIARIOS.PROG_ID')
                          ->select('CP_DISTRIB_BENEFICIARIOS.PERIODO_ID',
                                   'CP_DISTRIB_BENEFICIARIOS.PROG_ID',
                                   'CP_CAT_PROGRAMAS.PROG_DESC',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_META',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_M01', 
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_M02',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_M03',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_M04',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_M05',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_M06', 
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_M07',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_M08',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_M09',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_M10', 
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_M11',                              
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_M12'
                                   )
                          ->orderBy('CP_DISTRIB_BENEFICIARIOS.PERIODO_ID','DESC')
                          ->orderBy('CP_DISTRIB_BENEFICIARIOS.PROG_ID'   ,'DESC')
                          ->paginate(50);
        }else{            
            $regdistbenef=regDistbenefModel::join('CP_CAT_PROGRAMAS','CP_CAT_PROGRAMAS.PROG_ID', '=', 
                                                                     'CP_DISTRIB_BENEFICIARIOS.PROG_ID')
                          ->select('CP_DISTRIB_BENEFICIARIOS.PERIODO_ID',
                                   'CP_DISTRIB_BENEFICIARIOS.PROG_ID',
                                   'CP_CAT_PROGRAMAS.PROG_DESC',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_META',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_M01', 
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_M02',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_M03',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_M04',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_M05',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_M06', 
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_M07',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_M08',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_M09',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_M10', 
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_M11',                              
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_M12'
                                  )
                          ->where(  'CP_DISTRIB_BENEFICIARIOS.PROG_ID'   ,$codigo)                              
                          ->orderBy('CP_DISTRIB_BENEFICIARIOS.PERIODO_ID','DESC')
                          ->orderBy('CP_DISTRIB_BENEFICIARIOS.PROG_ID'   ,'DESC')
                          ->paginate(50);
        }                         
        if($regdistbenef->count() <= 0){
            toastr()->error('No existen distribución de beneficiarios','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }          
        return view('sicinar.distrib_beneficiarios.verDistbenefmetas',compact('nombre','usuario','codigo','regdistbenef'));
    }

    public function actionNuevoDistbenefmetas(){
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
            $regprogramas = regProgramasModel::select('PROG_ID','PROG_DESC')
                            ->orderBy('PROG_ID','asc')
                            ->get();    
            $regdistbenef = regDistbenefModel::select('PERIODO_ID','PROG_ID','BENEF_META',
                            'BENEF_M01','BENEF_M02','BENEF_M03','BENEF_M04','BENEF_M05','BENEF_M06',
                            'BENEF_M07','BENEF_M08','BENEF_M09','BENEF_M10','BENEF_M11','BENEF_M12',
                            'BENEF_MT01','BENEF_MT02','BENEF_MT03','BENEF_MT04','BENEF_MS01','BENEF_MS02','BENEF_MA01')
                            ->orderBy('PERIODO_ID','asc')
                            ->orderBy('PROG_ID'   ,'asc')
                            ->get();          
        }else{            
            $regprogramas = regProgramasModel::select('PROG_ID','PROG_DESC')
                            ->where('PROG_ID',$codigo) 
                            ->get();    
            $regdistbenef = regDistbenefModel::select('PERIODO_ID','PROG_ID','BENEF_META',
                            'BENEF_M01','BENEF_M02','BENEF_M03','BENEF_M04','BENEF_M05','BENEF_M06',
                            'BENEF_M07','BENEF_M08','BENEF_M09','BENEF_M10','BENEF_M11','BENEF_M12',
                            'BENEF_MT01','BENEF_MT02','BENEF_MT03','BENEF_MT04','BENEF_MS01','BENEF_MS02','BENEF_MA01')
                            ->where(  'PROG_ID'   ,$codigo) 
                            ->orderBy('PERIODO_ID','asc')
                            ->orderBy('PROG_ID'   ,'asc')
                            ->get();
        }                   
        //dd($unidades);
        return view('sicinar.distrib_beneficiarios.nuevoDistbenefmetas',compact('nombre','usuario','codigo','regprogramas','regperiodos','regdistbenef'));
    }
 
    public function actionAltaNuevoDistbenefmetas(Request $request){
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
        $regdistbenef = regDistbenefModel::where(['PERIODO_ID' => $request->periodo_id,'PROG_ID' => $request->prog_id]);
        if($regdistbenef->count() > 0)
            toastr()->error('Ya existe distribución de beneficiarios.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{   
            //*********** Calculamos valores ************************//
            $benef_m01 = 0;
            if(isset($request->benef_m01)){
                if(!empty($request->benef_m01)) 
                    $benef_m01 = (float)$request->benef_m01;
            }          
            $benef_m02 = 0;
            if(isset($request->benef_m02)){
                if(!empty($request->benef_m02)) 
                    $benef_m02 = (float)$request->benef_m02;
            }  
            $benef_m03 = 0;
            if(isset($request->benef_m03)){
                if(!empty($request->benef_m03)) 
                    $benef_m03 = (float)$request->benef_m03;
            }  
            $benef_m04 = 0;
            if(isset($request->benef_m04)){
                if(!empty($request->benef_m04)) 
                    $benef_m04 = (float)$request->benef_m04;
            }  
            $benef_m05 = 0;
            if(isset($request->benef_m05)){
                if(!empty($request->benef_m05)) 
                    $benef_m05 = (float)$request->benef_m05;
            }                                                  
            $benef_m06 = 0;
            if(isset($request->benef_m06)){
                if(!empty($request->benef_m06)) 
                    $benef_m06 = (float)$request->benef_m06;
            }               
            $benef_m07 = 0;
            if(isset($request->benef_m07)){
                if(!empty($request->benef_m07)) 
                    $benef_m07 = (float)$request->benef_m07;
            }          
            $benef_m08 = 0;
            if(isset($request->benef_m08)){
                if(!empty($request->benef_m08)) 
                    $benef_m08 = (float)$request->benef_m08;
            }  
            $benef_m09 = 0;
            if(isset($request->benef_m09)){
                if(!empty($request->benef_m09)) 
                    $benef_m09 = (float)$request->benef_m09;
            }  
            $benef_m10 = 0;
            if(isset($request->benef_m10)){
                if(!empty($request->benef_m10)) 
                    $benef_m10 = (float)$request->benef_m10;
            }  
            $benef_m11 = 0;
            if(isset($request->benef_m11)){
                if(!empty($request->benef_m11)) 
                    $benef_m11 = (float)$request->benef_m11;
            }                                                  
            $benef_m12 = 0;
            if(isset($request->benef_m12)){
                if(!empty($request->benef_m12)) 
                    $benef_m12 = (float)$request->benef_m12;
            }                           
            $benef_mt01 = (float)$benef_m01 + (float)$benef_m02 + (float)$benef_m03;
            $benef_mt02 = (float)$benef_m04 + (float)$benef_m05 + (float)$benef_m06;
            $benef_mt03 = (float)$benef_m07 + (float)$benef_m08 + (float)$benef_m09;
            $benef_mt04 = (float)$benef_m10 + (float)$benef_m11 + (float)$benef_m12;

            $benef_ms01 =(float)$benef_m01+(float)$benef_m02+(float)$benef_m03+(float)$benef_m04+(float)$benef_m05+(float)$benef_m06;
            $benef_ms02 =(float)$benef_m07+(float)$benef_m08+(float)$benef_m09+(float)$benef_m10+(float)$benef_m11+(float)$benef_m12;            

            $benef_ma01  = (float)$benef_ms01 + (float)$benef_ms02;             

            /********************** Alta  *****************************/ 
            //$iid = regDistbenefModel::count(*);
            //$iid = $iid + 1;
            $nuevaiap = new regDistbenefModel();
            $name1 =null;
            //Comprobar  si el campo foto1 tiene un archivo asignado:
            if($request->hasFile('osc_foto1')){
               $name1 = $osc_id.'_'.$request->file('osc_foto1')->getClientOriginalName(); 
               $request->file('osc_foto1')->move(public_path().'/images/', $name1);
            }
 
            $nuevaiap->PERIODO_ID      = $request->periodo_id;
            $nuevaiap->PROG_ID         = $request->prog_id;
            $nuevaiap->BENEF_META      = $request->benef_meta;
            $nuevaiap->BENEF_M01       = $benef_m01;
            $nuevaiap->BENEF_M02       = $benef_m02;
            $nuevaiap->BENEF_M03       = $benef_m03;
            $nuevaiap->BENEF_M04       = $benef_m04;
            $nuevaiap->BENEF_M05       = $benef_m05;
            $nuevaiap->BENEF_M06       = $benef_m06;
            $nuevaiap->BENEF_M07       = $benef_m07;
            $nuevaiap->BENEF_M08       = $benef_m08;
            $nuevaiap->BENEF_M09       = $benef_m09;
            $nuevaiap->BENEF_M10       = $benef_m10;
            $nuevaiap->BENEF_M11       = $benef_m11;
            $nuevaiap->BENEF_M12       = $benef_m12;

            $nuevaiap->BENEF_MT01      = $benef_mt01;
            $nuevaiap->BENEF_MT02      = $benef_mt02;
            $nuevaiap->BENEF_MT03      = $benef_mt03;
            $nuevaiap->BENEF_MT04      = $benef_mt04;
            $nuevaiap->BENEF_MS01      = $benef_ms01;
            $nuevaiap->BENEF_MS02      = $benef_ms02;
            $nuevaiap->BENEF_MA01      = $benef_ma01;

            $nuevaiap->IP              = $ip;
            $nuevaiap->LOGIN           = $nombre;         // Usuario ;
            //dd($nuevaiap);
            $nuevaiap->save();
            if($nuevaiap->save() == true){
                toastr()->success('distribución de beneficiarios dada de alta.','ok!',['positionClass' => 'toast-bottom-right']);

                /************ Bitacora inicia *************************************/ 
                setlocale(LC_TIME, "spanish");        
                $xip          = session()->get('ip');
                $xperiodo_id  = (int)date('Y');
                $xprograma_id = 1;
                $xmes_id      = (int)date('m');
                $xproceso_id  =         3;
                $xfuncion_id  =      3001;
                $xtrx_id      =        27;    //Alta
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
                        toastr()->success('Trx de distribución de beneficiarios dada de alta en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                    else
                        toastr()->error('Error de trx de distribución de beneficiarios en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
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
                    toastr()->success('Trx de distribución de beneficiarios actualizado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                }   /************ Bitacora termina *************************************/ 
            }else{
                toastr()->error('Error de trx de distribución de beneficiarios. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }
        }
        return redirect()->route('verdistbenefmetas');
    }

    public function actionEditarDistbenefmetas($id, $id2){
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
        $regdistbenef     = regDistbenefModel::select('PERIODO_ID','PROG_ID','BENEF_META',
                        'BENEF_M01','BENEF_M02','BENEF_M03','BENEF_M04','BENEF_M05','BENEF_M06',
                        'BENEF_M07','BENEF_M08','BENEF_M09','BENEF_M10','BENEF_M11','BENEF_M12',
                        'BENEF_MT01','BENEF_MT02','BENEF_MT03','BENEF_MT04','BENEF_MS01','BENEF_MS02','BENEF_MA01')
                         ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2])
                         ->first();
        //dd($id,'segundo.....'.$id2, $regdistbenef->count() );
        if($regdistbenef->count() <= 0){
            toastr()->error('No existe distribución de beneficiarios.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.distrib_beneficiarios.editardistbenefmetas',compact('nombre','usuario','codigo','regprogramas','regperiodos','regdistbenef'));
    }

    public function actionActualizarDistbenefmetas(distbenefmetasRequest $request, $id, $id2){
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
        $regdistbenef = regDistbenefModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2]);
        //dd('hola.....',$regdistbenef);
        if($regdistbenef->count() <= 0)
            toastr()->error('No existe distribución de beneficiarios.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            //*********** Calculamos valores ************************
            $benef_m01 = 0;
            if(isset($request->benef_m01)){
                if(!empty($request->benef_m01)) 
                    $benef_m01 = (float)$request->benef_m01;
            }          
            $benef_m02 = 0;
            if(isset($request->benef_m02)){
                if(!empty($request->benef_m02)) 
                    $benef_m02 = (float)$request->benef_m02;
            }  
            $benef_m03 = 0;
            if(isset($request->benef_m03)){
                if(!empty($request->benef_m03)) 
                    $benef_m03 = (float)$request->benef_m03;
            }  
            $benef_m04 = 0;
            if(isset($request->benef_m04)){
                if(!empty($request->benef_m04)) 
                    $benef_m04 = (float)$request->benef_m04;
            }  
            $benef_m05 = 0;
            if(isset($request->benef_m05)){
                if(!empty($request->benef_m05)) 
                    $benef_m05 = (float)$request->benef_m05;
            }                                                  
            $benef_m06 = 0;
            if(isset($request->benef_m06)){
                if(!empty($request->benef_m06)) 
                    $benef_m06 = (float)$request->benef_m06;
            }               
            $benef_m07 = 0;
            if(isset($request->benef_m07)){
                if(!empty($request->benef_m07)) 
                    $benef_m07 = (float)$request->benef_m07;
            }          
            $benef_m08 = 0;
            if(isset($request->benef_m08)){
                if(!empty($request->benef_m08)) 
                    $benef_m08 = (float)$request->benef_m08;
            }  
            $benef_m09 = 0;
            if(isset($request->benef_m09)){
                if(!empty($request->benef_m09)) 
                    $benef_m09 = (float)$request->benef_m09;
            }  
            $benef_m10 = 0;
            if(isset($request->benef_m10)){
                if(!empty($request->benef_m10)) 
                    $benef_m10 = (float)$request->benef_m10;
            }  
            $benef_m11 = 0;
            if(isset($request->benef_m11)){
                if(!empty($request->benef_m11)) 
                    $benef_m11 = (float)$request->benef_m11;
            }                                                  
            $benef_m12 = 0;
            if(isset($request->benef_m12)){
                if(!empty($request->benef_m12)) 
                    $benef_m12 = (float)$request->benef_m12;
            }                           
            $benef_mt01 = (float)$benef_m01 + (float)$benef_m02 + (float)$benef_m03;
            $benef_mt02 = (float)$benef_m04 + (float)$benef_m05 + (float)$benef_m06;
            $benef_mt03 = (float)$benef_m07 + (float)$benef_m08 + (float)$benef_m09;
            $benef_mt04 = (float)$benef_m10 + (float)$benef_m11 + (float)$benef_m12;

            $benef_ms01 =(float)$benef_mt01+(float)$benef_mt02;
            $benef_ms02 =(float)$benef_mt03+(float)$benef_mt04;            

            $benef_ma01  = (float)$benef_ms01 + (float)$benef_ms02;             
            //*********** Actualizarn items **********************
            $regdistbenef = regDistbenefModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2])
                               ->update([                
                                         'BENEF_META'    => $request->benef_meta,
                                         'BENEF_M01'     => $benef_m01,
                                         'BENEF_M02'     => $benef_m02,
                                         'BENEF_M03'     => $benef_m03,
                                         'BENEF_M04'     => $benef_m04,
                                         'BENEF_M05'     => $benef_m05,
                                         'BENEF_M06'     => $benef_m06,
                                         'BENEF_M07'     => $benef_m07,
                                         'BENEF_M08'     => $benef_m08,
                                         'BENEF_M09'     => $benef_m09,
                                         'BENEF_M10'     => $benef_m10,
                                         'BENEF_M11'     => $benef_m11,
                                         'BENEF_M12'     => $benef_m12,   

                                         'BENEF_MT01'    => $benef_mt01,
                                         'BENEF_MT02'    => $benef_mt02,
                                         'BENEF_MT03'    => $benef_mt03,
                                         'BENEF_MT04'    => $benef_mt04,
                                         'BENEF_MS01'    => $benef_ms01,
                                         'BENEF_MS02'    => $benef_ms02,
                                         'BENEF_MA01'    => $benef_ma01,

                                         'IP_M'          => $ip,
                                         'LOGIN_M'       => $nombre,
                                         'FECHA_M2'      => date('Y/m/d'),   //date('d/m/Y')            
                                         'FECHA_M'       => date('Y/m/d')    //date('d/m/Y')   
                              ]);
            toastr()->success('distribución de beneficiarios actualizado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =        28;    //Actualizar 
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
                    toastr()->success('Trx de actualización de distribución de beneficiarios registrado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error Trx de distribución de beneficiarios  actualizado en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
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
                toastr()->success('Trx de actualización de distribución de beneficiarios registrado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                     
        }       /************ Actualizar *******************************************/
        return redirect()->route('verdistbenefmetas');
    }

    public function actionBorrarDistbenefmetas($id, $id2){
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
        $regdistbenef = regDistbenefModel::select('PERIODO_ID','PROG_ID','BENEF_META',
                        'BENEF_M01','BENEF_M02','BENEF_M03','BENEF_M04','BENEF_M05','BENEF_M06',
                        'BENEF_M07','BENEF_M08','BENEF_M09','BENEF_M10','BENEF_M11','BENEF_M12',
                        'BENEF_MT01','BENEF_MT02','BENEF_MT03','BENEF_MT04','BENEF_MS01','BENEF_MS02','BENEF_MA01')
                         ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2]);
        if($regdistbenef->count() <= 0)
            toastr()->error('No existe distribución de beneficiarios.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            $regdistbenef->delete();
            toastr()->success('distribución de beneficiarios eliminado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            //echo 'Ya entre a borrar registro..........';
            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =        29;     // Baja 

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
                    toastr()->success('Trx de baja de distribución de beneficiarios registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error en Trx de baja de distribución de beneficiarios en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
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
                toastr()->success('Trx de baja de distribución de beneficiarios registrado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                 
        }       /************* Termina de eliminar **********************************/
        return redirect()->route('verdistbenefmetas');
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
        $xtrx_id      =        30;            // Exportar a formato Excel
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
        $xtrx_id      =        31;       //Exportar a formato PDF
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

        $regdistbenef  = regDistbenefModel::select('PROG_ID','PROG_DESC','PROG_SIGLAS','PROG_VIGENTE', 
                                              'CLASIFICGOB_ID','PRIORIDAD_ID',
                                              'PROG_ORDEN','PROG_TIPO','PROG_SEPUBLICA','PROG_OBS1', 
                                              'PROG_OBS2','PROG_STATUS1','PROG_STATUS2','PROG_FECREG')
                                     ->orderBy('PROG_ID','ASC')
                                     ->get();                               
        if($regdistbenef->count() <= 0){
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
