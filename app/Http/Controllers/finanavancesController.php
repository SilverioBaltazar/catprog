<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\finanavancesRequest;

use App\regPeriodosModel;
use App\regFuentesfinanModel;
use App\regProgramasModel;
use App\regFinanModel;
use App\regBitacoraModel;

// Exportar a excel 
//use App\Exports\ExcelExportProg;
use Maatwebsite\Excel\Facades\Excel;
// Exportar a pdf
use PDF;
//use Options;

class finanavancesController extends Controller
{

    public function actionBuscarFinanavances(Request $request)
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

        $regfuentefinan = regFuentesfinanModel::select('FTEFINAN_ID','FTEFINAN_DESC')
                          ->orderBy('FTEFINAN_DESC','asc')
                          ->get();     
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
            $regfinan = regFinanModel::orderBy('PROG_ID', 'ASC')
                       ->name($name)           //Metodos personalizados es equvalente a ->where('IAP_DESC', 'LIKE', "%$name%");
                       //->email($email)         //Metodos personalizados
                       //->bio($bio)             //Metodos personalizados
                       ->paginate(50);
        }else{           
            $regfinan = regFinanModel::where('PROG_ID',$codigo)
                       ->orderBy('PROG_ID', 'ASC')
                       ->name($name)           //Metodos personalizados es equvalente a ->where('IAP_DESC', 'LIKE', "%$name%");
                       //->email($email)         //Metodos personalizados
                       //->bio($bio)             //Metodos personalizados
                       ->paginate(50);          
        }
        if($regfinan->count() <= 0){
            toastr()->error('No existen fuentes de financiamiento','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }            
        return view('sicinar.financiamiento.verFinanavances', compact('nombre','usuario','codigo','regprogramas','regfuentefinan','regperiodos','regfinan'));
    }

    public function actionVerFinanavances(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $codigo       = session()->get('codigo');         

        $regfuentefinan = regFuentesfinanModel::select('FTEFINAN_ID','FTEFINAN_DESC')
                          ->orderBy('FTEFINAN_DESC','asc')
                          ->get();        
        $regprogramas   = regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->orderBy('PROG_ID','asc')
                          ->get();                                    
        if(session()->get('rango') !== '0'){                                                       
            $regfinan=regFinanModel::join('CP_CAT_FUENTES_FINAN','CP_CAT_FUENTES_FINAN.FTEFINAN_ID', '=', 
                                                                 'CP_FINANCIAMIENTO.FTEFINAN_ID')
                             ->select('CP_FINANCIAMIENTO.PERIODO_ID',
                                      'CP_FINANCIAMIENTO.PROG_ID',
                                      'CP_FINANCIAMIENTO.FTEFINAN_ID',
                                      'CP_CAT_FUENTES_FINAN.FTEFINAN_DESC',
                                      'CP_FINANCIAMIENTO.FINAN_META',
                                      'CP_FINANCIAMIENTO.FINAN_M01', 
                                      'CP_FINANCIAMIENTO.FINAN_M02',
                                      'CP_FINANCIAMIENTO.FINAN_M03',
                                      'CP_FINANCIAMIENTO.FINAN_M04',
                                      'CP_FINANCIAMIENTO.FINAN_M05',
                                      'CP_FINANCIAMIENTO.FINAN_M06', 
                                      'CP_FINANCIAMIENTO.FINAN_M07',
                                      'CP_FINANCIAMIENTO.FINAN_M08',
                                      'CP_FINANCIAMIENTO.FINAN_M09',
                                      'CP_FINANCIAMIENTO.FINAN_M10', 
                                      'CP_FINANCIAMIENTO.FINAN_M11',
                                      'CP_FINANCIAMIENTO.FINAN_M12',
                                      'CP_FINANCIAMIENTO.FINAN_AVANCE', 
                                      'CP_FINANCIAMIENTO.FINAN_A01', 
                                      'CP_FINANCIAMIENTO.FINAN_A02',
                                      'CP_FINANCIAMIENTO.FINAN_A03',
                                      'CP_FINANCIAMIENTO.FINAN_A04',
                                      'CP_FINANCIAMIENTO.FINAN_A05',
                                      'CP_FINANCIAMIENTO.FINAN_A06', 
                                      'CP_FINANCIAMIENTO.FINAN_A07',
                                      'CP_FINANCIAMIENTO.FINAN_A08',
                                      'CP_FINANCIAMIENTO.FINAN_A09',
                                      'CP_FINANCIAMIENTO.FINAN_A10', 
                                      'CP_FINANCIAMIENTO.FINAN_A11',
                                      'CP_FINANCIAMIENTO.FINAN_A12'
                                      )
                         ->orderBy('CP_FINANCIAMIENTO.PERIODO_ID','DESC')
                         ->orderBy('CP_FINANCIAMIENTO.PROG_ID'   ,'DESC')
                         ->paginate(50);
        }else{           
            $regfinan=regFinanModel::join('CP_CAT_FUENTES_FINAN','CP_CAT_FUENTES_FINAN.FTEFINAN_ID', '=', 
                                                                 'CP_FINANCIAMIENTO.FTEFINAN_ID')
                             ->select( 'CP_FINANCIAMIENTO.PERIODO_ID',
                                       'CP_FINANCIAMIENTO.PROG_ID',
                                       'CP_FINANCIAMIENTO.FTEFINAN_ID',
                                       'CP_CAT_FUENTES_FINAN.FTEFINAN_DESC',
                                       'CP_FINANCIAMIENTO.FINAN_META',
                                       'CP_FINANCIAMIENTO.FINAN_M01', 
                                       'CP_FINANCIAMIENTO.FINAN_M02',
                                       'CP_FINANCIAMIENTO.FINAN_M03',
                                       'CP_FINANCIAMIENTO.FINAN_M04',
                                       'CP_FINANCIAMIENTO.FINAN_M05',
                                       'CP_FINANCIAMIENTO.FINAN_M06', 
                                       'CP_FINANCIAMIENTO.FINAN_M07',
                                       'CP_FINANCIAMIENTO.FINAN_M08',
                                       'CP_FINANCIAMIENTO.FINAN_M09',
                                       'CP_FINANCIAMIENTO.FINAN_M10', 
                                       'CP_FINANCIAMIENTO.FINAN_M11',
                                       'CP_FINANCIAMIENTO.FINAN_M12',
                                       'CP_FINANCIAMIENTO.FINAN_AVANCE', 
                                       'CP_FINANCIAMIENTO.FINAN_A01', 
                                       'CP_FINANCIAMIENTO.FINAN_A02',
                                       'CP_FINANCIAMIENTO.FINAN_A03',
                                       'CP_FINANCIAMIENTO.FINAN_A04',
                                       'CP_FINANCIAMIENTO.FINAN_A05',
                                       'CP_FINANCIAMIENTO.FINAN_A06', 
                                       'CP_FINANCIAMIENTO.FINAN_A07',
                                       'CP_FINANCIAMIENTO.FINAN_A08',
                                       'CP_FINANCIAMIENTO.FINAN_A09',
                                       'CP_FINANCIAMIENTO.FINAN_A10', 
                                       'CP_FINANCIAMIENTO.FINAN_A11',
                                       'CP_FINANCIAMIENTO.FINAN_A12'                                       
                                      )
                             ->where(  'CP_FINANCIAMIENTO.PROG_ID'   ,$codigo)                             
                            ->orderBy( 'CP_FINANCIAMIENTO.PERIODO_ID','DESC')
                            ->orderBy( 'CP_FINANCIAMIENTO.PROG_ID'   ,'DESC')
                            ->paginate(50);          
        }                         
        if($regfinan->count() <= 0){
            toastr()->error('No existen fuentes de financiamiento','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.financiamiento.verFinanavances',compact('nombre','usuario','codigo','regprogramas','regfuentefinan','regfinan'));
    }

    public function actionNuevoFinanavances(){
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
        $regfuentefinan=regFuentesfinanModel::select('FTEFINAN_ID','FTEFINAN_DESC')
                        ->orderBy('FTEFINAN_DESC','asc')
                        ->get(); 
        $regprogramas = regProgramasModel::select('PROG_ID','PROG_DESC')
                        ->orderBy('PROG_ID','asc')
                        ->get();                                    
        $regfinan     = regFinanModel::select('PERIODO_ID','PROG_ID','FTEFINAN_ID','FINAN_META','FINAN_AVANCE',
                        'FINAN_M01','FINAN_M02','FINAN_M03','FINAN_M04','FINAN_M05','FINAN_M06',
                        'FINAN_M07','FINAN_M08','FINAN_M09','FINAN_M10','FINAN_M11','FINAN_M12',
                        'FINAN_MT01','FINAN_MT02','FINAN_MT03','FINAN_MT04','FINAN_MS01','FINAN_MS02','FINAN_MA01',
                        'FINAN_A01','FINAN_A02','FINAN_A03','FINAN_A04','FINAN_A05','FINAN_A06',
                        'FINAN_A07','FINAN_A08','FINAN_A09','FINAN_A10','FINAN_A11','FINAN_A12',
                        'FINAN_AT01','FINAN_AT02','FINAN_AT03','FINAN_AT04','FINAN_AS01','FINAN_AS02','FINAN_AA01'
                        )
                         ->orderBy('PERIODO_ID','asc')
                         ->orderBy('PROG_ID'   ,'asc')
                         ->get();
        //dd($unidades);
        return view('sicinar.financiamiento.nuevoFinanavances',compact('nombre','usuario','codigo','regprogramas','regfuentefinan','regperiodos','regfinan'));
    }

    public function actionAltaNuevoFinanavances(Request $request){
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
        $regfinan = regFinanModel::where(['PERIODO_ID' => $request->periodo_id,
                                          'PROG_ID'    => $request->prog_id,
                                          'FTEFINAN_ID'=> $request->ftefinan_id]);
        if($regfinan->count() > 0)
            toastr()->error('Ya existe la fuente de financiamiento.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{   
            //*********** Calculamos valores ************************//
            $finan_m01 = 0;
            if(isset($request->finan_m01)){
                if(!empty($request->finan_m01)) 
                    $finan_m01 = (float)$request->finan_m01;
            }          
            $finan_m02 = 0;
            if(isset($request->finan_m02)){
                if(!empty($request->finan_m02)) 
                    $finan_m02 = (float)$request->finan_m02;
            }  
            $finan_m03 = 0;
            if(isset($request->finan_m03)){
                if(!empty($request->finan_m03)) 
                    $finan_m03 = (float)$request->finan_m03;
            }  
            $finan_m04 = 0;
            if(isset($request->finan_m04)){
                if(!empty($request->finan_m04)) 
                    $finan_m04 = (float)$request->finan_m04;
            }  
            $finan_m05 = 0;
            if(isset($request->finan_m05)){
                if(!empty($request->finan_m05)) 
                    $finan_m05 = (float)$request->finan_m05;
            }                                                  
            $finan_m06 = 0;
            if(isset($request->finan_m06)){
                if(!empty($request->finan_m06)) 
                    $finan_m06 = (float)$request->finan_m06;
            }               
            $finan_m07 = 0;
            if(isset($request->finan_m07)){
                if(!empty($request->finan_m07)) 
                    $finan_m07 = (float)$request->finan_m07;
            }          
            $finan_m08 = 0;
            if(isset($request->finan_m08)){
                if(!empty($request->finan_m08)) 
                    $finan_m08 = (float)$request->finan_m08;
            }  
            $finan_m09 = 0;
            if(isset($request->finan_m09)){
                if(!empty($request->finan_m09)) 
                    $finan_m09 = (float)$request->finan_m09;
            }  
            $finan_m10 = 0;
            if(isset($request->finan_m10)){
                if(!empty($request->finan_m10)) 
                    $finan_m10 = (float)$request->finan_m10;
            }  
            $finan_m11 = 0;
            if(isset($request->finan_m11)){
                if(!empty($request->finan_m11)) 
                    $finan_m11 = (float)$request->finan_m11;
            }                                                  
            $finan_m12 = 0;
            if(isset($request->finan_m12)){
                if(!empty($request->finan_m12)) 
                    $finan_m12 = (float)$request->finan_m12;
            }                           
            $finan_mt01 = (float)$finan_m01 + (float)$finan_m02 + (float)$finan_m03;
            $finan_mt02 = (float)$finan_m04 + (float)$finan_m05 + (float)$finan_m06;
            $finan_mt03 = (float)$finan_m07 + (float)$finan_m08 + (float)$finan_m09;
            $finan_mt04 = (float)$finan_m10 + (float)$finan_m11 + (float)$finan_m12;

            $finan_ms01 =(float)$finan_m01+(float)$finan_m02+(float)$finan_m03+(float)$finan_m04+(float)$finan_m05+(float)$finan_m06;
            $finan_ms02 =(float)$finan_m07+(float)$finan_m08+(float)$finan_m09+(float)$finan_m10+(float)$finan_m11+(float)$finan_m12;            

            $finan_ma01  = (float)$finan_ms01 + (float)$finan_ms02;             

            /********************** Alta  *****************************/ 
            //$iid = regFinanModel::count(*);
            //$iid = $iid + 1;
            $nuevaiap = new regFinanModel();
            $name1 =null;
            //Comprobar  si el campo foto1 tiene un archivo asignado:
            if($request->hasFile('osc_foto1')){
               $name1 = $osc_id.'_'.$request->file('osc_foto1')->getClientOriginalName(); 
               $request->file('osc_foto1')->move(public_path().'/images/', $name1);
            }
 
            $nuevaiap->PERIODO_ID      = $request->periodo_id;
            $nuevaiap->PROG_ID         = $request->prog_id;
            $nuevaiap->FTEFINAN_ID     = $request->ftefinan_id;
            $nuevaiap->FINAN_META      = $request->finan_meta;
            $nuevaiap->FINAN_M01       = $finan_m01;
            $nuevaiap->FINAN_M02       = $finan_m02;
            $nuevaiap->FINAN_M03       = $finan_m03;
            $nuevaiap->FINAN_M04       = $finan_m04;
            $nuevaiap->FINAN_M05       = $finan_m05;
            $nuevaiap->FINAN_M06       = $finan_m06;
            $nuevaiap->FINAN_M07       = $finan_m07;
            $nuevaiap->FINAN_M08       = $finan_m08;
            $nuevaiap->FINAN_M09       = $finan_m09;
            $nuevaiap->FINAN_M10       = $finan_m10;
            $nuevaiap->FINAN_M11       = $finan_m11;
            $nuevaiap->FINAN_M12       = $finan_m12;

            $nuevaiap->FINAN_MT01      = $finan_mt01;
            $nuevaiap->FINAN_MT02      = $finan_mt02;
            $nuevaiap->FINAN_MT03      = $finan_mt03;
            $nuevaiap->FINAN_MT04      = $finan_mt04;
            $nuevaiap->FINAN_MS01      = $finan_ms01;
            $nuevaiap->FINAN_MS02      = $finan_ms02;
            $nuevaiap->FINAN_MA01      = $finan_ma01;

            $nuevaiap->IP              = $ip;
            $nuevaiap->LOGIN           = $nombre;         // Usuario ;
            //dd($nuevaiap);
            $nuevaiap->save();
            if($nuevaiap->save() == true){
                toastr()->success('fuente de financiamiento dada de alta.','ok!',['positionClass' => 'toast-bottom-right']);

                /************ Bitacora inicia *************************************/ 
                setlocale(LC_TIME, "spanish");        
                $xip          = session()->get('ip');
                $xperiodo_id  = (int)date('Y');
                $xprograma_id = 1;
                $xmes_id      = (int)date('m');
                $xproceso_id  =         3;
                $xfuncion_id  =      3001;
                $xtrx_id      =        22;    //Alta
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
                        toastr()->success('Trx de fuente de financiamiento dada de alta en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                    else
                        toastr()->error('Error de trx de fuente de financiamiento en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
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
                    toastr()->success('Trx de fuente de financiamiento actualizado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                }   /************ Bitacora termina *************************************/ 
            }else{
                toastr()->error('Error de trx de fuente de financiamiento. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }
        }
        return redirect()->route('verfinanmetas');
    }

    public function actionEditarFinanavances($id, $id2, $id3){
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
        $regfuentefinan=regFuentesfinanModel::select('FTEFINAN_ID','FTEFINAN_DESC')
                        ->orderBy('FTEFINAN_DESC','asc')
                        ->get(); 
        $regprogramas = regProgramasModel::select('PROG_ID','PROG_DESC')
                        ->orderBy('PROG_ID','asc')
                        ->get();                                 
        $regfinan     = regFinanModel::select('PERIODO_ID','PROG_ID','FTEFINAN_ID','FINAN_META','FINAN_AVANCE',
                        'FINAN_M01','FINAN_M02','FINAN_M03','FINAN_M04','FINAN_M05','FINAN_M06',
                        'FINAN_M07','FINAN_M08','FINAN_M09','FINAN_M10','FINAN_M11','FINAN_M12',
                        'FINAN_MT01','FINAN_MT02','FINAN_MT03','FINAN_MT04','FINAN_MS01','FINAN_MS02','FINAN_MA01',
                        'FINAN_A01','FINAN_A02','FINAN_A03','FINAN_A04','FINAN_A05','FINAN_A06',
                        'FINAN_A07','FINAN_A08','FINAN_A09','FINAN_A10','FINAN_A11','FINAN_A12',
                        'FINAN_AT01','FINAN_AT02','FINAN_AT03','FINAN_AT04','FINAN_AS01','FINAN_AS02','FINAN_AA01',
                        'FINAN_P01','FINAN_P02','FINAN_P03','FINAN_P04','FINAN_P05','FINAN_P06',
                        'FINAN_P07','FINAN_P08','FINAN_P09','FINAN_P10','FINAN_P11','FINAN_P12',
                        'FINAN_PT01','FINAN_PT02','FINAN_PT03','FINAN_PT04','FINAN_PS01','FINAN_PS02','FINAN_PA01',
                        'FINAN_S01','FINAN_S02','FINAN_S03','FINAN_S04','FINAN_S05','FINAN_S06',
                        'FINAN_S07','FINAN_S08','FINAN_S09','FINAN_S10','FINAN_S11','FINAN_S12',
                        'FINAN_ST01','FINAN_ST02','FINAN_ST03','FINAN_ST04','FINAN_SS01','FINAN_SS02','FINAN_SA01',
                        'FINAN_SC01','FINAN_SC02','FINAN_SC03','FINAN_SC04','FINAN_SC05','FINAN_SC06',
                        'FINAN_SC07','FINAN_SC08','FINAN_SC09','FINAN_SC10','FINAN_SC11','FINAN_SC12',
                        'FINAN_SCT01','FINAN_SCT02','FINAN_SCT03','FINAN_SCT04','FINAN_SCS01','FINAN_SCS02','FINAN_SCA01'
                        )
                         ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'FTEFINAN_ID' => $id3])
                         ->first();
        //dd($id,'segundo.....'.$id2, $regfinan->count() );
        if($regfinan->count() <= 0){
            toastr()->error('No existe fuente de financiamiento.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.financiamiento.editarFinanavances',compact('nombre','usuario','codigo','regprogramas','regfuentefinan','regperiodos','regfinan'));
    }

    public function actionActualizarFinanavances(finanavancesRequest $request, $id, $id2, $id3){
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
        $regfinan = regFinanModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'FTEFINAN_ID' => $id3]);
        //dd('hola.....',$regfinan);
        if($regfinan->count() <= 0)
            toastr()->error('No existe fuente de financiamiento.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            //************ Obtiene valores programados **********//
            $mesesp  = regFinanModel::obtmesesprog($id, $id2, $id3);       

            $finan_meta = $mesesp[0]->finan_meta; 

            $finan_m01  = $mesesp[0]->finan_m01;    
            $finan_m02  = $mesesp[0]->finan_m02;    
            $finan_m03  = $mesesp[0]->finan_m03;    
            $finan_m04  = $mesesp[0]->finan_m04;    
            $finan_m05  = $mesesp[0]->finan_m05;    
            $finan_m06  = $mesesp[0]->finan_m06;    
            $finan_m07  = $mesesp[0]->finan_m07;    
            $finan_m08  = $mesesp[0]->finan_m08;    
            $finan_m09  = $mesesp[0]->finan_m09;    
            $finan_m10  = $mesesp[0]->finan_m10;    
            $finan_m11  = $mesesp[0]->finan_m11;    
            $finan_m12  = $mesesp[0]->finan_m12;  
 
            $finan_mt01 = $mesesp[0]->finan_mt01;    
            $finan_mt02 = $mesesp[0]->finan_mt02;    
            $finan_mt03 = $mesesp[0]->finan_mt03;    
            $finan_mt04 = $mesesp[0]->finan_mt04;

            $finan_ms01 = $mesesp[0]->finan_ms01;    
            $finan_ms02 = $mesesp[0]->finan_ms02;    

            $finan_ma01 = $mesesp[0]->finan_ma01;    

            //$totp_02  = $mesesp[0]->totp_02;    

            //*********** Calculamos valores ************************
            $finan_avance = 0;
            if(isset($request->finan_avance)){
                if(!empty($request->finan_avance)) 
                    $finan_avance = (float)$request->finan_avance;
            }          
            $finan_a01 = 0;
            if(isset($request->finan_a01)){
                if(!empty($request->finan_a01)) 
                    $finan_a01 = (float)$request->finan_a01;
            }                      
            $finan_a02 = 0;
            if(isset($request->finan_a02)){
                if(!empty($request->finan_a02)) 
                    $finan_a02 = (float)$request->finan_a02;
            }  
            $finan_a03 = 0;
            if(isset($request->finan_a03)){
                if(!empty($request->finan_a03)) 
                    $finan_a03 = (float)$request->finan_a03;
            }  
            $finan_a04 = 0;
            if(isset($request->finan_a04)){
                if(!empty($request->finan_a04)) 
                    $finan_a04 = (float)$request->finan_a04;
            }  
            $finan_a05 = 0;
            if(isset($request->finan_a05)){
                if(!empty($request->finan_a05)) 
                    $finan_a05 = (float)$request->finan_a05;
            }                                                  
            $finan_a06 = 0;
            if(isset($request->finan_a06)){
                if(!empty($request->finan_a06)) 
                    $finan_a06 = (float)$request->finan_a06;
            }               
            $finan_a07 = 0;
            if(isset($request->finan_a07)){
                if(!empty($request->finan_a07)) 
                    $finan_a07 = (float)$request->finan_a07;
            }          
            $finan_a08 = 0;
            if(isset($request->finan_a08)){
                if(!empty($request->finan_a08)) 
                    $finan_a08 = (float)$request->finan_a08;
            }  
            $finan_a09 = 0;
            if(isset($request->finan_a09)){
                if(!empty($request->finan_a09)) 
                    $finan_a09 = (float)$request->finan_a09;
            }  
            $finan_a10 = 0;
            if(isset($request->finan_a10)){
                if(!empty($request->finan_a10)) 
                    $finan_a10 = (float)$request->finan_a10;
            }  
            $finan_a11 = 0;
            if(isset($request->finan_a11)){
                if(!empty($request->finan_a11)) 
                    $finan_a11 = (float)$request->finan_a11;
            }                                                  
            $finan_a12 = 0;
            if(isset($request->finan_a12)){
                if(!empty($request->finan_a12)) 
                    $finan_a12 = (float)$request->finan_a12;
            }                           
            $finan_at01 = (float)$finan_a01 + (float)$finan_a02 + (float)$finan_a03;
            $finan_at02 = (float)$finan_a04 + (float)$finan_a05 + (float)$finan_a06;
            $finan_at03 = (float)$finan_a07 + (float)$finan_a08 + (float)$finan_a09;
            $finan_at04 = (float)$finan_a10 + (float)$finan_a11 + (float)$finan_a12;

            $finan_as01 = (float)$finan_at01 + (float)$finan_at02;
            $finan_as02 = (float)$finan_at03 + (float)$finan_at04;            

            $finan_aa01 = (float)$finan_as01 + (float)$finan_as02; 
            
            //********** Calcula porcentaje anual ********************************//
            $finan_pa01  = 0;
            $finan_sa01  = 0;
            $finan_sca01 = "";            
            if( (float)$finan_avance > 0 && (float)$finan_meta > 0 ){
                $finan_pa01  =( (float)$finan_avance / (float)$finan_meta) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$finan_pa01 = 0 && (float)$finan_pa01 <= 49.9 ){
                     $finan_sa01  = 1;
                     $finan_sca01 = "ROJO";
                }else{    
                    if( (float)$finan_pa01 = 50 && (float)$finan_pa01 <= 69.9 ){
                        $finan_sa01  = 2;
                        $finan_sca01 = "NARANJA";
                    }else{    
                        if( (float)$finan_pa01 = 70 && (float)$finan_pa01 <= 89.9 ){
                            $finan_sa01  = 3;
                            $finan_sca01 = "AMARILLO";
                        }else{    
                            if( (float)$finan_pa01 = 90 && (float)$finan_pa01 <= 110 ){
                                 $finan_sa01  = 4;
                                 $finan_sca01 = "VERDE";
                            }else{    
                                if( (float)$finan_pa01 > 110 && (float)$finan_pa01 <= 300 ){
                                    $finan_sa01  = 5;
                                    $finan_sca01 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }

            //********** Calcula porcentales semestrales ********************************//
            $finan_ps01  = 0;
            $finan_ss01  = 0;
            $finan_scs01 = "";                        
            if( (float)$finan_as01 > 0 && (float)$finan_ms01 > 0 ){
                $finan_ps01 = ( (float)$finan_as01 / (float)$finan_ms01) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$finan_ps01 = 0 && (float)$finan_ps01 <= 49.9 ){
                     $finan_ss01  = 1;
                     $finan_scs01 = "ROJO";
                }else{    
                    if( (float)$finan_ps01 = 50 && (float)$finan_ps01 <= 69.9 ){
                        $finan_ss01  = 2;
                        $finan_scs01 = "NARANJA";
                    }else{    
                        if( (float)$finan_ps01 = 70 && (float)$finan_ps01 <= 89.9 ){
                            $finan_ss01  = 3;
                            $finan_scs01 = "AMARILLO";
                        }else{    
                            if( (float)$finan_ps01 = 90 && (float)$finan_ps01 <= 110 ){
                                 $finan_ss01  = 4;
                                 $finan_scs01 = "VERDE";
                            }else{    
                                if( (float)$finan_ps01 > 110 && (float)$finan_ps01 <= 300 ){
                                    $finan_ss01  = 5;
                                    $finan_scs01 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $finan_ps02  = 0;
            $finan_ss02  = 0;
            $finan_scs02 = "";            
            if( (float)$finan_as02 > 0 && (float)$finan_ms02 > 0 ){
                $finan_ps02 = ( (float)$finan_as02 / (float)$finan_ms02) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$finan_ps02 = 0 && (float)$finan_ps02 <= 49.9 ){
                     $finan_ss02  = 1;
                     $finan_scs02 = "ROJO";
                }else{    
                    if( (float)$finan_ps02 = 50 && (float)$finan_ps02 <= 69.9 ){
                        $finan_ss02  = 2;
                        $finan_scs02 = "NARANJA";
                    }else{    
                        if( (float)$finan_ps02 = 70 && (float)$finan_ps02 <= 89.9 ){
                            $finan_ss02  = 3;
                            $finan_scs02 = "AMARILLO";
                        }else{    
                            if( (float)$finan_ps02 = 90 && (float)$finan_ps02 <= 110 ){
                                 $finan_ss02  = 4;
                                 $finan_scs02 = "VERDE";
                            }else{    
                                if( (float)$finan_ps02 > 110 && (float)$finan_ps02 <= 300 ){
                                    $finan_ss02  = 5;
                                    $finan_scs02 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }

            //********** Calcula porcentales trimestrales ********************************//
            $finan_pt01  = 0;
            $finan_st01  = 0;
            $finan_sct01 = "";                        
            if( (float)$finan_at01 > 0 && (float)$finan_mt01 > 0 ){
                $finan_pt01 = ( (float)$finan_at01 / (float)$finan_mt01) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$finan_pt01 = 0 && (float)$finan_pt01 <= 49.9 ){
                     $finan_st01  = 1;
                     $finan_sct01 = "ROJO";
                }else{    
                    if( (float)$finan_pt01 = 50 && (float)$finan_pt01 <= 69.9 ){
                        $finan_st01  = 2;
                        $finan_sct01 = "NARANJA";
                    }else{    
                        if( (float)$finan_pt01 = 70 && (float)$finan_pt01 <= 89.9 ){
                            $finan_st01  = 3;
                            $finan_sct01 = "AMARILLO";
                        }else{    
                            if( (float)$finan_pt01 = 90 && (float)$finan_pt01 <= 110 ){
                                 $finan_st01  = 4;
                                 $finan_sct01 = "VERDE";
                            }else{    
                                if( (float)$finan_pt01 > 110 && (float)$finan_pt01 <= 300 ){
                                    $finan_st01  = 5;
                                    $finan_sct01 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $finan_pt02  = 0;
            $finan_st02  = 0;
            $finan_sct02 = "";                        
            if( (float)$finan_at02 > 0 && (float)$finan_mt02 > 0 ){
                $finan_pt02 = ( (float)$finan_at02 / (float)$finan_mt02) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$finan_pt02 = 0 && (float)$finan_pt02 <= 49.9 ){
                     $finan_st02  = 1;
                     $finan_sct02 = "ROJO";
                }else{    
                    if( (float)$finan_pt02 = 50 && (float)$finan_pt02 <= 69.9 ){
                        $finan_st02  = 2;
                        $finan_sct02 = "NARANJA";
                    }else{    
                        if( (float)$finan_pt02 = 70 && (float)$finan_pt02 <= 89.9 ){
                            $finan_st02  = 3;
                            $finan_sct02 = "AMARILLO";
                        }else{    
                            if( (float)$finan_pt02 = 90 && (float)$finan_pt02 <= 110 ){
                                 $finan_st02  = 4;
                                 $finan_sct02 = "VERDE";
                            }else{    
                                if( (float)$finan_pt02 > 110 && (float)$finan_pt02 <= 300 ){
                                    $finan_st02  = 5;
                                    $finan_sct02 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $finan_pt03  = 0;
            $finan_st03  = 0;
            $finan_sct03 = "";                        
            if( (float)$finan_at03 > 0 && (float)$finan_mt03 > 0 ){
                $finan_pt03 = ( (float)$finan_at03 / (float)$finan_mt03) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$finan_pt03 = 0 && (float)$finan_pt03 <= 49.9 ){
                     $finan_st03  = 1;
                     $finan_sct03 = "ROJO";
                }else{    
                    if( (float)$finan_pt03 = 50 && (float)$finan_pt03 <= 69.9 ){
                        $finan_st03  = 2;
                        $finan_sct03 = "NARANJA";
                    }else{    
                        if( (float)$finan_pt03 = 70 && (float)$finan_pt03 <= 89.9 ){
                            $finan_st03  = 3;
                            $finan_sct03 = "AMARILLO";
                        }else{    
                            if( (float)$finan_pt03 = 90 && (float)$finan_pt03 <= 110 ){
                                 $finan_st03  = 4;
                                 $finan_sct03 = "VERDE";
                            }else{    
                                if( (float)$finan_pt03 > 110 && (float)$finan_pt03 <= 300 ){
                                    $finan_st03  = 5;
                                    $finan_sct03 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $finan_pt04  = 0;
            $finan_st04  = 0;
            $finan_sct04 = "";            
            if( (float)$finan_at04 > 0 && (float)$finan_mt04 > 0 ){
                $finan_pt04 = ( (float)$finan_at04 / (float)$finan_mt04) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$finan_pt04 = 0 && (float)$finan_pt04 <= 49.9 ){
                     $finan_st04  = 1;
                     $finan_sct04 = "ROJO";
                }else{    
                    if( (float)$finan_pt04 = 50 && (float)$finan_pt04 <= 69.9 ){
                        $finan_st04  = 2;
                        $finan_sct04 = "NARANJA";
                    }else{    
                        if( (float)$finan_pt04 = 70 && (float)$finan_pt04 <= 89.9 ){
                            $finan_st04  = 3;
                            $finan_sct04 = "AMARILLO";
                        }else{    
                            if( (float)$finan_pt04 = 90 && (float)$finan_pt04 <= 110 ){
                                 $finan_st04  = 4;
                                 $finan_sct04 = "VERDE";
                            }else{    
                                if( (float)$finan_pt04 > 110 && (float)$finan_pt04 <= 300 ){
                                    $finan_st04  = 5;
                                    $finan_sct04 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }

            //********** Calcula porcentales mesuales ********************************//
            $finan_p01  = 0;
            $finan_s01  = 0;
            $finan_sc01 = "";                 
            if( (float)$finan_a01 > 0 && (float)$finan_m01 > 0 ){
                $finan_p01 = ( (float)$finan_a01 / (float)$finan_m01) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$finan_p01 = 0 && (float)$finan_p01 <= 49.9 ){
                     $finan_s01  = 1;
                     $finan_sc01 = "ROJO";
                }else{    
                    if( (float)$finan_p01 = 50 && (float)$finan_p01 <= 69.9 ){
                        $finan_s01  = 2;
                        $finan_sc01 = "NARANJA";
                    }else{    
                        if( (float)$finan_p01 = 70 && (float)$finan_p01 <= 89.9 ){
                            $finan_s01  = 3;
                            $finan_sc01 = "AMARILLO";
                        }else{    
                            if( (float)$finan_p01 = 90 && (float)$finan_p01 <= 110 ){
                                 $finan_s01  = 4;
                                 $finan_sc01 = "VERDE";
                            }else{    
                                if( (float)$finan_p01 > 110 && (float)$finan_p01 <= 300 ){
                                    $finan_s01  = 5;
                                    $finan_sc01 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $finan_p02  = 0;
            $finan_s02  = 0;
            $finan_sc02 = "";                 
            if( (float)$finan_a02 > 0 && (float)$finan_m02 > 0 ){
                $finan_p02 = ( (float)$finan_a02 / (float)$finan_m02) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$finan_p02 = 0 && (float)$finan_p02 <= 49.9 ){
                     $finan_s02  = 1;
                     $finan_sc02 = "ROJO";
                }else{    
                    if( (float)$finan_p02 = 50 && (float)$finan_p02 <= 69.9 ){
                        $finan_s02  = 2;
                        $finan_sc02 = "NARANJA";
                    }else{    
                        if( (float)$finan_p02 = 70 && (float)$finan_p02 <= 89.9 ){
                            $finan_s02  = 3;
                            $finan_sc02 = "AMARILLO";
                        }else{    
                            if( (float)$finan_p02 = 90 && (float)$finan_p02 <= 110 ){
                                 $finan_s02  = 4;
                                 $finan_sc02 = "VERDE";
                            }else{    
                                if( (float)$finan_p02 > 110 && (float)$finan_p02 <= 300 ){
                                    $finan_s02  = 5;
                                    $finan_sc02 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $finan_p03  = 0;
            $finan_s03  = 0;
            $finan_sc03 = "";                 
            if( (float)$finan_a03 > 0 && (float)$finan_m03 > 0 ){
                $finan_p03 = ( (float)$finan_a03 / (float)$finan_m03) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$finan_p03 = 0 && (float)$finan_p03 <= 49.9 ){
                     $finan_s03  = 1;
                     $finan_sc03 = "ROJO";
                }else{    
                    if( (float)$finan_p03 = 50 && (float)$finan_p03 <= 69.9 ){
                        $finan_s03  = 2;
                        $finan_sc03 = "NARANJA";
                    }else{    
                        if( (float)$finan_p03 = 70 && (float)$finan_p03 <= 89.9 ){
                            $finan_s03  = 3;
                            $finan_sc03 = "AMARILLO";
                        }else{    
                            if( (float)$finan_p03 = 90 && (float)$finan_p03 <= 110 ){
                                 $finan_s03  = 4;
                                 $finan_sc03 = "VERDE";
                            }else{    
                                if( (float)$finan_p03 > 110 && (float)$finan_p03 <= 300 ){
                                    $finan_s03  = 5;
                                    $finan_sc03 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $finan_p04  = 0;
            $finan_s04  = 0;
            $finan_sc04 = "";                 
            if( (float)$finan_a04 > 0 && (float)$finan_m04 > 0 ){
                $finan_p04 = ( (float)$finan_a04 / (float)$finan_m04) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$finan_p04 = 0 && (float)$finan_p04 <= 49.9 ){
                     $finan_s04  = 1;
                     $finan_sc04 = "ROJO";
                }else{    
                    if( (float)$finan_p04 = 50 && (float)$finan_p04 <= 69.9 ){
                        $finan_s04  = 2;
                        $finan_sc04 = "NARANJA";
                    }else{    
                        if( (float)$finan_p04 = 70 && (float)$finan_p04 <= 89.9 ){
                            $finan_s04  = 3;
                            $finan_sc04 = "AMARILLO";
                        }else{    
                            if( (float)$finan_p04 = 90 && (float)$finan_p04 <= 110 ){
                                 $finan_s04  = 4;
                                 $finan_sc04 = "VERDE";
                            }else{    
                                if( (float)$finan_p04 > 110 && (float)$finan_p04 <= 300 ){
                                    $finan_s04  = 5;
                                    $finan_sc04 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $finan_p05  = 0;
            $finan_s05  = 0;
            $finan_sc05 = "";                 
            if( (float)$finan_a05 > 0 && (float)$finan_m05 > 0 ){
                $finan_p05 = ( (float)$finan_a05 / (float)$finan_m05) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$finan_p05 = 0 && (float)$finan_p05 <= 49.9 ){
                     $finan_s05  = 1;
                     $finan_sc05 = "ROJO";
                }else{    
                    if( (float)$finan_p05 = 50 && (float)$finan_p05 <= 69.9 ){
                        $finan_s05  = 2;
                        $finan_sc05 = "NARANJA";
                    }else{    
                        if( (float)$finan_p05 = 70 && (float)$finan_p05 <= 89.9 ){
                            $finan_s05  = 3;
                            $finan_sc05 = "AMARILLO";
                        }else{    
                            if( (float)$finan_p05 = 90 && (float)$finan_p05 <= 110 ){
                                 $finan_s05  = 4;
                                 $finan_sc05 = "VERDE";
                            }else{    
                                if( (float)$finan_p05 > 110 && (float)$finan_p05 <= 300 ){
                                    $finan_s05  = 5;
                                    $finan_sc05 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $finan_p06  = 0;
            $finan_s06  = 0;
            $finan_sc06 = "";                 
            if( (float)$finan_a06 > 0 && (float)$finan_m06 > 0 ){
                $finan_p06 = ( (float)$finan_a06 / (float)$finan_m06) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$finan_p06 = 0 && (float)$finan_p06 <= 49.9 ){
                     $finan_s06  = 1;
                     $finan_sc06 = "ROJO";
                }else{    
                    if( (float)$finan_p06 = 50 && (float)$finan_p06 <= 69.9 ){
                        $finan_s06  = 2;
                        $finan_sc06 = "NARANJA";
                    }else{    
                        if( (float)$finan_p06 = 70 && (float)$finan_p06 <= 89.9 ){
                            $finan_s06  = 3;
                            $finan_sc06 = "AMARILLO";
                        }else{    
                            if( (float)$finan_p06 = 90 && (float)$finan_p06 <= 110 ){
                                 $finan_s06  = 4;
                                 $finan_sc06 = "VERDE";
                            }else{    
                                if( (float)$finan_p06 > 110 && (float)$finan_p06 <= 300 ){
                                    $finan_s06  = 5;
                                    $finan_sc06 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $finan_p07  = 0;
            $finan_s07  = 0;
            $finan_sc07 = "";                 
            if( (float)$finan_a07 > 0 && (float)$finan_m07 > 0 ){
                $finan_p07 = ( (float)$finan_a07 / (float)$finan_m07) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$finan_p07 = 0 && (float)$finan_p07 <= 49.9 ){
                     $finan_s07  = 1;
                     $finan_sc07 = "ROJO";
                }else{    
                    if( (float)$finan_p07 = 50 && (float)$finan_p07 <= 69.9 ){
                        $finan_s07  = 2;
                        $finan_sc07 = "NARANJA";
                    }else{    
                        if( (float)$finan_p07 = 70 && (float)$finan_p07 <= 89.9 ){
                            $finan_s07  = 3;
                            $finan_sc07 = "AMARILLO";
                        }else{    
                            if( (float)$finan_p07 = 90 && (float)$finan_p07 <= 110 ){
                                 $finan_s07  = 4;
                                 $finan_sc07 = "VERDE";
                            }else{    
                                if( (float)$finan_p07 > 110 && (float)$finan_p07 <= 300 ){
                                    $finan_s07  = 5;
                                    $finan_sc07 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $finan_p08  = 0;
            $finan_s08  = 0;
            $finan_sc08 = "";                 
            if( (float)$finan_a08 > 0 && (float)$finan_m08 > 0 ){
                $finan_p08 = ( (float)$finan_a08 / (float)$finan_m08) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$finan_p08 = 0 && (float)$finan_p08 <= 49.9 ){
                     $finan_s08  = 1;
                     $finan_sc08 = "ROJO";
                }else{    
                    if( (float)$finan_p08 = 50 && (float)$finan_p08 <= 69.9 ){
                        $finan_s08  = 2;
                        $finan_sc08 = "NARANJA";
                    }else{    
                        if( (float)$finan_p08 = 70 && (float)$finan_p08 <= 89.9 ){
                            $finan_s08  = 3;
                            $finan_sc08 = "AMARILLO";
                        }else{    
                            if( (float)$finan_p08 = 90 && (float)$finan_p08 <= 110 ){
                                 $finan_s08  = 4;
                                 $finan_sc08 = "VERDE";
                            }else{    
                                if( (float)$finan_p08 > 110 && (float)$finan_p08 <= 300 ){
                                    $finan_s08  = 5;
                                    $finan_sc08 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $finan_p09  = 0;
            $finan_s09  = 0;
            $finan_sc09 = "";            
            if( (float)$finan_a09 > 0 && (float)$finan_m09 > 0 ){
                $finan_p09 = ( (float)$finan_a09 / (float)$finan_m09) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$finan_p09 = 0 && (float)$finan_p09 <= 49.9 ){
                     $finan_s09  = 1;
                     $finan_sc09 = "ROJO";
                }else{    
                    if( (float)$finan_p09 = 50 && (float)$finan_p09 <= 69.9 ){
                        $finan_s09  = 2;
                        $finan_sc09 = "NARANJA";
                    }else{    
                        if( (float)$finan_p09 = 70 && (float)$finan_p09 <= 89.9 ){
                            $finan_s09  = 3;
                            $finan_sc09 = "AMARILLO";
                        }else{    
                            if( (float)$finan_p09 = 90 && (float)$finan_p09 <= 110 ){
                                 $finan_s09  = 4;
                                 $finan_sc09 = "VERDE";
                            }else{    
                                if( (float)$finan_p09 > 110 && (float)$finan_p09 <= 300 ){
                                    $finan_s09  = 5;
                                    $finan_sc09 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $finan_p10  = 0;
            $finan_s10  = 0;
            $finan_sc10 = "";            
            if( (float)$finan_a10 > 0 && (float)$finan_m10 > 0 ){
                $finan_p10 = ( (float)$finan_a10 / (float)$finan_m10) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$finan_p10 = 0 && (float)$finan_p10 <= 49.9 ){
                     $finan_s10  = 1;
                     $finan_sc10 = "ROJO";
                }else{    
                    if( (float)$finan_p10 = 50 && (float)$finan_p10 <= 69.9 ){
                        $finan_s10  = 2;
                        $finan_sc10 = "NARANJA";
                    }else{    
                        if( (float)$finan_p10 = 70 && (float)$finan_p10 <= 89.9 ){
                            $finan_s10  = 3;
                            $finan_sc10 = "AMARILLO";
                        }else{    
                            if( (float)$finan_p10 = 90 && (float)$finan_p10 <= 110 ){
                                 $finan_s10  = 4;
                                 $finan_sc10 = "VERDE";
                            }else{    
                                if( (float)$finan_p10 > 110 && (float)$finan_p10 <= 300 ){
                                    $finan_s10  = 5;
                                    $finan_sc10 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $finan_p11  = 0;
            $finan_s11  = 0;
            $finan_sc11 = "";
            if( (float)$finan_a11 > 0 && (float)$finan_m11 > 0 ){
                $finan_p11 = ( (float)$finan_a11 / (float)$finan_m11) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$finan_p11 = 0 && (float)$finan_p11 <= 49.9 ){
                     $finan_s11  = 1;
                     $finan_sc11 = "ROJO";
                }else{    
                    if( (float)$finan_p11 = 50 && (float)$finan_p11 <= 69.9 ){
                        $finan_s11  = 2;
                        $finan_sc11 = "NARANJA";
                    }else{    
                        if( (float)$finan_p11 = 70 && (float)$finan_p11 <= 89.9 ){
                            $finan_s11  = 3;
                            $finan_sc11 = "AMARILLO";
                        }else{    
                            if( (float)$finan_p11 = 90 && (float)$finan_p11 <= 110 ){
                                 $finan_s11  = 4;
                                 $finan_sc11 = "VERDE";
                            }else{    
                                if( (float)$finan_p11 > 110 && (float)$finan_p11 <= 300 ){
                                    $finan_s11  = 5;
                                    $finan_sc11 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $finan_p12  = 0;
            $finan_s12  = 0;
            $finan_sc12 = "";
            if( (float)$finan_a12 > 0 && (float)$finan_m12 > 0 ){
                $finan_p12 = ( (float)$finan_a12 / (float)$finan_m12) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$finan_p12 = 0 && (float)$finan_p12 <= 49.9 ){
                     $finan_s12  = 1;
                     $finan_sc12 = "ROJO";
                }else{    
                    if( (float)$finan_p12 = 50 && (float)$finan_p12 <= 69.9 ){
                        $finan_s12  = 2;
                        $finan_sc12 = "NARANJA";
                    }else{    
                        if( (float)$finan_p12 = 70 && (float)$finan_p12 <= 89.9 ){
                            $finan_s12  = 3;
                            $finan_sc12 = "AMARILLO";
                        }else{    
                            if( (float)$finan_p12 = 90 && (float)$finan_p12 <= 110 ){
                                 $finan_s12  = 4;
                                 $finan_sc12 = "VERDE";
                            }else{    
                                if( (float)$finan_p12 > 110 && (float)$finan_p12 <= 300 ){
                                    $finan_s12  = 5;
                                    $finan_sc12 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }


            //*********** Actualizarn items **********************
            $regfinan = regFinanModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'FTEFINAN_ID' => $id3])
                               ->update([                
                                         'FINAN_AVANCE'  => $request->finan_avance,
                                         'FINAN_A01'     => $finan_a01,
                                         'FINAN_A02'     => $finan_a02,
                                         'FINAN_A03'     => $finan_a03,
                                         'FINAN_A04'     => $finan_a04,
                                         'FINAN_A05'     => $finan_a05,
                                         'FINAN_A06'     => $finan_a06,
                                         'FINAN_A07'     => $finan_a07,
                                         'FINAN_A08'     => $finan_a08,
                                         'FINAN_A09'     => $finan_a09,
                                         'FINAN_A10'     => $finan_a10,
                                         'FINAN_A11'     => $finan_a11,
                                         'FINAN_A12'     => $finan_a12,   
                                         'FINAN_AT01'    => $finan_at01,
                                         'FINAN_AT02'    => $finan_at02,
                                         'FINAN_AT03'    => $finan_at03,
                                         'FINAN_AT04'    => $finan_at04,
                                         'FINAN_AS01'    => $finan_as01,
                                         'FINAN_AS02'    => $finan_as02,
                                         'FINAN_AA01'    => $finan_aa01,

                                         'FINAN_P01'     => $finan_p01,
                                         'FINAN_P02'     => $finan_p02,
                                         'FINAN_P03'     => $finan_p03,
                                         'FINAN_P04'     => $finan_p04,
                                         'FINAN_P05'     => $finan_p05,
                                         'FINAN_P06'     => $finan_p06,
                                         'FINAN_P07'     => $finan_p07,
                                         'FINAN_P08'     => $finan_p08,
                                         'FINAN_P09'     => $finan_p09,
                                         'FINAN_P10'     => $finan_p10,
                                         'FINAN_P11'     => $finan_p11,
                                         'FINAN_P12'     => $finan_p12,   
                                         'FINAN_PT01'    => $finan_pt01,
                                         'FINAN_PT02'    => $finan_pt02,
                                         'FINAN_PT03'    => $finan_pt03,
                                         'FINAN_PT04'    => $finan_pt04,
                                         'FINAN_PS01'    => $finan_ps01,
                                         'FINAN_PS02'    => $finan_ps02,
                                         'FINAN_PA01'    => $finan_pa01,

                                         'FINAN_S01'     => $finan_s01,
                                         'FINAN_S02'     => $finan_s02,
                                         'FINAN_S03'     => $finan_s03,
                                         'FINAN_S04'     => $finan_s04,
                                         'FINAN_S05'     => $finan_s05,
                                         'FINAN_S06'     => $finan_s06,
                                         'FINAN_S07'     => $finan_s07,
                                         'FINAN_S08'     => $finan_s08,
                                         'FINAN_S09'     => $finan_s09,
                                         'FINAN_S10'     => $finan_s10,
                                         'FINAN_S11'     => $finan_s11,
                                         'FINAN_S12'     => $finan_s12,   
                                         'FINAN_ST01'    => $finan_st01,
                                         'FINAN_ST02'    => $finan_st02,
                                         'FINAN_ST03'    => $finan_st03,
                                         'FINAN_ST04'    => $finan_st04,
                                         'FINAN_SS01'    => $finan_ss01,
                                         'FINAN_SS02'    => $finan_ss02,
                                         'FINAN_SA01'    => $finan_sa01,                                         

                                         'FINAN_SC01'    => $finan_sc01,
                                         'FINAN_SC02'    => $finan_sc02,
                                         'FINAN_SC03'    => $finan_sc03,
                                         'FINAN_SC04'    => $finan_sc04,
                                         'FINAN_SC05'    => $finan_sc05,
                                         'FINAN_SC06'    => $finan_sc06,
                                         'FINAN_SC07'    => $finan_sc07,
                                         'FINAN_SC08'    => $finan_sc08,
                                         'FINAN_SC09'    => $finan_sc09,
                                         'FINAN_SC10'    => $finan_sc10,
                                         'FINAN_SC11'    => $finan_sc11,
                                         'FINAN_SC12'    => $finan_sc12,   
                                         'FINAN_SCT01'   => $finan_sct01,
                                         'FINAN_SCT02'   => $finan_sct02,
                                         'FINAN_SCT03'   => $finan_sct03,
                                         'FINAN_SCT04'   => $finan_sct04,
                                         'FINAN_SCS01'   => $finan_scs01,
                                         'FINAN_SCS02'   => $finan_scs02,
                                         'FINAN_SCA01'   => $finan_sca01, 

                                         'IP_M'          => $ip,
                                         'LOGIN_M'       => $nombre,
                                         'FECHA_M2'      => date('Y/m/d'),   //date('d/m/Y')            
                                         'FECHA_M'       => date('Y/m/d')    //date('d/m/Y')   
                              ]);
            toastr()->success('fuentes de financiamiento actualizado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =        23;    //Actualizar 
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
                    toastr()->success('Trx de actualización de fuentes de financiamiento registrado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error Trx de fuentes de financiamiento  actualizado en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
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
                toastr()->success('Trx de actualización de fuentes de financiamiento registrado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                     
        }       /************ Actualizar *******************************************/
        return redirect()->route('verfinanavances');
    }

    public function actionBorrarFinanavances($id, $id2, $id3){
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
        $regfinan     = regFinanModel::select('PERIODO_ID','PROG_ID','FTEFINAN_ID','FINAN_META','FINAN_AVANCE',
                        'FINAN_M01','FINAN_M02','FINAN_M03','FINAN_M04','FINAN_M05','FINAN_M06',
                        'FINAN_M07','FINAN_M08','FINAN_M09','FINAN_M10','FINAN_M11','FINAN_M12',
                        'FINAN_MT01','FINAN_MT02','FINAN_MT03','FINAN_MT04','FINAN_MS01','FINAN_MS02','FINAN_MA01',
                        'FINAN_A01','FINAN_A02','FINAN_A03','FINAN_A04','FINAN_A05','FINAN_A06',
                        'FINAN_A07','FINAN_A08','FINAN_A09','FINAN_A10','FINAN_A11','FINAN_A12',
                        'FINAN_AT01','FINAN_AT02','FINAN_AT03','FINAN_AT04','FINAN_AS01','FINAN_AS02','FINAN_AA01'
                        )
                         ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'FTEFINAN_ID' => $id3]);
        if($regfinan->count() <= 0)
            toastr()->error('No existe fuente de financiamiento.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            $regfinan->delete();
            toastr()->success('fuente de financiamiento eliminado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            //echo 'Ya entre a borrar registro..........';
            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =        24;     // Baja 

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
                    toastr()->success('Trx de baja de fuente de financiamiento registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error en Trx de baja de fuente de financiamiento en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
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
                toastr()->success('Trx de fuente de financiamiento registrado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                 
        }       /************* Termina de eliminar **********************************/
        return redirect()->route('verfinanavances');
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
        $xtrx_id      =        25;            // Exportar a formato Excel
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
        $xtrx_id      =        26;       //Exportar a formato PDF
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

        $regfinan  = regFinanModel::select('PROG_ID','PROG_DESC','PROG_SIGLAS','PROG_VIGENTE', 
                                              'CLASIFICGOB_ID','PRIORIDAD_ID',
                                              'PROG_ORDEN','PROG_TIPO','PROG_SEPUBLICA','PROG_OBS1', 
                                              'PROG_OBS2','PROG_STATUS1','PROG_STATUS2','PROG_FECREG')
                                     ->orderBy('PROG_ID','ASC')
                                     ->get();                               
        if($regfinan->count() <= 0){
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
