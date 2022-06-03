<?php
//**************************************************************/
//* File:       distmuniavanController.php
//* Proyecto:   Sistema SISCATPROG
//¨Función:     Clases para el modulo de distribución por municipio
//* Autor:      Ing. Silverio Baltazar Barrientos Zarate
//* Modifico:   Ing. Silverio Baltazar Barrientos Zarate
//* Fecha act.: junio 2022
//* @Derechos reservados. Gobierno del Estado de México
//*************************************************************/

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\distmuniavancesRequest;

use App\regPeriodosModel;
use App\regProgramasModel;
use App\regMunicipiosModel;
use App\regDistmunicipioModel;
use App\regBitacoraModel;

// Exportar a excel 
//use App\Exports\ExcelExportProg;
use Maatwebsite\Excel\Facades\Excel;
// Exportar a pdf
use PDF;
//use Options;

class distmuniavanController extends Controller
{

    public function actionBuscarDistmuniavan(Request $request)
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

        $regmunicipios = regMunicipiosModel::select('MUNICIPIO_ID','MUNICIPIO')
                         ->where(  'ENTIDADFEDERATIVA_ID','=',15)
                         ->orderBy('MUNICIPIO','asc')
                         ->get();     
        $regprogramas  = regProgramasModel::select('PROG_ID','PROG_DESC')
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
            $regdistmuni = regDistmunicipioModel::orderBy('PROG_ID', 'ASC')
                       ->name($name)           //Metodos personalizados es equvalente a ->where('IAP_DESC', 'LIKE', "%$name%");
                       //->email($email)         //Metodos personalizados
                       //->bio($bio)             //Metodos personalizados
                       ->paginate(50);
        }else{           
            $regdistmuni = regDistmunicipioModel::where('PROG_ID',$codigo)
                       ->orderBy('PROG_ID', 'ASC')
                       ->name($name)           //Metodos personalizados es equvalente a ->where('IAP_DESC', 'LIKE', "%$name%");
                       //->email($email)         //Metodos personalizados
                       //->bio($bio)             //Metodos personalizados
                       ->paginate(50);          
        }
        if($regdistmuni->count() <= 0){
            toastr()->error('No existen distribución por municipio','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }            
        return view('sicinar.distrib_mun.verDistmuniavan', compact('nombre','usuario','codigo','regprogramas','regdistmuni','regperiodos','regmunicipios'));
    }

    public function actionVerDistmuniavan(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $codigo       = session()->get('codigo');         

        $regmunicipios = regMunicipiosModel::select('MUNICIPIO_ID','MUNICIPIO')
                         ->where('ENTIDADFEDERATIVA_ID','=',15)
                         ->orderBy('MUNICIPIO','asc')
                         ->get();     
        if(session()->get('rango') !== '0'){                                                       
            $regdistmuni=regDistmunicipioModel::join('CP_CAT_PROGRAMAS','CP_CAT_PROGRAMAS.PROG_ID','=',
                                                                        'CP_DISTRIB_MUNICIPIOS.PROG_ID')
                          ->select('CP_DISTRIB_MUNICIPIOS.PERIODO_ID',
                                   'CP_DISTRIB_MUNICIPIOS.PROG_ID',
                                   'CP_DISTRIB_MUNICIPIOS.MUNICIPIO_ID',
                                   'CP_CAT_PROGRAMAS.PROG_DESC',
                                   'CP_DISTRIB_MUNICIPIOS.BENE_META',
                                   'CP_DISTRIB_MUNICIPIOS.BENE_AVANCE',
                                   'CP_DISTRIB_MUNICIPIOS.BENEF_META',
                                   'CP_DISTRIB_MUNICIPIOS.BENEF_AVANCE',                                      
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_META',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_M01', 
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_M02',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_M03',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_M04',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_M05',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_M06', 
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_M07',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_M08',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_M09',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_M10', 
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_M11',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_M12',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_AVANCE', 
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_A01', 
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_A02',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_A03',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_A04',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_A05',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_A06', 
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_A07',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_A08',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_A09',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_A10', 
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_A11',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_A12'
                                      )
                         ->orderBy('CP_DISTRIB_MUNICIPIOS.PERIODO_ID','DESC')
                         ->orderBy('CP_DISTRIB_MUNICIPIOS.PROG_ID'   ,'DESC')
                         ->paginate(50);
        }else{           
            $regdistmuni=regDistmunicipioModel::join('CP_CAT_PROGRAMAS','CP_CAT_PROGRAMAS.PROG_ID','=',
                                                                        'CP_DISTRIB_MUNICIPIOS.PROG_ID')
                          ->select('CP_DISTRIB_MUNICIPIOS.PERIODO_ID',
                                   'CP_DISTRIB_MUNICIPIOS.PROG_ID',
                                   'CP_DISTRIB_MUNICIPIOS.MUNICIPIO_ID',
                                   'CP_CAT_PROGRAMAS.PROG_DESC',
                                   'CP_DISTRIB_MUNICIPIOS.BENE_META',
                                   'CP_DISTRIB_MUNICIPIOS.BENE_AVANCE',
                                   'CP_DISTRIB_MUNICIPIOS.BENEF_META',
                                   'CP_DISTRIB_MUNICIPIOS.BENEF_AVANCE',                                   
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_META',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_M01', 
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_M02',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_M03',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_M04',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_M05',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_M06', 
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_M07',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_M08',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_M09',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_M10', 
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_M11',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_M12',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_AVANCE', 
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_A01', 
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_A02',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_A03',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_A04',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_A05',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_A06', 
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_A07',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_A08',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_A09',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_A10', 
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_A11',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_A12'                                       
                                  )
                             ->where(  'CP_DISTRIB_MUNICIPIOS.PROG_ID'   ,$codigo)                             
                            ->orderBy( 'CP_DISTRIB_MUNICIPIOS.PERIODO_ID','DESC')
                            ->orderBy( 'CP_DISTRIB_MUNICIPIOS.PROG_ID'   ,'DESC')
                            ->paginate(50);          
        }                         
        if($regdistmuni->count() <= 0){
            toastr()->error('No existen distribución por municipio','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.distrib_mun.verDistmuniavan',compact('nombre','usuario','codigo','regprogramas','regdistmuni','regmunicipios'));
    }

    public function actionNuevoDistmuniavan(){
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
        $regdistmuni  = regDistmunicipioModel::select('PERIODO_ID','PROG_ID','FTEFINAN_ID','FINAN_META','FINAN_AVANCE',
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
        return view('sicinar.distrib_mun.nuevoFinanavances',compact('nombre','usuario','codigo','regprogramas','regdistmuni','regperiodos','regmunicipios'));
    }

    public function actionAltaNuevoDistmuniavan(Request $request){
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
        $regdistmuni = regDistmunicipioModel::where(['PERIODO_ID' => $request->periodo_id,
                                          'PROG_ID'    => $request->prog_id,
                                          'FTEFINAN_ID'=> $request->ftefinan_id]);
        if($regdistmuni->count() > 0)
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
            //$iid = regDistmunicipioModel::count(*);
            //$iid = $iid + 1;
            $nuevaiap = new regDistmunicipioModel();
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
                $xtrx_id      =        52;    //Alta
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

    public function actionEditarDistmuniavan($id, $id2, $id3){
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
        $regmunicipios = regMunicipiosModel::select('MUNICIPIO_ID','MUNICIPIO')
                         ->where('ENTIDADFEDERATIVA_ID','=',15)
                         ->orderBy('MUNICIPIO','asc')
                         ->get();     
        $regprogramas = regProgramasModel::select('PROG_ID','PROG_DESC')
                        ->orderBy('PROG_ID','asc')
                        ->get();                                 
        $regdistmuni     = regDistmunicipioModel::select('*')
                         ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'MUNICIPIO_ID' => $id3])
                         ->first();
        //dd($id,'segundo.....'.$id2, $regdistmuni->count() );
        if($regdistmuni->count() <= 0){
            toastr()->error('No existe distribución por municipio.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.distrib_mun.editarDistmuniavan',compact('nombre','usuario','codigo','regprogramas','regdistmuni','regperiodos','regmunicipios'));
    }

    public function actionActualizarDistmuniavan(distmuniavancesRequest $request, $id, $id2, $id3){
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
        $regdistmuni = regDistmunicipioModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'MUNICIPIO_ID' => $id3]);
        //dd('hola.....',$regdistmuni);
        if($regdistmuni->count() <= 0)
            toastr()->error('No existe distribución por municipio.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            //***********************************************************************//
            //************ Obtiene valores beneficiarios metas programados **********//
            $benef_meta = 0;
            if(isset($request->benef_meta)){
                if(!empty($request->benef_meta)) 
                    $benef_meta = (float)$request->benef_meta;
            }                      
            //$benef_meta = $mesesp[0]->benef_meta;
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

            //*********** Calculamos valores ************************
            $benef_avance = 0;
            if(isset($request->benef_avance)){
                if(!empty($request->benef_avance)) 
                    $benef_avance = (float)$request->benef_avance;
            }          
            $benef_a01 = 0;
            if(isset($request->benef_a01)){
                if(!empty($request->benef_a01)) 
                    $benef_a01 = (float)$request->benef_a01;
            }                      
            $benef_a02 = 0;
            if(isset($request->benef_a02)){
                if(!empty($request->benef_a02)) 
                    $benef_a02 = (float)$request->benef_a02;
            }  
            $benef_a03 = 0;
            if(isset($request->benef_a03)){
                if(!empty($request->benef_a03)) 
                    $benef_a03 = (float)$request->benef_a03;
            }  
            $benef_a04 = 0;
            if(isset($request->benef_a04)){
                if(!empty($request->benef_a04)) 
                    $benef_a04 = (float)$request->benef_a04;
            }  
            $benef_a05 = 0;
            if(isset($request->benef_a05)){
                if(!empty($request->benef_a05)) 
                    $benef_a05 = (float)$request->benef_a05;
            }                                                  
            $benef_a06 = 0;
            if(isset($request->benef_a06)){
                if(!empty($request->benef_a06)) 
                    $benef_a06 = (float)$request->benef_a06;
            }               
            $benef_a07 = 0;
            if(isset($request->benef_a07)){
                if(!empty($request->benef_a07)) 
                    $benef_a07 = (float)$request->benef_a07;
            }          
            $benef_a08 = 0;
            if(isset($request->benef_a08)){
                if(!empty($request->benef_a08)) 
                    $benef_a08 = (float)$request->benef_a08;
            }  
            $benef_a09 = 0;
            if(isset($request->benef_a09)){
                if(!empty($request->benef_a09)) 
                    $benef_a09 = (float)$request->benef_a09;
            }  
            $benef_a10 = 0;
            if(isset($request->benef_a10)){
                if(!empty($request->benef_a10)) 
                    $benef_a10 = (float)$request->benef_a10;
            }  
            $benef_a11 = 0;
            if(isset($request->benef_a11)){
                if(!empty($request->benef_a11)) 
                    $benef_a11 = (float)$request->benef_a11;
            }                                                  
            $benef_a12 = 0;
            if(isset($request->benef_a12)){
                if(!empty($request->benef_a12)) 
                    $benef_a12 = (float)$request->benef_a12;
            }                           
            $benef_at01 = (float)$benef_a01 + (float)$benef_a02 + (float)$benef_a03;
            $benef_at02 = (float)$benef_a04 + (float)$benef_a05 + (float)$benef_a06;
            $benef_at03 = (float)$benef_a07 + (float)$benef_a08 + (float)$benef_a09;
            $benef_at04 = (float)$benef_a10 + (float)$benef_a11 + (float)$benef_a12;

            $benef_as01 = (float)$benef_at01 + (float)$benef_at02;
            $benef_as02 = (float)$benef_at03 + (float)$benef_at04;            

            $benef_aa01 = (float)$benef_as01 + (float)$benef_as02; 

            //********** Calcula porcentaje anual ********************************//
            $benef_pa01  = 0;
            $benef_sa01  = 0;
            $benef_sca01 = "";            
            if( (float)$benef_avance > 0 && (float)$benef_meta > 0 ){
                $benef_pa01  =( (float)$benef_avance / (float)$benef_meta) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$benef_pa01 = 0 && (float)$benef_pa01 <= 49.9 ){
                     $benef_sa01  = 1;
                     $benef_sca01 = "ROJO";
                }else{    
                    if( (float)$benef_pa01 = 50 && (float)$benef_pa01 <= 69.9 ){
                        $benef_sa01  = 2;
                        $benef_sca01 = "NARANJA";
                    }else{    
                        if( (float)$benef_pa01 = 70 && (float)$benef_pa01 <= 89.9 ){
                            $benef_sa01  = 3;
                            $benef_sca01 = "AMARILLO";
                        }else{    
                            if( (float)$benef_pa01 = 90 && (float)$benef_pa01 <= 110 ){
                                 $benef_sa01  = 4;
                                 $benef_sca01 = "VERDE";
                            }else{    
                                if( (float)$benef_pa01 > 110 && (float)$benef_pa01 <= 300 ){
                                    $benef_sa01  = 5;
                                    $benef_sca01 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }

            //********** Calcula porcentajes semestrales ********************************//
            $benef_ps01  = 0;
            $benef_ss01  = 0;
            $benef_scs01 = "";                        
            if( (float)$benef_as01 > 0 && (float)$benef_ms01 > 0 ){
                $benef_ps01 = ( (float)$benef_as01 / (float)$benef_ms01) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$benef_ps01 = 0 && (float)$benef_ps01 <= 49.9 ){
                     $benef_ss01  = 1;
                     $benef_scs01 = "ROJO";
                }else{    
                    if( (float)$benef_ps01 = 50 && (float)$benef_ps01 <= 69.9 ){
                        $benef_ss01  = 2;
                        $benef_scs01 = "NARANJA";
                    }else{    
                        if( (float)$benef_ps01 = 70 && (float)$benef_ps01 <= 89.9 ){
                            $benef_ss01  = 3;
                            $benef_scs01 = "AMARILLO";
                        }else{    
                            if( (float)$benef_ps01 = 90 && (float)$benef_ps01 <= 110 ){
                                 $benef_ss01  = 4;
                                 $benef_scs01 = "VERDE";
                            }else{    
                                if( (float)$benef_ps01 > 110 && (float)$benef_ps01 <= 300 ){
                                    $benef_ss01  = 5;
                                    $benef_scs01 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $benef_ps02  = 0;
            $benef_ss02  = 0;
            $benef_scs02 = "";            
            if( (float)$benef_as02 > 0 && (float)$benef_ms02 > 0 ){
                $benef_ps02 = ( (float)$benef_as02 / (float)$benef_ms02) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$benef_ps02 = 0 && (float)$benef_ps02 <= 49.9 ){
                     $benef_ss02  = 1;
                     $benef_scs02 = "ROJO";
                }else{    
                    if( (float)$benef_ps02 = 50 && (float)$benef_ps02 <= 69.9 ){
                        $benef_ss02  = 2;
                        $benef_scs02 = "NARANJA";
                    }else{    
                        if( (float)$benef_ps02 = 70 && (float)$benef_ps02 <= 89.9 ){
                            $benef_ss02  = 3;
                            $benef_scs02 = "AMARILLO";
                        }else{    
                            if( (float)$benef_ps02 = 90 && (float)$benef_ps02 <= 110 ){
                                 $benef_ss02  = 4;
                                 $benef_scs02 = "VERDE";
                            }else{    
                                if( (float)$benef_ps02 > 110 && (float)$benef_ps02 <= 300 ){
                                    $benef_ss02  = 5;
                                    $benef_scs02 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }

            //********** Calcula porcentajes trimestrales ********************************//
            $benef_pt01  = 0;
            $benef_st01  = 0;
            $benef_sct01 = "";                        
            if( (float)$benef_at01 > 0 && (float)$benef_mt01 > 0 ){
                $benef_pt01 = ( (float)$benef_at01 / (float)$benef_mt01) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$benef_pt01 = 0 && (float)$benef_pt01 <= 49.9 ){
                     $benef_st01  = 1;
                     $benef_sct01 = "ROJO";
                }else{    
                    if( (float)$benef_pt01 = 50 && (float)$benef_pt01 <= 69.9 ){
                        $benef_st01  = 2;
                        $benef_sct01 = "NARANJA";
                    }else{    
                        if( (float)$benef_pt01 = 70 && (float)$benef_pt01 <= 89.9 ){
                            $benef_st01  = 3;
                            $benef_sct01 = "AMARILLO";
                        }else{    
                            if( (float)$benef_pt01 = 90 && (float)$benef_pt01 <= 110 ){
                                 $benef_st01  = 4;
                                 $benef_sct01 = "VERDE";
                            }else{    
                                if( (float)$benef_pt01 > 110 && (float)$benef_pt01 <= 300 ){
                                    $benef_st01  = 5;
                                    $benef_sct01 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $benef_pt02  = 0;
            $benef_st02  = 0;
            $benef_sct02 = "";                        
            if( (float)$benef_at02 > 0 && (float)$benef_mt02 > 0 ){
                $benef_pt02 = ( (float)$benef_at02 / (float)$benef_mt02) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$benef_pt02 = 0 && (float)$benef_pt02 <= 49.9 ){
                     $benef_st02  = 1;
                     $benef_sct02 = "ROJO";
                }else{    
                    if( (float)$benef_pt02 = 50 && (float)$benef_pt02 <= 69.9 ){
                        $benef_st02  = 2;
                        $benef_sct02 = "NARANJA";
                    }else{    
                        if( (float)$benef_pt02 = 70 && (float)$benef_pt02 <= 89.9 ){
                            $benef_st02  = 3;
                            $benef_sct02 = "AMARILLO";
                        }else{    
                            if( (float)$benef_pt02 = 90 && (float)$benef_pt02 <= 110 ){
                                 $benef_st02  = 4;
                                 $benef_sct02 = "VERDE";
                            }else{    
                                if( (float)$benef_pt02 > 110 && (float)$benef_pt02 <= 300 ){
                                    $benef_st02  = 5;
                                    $benef_sct02 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $benef_pt03  = 0;
            $benef_st03  = 0;
            $benef_sct03 = "";                        
            if( (float)$benef_at03 > 0 && (float)$benef_mt03 > 0 ){
                $benef_pt03 = ( (float)$benef_at03 / (float)$benef_mt03) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$benef_pt03 = 0 && (float)$benef_pt03 <= 49.9 ){
                     $benef_st03  = 1;
                     $benef_sct03 = "ROJO";
                }else{    
                    if( (float)$benef_pt03 = 50 && (float)$benef_pt03 <= 69.9 ){
                        $benef_st03  = 2;
                        $benef_sct03 = "NARANJA";
                    }else{    
                        if( (float)$benef_pt03 = 70 && (float)$benef_pt03 <= 89.9 ){
                            $benef_st03  = 3;
                            $benef_sct03 = "AMARILLO";
                        }else{    
                            if( (float)$benef_pt03 = 90 && (float)$benef_pt03 <= 110 ){
                                 $benef_st03  = 4;
                                 $benef_sct03 = "VERDE";
                            }else{    
                                if( (float)$benef_pt03 > 110 && (float)$benef_pt03 <= 300 ){
                                    $benef_st03  = 5;
                                    $benef_sct03 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $benef_pt04  = 0;
            $benef_st04  = 0;
            $benef_sct04 = "";            
            if( (float)$benef_at04 > 0 && (float)$benef_mt04 > 0 ){
                $benef_pt04 = ( (float)$benef_at04 / (float)$benef_mt04) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$benef_pt04 = 0 && (float)$benef_pt04 <= 49.9 ){
                     $benef_st04  = 1;
                     $benef_sct04 = "ROJO";
                }else{    
                    if( (float)$benef_pt04 = 50 && (float)$benef_pt04 <= 69.9 ){
                        $benef_st04  = 2;
                        $benef_sct04 = "NARANJA";
                    }else{    
                        if( (float)$benef_pt04 = 70 && (float)$benef_pt04 <= 89.9 ){
                            $benef_st04  = 3;
                            $benef_sct04 = "AMARILLO";
                        }else{    
                            if( (float)$benef_pt04 = 90 && (float)$benef_pt04 <= 110 ){
                                 $benef_st04  = 4;
                                 $benef_sct04 = "VERDE";
                            }else{    
                                if( (float)$benef_pt04 > 110 && (float)$benef_pt04 <= 300 ){
                                    $benef_st04  = 5;
                                    $benef_sct04 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }

            //********** Calcula porcentajes mesuales ********************************//
            $benef_p01  = 0;
            $benef_s01  = 0;
            $benef_sc01 = "";                 
            if( (float)$benef_a01 > 0 && (float)$benef_m01 > 0 ){
                $benef_p01 = ( (float)$benef_a01 / (float)$benef_m01) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$benef_p01 = 0 && (float)$benef_p01 <= 49.9 ){
                     $benef_s01  = 1;
                     $benef_sc01 = "ROJO";
                }else{    
                    if( (float)$benef_p01 = 50 && (float)$benef_p01 <= 69.9 ){
                        $benef_s01  = 2;
                        $benef_sc01 = "NARANJA";
                    }else{    
                        if( (float)$benef_p01 = 70 && (float)$benef_p01 <= 89.9 ){
                            $benef_s01  = 3;
                            $benef_sc01 = "AMARILLO";
                        }else{    
                            if( (float)$benef_p01 = 90 && (float)$benef_p01 <= 110 ){
                                 $benef_s01  = 4;
                                 $benef_sc01 = "VERDE";
                            }else{    
                                if( (float)$benef_p01 > 110 && (float)$benef_p01 <= 300 ){
                                    $benef_s01  = 5;
                                    $benef_sc01 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $benef_p02  = 0;
            $benef_s02  = 0;
            $benef_sc02 = "";                 
            if( (float)$benef_a02 > 0 && (float)$benef_m02 > 0 ){
                $benef_p02 = ( (float)$benef_a02 / (float)$benef_m02) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$benef_p02 = 0 && (float)$benef_p02 <= 49.9 ){
                     $benef_s02  = 1;
                     $benef_sc02 = "ROJO";
                }else{    
                    if( (float)$benef_p02 = 50 && (float)$benef_p02 <= 69.9 ){
                        $benef_s02  = 2;
                        $benef_sc02 = "NARANJA";
                    }else{    
                        if( (float)$benef_p02 = 70 && (float)$benef_p02 <= 89.9 ){
                            $benef_s02  = 3;
                            $benef_sc02 = "AMARILLO";
                        }else{    
                            if( (float)$benef_p02 = 90 && (float)$benef_p02 <= 110 ){
                                 $benef_s02  = 4;
                                 $benef_sc02 = "VERDE";
                            }else{    
                                if( (float)$benef_p02 > 110 && (float)$benef_p02 <= 300 ){
                                    $benef_s02  = 5;
                                    $benef_sc02 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $benef_p03  = 0;
            $benef_s03  = 0;
            $benef_sc03 = "";                 
            if( (float)$benef_a03 > 0 && (float)$benef_m03 > 0 ){
                $benef_p03 = ( (float)$benef_a03 / (float)$benef_m03) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$benef_p03 = 0 && (float)$benef_p03 <= 49.9 ){
                     $benef_s03  = 1;
                     $benef_sc03 = "ROJO";
                }else{    
                    if( (float)$benef_p03 = 50 && (float)$benef_p03 <= 69.9 ){
                        $benef_s03  = 2;
                        $benef_sc03 = "NARANJA";
                    }else{    
                        if( (float)$benef_p03 = 70 && (float)$benef_p03 <= 89.9 ){
                            $benef_s03  = 3;
                            $benef_sc03 = "AMARILLO";
                        }else{    
                            if( (float)$benef_p03 = 90 && (float)$benef_p03 <= 110 ){
                                 $benef_s03  = 4;
                                 $benef_sc03 = "VERDE";
                            }else{    
                                if( (float)$benef_p03 > 110 && (float)$benef_p03 <= 300 ){
                                    $benef_s03  = 5;
                                    $benef_sc03 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $benef_p04  = 0;
            $benef_s04  = 0;
            $benef_sc04 = "";                 
            if( (float)$benef_a04 > 0 && (float)$benef_m04 > 0 ){
                $benef_p04 = ( (float)$benef_a04 / (float)$benef_m04) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$benef_p04 = 0 && (float)$benef_p04 <= 49.9 ){
                     $benef_s04  = 1;
                     $benef_sc04 = "ROJO";
                }else{    
                    if( (float)$benef_p04 = 50 && (float)$benef_p04 <= 69.9 ){
                        $benef_s04  = 2;
                        $benef_sc04 = "NARANJA";
                    }else{    
                        if( (float)$benef_p04 = 70 && (float)$benef_p04 <= 89.9 ){
                            $benef_s04  = 3;
                            $benef_sc04 = "AMARILLO";
                        }else{    
                            if( (float)$benef_p04 = 90 && (float)$benef_p04 <= 110 ){
                                 $benef_s04  = 4;
                                 $benef_sc04 = "VERDE";
                            }else{    
                                if( (float)$benef_p04 > 110 && (float)$benef_p04 <= 300 ){
                                    $benef_s04  = 5;
                                    $benef_sc04 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $benef_p05  = 0;
            $benef_s05  = 0;
            $benef_sc05 = "";                 
            if( (float)$benef_a05 > 0 && (float)$benef_m05 > 0 ){
                $benef_p05 = ( (float)$benef_a05 / (float)$benef_m05) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$benef_p05 = 0 && (float)$benef_p05 <= 49.9 ){
                     $benef_s05  = 1;
                     $benef_sc05 = "ROJO";
                }else{    
                    if( (float)$benef_p05 = 50 && (float)$benef_p05 <= 69.9 ){
                        $benef_s05  = 2;
                        $benef_sc05 = "NARANJA";
                    }else{    
                        if( (float)$benef_p05 = 70 && (float)$benef_p05 <= 89.9 ){
                            $benef_s05  = 3;
                            $benef_sc05 = "AMARILLO";
                        }else{    
                            if( (float)$benef_p05 = 90 && (float)$benef_p05 <= 110 ){
                                 $benef_s05  = 4;
                                 $benef_sc05 = "VERDE";
                            }else{    
                                if( (float)$benef_p05 > 110 && (float)$benef_p05 <= 300 ){
                                    $benef_s05  = 5;
                                    $benef_sc05 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $benef_p06  = 0;
            $benef_s06  = 0;
            $benef_sc06 = "";                 
            if( (float)$benef_a06 > 0 && (float)$benef_m06 > 0 ){
                $benef_p06 = ( (float)$benef_a06 / (float)$benef_m06) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$benef_p06 = 0 && (float)$benef_p06 <= 49.9 ){
                     $benef_s06  = 1;
                     $benef_sc06 = "ROJO";
                }else{    
                    if( (float)$benef_p06 = 50 && (float)$benef_p06 <= 69.9 ){
                        $benef_s06  = 2;
                        $benef_sc06 = "NARANJA";
                    }else{    
                        if( (float)$benef_p06 = 70 && (float)$benef_p06 <= 89.9 ){
                            $benef_s06  = 3;
                            $benef_sc06 = "AMARILLO";
                        }else{    
                            if( (float)$benef_p06 = 90 && (float)$benef_p06 <= 110 ){
                                 $benef_s06  = 4;
                                 $benef_sc06 = "VERDE";
                            }else{    
                                if( (float)$benef_p06 > 110 && (float)$benef_p06 <= 300 ){
                                    $benef_s06  = 5;
                                    $benef_sc06 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $benef_p07  = 0;
            $benef_s07  = 0;
            $benef_sc07 = "";                 
            if( (float)$benef_a07 > 0 && (float)$benef_m07 > 0 ){
                $benef_p07 = ( (float)$benef_a07 / (float)$benef_m07) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$benef_p07 = 0 && (float)$benef_p07 <= 49.9 ){
                     $benef_s07  = 1;
                     $benef_sc07 = "ROJO";
                }else{    
                    if( (float)$benef_p07 = 50 && (float)$benef_p07 <= 69.9 ){
                        $benef_s07  = 2;
                        $benef_sc07 = "NARANJA";
                    }else{    
                        if( (float)$benef_p07 = 70 && (float)$benef_p07 <= 89.9 ){
                            $benef_s07  = 3;
                            $benef_sc07 = "AMARILLO";
                        }else{    
                            if( (float)$benef_p07 = 90 && (float)$benef_p07 <= 110 ){
                                 $benef_s07  = 4;
                                 $benef_sc07 = "VERDE";
                            }else{    
                                if( (float)$benef_p07 > 110 && (float)$benef_p07 <= 300 ){
                                    $benef_s07  = 5;
                                    $benef_sc07 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $benef_p08  = 0;
            $benef_s08  = 0;
            $benef_sc08 = "";                 
            if( (float)$benef_a08 > 0 && (float)$benef_m08 > 0 ){
                $benef_p08 = ( (float)$benef_a08 / (float)$benef_m08) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$benef_p08 = 0 && (float)$benef_p08 <= 49.9 ){
                     $benef_s08  = 1;
                     $benef_sc08 = "ROJO";
                }else{    
                    if( (float)$benef_p08 = 50 && (float)$benef_p08 <= 69.9 ){
                        $benef_s08  = 2;
                        $benef_sc08 = "NARANJA";
                    }else{    
                        if( (float)$benef_p08 = 70 && (float)$benef_p08 <= 89.9 ){
                            $benef_s08  = 3;
                            $benef_sc08 = "AMARILLO";
                        }else{    
                            if( (float)$benef_p08 = 90 && (float)$benef_p08 <= 110 ){
                                 $benef_s08  = 4;
                                 $benef_sc08 = "VERDE";
                            }else{    
                                if( (float)$benef_p08 > 110 && (float)$benef_p08 <= 300 ){
                                    $benef_s08  = 5;
                                    $benef_sc08 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $benef_p09  = 0;
            $benef_s09  = 0;
            $benef_sc09 = "";            
            if( (float)$benef_a09 > 0 && (float)$benef_m09 > 0 ){
                $benef_p09 = ( (float)$benef_a09 / (float)$benef_m09) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$benef_p09 = 0 && (float)$benef_p09 <= 49.9 ){
                     $benef_s09  = 1;
                     $benef_sc09 = "ROJO";
                }else{    
                    if( (float)$benef_p09 = 50 && (float)$benef_p09 <= 69.9 ){
                        $benef_s09  = 2;
                        $benef_sc09 = "NARANJA";
                    }else{    
                        if( (float)$benef_p09 = 70 && (float)$benef_p09 <= 89.9 ){
                            $benef_s09  = 3;
                            $benef_sc09 = "AMARILLO";
                        }else{    
                            if( (float)$benef_p09 = 90 && (float)$benef_p09 <= 110 ){
                                 $benef_s09  = 4;
                                 $benef_sc09 = "VERDE";
                            }else{    
                                if( (float)$benef_p09 > 110 && (float)$benef_p09 <= 300 ){
                                    $benef_s09  = 5;
                                    $benef_sc09 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $benef_p10  = 0;
            $benef_s10  = 0;
            $benef_sc10 = "";            
            if( (float)$benef_a10 > 0 && (float)$benef_m10 > 0 ){
                $benef_p10 = ( (float)$benef_a10 / (float)$benef_m10) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$benef_p10 = 0 && (float)$benef_p10 <= 49.9 ){
                     $benef_s10  = 1;
                     $benef_sc10 = "ROJO";
                }else{    
                    if( (float)$benef_p10 = 50 && (float)$benef_p10 <= 69.9 ){
                        $benef_s10  = 2;
                        $benef_sc10 = "NARANJA";
                    }else{    
                        if( (float)$benef_p10 = 70 && (float)$benef_p10 <= 89.9 ){
                            $benef_s10  = 3;
                            $benef_sc10 = "AMARILLO";
                        }else{    
                            if( (float)$benef_p10 = 90 && (float)$benef_p10 <= 110 ){
                                 $benef_s10  = 4;
                                 $benef_sc10 = "VERDE";
                            }else{    
                                if( (float)$benef_p10 > 110 && (float)$benef_p10 <= 300 ){
                                    $benef_s10  = 5;
                                    $benef_sc10 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $benef_p11  = 0;
            $benef_s11  = 0;
            $benef_sc11 = "";
            if( (float)$benef_a11 > 0 && (float)$benef_m11 > 0 ){
                $benef_p11 = ( (float)$benef_a11 / (float)$benef_m11) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$benef_p11 = 0 && (float)$benef_p11 <= 49.9 ){
                     $benef_s11  = 1;
                     $benef_sc11 = "ROJO";
                }else{    
                    if( (float)$benef_p11 = 50 && (float)$benef_p11 <= 69.9 ){
                        $benef_s11  = 2;
                        $benef_sc11 = "NARANJA";
                    }else{    
                        if( (float)$benef_p11 = 70 && (float)$benef_p11 <= 89.9 ){
                            $benef_s11  = 3;
                            $benef_sc11 = "AMARILLO";
                        }else{    
                            if( (float)$benef_p11 = 90 && (float)$benef_p11 <= 110 ){
                                 $benef_s11  = 4;
                                 $benef_sc11 = "VERDE";
                            }else{    
                                if( (float)$benef_p11 > 110 && (float)$benef_p11 <= 300 ){
                                    $benef_s11  = 5;
                                    $benef_sc11 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $benef_p12  = 0;
            $benef_s12  = 0;
            $benef_sc12 = "";
            if( (float)$benef_a12 > 0 && (float)$benef_m12 > 0 ){
                $benef_p12 = ( (float)$benef_a12 / (float)$benef_m12) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$benef_p12 = 0 && (float)$benef_p12 <= 49.9 ){
                     $benef_s12  = 1;
                     $benef_sc12 = "ROJO";
                }else{    
                    if( (float)$benef_p12 = 50 && (float)$benef_p12 <= 69.9 ){
                        $benef_s12  = 2;
                        $benef_sc12 = "NARANJA";
                    }else{    
                        if( (float)$benef_p12 = 70 && (float)$benef_p12 <= 89.9 ){
                            $benef_s12  = 3;
                            $benef_sc12 = "AMARILLO";
                        }else{    
                            if( (float)$benef_p12 = 90 && (float)$benef_p12 <= 110 ){
                                 $benef_s12  = 4;
                                 $benef_sc12 = "VERDE";
                            }else{    
                                if( (float)$benef_p12 > 110 && (float)$benef_p12 <= 300 ){
                                    $benef_s12  = 5;
                                    $benef_sc12 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }

            //*************************************************************************//
            //************ Obtiene valores beneficios programados **********//
            $bene_meta = 0;
            if(isset($request->bene_meta)){
                if(!empty($request->bene_meta)) 
                    $bene_meta = (float)$request->bene_meta;
            }                      
            //$bene_meta = $mesesp[0]->bene_meta;
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

            //*********** Calculamos valores ************************
            $bene_avance = 0;
            if(isset($request->bene_avance)){
                if(!empty($request->bene_avance)) 
                    $bene_avance = (float)$request->bene_avance;
            }          
            $bene_a01 = 0;
            if(isset($request->bene_a01)){
                if(!empty($request->bene_a01)) 
                    $bene_a01 = (float)$request->bene_a01;
            }                      
            $bene_a02 = 0;
            if(isset($request->bene_a02)){
                if(!empty($request->bene_a02)) 
                    $bene_a02 = (float)$request->bene_a02;
            }  
            $bene_a03 = 0;
            if(isset($request->bene_a03)){
                if(!empty($request->bene_a03)) 
                    $bene_a03 = (float)$request->bene_a03;
            }  
            $bene_a04 = 0;
            if(isset($request->bene_a04)){
                if(!empty($request->bene_a04)) 
                    $bene_a04 = (float)$request->bene_a04;
            }  
            $bene_a05 = 0;
            if(isset($request->bene_a05)){
                if(!empty($request->bene_a05)) 
                    $bene_a05 = (float)$request->bene_a05;
            }                                                  
            $bene_a06 = 0;
            if(isset($request->bene_a06)){
                if(!empty($request->bene_a06)) 
                    $bene_a06 = (float)$request->bene_a06;
            }               
            $bene_a07 = 0;
            if(isset($request->bene_a07)){
                if(!empty($request->bene_a07)) 
                    $bene_a07 = (float)$request->bene_a07;
            }          
            $bene_a08 = 0;
            if(isset($request->bene_a08)){
                if(!empty($request->bene_a08)) 
                    $bene_a08 = (float)$request->bene_a08;
            }  
            $bene_a09 = 0;
            if(isset($request->bene_a09)){
                if(!empty($request->bene_a09)) 
                    $bene_a09 = (float)$request->bene_a09;
            }  
            $bene_a10 = 0;
            if(isset($request->bene_a10)){
                if(!empty($request->bene_a10)) 
                    $bene_a10 = (float)$request->bene_a10;
            }  
            $bene_a11 = 0;
            if(isset($request->bene_a11)){
                if(!empty($request->bene_a11)) 
                    $bene_a11 = (float)$request->bene_a11;
            }                                                  
            $bene_a12 = 0;
            if(isset($request->bene_a12)){
                if(!empty($request->bene_a12)) 
                    $bene_a12 = (float)$request->bene_a12;
            }                           
            $bene_at01 = (float)$bene_a01 + (float)$bene_a02 + (float)$bene_a03;
            $bene_at02 = (float)$bene_a04 + (float)$bene_a05 + (float)$bene_a06;
            $bene_at03 = (float)$bene_a07 + (float)$bene_a08 + (float)$bene_a09;
            $bene_at04 = (float)$bene_a10 + (float)$bene_a11 + (float)$bene_a12;

            $bene_as01 = (float)$bene_at01 + (float)$bene_at02;
            $bene_as02 = (float)$bene_at03 + (float)$bene_at04;            

            $bene_aa01 = (float)$bene_as01 + (float)$bene_as02; 

            //********** Calcula porcentaje anual ********************************//
            $bene_pa01  = 0;
            $bene_sa01  = 0;
            $bene_sca01 = "";            
            if( (float)$bene_avance > 0 && (float)$bene_meta > 0 ){
                $bene_pa01  =( (float)$bene_avance / (float)$bene_meta) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$bene_pa01 = 0 && (float)$bene_pa01 <= 49.9 ){
                     $bene_sa01  = 1;
                     $bene_sca01 = "ROJO";
                }else{    
                    if( (float)$bene_pa01 = 50 && (float)$bene_pa01 <= 69.9 ){
                        $bene_sa01  = 2;
                        $bene_sca01 = "NARANJA";
                    }else{    
                        if( (float)$bene_pa01 = 70 && (float)$bene_pa01 <= 89.9 ){
                            $bene_sa01  = 3;
                            $bene_sca01 = "AMARILLO";
                        }else{    
                            if( (float)$bene_pa01 = 90 && (float)$bene_pa01 <= 110 ){
                                 $bene_sa01  = 4;
                                 $bene_sca01 = "VERDE";
                            }else{    
                                if( (float)$bene_pa01 > 110 && (float)$bene_pa01 <= 300 ){
                                    $bene_sa01  = 5;
                                    $bene_sca01 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }

            //********** Calcula porcentajes semestrales ********************************//
            $bene_ps01  = 0;
            $bene_ss01  = 0;
            $bene_scs01 = "";                        
            if( (float)$bene_as01 > 0 && (float)$bene_ms01 > 0 ){
                $bene_ps01 = ( (float)$bene_as01 / (float)$bene_ms01) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$bene_ps01 = 0 && (float)$bene_ps01 <= 49.9 ){
                     $bene_ss01  = 1;
                     $bene_scs01 = "ROJO";
                }else{    
                    if( (float)$bene_ps01 = 50 && (float)$bene_ps01 <= 69.9 ){
                        $bene_ss01  = 2;
                        $bene_scs01 = "NARANJA";
                    }else{    
                        if( (float)$bene_ps01 = 70 && (float)$bene_ps01 <= 89.9 ){
                            $bene_ss01  = 3;
                            $bene_scs01 = "AMARILLO";
                        }else{    
                            if( (float)$bene_ps01 = 90 && (float)$bene_ps01 <= 110 ){
                                 $bene_ss01  = 4;
                                 $bene_scs01 = "VERDE";
                            }else{    
                                if( (float)$bene_ps01 > 110 && (float)$bene_ps01 <= 300 ){
                                    $bene_ss01  = 5;
                                    $bene_scs01 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $bene_ps02  = 0;
            $bene_ss02  = 0;
            $bene_scs02 = "";            
            if( (float)$bene_as02 > 0 && (float)$bene_ms02 > 0 ){
                $bene_ps02 = ( (float)$bene_as02 / (float)$bene_ms02) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$bene_ps02 = 0 && (float)$bene_ps02 <= 49.9 ){
                     $bene_ss02  = 1;
                     $bene_scs02 = "ROJO";
                }else{    
                    if( (float)$bene_ps02 = 50 && (float)$bene_ps02 <= 69.9 ){
                        $bene_ss02  = 2;
                        $bene_scs02 = "NARANJA";
                    }else{    
                        if( (float)$bene_ps02 = 70 && (float)$bene_ps02 <= 89.9 ){
                            $bene_ss02  = 3;
                            $bene_scs02 = "AMARILLO";
                        }else{    
                            if( (float)$bene_ps02 = 90 && (float)$bene_ps02 <= 110 ){
                                 $bene_ss02  = 4;
                                 $bene_scs02 = "VERDE";
                            }else{    
                                if( (float)$bene_ps02 > 110 && (float)$bene_ps02 <= 300 ){
                                    $bene_ss02  = 5;
                                    $bene_scs02 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }

            //********** Calcula porcentajes trimestrales ********************************//
            $bene_pt01  = 0;
            $bene_st01  = 0;
            $bene_sct01 = "";                        
            if( (float)$bene_at01 > 0 && (float)$bene_mt01 > 0 ){
                $bene_pt01 = ( (float)$bene_at01 / (float)$bene_mt01) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$bene_pt01 = 0 && (float)$bene_pt01 <= 49.9 ){
                     $bene_st01  = 1;
                     $bene_sct01 = "ROJO";
                }else{    
                    if( (float)$bene_pt01 = 50 && (float)$bene_pt01 <= 69.9 ){
                        $bene_st01  = 2;
                        $bene_sct01 = "NARANJA";
                    }else{    
                        if( (float)$bene_pt01 = 70 && (float)$bene_pt01 <= 89.9 ){
                            $bene_st01  = 3;
                            $bene_sct01 = "AMARILLO";
                        }else{    
                            if( (float)$bene_pt01 = 90 && (float)$bene_pt01 <= 110 ){
                                 $bene_st01  = 4;
                                 $bene_sct01 = "VERDE";
                            }else{    
                                if( (float)$bene_pt01 > 110 && (float)$bene_pt01 <= 300 ){
                                    $bene_st01  = 5;
                                    $bene_sct01 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $bene_pt02  = 0;
            $bene_st02  = 0;
            $bene_sct02 = "";                        
            if( (float)$bene_at02 > 0 && (float)$bene_mt02 > 0 ){
                $bene_pt02 = ( (float)$bene_at02 / (float)$bene_mt02) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$bene_pt02 = 0 && (float)$bene_pt02 <= 49.9 ){
                     $bene_st02  = 1;
                     $bene_sct02 = "ROJO";
                }else{    
                    if( (float)$bene_pt02 = 50 && (float)$bene_pt02 <= 69.9 ){
                        $bene_st02  = 2;
                        $bene_sct02 = "NARANJA";
                    }else{    
                        if( (float)$bene_pt02 = 70 && (float)$bene_pt02 <= 89.9 ){
                            $bene_st02  = 3;
                            $bene_sct02 = "AMARILLO";
                        }else{    
                            if( (float)$bene_pt02 = 90 && (float)$bene_pt02 <= 110 ){
                                 $bene_st02  = 4;
                                 $bene_sct02 = "VERDE";
                            }else{    
                                if( (float)$bene_pt02 > 110 && (float)$bene_pt02 <= 300 ){
                                    $bene_st02  = 5;
                                    $bene_sct02 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $bene_pt03  = 0;
            $bene_st03  = 0;
            $bene_sct03 = "";                        
            if( (float)$bene_at03 > 0 && (float)$bene_mt03 > 0 ){
                $bene_pt03 = ( (float)$bene_at03 / (float)$bene_mt03) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$bene_pt03 = 0 && (float)$bene_pt03 <= 49.9 ){
                     $bene_st03  = 1;
                     $bene_sct03 = "ROJO";
                }else{    
                    if( (float)$bene_pt03 = 50 && (float)$bene_pt03 <= 69.9 ){
                        $bene_st03  = 2;
                        $bene_sct03 = "NARANJA";
                    }else{    
                        if( (float)$bene_pt03 = 70 && (float)$bene_pt03 <= 89.9 ){
                            $bene_st03  = 3;
                            $bene_sct03 = "AMARILLO";
                        }else{    
                            if( (float)$bene_pt03 = 90 && (float)$bene_pt03 <= 110 ){
                                 $bene_st03  = 4;
                                 $bene_sct03 = "VERDE";
                            }else{    
                                if( (float)$bene_pt03 > 110 && (float)$bene_pt03 <= 300 ){
                                    $bene_st03  = 5;
                                    $bene_sct03 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $bene_pt04  = 0;
            $bene_st04  = 0;
            $bene_sct04 = "";            
            if( (float)$bene_at04 > 0 && (float)$bene_mt04 > 0 ){
                $bene_pt04 = ( (float)$bene_at04 / (float)$bene_mt04) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$bene_pt04 = 0 && (float)$bene_pt04 <= 49.9 ){
                     $bene_st04  = 1;
                     $bene_sct04 = "ROJO";
                }else{    
                    if( (float)$bene_pt04 = 50 && (float)$bene_pt04 <= 69.9 ){
                        $bene_st04  = 2;
                        $bene_sct04 = "NARANJA";
                    }else{    
                        if( (float)$bene_pt04 = 70 && (float)$bene_pt04 <= 89.9 ){
                            $bene_st04  = 3;
                            $bene_sct04 = "AMARILLO";
                        }else{    
                            if( (float)$bene_pt04 = 90 && (float)$bene_pt04 <= 110 ){
                                 $bene_st04  = 4;
                                 $bene_sct04 = "VERDE";
                            }else{    
                                if( (float)$bene_pt04 > 110 && (float)$bene_pt04 <= 300 ){
                                    $bene_st04  = 5;
                                    $bene_sct04 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }

            //********** Calcula porcentajes mesuales ********************************//
            $bene_p01  = 0;
            $bene_s01  = 0;
            $bene_sc01 = "";                 
            if( (float)$bene_a01 > 0 && (float)$bene_m01 > 0 ){
                $bene_p01 = ( (float)$bene_a01 / (float)$bene_m01) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$bene_p01 = 0 && (float)$bene_p01 <= 49.9 ){
                     $bene_s01  = 1;
                     $bene_sc01 = "ROJO";
                }else{    
                    if( (float)$bene_p01 = 50 && (float)$bene_p01 <= 69.9 ){
                        $bene_s01  = 2;
                        $bene_sc01 = "NARANJA";
                    }else{    
                        if( (float)$bene_p01 = 70 && (float)$bene_p01 <= 89.9 ){
                            $bene_s01  = 3;
                            $bene_sc01 = "AMARILLO";
                        }else{    
                            if( (float)$bene_p01 = 90 && (float)$bene_p01 <= 110 ){
                                 $bene_s01  = 4;
                                 $bene_sc01 = "VERDE";
                            }else{    
                                if( (float)$bene_p01 > 110 && (float)$bene_p01 <= 300 ){
                                    $bene_s01  = 5;
                                    $bene_sc01 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $bene_p02  = 0;
            $bene_s02  = 0;
            $bene_sc02 = "";                 
            if( (float)$bene_a02 > 0 && (float)$bene_m02 > 0 ){
                $bene_p02 = ( (float)$bene_a02 / (float)$bene_m02) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$bene_p02 = 0 && (float)$bene_p02 <= 49.9 ){
                     $bene_s02  = 1;
                     $bene_sc02 = "ROJO";
                }else{    
                    if( (float)$bene_p02 = 50 && (float)$bene_p02 <= 69.9 ){
                        $bene_s02  = 2;
                        $bene_sc02 = "NARANJA";
                    }else{    
                        if( (float)$bene_p02 = 70 && (float)$bene_p02 <= 89.9 ){
                            $bene_s02  = 3;
                            $bene_sc02 = "AMARILLO";
                        }else{    
                            if( (float)$bene_p02 = 90 && (float)$bene_p02 <= 110 ){
                                 $bene_s02  = 4;
                                 $bene_sc02 = "VERDE";
                            }else{    
                                if( (float)$bene_p02 > 110 && (float)$bene_p02 <= 300 ){
                                    $bene_s02  = 5;
                                    $bene_sc02 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $bene_p03  = 0;
            $bene_s03  = 0;
            $bene_sc03 = "";                 
            if( (float)$bene_a03 > 0 && (float)$bene_m03 > 0 ){
                $bene_p03 = ( (float)$bene_a03 / (float)$bene_m03) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$bene_p03 = 0 && (float)$bene_p03 <= 49.9 ){
                     $bene_s03  = 1;
                     $bene_sc03 = "ROJO";
                }else{    
                    if( (float)$bene_p03 = 50 && (float)$bene_p03 <= 69.9 ){
                        $bene_s03  = 2;
                        $bene_sc03 = "NARANJA";
                    }else{    
                        if( (float)$bene_p03 = 70 && (float)$bene_p03 <= 89.9 ){
                            $bene_s03  = 3;
                            $bene_sc03 = "AMARILLO";
                        }else{    
                            if( (float)$bene_p03 = 90 && (float)$bene_p03 <= 110 ){
                                 $bene_s03  = 4;
                                 $bene_sc03 = "VERDE";
                            }else{    
                                if( (float)$bene_p03 > 110 && (float)$bene_p03 <= 300 ){
                                    $bene_s03  = 5;
                                    $bene_sc03 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $bene_p04  = 0;
            $bene_s04  = 0;
            $bene_sc04 = "";                 
            if( (float)$bene_a04 > 0 && (float)$bene_m04 > 0 ){
                $bene_p04 = ( (float)$bene_a04 / (float)$bene_m04) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$bene_p04 = 0 && (float)$bene_p04 <= 49.9 ){
                     $bene_s04  = 1;
                     $bene_sc04 = "ROJO";
                }else{    
                    if( (float)$bene_p04 = 50 && (float)$bene_p04 <= 69.9 ){
                        $bene_s04  = 2;
                        $bene_sc04 = "NARANJA";
                    }else{    
                        if( (float)$bene_p04 = 70 && (float)$bene_p04 <= 89.9 ){
                            $bene_s04  = 3;
                            $bene_sc04 = "AMARILLO";
                        }else{    
                            if( (float)$bene_p04 = 90 && (float)$bene_p04 <= 110 ){
                                 $bene_s04  = 4;
                                 $bene_sc04 = "VERDE";
                            }else{    
                                if( (float)$bene_p04 > 110 && (float)$bene_p04 <= 300 ){
                                    $bene_s04  = 5;
                                    $bene_sc04 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $bene_p05  = 0;
            $bene_s05  = 0;
            $bene_sc05 = "";                 
            if( (float)$bene_a05 > 0 && (float)$bene_m05 > 0 ){
                $bene_p05 = ( (float)$bene_a05 / (float)$bene_m05) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$bene_p05 = 0 && (float)$bene_p05 <= 49.9 ){
                     $bene_s05  = 1;
                     $bene_sc05 = "ROJO";
                }else{    
                    if( (float)$bene_p05 = 50 && (float)$bene_p05 <= 69.9 ){
                        $bene_s05  = 2;
                        $bene_sc05 = "NARANJA";
                    }else{    
                        if( (float)$bene_p05 = 70 && (float)$bene_p05 <= 89.9 ){
                            $bene_s05  = 3;
                            $bene_sc05 = "AMARILLO";
                        }else{    
                            if( (float)$bene_p05 = 90 && (float)$bene_p05 <= 110 ){
                                 $bene_s05  = 4;
                                 $bene_sc05 = "VERDE";
                            }else{    
                                if( (float)$bene_p05 > 110 && (float)$bene_p05 <= 300 ){
                                    $bene_s05  = 5;
                                    $bene_sc05 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $bene_p06  = 0;
            $bene_s06  = 0;
            $bene_sc06 = "";                 
            if( (float)$bene_a06 > 0 && (float)$bene_m06 > 0 ){
                $bene_p06 = ( (float)$bene_a06 / (float)$bene_m06) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$bene_p06 = 0 && (float)$bene_p06 <= 49.9 ){
                     $bene_s06  = 1;
                     $bene_sc06 = "ROJO";
                }else{    
                    if( (float)$bene_p06 = 50 && (float)$bene_p06 <= 69.9 ){
                        $bene_s06  = 2;
                        $bene_sc06 = "NARANJA";
                    }else{    
                        if( (float)$bene_p06 = 70 && (float)$bene_p06 <= 89.9 ){
                            $bene_s06  = 3;
                            $bene_sc06 = "AMARILLO";
                        }else{    
                            if( (float)$bene_p06 = 90 && (float)$bene_p06 <= 110 ){
                                 $bene_s06  = 4;
                                 $bene_sc06 = "VERDE";
                            }else{    
                                if( (float)$bene_p06 > 110 && (float)$bene_p06 <= 300 ){
                                    $bene_s06  = 5;
                                    $bene_sc06 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $bene_p07  = 0;
            $bene_s07  = 0;
            $bene_sc07 = "";                 
            if( (float)$bene_a07 > 0 && (float)$bene_m07 > 0 ){
                $bene_p07 = ( (float)$bene_a07 / (float)$bene_m07) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$bene_p07 = 0 && (float)$bene_p07 <= 49.9 ){
                     $bene_s07  = 1;
                     $bene_sc07 = "ROJO";
                }else{    
                    if( (float)$bene_p07 = 50 && (float)$bene_p07 <= 69.9 ){
                        $bene_s07  = 2;
                        $bene_sc07 = "NARANJA";
                    }else{    
                        if( (float)$bene_p07 = 70 && (float)$bene_p07 <= 89.9 ){
                            $bene_s07  = 3;
                            $bene_sc07 = "AMARILLO";
                        }else{    
                            if( (float)$bene_p07 = 90 && (float)$bene_p07 <= 110 ){
                                 $bene_s07  = 4;
                                 $bene_sc07 = "VERDE";
                            }else{    
                                if( (float)$bene_p07 > 110 && (float)$bene_p07 <= 300 ){
                                    $bene_s07  = 5;
                                    $bene_sc07 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $bene_p08  = 0;
            $bene_s08  = 0;
            $bene_sc08 = "";                 
            if( (float)$bene_a08 > 0 && (float)$bene_m08 > 0 ){
                $bene_p08 = ( (float)$bene_a08 / (float)$bene_m08) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$bene_p08 = 0 && (float)$bene_p08 <= 49.9 ){
                     $bene_s08  = 1;
                     $bene_sc08 = "ROJO";
                }else{    
                    if( (float)$bene_p08 = 50 && (float)$bene_p08 <= 69.9 ){
                        $bene_s08  = 2;
                        $bene_sc08 = "NARANJA";
                    }else{    
                        if( (float)$bene_p08 = 70 && (float)$bene_p08 <= 89.9 ){
                            $bene_s08  = 3;
                            $bene_sc08 = "AMARILLO";
                        }else{    
                            if( (float)$bene_p08 = 90 && (float)$bene_p08 <= 110 ){
                                 $bene_s08  = 4;
                                 $bene_sc08 = "VERDE";
                            }else{    
                                if( (float)$bene_p08 > 110 && (float)$bene_p08 <= 300 ){
                                    $bene_s08  = 5;
                                    $bene_sc08 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $bene_p09  = 0;
            $bene_s09  = 0;
            $bene_sc09 = "";            
            if( (float)$bene_a09 > 0 && (float)$bene_m09 > 0 ){
                $bene_p09 = ( (float)$bene_a09 / (float)$bene_m09) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$bene_p09 = 0 && (float)$bene_p09 <= 49.9 ){
                     $bene_s09  = 1;
                     $bene_sc09 = "ROJO";
                }else{    
                    if( (float)$bene_p09 = 50 && (float)$bene_p09 <= 69.9 ){
                        $bene_s09  = 2;
                        $bene_sc09 = "NARANJA";
                    }else{    
                        if( (float)$bene_p09 = 70 && (float)$bene_p09 <= 89.9 ){
                            $bene_s09  = 3;
                            $bene_sc09 = "AMARILLO";
                        }else{    
                            if( (float)$bene_p09 = 90 && (float)$bene_p09 <= 110 ){
                                 $bene_s09  = 4;
                                 $bene_sc09 = "VERDE";
                            }else{    
                                if( (float)$bene_p09 > 110 && (float)$bene_p09 <= 300 ){
                                    $bene_s09  = 5;
                                    $bene_sc09 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $bene_p10  = 0;
            $bene_s10  = 0;
            $bene_sc10 = "";            
            if( (float)$bene_a10 > 0 && (float)$bene_m10 > 0 ){
                $bene_p10 = ( (float)$bene_a10 / (float)$bene_m10) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$bene_p10 = 0 && (float)$bene_p10 <= 49.9 ){
                     $bene_s10  = 1;
                     $bene_sc10 = "ROJO";
                }else{    
                    if( (float)$bene_p10 = 50 && (float)$bene_p10 <= 69.9 ){
                        $bene_s10  = 2;
                        $bene_sc10 = "NARANJA";
                    }else{    
                        if( (float)$bene_p10 = 70 && (float)$bene_p10 <= 89.9 ){
                            $bene_s10  = 3;
                            $bene_sc10 = "AMARILLO";
                        }else{    
                            if( (float)$bene_p10 = 90 && (float)$bene_p10 <= 110 ){
                                 $bene_s10  = 4;
                                 $bene_sc10 = "VERDE";
                            }else{    
                                if( (float)$bene_p10 > 110 && (float)$bene_p10 <= 300 ){
                                    $bene_s10  = 5;
                                    $bene_sc10 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $bene_p11  = 0;
            $bene_s11  = 0;
            $bene_sc11 = "";
            if( (float)$bene_a11 > 0 && (float)$bene_m11 > 0 ){
                $bene_p11 = ( (float)$bene_a11 / (float)$bene_m11) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$bene_p11 = 0 && (float)$bene_p11 <= 49.9 ){
                     $bene_s11  = 1;
                     $bene_sc11 = "ROJO";
                }else{    
                    if( (float)$bene_p11 = 50 && (float)$bene_p11 <= 69.9 ){
                        $bene_s11  = 2;
                        $bene_sc11 = "NARANJA";
                    }else{    
                        if( (float)$bene_p11 = 70 && (float)$bene_p11 <= 89.9 ){
                            $bene_s11  = 3;
                            $bene_sc11 = "AMARILLO";
                        }else{    
                            if( (float)$bene_p11 = 90 && (float)$bene_p11 <= 110 ){
                                 $bene_s11  = 4;
                                 $bene_sc11 = "VERDE";
                            }else{    
                                if( (float)$bene_p11 > 110 && (float)$bene_p11 <= 300 ){
                                    $bene_s11  = 5;
                                    $bene_sc11 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }
            $bene_p12  = 0;
            $bene_s12  = 0;
            $bene_sc12 = "";
            if( (float)$bene_a12 > 0 && (float)$bene_m12 > 0 ){
                $bene_p12 = ( (float)$bene_a12 / (float)$bene_m12) * 100; 
                //********** Calcular semáforo y color *************************//
                if( (float)$bene_p12 = 0 && (float)$bene_p12 <= 49.9 ){
                     $bene_s12  = 1;
                     $bene_sc12 = "ROJO";
                }else{    
                    if( (float)$bene_p12 = 50 && (float)$bene_p12 <= 69.9 ){
                        $bene_s12  = 2;
                        $bene_sc12 = "NARANJA";
                    }else{    
                        if( (float)$bene_p12 = 70 && (float)$bene_p12 <= 89.9 ){
                            $bene_s12  = 3;
                            $bene_sc12 = "AMARILLO";
                        }else{    
                            if( (float)$bene_p12 = 90 && (float)$bene_p12 <= 110 ){
                                 $bene_s12  = 4;
                                 $bene_sc12 = "VERDE";
                            }else{    
                                if( (float)$bene_p12 > 110 && (float)$bene_p12 <= 300 ){
                                    $bene_s12  = 5;
                                    $bene_sc12 = "MORADO";
                                }
                            }
                        }                      
                    }
                }
            }

            //*************************************************************************//
            //*********** Calculamos valores presupuesto metas ************************//
            $finan_meta = 0;
            if(isset($request->finan_meta)){
                if(!empty($request->finan_meta)) 
                    $finan_meta = (float)$request->finan_meta;
            }                  
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

            $finan_ms01 =(float)$finan_mt01+(float)$finan_mt02;
            $finan_ms02 =(float)$finan_mt03+(float)$finan_mt04;            

            $finan_ma01  = (float)$finan_ms01 + (float)$finan_ms02;          
            
            //*********** Calculamos valores presupuesto avances ************************
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
            $regdistmuni = regDistmunicipioModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'MUNICIPIO_ID' => $id3])
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

                                         'BENEF_AVANCE'  => $request->benef_avance,
                                         'BENEF_A01'     => $benef_a01,
                                         'BENEF_A02'     => $benef_a02,
                                         'BENEF_A03'     => $benef_a03,
                                         'BENEF_A04'     => $benef_a04,
                                         'BENEF_A05'     => $benef_a05,
                                         'BENEF_A06'     => $benef_a06,
                                         'BENEF_A07'     => $benef_a07,
                                         'BENEF_A08'     => $benef_a08,
                                         'BENEF_A09'     => $benef_a09,
                                         'BENEF_A10'     => $benef_a10,
                                         'BENEF_A11'     => $benef_a11,
                                         'BENEF_A12'     => $benef_a12,   
                                         'BENEF_AT01'    => $benef_at01,
                                         'BENEF_AT02'    => $benef_at02,
                                         'BENEF_AT03'    => $benef_at03,
                                         'BENEF_AT04'    => $benef_at04,
                                         'BENEF_AS01'    => $benef_as01,
                                         'BENEF_AS02'    => $benef_as02,
                                         'BENEF_AA01'    => $benef_aa01,

                                         'BENEF_P01'     => $benef_p01,
                                         'BENEF_P02'     => $benef_p02,
                                         'BENEF_P03'     => $benef_p03,
                                         'BENEF_P04'     => $benef_p04,
                                         'BENEF_P05'     => $benef_p05,
                                         'BENEF_P06'     => $benef_p06,
                                         'BENEF_P07'     => $benef_p07,
                                         'BENEF_P08'     => $benef_p08,
                                         'BENEF_P09'     => $benef_p09,
                                         'BENEF_P10'     => $benef_p10,
                                         'BENEF_P11'     => $benef_p11,
                                         'BENEF_P12'     => $benef_p12,   
                                         'BENEF_PT01'    => $benef_pt01,
                                         'BENEF_PT02'    => $benef_pt02,
                                         'BENEF_PT03'    => $benef_pt03,
                                         'BENEF_PT04'    => $benef_pt04,
                                         'BENEF_PS01'    => $benef_ps01,
                                         'BENEF_PS02'    => $benef_ps02,
                                         'BENEF_PA01'    => $benef_pa01,

                                         'BENEF_S01'     => $benef_s01,
                                         'BENEF_S02'     => $benef_s02,
                                         'BENEF_S03'     => $benef_s03,
                                         'BENEF_S04'     => $benef_s04,
                                         'BENEF_S05'     => $benef_s05,
                                         'BENEF_S06'     => $benef_s06,
                                         'BENEF_S07'     => $benef_s07,
                                         'BENEF_S08'     => $benef_s08,
                                         'BENEF_S09'     => $benef_s09,
                                         'BENEF_S10'     => $benef_s10,
                                         'BENEF_S11'     => $benef_s11,
                                         'BENEF_S12'     => $benef_s12,   
                                         'BENEF_ST01'    => $benef_st01,
                                         'BENEF_ST02'    => $benef_st02,
                                         'BENEF_ST03'    => $benef_st03,
                                         'BENEF_ST04'    => $benef_st04,
                                         'BENEF_SS01'    => $benef_ss01,
                                         'BENEF_SS02'    => $benef_ss02,
                                         'BENEF_SA01'    => $benef_sa01,                                         

                                         'BENEF_SC01'    => $benef_sc01,
                                         'BENEF_SC02'    => $benef_sc02,
                                         'BENEF_SC03'    => $benef_sc03,
                                         'BENEF_SC04'    => $benef_sc04,
                                         'BENEF_SC05'    => $benef_sc05,
                                         'BENEF_SC06'    => $benef_sc06,
                                         'BENEF_SC07'    => $benef_sc07,
                                         'BENEF_SC08'    => $benef_sc08,
                                         'BENEF_SC09'    => $benef_sc09,
                                         'BENEF_SC10'    => $benef_sc10,
                                         'BENEF_SC11'    => $benef_sc11,
                                         'BENEF_SC12'    => $benef_sc12,   
                                         'BENEF_SCT01'   => $benef_sct01,
                                         'BENEF_SCT02'   => $benef_sct02,
                                         'BENEF_SCT03'   => $benef_sct03,
                                         'BENEF_SCT04'   => $benef_sct04,
                                         'BENEF_SCS01'   => $benef_scs01,
                                         'BENEF_SCS02'   => $benef_scs02,
                                         'BENEF_SCA01'   => $benef_sca01, 

                                         'BENE_AVANCE'  => $request->bene_avance,
                                         'BENE_A01'     => $bene_a01,
                                         'BENE_A02'     => $bene_a02,
                                         'BENE_A03'     => $bene_a03,
                                         'BENE_A04'     => $bene_a04,
                                         'BENE_A05'     => $bene_a05,
                                         'BENE_A06'     => $bene_a06,
                                         'BENE_A07'     => $bene_a07,
                                         'BENE_A08'     => $bene_a08,
                                         'BENE_A09'     => $bene_a09,
                                         'BENE_A10'     => $bene_a10,
                                         'BENE_A11'     => $bene_a11,
                                         'BENE_A12'     => $bene_a12,   
                                         'BENE_AT01'    => $bene_at01,
                                         'BENE_AT02'    => $bene_at02,
                                         'BENE_AT03'    => $bene_at03,
                                         'BENE_AT04'    => $bene_at04,
                                         'BENE_AS01'    => $bene_as01,
                                         'BENE_AS02'    => $bene_as02,
                                         'BENE_AA01'    => $bene_aa01,

                                         'BENE_P01'     => $bene_p01,
                                         'BENE_P02'     => $bene_p02,
                                         'BENE_P03'     => $bene_p03,
                                         'BENE_P04'     => $bene_p04,
                                         'BENE_P05'     => $bene_p05,
                                         'BENE_P06'     => $bene_p06,
                                         'BENE_P07'     => $bene_p07,
                                         'BENE_P08'     => $bene_p08,
                                         'BENE_P09'     => $bene_p09,
                                         'BENE_P10'     => $bene_p10,
                                         'BENE_P11'     => $bene_p11,
                                         'BENE_P12'     => $bene_p12,   
                                         'BENE_PT01'    => $bene_pt01,
                                         'BENE_PT02'    => $bene_pt02,
                                         'BENE_PT03'    => $bene_pt03,
                                         'BENE_PT04'    => $bene_pt04,
                                         'BENE_PS01'    => $bene_ps01,
                                         'BENE_PS02'    => $bene_ps02,
                                         'BENE_PA01'    => $bene_pa01,

                                         'BENE_S01'     => $bene_s01,
                                         'BENE_S02'     => $bene_s02,
                                         'BENE_S03'     => $bene_s03,
                                         'BENE_S04'     => $bene_s04,
                                         'BENE_S05'     => $bene_s05,
                                         'BENE_S06'     => $bene_s06,
                                         'BENE_S07'     => $bene_s07,
                                         'BENE_S08'     => $bene_s08,
                                         'BENE_S09'     => $bene_s09,
                                         'BENE_S10'     => $bene_s10,
                                         'BENE_S11'     => $bene_s11,
                                         'BENE_S12'     => $bene_s12,   
                                         'BENE_ST01'    => $bene_st01,
                                         'BENE_ST02'    => $bene_st02,
                                         'BENE_ST03'    => $bene_st03,
                                         'BENE_ST04'    => $bene_st04,
                                         'BENE_SS01'    => $bene_ss01,
                                         'BENE_SS02'    => $bene_ss02,
                                         'BENE_SA01'    => $bene_sa01,                                         

                                         'BENE_SC01'    => $bene_sc01,
                                         'BENE_SC02'    => $bene_sc02,
                                         'BENE_SC03'    => $bene_sc03,
                                         'BENE_SC04'    => $bene_sc04,
                                         'BENE_SC05'    => $bene_sc05,
                                         'BENE_SC06'    => $bene_sc06,
                                         'BENE_SC07'    => $bene_sc07,
                                         'BENE_SC08'    => $bene_sc08,
                                         'BENE_SC09'    => $bene_sc09,
                                         'BENE_SC10'    => $bene_sc10,
                                         'BENE_SC11'    => $bene_sc11,
                                         'BENE_SC12'    => $bene_sc12,   
                                         'BENE_SCT01'   => $bene_sct01,
                                         'BENE_SCT02'   => $bene_sct02,
                                         'BENE_SCT03'   => $bene_sct03,
                                         'BENE_SCT04'   => $bene_sct04,
                                         'BENE_SCS01'   => $bene_scs01,
                                         'BENE_SCS02'   => $bene_scs02,
                                         'BENE_SCA01'   => $bene_sca01,                                                                                   

                                         'IP_M'          => $ip,
                                         'LOGIN_M'       => $nombre,
                                         'FECHA_M2'      => date('Y/m/d'),   //date('d/m/Y')            
                                         'FECHA_M'       => date('Y/m/d')    //date('d/m/Y')   
                              ]);
            toastr()->success('distribución por municipio actualizado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =        53;    //Actualizar 
            $regbitacora = regBitacoraModel::select('PERIODO_ID','MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
                                                    'TRX_ID',    'FOLIO',  'NO_VECES',   'FECHA_REG', 'IP', 
                                                    'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
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
                    toastr()->success('Trx de actualización de distribución por municipio registrado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error Trx de distribución por municipio  actualizado en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
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
                toastr()->success('Trx de actualización de distribución por municipio registrado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                     
        }       /************ Actualizar *******************************************/
        return redirect()->route('verdistmuniavan');
    }

    public function actionBorrarDistmuniavan($id, $id2, $id3){
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

        /************ Elimina **************************************/
        $regdistmuni  = regDistmunicipioModel::select('PERIODO_ID','PROG_ID','MUNICIPIO_ID','FINAN_META','FINAN_AVANCE',
                        'FINAN_M01','FINAN_M02','FINAN_M03','FINAN_M04','FINAN_M05','FINAN_M06',
                        'FINAN_M07','FINAN_M08','FINAN_M09','FINAN_M10','FINAN_M11','FINAN_M12',
                        'FINAN_MT01','FINAN_MT02','FINAN_MT03','FINAN_MT04','FINAN_MS01','FINAN_MS02','FINAN_MA01',
                        'FINAN_A01','FINAN_A02','FINAN_A03','FINAN_A04','FINAN_A05','FINAN_A06',
                        'FINAN_A07','FINAN_A08','FINAN_A09','FINAN_A10','FINAN_A11','FINAN_A12',
                        'FINAN_AT01','FINAN_AT02','FINAN_AT03','FINAN_AT04','FINAN_AS01','FINAN_AS02','FINAN_AA01'
                        )
                        ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'MUNICIPIO_ID' => $id3]);
        if($regdistmuni->count() <= 0)
            toastr()->error('No existe distribución por municipio.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            $regdistmuni->delete();
            toastr()->success('distribución por municipio eliminado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            //echo 'Ya entre a borrar registro..........';
            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =        54;     // Baja 

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
                    toastr()->success('Trx de baja de distribución por municipio registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error en Trx de baja de distribución por municipio en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
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
                toastr()->success('Trx de distribución por municipio registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                 
        }       /************* Termina de eliminar **********************************/
        return redirect()->route('verdistmuniavan');
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
        $xtrx_id      =        55;            // Exportar a formato Excel
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
        $xtrx_id      =        56;       //Exportar a formato PDF
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

        $regdistmuni  = regDistmunicipioModel::select('PROG_ID','PROG_DESC','PROG_SIGLAS','PROG_VIGENTE', 
                                              'CLASIFICGOB_ID','PRIORIDAD_ID',
                                              'PROG_ORDEN','PROG_TIPO','PROG_SEPUBLICA','PROG_OBS1', 
                                              'PROG_OBS2','PROG_STATUS1','PROG_STATUS2','PROG_FECREG')
                                     ->orderBy('PROG_ID','ASC')
                                     ->get();                               
        if($regdistmuni->count() <= 0){
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
