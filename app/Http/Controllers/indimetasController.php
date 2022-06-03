<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\indimetasRequest;

use App\regPeriodosModel;
use App\regProgramasModel;
use App\regiclaseModel;
use App\regitipoModel;
use App\regidimenModel;
use App\regIndicadorModel;
use App\regBitacoraModel;

// Exportar a excel 
//use App\Exports\ExcelExportProg;
use Maatwebsite\Excel\Facades\Excel;
// Exportar a pdf
use PDF;
//use Options;

class indimetasController extends Controller
{

    public function actionBuscarIndimetas(Request $request)
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

        $regitipo     = regitipoModel::select('ITIPO_ID','ITIPO_DESC')
                          ->orderBy('ITIPO_DESC','asc')
                          ->get();     
        $regiclase    = regiclaseModel::select('ICLASE_ID','ICLASE_DESC')
                          ->orderBy('ICLASE_DESC','asc')
                          ->get();         
        $regidimen    = regidimenModel::select('IDIMENSION_ID','IDIMENSION_DESC')
                          ->orderBy('IDIMENSION_DESC','asc')
                          ->get();                                                 
        $regprogramas = regProgramasModel::select('PROG_ID','PROG_DESC')
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
            $regindicador = regIndicadorModel::orderBy('PROG_ID', 'ASC')
                       ->name($name)           //Metodos personalizados es equvalente a ->where('IAP_DESC', 'LIKE', "%$name%");
                       //->email($email)         //Metodos personalizados
                       //->bio($bio)             //Metodos personalizados
                       ->paginate(50);
        }else{           
            $regindicador = regIndicadorModel::where('PROG_ID',$codigo)
                       ->orderBy('PROG_ID', 'ASC')
                       ->name($name)           //Metodos personalizados es equvalente a ->where('IAP_DESC', 'LIKE', "%$name%");
                       //->email($email)         //Metodos personalizados
                       //->bio($bio)             //Metodos personalizados
                       ->paginate(50);          
        }
        if($regindicador->count() <= 0){
            toastr()->error('No existe indicador','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }            
        return view('sicinar.distrib_indicadores.verIndimetas', compact('nombre','usuario','codigo','regprogramas','regitipo','regiclase','regidimen','regperiodos','regindicador'));
    }

    public function actionVerIndimetas(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $codigo       = session()->get('codigo');         

        $regitipo     = regitipoModel::select('ITIPO_ID','ITIPO_DESC')
                          ->orderBy('ITIPO_DESC','asc')
                          ->get();     
        $regiclase    = regiclaseModel::select('ICLASE_ID','ICLASE_DESC')
                          ->orderBy('ICLASE_DESC','asc')
                          ->get();         
        $regidimen    = regidimenModel::select('IDIMENSION_ID','IDIMENSION_DESC')
                          ->orderBy('IDIMENSION_DESC','asc')
                          ->get();                                                 
        //$regprogramas   = regProgramasModel::select('PROG_ID','PROG_DESC')
        //                  ->orderBy('PROG_ID','asc')
        //                  ->get();                                        
        if(session()->get('rango') !== '0'){                                                       
            $regindicador=regIndicadorModel::join('CP_CAT_PROGRAMAS','CP_CAT_PROGRAMAS.PROG_ID', '=', 
                                                                     'CP_INDICADOR.PROG_ID')
                          ->select('CP_INDICADOR.PERIODO_ID',
                                   'CP_INDICADOR.PROG_ID',
                                   'CP_INDICADOR.INDI_ID',
                                   'CP_INDICADOR.ITIPO_ID',
                                   'CP_INDICADOR.ICLASE_ID',
                                   'CP_INDICADOR.IDIMENSION_ID',
                                   'CP_CAT_PROGRAMAS.PROG_DESC',
                                   'CP_INDICADOR.INDI_DESC',
                                   'CP_INDICADOR.INDI_FORMULA',                                   
                                   'CP_INDICADOR.INDI_META',
                                   'CP_INDICADOR.INDI_M01', 
                                   'CP_INDICADOR.INDI_M02',
                                   'CP_INDICADOR.INDI_M03',
                                   'CP_INDICADOR.INDI_M04',
                                   'CP_INDICADOR.INDI_M05',
                                   'CP_INDICADOR.INDI_M06', 
                                   'CP_INDICADOR.INDI_M07',
                                   'CP_INDICADOR.INDI_M08',
                                   'CP_INDICADOR.INDI_M09',
                                   'CP_INDICADOR.INDI_M10', 
                                   'CP_INDICADOR.INDI_M11',
                                   'CP_INDICADOR.INDI_M12'
                                      )
                         ->orderBy('CP_INDICADOR.PERIODO_ID','DESC')
                         ->orderBy('CP_INDICADOR.PROG_ID'   ,'DESC')
                         ->paginate(50);
        }else{           
            $regindicador=regIndicadorModel::join('CP_CAT_PROGRAMAS','CP_CAT_PROGRAMAS.PROG_ID', '=', 
                                                                     'CP_INDICADOR.PROG_ID')
                             ->select( 'CP_INDICADOR.PERIODO_ID',
                                       'CP_INDICADOR.PROG_ID',
                                       'CP_INDICADOR.INDI_ID',
                                       'CP_INDICADOR.ITIPO_ID',
                                       'CP_INDICADOR.ICLASE_ID',
                                       'CP_INDICADOR.IDIMENSION_ID',
                                       'CP_CAT_PROGRAMAS.PROG_DESC',
                                       'CP_INDICADOR.INDI_DESC',
                                       'CP_INDICADOR.INDI_FORMULA',
                                       'CP_INDICADOR.INDI_META',
                                       'CP_INDICADOR.INDI_M01', 
                                       'CP_INDICADOR.INDI_M02',
                                       'CP_INDICADOR.INDI_M03',
                                       'CP_INDICADOR.INDI_M04',
                                       'CP_INDICADOR.INDI_M05',
                                       'CP_INDICADOR.INDI_M06', 
                                       'CP_INDICADOR.INDI_M07',
                                       'CP_INDICADOR.INDI_M08',
                                       'CP_INDICADOR.INDI_M09',
                                       'CP_INDICADOR.INDI_M10', 
                                       'CP_INDICADOR.INDI_M11',
                                       'CP_INDICADOR.INDI_M12'
                                      )
                             ->where(  'CP_INDICADOR.PROG_ID'   ,$codigo)                             
                            ->orderBy( 'CP_INDICADOR.PERIODO_ID','DESC')
                            ->orderBy( 'CP_INDICADOR.PROG_ID'   ,'DESC')
                            ->paginate(50);          
        }                         
        if($regindicador->count() <= 0){
            toastr()->error('No existen indicador','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.distrib_indicadores.verIndimetas',compact('nombre','usuario','codigo','regprogramas','regitipo','regiclase','regidimen','regindicador'));
    }

    public function actionNuevoIndimetas(){
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
        $regitipo     = regitipoModel::select('ITIPO_ID','ITIPO_DESC')
                          ->orderBy('ITIPO_DESC','asc')
                          ->get();     
        $regiclase    = regiclaseModel::select('ICLASE_ID','ICLASE_DESC')
                          ->orderBy('ICLASE_DESC','asc')
                          ->get();         
        $regidimen    = regidimenModel::select('IDIMENSION_ID','IDIMENSION_DESC')
                          ->orderBy('IDIMENSION_DESC','asc')
                          ->get();      
        if(session()->get('rango') !== '0'){    
            $regprogramas = regProgramasModel::select('PROG_ID','PROG_DESC')
                            ->orderBy('PROG_ID','asc')
                            ->get();                                    
            $regindicador = regIndicadorModel::select('PERIODO_ID','PROG_ID','INDI_ID','ITIPO_ID','ICLASE_ID',
                            'IDIMENSION_ID','INDI_DESC','INDI_FORMULA','INDI_META',
                            'INDI_M01','INDI_M02','INDI_M03','INDI_M04','INDI_M05','INDI_M06',
                            'INDI_M07','INDI_M08','INDI_M09','INDI_M10','INDI_M11','INDI_M12',
                            'INDI_MT01','INDI_MT02','INDI_MT03','INDI_MT04','INDI_MS01','INDI_MS02','INDI_MA01')
                            ->orderBy('PERIODO_ID','asc')
                            ->orderBy('PROG_ID'   ,'asc')
                            ->get();          
        }else{                                                                              
            $regprogramas = regProgramasModel::select('PROG_ID','PROG_DESC')
                            ->where('PROG_ID',$codigo) 
                            ->get();                                    
            $regindicador = regIndicadorModel::select('PERIODO_ID','PROG_ID','INDI_ID','ITIPO_ID','ICLASE_ID',
                            'IDIMENSION_ID','INDI_DESC','INDI_FORMULA','INDI_META',
                            'INDI_M01','INDI_M02','INDI_M03','INDI_M04','INDI_M05','INDI_M06',
                            'INDI_M07','INDI_M08','INDI_M09','INDI_M10','INDI_M11','INDI_M12',
                            'INDI_MT01','INDI_MT02','INDI_MT03','INDI_MT04','INDI_MS01','INDI_MS02','INDI_MA01')
                            ->where('PROG_ID',$codigo) 
                            ->orderBy('PERIODO_ID','asc')
                            ->orderBy('PROG_ID'   ,'asc')
                            ->get();
        }
        //dd($unidades);
        return view('sicinar.distrib_indicadores.nuevoIndimetas',compact('nombre','usuario','codigo','regprogramas','regitipo','regiclase','regidimen','regperiodos','regindicador'));
    }

    public function actionAltaNuevoIndimetas(Request $request){
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
        $regindicador = regIndicadorModel::where(['PERIODO_ID' => $request->periodo_id,
                                                  'PROG_ID'    => $request->prog_id,
                                                  'INDI_ID'    => $request->indi_id]);
        if($regindicador->count() > 0)
            toastr()->error('Ya existe la indicador.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{   
            //*********** Calculamos valores ************************//
            $indi_m01 = 0;
            if(isset($request->indi_m01)){
                if(!empty($request->indi_m01)) 
                    $indi_m01 = (float)$request->indi_m01;
            }          
            $indi_m02 = 0;
            if(isset($request->indi_m02)){
                if(!empty($request->indi_m02)) 
                    $indi_m02 = (float)$request->indi_m02;
            }  
            $indi_m03 = 0;
            if(isset($request->indi_m03)){
                if(!empty($request->indi_m03)) 
                    $indi_m03 = (float)$request->indi_m03;
            }  
            $indi_m04 = 0;
            if(isset($request->indi_m04)){
                if(!empty($request->indi_m04)) 
                    $indi_m04 = (float)$request->indi_m04;
            }  
            $indi_m05 = 0;
            if(isset($request->indi_m05)){
                if(!empty($request->indi_m05)) 
                    $indi_m05 = (float)$request->indi_m05;
            }                                                  
            $indi_m06 = 0;
            if(isset($request->indi_m06)){
                if(!empty($request->indi_m06)) 
                    $indi_m06 = (float)$request->indi_m06;
            }               
            $indi_m07 = 0;
            if(isset($request->indi_m07)){
                if(!empty($request->indi_m07)) 
                    $indi_m07 = (float)$request->indi_m07;
            }          
            $indi_m08 = 0;
            if(isset($request->indi_m08)){
                if(!empty($request->indi_m08)) 
                    $indi_m08 = (float)$request->indi_m08;
            }  
            $indi_m09 = 0;
            if(isset($request->indi_m09)){
                if(!empty($request->indi_m09)) 
                    $indi_m09 = (float)$request->indi_m09;
            }  
            $indi_m10 = 0;
            if(isset($request->indi_m10)){
                if(!empty($request->indi_m10)) 
                    $indi_m10 = (float)$request->indi_m10;
            }  
            $indi_m11 = 0;
            if(isset($request->indi_m11)){
                if(!empty($request->indi_m11)) 
                    $indi_m11 = (float)$request->indi_m11;
            }                                                  
            $indi_m12 = 0;
            if(isset($request->indi_m12)){
                if(!empty($request->indi_m12)) 
                    $indi_m12 = (float)$request->indi_m12;
            }                           
            $indi_mt01 = (float)$indi_m01 + (float)$indi_m02 + (float)$indi_m03;
            $indi_mt02 = (float)$indi_m04 + (float)$indi_m05 + (float)$indi_m06;
            $indi_mt03 = (float)$indi_m07 + (float)$indi_m08 + (float)$indi_m09;
            $indi_mt04 = (float)$indi_m10 + (float)$indi_m11 + (float)$indi_m12;

            $indi_ms01 =(float)$indi_m01+(float)$indi_m02+(float)$indi_m03+(float)$indi_m04+(float)$indi_m05+(float)$indi_m06;
            $indi_ms02 =(float)$indi_m07+(float)$indi_m08+(float)$indi_m09+(float)$indi_m10+(float)$indi_m11+(float)$indi_m12;            

            $indi_ma01  = (float)$indi_ms01 + (float)$indi_ms02;             

            /********************** Alta  *****************************/ 
            $id = regIndicadorModel::max('INDI_ID');
            $id = $id + 1;

            $nuevaiap = new regIndicadorModel();
            $name1 =null;
            //Comprobar  si el campo foto1 tiene un archivo asignado:
            if($request->hasFile('osc_foto1')){
               $name1 = $osc_id.'_'.$request->file('osc_foto1')->getClientOriginalName(); 
               $request->file('osc_foto1')->move(public_path().'/images/', $name1);
            }
 
            $nuevaiap->PERIODO_ID     = $request->periodo_id;
            $nuevaiap->PROG_ID        = $request->prog_id;
            $nuevaiap->INDI_ID        = $id;

            $nuevaiap->ITIPO_ID       = $request->itipo_id;
            $nuevaiap->ICLASE_ID      = $request->iclase_id;
            $nuevaiap->IDIMENSION_ID  = $request->idimension_id;
            $nuevaiap->INDI_DESC      = $request->indi_desc;
            $nuevaiap->INDI_FORMULA   = $request->indi_formula;
            $nuevaiap->INDI_META      = $request->indi_meta;
            $nuevaiap->INDI_M01       = $indi_m01;
            $nuevaiap->INDI_M02       = $indi_m02;
            $nuevaiap->INDI_M03       = $indi_m03;
            $nuevaiap->INDI_M04       = $indi_m04;
            $nuevaiap->INDI_M05       = $indi_m05;
            $nuevaiap->INDI_M06       = $indi_m06;
            $nuevaiap->INDI_M07       = $indi_m07;
            $nuevaiap->INDI_M08       = $indi_m08;
            $nuevaiap->INDI_M09       = $indi_m09;
            $nuevaiap->INDI_M10       = $indi_m10;
            $nuevaiap->INDI_M11       = $indi_m11;
            $nuevaiap->INDI_M12       = $indi_m12;

            $nuevaiap->INDI_MT01      = $indi_mt01;
            $nuevaiap->INDI_MT02      = $indi_mt02;
            $nuevaiap->INDI_MT03      = $indi_mt03;
            $nuevaiap->INDI_MT04      = $indi_mt04;
            $nuevaiap->INDI_MS01      = $indi_ms01;
            $nuevaiap->INDI_MS02      = $indi_ms02;
            $nuevaiap->INDI_MA01      = $indi_ma01;

            $nuevaiap->IP              = $ip;
            $nuevaiap->LOGIN           = $nombre;         // Usuario ;
            //dd($nuevaiap);
            $nuevaiap->save();
            if($nuevaiap->save() == true){
                toastr()->success('indicador dada de alta.','ok!',['positionClass' => 'toast-bottom-right']);

                /************ Bitacora inicia *************************************/ 
                setlocale(LC_TIME, "spanish");        
                $xip          = session()->get('ip');
                $xperiodo_id  = (int)date('Y');
                $xprograma_id = 1;
                $xmes_id      = (int)date('m');
                $xproceso_id  =         3;
                $xfuncion_id  =      3001;
                $xtrx_id      =        57;    //Alta
                $regbitacora=regBitacoraModel::select('PERIODO_ID', 'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
                                                      'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 
                                                      'FECHA_M', 'IP_M', 'LOGIN_M')
                             ->where(['PERIODO_ID' => $xperiodo_id, 'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id, 
                                      'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                      'FOLIO'      => $id])
                             ->get();
                if($regbitacora->count() <= 0){              // Alta
                    $nuevoregBitacora = new regBitacoraModel();              
                    $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                    $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                    $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                    $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                    $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                    $nuevoregBitacora->FOLIO      = $id;        // Folio    
                    $nuevoregBitacora->NO_VECES   = 1;               // Numero de veces            
                    $nuevoregBitacora->IP         = $ip;             // IP
                    $nuevoregBitacora->LOGIN      = $nombre;         // Usuario 

                    $nuevoregBitacora->save();
                    if($nuevoregBitacora->save() == true)
                        toastr()->success('Trx de indicador dada de alta en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                    else
                        toastr()->error('Error de trx de indicador en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
                }else{                   
                    //*********** Obtine el no. de veces *****************************
                    $xno_veces=regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id,'MES_ID'     => $xmes_id, 
                                                        'PROCESO_ID' => $xproceso_id,'FUNCION_ID' => $xfuncion_id, 
                                                        'TRX_ID'     => $xtrx_id,    'FOLIO'      => $id])
                               ->max('NO_VECES');
                    $xno_veces = $xno_veces+1;                        
                    //*********** Termina de obtener el no de veces *****************************         
                    $regbitacora=regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                                 ->where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id,'PROCESO_ID'=> $xproceso_id, 
                                          'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO'     => $id])
                                 ->update([
                                           'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                           'IP_M'     => $regbitacora->IP       = $ip,
                                           'LOGIN_M'  => $regbitacora->LOGIN_M  = $nombre,
                                           'FECHA_M'  => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                          ]);
                    toastr()->success('Trx de indicador actualizado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                }   /************ Bitacora termina *************************************/ 
            }else{
                toastr()->error('Error de trx de indicador. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }
        }
        return redirect()->route('verindimetas');
    }

    public function actionEditarIndimetas($id, $id2, $id3){
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
        $regitipo     = regitipoModel::select('ITIPO_ID','ITIPO_DESC')
                          ->orderBy('ITIPO_DESC','asc')
                          ->get();     
        $regiclase    = regiclaseModel::select('ICLASE_ID','ICLASE_DESC')
                          ->orderBy('ICLASE_DESC','asc')
                          ->get();         
        $regidimen    = regidimenModel::select('IDIMENSION_ID','IDIMENSION_DESC')
                          ->orderBy('IDIMENSION_DESC','asc')
                          ->get();                                                 
        $regprogramas = regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->orderBy('PROG_ID','asc')
                          ->get();                                    
        $regindicador = regIndicadorModel::select('PERIODO_ID','PROG_ID','INDI_ID','ITIPO_ID','ICLASE_ID',
                        'IDIMENSION_ID','INDI_DESC','INDI_FORMULA','INDI_META',
                        'INDI_M01','INDI_M02','INDI_M03','INDI_M04','INDI_M05','INDI_M06',
                        'INDI_M07','INDI_M08','INDI_M09','INDI_M10','INDI_M11','INDI_M12',
                        'INDI_MT01','INDI_MT02','INDI_MT03','INDI_MT04','INDI_MS01','INDI_MS02','INDI_MA01')
                         ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'INDI_ID' => $id3])
                         ->first();
        //dd($id,'segundo.....'.$id2, $regindicador->count() );
        if($regindicador->count() <= 0){
            toastr()->error('No existe indicador.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.distrib_indicadores.editarIndimetas',compact('nombre','usuario','codigo','regprogramas','regitipo','regiclase','regidimen','regperiodos','regindicador'));
    }

    public function actionActualizarIndimetas(indimetasRequest $request, $id, $id2, $id3){
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
        $regindicador = regIndicadorModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'INDI_ID' => $id3]);
        //dd('hola.....',$regindicador);
        if($regindicador->count() <= 0)
            toastr()->error('No existe indicador.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            //*********** Calculamos valores ************************
            $indi_m01 = 0;
            if(isset($request->indi_m01)){
                if(!empty($request->indi_m01)) 
                    $indi_m01 = (float)$request->indi_m01;
            }          
            $indi_m02 = 0;
            if(isset($request->indi_m02)){
                if(!empty($request->indi_m02)) 
                    $indi_m02 = (float)$request->indi_m02;
            }  
            $indi_m03 = 0;
            if(isset($request->indi_m03)){
                if(!empty($request->indi_m03)) 
                    $indi_m03 = (float)$request->indi_m03;
            }  
            $indi_m04 = 0;
            if(isset($request->indi_m04)){
                if(!empty($request->indi_m04)) 
                    $indi_m04 = (float)$request->indi_m04;
            }  
            $indi_m05 = 0;
            if(isset($request->indi_m05)){
                if(!empty($request->indi_m05)) 
                    $indi_m05 = (float)$request->indi_m05;
            }                                                  
            $indi_m06 = 0;
            if(isset($request->indi_m06)){
                if(!empty($request->indi_m06)) 
                    $indi_m06 = (float)$request->indi_m06;
            }               
            $indi_m07 = 0;
            if(isset($request->indi_m07)){
                if(!empty($request->indi_m07)) 
                    $indi_m07 = (float)$request->indi_m07;
            }          
            $indi_m08 = 0;
            if(isset($request->indi_m08)){
                if(!empty($request->indi_m08)) 
                    $indi_m08 = (float)$request->indi_m08;
            }  
            $indi_m09 = 0;
            if(isset($request->indi_m09)){
                if(!empty($request->indi_m09)) 
                    $indi_m09 = (float)$request->indi_m09;
            }  
            $indi_m10 = 0;
            if(isset($request->indi_m10)){
                if(!empty($request->indi_m10)) 
                    $indi_m10 = (float)$request->indi_m10;
            }  
            $indi_m11 = 0;
            if(isset($request->indi_m11)){
                if(!empty($request->indi_m11)) 
                    $indi_m11 = (float)$request->indi_m11;
            }                                                  
            $indi_m12 = 0;
            if(isset($request->indi_m12)){
                if(!empty($request->indi_m12)) 
                    $indi_m12 = (float)$request->indi_m12;
            }                           
            $indi_mt01 = (float)$indi_m01 + (float)$indi_m02 + (float)$indi_m03;
            $indi_mt02 = (float)$indi_m04 + (float)$indi_m05 + (float)$indi_m06;
            $indi_mt03 = (float)$indi_m07 + (float)$indi_m08 + (float)$indi_m09;
            $indi_mt04 = (float)$indi_m10 + (float)$indi_m11 + (float)$indi_m12;

            $indi_ms01 =(float)$indi_m01+(float)$indi_m02+(float)$indi_m03+(float)$indi_m04+(float)$indi_m05+(float)$indi_m06;
            $indi_ms02 =(float)$indi_m07+(float)$indi_m08+(float)$indi_m09+(float)$indi_m10+(float)$indi_m11+(float)$indi_m12;            

            $indi_ma01  = (float)$indi_ms01 + (float)$indi_ms02;             
            //*********** Actualizarn items **********************
            $regindicador = regIndicadorModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'INDI_ID' => $id3])
                               ->update([                
                                         //'INDI_ID'    => $request->indi_meta,
                                         'ITIPO_ID'     => $request->itipo_id,
                                         'ICLASE_ID'    => $request->iclase_id,
                                         'IDIMENSION_ID'=> $request->idimension_id,
                                         'INDI_DESC'    => $request->indi_desc,
                                         'INDI_FORMULA' => $request->indi_formula,
                                         'INDI_META'    => $request->indi_meta,
                                         'INDI_M01'     => $indi_m01,
                                         'INDI_M02'     => $indi_m02,
                                         'INDI_M03'     => $indi_m03,
                                         'INDI_M04'     => $indi_m04,
                                         'INDI_M05'     => $indi_m05,
                                         'INDI_M06'     => $indi_m06,
                                         'INDI_M07'     => $indi_m07,
                                         'INDI_M08'     => $indi_m08,
                                         'INDI_M09'     => $indi_m09,
                                         'INDI_M10'     => $indi_m10,
                                         'INDI_M11'     => $indi_m11,
                                         'INDI_M12'     => $indi_m12,   

                                         'INDI_MT01'    => $indi_mt01,
                                         'INDI_MT02'    => $indi_mt02,
                                         'INDI_MT03'    => $indi_mt03,
                                         'INDI_MT04'    => $indi_mt04,
                                         'INDI_MS01'    => $indi_ms01,
                                         'INDI_MS02'    => $indi_ms02,
                                         'INDI_MA01'    => $indi_ma01,

                                         'IP_M'          => $ip,
                                         'LOGIN_M'       => $nombre,
                                         'FECHA_M2'      => date('Y/m/d'),   //date('d/m/Y')            
                                         'FECHA_M'       => date('Y/m/d')    //date('d/m/Y')   
                              ]);
            toastr()->success('indicador actualizado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =        58;    //Actualizar 
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
                    toastr()->success('Trx de actualización de indicador registrado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error Trx de indicador  actualizado en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
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
                toastr()->success('Trx de actualización de indicador registrado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                     
        }       /************ Actualizar *******************************************/
        return redirect()->route('verindimetas');
    }

    public function actionBorrarIndimetas($id, $id2, $id3){
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
        $regindicador = regIndicadorModel::select('PERIODO_ID','PROG_ID','INDI_ID','ITIPO_ID','ICLASE_ID',
                        'IDIMENSION_ID','INDI_DESC','INDI_FORMULA','INDI_META',
                        'INDI_M01','INDI_M02','INDI_M03','INDI_M04','INDI_M05','INDI_M06',
                        'INDI_M07','INDI_M08','INDI_M09','INDI_M10','INDI_M11','INDI_M12',
                        'INDI_MT01','INDI_MT02','INDI_MT03','INDI_MT04','INDI_MS01','INDI_MS02','INDI_MA01')
                         ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'INDI_ID' => $id3]);
        if($regindicador->count() <= 0)
            toastr()->error('No existe indicador.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            $regindicador->delete();
            toastr()->success('indicador eliminado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            //echo 'Ya entre a borrar registro..........';
            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =        59;     // Baja 

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
                    toastr()->success('Trx de baja de indicador registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error en Trx de baja de indicador en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
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
                toastr()->success('Trx de indicador registrado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                 
        }       /************* Termina de eliminar **********************************/
        return redirect()->route('verindimetas');
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
        $xtrx_id      =        60;            // Exportar a formato Excel
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
        $xtrx_id      =        61;       //Exportar a formato PDF
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

        $regindicador  = $regIndicadorModel::select('PROG_ID','PROG_DESC','PROG_SIGLAS','PROG_VIGENTE', 
                                              'CLASIFICGOB_ID','PRIORIDAD_ID',
                                              'PROG_ORDEN','PROG_TIPO','PROG_SEPUBLICA','PROG_OBS1', 
                                              'PROG_OBS2','PROG_STATUS1','PROG_STATUS2','PROG_FECREG')
                                     ->orderBy('PROG_ID','ASC')
                                     ->get();                               
        if($regindicador->count() <= 0){
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
