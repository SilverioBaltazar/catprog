<?php
//**************************************************************/
//* File:       finanpresController.php
//* Función:    Financiamiento presupuestario encabezado
//* Autor:      Ing. Silverio Baltazar Barrientos Zarate
//* Modifico:   Ing. Silverio Baltazar Barrientos Zarate
//* Fecha act.: febrero 2022
//* @Derechos reservados. Gobierno del Estado de México
//*************************************************************/
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\finanpresRequest;
use App\Http\Requests\finanpres1Request;
use App\Http\Requests\finanpres2Request;
use App\Http\Requests\finanpres3Request;
use App\Http\Requests\finanpresdetRequest;

use App\regBitacoraModel;
use App\regPeriodosModel;
use App\regMesesModel;
use App\regDiasModel;
use App\regFuentesModel;
use App\regTipogastoModel;
use App\regConacModel;
use App\regSectoresModel;
use App\regSubsectoresModel;
use App\regProgramasModel;
use App\regProgramaModel;
use App\regProyectosModel;
use App\regFinanpresModel;
use App\regfinandetModel;

// Exportar a excel 
use App\Exports\ExportFinanpresExcel;
use Maatwebsite\Excel\Facades\Excel;
// Exportar a pdf
use PDF;
//use Options;

class finanpresupController extends Controller
{

