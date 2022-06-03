<?php
//**************************************************************/
//* File:       diagnosticoController.php
//* Función:    Cedula detección de necesidades
//* Autor:      Ing. Silverio Baltazar Barrientos Zarate
//* Modifico:   Ing. Silverio Baltazar Barrientos Zarate
//* Fecha act.: junio 2022
//* @Derechos reservados. Gobierno del Estado de México
//*************************************************************/
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\diagnosticopregsRequest;
use App\Http\Requests\diagnosticoRequest;
use App\Http\Requests\diagnostico1Request;

use App\regBitacoraModel;
use App\regPeriodosModel;
use App\regProgramasModel;
use App\regPreguntasModel;
use App\regDiagnosticoModel;

// Exportar a excel 
//use App\Exports\ExportCedulaExcel;
use Maatwebsite\Excel\Facades\Excel;
// Exportar a pdf
use PDF;
//use Options;

class diagnosticoController extends Controller
{

    public function actionBuscarDiagnostico(Request $request)
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
        $regpreguntas = regPreguntasModel::select('PREG_ID','PREG_DESC')
                        ->get();
        $regprogramas  = regProgramasModel::select('PROG_ID','PROG_DESC')
                         ->orderBy('PROG_ID','asc')
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
            $regdiagnostico= regDiagnosticoModel::join('CP_CAT_PROGRAMAS','CP_CAT_PROGRAMAS.PROG_ID', '=', 
                                                                          'CP_DIAGNOSTICO.PROG_ID')
                          ->select( 'CP_CAT_PROGRAMAS.PROG_DESC','CP_DIAGNOSTICO.*')                   
                          ->orderBy('CP_DIAGNOSTICO.PERIODO_ID','ASC')
                          ->orderBy('CP_DIAGNOSTICO.PROG_ID'   ,'ASC')
                          ->orderBy('CP_DIAGNOSTICO.PREG_ID'   ,'asc')
                       //->name($name)    //Metodos personalizados es equvalente a ->where('IAP_DESC', 'LIKE', "%$name%");
                       //->acti($acti)    //Metodos personalizados
                       //->bio($bio)      //Metodos personalizados
                       ->folio($folio)    //Metodos personalizados  
                       ->nameiap($nameiap) //Metodos personalizados                         
                       ->paginate(30);
        }else{
            $regdiagnostico= regDiagnosticoModel::join('CP_CAT_PROGRAMAS','CP_CAT_PROGRAMAS.PROG_ID', '=', 
                                                                          'CP_DIAGNOSTICO.PROG_ID')
                          ->select( 'CP_CAT_PROGRAMAS.PROG_DESC','CP_DIAGNOSTICO.*')                   
                          ->where(  'CP_DIAGNOSTICO.PROG_ID'   ,$codigo)                          
                          ->orderBy('CP_DIAGNOSTICO.PERIODO_ID','ASC')
                          ->orderBy('CP_DIAGNOSTICO.PROG_ID'   ,'ASC')
                          ->orderBy('CP_DIAGNOSTICO.PREG_ID'   ,'asc')
                          ->folio($folio)    //Metodos personalizados                                                            
                          ->name($name)      //Metodos personalizados es equvalente a ->where('IAP_DESC', 'LIKE', "%$name%");
                          ->nameiap($nameiap) //Metodos personalizados                                  
                          //->email($email)   //Metodos personalizados
                          //->bio($bio)       //Metodos personalizados
                          ->paginate(30);              
        }                               
        if($regdiagnostico->count() <= 0){
            toastr()->error('No existe cuestionario de diagnóstico.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }            
        return view('sicinar.diagnostico.verDiagnostico', compact('nombre','usuario','regprogramas','regperiodos','regdiagnostico','regpreguntas'));
    }

public function actionVerDiagnostico(){
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
        $regpreguntas = regPreguntasModel::select('PREG_ID','PREG_DESC')
                        ->get();
        $regprogramas  = regProgramasModel::select('PROG_ID','PROG_DESC')
                         ->orderBy('PROG_ID','asc')
                         ->get();                                                            
        //********* Validar rol de usuario **********************/
        if(session()->get('rango') !== '0'){    
            $regdiagnostico=regDiagnosticoModel::select('PERIODO_ID','PROG_ID','PREG_ID',
                            'PREG_DESC','PREG_RESP','PREG_URL','PREG_ARC','PREG_OBS1',
                            'PREG_OBS2','PREG_STATUS1','PREG_STATUS2',
                            'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                            ->orderBy('PERIODO_ID','ASC')
                            ->orderBy('PROG_ID'   ,'ASC')
                            ->paginate(30);
        }else{                       
            $regdiagnostico=regDiagnosticoModel::select('PERIODO_ID','PROG_ID','PREG_ID',
                            'PREG_DESC','PREG_RESP','PREG_URL','PREG_ARC','PREG_OBS1',
                            'PREG_OBS2','PREG_STATUS1','PREG_STATUS2',
                            'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                            ->where(  'PROG_ID'    ,$codigo)            
                            ->orderBy('PERIODO_ID','ASC')
                            ->orderBy('PROG_ID'   ,'ASC')
                            ->paginate(30);         
        }                        
        if($regdiagnostico->count() <= 0){
            toastr()->error('No existe cuestionario de diagnóstico.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.diagnostico.verDiagnostico',compact('nombre','usuario','regperiodos','regdiagnostico','regpreguntas','regprogramas'));
    }

    public function actionNuevoDiagnostico(){
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
        $regpreguntas = regPreguntasModel::select('PREG_ID','PREG_DESC')
                        ->get();                       
        if(session()->get('rango') !== '0'){                           
            $regprogramas = regProgramasModel::select('PROG_ID','PROG_DESC')
                            ->orderBy('PROG_ID','asc')
                            ->get();                                                 
            $regdiagnostico=regDiagnosticoModel::select('PERIODO_ID','PROG_ID','PREG_ID',
                            'PREG_DESC','PREG_RESP','PREG_URL','PREG_ARC','PREG_OBS1',
                            'PREG_OBS2','PREG_STATUS1','PREG_STATUS2',
                            'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                            ->get();
        }else{
            $regprogramas = regProgramasModel::select('PROG_ID','PROG_DESC')
                            ->where('PROG_ID',$codigo)
                            ->get();                                      
            $regdiagnostico=regDiagnosticoModel::select('PERIODO_ID','PROG_ID','PREG_ID',
                            'PREG_DESC','PREG_RESP','PREG_URL','PREG_ARC','PREG_OBS1',
                            'PREG_OBS2','PREG_STATUS1','PREG_STATUS2',
                            'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                            ->where('PROG_ID',$codigo)
                            ->get();
        }    
        return view('sicinar.diagnostico.nuevoDiagnostico',compact('nombre','usuario','regpreguntas','regperiodos','regdiagnostico','regprogramas')); 
    }

    public function actionAltaNuevoDiagnostico(Request $request){
        //dd($request->all());
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $arbol_id     = session()->get('arbol_id');

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
        //$periodo_id= $request->input('periodo_id');
        $preg_id     = $request->input('preg_id');
        $preg_desc   = $request->input('preg_desc');
        $preg_resp   = $request->input('preg_resp');
        $preg_url    = $request->input('preg_url');
        $preg_arc    = $request->input('preg_arc');
        
        $i       = 0;
        //for($i=1;$i<=$max;$i++){
        //foreach($arr_articulos as $articulo) {    
        foreach($preg_id as $key => $n ) {
            $i++;
            //********************* ALTA  *****************************/ 
            //**************** Validar duplicidad ***********************************/
            $duplicado = regDiagnosticoModel::where(['PERIODO_ID' => $request->periodo_id, 
                                                     'PROG_ID'    => $request->prog_id, 
                                                     'PREG_ID'    => $preg_id[$key] 
                                                    ])
                         //'ARTICULO_ID'  => $request->input('articulo_id')[$i]])
                         ->get();
            if($duplicado->count() >= 1)
                return back()->withInput()->withErrors(['PREG_ID' => 'Pregunta '.$preg_id[$key].' Ya existe en el cuestionario del diagnóstico.']);
            else{  

                // ******** Obtiene partida ************************/
                $name1 =null;
                $archi = Trim($preg_arc[$key]);
                $url   =  Trim($preg_url[$key]);
                //dd('preg....'.$key,'preg....'.$url,' i....'.$i,' archivo key....'.$request->file('preg_arc[$key]',' archivo crudo...'.$archi));
                //Comprobar  si el campo foto1 tiene un archivo asignado:
                if(isset($archi)){
                    if(!empty($archi)){

                       //if($request->hasFile('preg_arc[$key]')){
                       $name1 = $periodo_id.'_'.$prog_id.'_'.$request->file('preg_arc[$key]')->getClientOriginalName(); 
                       //dd('archivo....1'.$name1,' archivo key....'.$request->file('preg_arc[$key]',' archivo crudo...'.$archi));
                       //sube el archivo a la carpeta del servidor public/storage/
                       $request->file('preg_arc[$key]')->move(public_path().'/storage/', $name1);
                    }
                }
                
                $nuevoarti = new regDiagnosticoModel();

                $nuevoarti->PERIODO_ID     = $request->periodo_id;                            
                $nuevoarti->PROG_ID        = $request->prog_id;            
                //$nuevoarti->ARTICULO_ID  = $request->input('articulo_id')[$i];
                $nuevoarti->PREG_ID        = $preg_id[$key];
            
                $nuevoarti->PREG_DESC      = substr(trim(strtoupper($preg_desc[$key])),0,149);
                $nuevoarti->PREG_URL       = substr(trim($preg_url[$key])             ,0,299);
                $nuevoarti->PREG_ARC       = substr(trim(strtoupper($archi))          ,0,199);
      
                $nuevoarti->IP               = $ip;
                $nuevoarti->LOGIN            = $nombre;         // Usuario ;
                //dd($nuevoarti);
                $nuevoarti->save();
                //if($nuevoarti->save() == true)
                    //toastr()->success('Articulo en cedula dado de alta.','ok!',['positionClass' => 'toast-bottom-right']);
                //else
                    //toastr()->error('Error al dar de alta lista de articulos en la cedula. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
                //**************** Termina la alta ***************/
            }       //**************** Duplicado *********************/

        }   // ******************* for Termina listado de articulos **********/

        if($i = 0)
            toastr()->error('Error en el diagnostico. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
        else{  
                /************ Bitacora inicia *************************************/ 
                setlocale(LC_TIME, "spanish");        
                $xip          = session()->get('ip');
                $xperiodo_id  = (int)date('Y');
                $xprograma_id = 1;
                $xmes_id      = (int)date('m');
                $xproceso_id  =         3;
                $xfuncion_id  =      3001;
                $xtrx_id      =        67;    //Alta
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
                    $nuevoregBitacora->FOLIO      = $request->prog_id;          // Folio    
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
                    $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id,'MES_ID'     => $xmes_id, 
                                                          'PROCESO_ID' => $xproceso_id,'FUNCION_ID' => $xfuncion_id, 
                                                          'TRX_ID'     => $xtrx_id,    'FOLIO'      => $request->prog_id])
                                 ->max('NO_VECES');
                    $xno_veces = $xno_veces+1;                        
                    //*********** Termina de obtener el no de veces *****************************         
                    $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                                   ->where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id,'PROCESO_ID' => $xproceso_id,
                                            'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO' => $request->prog_id])
                                   ->update([
                                         'NO_VECES'=> $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'    => $regbitacora->IP       = $ip,
                                         'LOGIN_M' => $regbitacora->LOGIN_M  = $nombre,
                                         'FECHA_M' => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                       ]);
                    toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                }   /************ Bitacora termina *************************************/ 
        }
        return redirect()->route('verdiagnostico');        
        //return redirect()->route('verdiagnostico',array($request->periodo_id,$request->cedula_folio));        
    }
            
    public function actionEditarDiagnostico($id,$id2,$id3){
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
        $regpreguntas = regPreguntasModel::select('PREG_ID','PREG_DESC')
                        ->get();
        $regprogramas = regProgramasModel::select('PROG_ID','PROG_DESC')
                        ->orderBy('PROG_ID','asc')
                        ->get();                                                            
        if(session()->get('rango') !== '0'){                           
            $regdiagnostico=regDiagnosticoModel::select('PERIODO_ID','PROG_ID','PREG_ID',
                            'PREG_DESC','PREG_RESP','PREG_URL','PREG_ARC','PREG_OBS1',
                            'PREG_OBS2','PREG_STATUS1','PREG_STATUS2',
                            'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                            ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'PREG_ID' => $id3])
                            ->first();
        }else{
            $regdiagnostico=regDiagnosticoModel::select('PERIODO_ID','PROG_ID','PREG_ID',
                            'PREG_DESC','PREG_RESP','PREG_URL','PREG_ARC','PREG_OBS1',
                            'PREG_OBS2','PREG_STATUS1','PREG_STATUS2',
                            'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                            ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'PREG_ID' => $id3])
                            ->where( 'PROG_ID',$codigo)
                            ->first();
        }    
        if($regdiagnostico->count() <= 0){
            toastr()->error('No existe pregunta del cuestionario del diagnóstico.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        } 
        return view('sicinar.diagnostico.editarDiagnostico',compact('nombre','usuario','regpreguntas','regprogramas','regperiodos','regdiagnostico'));
    }

    public function actionActualizarDiagnostico(diagnosticoRequest $request,$id,$id2,$id3){
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
        $regdiagnostico = regDiagnosticoModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'PREG_ID' => $id3]);
        if($regdiagnostico->count() <= 0)
            toastr()->error('No existe pregunta del cuestionario del diagnóstico.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            //********************** Actualizar ********************************/
            $file1 =null;
            if(isset($request->preg_arc)){
                if(!empty($request->preg_arc)){
                    //Comprobar  si el campo act_const tiene un archivo asignado:
                    if($request->hasFile('preg_arc')){
                        $file1=$id.'_'.$id2.'_'.$id3.'_'.$request->file('preg_arc')->getClientOriginalName();
                        //sube el archivo a la carpeta del servidor public/images/
                        $request->file('preg_arc')->move(public_path().'/storage/', $file1);
                    }
                    $regdiagnostico=regDiagnosticoModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'PREG_ID' => $id3])
                                    ->update([                
                                       'PREG_RESP' => $request->preg_resp,
                                       'PREG_URL'  => substr(trim($request->preg_url)             ,0, 199),
                                       'PREG_ARC'  => substr(trim(strtoupper($file1))             ,0, 199),
                                       'PREG_OBS1' => substr(trim(strtoupper($request->preg_obs1)),0,3999),        

                                       'IP_M'      => $ip,
                                       'LOGIN_M'   => $nombre,
                                       'FECHA_M2'  => date('Y/m/d'),   //date('d/m/Y')            
                                       'FECHA_M'   => date('Y/m/d')    //date('d/m/Y')                                
                                     ]);
                    toastr()->success('pregunta del cuestionario de diagnóstico actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);

                }else{
                    $regdiagnostico=regDiagnosticoModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'PREG_ID' => $id3])
                                    ->update([                
                                       'PREG_RESP' => $request->preg_resp,
                                       'PREG_URL'  => substr(trim($request->preg_url)             ,0, 199),
                                       //'PREG_ARC'=> substr(trim(strtoupper($file1))             ,0, 199),
                                       'PREG_OBS1' => substr(trim(strtoupper($request->preg_obs1)),0,3999),        

                                       'IP_M'      => $ip,
                                       'LOGIN_M'   => $nombre,
                                       'FECHA_M2'  => date('Y/m/d'),   //date('d/m/Y')            
                                       'FECHA_M'   => date('Y/m/d')    //date('d/m/Y')                                
                                     ]);
                    toastr()->success('pregunta del cuestionario de diagnóstico actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                }
            }            

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =        68;    //Actualizar 
            $regbitacora = regBitacoraModel::select('PERIODO_ID', 'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
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
                    toastr()->success('pregunta del diagnóstico actualizada en bitacora correctamente.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error en trx de pregunta del diagnóstico. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id,
                             'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 
                             'TRX_ID' => $xtrx_id, 'FOLIO' => $id2])
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
                toastr()->success('pregunta del diagnóstico actualizada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                     
        }       /************ Actualizar *******************************************/
        return redirect()->route('verdiagnostico');
    }

    //***************** actulizar archivo digital *****************//
    public function actionEditarDiagnostico1($id,$id2,$id3){
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
        $regpreguntas = regPreguntasModel::select('PREG_ID','PREG_DESC')
                        ->get();
        $regprogramas = regProgramasModel::select('PROG_ID','PROG_DESC')
                        ->orderBy('PROG_ID','asc')
                        ->get();                                                            
        if(session()->get('rango') !== '0'){                           
            $regdiagnostico=regDiagnosticoModel::select('PERIODO_ID','PROG_ID','PREG_ID',
                            'PREG_DESC','PREG_RESP','PREG_URL','PREG_ARC','PREG_OBS1',
                            'PREG_OBS2','PREG_STATUS1','PREG_STATUS2',
                            'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                            ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'PREG_ID' => $id3])
                            ->first();
        }else{
            $regdiagnostico=regDiagnosticoModel::select('PERIODO_ID','PROG_ID','PREG_ID',
                            'PREG_DESC','PREG_RESP','PREG_URL','PREG_ARC','PREG_OBS1',
                            'PREG_OBS2','PREG_STATUS1','PREG_STATUS2',
                            'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                            ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'PREG_ID' => $id3])
                            ->where( 'PROG_ID',$codigo)
                            ->first();
        }    
        if($regdiagnostico->count() <= 0){
            toastr()->error('No existe pregunta del cuestionario del diagnóstico.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        } 
        return view('sicinar.diagnostico.editarDiagnostico1',compact('nombre','usuario','regpreguntas','regprogramas','regperiodos','regdiagnostico'));
    }

    public function actionActualizarDiagnostico1(diagnostico1Request $request,$id,$id2,$id3){
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
        $regdiagnostico = regDiagnosticoModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'PREG_ID' => $id3]);
        if($regdiagnostico->count() <= 0)
            toastr()->error('No existe pregunta del cuestionario del diagnóstico.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            //********************** Actualizar ********************************/
            $file1 =null;
            if(isset($request->preg_arc)){
                if(!empty($request->preg_arc)){
                    //Comprobar  si el campo act_const tiene un archivo asignado:
                    if($request->hasFile('preg_arc')){
                        $file1=$id.'_'.$id2.'_'.$id3.'_'.$request->file('preg_arc')->getClientOriginalName();
                        //sube el archivo a la carpeta del servidor public/images/
                        $request->file('preg_arc')->move(public_path().'/storage/', $file1);
                    
                        $regdiagnostico=regDiagnosticoModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'PREG_ID' => $id3])
                            ->update([                
                                       //'PREG_URL'  => substr(trim($request->preg_url)             ,0, 199),
                                       'PREG_ARC'  => substr(trim(strtoupper($file1))             ,0, 199),
                                       //'PREG_OBS1' => substr(trim(strtoupper($request->preg_obs1)),0,3999),        

                                       'IP_M'      => $ip,
                                       'LOGIN_M'   => $nombre,
                                       'FECHA_M2'  => date('Y/m/d'),   //date('d/m/Y')            
                                       'FECHA_M'   => date('Y/m/d')    //date('d/m/Y')                                
                                     ]);
                        toastr()->success('archivo digital del cuestionario de diagnóstico actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);

                        /************ Bitacora inicia *************************************/ 
                        setlocale(LC_TIME, "spanish");        
                        $xip          = session()->get('ip');
                        $xperiodo_id  = (int)date('Y');
                        $xprograma_id = 1;
                        $xmes_id      = (int)date('m');
                        $xproceso_id  =         3;
                        $xfuncion_id  =      3001;
                        $xtrx_id      =        68;    //Actualizar 
                        $regbitacora = regBitacoraModel::select('PERIODO_ID', 'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
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
                             toastr()->success('archivo digital del diagnóstico actualizada en bitacora correctamente.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                        else
                             toastr()->error('Error en trx de archivo digital del diagnóstico. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
                      }else{                   
                        //*********** Obtine el no. de veces *****************************
                        $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id,'MES_ID' => $xmes_id,
                                     'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 
                                     'TRX_ID' => $xtrx_id, 'FOLIO' => $id2])
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
                        toastr()->success('archivo digital del diagnóstico actualizada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                      }   /************ Bitacora termina *************************************/                     
                    }
                }
            }            

        }       /************ Actualizar *******************************************/
        return redirect()->route('verdiagnostico');
    }

    public function actionBorrarDiagnostico($id, $id2, $id3){
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
        $regdiagnostico  = regDiagnosticoModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'PREG_ID' => $id3]);
        //              ->find('UMEDIDA_ID',$id);
        if($regdiagnostico->count() <= 0)
            toastr()->error('No existe daignóstico.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            $regdiagnostico->delete();
            toastr()->success('diagnóstico eliminado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            //echo 'Ya entre a borrar registro..........';
            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =        69;     // Baja 
            $regbitacora = regBitacoraModel::select('PERIODO_ID','PROGRAMA_ID','MES_ID', 'PROCESO_ID','FUNCION_ID', 
                           'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 
                                    'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 
                                    'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
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
                                                      'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO' => $id])
                             ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                                        'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 
                                        'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                               ->update([
                                         'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'     => $regbitacora->IP       = $ip,
                                         'LOGIN_M'  => $regbitacora->LOGIN_M  = $nombre,
                                         'FECHA_M'  => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                 
        }       /************* Termina de eliminar *********************************/
        return redirect()->route('verdiagnostico');
    }    

    // exportar a formato excel
    public function actionExportProgtrabExcel($id){
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
        $xtrx_id      =        70;            // Exportar a formato Excel
        $id           =         0;
        $regbitacora  = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
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
                                     'IP_M'     => $regbitacora->IP       = $ip,
                                     'LOGIN_M'  => $regbitacora->LOGIN_M  = $nombre,
                                     'FECHA_M'  => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                    ]);
            toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
        }   /********************** Bitacora termina *************************************/  

        return Excel::download(new ExportCedulaExcel, 'Cedula_'.date('d-m-Y').'.xlsx');
    }

    // exportar a formato PDF
    public function actionExportCedulaPdf($id,$id2){
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
        $xtrx_id      =        71;       //Exportar a formato PDF
        $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
                       'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
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
               toastr()->success('Bitacora dada de alta correctamente.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            else
               toastr()->error('Erroral dar de alta la bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
        }else{                   
            //*********** Obtine el no. de veces *****************************
            $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                         'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 
                         'TRX_ID' => $xtrx_id, 'FOLIO' => $id2])
                        ->max('NO_VECES');
            $xno_veces = $xno_veces+1;                        
            //*********** Termina de obtener el no de veces *****************************         
            $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                           ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 
                                    'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                    'FOLIO' => $id2])
                           ->update([
                                     'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                     'IP_M' => $regbitacora->IP           = $ip,
                                     'LOGIN_M' => $regbitacora->LOGIN_M   = $nombre,
                                     'FECHA_M' => $regbitacora->FECHA_M   = date('Y/m/d')  //date('d/m/Y')
                                    ]);
            toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
        }   /************ Bitacora termina *************************************/ 

        $regarticulos = regArticulosModel::join('JP_CAT_TIPO_ARTICULO','JP_CAT_TIPO_ARTICULO.TIPO_ID','=','JP_CAT_ARTICULOS.TIPO_ID')
                                       ->select('JP_CAT_ARTICULOS.ARTICULO_ID', 'JP_CAT_ARTICULOS.ARTICULO_DESC',
                                                'JP_CAT_ARTICULOS.TIPO_ID','JP_CAT_TIPO_ARTICULO.TIPO_DESC')
                                       ->get(); 
        $regiap       = regIapModel::select('IAP_ID', 'IAP_DESC')->get();   
        //********* Validar rol de usuario **********************/
        if(session()->get('rango') !== '0'){                 
            $regdiagnostico= regCedulaModel::select('PERIODO_ID','CEDULA_FOLIO','IAP_ID','SP_ID','SP_NOMB',
                        'CEDULA_FECHA','CEDULA_FECHA2','PERIODO_ID1','MES_ID1','DIA_ID1','CEDULA_OBS','CEDULA_STATUS',
                        'FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                        ->where(['PERIODO_ID' => $id,'CEDULA_FOLIO' => $id2])                                 
                        ->get();
        }else{
            $regdiagnostico= regCedulaModel::select('PERIODO_ID','CEDULA_FOLIO','IAP_ID','SP_ID','SP_NOMB',
                        'CEDULA_FECHA','CEDULA_FECHA2','PERIODO_ID1','MES_ID1','DIA_ID1','CEDULA_OBS','CEDULA_STATUS',
                        'FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                        ->where(['PERIODO_ID' => $id,'CEDULA_FOLIO' => $id2, 'IAP_ID' => $arbol_id])
                        ->orderBy('PERIODO_ID'  ,'ASC')
                        ->orderBy('CEDULA_FOLIO','ASC')
                        ->get();            
        }                           
        $regcedulaarti= regCedulaarticulosModel::join('JP_CEDULA','JP_CEDULA.CEDULA_FOLIO','=',
                                                        'JP_CEDULA_ARTICULOS.CEDULA_FOLIO')
                        ->select( 'JP_CEDULA.PERIODO_ID',
                                  'JP_CEDULA.CEDULA_FOLIO',
                                  'JP_CEDULA.IAP_ID',
                                  'JP_CEDULA.SP_NOMB',
                                  'JP_CEDULA.CEDULA_FECHA2',
                                  'JP_CEDULA.CEDULA_OBS',
                                  'JP_CEDULA.CEDULA_STATUS',
                                  'JP_CEDULA_ARTICULOS.CEDULA_PARTIDA','JP_CEDULA_ARTICULOS.IAP_ID',
                                  'JP_CEDULA_ARTICULOS.CEDULA_FECHA'  ,'JP_CEDULA_ARTICULOS.CEDULA_FECHA2',
                                  'JP_CEDULA_ARTICULOS.PERIODO_ID1'   ,'JP_CEDULA_ARTICULOS.MES_ID1',
                                  'JP_CEDULA_ARTICULOS.DIA_ID1'       ,
                                  'JP_CEDULA_ARTICULOS.ARTICULO_ID'   ,
                                  'JP_CEDULA_ARTICULOS.ARTICULO_CANTIDAD',
                                  'JP_CEDULA_ARTICULOS.CEDART_OBS'    ,
                                  'JP_CEDULA_ARTICULOS.CEDART_STATUS',
                                  'JP_CEDULA_ARTICULOS.FECREG','JP_CEDULA_ARTICULOS.IP',
                                  'JP_CEDULA_ARTICULOS.LOGIN','JP_CEDULA_ARTICULOS.FECHA_M',
                                  'JP_CEDULA_ARTICULOS.IP_M','JP_CEDULA_ARTICULOS.LOGIN_M')         
                        ->where( ['JP_CEDULA.PERIODO_ID' => $id, 'JP_CEDULA.CEDULA_FOLIO' => $id2])
                        ->orderBy('JP_CEDULA.PERIODO_ID'    ,'asc')          
                        ->orderBy('JP_CEDULA.CEDULA_FOLIO'  ,'asc')
                        ->orderBy('JP_CEDULA_ARTICULOS.CEDULA_PARTIDA','asc')            
                        ->get();    
        //dd('Llave:',$id,' llave2:',$id2);       
        if($regcedulaarti->count() <= 0){
            toastr()->error('No existen articulos en la cuestionario de regdiagnóstico.','Uppss!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('verProgtrab');
        }else{
            $pdf = PDF::loadView('sicinar.pdf.CedulaPdf',compact('nombre','usuario','regarticulos','regiap','regcedula','regcedulaarti'));
            //******** Horizontal ***************
            //$pdf->setPaper('A4', 'landscape');      
            //$pdf->set('defaultFont', 'Courier');          
            //$pdf->setPaper('A4','portrait');
            // Output the generated PDF to Browser
            //******** vertical *************** 
            //El tamaño de hoja se especifica en page_size puede ser letter, legal, A4, etc.         
            $pdf->setPaper('letter','portrait');   
            // Output the generated PDF to Browser
            return $pdf->stream('CeduladeDetecciondeNecesidades-'.$id2);
        }
    }


    //*****************************************************************************//
    //********************* Detalle de la cedula - articulos **********************//
    //*****************************************************************************//
    public function actionVerCedulaarti($id,$id2){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $arbol_id     = session()->get('arbol_id');        

        $regarticulos = regArticulosModel::join('JP_CAT_TIPO_ARTICULO','JP_CAT_TIPO_ARTICULO.TIPO_ID','=','JP_CAT_ARTICULOS.TIPO_ID')
                                       ->select('JP_CAT_ARTICULOS.ARTICULO_ID', 'JP_CAT_ARTICULOS.ARTICULO_DESC',
                                                'JP_CAT_ARTICULOS.TIPO_ID','JP_CAT_TIPO_ARTICULO.TIPO_DESC')
                                       ->get(); 
        $regperiodos  = regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')->get();         
        $reganios     = regPeriodosaniosModel::select('PERIODO_ID','PERIODO_DESC')
                        ->wherein('PERIODO_ID',[2020,2021,2022,2023])        
                        ->get();        
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')->get();      
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')->get();                                
        $regiap       = regIapModel::select('IAP_ID', 'IAP_DESC')->orderBy('IAP_DESC','asc')->get();                     
        //************** Validar rol de usuario **********************/
        if(session()->get('rango') !== '0'){           
            $regdiagnostico= regCedulaModel::select('PERIODO_ID','CEDULA_FOLIO','IAP_ID','SP_ID','SP_NOMB',
                        'CEDULA_FECHA','CEDULA_FECHA2','PERIODO_ID1','MES_ID1','DIA_ID1','CEDULA_OBS','CEDULA_STATUS',
                        'FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                        ->where(['PERIODO_ID' => $id, 'CEDULA_FOLIO' => $id2])
                        ->orderBy('PERIODO_ID','ASC')
                        ->orderBy('IAP_ID'    ,'ASC')
                        ->get();
        }else{                         
            $regdiagnostico= regCedulaModel::select('PERIODO_ID','CEDULA_FOLIO','IAP_ID','SP_ID','SP_NOMB',
                        'CEDULA_FECHA','CEDULA_FECHA2','PERIODO_ID1','MES_ID1','DIA_ID1','CEDULA_OBS','CEDULA_STATUS',
                        'FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                        ->where(['PERIODO_ID' => $id, 'CEDULA_FOLIO' => $id2, 'IAP_ID' => $arbol_id])
                        //->where('FOLIO',$id)            
                        //->where('IAP_ID',$arbol_id)            
                        ->orderBy('PERIODO_ID','ASC')
                        ->orderBy('IAP_ID'    ,'ASC')
                        ->get();
        }                        
        if($regdiagnostico->count() <= 0){
            toastr()->error('No existe cuestionario de regdiagnóstico.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevoprogtrab');
        }
        $regcedulaarti= regCedulaarticulosModel::select('PERIODO_ID','CEDULA_FOLIO','CEDULA_PARTIDA','IAP_ID',
                        'CEDULA_FECHA','CEDULA_FECHA2','PERIODO_ID1','MES_ID1','DIA_ID1',
                        'ARTICULO_ID','ARTICULO_CANTIDAD','CEDART_OBS','CEDART_STATUS',
                        'FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')         
                        ->where( ['PERIODO_ID' => $id, 'CEDULA_FOLIO' => $id2])
                        ->orderBy('PERIODO_ID'    ,'asc')          
                        ->orderBy('CEDULA_FOLIO'  ,'asc')
                        ->orderBy('CEDULA_PARTIDA','asc')
                        ->paginate(100);           
        if($regcedulaarti->count() <= 0){
            toastr()->error('No existen artículos en la cédula de detección de necesidades.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevoprogtrab');
        }                        

        return view('sicinar.diagnostico.verCedulaarti',compact('nombre','usuario','regiap','regarticulos','reganios','regperiodos','regmeses','regdias','regdiagnostico','regcedulaarti'));
    }


    public function actionNuevaCedulaarti($id,$id2){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $arbol_id     = session()->get('arbol_id');

        $regtipos     = regTiposModel::select('TIPO_ID', 'TIPO_DESC')->get();  
        $regarticulos = regArticulosModel::select('ARTICULO_ID', 'ARTICULO_DESC','TIPO_ID')->orderBy('ARTICULO_ID','asc')
                        ->get(); 
        //$regperiodos  = regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')->get();         
        //$reganios     = regPeriodosaniosModel::select('PERIODO_ID','PERIODO_DESC')
        //                ->wherein('PERIODO_ID',[2020,2021,2022,2023])        
        //                ->get();        
        //$regmeses     = regMesesModel::select('MES_ID','MES_DESC')->get();      
        //$regdias      = regDiasModel::select('DIA_ID','DIA_DESC')->get();     
        if(session()->get('rango') !== '0'){                           
            $regiap   = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_STATUS')->orderBy('IAP_DESC','ASC')
                        ->get();                                                        
        }else{
            $regiap   = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_STATUS')->orderBy('IAP_DESC','ASC')
                        ->where('IAP_ID',$arbol_id)
                        ->get();            
        }    
        $regdiagnostico    = regCedulaModel::select('PERIODO_ID','CEDULA_FOLIO','IAP_ID','SP_ID','SP_NOMB',
                        'CEDULA_FECHA','CEDULA_FECHA2','PERIODO_ID1','MES_ID1','DIA_ID1','CEDULA_OBS','CEDULA_STATUS',
                        'FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                        ->where(['PERIODO_ID' => $id,'CEDULA_FOLIO' => $id2])            
                        ->get();
        $regcedulaarti= regCedulaarticulosModel::select('PERIODO_ID','CEDULA_FOLIO','CEDULA_PARTIDA','IAP_ID',
                        'CEDULA_FECHA','CEDULA_FECHA2','PERIODO_ID1','MES_ID1','DIA_ID1',
                        'ARTICULO_ID','ARTICULO_CANTIDAD','CEDART_OBS','CEDART_STATUS',
                        'FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')       
                        ->where( ['PERIODO_ID' => $id,'CEDULA_FOLIO' => $id2])                      
                        ->orderBy('CEDULA_FOLIO'  ,'asc')
                        ->orderBy('CEDULA_PARTIDA','asc')
                        ->get();                                
        //dd($unidades);
        //return view('sicinar.diagnostico.nuevoProgtrab',compact('regumedida','regiap','nombre','usuario','reganios','regperiodos','regmeses','regdias','regcedula'));
        return view('sicinar.diagnostico.nuevaCedulaarti',compact('nombre','usuario','regiap','regtipos','regarticulos','regdiagnostico','regcedulaarti'));   
    }

    public function actionAltaNuevaCedulaarti(Request $request){
        //dd($request->all());
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $arbol_id     = session()->get('arbol_id');

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
        //$duplicado = regCedulaarticulosModel::where(['PERIODO_ID' => $request->periodo_id,'IAP_ID' => $request->iap_id])
        //             ->get();
        //if($duplicado->count() >= 1)
        //    return back()->withInput()->withErrors(['IAP_ID' => 'IAP '.$request->iap_id.' Ya existe programa de trabajo en el mismo periodo y con la IAP referida. Por favor verificar.']);
        //else{  
        $max = regArticulosModel::max('ARTICULO_ID');
        //$max = $max+1;
        $per_aux = date('Y');
        $mes_aux = date('m');
        $dia_aux = date('d');
        $hoy     = date('Y/m/d');
        //$arr_articulos_id   = Post::get('articulo_id');
        //$arr_articulos_cant = Post::get('articulo_cantidad');
        //dd($arr_articulos_id,' arreglo:',$arr_articulos_cant);
        //dd(' Articulos:',$request->input('articulo_id'),' Cantidad:',$request->input('articulo_cantidad'));
        $articulo_id   = $request->input('articulo_id');
        $articulo_cant = $request->input('articulo_cantidad');
        $i       = 0;
        //for($i=1;$i<=$max;$i++){
        //foreach($arr_articulos as $articulo) {    
        foreach($articulo_id as $key => $n ) {
            $i++;
            //********************* ALTA  *****************************/ 
            //**************** Validar duplicidad ***********************************/
            $duplicado = regCedulaarticulosModel::where(['PERIODO_ID'   => $request->periodo_id, 
                                                         'IAP_ID'       => $request->iap_id, 
                                                         'CEDULA_FOLIO' => $request->cedula_folio,
                                                         'ARTICULO_ID'  => $articulo_id[$key] 
                                                        ])
                                                         //'ARTICULO_ID'  => $request->input('articulo_id')[$i]])
                         ->get();
            if($duplicado->count() >= 1)
                return back()->withInput()->withErrors(['ARTICULO_ID' => 'Artículo '.$articulo_id[$key].' Ya existe en la lista de la cedula.']);
            else{  

                // ******** Obtiene partida ************************/
                //$partida = regCedulaarticulosModel::where(['PERIODO_ID'   => $request->periodo_id, 
                //                                           'IAP_ID'       => $request->iap_id, 
                //                                           'CEDULA_FOLIO' => $request->cedula_folio])
                //           ->max('CEDULA_PARTIDA');
                //$partida = $partida + 1;
                
                $nuevoarti = new regCedulaarticulosModel();
                $nuevoarti->PERIODO_ID       = $request->periodo_id;                            
                $nuevoarti->IAP_ID           = $request->iap_id;            
                $nuevoarti->CEDULA_FOLIO     = $request->cedula_folio;
                //$nuevoarti->CEDULA_PARTIDA = $partida;
                $nuevoarti->CEDULA_PARTIDA   = $i;
                //$nuevoarti->ARTICULO_ID      = $request->input('articulo_id')[$i];
                $nuevoarti->ARTICULO_ID      = $articulo_id[$key];
            
                $nuevoarti->CEDULA_FECHA     = $hoy;
                $nuevoarti->CEDULA_FECHA2    = trim($dia_aux.'/'.$mes_aux.'/'.$per_aux);

                $nuevoarti->PERIODO_ID1      = $per_aux;
                $nuevoarti->MES_ID1          = $mes_aux;
                $nuevoarti->DIA_ID1          = $dia_aux;

                $nuevoarti->ARTICULO_CANTIDAD= $articulo_cant[$key];
                $nuevoarti->CEDART_OBS       = substr(trim(strtoupper($request->cedart_obs)),0,499);
      
                $nuevoarti->IP               = $ip;
                $nuevoarti->LOGIN            = $nombre;         // Usuario ;
                //dd($nuevoarti);
                $nuevoarti->save();
                //if($nuevoarti->save() == true)
                    //toastr()->success('Articulo en cedula dado de alta.','ok!',['positionClass' => 'toast-bottom-right']);
                //else
                    //toastr()->error('Error al dar de alta lista de articulos en la cedula. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
                //**************** Termina la alta ***************/
            }       //**************** Duplicado *********************/

        }   // ******************* for Termina listado de articulos **********/

        if($i = 0)
            toastr()->error('Error al dar de alta artículos en la cédula. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
        else{  
                /************ Bitacora inicia *************************************/ 
                setlocale(LC_TIME, "spanish");        
                $xip          = session()->get('ip');
                $xperiodo_id  = (int)date('Y');
                $xprograma_id = 1;
                $xmes_id      = (int)date('m');
                $xproceso_id  =         3;
                $xfuncion_id  =      3012;
                $xtrx_id      =        32;    //Alta
                $regbitacora = regBitacoraModel::select('PERIODO_ID','PROGRAMA_ID','MES_ID','PROCESO_ID','FUNCION_ID', 
                                                    'TRX_ID','FOLIO','NO_VECES','FECHA_REG','IP','LOGIN', 
                                                    'FECHA_M','IP_M','LOGIN_M')
                               ->where(['PERIODO_ID' => $xperiodo_id,'PROGRAMA_ID' => $xprograma_id,'MES_ID' => $xmes_id,
                                    'PROCESO_ID' => $xproceso_id,'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id, 
                                    'FOLIO' => $request->cedula_folio])
                               ->get();
                if($regbitacora->count() <= 0){              // Alta
                    $nuevoregBitacora = new regBitacoraModel();              
                    $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                    $nuevoregBitacora->PROGRAMA_ID= $xprograma_id;   // Proyecto JAPEM 
                    $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                    $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                    $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                    $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                    $nuevoregBitacora->FOLIO      = $request->cedula_folio;          // Folio    
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
                                                      'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                                      'FOLIO' => $request->cedula_folio])
                                 ->max('NO_VECES');
                    $xno_veces = $xno_veces+1;                        
                    //*********** Termina de obtener el no de veces *****************************         
                    $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                                   ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                                        'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 
                                        'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO' => $request->cedula_folio])
                                   ->update([
                                         'NO_VECES'=> $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'    => $regbitacora->IP       = $ip,
                                         'LOGIN_M' => $regbitacora->LOGIN_M  = $nombre,
                                         'FECHA_M' => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                       ]);
                    toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                }   /************ Bitacora termina *************************************/ 
        }

        return redirect()->route('verCedulaarti',array($request->periodo_id,$request->cedula_folio));
    }

    public function actionEditarCedulaarti($id,$id2,$id3){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');
        $arbol_id      = session()->get('arbol_id');        

        $regarticulos = regArticulosModel::join('JP_CAT_TIPO_ARTICULO','JP_CAT_TIPO_ARTICULO.TIPO_ID','=','JP_CAT_ARTICULOS.TIPO_ID')
                                       ->select('JP_CAT_ARTICULOS.ARTICULO_ID', 'JP_CAT_ARTICULOS.ARTICULO_DESC',
                                                'JP_CAT_ARTICULOS.TIPO_ID','JP_CAT_TIPO_ARTICULO.TIPO_DESC')
                                       ->get(); 
        $reganios     = regPeriodosaniosModel::select('PERIODO_ID','PERIODO_DESC')
                        ->wherein('PERIODO_ID',[2020,2021,2022,2023])        
                        ->get();
        $regperiodos  = regPfiscalesModel::select('PERIODO_ID', 'PERIODO_DESC')->get();         
        $regmeses     = regMesesModel::select('MES_ID','MES_DESC')->get();      
        $regdias      = regDiasModel::select('DIA_ID','DIA_DESC')->get();         
        //********* Validar rol de usuario **********************/
        if(session()->get('rango') !== '0'){                          
            $regiap   = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_STATUS')
                        ->get();                                                        
        }else{
            $regiap   = regIapModel::select('IAP_ID', 'IAP_DESC','IAP_STATUS')
                        ->where('IAP_ID',$arbol_id)
                        ->get();            
        }                    
        $regdiagnostico    = regCedulaModel::select('PERIODO_ID','CEDULA_FOLIO','IAP_ID','SP_ID','SP_NOMB',
                        'CEDULA_FECHA','CEDULA_FECHA2','PERIODO_ID1','MES_ID1','DIA_ID1','CEDULA_OBS','CEDULA_STATUS',
                        'FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')
                        ->where(['PERIODO_ID' => $id, 'CEDULA_FOLIO' => $id2])
                        ->get();
        $regcedulaarti= regCedulaarticulosModel::select('PERIODO_ID','CEDULA_FOLIO','CEDULA_PARTIDA','IAP_ID',
                        'CEDULA_FECHA','CEDULA_FECHA2','PERIODO_ID1','MES_ID1','DIA_ID1',
                        'ARTICULO_ID','ARTICULO_CANTIDAD','CEDART_OBS','CEDART_STATUS',
                        'FECREG','IP','LOGIN','FECHA_M','IP_M','LOGIN_M')       
                        ->where(['PERIODO_ID' => $id,'CEDULA_FOLIO' => $id2, 'ARTICULO_ID' => $id3])
                        //->where('FOLIO',$id)
                        //->where('PARTIDA',$id2)
                        ->first();
        if($regcedulaarti->count() <= 0){
            toastr()->error('No existe artículo en cedula.','Lo siento!',['positionClass' => 'toast-bottom-right']);
            //return redirect()->route('nuevoprogtrab');
        }
        //return view('sicinar.diagnostico.editarProgtrab',compact('nombre','usuario','regiap','regumedida','reganios','regperiodos','regmeses','regdias','regcedula'));
        return view('sicinar.diagnostico.editarCedulaarti',compact('nombre','usuario','regarticulos','regiap','reganios','regperiodos','regmeses','regdias','regdiagnostico','regcedulaarti'));

    }

    public function actionActualizarCedulaarti(cedulaarticuloRequest $request, $id, $id2,$id3){
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
        $regcedulaarti = regCedulaarticulosModel::where(['PERIODO_ID' => $id,'CEDULA_FOLIO' => $id2, 'ARTICULO_ID' => $id3]);
        if($regcedulaarti->count() <= 0)
            toastr()->error('No existe articulo en la cedula.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            //********************** Actualizar ********************************/
            $regcedulaarti = regCedulaarticulosModel::where(['PERIODO_ID' => $id,'CEDULA_FOLIO' => $id2, 'ARTICULO_ID' => $id3])        
                             ->update([                
                                        'ARTICULO_CANTIDAD' => $request->articulo_cantidad,

                                        'IP_M'              => $ip,
                                        'LOGIN_M'           => $nombre,
                                        'FECHA_M'           => date('Y/m/d')    //date('d/m/Y')                                
                                       ]);
            toastr()->success('Articulo en cedula actualizado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3012;
            $xtrx_id      =        33;    //Actualizar 
            $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 'FUNCION_ID', 
                           'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
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
                    toastr()->success('Bitacora dada de alta correctamente.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error inesperado al dar de alta la bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                             'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 
                             'TRX_ID' => $xtrx_id, 'FOLIO' => $id2])
                             ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                                        'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 
                                        'TRX_ID' => $xtrx_id, 'FOLIO' => $id2])
                               ->update([
                                         'NO_VECES'=> $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'    => $regbitacora->IP       = $ip,
                                         'LOGIN_M' => $regbitacora->LOGIN_M  = $nombre,
                                         'FECHA_M' => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                         ]);
                toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                     
        }       /************ Actualizar *******************************************/

        return redirect()->route('verCedulaarti',array($id,$id2));

    }


    public function actionBorrarCedulaArti($id,$id2,$id3){
        //dd($request->all());
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $arbol_id     = session()->get('arbol_id');        

        /************ Eliminar **************************************/
        $regcedulaarti  = regCedulaarticulosModel::where(['PERIODO_ID' => $id, 'CEDULA_FOLIO' => $id2]);
        //              ->find('UMEDIDA_ID',$id);
        if($regcedulaarti->count() <= 0)
            toastr()->error('No existe cedula.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            $regcedulaarti->delete();
            toastr()->success('Articulo de Cedula eliminado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            //echo 'Ya entre a borrar registro..........';
            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3012;
            $xtrx_id      =        34;     // Baja 
            $regbitacora = regBitacoraModel::select('PERIODO_ID','PROGRAMA_ID','MES_ID', 'PROCESO_ID','FUNCION_ID', 
                           'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 'IP_M', 'LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 'MES_ID' => $xmes_id, 
                                    'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 
                                    'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
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
                                                      'FUNCION_ID' => $xfuncion_id,'TRX_ID' => $xtrx_id,'FOLIO' => $id])
                             ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                                        'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 
                                        'TRX_ID' => $xtrx_id, 'FOLIO' => $id])
                               ->update([
                                         'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'     => $regbitacora->IP       = $ip,
                                         'LOGIN_M'  => $regbitacora->LOGIN_M  = $nombre,
                                         'FECHA_M'  => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('Bitacora actualizada.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                 
        }       /************* Termina de eliminar *********************************/
        return redirect()->route('verCedula');
    }    

}
