<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\finanmetasRequest;

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

class finanmetasController extends Controller
{

    public function actionBuscarFinanmetas(Request $request)
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
        return view('sicinar.financiamiento.verFinanmetas', compact('nombre','usuario','codigo','regprogramas','regfuentefinan','regperiodos','regfinan'));
    }

    public function actionVerFinanmetas(){
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
                                      'CP_FINANCIAMIENTO.FINAN_M12'
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
                                       'CP_FINANCIAMIENTO.FINAN_M12'
                                      )
                             ->where(  'CP_FINANCIAMIENTO.PROG_ID'   ,$codigo)                             
                            ->orderBy( 'CP_FINANCIAMIENTO.PERIODO_ID','DESC')
                            ->orderBy( 'CP_FINANCIAMIENTO.PROG_ID'   ,'DESC')
                            ->paginate(50);          
        }                         
        if($regfinan->count() <= 0){
            toastr()->error('No existen fuentes de financiamiento','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.financiamiento.verFinanmetas',compact('nombre','usuario','codigo','regprogramas','regfuentefinan','regfinan'));
    }

    public function actionNuevoFinanmetas(){
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
        $regfinan     = regFinanModel::select('PERIODO_ID','PROG_ID','FTEFINAN_ID','FINAN_META',
                        'FINAN_M01','FINAN_M02','FINAN_M03','FINAN_M04','FINAN_M05','FINAN_M06',
                        'FINAN_M07','FINAN_M08','FINAN_M09','FINAN_M10','FINAN_M11','FINAN_M12',
                        'FINAN_MT01','FINAN_MT02','FINAN_MT03','FINAN_MT04','FINAN_MS01','FINAN_MS02','FINAN_MA01')
                         ->orderBy('PERIODO_ID','asc')
                         ->orderBy('PROG_ID'   ,'asc')
                         ->get();
        //dd($unidades);
        return view('sicinar.financiamiento.nuevoFinanmetas',compact('nombre','usuario','codigo','regprogramas','regfuentefinan','regperiodos','regfinan'));
    }

    public function actionAltaNuevoFinanmetas(Request $request){
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
                $xtrx_id      =        17;    //Alta
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

    public function actionEditarFinanmetas($id, $id2, $id3){
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
        $regfinan     = regFinanModel::select('PERIODO_ID','PROG_ID','FTEFINAN_ID','FINAN_META',
                        'FINAN_M01','FINAN_M02','FINAN_M03','FINAN_M04','FINAN_M05','FINAN_M06',
                        'FINAN_M07','FINAN_M08','FINAN_M09','FINAN_M10','FINAN_M11','FINAN_M12',
                        'FINAN_MT01','FINAN_MT02','FINAN_MT03','FINAN_MT04','FINAN_MS01','FINAN_MS02','FINAN_MA01')
                         ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'FTEFINAN_ID' => $id3])
                         ->first();
        //dd($id,'segundo.....'.$id2, $regfinan->count() );
        if($regfinan->count() <= 0){
            toastr()->error('No existe fuente de financiamiento.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.financiamiento.editarFinanmetas',compact('nombre','usuario','codigo','regprogramas','regfuentefinan','regperiodos','regfinan'));
    }

    public function actionActualizarFinanmetas(finanmetasRequest $request, $id, $id2, $id3){
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
            //*********** Calculamos valores ************************
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
            //*********** Actualizarn items **********************
            $regfinan = regFinanModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'FTEFINAN_ID' => $id3])
                               ->update([                
                                         'FINAN_META'    => $request->finan_meta,
                                         'FINAN_M01'     => $finan_m01,
                                         'FINAN_M02'     => $finan_m02,
                                         'FINAN_M03'     => $finan_m03,
                                         'FINAN_M04'     => $finan_m04,
                                         'FINAN_M05'     => $finan_m05,
                                         'FINAN_M06'     => $finan_m06,
                                         'FINAN_M07'     => $finan_m07,
                                         'FINAN_M08'     => $finan_m08,
                                         'FINAN_M09'     => $finan_m09,
                                         'FINAN_M10'     => $finan_m10,
                                         'FINAN_M11'     => $finan_m11,
                                         'FINAN_M12'     => $finan_m12,   

                                         'FINAN_MT01'    => $finan_mt01,
                                         'FINAN_MT02'    => $finan_mt02,
                                         'FINAN_MT03'    => $finan_mt03,
                                         'FINAN_MT04'    => $finan_mt04,
                                         'FINAN_MS01'    => $finan_ms01,
                                         'FINAN_MS02'    => $finan_ms02,
                                         'FINAN_MA01'    => $finan_ma01,

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
            $xtrx_id      =        18;    //Actualizar 
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
        return redirect()->route('verfinanmetas');
    }

    public function actionBorrarFinanmetas($id, $id2, $id3){
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
        $regfinan     = regFinanModel::select('PERIODO_ID','PROG_ID','FTEFINAN_ID','FINAN_META',
                        'FINAN_M01','FINAN_M02','FINAN_M03','FINAN_M04','FINAN_M05','FINAN_M06',
                        'FINAN_M07','FINAN_M08','FINAN_M09','FINAN_M10','FINAN_M11','FINAN_M12',
                        'FINAN_MT01','FINAN_MT02','FINAN_MT03','FINAN_MT04','FINAN_MS01','FINAN_MS02','FINAN_MA01')
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
            $xtrx_id      =        19;     // Baja 

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
        return redirect()->route('verfinanmetas');
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
        $xtrx_id      =        20;            // Exportar a formato Excel
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
        $xtrx_id      =        21;       //Exportar a formato PDF
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