    public function actionBuscarFinanpres(Request $request)
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
                        ->orderBy('PERIODO_ID','ASC')
                        ->get();  
        $regproyectos = regProyectosModel::select('PROY_ID','PROY_DESC')
                        ->orderBy('PROY_ID','ASC')
                        ->get();
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')
                        ->get();      
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')
                        ->get(); 
        $totactivs    = regFinanpresModel::join('CP_FINAN_PRESUP_DETALLE',
                                              [['CP_FINAN_PRESUP_DETALLE.PERIODO_ID','=','CP_FINAN_PRESUP.PERIODO_ID'],
                                               ['CP_FINAN_PRESUP_DETALLE.PROG_ID'   ,'=','CP_FINAN_PRESUP.PROG_ID']])
                        ->select(   'CP_FINAN_PRESUP.PERIODO_ID','CP_FINAN_PRESUP.PROG_ID')
                        ->selectRaw('COUNT(*) AS TOTPRESUPUESTO')
                        ->groupBy(  'CP_FINAN_PRESUP.PERIODO_ID','CP_FINAN_PRESUP.PROG_ID')
                        ->get();                              
        //**************************************************************//
        // ***** busqueda https://github.com/rimorsoft/Search-simple ***//
        // ***** video https://www.youtube.com/watch?v=bmtD9GUaszw   ***//                            
        //**************************************************************//
        $folio   = $request->get('folio');   
        $name    = $request->get('name');           
        $acti    = $request->get('acti');  
        $bio     = $request->get('bio');   
        $nameiap = $request->get('nameiap');  
        if(session()->get('rango') !== '0'){    
            //$regprogramas = regProgramasModel::select('PROG_ID','PROG_DESC')
            //              ->get();                                 
            $regfinanpres= regFinanpresModel::join('CP_CAT_PROGRAMAS','CP_CAT_PROGRAMAS.PROG_ID','=',
                                                                      'CP_FINAN_PRESUP.PROG_ID')
                           ->select( 'CP_CAT_PROGRAMAS.PROG_DESC','CP_FINAN_PRESUP.*')
                           ->orderBy('CP_FINAN_PRESUP.PERIODO_ID','ASC')
                           ->orderBy('CP_FINAN_PRESUP.PROG_ID'   ,'ASC')
                           ->orderBy('CP_FINAN_PRESUP.PROY_ID'   ,'ASC')
                           //->name($name)     //Metodos personalizados es equvalente a ->where('OSC_DESC', 'LIKE', "%$name%");
                           //->acti($acti)     //Metodos personalizados
                           //->bio($bio)       //Metodos personalizados
                           ->folio($folio)     //Metodos personalizados     
                           ->nameiap($nameiap) //Metodos personalizados                                                                      
                           ->paginate(30);
        }else{
            //$regprogramas = regProgramasModel::select('OSC_ID', 'OSC_DESC','OSC_STATUS')
            //              ->where('OSC_ID',$arbol_id)
            //              ->get();                                        
            $regfinanpres= regFinanpresModel::join('CP_CAT_PROGRAMAS','CP_CAT_PROGRAMAS.PROG_ID','=',
                                                                      'CP_FINAN_PRESUP.PROG_ID')
                           ->select( 'CP_CAT_PROGRAMAS.PROG_DESC','CP_FINAN_PRESUP.*')
                           ->where(  'CP_FINAN_PRESUP.PROG_ID'   ,$codigo)
                           ->orderBy('CP_FINAN_PRESUP.PERIODO_ID','ASC')                          
                           ->orderBy('CP_FINAN_PRESUP.PROG_ID'   ,'ASC')
                           ->orderBy('CP_FINAN_PRESUP.PROY_ID'   ,'ASC')                          
                           ->name($name)      //Metodos personalizados es equvalente a ->where('OSC_DESC', 'LIKE', "%$name%");
                           ->nameiap($nameiap) //Metodos personalizados                                  
                           //->email($email)   //Metodos personalizados
                           //->bio($bio)       //Metodos personalizados
                           ->paginate(30);              
        }                                                                          
        if($regfinanpres->count() <= 0){
            toastr()->error('No existen registros de Financiamiento presupuestal.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }            
        return view('sicinar.presupuesto.verFinanpres', compact('nombre','usuario','codigo','regprogramas','reganios','regperiodos','regmeses','regdias','regfinanpres','totactivs'));
    }

    public function actionVerFinanpres(){
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
                        ->orderBy('PROY_ID','ASC')
                        ->get();
        $regperiodos  = regPeriodosModel::select('PERIODO_ID', 'PERIODO_DESC')
                        ->orderBy('PERIODO_ID','ASC')        
                        ->get();         
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')
                        ->get();      
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')
                        ->get();  
        $regfinandet  = regfinandetModel::select('PERIODO_ID','PROG_ID','PERIODO_ID2','FUENTE_ID','CTGASTO_ID', 
                        'CONAC_ID','SUBSECTOR_ID','FIN_ID','FUNCION_ID','SUBFUN_ID','PROGRAM_ID','SUBPROG_ID', 
                        'PROY_ID','DET_TOTAL','DET_PORCEN','DET_OBS1','DET_OBS2','DET_STATUS1','DET_STATUS2', 
                        'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')        
                        ->orderBy('PERIODO_ID','asc')
                        ->orderBy('PROG_ID'   ,'asc')
                        ->get();        
        //********* Validar rol de usuario **********************/
        if(session()->get('rango') !== '0'){  
            $regprogramas=regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->get();                                        
            $totactivs =  regFinanpresModel::join('CP_FINAN_PRESUP_DETALLE',
                                                [['CP_FINAN_PRESUP_DETALLE.PERIODO_ID','=','CP_FINAN_PRESUP.PERIODO_ID'],
                                                 ['CP_FINAN_PRESUP_DETALLE.PROG_ID'   ,'=','CP_FINAN_PRESUP.PROG_ID']])
                          ->select(   'CP_FINAN_PRESUP.PERIODO_ID','CP_FINAN_PRESUP.PROG_ID')
                          ->selectRaw('COUNT(*) AS TOTPRESUPUESTO')
                          ->groupBy(  'CP_FINAN_PRESUP.PERIODO_ID','CP_FINAN_PRESUP.PROG_ID')
                          ->get();                   
            $regfinanpres=regFinanpresModel::select('PERIODO_ID','PROG_ID','FIN_ID','FUNCION_ID','SUBFUN_ID','PROGRAM_ID', 
                          'SUBPROG_ID','PROY_ID','FINAN_ARC1','FINAN_ARC2','FINAN_ARC3','FINAN_ARC4','FINAN_ARC5', 
                          'FINAN_OBS1','FINAN_OBS2','FINAN_OBS3','FINAN_STATUS1','FINAN_STATUS2', 
                          'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                          ->orderBy('PERIODO_ID','ASC')
                          ->orderBy('PROG_ID'   ,'ASC')
                          ->orderBy('PROY_ID'   ,'ASC')
                          ->paginate(30);
        }else{                  
            $regprogramas=regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->where('PROG_ID',$codigo_id)
                          ->get();                                        
            $totactivs =  regFinanpresModel::join('CP_FINAN_PRESUP_DETALLE',
                                                [['CP_FINAN_PRESUP_DETALLE.PERIODO_ID','=','CP_FINAN_PRESUP.PERIODO_ID'],
                                                 ['CP_FINAN_PRESUP_DETALLE.PROG_ID'   ,'=','CP_FINAN_PRESUP.PROG_ID']])
                          ->select(   'CP_FINAN_PRESUP.PERIODO_ID','CP_FINAN_PRESUP.PROG_ID')
                          ->selectRaw('COUNT(*) AS TOTPRESUPUESTO')
                          ->where(    'CP_FINAN_PRESUP.PROG_ID'   ,$codigo_id) 
                          ->groupBy(  'CP_FINAN_PRESUP.PERIODO_ID','CP_FINAN_PRESUP.PROG_ID')
                          ->get();                               
            $regfinanpres=regFinanpresModel::select('PERIODO_ID','PROG_ID','FIN_ID','FUNCION_ID','SUBFUN_ID','PROGRAM_ID', 
                          'SUBPROG_ID','PROY_ID','FINAN_ARC1','FINAN_ARC2','FINAN_ARC3','FINAN_ARC4','FINAN_ARC5', 
                          'FINAN_OBS1','FINAN_OBS2','FINAN_OBS3','FINAN_STATUS1','FINAN_STATUS2', 
                          'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                          ->where(  'PROG_ID'   ,$codigo_id)            
                          ->orderBy('PERIODO_ID','ASC')
                          ->orderBy('PROG_ID'   ,'ASC')
                          ->orderBy('PROY'      ,'ASC')  
                          ->paginate(30);         
        }                        
        if($regfinanpres->count() <= 0){
            toastr()->error('No existe Financiamiento presupuestal.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.presupuesto.verFinanpres',compact('nombre','usuario','codigo','regprogramas','reganios','regperiodos','regmeses','regdias','regfinanpres','regfinandet','totactivs','regproyectos')); 
    }

    public function actionNuevoFinanpres(){
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
                        ->orderBy('PROY_DESC','ASC')
                        ->get();
        $regperiodos  = regPeriodosModel::select('PERIODO_ID', 'PERIODO_DESC')
                        ->orderBy('PERIODO_ID','ASC')        
                        ->get();         
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')
                        ->get();      
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')
                        ->get();   
        if(session()->get('rango') !== '0'){                           
            $regprogramas=regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->orderBy('PROG_ID','asc')
                          ->get();                                            
        }else{
            $regprogramas=regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->where(  'PROG_ID',$codigo)
                          ->orderBy('PROG_ID','asc')
                          ->get();            
        }     
        $regfinanpres=regFinanpresModel::select('PERIODO_ID','PROG_ID','FIN_ID','FUNCION_ID','SUBFUN_ID','PROGRAM_ID', 
                      'SUBPROG_ID','PROY_ID','FINAN_ARC1','FINAN_ARC2','FINAN_ARC3','FINAN_ARC4','FINAN_ARC5', 
                      'FINAN_OBS1','FINAN_OBS2','FINAN_OBS3','FINAN_STATUS1','FINAN_STATUS2', 
                      'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                      ->orderBy('PERIODO_ID','ASC')
                      ->orderBy('PROG_ID'   ,'ASC')
                      ->orderBy('PROY_ID'   ,'ASC')
                      ->get();
        //dd($unidades);
        return view('sicinar.presupuesto.nuevoFinanpres',compact('nombre','usuario','codigo','regprogramas','reganios','regperiodos','regmeses','regdias','regfinanpres','regproyectos'));   
    }

    public function actionAltaNuevoFinanpres(Request $request){
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

        // *************** Validar duplicidad ***********************************/
        $duplicado = regFinanpresModel::where(['PERIODO_ID' => $request->periodo_id,'PROG_ID' => $request->prog_id])
                     ->get();
        if($duplicado->count() >= 1)
            return back()->withInput()->withErrors(['PROG_ID' => 'PROGRAMA '.$request->prog_id.' Ya existe periodo y programa presupuestal. Por favor verificar.']);
        else{  
            /************ ALTA  *****************************/ 

            //$mes1 = regMesesModel::ObtMes($request->mes_id1);
            //$dia1 = regDiasModel::ObtDia($request->dia_id1);                

            //$folio = regFinanpresModel::max('FOLIO');
            //$folio = $folio + 1;

            $file01 =null;
            if(isset($request->finan_arc1)){
                if(!empty($request->finan_arc1)){
                    //Comprobar  si el campo act_const tiene un archivo asignado:
                    if($request->hasFile('finan_arc1')){
                        $file01=$request->prog_id.'_'.$request->file('finan_arc1')->getClientOriginalName();
                        //sube el archivo a la carpeta del servidor public/images/
                        $request->file('finan_arc1')->move(public_path().'/images/', $file01);
                    }
                }
            }
            $file02 =null;
            if(isset($request->finan_arc2)){
                if(!empty($request->finan_arc2)){
                    //Comprobar  si el campo act_const tiene un archivo asignado:
                    if($request->hasFile('finan_arc2')){
                        $file02=$request->prog_id.'_'.$request->file('finan_arc2')->getClientOriginalName();
                        //sube el archivo a la carpeta del servidor public/images/
                        $request->file('finan_arc2')->move(public_path().'/images/', $file02);
                    }
                }
            }
            $file03 =null;
            if(isset($request->finan_arc3)){
                if(!empty($request->finan_arc3)){
                    //Comprobar  si el campo act_const tiene un archivo asignado:
                    if($request->hasFile('finan_arc3')){
                        $file03=$request->prog_id.'_'.$request->file('finan_arc3')->getClientOriginalName();
                        //sube el archivo a la carpeta del servidor public/images/
                        $request->file('finan_arc3')->move(public_path().'/images/', $file03);
                    }
                }
            }

            $nuevoprogtrab = new regFinanpresModel();
            //$nuevoprogtrab->FOLIO       = $folio;
            $nuevoprogtrab->PERIODO_ID    = $request->periodo_id;                            
            $nuevoprogtrab->PROG_ID       = $request->prog_id;
            $nuevoprogtrab->PROY_ID       = $request->proy_id; 
            $nuevoprogtrab->FINAN_OBS1    = substr(strtoupper(trim($request->finan_obs1)),0,1999);

            $nuevoprogtrab->FINAN_ARC1    = $file01;
            $nuevoprogtrab->FINAN_ARC2    = $file02;
            $nuevoprogtrab->FINAN_ARC3    = $file03;
        
            $nuevoprogtrab->IP            = $ip;
            $nuevoprogtrab->LOGIN         = $nombre;         // Usuario ;
            $nuevoprogtrab->save();
            if($nuevoprogtrab->save() == true){
                toastr()->success('Financiamiento presupuestado dado de alta.','ok!',['positionClass' => 'toast-bottom-right']);
                /************ Bitacora inicia *************************************/ 
                setlocale(LC_TIME, "spanish");        
                $xip          = session()->get('ip');
                $xperiodo_id  = (int)date('Y');
                $xprograma_id = 1;
                $xmes_id      = (int)date('m');
                $xproceso_id  =         3;
                $xfuncion_id  =      3001;
                $xtrx_id      =         2;    //Alta
                $regbitacora = regBitacoraModel::select('PERIODO_ID','MES_ID','PROCESO_ID','FUNCION_ID', 
                                                    'TRX_ID','FOLIO','NO_VECES','FECHA_REG','IP','LOGIN', 
                                                    'FECHA_M','IP_M','LOGIN_M')
                               ->where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id,
                                        'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO'      => $request->prog_id])
                               ->get();
                if($regbitacora->count() <= 0){              // Alta
                    $nuevoregBitacora = new regBitacoraModel();              
                    $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                    $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                    $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                    $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                    $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                    $nuevoregBitacora->FOLIO      = $request->prog_id;          // Folio    
                    $nuevoregBitacora->NO_VECES   = 1;               // Numero de veces            
                    $nuevoregBitacora->IP         = $ip;             // IP
                    $nuevoregBitacora->LOGIN      = $nombre;         // Usuario 
                    $nuevoregBitacora->save();
                    if($nuevoregBitacora->save() == true)
                        toastr()->success('Trx de financiamiento presup. registrado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                    else
                        toastr()->error('Error trx. de finan. presup. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
                }else{                   
                    //*********** Obtine el no. de veces *****************************
                    $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id,'MES_ID'     => $xmes_id, 
                                                          'PROCESO_ID' => $xproceso_id,'FUNCION_ID' => $xfuncion_id, 
                                                          'TRX_ID'     => $xtrx_id,    'FOLIO'      => $request->prog_id])
                                 ->max('NO_VECES');
                    $xno_veces = $xno_veces+1;                        
                    //*********** Termina de obtener el no de veces *****************************         
                    $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                                   ->where(['PERIODO_ID' => $xperiodo_id,'MES_ID'     => $xmes_id, 
                                            'PROCESO_ID' => $xproceso_id,'FUNCION_ID' => $xfuncion_id,
                                            'TRX_ID'     => $xtrx_id,    'FOLIO'      => $request->prog_id])
                                   ->update([
                                             'NO_VECES'=> $regbitacora->NO_VECES = $xno_veces,
                                             'IP_M'    => $regbitacora->IP       = $ip,
                                             'LOGIN_M' => $regbitacora->LOGIN_M  = $nombre,
                                             'FECHA_M' => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                            ]);
                    toastr()->success('Trx de finan. presup. registrado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                }   /************ Bitacora termina *************************************/ 
            }else{
                toastr()->error('Error en Trx de finan. presup. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }   //**************** Termina alta **********************/
        }       // ******************* Termina el duplicado **********/
        return redirect()->route('verfinanpres');
    } 

    public function actionEditarFinanpres($id, $id2){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $codigo       = session()->get('codigo');      

        $regproyectos = regProyectosModel::select('PROY_ID','PROY_DESC')
                        ->orderBy('PROY_DESC','ASC')
                        ->get();
        $regperiodos  = regPeriodosModel::select('PERIODO_ID', 'PERIODO_DESC')
                        ->orderBy('PERIODO_ID','ASC')        
                        ->get();         
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')
                        ->get();      
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')
                        ->get();   
        if(session()->get('rango') !== '0'){                           
            $regprogramas=regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->orderBy('PROG_ID','asc')
                          ->get();                                            
        }else{
            $regprogramas=regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->where(  'PROG_ID',$codigo)
                          ->orderBy('PROG_ID','asc')
                          ->get();            
        }     
        $regfinanpres=regFinanpresModel::select('PERIODO_ID','PROG_ID','FIN_ID','FUNCION_ID','SUBFUN_ID','PROGRAM_ID', 
                      'SUBPROG_ID','PROY_ID','FINAN_ARC1','FINAN_ARC2','FINAN_ARC3','FINAN_ARC4','FINAN_ARC5', 
                      'FINAN_OBS1','FINAN_OBS2','FINAN_OBS3','FINAN_STATUS1','FINAN_STATUS2', 
                      'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                      ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2])
                      ->first();
        if($regfinanpres->count() <= 0){
            toastr()->error('No existe registros de finan. presup.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.presupuesto.editarFinanpres',compact('nombre','usuario','codigo','regprogramas','reganios','regperiodos','regmeses','regdias','regfinanpres','regproyectos'));
    }

    public function actionActualizarFinanpres(finanpresRequest $request, $id, $id2){
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
        $regfinanpres = regFinanpresModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2]);
        if($regfinanpres->count() <= 0)
            toastr()->error('No existe finananciamiento presupuestario',' ¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            //********************** Actualizar ********************************/
            $ymes_id = (int)date('m');
            $ydia_id = (int)date('d');

            $mes = regMesesModel::ObtMes($ymes_id);
            $dia = regDiasModel::ObtDia($ydia_id);                
            //dd('año 1:',$request->periodo_id1, ' año 2:',$request->periodo_id2,' mes1:',$mes1[0]->mes_mes,' dia1:',$dia1[0]->dia_desc,' mes2:',$mes2[0]->mes_mes, ' dia2:',$dia2[0]->dia_desc);
            $regfinanpres= regFinanpresModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2])
                           ->update([                
                                     'PROY_ID'   => $request->proy_id,   
                                     'FINAN_OBS1'=> substr(trim(strtoupper($request->finan_obs1)),0,1999), 

                                     'IP_M'      => $ip,
                                     'LOGIN_M'   => $nombre,
                                     'FECHA_M2'  => trim($dia[0]->dia_desc.'/'.$mes[0]->mes_mes.'/'.$id),                 
                                     'FECHA_M'   => date('Y/m/d')    //date('d/m/Y')                                
                                   ]);
            toastr()->success('Finciamiento presupuestal actualizado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =         3;    //Actualizar 
            $regbitacora = regBitacoraModel::select('PERIODO_ID',  'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
                           'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
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
                    toastr()->success('Trx de finan. presup. registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error Trx de finan. presup. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id,'MES_ID'     => $xmes_id, 
                                                      'PROCESO_ID' => $xproceso_id,'FUNCION_ID' => $xfuncion_id, 
                                                      'TRX_ID'     => $xtrx_id,    'FOLIO'      => $id2])
                             ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id, 
                                        'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO'      => $id2])
                               ->update([
                                         'NO_VECES'=> $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'    => $regbitacora->IP       = $ip,
                                         'LOGIN_M' => $regbitacora->LOGIN_M  = $nombre,
                                         'FECHA_M' => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                         ]);
                toastr()->success('Trx de finan. presup. registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                     
        }       /************ Actualizar *******************************************/
        return redirect()->route('verfinanpres');
    }

    public function actionEditarFinanpres1($id, $id2){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $codigo       = session()->get('codigo');      

        $regproyectos = regProyectosModel::select('PROY_ID','PROY_DESC')
                        ->orderBy('PROY_DESC','ASC')
                        ->get();
        $regperiodos  = regPeriodosModel::select('PERIODO_ID', 'PERIODO_DESC')
                        ->orderBy('PERIODO_ID','ASC')        
                        ->get();         
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')
                        ->get();      
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')
                        ->get();   
        if(session()->get('rango') !== '0'){                           
            $regprogramas=regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->orderBy('PROG_ID','asc')
                          ->get();                                            
        }else{
            $regprogramas=regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->where(  'PROG_ID',$codigo)
                          ->orderBy('PROG_ID','asc')
                          ->get();            
        }     
        $regfinanpres=regFinanpresModel::select('PERIODO_ID','PROG_ID','FIN_ID','FUNCION_ID','SUBFUN_ID','PROGRAM_ID', 
                      'SUBPROG_ID','PROY_ID','FINAN_ARC1','FINAN_ARC2','FINAN_ARC3','FINAN_ARC4','FINAN_ARC5', 
                      'FINAN_OBS1','FINAN_OBS2','FINAN_OBS3','FINAN_STATUS1','FINAN_STATUS2', 
                      'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                      ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2])
                      ->first();
        if($regfinanpres->count() <= 0){
            toastr()->error('No existe registros de finan. presup.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.presupuesto.editarFinanpres1',compact('nombre','usuario','codigo','regprogramas','reganios','regperiodos','regmeses','regdias','regfinanpres','regproyectos'));
    }

    public function actionActualizarFinanpres1(finanpres1Request $request, $id, $id2){
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
        $regfinanpres = regFinanpresModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2]);
        if($regfinanpres->count() <= 0)
            toastr()->error('No existe finananciamiento presupuestario',' ¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            //********************** Actualizar ********************************/
            $ymes_id = (int)date('m');
            $ydia_id = (int)date('d');

            $mes = regMesesModel::ObtMes($ymes_id);
            $dia = regDiasModel::ObtDia($ydia_id);                
            //dd('año 1:',$request->periodo_id1, ' año 2:',$request->periodo_id2,' mes1:',$mes1[0]->mes_mes,' dia1:',$dia1[0]->dia_desc,' mes2:',$mes2[0]->mes_mes, ' dia2:',$dia2[0]->dia_desc);
            $name01 =null;
            if($request->hasFile('finan_arc1')){
                $name01 = $id2.'_'.$request->file('finan_arc1')->getClientOriginalName(); 
                $request->file('finan_arc1')->move(public_path().'/images/', $name01);
                // ************* Actualizamos registro **********************************
                $regfinanpres=regFinanpresModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2])
                              ->update([   
                                        'FINAN_ARC1' => $name01,                  

                                        'IP_M'       => $ip,
                                        'LOGIN_M'    => $nombre,
                                        'FECHA_M2'   => trim($dia[0]->dia_desc.'/'.$mes[0]->mes_mes.'/'.$id),                                       
                                        'FECHA_M'    => date('Y/m/d')    //date('d/m/Y')                                
                                        ]);
                toastr()->success('Archivo digital 1 actualizado.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =         3;    //Actualizar 
            $regbitacora = regBitacoraModel::select('PERIODO_ID',  'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
                           'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
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
                    toastr()->success('Trx de archivo digital 1 registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error Trx de archivo digital 1. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id,'MES_ID'     => $xmes_id, 
                                                      'PROCESO_ID' => $xproceso_id,'FUNCION_ID' => $xfuncion_id, 
                                                      'TRX_ID'     => $xtrx_id,    'FOLIO'      => $id2])
                             ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id, 
                                        'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO'      => $id2])
                               ->update([
                                         'NO_VECES'=> $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'    => $regbitacora->IP       = $ip,
                                         'LOGIN_M' => $regbitacora->LOGIN_M  = $nombre,
                                         'FECHA_M' => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                         ]);
                toastr()->success('Trx de archivo digital 1 registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                     
        }       /************ Actualizar *******************************************/
        return redirect()->route('verfinanpres');
    }

    public function actionEditarFinanpres2($id, $id2){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $codigo       = session()->get('codigo');      

        $regproyectos = regProyectosModel::select('PROY_ID','PROY_DESC')
                        ->orderBy('PROY_DESC','ASC')
                        ->get();
        $regperiodos  = regPeriodosModel::select('PERIODO_ID', 'PERIODO_DESC')
                        ->orderBy('PERIODO_ID','ASC')        
                        ->get();         
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')
                        ->get();      
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')
                        ->get();   
        if(session()->get('rango') !== '0'){                           
            $regprogramas=regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->orderBy('PROG_ID','asc')
                          ->get();                                            
        }else{
            $regprogramas=regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->where(  'PROG_ID',$codigo)
                          ->orderBy('PROG_ID','asc')
                          ->get();            
        }     
        $regfinanpres=regFinanpresModel::select('PERIODO_ID','PROG_ID','FIN_ID','FUNCION_ID','SUBFUN_ID','PROGRAM_ID', 
                      'SUBPROG_ID','PROY_ID','FINAN_ARC1','FINAN_ARC2','FINAN_ARC3','FINAN_ARC4','FINAN_ARC5', 
                      'FINAN_OBS1','FINAN_OBS2','FINAN_OBS3','FINAN_STATUS1','FINAN_STATUS2', 
                      'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                      ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2])
                      ->first();
        if($regfinanpres->count() <= 0){
            toastr()->error('No existe registros de finan. presup.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.presupuesto.editarFinanpres2',compact('nombre','usuario','codigo','regprogramas','reganios','regperiodos','regmeses','regdias','regfinanpres','regproyectos'));
    }

    public function actionActualizarFinanpres2(finanpres2Request $request, $id, $id2){
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
        $regfinanpres = regFinanpresModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2]);
        if($regfinanpres->count() <= 0)
            toastr()->error('No existe finananciamiento presupuestario',' ¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            //********************** Actualizar ********************************/
            $ymes_id = (int)date('m');
            $ydia_id = (int)date('d');

            $mes = regMesesModel::ObtMes($ymes_id);
            $dia = regDiasModel::ObtDia($ydia_id);                
            //dd('año 1:',$request->periodo_id1, ' año 2:',$request->periodo_id2,' mes1:',$mes1[0]->mes_mes,' dia1:',$dia1[0]->dia_desc,' mes2:',$mes2[0]->mes_mes, ' dia2:',$dia2[0]->dia_desc);
            $name02 =null;
            if($request->hasFile('finan_arc2')){
                $name02 = $id2.'_'.$request->file('finan_arc2')->getClientOriginalName(); 
                $request->file('finan_arc2')->move(public_path().'/images/', $name02);
                // ************* Actualizamos registro **********************************
                $regfinanpres=regFinanpresModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2])
                              ->update([   
                                        'FINAN_ARC2' => $name02,                  

                                        'IP_M'       => $ip,
                                        'LOGIN_M'    => $nombre,
                                        'FECHA_M2'   => trim($dia[0]->dia_desc.'/'.$mes[0]->mes_mes.'/'.$id),                                       
                                        'FECHA_M'    => date('Y/m/d')    //date('d/m/Y')                                
                                        ]);
                toastr()->success('Archivo digital 2 actualizado.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =         3;    //Actualizar 
            $regbitacora = regBitacoraModel::select('PERIODO_ID',  'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
                           'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
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
                    toastr()->success('Trx de archivo digital 2 registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error Trx de archivo digital 2. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id,'MES_ID'     => $xmes_id, 
                                                      'PROCESO_ID' => $xproceso_id,'FUNCION_ID' => $xfuncion_id, 
                                                      'TRX_ID'     => $xtrx_id,    'FOLIO'      => $id2])
                             ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id, 
                                        'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO'      => $id2])
                               ->update([
                                         'NO_VECES'=> $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'    => $regbitacora->IP       = $ip,
                                         'LOGIN_M' => $regbitacora->LOGIN_M  = $nombre,
                                         'FECHA_M' => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                         ]);
                toastr()->success('Trx de archivo digital 2 registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                     
        }       /************ Actualizar *******************************************/
        return redirect()->route('verfinanpres');
    }

    public function actionEditarFinanpres3($id, $id2){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $codigo       = session()->get('codigo');      

        $regproyectos = regProyectosModel::select('PROY_ID','PROY_DESC')
                        ->orderBy('PROY_DESC','ASC')
                        ->get();
        $regperiodos  = regPeriodosModel::select('PERIODO_ID', 'PERIODO_DESC')
                        ->orderBy('PERIODO_ID','ASC')        
                        ->get();         
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')
                        ->get();      
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')
                        ->get();   
        if(session()->get('rango') !== '0'){                           
            $regprogramas=regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->orderBy('PROG_ID','asc')
                          ->get();                                            
        }else{
            $regprogramas=regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->where(  'PROG_ID',$codigo)
                          ->orderBy('PROG_ID','asc')
                          ->get();            
        }     
        $regfinanpres=regFinanpresModel::select('PERIODO_ID','PROG_ID','FIN_ID','FUNCION_ID','SUBFUN_ID','PROGRAM_ID', 
                      'SUBPROG_ID','PROY_ID','FINAN_ARC1','FINAN_ARC2','FINAN_ARC3','FINAN_ARC4','FINAN_ARC5', 
                      'FINAN_OBS1','FINAN_OBS2','FINAN_OBS3','FINAN_STATUS1','FINAN_STATUS2', 
                      'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                      ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2])
                      ->first();
        if($regfinanpres->count() <= 0){
            toastr()->error('No existe registros de finan. presup.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.presupuesto.editarFinanpres3',compact('nombre','usuario','codigo','regprogramas','reganios','regperiodos','regmeses','regdias','regfinanpres','regproyectos'));
    }

    public function actionActualizarFinanpres3(finanpres3Request $request, $id, $id2){
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
        $regfinanpres = regFinanpresModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2]);
        if($regfinanpres->count() <= 0)
            toastr()->error('No existe finananciamiento presupuestario',' ¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            //********************** Actualizar ********************************/
            $ymes_id = (int)date('m');
            $ydia_id = (int)date('d');

            $mes = regMesesModel::ObtMes($ymes_id);
            $dia = regDiasModel::ObtDia($ydia_id);                
            //dd('año 1:',$request->periodo_id1, ' año 2:',$request->periodo_id2,' mes1:',$mes1[0]->mes_mes,' dia1:',$dia1[0]->dia_desc,' mes2:',$mes2[0]->mes_mes, ' dia2:',$dia2[0]->dia_desc);
            $name03 =null;
            if($request->hasFile('finan_arc3')){
                $name03 = $id2.'_'.$request->file('finan_arc3')->getClientOriginalName(); 
                $request->file('finan_arc3')->move(public_path().'/images/', $name03);
                // ************* Actualizamos registro **********************************
                $regfinanpres=regFinanpresModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2])
                              ->update([   
                                        'FINAN_ARC3' => $name03,                  

                                        'IP_M'       => $ip,
                                        'LOGIN_M'    => $nombre,
                                        'FECHA_M2'   => trim($dia[0]->dia_desc.'/'.$mes[0]->mes_mes.'/'.$id),                                       
                                        'FECHA_M'    => date('Y/m/d')    //date('d/m/Y')                                
                                        ]);
                toastr()->success('Archivo digital 3 actualizado.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =         3;    //Actualizar 
            $regbitacora = regBitacoraModel::select('PERIODO_ID',  'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
                           'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
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
                    toastr()->success('Trx de archivo digital 3 registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error Trx de archivo digital 3. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id,'MES_ID'     => $xmes_id, 
                                                      'PROCESO_ID' => $xproceso_id,'FUNCION_ID' => $xfuncion_id, 
                                                      'TRX_ID'     => $xtrx_id,    'FOLIO'      => $id2])
                             ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id, 
                                        'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO'      => $id2])
                               ->update([
                                         'NO_VECES'=> $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'    => $regbitacora->IP       = $ip,
                                         'LOGIN_M' => $regbitacora->LOGIN_M  = $nombre,
                                         'FECHA_M' => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                         ]);
                toastr()->success('Trx de archivo digital 3 registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                     
        }       /************ Actualizar *******************************************/
        return redirect()->route('verfinanpres');
    }

    public function actionBorrarFinanpres($id, $id2){
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

        /************ Elimina la IAP **************************************/
        $regfinanpres  = regFinanpresModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2]);
        //              ->find('UMEDIDA_ID',$id);
        if($regfinanpres->count() <= 0)
            toastr()->error('No existe finan. presup. ','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            $regfinanpres->delete();
            toastr()->success('Finan. presup. eliminado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

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
            $regbitacora = regBitacoraModel::select('PERIODO_ID','MES_ID', 'PROCESO_ID','FUNCION_ID', 
                           'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
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
                    toastr()->success('Trx de elimiar finan. presup. registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error de Trx de elimiar finan. presup. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id, 
                                                      'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO'      => $id2])
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
                toastr()->success('Trx de elimiar de finan. presup. registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                 
        }       /************* Termina de eliminar *********************************/
        return redirect()->route('verfinanpres');
    }    

    // exportar a formato excel
    public function actionExportFinanpresExcel($id, $id2){
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
        $regbitacora  = regBitacoraModel::select('PERIODO_ID',  'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
                        'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
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
               toastr()->success('Trx de exportar a excel financiamiento presupuestal registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            else
               toastr()->error('Error Trx de exportar a excel financiamiento presupuestal. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
        }else{                   
            //*********** Obtine el no. de veces *****************************
            $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id,'MES_ID'     => $xmes_id,
                                                  'PROCESO_ID' => $xproceso_id,'FUNCION_ID' => $xfuncion_id, 
                                                  'TRX_ID'     => $xtrx_id,    'FOLIO'      => $id2])
                         ->max('NO_VECES');
            $xno_veces = $xno_veces+1;                        
            //*********** Termina de obtener el no de veces *****************************                
            $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                           ->where(['PERIODO_ID' => $xperiodo_id, 'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id, 
                                    'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id,'FOLIO'      => $id2])
                           ->update([
                                     'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                     'IP_M'     => $regbitacora->IP       = $ip,
                                     'LOGIN_M'  => $regbitacora->LOGIN_M  = $nombre,
                                     'FECHA_M'  => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                    ]);
            toastr()->success('Trx de exportar a excel financiamiento presupuestal registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
        }   /********************** Bitacora termina *************************************/  
        return Excel::download(new ExportFinanpresExcel, 'Financiamiento_presupuestario'.date('d-m-Y').'.xlsx');
    }

    // exportar a formato PDF
    public function actionExportFinanpresPdf($id,$id2){
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
        $regbitacora = regBitacoraModel::select('PERIODO_ID',  'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
                       'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
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
               toastr()->success('Trx de exportar a PDF financiamiento presupuestal registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            else
               toastr()->error('Error de Trx de exportar a excel financiamiento presupuestal. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
        }else{                   
            //*********** Obtine el no. de veces *****************************
            $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id, 
                                                  'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO'      => $id2])
                        ->max('NO_VECES');
            $xno_veces = $xno_veces+1;                        
            //*********** Termina de obtener el no de veces *****************************         
            $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                           ->where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id, 
                                    'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO'      => $id2])
                           ->update([
                                     'NO_VECES'=> $regbitacora->NO_VECES = $xno_veces,
                                     'IP_M'    => $regbitacora->IP       = $ip,
                                     'LOGIN_M' => $regbitacora->LOGIN_M  = $nombre,
                                     'FECHA_M' => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                    ]);
            toastr()->success('Trx de exportar a excel financiamiento presupuestal actualizada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
        }   /************ Bitacora termina *************************************/ 

        $regumedida   = regProyectosModel::select('UMEDIDA_ID','UMEDIDA_DESC')->get(); 
        $regprogramas       = regProgramasModel::select('OSC_ID', 'OSC_DESC')->get();   
        //********* Validar rol de usuario **********************/
        if(session()->get('rango') !== '0'){                 
            $regfinanpres= regFinanpresModel::select('FOLIO','PERIODO_ID','OSC_ID','FECHA_ELAB','FECHA_ELAB2',
                          'PERIODO_ID1','MES_ID1','DIA_ID1','PROGRAMA_ID','PROGRAMA_DESC',
                          'RESPONSABLE','ELABORO','AUTORIZO','OBS_1','OBS_2','STATUS_1','STATUS_2',
                          'FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                          ->where('FOLIO',$id2)                                 
                          ->get();
        }else{
            $regfinanpres= regFinanpresModel::select('FOLIO','PERIODO_ID','OSC_ID','FECHA_ELAB','FECHA_ELAB2',
                          'PERIODO_ID1','MES_ID1','DIA_ID1','PROGRAMA_ID','PROGRAMA_DESC',
                          'RESPONSABLE','ELABORO','AUTORIZO','OBS_1','OBS_2','STATUS_1','STATUS_2',
                          'FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                          ->where(['FOLIO' => $id2,'OSC_ID' => $arbol_id])
                          ->orderBy('PERIODO_ID','ASC')
                          ->orderBy('FOLIO'     ,'ASC')
                          ->get();            
        }                                       
        $regfinandet=regfinandetModel::join('PE_CAT_UNID_MEDIDA' ,'PE_CAT_UNID_MEDIDA.UMEDIDA_ID','=',
                                                                    'CP_FINAN_PRESUP_DETALLE.UMEDIDA_ID')
                ->select('CP_FINAN_PRESUP_DETALLE.PARTIDA', 
                         'CP_FINAN_PRESUP_DETALLE.PROGRAMA_DESC', 
                         'CP_FINAN_PRESUP_DETALLE.ACTIVIDAD_DESC', 
                         'CP_FINAN_PRESUP_DETALLE.OBJETIVO_DESC',
                         'CP_FINAN_PRESUP_DETALLE.UMEDIDA_ID', 
                         'PE_CAT_UNID_MEDIDA.UMEDIDA_DESC', 
                         'CP_FINAN_PRESUP_DETALLE.MESP_01', 'CP_FINAN_PRESUP_DETALLE.MESP_02', 'CP_FINAN_PRESUP_DETALLE.MESP_03', 
                         'CP_FINAN_PRESUP_DETALLE.MESP_04', 'CP_FINAN_PRESUP_DETALLE.MESP_05', 'CP_FINAN_PRESUP_DETALLE.MESP_06', 
                         'CP_FINAN_PRESUP_DETALLE.MESP_07', 'CP_FINAN_PRESUP_DETALLE.MESP_08', 'CP_FINAN_PRESUP_DETALLE.MESP_09', 
                         'CP_FINAN_PRESUP_DETALLE.MESP_10', 'CP_FINAN_PRESUP_DETALLE.MESP_11', 'CP_FINAN_PRESUP_DETALLE.MESP_12' 
                            )
                ->selectRaw('(CP_FINAN_PRESUP_DETALLE.MESP_01+CP_FINAN_PRESUP_DETALLE.MESP_02+CP_FINAN_PRESUP_DETALLE.MESP_03+
                              CP_FINAN_PRESUP_DETALLE.MESP_04+CP_FINAN_PRESUP_DETALLE.MESP_05+CP_FINAN_PRESUP_DETALLE.MESP_06+
                              CP_FINAN_PRESUP_DETALLE.MESP_07+CP_FINAN_PRESUP_DETALLE.MESP_08+CP_FINAN_PRESUP_DETALLE.MESP_09+
                              CP_FINAN_PRESUP_DETALLE.MESP_10+CP_FINAN_PRESUP_DETALLE.MESP_11+CP_FINAN_PRESUP_DETALLE.MESP_12)
                              META_PROGRAMADA')
                ->where(  'CP_FINAN_PRESUP_DETALLE.FOLIO'     ,$id2)
                ->orderBy('CP_FINAN_PRESUP_DETALLE.PERIODO_ID','ASC')                   
                ->orderBy('CP_FINAN_PRESUP_DETALLE.FOLIO'     ,'ASC')
                ->orderBy('CP_FINAN_PRESUP_DETALLE.PARTIDA'   ,'ASC')
                ->get();    
        //dd('Llave:',$id,' llave2:',$id2);       
        if($regfinandet->count() <= 0){
            toastr()->error('No existen registros de financiamiento presupuestal.','Uppss!',['positionClass' => 'toast-bottom-right']);
            return redirect()->route('verProgtrab');
        }else{
            $pdf = PDF::loadView('sicinar.pdf.FinanpresPdf',compact('nombre','usuario','regumedida','regprogramas','regfinanpres','regfinandet'));
            //$options = new Options();
            //$options->set('defaultFont', 'Courier');
            //$pdf->set_option('defaultFont', 'Courier');
            $pdf->setPaper('A4', 'landscape');      
            //$pdf->set('defaultFont', 'Courier');          
            //$pdf->setPaper('A4','portrait');

            // Output the generated PDF to Browser
            return $pdf->stream('Financiamiento_presupuestal-'.$id2);
        }
    }


    //*****************************************************************************//
    //*************************************** Detalle *****************************//
    //*****************************************************************************//
    public function actionVerFinanpresd($id, $id2){
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
                        ->orderBy('PERIODO_ID','ASC')        
                        ->get();         
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')
                        ->get();      
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')
                        ->get();   
        $regprogramas = regProgramasModel::select('PROG_ID','PROG_DESC')
                        ->orderBy('PROG_ID','asc')
                        ->get();                                            
        $regfuente    = regFuentesModel::select('FUENTE_ID','FUENTE_DESC')
                        ->orderBy('FUENTE_ID','asc')
                        ->get();      
        $regtipogasto = regTipogastoModel::select('CTGASTO_ID','CTGASTO_DESC')
                        ->orderBy('CTGASTO_ID','asc')
                        ->get();                              
        $regconac     = regConacModel::select('CONAC_ID','CONAC_DESC')
                        ->orderBy('CONAC_ID','asc')
                        ->get();      
        $regsubsector = regSubsectoresModel::join('CP_CAT_SECTORES','CP_CAT_SECTORES.SECTOR_ID','=',
                                                                    'CP_CAT_SUBSECTORES.SECTOR_ID')
                                         ->select('CP_CAT_SECTORES.SECTOR_DESC',
                                                  'CP_CAT_SUBSECTORES.SUBSECTOR_ID',
                                                  'CP_CAT_SUBSECTORES.SUBSECTOR_DESC',
                                                  'CP_CAT_SUBSECTORES.SECTOR_ID')
                                        ->orderBy('CP_CAT_SUBSECTORES.SECTOR_ID'   ,'asc')
                                        ->orderBy('CP_CAT_SUBSECTORES.SUBSECTOR_ID','asc')
                        ->get();  
        //************** Validar rol de usuario **********************/
        if(session()->get('rango') !== '0'){           
            $regfinanpres=regFinanpresModel::select('PERIODO_ID','PROG_ID','FIN_ID','FUNCION_ID','SUBFUN_ID','PROGRAM_ID', 
                          'SUBPROG_ID','PROY_ID','FINAN_ARC1','FINAN_ARC2','FINAN_ARC3','FINAN_ARC4','FINAN_ARC5', 
                          'FINAN_OBS1','FINAN_OBS2','FINAN_OBS3','FINAN_STATUS1','FINAN_STATUS2', 
                          'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')                        
                          ->where(  'PERIODO_ID' ,$id)            
                          ->where(  'PROG_ID'    ,$id2)                    
                          ->orderBy('PERIODO_ID','asc')
                          ->orderBy('PROG_ID'   ,'asc')
                          ->get();                    
            $regfinandet=regfinandetModel::select('PERIODO_ID','PROG_ID','DET_NPARTIDA','PERIODO_ID2','FUENTE_ID', 
                         'CTGASTO_ID','CONAC_ID','SUBSECTOR_ID','FIN_ID','FUNCION_ID','SUBFUN_ID','PROGRAM_ID', 
                         'SUBPROG_ID','PROY_ID','DET_TOTAL','DET_PORCEN','DET_OBS1','DET_OBS2', 
                         'DET_STATUS1','DET_STATUS2',
                         'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')        
                        ->where(  'PERIODO_ID' ,$id)            
                        ->where(  'PROG_ID'    ,$id2)            
                        ->orderBy('PERIODO_ID' ,'asc')
                        ->orderBy('PROG_ID'    ,'asc')
                        ->orderBy('PERIODO_ID2','asc')
                        ->orderBy('FUENTE_ID'  ,'asc')                        
                        ->paginate(30);        
        }else{                         
            $regfinanpres=regFinanpresModel::select('PERIODO_ID','PROG_ID','FIN_ID','FUNCION_ID','SUBFUN_ID','PROGRAM_ID', 
                          'SUBPROG_ID','PROY_ID','FINAN_ARC1','FINAN_ARC2','FINAN_ARC3','FINAN_ARC4','FINAN_ARC5', 
                          'FINAN_OBS1','FINAN_OBS2','FINAN_OBS3','FINAN_STATUS1','FINAN_STATUS2', 
                          'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')                        
                          ->where(  'PERIODO_ID' ,$id)            
                          ->where(  'PROG_ID'    ,$id2)                    
                          ->where(  'PROG_ID'    ,$codigo)                                
                          ->orderBy('PERIODO_ID','asc')
                          ->orderBy('PROG_ID'   ,'asc')
                          ->get();                          
            $regfinandet=regfinandetModel::select('PERIODO_ID','PROG_ID','DET_NPARTIDA','PERIODO_ID2','FUENTE_ID', 
                         'CTGASTO_ID','CONAC_ID','SUBSECTOR_ID','FIN_ID','FUNCION_ID','SUBFUN_ID','PROGRAM_ID', 
                         'SUBPROG_ID','PROY_ID','DET_TOTAL','DET_PORCEN','DET_OBS1','DET_OBS2', 
                         'DET_STATUS1','DET_STATUS2',
                         'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')        
                        ->where(  'PERIODO_ID' ,$id)            
                        ->where(  'PROG_ID'    ,$id2)            
                        ->where(  'PROG_ID'    ,$codigo)                                    
                        ->orderBy('PERIODO_ID' ,'asc')
                        ->orderBy('PROG_ID'    ,'asc')
                        ->orderBy('PERIODO_ID2','asc')
                        ->orderBy('FUENTE_ID'  ,'asc')                        
                        ->paginate(30);        
        }                        
        if($regfinandet->count() <= 0){
            toastr()->error('No existe matriz de presupuesto.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }                        
        return view('sicinar.presupuesto.verFinanpresdet',compact('nombre','usuario','codigo','regfuente','regtipogasto','regconac','regsubsector','regprogramas','regperiodos','regmeses','regdias','regfinanpres','regfinandet'));
    }


    public function actionNuevoFinanpresd($id, $id2){
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
                        ->orderBy('PERIODO_ID','ASC')        
                        ->get();         
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')
                        ->get();      
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')
                        ->get();   
        $regprogramas = regProgramasModel::select('PROG_ID','PROG_DESC')
                        ->orderBy('PROG_ID','asc')
                        ->get();                                            
        $regfuente    = regFuentesModel::select('FUENTE_ID','FUENTE_DESC')
                        ->orderBy('FUENTE_ID','asc')
                        ->get();      
        $regtipogasto = regTipogastoModel::select('CTGASTO_ID','CTGASTO_DESC')
                        ->orderBy('CTGASTO_ID','asc')
                        ->get();                              
        $regconac     = regConacModel::select('CONAC_ID','CONAC_DESC')
                        ->orderBy('CONAC_ID','asc')
                        ->get();      
        $regsubsector = regSubsectoresModel::join('CP_CAT_SECTORES','CP_CAT_SECTORES.SECTOR_ID','=',
                                                                    'CP_CAT_SUBSECTORES.SECTOR_ID')
                                         ->select('CP_CAT_SECTORES.SECTOR_DESC',
                                                  'CP_CAT_SUBSECTORES.SUBSECTOR_ID',
                                                  'CP_CAT_SUBSECTORES.SUBSECTOR_DESC',
                                                  'CP_CAT_SUBSECTORES.SECTOR_ID')
                                        ->orderBy('CP_CAT_SUBSECTORES.SECTOR_ID'   ,'asc')
                                        ->orderBy('CP_CAT_SUBSECTORES.SUBSECTOR_ID','asc')
                        ->get();  
        $regfinanpres = regFinanpresModel::select('PERIODO_ID','PROG_ID','FIN_ID','FUNCION_ID','SUBFUN_ID','PROGRAM_ID', 
                        'SUBPROG_ID','PROY_ID','FINAN_ARC1','FINAN_ARC2','FINAN_ARC3','FINAN_ARC4','FINAN_ARC5', 
                        'FINAN_OBS1','FINAN_OBS2','FINAN_OBS3','FINAN_STATUS1','FINAN_STATUS2', 
                        'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')                        
                        ->orderBy('PERIODO_ID','asc')
                        ->orderBy('PROG_ID'   ,'asc')
                        ->get();              
        if(session()->get('rango') !== '0'){                           
            $regfinandet=regfinandetModel::select('PERIODO_ID','PROG_ID','DET_NPARTIDA','PERIODO_ID2','FUENTE_ID', 
                         'CTGASTO_ID','CONAC_ID','SUBSECTOR_ID','FIN_ID','FUNCION_ID','SUBFUN_ID','PROGRAM_ID', 
                         'SUBPROG_ID','PROY_ID','DET_TOTAL','DET_PORCEN','DET_OBS1','DET_OBS2', 
                         'DET_STATUS1','DET_STATUS2',
                         'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')        
                        ->where(  'PERIODO_ID' ,$id)            
                        ->where(  'PROG_ID'    ,$id2)            
                        ->orderBy('PERIODO_ID' ,'asc')
                        ->orderBy('PROG_ID'    ,'asc')
                        ->orderBy('PERIODO_ID2','asc')
                        ->orderBy('FUENTE_ID'  ,'asc')                        
                        ->get();                                                        
        }else{
            $regfinandet=regfinandetModel::select('PERIODO_ID','PROG_ID','DET_NPARTIDA','PERIODO_ID2','FUENTE_ID', 
                         'CTGASTO_ID','CONAC_ID','SUBSECTOR_ID','FIN_ID','FUNCION_ID','SUBFUN_ID','PROGRAM_ID', 
                         'SUBPROG_ID','PROY_ID','DET_TOTAL','DET_PORCEN','DET_OBS1','DET_OBS2', 
                         'DET_STATUS1','DET_STATUS2',
                         'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')        
                        ->where(  'PERIODO_ID' ,$id)            
                        ->where(  'PROG_ID'    ,$id2)            
                        ->where(  'PROG_ID'    ,$codigo)                        
                        ->orderBy('PERIODO_ID' ,'asc')
                        ->orderBy('PROG_ID'    ,'asc')
                        ->orderBy('PERIODO_ID2','asc')
                        ->orderBy('FUENTE_ID'  ,'asc')                        
                        ->get();            
        }    
        //dd($unidades);
        return view('sicinar.presupuesto.nuevoFinanpresdet',compact('nombre','usuario','codigo','regfuente','regtipogasto','regconac','regsubsector','regprogramas','regperiodos','regmeses','regdias','regfinanpres','regfinandet'));
    }

    public function actionAltaNuevoFinanpresd(Request $request){
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

        // *************** Validar duplicidad ***********************************/
        $duplicado = regfinandetModel::where(['PERIODO_ID'  => $request->periodo_id,
                                              'PROG_ID'     => $request->prog_id, 
                                              'PERIODO_ID2' => $request->periodo_id2,
                                              'FUENTE_ID'   => $request->fuente_id,
                                              'CTGASTO_ID'  => $request->ctgasto_id,
                                              'CONAC_ID'    => $request->conac_id, 
                                              'SUBSECTOR_ID'=> $request->subsector_id                                              
                                              ])
                     ->get();
        if($duplicado->count() >= 1 )
            return back()->withInput()->withErrors(['PROG_ID' => 'Programa '.$request->prog_id.' Ya existe presupuesto con el MISMO periodo-programa-fuente-tipo de gasto- CONAC y subsector. Por favor verificar.']);
        else{  

            /************************* ALTA  *****************************/ 
            //$mes1 = regMesesModel::ObtMes($request->mes_id1);
            //$dia1 = regDiasModel::ObtDia($request->dia_id1);                
            // ****************** Obtiene valores ************************/
            $fin_id     = 0;
            $funcion_id = 0;
            $subfun_id  = 0;
            $program_id = 0;
            $subprog_id = 0;
            $proy_id = 0;            
            $existe = regFinanpresModel::where(['PERIODO_ID'=> $request->periodo_id, 
                                                 'PROG_ID'  => $request->prog_id     ])
                      ->get();
            if($existe->count() >=1 ){
                $fin_id     = $existe[0]->fin_id;
                $funcion_id = $existe[0]->funcion_id;
                $subfun_id  = $existe[0]->subfun_id;
                $program_id = $existe[0]->program_id;
                $subprog_id = $existe[0]->subprog_id;
                $proy_id    = $existe[0]->proy_id;
            }
            // ******************** Obtiene partida ************************/
            $partida = regfinandetModel::where(['PERIODO_ID'=> $request->periodo_id, 
                                                 'PROG_ID'  => $request->prog_id     ])
                       ->max('DET_NPARTIDA');
            $partida = $partida + 1;
            //dd($partida,' periodo:'.$request->periodo_id,' IAP:'.$request->osc_id,' folio'.$request->folio);

            $nuevoprogdtrab = new regfinandetModel();
            $nuevoprogdtrab->PERIODO_ID    = $request->periodo_id;                            
            $nuevoprogdtrab->PROG_ID       = $request->prog_id;
            $nuevoprogdtrab->DET_NPARTIDA  = $partida;            

            //$nuevoprogdtrab->DFECHA_ELAB = date('Y/m/d', strtotime(trim($dia1[0]->dia_desc.'/'.$mes1[0]->mes_mes.'/'.$request->periodo_id1) ));
            //$nuevoprogdtrab->DFECHA_ELAB2= trim($dia1[0]->dia_desc.'/'.$mes1[0]->mes_mes.'/'.$request->periodo_id1);
            $nuevoprogdtrab->PERIODO_ID2   = $request->periodo_id2;
            $nuevoprogdtrab->FUENTE_ID     = $request->fuente_id;
            $nuevoprogdtrab->CTGASTO_ID    = $request->ctgasto_id;
            $nuevoprogdtrab->CONAC_ID      = $request->conac_id;                                    
            $nuevoprogdtrab->SUBSECTOR_ID  = $request->subsector_id;
            $nuevoprogdtrab->DET_TOTAL     = $request->det_total;
            $nuevoprogdtrab->DET_PORCEN    = $request->det_porcen;

            $nuevoprogdtrab->FIN_ID        = $fin_id;
            $nuevoprogdtrab->FUNCION_ID    = $funcion_id;
            $nuevoprogdtrab->SUBFUN_ID     = $subfun_id;
            $nuevoprogdtrab->PROGRAM_ID    = $program_id;                                    
            $nuevoprogdtrab->SUBPROG_ID    = $subprog_id;            
            $nuevoprogdtrab->PROY_ID       = $proy_id;                        
      
            $nuevoprogdtrab->IP            = $ip;
            $nuevoprogdtrab->LOGIN         = $nombre;         // Usuario ;
            $nuevoprogdtrab->save();
            if($nuevoprogdtrab->save() == true){
                toastr()->success('Partida presupuestal dada de alta.','ok!',['positionClass' => 'toast-bottom-right']);
                /************ Bitacora inicia *************************************/ 
                setlocale(LC_TIME, "spanish");        
                $xip          = session()->get('ip');
                $xperiodo_id  = (int)date('Y');
                $xprograma_id = 1;
                $xmes_id      = (int)date('m');
                $xproceso_id  =         3;
                $xfuncion_id  =      3001;
                $xtrx_id      =         7;    //Alta
                $regbitacora = regBitacoraModel::select('PERIODO_ID','MES_ID','PROCESO_ID','FUNCION_ID', 
                                                    'TRX_ID','FOLIO','NO_VECES','FECHA_REG','IP','LOGIN', 
                                                    'FECHA_M','IP_M','LOGIN_M')
                               ->where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id,
                                        'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO'      => $request->prog_id])
                               ->get();
                if($regbitacora->count() <= 0){              // Alta
                    $nuevoregBitacora = new regBitacoraModel();              
                    $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                    $nuevoregBitacora->PROGRAMA_ID= $xprograma_id;   // Proyecto JAPEM 
                    $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                    $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                    $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                    $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                    $nuevoregBitacora->FOLIO      = $request->prog_id;            // Folio    
                    $nuevoregBitacora->NO_VECES   = 1;               // Numero de veces            
                    $nuevoregBitacora->IP         = $ip;             // IP
                    $nuevoregBitacora->LOGIN      = $nombre;         // Usuario 
                    $nuevoregBitacora->save();
                    if($nuevoregBitacora->save() == true)
                        toastr()->success('Trx de partida presupuestal registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                    else
                        toastr()->error('Error de Trx de partida presupuestal. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
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
                    toastr()->success('Trx de partida presupuestal actualizada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                }   /************ Bitacora termina *************************************/ 
            }else{
                toastr()->error('Error en Trx de partida presupuestal.','Ups!',['positionClass' => 'toast-bottom-right']);
            }   //**************** Termina la alta ***************/
        }   // ******************* Termina el duplicado **********/
        return redirect()->route('verfinanpresd',array($request->periodo_id,$request->prog_id));
    }

    public function actionEditarFinanpresd($id, $id2, $id3){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $codigo       = session()->get('codigo');

        $regperiodos  = regPeriodosModel::select('PERIODO_ID', 'PERIODO_DESC')
                        ->orderBy('PERIODO_ID','ASC')        
                        ->get();         
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')
                        ->get();      
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')
                        ->get();   
        $regprogramas = regProgramasModel::select('PROG_ID','PROG_DESC')
                        ->orderBy('PROG_ID','asc')
                        ->get();                                            
        $regfuente    = regFuentesModel::select('FUENTE_ID','FUENTE_DESC')
                        ->orderBy('FUENTE_ID','asc')
                        ->get();      
        $regtipogasto = regTipogastoModel::select('CTGASTO_ID','CTGASTO_DESC')
                        ->orderBy('CTGASTO_ID','asc')
                        ->get();                              
        $regconac     = regConacModel::select('CONAC_ID','CONAC_DESC')
                        ->orderBy('CONAC_ID','asc')
                        ->get();      
        $regsubsector = regSubsectoresModel::join('CP_CAT_SECTORES','CP_CAT_SECTORES.SECTOR_ID','=',
                                                                    'CP_CAT_SUBSECTORES.SECTOR_ID')
                                         ->select('CP_CAT_SECTORES.SECTOR_DESC',
                                                  'CP_CAT_SUBSECTORES.SUBSECTOR_ID',
                                                  'CP_CAT_SUBSECTORES.SUBSECTOR_DESC',
                                                  'CP_CAT_SUBSECTORES.SECTOR_ID')
                                        ->orderBy('CP_CAT_SUBSECTORES.SECTOR_ID'   ,'asc')
                                        ->orderBy('CP_CAT_SUBSECTORES.SUBSECTOR_ID','asc')
                        ->get();  
        $regfinanpres = regFinanpresModel::select('PERIODO_ID','PROG_ID','FIN_ID','FUNCION_ID','SUBFUN_ID','PROGRAM_ID', 
                        'SUBPROG_ID','PROY_ID','FINAN_ARC1','FINAN_ARC2','FINAN_ARC3','FINAN_ARC4','FINAN_ARC5', 
                        'FINAN_OBS1','FINAN_OBS2','FINAN_OBS3','FINAN_STATUS1','FINAN_STATUS2', 
                        'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')                        
                        ->where('PERIODO_ID',$id)
                        ->where('PROG_ID'   ,$id2)
                        ->orderBy('PERIODO_ID','asc')
                        ->orderBy('PROG_ID'   ,'asc')
                        ->get();                   
        //********* Validar rol de usuario **********************/
        if(session()->get('rango') !== '0'){                          
            $regfinandet=regfinandetModel::select('PERIODO_ID','PROG_ID','DET_NPARTIDA','PERIODO_ID2','FUENTE_ID', 
                         'CTGASTO_ID','CONAC_ID','SUBSECTOR_ID','FIN_ID','FUNCION_ID','SUBFUN_ID','PROGRAM_ID', 
                         'SUBPROG_ID','PROY_ID','DET_TOTAL','DET_PORCEN','DET_OBS1','DET_OBS2', 
                         'DET_STATUS1','DET_STATUS2',
                         'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')        
                         ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'DET_NPARTIDA' => $id3])
                         ->orderBy('PERIODO_ID'  ,'asc')
                         ->orderBy('PROG_ID'     ,'asc')
                         ->orderBy('DET_NPARTIDA','asc')
                         ->first();        
        }else{
            $regfinandet=regfinandetModel::select('PERIODO_ID','PROG_ID','DET_NPARTIDA','PERIODO_ID2','FUENTE_ID', 
                         'CTGASTO_ID','CONAC_ID','SUBSECTOR_ID','FIN_ID','FUNCION_ID','SUBFUN_ID','PROGRAM_ID', 
                         'SUBPROG_ID','PROY_ID','DET_TOTAL','DET_PORCEN','DET_OBS1','DET_OBS2', 
                         'DET_STATUS1','DET_STATUS2',
                         'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')        
                         ->where( ['PERIODO_ID' => $id,'PROG_ID' => $id2,'DET_NPARTIDA' => $id3])
                         ->where(  'PROG_ID'     ,$codigo)                        
                         ->orderBy('PERIODO_ID'  ,'asc')
                         ->orderBy('PROG_ID'     ,'asc')
                         ->orderBy('DET_NPARTIDA','asc')
                         ->first();                             
        }        
        //dd($regfinandet);
        if($regfinandet->count() <= 0){
            toastr()->error('No existe partida presupuestal.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.presupuesto.editarFinanpresdet',compact('nombre','usuario','codigo','regfuente','regtipogasto','regconac','regsubsector','regprogramas','regperiodos','regmeses','regdias','regfinanpres','regfinandet'));
    }

    public function actionActualizarFinanpresd(finanpresdetRequest $request, $id, $id2, $id3){
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
        $regfinandet = regfinandetModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'DET_NPARTIDA' => $id3]);
        if($regfinandet->count() <= 0)
            toastr()->error('No existe partida presupuestal.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            //********************** Actualizar ********************************/
            $ymes_id = (int)date('m');
            $ydia_id = (int)date('d');
            $mes     = regMesesModel::ObtMes($ymes_id);
            $dia     = regDiasModel::ObtDia($ydia_id);                

            $regfinandet = regfinandetModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'DET_NPARTIDA' => $id3])        
                           ->update([
                                     'PERIODO_ID2'  => $request->periodo_id2,                
                                     'FUENTE_ID'    => $request->fuente_id,
                                     'CTGASTO_ID'   => $request->ctgasto_id,
                                     'CONAC_ID'     => $request->conac_id,
                                     'SUBSECTOR_ID' => $request->subsector_id,
                                     
                                     'DET_TOTAL'   => $request->det_total,
                                     'DET_PORCEN'  => $request->det_porcen,

                                     'IP_M'         => $ip,
                                     'LOGIN_M'      => $nombre,
                                     'FECHA_M2'     => trim($dia[0]->dia_desc.'/'.$mes[0]->mes_mes.'/'.$id), 
                                     'FECHA_M'      => date('Y/m/d')    //date('d/m/Y')                                
                                    ]);
            toastr()->success('Partida presupuestal actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =         8;    //Actualizar 
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
                    toastr()->success('Trx de partida presupuestal registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error de partida presupuestal. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id,'MES_ID'     => $xmes_id, 
                                                      'PROCESO_ID' => $xproceso_id,'FUNCION_ID' => $xfuncion_id, 
                                                      'TRX_ID'     => $xtrx_id,    'FOLIO'      => $id2])
                             ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id, 
                                        'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO'      => $id2])
                               ->update([
                                         'NO_VECES'=> $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'    => $regbitacora->IP       = $ip,
                                         'LOGIN_M' => $regbitacora->LOGIN_M  = $nombre,
                                         'FECHA_M' => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                         ]);
                toastr()->success('Trx de partida presupuestal actualizada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                     
        }       /************ Actualizar *******************************************/
        return redirect()->route('verfinanpresd',array($id, $id2));
    }


    public function actionBorrarFinanpresd($id,$id2, $id3){
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

        /************ Eliminar **************************************/
        $regfinandet  = regfinandetModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'DET_NPARTIDA' => $id3]);
        //              ->find('UMEDIDA_ID',$id);
        if($regfinandet->count() <= 0)
            toastr()->error('No existe partida presupuestal.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            $regfinandet->delete();
            toastr()->success('Partida presupuestal eliminada.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            //echo 'Ya entre a borrar registro..........';
            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =         9;     // Baja 
            $regbitacora = regBitacoraModel::select('PERIODO_ID','MES_ID','PROCESO_ID','FUNCION_ID','TRX_ID','FOLIO', 
                                                    'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
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
                    toastr()->success('Trx de eliminar partida presupuestal registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error de Trx de eliminar partida presupuestal. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id,'MES_ID'     => $xmes_id,
                                                      'PROCESO_ID' => $xproceso_id,'FUNCION_ID' => $xfuncion_id,
                                                      'TRX_ID'     => $xtrx_id,    'FOLIO'      => $id2])
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
                toastr()->success('Trx de eliminar partida presupuestal actualizada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                 
        }       /************* Termina de eliminar *********************************/
        return redirect()->route('verfinanpresd',array($id, $id2));
    }    


}
