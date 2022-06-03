<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\indiavanRequest;

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

class indiavanController extends Controller
{

    public function actionBuscarIndiavan(Request $request)
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
        return view('sicinar.distrib_indicadores.verIndiavan', compact('nombre','usuario','codigo','regprogramas','regiclase','regitipo','regidimen','regperiodos','regindicador'));
    }

    public function actionVerIndiavan(){
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
        if(session()->get('rango') !== '0'){                                                       
            $regindicador=regIndicadorModel::join('CP_CAT_PROGRAMAS','CP_CAT_PROGRAMAS.PROG_ID', '=', 
                                                                     'CP_INDICADOR.PROG_ID')
                             ->select('CP_INDICADOR.PERIODO_ID',
                                      'CP_INDICADOR.PROG_ID',
                                      'CP_CAT_PROGRAMAS.PROG_DESC',
                                      'CP_INDICADOR.INDI_ID',
                                      'CP_INDICADOR.INDI_DESC', 
                                      'CP_INDICADOR.INDI_FORMULA', 
                                      'CP_INDICADOR.ICLASE_ID',      
                                      'CP_INDICADOR.ITIPO_ID',   
                                      'CP_INDICADOR.IDIMENSION_ID',                                         
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
                                      'CP_INDICADOR.INDI_M12',
                                      'CP_INDICADOR.INDI_AVANCE', 
                                      'CP_INDICADOR.INDI_A01', 
                                      'CP_INDICADOR.INDI_A02',
                                      'CP_INDICADOR.INDI_A03',
                                      'CP_INDICADOR.INDI_A04',
                                      'CP_INDICADOR.INDI_A05',
                                      'CP_INDICADOR.INDI_A06', 
                                      'CP_INDICADOR.INDI_A07',
                                      'CP_INDICADOR.INDI_A08',
                                      'CP_INDICADOR.INDI_A09',
                                      'CP_INDICADOR.INDI_A10', 
                                      'CP_INDICADOR.INDI_A11',
                                      'CP_INDICADOR.INDI_A12'
                                      )
                         ->orderBy('CP_INDICADOR.PERIODO_ID','DESC')
                         ->orderBy('CP_INDICADOR.PROG_ID'   ,'DESC')
                         ->paginate(50);
        }else{           
            $regindicador=regIndicadorModel::join('CP_CAT_PROGRAMAS','CP_CAT_PROGRAMAS.PROG_ID', '=', 
                                                                     'CP_INDICADOR.PROG_ID')
                             ->select('CP_INDICADOR.PERIODO_ID',
                                      'CP_INDICADOR.PROG_ID',
                                      'CP_CAT_PROGRAMAS.PROG_DESC',
                                      'CP_INDICADOR.INDI_ID',
                                      'CP_INDICADOR.INDI_DESC', 
                                      'CP_INDICADOR.INDI_FORMULA', 
                                      'CP_INDICADOR.ICLASE_ID',      
                                      'CP_INDICADOR.ITIPO_ID',   
                                      'CP_INDICADOR.IDIMENSION_ID',  
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
                                      'CP_INDICADOR.INDI_M12',
                                      'CP_INDICADOR.INDI_AVANCE', 
                                      'CP_INDICADOR.INDI_A01', 
                                      'CP_INDICADOR.INDI_A02',
                                      'CP_INDICADOR.INDI_A03',
                                      'CP_INDICADOR.INDI_A04',
                                      'CP_INDICADOR.INDI_A05',
                                      'CP_INDICADOR.INDI_A06', 
                                      'CP_INDICADOR.INDI_A07',
                                      'CP_INDICADOR.INDI_A08',
                                      'CP_INDICADOR.INDI_A09',
                                      'CP_INDICADOR.INDI_A10', 
                                      'CP_INDICADOR.INDI_A11',
                                      'CP_INDICADOR.INDI_A12'                                       
                                     )
                             ->where(  'CP_INDICADOR.PROG_ID'   ,$codigo)                             
                            ->orderBy( 'CP_INDICADOR.PERIODO_ID','DESC')
                            ->orderBy( 'CP_INDICADOR.PROG_ID'   ,'DESC')
                            ->paginate(50);          
        }                         
        if($regindicador->count() <= 0){
            toastr()->error('No existen indicador','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.distrib_indicadores.verIndiavan',compact('nombre','usuario','codigo','regprogramas','regiclase','regitipo','regidimen','regindicador'));
    }

    public function actionNuevoIndiavan(){
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
        $regprogramas = regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->orderBy('PROG_ID','asc')
                          ->get();                                                      
        $regindicador = regIndicadorModel::select('PERIODO_ID','PROG_ID','INDI_ID',
                        'INDI_DESC','INDI_FORMULA','ICLASE_ID','ITIPO_ID','IDIMENSION_ID', 
                        'INDI_META','INDI_AVANCE',
                        'INDI_M01','INDI_M02','INDI_M03','INDI_M04','INDI_M05','INDI_M06',
                        'INDI_M07','INDI_M08','INDI_M09','INDI_M10','INDI_M11','INDI_M12',
                        'INDI_MT01','INDI_MT02','INDI_MT03','INDI_MT04','INDI_MS01','INDI_MS02','INDI_MA01',
                        'INDI_A01','INDI_A02','INDI_A03','INDI_A04','INDI_A05','INDI_A06',
                        'INDI_A07','INDI_A08','INDI_A09','INDI_A10','INDI_A11','INDI_A12',
                        'INDI_AT01','INDI_AT02','INDI_AT03','INDI_AT04','INDI_AS01','INDI_AS02','INDI_AA01'
                        )
                         ->orderBy('PERIODO_ID','asc')
                         ->orderBy('PROG_ID'   ,'asc')
                         ->get();
        //dd($unidades);
        return view('sicinar.distrib_indicadores.nuevoIndiavan',compact('nombre','usuario','codigo','regprogramas','regiclase','regitipo','regidimen','regperiodos','regindicador'));
    }

    public function actionAltaNuevoIndiavan(Request $request){
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
            //$iid = regIndicadorModel::count(*);
            //$iid = $iid + 1;
            $nuevaiap = new regIndicadorModel();
            $name1 =null;
            //Comprobar  si el campo foto1 tiene un archivo asignado:
            if($request->hasFile('osc_foto1')){
               $name1 = $osc_id.'_'.$request->file('osc_foto1')->getClientOriginalName(); 
               $request->file('osc_foto1')->move(public_path().'/images/', $name1);
            }
 
            $nuevaiap->PERIODO_ID     = $request->periodo_id;
            $nuevaiap->PROG_ID        = $request->prog_id;
            $nuevaiap->INDI_ID        = $request->indi_id;
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
                $xtrx_id      =        62;    //Alta
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
                        toastr()->success('Trx de indicador dada de alta en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                    else
                        toastr()->error('Error de trx de indicador en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
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
                    toastr()->success('Trx de indicador actualizado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                }   /************ Bitacora termina *************************************/ 
            }else{
                toastr()->error('Error de trx de indicador. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }
        }
        return redirect()->route('verindimetas');
    }

    public function actionEditarIndiavan($id, $id2, $id3){
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
        $regindicador = regIndicadorModel::select('PERIODO_ID','PROG_ID','INDI_ID',
                        'INDI_DESC','INDI_FORMULA','ICLASE_ID','ITIPO_ID','IDIMENSION_ID', 
                        'INDI_META','INDI_AVANCE',
                        'INDI_M01','INDI_M02','INDI_M03','INDI_M04','INDI_M05','INDI_M06',
                        'INDI_M07','INDI_M08','INDI_M09','INDI_M10','INDI_M11','INDI_M12',
                        'INDI_MT01','INDI_MT02','INDI_MT03','INDI_MT04','INDI_MS01','INDI_MS02','INDI_MA01',
                        'INDI_A01','INDI_A02','INDI_A03','INDI_A04','INDI_A05','INDI_A06',
                        'INDI_A07','INDI_A08','INDI_A09','INDI_A10','INDI_A11','INDI_A12',
                        'INDI_AT01','INDI_AT02','INDI_AT03','INDI_AT04','INDI_AS01','INDI_AS02','INDI_AA01',
                        'INDI_P01','INDI_P02','INDI_P03','INDI_P04','INDI_P05','INDI_P06',
                        'INDI_P07','INDI_P08','INDI_P09','INDI_P10','INDI_P11','INDI_P12',
                        'INDI_PT01','INDI_PT02','INDI_PT03','INDI_PT04','INDI_PS01','INDI_PS02','INDI_PA01',
                        'INDI_S01','INDI_S02','INDI_S03','INDI_S04','INDI_S05','INDI_S06',
                        'INDI_S07','INDI_S08','INDI_S09','INDI_S10','INDI_S11','INDI_S12',
                        'INDI_ST01','INDI_ST02','INDI_ST03','INDI_ST04','INDI_SS01','INDI_SS02','INDI_SA01',
                        'INDI_SC01','INDI_SC02','INDI_SC03','INDI_SC04','INDI_SC05','INDI_SC06',
                        'INDI_SC07','INDI_SC08','INDI_SC09','INDI_SC10','INDI_SC11','INDI_SC12',
                        'INDI_SCT01','INDI_SCT02','INDI_SCT03','INDI_SCT04','INDI_SCS01','INDI_SCS02','INDI_SCA01'
                        )
                         ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'INDI_ID' => $id3])
                         ->first();
        //dd($id,'segundo.....'.$id2, $regindicador->count() );
        if($regindicador->count() <= 0){
            toastr()->error('No existe indicador.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.distrib_indicadores.editarIndiavan',compact('nombre','usuario','codigo','regprogramas','regiclase','regitipo','regidimen','regperiodos','regindicador'));
    }

    public function actionActualizarIndiavan(indiavanRequest $request, $id, $id2, $id3){
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
        $regindicador = regindicadorModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'INDI_ID' => $id3]);
        //dd('hola.....',$regindicador);
        if($regindicador->count() <= 0)
            toastr()->error('No existe indicador.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            //************ Obtiene valores programados **********//
            //$mesesp  = regIndicadorModel::obtmesesprog($id, $id2, $id3);       

            //$indi_meta = $mesesp[0]->indi_meta; 

            //$indi_m01  = $mesesp[0]->indi_m01;    
            //$indi_m02  = $mesesp[0]->indi_m02;    
            //$indi_m03  = $mesesp[0]->indi_m03;    
            //$indi_m04  = $mesesp[0]->indi_m04;    
            //$indi_m05  = $mesesp[0]->indi_m05;    
            //$indi_m06  = $mesesp[0]->indi_m06;    
            //$indi_m07  = $mesesp[0]->indi_m07;    
            //$indi_m08  = $mesesp[0]->indi_m08;    
            //$indi_m09  = $mesesp[0]->indi_m09;    
            //$indi_m10  = $mesesp[0]->indi_m10;    
            //$indi_m11  = $mesesp[0]->indi_m11;    
            //$indi_m12  = $mesesp[0]->indi_m12;  
 
            //$indi_mt01 = $mesesp[0]->indi_mt01;    
            //$indi_mt02 = $mesesp[0]->indi_mt02;    
            //$indi_mt03 = $mesesp[0]->indi_mt03;    
            //$indi_mt04 = $mesesp[0]->indi_mt04;

            //$indi_ms01 = $mesesp[0]->indi_ms01;    
            //$indi_ms02 = $mesesp[0]->indi_ms02;     

            //$indi_ma01 = $mesesp[0]->indi_ma01;    

            //$totp_02  = $mesesp[0]->totp_02;    

            //************ Obtiene valores programados **********//
            $indi_meta = 0;
            if(isset($request->indi_meta)){
                if(!empty($request->indi_meta)) 
                    $indi_meta = (float)$request->indi_meta;
            }                      
            //$indi_meta = $mesesp[0]->indi_meta;
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

            $indi_ms01 =(float)$indi_mt01+(float)$indi_mt02;
            $indi_ms02 =(float)$indi_mt03+(float)$indi_mt04;            

            $indi_ma01  = (float)$indi_ms01 + (float)$indi_ms02;      


            //*********** Calculamos valores ************************
            $indi_avance = 0;
            if(isset($request->indi_avance)){
                if(!empty($request->indi_avance)) 
                    $indi_avance = (float)$request->indi_avance;
            }          
            $indi_a01 = 0;
            if(isset($request->indi_a01)){
                if(!empty($request->indi_a01)) 
                    $indi_a01 = (float)$request->indi_a01;
            }                      
            $indi_a02 = 0;
            if(isset($request->indi_a02)){
                if(!empty($request->indi_a02)) 
                    $indi_a02 = (float)$request->indi_a02;
            }  
            $indi_a03 = 0;
            if(isset($request->indi_a03)){
                if(!empty($request->indi_a03)) 
                    $indi_a03 = (float)$request->indi_a03;
            }  
            $indi_a04 = 0;
            if(isset($request->indi_a04)){
                if(!empty($request->indi_a04)) 
                    $indi_a04 = (float)$request->indi_a04;
            }  
            $indi_a05 = 0;
            if(isset($request->indi_a05)){
                if(!empty($request->indi_a05)) 
                    $indi_a05 = (float)$request->indi_a05;
            }                                                  
            $indi_a06 = 0;
            if(isset($request->indi_a06)){
                if(!empty($request->indi_a06)) 
                    $indi_a06 = (float)$request->indi_a06;
            }               
            $indi_a07 = 0;
            if(isset($request->indi_a07)){
                if(!empty($request->indi_a07)) 
                    $indi_a07 = (float)$request->indi_a07;
            }          
            $indi_a08 = 0;
            if(isset($request->indi_a08)){
                if(!empty($request->indi_a08)) 
                    $indi_a08 = (float)$request->indi_a08;
            }  
            $indi_a09 = 0;
            if(isset($request->indi_a09)){
                if(!empty($request->indi_a09)) 
                    $indi_a09 = (float)$request->indi_a09;
            }  
            $indi_a10 = 0;
            if(isset($request->indi_a10)){
                if(!empty($request->indi_a10)) 
                    $indi_a10 = (float)$request->indi_a10;
            }  
            $indi_a11 = 0;
            if(isset($request->indi_a11)){
                if(!empty($request->indi_a11)) 
                    $indi_a11 = (float)$request->indi_a11;
            }                                                  
            $indi_a12 = 0;
            if(isset($request->indi_a12)){
                if(!empty($request->indi_a12)) 
                    $indi_a12 = (float)$request->indi_a12;
            }                           
            $indi_at01 = (float)$indi_a01 + (float)$indi_a02 + (float)$indi_a03;
            $indi_at02 = (float)$indi_a04 + (float)$indi_a05 + (float)$indi_a06;
            $indi_at03 = (float)$indi_a07 + (float)$indi_a08 + (float)$indi_a09;
            $indi_at04 = (float)$indi_a10 + (float)$indi_a11 + (float)$indi_a12;

            $indi_as01 = (float)$indi_at01 + (float)$indi_at02;
            $indi_as02 = (float)$indi_at03 + (float)$indi_at04;            

            $indi_aa01 = (float)$indi_as01 + (float)$indi_as02; 
            
            //********** Calcula porcentaje anual ********************************//
            $indi_pa01  = 0;
            $indi_sa01  = 0;
            $indi_sca01 = "";            
            if( (float)$indi_avance > 0 && (float)$indi_meta > 0 ){
                $indi_pa01  =( (float)$indi_avance / (float)$indi_meta) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$indi_pa01 = 0 && (float)$indi_pa01 <= 49.9 ){
                     $indi_sa01  = 1;
                     $indi_sca01 = "ROJO";
                }else{    
                    if( (float)$indi_pa01 = 50 && (float)$indi_pa01 <= 69.9 ){
                        $indi_sa01  = 2;
                        $indi_sca01 = "NARANJA";
                    }else{    
                        if( (float)$indi_pa01 = 70 && (float)$indi_pa01 <= 89.9 ){
                            $indi_sa01  = 3;
                            $indi_sca01 = "AMARILLO";
                        }else{    
                            if( (float)$indi_pa01 = 90 && (float)$indi_pa01 <= 110 ){
                                 $indi_sa01  = 4;
                                 $indi_sca01 = "VERDE";
                            }else{    
                                if( (float)$indi_pa01 > 110 && (float)$indi_pa01 <= 300 ){
                                    $indi_sa01  = 5;
                                    $indi_sca01 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }

            //********** Calcula porcentales semestrales ********************************//
            $indi_ps01  = 0;
            $indi_ss01  = 0;
            $indi_scs01 = "";                        
            if( (float)$indi_as01 > 0 && (float)$indi_ms01 > 0 ){
                $indi_ps01 = ( (float)$indi_as01 / (float)$indi_ms01) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$indi_ps01 = 0 && (float)$indi_ps01 <= 49.9 ){
                     $indi_ss01  = 1;
                     $indi_scs01 = "ROJO";
                }else{    
                    if( (float)$indi_ps01 = 50 && (float)$indi_ps01 <= 69.9 ){
                        $indi_ss01  = 2;
                        $indi_scs01 = "NARANJA";
                    }else{    
                        if( (float)$indi_ps01 = 70 && (float)$indi_ps01 <= 89.9 ){
                            $indi_ss01  = 3;
                            $indi_scs01 = "AMARILLO";
                        }else{    
                            if( (float)$indi_ps01 = 90 && (float)$indi_ps01 <= 110 ){
                                 $indi_ss01  = 4;
                                 $indi_scs01 = "VERDE";
                            }else{    
                                if( (float)$indi_ps01 > 110 && (float)$indi_ps01 <= 300 ){
                                    $indi_ss01  = 5;
                                    $indi_scs01 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $indi_ps02  = 0;
            $indi_ss02  = 0;
            $indi_scs02 = "";            
            if( (float)$indi_as02 > 0 && (float)$indi_ms02 > 0 ){
                $indi_ps02 = ( (float)$indi_as02 / (float)$indi_ms02) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$indi_ps02 = 0 && (float)$indi_ps02 <= 49.9 ){
                     $indi_ss02  = 1;
                     $indi_scs02 = "ROJO";
                }else{    
                    if( (float)$indi_ps02 = 50 && (float)$indi_ps02 <= 69.9 ){
                        $indi_ss02  = 2;
                        $indi_scs02 = "NARANJA";
                    }else{    
                        if( (float)$indi_ps02 = 70 && (float)$indi_ps02 <= 89.9 ){
                            $indi_ss02  = 3;
                            $indi_scs02 = "AMARILLO";
                        }else{    
                            if( (float)$indi_ps02 = 90 && (float)$indi_ps02 <= 110 ){
                                 $indi_ss02  = 4;
                                 $indi_scs02 = "VERDE";
                            }else{    
                                if( (float)$indi_ps02 > 110 && (float)$indi_ps02 <= 300 ){
                                    $indi_ss02  = 5;
                                    $indi_scs02 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }

            //********** Calcula porcentales trimestrales ********************************//
            $indi_pt01  = 0;
            $indi_st01  = 0;
            $indi_sct01 = "";                        
            if( (float)$indi_at01 > 0 && (float)$indi_mt01 > 0 ){
                $indi_pt01 = ( (float)$indi_at01 / (float)$indi_mt01) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$indi_pt01 = 0 && (float)$indi_pt01 <= 49.9 ){
                     $indi_st01  = 1;
                     $indi_sct01 = "ROJO";
                }else{    
                    if( (float)$indi_pt01 = 50 && (float)$indi_pt01 <= 69.9 ){
                        $indi_st01  = 2;
                        $indi_sct01 = "NARANJA";
                    }else{    
                        if( (float)$indi_pt01 = 70 && (float)$indi_pt01 <= 89.9 ){
                            $indi_st01  = 3;
                            $indi_sct01 = "AMARILLO";
                        }else{    
                            if( (float)$indi_pt01 = 90 && (float)$indi_pt01 <= 110 ){
                                 $indi_st01  = 4;
                                 $indi_sct01 = "VERDE";
                            }else{    
                                if( (float)$indi_pt01 > 110 && (float)$indi_pt01 <= 300 ){
                                    $indi_st01  = 5;
                                    $indi_sct01 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $indi_pt02  = 0;
            $indi_st02  = 0;
            $indi_sct02 = "";                        
            if( (float)$indi_at02 > 0 && (float)$indi_mt02 > 0 ){
                $indi_pt02 = ( (float)$indi_at02 / (float)$indi_mt02) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$indi_pt02 = 0 && (float)$indi_pt02 <= 49.9 ){
                     $indi_st02  = 1;
                     $indi_sct02 = "ROJO";
                }else{    
                    if( (float)$indi_pt02 = 50 && (float)$indi_pt02 <= 69.9 ){
                        $indi_st02  = 2;
                        $indi_sct02 = "NARANJA";
                    }else{    
                        if( (float)$indi_pt02 = 70 && (float)$indi_pt02 <= 89.9 ){
                            $indi_st02  = 3;
                            $indi_sct02 = "AMARILLO";
                        }else{    
                            if( (float)$indi_pt02 = 90 && (float)$indi_pt02 <= 110 ){
                                 $indi_st02  = 4;
                                 $indi_sct02 = "VERDE";
                            }else{    
                                if( (float)$indi_pt02 > 110 && (float)$indi_pt02 <= 300 ){
                                    $indi_st02  = 5;
                                    $indi_sct02 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $indi_pt03  = 0;
            $indi_st03  = 0;
            $indi_sct03 = "";                        
            if( (float)$indi_at03 > 0 && (float)$indi_mt03 > 0 ){
                $indi_pt03 = ( (float)$indi_at03 / (float)$indi_mt03) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$indi_pt03 = 0 && (float)$indi_pt03 <= 49.9 ){
                     $indi_st03  = 1;
                     $indi_sct03 = "ROJO";
                }else{    
                    if( (float)$indi_pt03 = 50 && (float)$indi_pt03 <= 69.9 ){
                        $indi_st03  = 2;
                        $indi_sct03 = "NARANJA";
                    }else{    
                        if( (float)$indi_pt03 = 70 && (float)$indi_pt03 <= 89.9 ){
                            $indi_st03  = 3;
                            $indi_sct03 = "AMARILLO";
                        }else{    
                            if( (float)$indi_pt03 = 90 && (float)$indi_pt03 <= 110 ){
                                 $indi_st03  = 4;
                                 $indi_sct03 = "VERDE";
                            }else{    
                                if( (float)$indi_pt03 > 110 && (float)$indi_pt03 <= 300 ){
                                    $indi_st03  = 5;
                                    $indi_sct03 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $indi_pt04  = 0;
            $indi_st04  = 0;
            $indi_sct04 = "";            
            if( (float)$indi_at04 > 0 && (float)$indi_mt04 > 0 ){
                $indi_pt04 = ( (float)$indi_at04 / (float)$indi_mt04) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$indi_pt04 = 0 && (float)$indi_pt04 <= 49.9 ){
                     $indi_st04  = 1;
                     $indi_sct04 = "ROJO";
                }else{    
                    if( (float)$indi_pt04 = 50 && (float)$indi_pt04 <= 69.9 ){
                        $indi_st04  = 2;
                        $indi_sct04 = "NARANJA";
                    }else{    
                        if( (float)$indi_pt04 = 70 && (float)$indi_pt04 <= 89.9 ){
                            $indi_st04  = 3;
                            $indi_sct04 = "AMARILLO";
                        }else{    
                            if( (float)$indi_pt04 = 90 && (float)$indi_pt04 <= 110 ){
                                 $indi_st04  = 4;
                                 $indi_sct04 = "VERDE";
                            }else{    
                                if( (float)$indi_pt04 > 110 && (float)$indi_pt04 <= 300 ){
                                    $indi_st04  = 5;
                                    $indi_sct04 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }

            //********** Calcula porcentales mesuales ********************************//
            $indi_p01  = 0;
            $indi_s01  = 0;
            $indi_sc01 = "";                 
            if( (float)$indi_a01 > 0 && (float)$indi_m01 > 0 ){
                $indi_p01 = ( (float)$indi_a01 / (float)$indi_m01) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$indi_p01 = 0 && (float)$indi_p01 <= 49.9 ){
                     $indi_s01  = 1;
                     $indi_sc01 = "ROJO";
                }else{    
                    if( (float)$indi_p01 = 50 && (float)$indi_p01 <= 69.9 ){
                        $indi_s01  = 2;
                        $indi_sc01 = "NARANJA";
                    }else{    
                        if( (float)$indi_p01 = 70 && (float)$indi_p01 <= 89.9 ){
                            $indi_s01  = 3;
                            $indi_sc01 = "AMARILLO";
                        }else{    
                            if( (float)$indi_p01 = 90 && (float)$indi_p01 <= 110 ){
                                 $indi_s01  = 4;
                                 $indi_sc01 = "VERDE";
                            }else{    
                                if( (float)$indi_p01 > 110 && (float)$indi_p01 <= 300 ){
                                    $indi_s01  = 5;
                                    $indi_sc01 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $indi_p02  = 0;
            $indi_s02  = 0;
            $indi_sc02 = "";                 
            if( (float)$indi_a02 > 0 && (float)$indi_m02 > 0 ){
                $indi_p02 = ( (float)$indi_a02 / (float)$indi_m02) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$indi_p02 = 0 && (float)$indi_p02 <= 49.9 ){
                     $indi_s02  = 1;
                     $indi_sc02 = "ROJO";
                }else{    
                    if( (float)$indi_p02 = 50 && (float)$indi_p02 <= 69.9 ){
                        $indi_s02  = 2;
                        $indi_sc02 = "NARANJA";
                    }else{    
                        if( (float)$indi_p02 = 70 && (float)$indi_p02 <= 89.9 ){
                            $indi_s02  = 3;
                            $indi_sc02 = "AMARILLO";
                        }else{    
                            if( (float)$indi_p02 = 90 && (float)$indi_p02 <= 110 ){
                                 $indi_s02  = 4;
                                 $indi_sc02 = "VERDE";
                            }else{    
                                if( (float)$indi_p02 > 110 && (float)$indi_p02 <= 300 ){
                                    $indi_s02  = 5;
                                    $indi_sc02 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $indi_p03  = 0;
            $indi_s03  = 0;
            $indi_sc03 = "";                 
            if( (float)$indi_a03 > 0 && (float)$indi_m03 > 0 ){
                $indi_p03 = ( (float)$indi_a03 / (float)$indi_m03) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$indi_p03 = 0 && (float)$indi_p03 <= 49.9 ){
                     $indi_s03  = 1;
                     $indi_sc03 = "ROJO";
                }else{    
                    if( (float)$indi_p03 = 50 && (float)$indi_p03 <= 69.9 ){
                        $indi_s03  = 2;
                        $indi_sc03 = "NARANJA";
                    }else{    
                        if( (float)$indi_p03 = 70 && (float)$indi_p03 <= 89.9 ){
                            $indi_s03  = 3;
                            $indi_sc03 = "AMARILLO";
                        }else{    
                            if( (float)$indi_p03 = 90 && (float)$indi_p03 <= 110 ){
                                 $indi_s03  = 4;
                                 $indi_sc03 = "VERDE";
                            }else{    
                                if( (float)$indi_p03 > 110 && (float)$indi_p03 <= 300 ){
                                    $indi_s03  = 5;
                                    $indi_sc03 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $indi_p04  = 0;
            $indi_s04  = 0;
            $indi_sc04 = "";                 
            if( (float)$indi_a04 > 0 && (float)$indi_m04 > 0 ){
                $indi_p04 = ( (float)$indi_a04 / (float)$indi_m04) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$indi_p04 = 0 && (float)$indi_p04 <= 49.9 ){
                     $indi_s04  = 1;
                     $indi_sc04 = "ROJO";
                }else{    
                    if( (float)$indi_p04 = 50 && (float)$indi_p04 <= 69.9 ){
                        $indi_s04  = 2;
                        $indi_sc04 = "NARANJA";
                    }else{    
                        if( (float)$indi_p04 = 70 && (float)$indi_p04 <= 89.9 ){
                            $indi_s04  = 3;
                            $indi_sc04 = "AMARILLO";
                        }else{    
                            if( (float)$indi_p04 = 90 && (float)$indi_p04 <= 110 ){
                                 $indi_s04  = 4;
                                 $indi_sc04 = "VERDE";
                            }else{    
                                if( (float)$indi_p04 > 110 && (float)$indi_p04 <= 300 ){
                                    $indi_s04  = 5;
                                    $indi_sc04 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $indi_p05  = 0;
            $indi_s05  = 0;
            $indi_sc05 = "";                 
            if( (float)$indi_a05 > 0 && (float)$indi_m05 > 0 ){
                $indi_p05 = ( (float)$indi_a05 / (float)$indi_m05) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$indi_p05 = 0 && (float)$indi_p05 <= 49.9 ){
                     $indi_s05  = 1;
                     $indi_sc05 = "ROJO";
                }else{    
                    if( (float)$indi_p05 = 50 && (float)$indi_p05 <= 69.9 ){
                        $indi_s05  = 2;
                        $indi_sc05 = "NARANJA";
                    }else{    
                        if( (float)$indi_p05 = 70 && (float)$indi_p05 <= 89.9 ){
                            $indi_s05  = 3;
                            $indi_sc05 = "AMARILLO";
                        }else{    
                            if( (float)$indi_p05 = 90 && (float)$indi_p05 <= 110 ){
                                 $indi_s05  = 4;
                                 $indi_sc05 = "VERDE";
                            }else{    
                                if( (float)$indi_p05 > 110 && (float)$indi_p05 <= 300 ){
                                    $indi_s05  = 5;
                                    $indi_sc05 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $indi_p06  = 0;
            $indi_s06  = 0;
            $indi_sc06 = "";                 
            if( (float)$indi_a06 > 0 && (float)$indi_m06 > 0 ){
                $indi_p06 = ( (float)$indi_a06 / (float)$indi_m06) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$indi_p06 = 0 && (float)$indi_p06 <= 49.9 ){
                     $indi_s06  = 1;
                     $indi_sc06 = "ROJO";
                }else{    
                    if( (float)$indi_p06 = 50 && (float)$indi_p06 <= 69.9 ){
                        $indi_s06  = 2;
                        $indi_sc06 = "NARANJA";
                    }else{    
                        if( (float)$indi_p06 = 70 && (float)$indi_p06 <= 89.9 ){
                            $indi_s06  = 3;
                            $indi_sc06 = "AMARILLO";
                        }else{    
                            if( (float)$indi_p06 = 90 && (float)$indi_p06 <= 110 ){
                                 $indi_s06  = 4;
                                 $indi_sc06 = "VERDE";
                            }else{    
                                if( (float)$indi_p06 > 110 && (float)$indi_p06 <= 300 ){
                                    $indi_s06  = 5;
                                    $indi_sc06 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $indi_p07  = 0;
            $indi_s07  = 0;
            $indi_sc07 = "";                 
            if( (float)$indi_a07 > 0 && (float)$indi_m07 > 0 ){
                $indi_p07 = ( (float)$indi_a07 / (float)$indi_m07) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$indi_p07 = 0 && (float)$indi_p07 <= 49.9 ){
                     $indi_s07  = 1;
                     $indi_sc07 = "ROJO";
                }else{    
                    if( (float)$indi_p07 = 50 && (float)$indi_p07 <= 69.9 ){
                        $indi_s07  = 2;
                        $indi_sc07 = "NARANJA";
                    }else{    
                        if( (float)$indi_p07 = 70 && (float)$indi_p07 <= 89.9 ){
                            $indi_s07  = 3;
                            $indi_sc07 = "AMARILLO";
                        }else{    
                            if( (float)$indi_p07 = 90 && (float)$indi_p07 <= 110 ){
                                 $indi_s07  = 4;
                                 $indi_sc07 = "VERDE";
                            }else{    
                                if( (float)$indi_p07 > 110 && (float)$indi_p07 <= 300 ){
                                    $indi_s07  = 5;
                                    $indi_sc07 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $indi_p08  = 0;
            $indi_s08  = 0;
            $indi_sc08 = "";                 
            if( (float)$indi_a08 > 0 && (float)$indi_m08 > 0 ){
                $indi_p08 = ( (float)$indi_a08 / (float)$indi_m08) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$indi_p08 = 0 && (float)$indi_p08 <= 49.9 ){
                     $indi_s08  = 1;
                     $indi_sc08 = "ROJO";
                }else{    
                    if( (float)$indi_p08 = 50 && (float)$indi_p08 <= 69.9 ){
                        $indi_s08  = 2;
                        $indi_sc08 = "NARANJA";
                    }else{    
                        if( (float)$indi_p08 = 70 && (float)$indi_p08 <= 89.9 ){
                            $indi_s08  = 3;
                            $indi_sc08 = "AMARILLO";
                        }else{    
                            if( (float)$indi_p08 = 90 && (float)$indi_p08 <= 110 ){
                                 $indi_s08  = 4;
                                 $indi_sc08 = "VERDE";
                            }else{    
                                if( (float)$indi_p08 > 110 && (float)$indi_p08 <= 300 ){
                                    $indi_s08  = 5;
                                    $indi_sc08 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $indi_p09  = 0;
            $indi_s09  = 0;
            $indi_sc09 = "";            
            if( (float)$indi_a09 > 0 && (float)$indi_m09 > 0 ){
                $indi_p09 = ( (float)$indi_a09 / (float)$indi_m09) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$indi_p09 = 0 && (float)$indi_p09 <= 49.9 ){
                     $indi_s09  = 1;
                     $indi_sc09 = "ROJO";
                }else{    
                    if( (float)$indi_p09 = 50 && (float)$indi_p09 <= 69.9 ){
                        $indi_s09  = 2;
                        $indi_sc09 = "NARANJA";
                    }else{    
                        if( (float)$indi_p09 = 70 && (float)$indi_p09 <= 89.9 ){
                            $indi_s09  = 3;
                            $indi_sc09 = "AMARILLO";
                        }else{    
                            if( (float)$indi_p09 = 90 && (float)$indi_p09 <= 110 ){
                                 $indi_s09  = 4;
                                 $indi_sc09 = "VERDE";
                            }else{    
                                if( (float)$indi_p09 > 110 && (float)$indi_p09 <= 300 ){
                                    $indi_s09  = 5;
                                    $indi_sc09 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $indi_p10  = 0;
            $indi_s10  = 0;
            $indi_sc10 = "";            
            if( (float)$indi_a10 > 0 && (float)$indi_m10 > 0 ){
                $indi_p10 = ( (float)$indi_a10 / (float)$indi_m10) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$indi_p10 = 0 && (float)$indi_p10 <= 49.9 ){
                     $indi_s10  = 1;
                     $indi_sc10 = "ROJO";
                }else{    
                    if( (float)$indi_p10 = 50 && (float)$indi_p10 <= 69.9 ){
                        $indi_s10  = 2;
                        $indi_sc10 = "NARANJA";
                    }else{    
                        if( (float)$indi_p10 = 70 && (float)$indi_p10 <= 89.9 ){
                            $indi_s10  = 3;
                            $indi_sc10 = "AMARILLO";
                        }else{    
                            if( (float)$indi_p10 = 90 && (float)$indi_p10 <= 110 ){
                                 $indi_s10  = 4;
                                 $indi_sc10 = "VERDE";
                            }else{    
                                if( (float)$indi_p10 > 110 && (float)$indi_p10 <= 300 ){
                                    $indi_s10  = 5;
                                    $indi_sc10 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $indi_p11  = 0;
            $indi_s11  = 0;
            $indi_sc11 = "";
            if( (float)$indi_a11 > 0 && (float)$indi_m11 > 0 ){
                $indi_p11 = ( (float)$indi_a11 / (float)$indi_m11) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$indi_p11 = 0 && (float)$indi_p11 <= 49.9 ){
                     $indi_s11  = 1;
                     $indi_sc11 = "ROJO";
                }else{    
                    if( (float)$indi_p11 = 50 && (float)$indi_p11 <= 69.9 ){
                        $indi_s11  = 2;
                        $indi_sc11 = "NARANJA";
                    }else{    
                        if( (float)$indi_p11 = 70 && (float)$indi_p11 <= 89.9 ){
                            $indi_s11  = 3;
                            $indi_sc11 = "AMARILLO";
                        }else{    
                            if( (float)$indi_p11 = 90 && (float)$indi_p11 <= 110 ){
                                 $indi_s11  = 4;
                                 $indi_sc11 = "VERDE";
                            }else{    
                                if( (float)$indi_p11 > 110 && (float)$indi_p11 <= 300 ){
                                    $indi_s11  = 5;
                                    $indi_sc11 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $indi_p12  = 0;
            $indi_s12  = 0;
            $indi_sc12 = "";
            if( (float)$indi_a12 > 0 && (float)$indi_m12 > 0 ){
                $indi_p12 = ( (float)$indi_a12 / (float)$indi_m12) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$indi_p12 = 0 && (float)$indi_p12 <= 49.9 ){
                     $indi_s12  = 1;
                     $indi_sc12 = "ROJO";
                }else{    
                    if( (float)$indi_p12 = 50 && (float)$indi_p12 <= 69.9 ){
                        $indi_s12  = 2;
                        $indi_sc12 = "NARANJA";
                    }else{    
                        if( (float)$indi_p12 = 70 && (float)$indi_p12 <= 89.9 ){
                            $indi_s12  = 3;
                            $indi_sc12 = "AMARILLO";
                        }else{    
                            if( (float)$indi_p12 = 90 && (float)$indi_p12 <= 110 ){
                                 $indi_s12  = 4;
                                 $indi_sc12 = "VERDE";
                            }else{    
                                if( (float)$indi_p12 > 110 && (float)$indi_p12 <= 300 ){
                                    $indi_s12  = 5;
                                    $indi_sc12 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }


            //*********** Actualizarn items **********************
            $regindicador = regIndicadorModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'INDI_ID' => $id3])
                               ->update([                
                                         'INDI_AVANCE'  => $request->indi_avance,
                                         'INDI_A01'     => $indi_a01,
                                         'INDI_A02'     => $indi_a02,
                                         'INDI_A03'     => $indi_a03,
                                         'INDI_A04'     => $indi_a04,
                                         'INDI_A05'     => $indi_a05,
                                         'INDI_A06'     => $indi_a06,
                                         'INDI_A07'     => $indi_a07,
                                         'INDI_A08'     => $indi_a08,
                                         'INDI_A09'     => $indi_a09,
                                         'INDI_A10'     => $indi_a10,
                                         'INDI_A11'     => $indi_a11,
                                         'INDI_A12'     => $indi_a12,   
                                         'INDI_AT01'    => $indi_at01,
                                         'INDI_AT02'    => $indi_at02,
                                         'INDI_AT03'    => $indi_at03,
                                         'INDI_AT04'    => $indi_at04,
                                         'INDI_AS01'    => $indi_as01,
                                         'INDI_AS02'    => $indi_as02,
                                         'INDI_AA01'    => $indi_aa01,

                                         'INDI_P01'     => $indi_p01,
                                         'INDI_P02'     => $indi_p02,
                                         'INDI_P03'     => $indi_p03,
                                         'INDI_P04'     => $indi_p04,
                                         'INDI_P05'     => $indi_p05,
                                         'INDI_P06'     => $indi_p06,
                                         'INDI_P07'     => $indi_p07,
                                         'INDI_P08'     => $indi_p08,
                                         'INDI_P09'     => $indi_p09,
                                         'INDI_P10'     => $indi_p10,
                                         'INDI_P11'     => $indi_p11,
                                         'INDI_P12'     => $indi_p12,   
                                         'INDI_PT01'    => $indi_pt01,
                                         'INDI_PT02'    => $indi_pt02,
                                         'INDI_PT03'    => $indi_pt03,
                                         'INDI_PT04'    => $indi_pt04,
                                         'INDI_PS01'    => $indi_ps01,
                                         'INDI_PS02'    => $indi_ps02,
                                         'INDI_PA01'    => $indi_pa01,

                                         'INDI_S01'     => $indi_s01,
                                         'INDI_S02'     => $indi_s02,
                                         'INDI_S03'     => $indi_s03,
                                         'INDI_S04'     => $indi_s04,
                                         'INDI_S05'     => $indi_s05,
                                         'INDI_S06'     => $indi_s06,
                                         'INDI_S07'     => $indi_s07,
                                         'INDI_S08'     => $indi_s08,
                                         'INDI_S09'     => $indi_s09,
                                         'INDI_S10'     => $indi_s10,
                                         'INDI_S11'     => $indi_s11,
                                         'INDI_S12'     => $indi_s12,   
                                         'INDI_ST01'    => $indi_st01,
                                         'INDI_ST02'    => $indi_st02,
                                         'INDI_ST03'    => $indi_st03,
                                         'INDI_ST04'    => $indi_st04,
                                         'INDI_SS01'    => $indi_ss01,
                                         'INDI_SS02'    => $indi_ss02,
                                         'INDI_SA01'    => $indi_sa01,                                         

                                         'INDI_SC01'    => $indi_sc01,
                                         'INDI_SC02'    => $indi_sc02,
                                         'INDI_SC03'    => $indi_sc03,
                                         'INDI_SC04'    => $indi_sc04,
                                         'INDI_SC05'    => $indi_sc05,
                                         'INDI_SC06'    => $indi_sc06,
                                         'INDI_SC07'    => $indi_sc07,
                                         'INDI_SC08'    => $indi_sc08,
                                         'INDI_SC09'    => $indi_sc09,
                                         'INDI_SC10'    => $indi_sc10,
                                         'INDI_SC11'    => $indi_sc11,
                                         'INDI_SC12'    => $indi_sc12,   
                                         'INDI_SCT01'   => $indi_sct01,
                                         'INDI_SCT02'   => $indi_sct02,
                                         'INDI_SCT03'   => $indi_sct03,
                                         'INDI_SCT04'   => $indi_sct04,
                                         'INDI_SCS01'   => $indi_scs01,
                                         'INDI_SCS02'   => $indi_scs02,
                                         'INDI_SCA01'   => $indi_sca01, 

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
            $xtrx_id      =        63;    //Actualizar 
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
        return redirect()->route('verindiavan');
    }

    public function actionBorrarIndiavan($id, $id2, $id3){
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
        $regindicador = regIndicadorModel::select('PERIODO_ID','PROG_ID','INDI_ID',
                        'INDI_DESC','INDI_FORMULA','ICLASE_ID','ITIPO_ID','IDIMENSION_ID', 
                        'INDI_META','INDI_AVANCE',
                        'INDI_M01','INDI_M02','INDI_M03','INDI_M04','INDI_M05','INDI_M06',
                        'INDI_M07','INDI_M08','INDI_M09','INDI_M10','INDI_M11','INDI_M12',
                        'INDI_MT01','INDI_MT02','INDI_MT03','INDI_MT04','INDI_MS01','INDI_MS02','INDI_MA01',
                        'INDI_A01','INDI_A02','INDI_A03','INDI_A04','INDI_A05','INDI_A06',
                        'INDI_A07','INDI_A08','INDI_A09','INDI_A10','INDI_A11','INDI_A12',
                        'INDI_AT01','INDI_AT02','INDI_AT03','INDI_AT04','INDI_AS01','INDI_AS02','INDI_AA01'
                        )
                         ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'INDI_ID' => $id3]);
        if($regfinan->count() <= 0)
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
            $xtrx_id      =        64;     // Baja 

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
        return redirect()->route('verindiavan');
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
        $xtrx_id      =        65;            // Exportar a formato Excel
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
        $xtrx_id      =        66;       //Exportar a formato PDF
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

        $regindicador  = regIndicadorModel::select('PROG_ID','PROG_DESC','PROG_SIGLAS','PROG_VIGENTE', 
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
