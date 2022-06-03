<?php
//**************************************************************/
//* File:       objprogController.php
//* Autor:      Ing. Silverio Baltazar Barrientos Zarate
//* Modifico:   Ing. Silverio Baltazar Barrientos Zarate
//* Fecha act.: diciembre 2022
//* @Derechos reservados. Gobierno del Estado de México
//*************************************************************/
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\objprogRequest;
use App\regProgramasModel;
use App\regBitacoraModel;
use App\regDiasModel;
use App\regMesesModel;
use App\regPeriodosModel;
use App\regObjprogModel;

// Exportar a excel 
//use App\Exports\ExcelExportCatIAPS;
use Maatwebsite\Excel\Facades\Excel;
// Exportar a pdf
use PDF;
//use Options;

class objprogController extends Controller
{
 
    public function actionBuscarObjprog(Request $request)
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

        $regdias    = regDiasModel::select('DIA_ID','DIA_DESC')
                      ->get();
        $regmeses   = regMesesModel::select('MES_ID','MES_DESC')
                      ->get();
        $regperiodos= regPeriodosModel::select('PERIODO_ID', 'PERIODO_DESC')
                      ->orderBy('PERIODO_ID','asc')
                      ->get();  
        //**************************************************************//
        // ***** busqueda https://github.com/rimorsoft/Search-simple ***//
        // ***** video https://www.youtube.com/watch?v=bmtD9GUaszw   ***//
        //**************************************************************//
        $name  = $request->get('name');    
        $idd   = $request->get('idd');  
        $bio   = $request->get('bio');    
        if(session()->get('rango') !== '0'){                    
            $regprograma= regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->orderBy('PROG_ID','asc')
                          ->get();          
            $regobjprog = regObjprogModel::orderBy('PERIODO_ID', 'ASC')
                          ->orderBy('PROG_ID','ASC')
                          ->name($name)           //Metodos personalizados es equvalente a ->where('IAP_DESC', 'LIKE', "%$name%");
                          ->idd($idd)             //Metodos personalizados
                          ->bio($bio)             //Metodos personalizados
                          ->paginate(50);
        }else{           
            $regprograma= regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->where(  'PROG_ID',$codigo)
                          ->orderBy('PROG_ID','asc')
                          ->get();                    
            $regobjprog = regObjprogModel::where('PROG_ID',$codigo)
                          ->orderBy('PERIODO_ID','ASC')
                          ->orderBy('PROG_ID'   ,'ASC')
                          ->name($name)           //Metodos personalizados es equvalente a ->where('IAP_DESC', 'LIKE', "%$name%");
                          ->idd($idd)             //Metodos personalizados
                          ->bio($bio)             //Metodos personalizados
                          ->paginate(50);          
        }                          
        if($regobjprog->count() <= 0){
            toastr()->error('No existen registros.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }       
        return view('sicinar.programa.verObjprog',compact('nombre','usuario','codigo','regperiodos','regprograma','regobjprog')); 
    }


    //*********** Mostrar las aportaciones ***************//
    public function actionVerObjprog(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $codigo       = session()->get('codigo');   

        $regmeses   = regMesesModel::select('MES_ID', 'MES_DESC')
                      ->get();
        $regperiodos= regPeriodosModel::select('PERIODO_ID','PERIODO_DESC')
                      ->orderBy('PERIODO_ID','asc')
                      ->get();          
        if(session()->get('rango') !== '0'){     
            $regprograma= regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->orderBy('PROG_ID','asc')
                          ->get();           
            $regobjprog = regObjprogModel::select('PERIODO_ID','PROG_ID','OBJ_PROG','OBJ_META',
                          'OBJ_UNI_ATEN','OBJ_COBERTURA','OBJ_REQ_CRITER','OBJ_DOCTOS','OBJ_CRIT_PRIORI',        
                          'OBJ_ZONA_ATEN','OBJ_SECTORES_APOYA',
                          'OBJ_OPER_EJEC1','OBJ_OPER_EJEC2','OBJ_OPER_EJEC3','OBJ_OPER_EJEC4','OBJ_OPER_EJEC5',
                          'OBJ_OPER_EJEC6','OBJ_ODS01','OBJ_ODS02','OBJ_ODS03','OBJ_ODS04','OBJ_ODS05','OBJ_ODS06',
                          'OBJ_ODS07','OBJ_ODS08','OBJ_ODS09','OBJ_ODS10','OBJ_ODS11','OBJ_ODS12','OBJ_ODS13','OBJ_ODS14',
                          'OBJ_ODS15','OBJ_ODS16','OBJ_ODS17',
                          'OBJ_PDEM01','OBJ_PDEM02','OBJ_PDEM03','OBJ_PDEM04','OBJ_PDEM05','OBJ_PDEM06','OBJ_PDEM07',
                          'OBJ_SEC_01','OBJ_SEC_02','OBJ_SEC_03','OBJ_SEC_04','OBJ_SEC_05',
                          'OBJ_SEC_06','OBJ_SEC_07','OBJ_SEC_08','OBJ_SEC_09','OBJ_SEC_10',
                          'OBJ_SEC_11','OBJ_SEC_12','OBJ_SEC_13','OBJ_SEC_14','OBJ_SEC_15',
                          'OBJ_SEC_16','OBJ_SEC_17','OBJ_SEC_18','OBJ_SEC_19','OBJ_SEC_20',
                          'OBJ_SEC_21','OBJ_SEC_22','PERIODO_ID1','MES_ID1','DIA_ID1',
                          'OBJ_OBS1','OBJ_OBS2','OBJ_ARC1','OBJ_ARC2','OBJ_STATUS1','OBJ_STATUS2',
                          'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                          ->orderBy('PERIODO_ID','ASC')
                          ->orderBy('PROG_ID'   ,'ASC')
                          ->paginate(30);
        }else{
            $regprograma= regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->where(  'PROG_ID',$codigo)
                          ->orderBy('PROG_ID','asc')
                          ->get();                    
            $regobjprog = regObjprogModel::select('PERIODO_ID','PROG_ID','OBJ_PROG','OBJ_META',
                          'OBJ_UNI_ATEN','OBJ_COBERTURA','OBJ_REQ_CRITER','OBJ_DOCTOS','OBJ_CRIT_PRIORI',        
                          'OBJ_ZONA_ATEN','OBJ_SECTORES_APOYA',
                          'OBJ_OPER_EJEC1','OBJ_OPER_EJEC2','OBJ_OPER_EJEC3','OBJ_OPER_EJEC4','OBJ_OPER_EJEC5',
                          'OBJ_OPER_EJEC6','OBJ_ODS01','OBJ_ODS02','OBJ_ODS03','OBJ_ODS04','OBJ_ODS05','OBJ_ODS06',
                          'OBJ_ODS07','OBJ_ODS08','OBJ_ODS09','OBJ_ODS10','OBJ_ODS11','OBJ_ODS12','OBJ_ODS13','OBJ_ODS14',
                          'OBJ_ODS15','OBJ_ODS16','OBJ_ODS17',
                          'OBJ_PDEM01','OBJ_PDEM02','OBJ_PDEM03','OBJ_PDEM04','OBJ_PDEM05','OBJ_PDEM06','OBJ_PDEM07',
                          'OBJ_SEC_01','OBJ_SEC_02','OBJ_SEC_03','OBJ_SEC_04','OBJ_SEC_05',
                          'OBJ_SEC_06','OBJ_SEC_07','OBJ_SEC_08','OBJ_SEC_09','OBJ_SEC_10',
                          'OBJ_SEC_11','OBJ_SEC_12','OBJ_SEC_13','OBJ_SEC_14','OBJ_SEC_15',
                          'OBJ_SEC_16','OBJ_SEC_17','OBJ_SEC_18','OBJ_SEC_19','OBJ_SEC_20',
                          'OBJ_SEC_21','OBJ_SEC_22','PERIODO_ID1','MES_ID1','DIA_ID1',                          
                          'OBJ_OBS1','OBJ_OBS2','OBJ_ARC1','OBJ_ARC2','OBJ_STATUS1','OBJ_STATUS2',
                          'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                          ->where(  'PROG_ID'   ,$codigo)         
                          ->orderBy('PERIODO_ID','ASC')
                          ->orderBy('PROG_ID'   ,'ASC')
                          ->paginate(30);
        }          
        if($regobjprog->count() <= 0){
            toastr()->error('No existen registros.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.programa.verObjprog',compact('nombre','usuario','codigo','regperiodos','regprograma','regobjprog'));
    }
 
    public function actionNuevoObjprog(){
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');
        $codigo       = session()->get('codigo');   

        $regperiodos= regPeriodosModel::select('PERIODO_ID','PERIODO_DESC')
                      ->orderBy('PERIODO_ID','asc')
                      ->get();          
        $regmeses   = regMesesModel::select('MES_ID','MES_DESC')
                      ->get();
        $regdias    = regDiasModel::select('DIA_ID','DIA_DESC')
                      ->orderBy('DIA_ID','asc')
                      ->get();                      
        if(session()->get('rango') !== '0'){     
            $regprograma= regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->orderBy('PROG_ID','asc')
                          ->get();          
            $regobjprog = regObjprogModel::select('PERIODO_ID','PROG_ID','OBJ_PROG','OBJ_META',
                          'OBJ_UNI_ATEN','OBJ_COBERTURA','OBJ_REQ_CRITER','OBJ_DOCTOS','OBJ_CRIT_PRIORI',        
                          'OBJ_ZONA_ATEN','OBJ_SECTORES_APOYA',
                          'OBJ_OPER_EJEC1','OBJ_OPER_EJEC2','OBJ_OPER_EJEC3','OBJ_OPER_EJEC4','OBJ_OPER_EJEC5',
                          'OBJ_OPER_EJEC6','OBJ_ODS01','OBJ_ODS02','OBJ_ODS03','OBJ_ODS04','OBJ_ODS05','OBJ_ODS06',
                          'OBJ_ODS07','OBJ_ODS08','OBJ_ODS09','OBJ_ODS10','OBJ_ODS11','OBJ_ODS12','OBJ_ODS13','OBJ_ODS14',
                          'OBJ_ODS15','OBJ_ODS16','OBJ_ODS17',
                          'OBJ_PDEM01','OBJ_PDEM02','OBJ_PDEM03','OBJ_PDEM04','OBJ_PDEM05','OBJ_PDEM06','OBJ_PDEM07',
                          'OBJ_SEC_01','OBJ_SEC_02','OBJ_SEC_03','OBJ_SEC_04','OBJ_SEC_05',
                          'OBJ_SEC_06','OBJ_SEC_07','OBJ_SEC_08','OBJ_SEC_09','OBJ_SEC_10',
                          'OBJ_SEC_11','OBJ_SEC_12','OBJ_SEC_13','OBJ_SEC_14','OBJ_SEC_15',
                          'OBJ_SEC_16','OBJ_SEC_17','OBJ_SEC_18','OBJ_SEC_19','OBJ_SEC_20',
                          'OBJ_SEC_21','OBJ_SEC_22','PERIODO_ID1','MES_ID1','DIA_ID1',                          
                          'OBJ_OBS1','OBJ_OBS2','OBJ_ARC1','OBJ_ARC2','OBJ_STATUS1','OBJ_STATUS2',
                          'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                          ->orderBy('PERIODO_ID','ASC')
                          ->orderBy('PROG_ID'   ,'ASC')
                          ->get();
        }else{
            $regprograma= regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->where(  'PROG_ID',$codigo)
                          ->orderBy('PROG_ID','asc')
                          ->get();                    
            $regobjprog = regObjprogModel::select('PERIODO_ID','PROG_ID','OBJ_PROG','OBJ_META',
                          'OBJ_UNI_ATEN','OBJ_COBERTURA','OBJ_REQ_CRITER','OBJ_DOCTOS','OBJ_CRIT_PRIORI',        
                          'OBJ_ZONA_ATEN','OBJ_SECTORES_APOYA',
                          'OBJ_OPER_EJEC1','OBJ_OPER_EJEC2','OBJ_OPER_EJEC3','OBJ_OPER_EJEC4','OBJ_OPER_EJEC5',
                          'OBJ_OPER_EJEC6','OBJ_ODS01','OBJ_ODS02','OBJ_ODS03','OBJ_ODS04','OBJ_ODS05','OBJ_ODS06',
                          'OBJ_ODS07','OBJ_ODS08','OBJ_ODS09','OBJ_ODS10','OBJ_ODS11','OBJ_ODS12','OBJ_ODS13','OBJ_ODS14',
                          'OBJ_ODS15','OBJ_ODS16','OBJ_ODS17',
                          'OBJ_PDEM01','OBJ_PDEM02','OBJ_PDEM03','OBJ_PDEM04','OBJ_PDEM05','OBJ_PDEM06','OBJ_PDEM07',
                          'OBJ_SEC_01','OBJ_SEC_02','OBJ_SEC_03','OBJ_SEC_04','OBJ_SEC_05',
                          'OBJ_SEC_06','OBJ_SEC_07','OBJ_SEC_08','OBJ_SEC_09','OBJ_SEC_10',
                          'OBJ_SEC_11','OBJ_SEC_12','OBJ_SEC_13','OBJ_SEC_14','OBJ_SEC_15',
                          'OBJ_SEC_16','OBJ_SEC_17','OBJ_SEC_18','OBJ_SEC_19','OBJ_SEC_20',
                          'OBJ_SEC_21','OBJ_SEC_22','PERIODO_ID1','MES_ID1','DIA_ID1',                          
                          'OBJ_OBS1','OBJ_OBS2','OBJ_ARC1','OBJ_ARC2','OBJ_STATUS1','OBJ_STATUS2',
                          'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                          ->where(  'PROG_ID'   ,$codigo)         
                          ->orderBy('PERIODO_ID','ASC')
                          ->orderBy('PROG_ID'   ,'ASC')
                          ->get();
        }          
        return view('sicinar.programa.nuevoObjprog',compact('nombre','usuario','codigo','regperiodos','regmeses','regdias','regprograma','regobjprog'));
    }

    public function actionAltaNuevoObjprog(Request $request){
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

        /************ Registro de la aportación monetaria *****************************/ 
        //$apor_folio = regAportacionesModel::max('APOR_FOLIO');
        //$apor_folio = $apor_folio+1;

        $nuevoobj = new regObjprogModel();
        $nuevoobj->PERIODO_ID     = $request->periodo_id;
        $nuevoobj->PROG_ID        = $request->prog_id;  
        $nuevoobj->OBJ_PROG       = substr(trim(strtoupper($request->obj_prog))       ,0,3999);
        $nuevoobj->OBJ_META       = substr(trim(strtoupper($request->obj_meta))       ,0,3999);        
        $nuevoobj->OBJ_UNI_ATEN   = substr(trim(strtoupper($request->obj_uni_aten))   ,0,3999);
        $nuevoobj->OBJ_COBERTURA  = substr(trim(strtoupper($request->obj_cobertura))  ,0,3999);
        $nuevoobj->OBJ_REQ_CRITER = substr(trim(strtoupper($request->obj_req_criter)) ,0,3999);
        $nuevoobj->OBJ_DOCTOS     = substr(trim(strtoupper($request->obj_doctos))     ,0,3999);
        $nuevoobj->OBJ_CRIT_PRIORI= substr(trim(strtoupper($request->obj_crit_priori)),0,3999);
        $nuevoobj->OBJ_ZONA_ATEN  = substr(trim(strtoupper($request->obj_zona_aten))  ,0,3999);
        $nuevoobj->OBJ_SECTORES_APOYA= substr(trim(strtoupper($request->obj_sectores_apoya)),0,3999);

        $nuevoobj->OBJ_SEC_01     = $request->obj_sec_01;
        $nuevoobj->OBJ_SEC_02     = $request->obj_sec_02;
        $nuevoobj->OBJ_SEC_03     = $request->obj_sec_03;       
        $nuevoobj->OBJ_SEC_04     = $request->obj_sec_03;
        $nuevoobj->OBJ_SEC_05     = $request->obj_sec_05;
        $nuevoobj->OBJ_SEC_06     = $request->obj_sec_06;
        $nuevoobj->OBJ_SEC_07     = $request->obj_sec_07;
        $nuevoobj->OBJ_SEC_08     = $request->obj_sec_08;
        $nuevoobj->OBJ_SEC_09     = $request->obj_sec_09;       
        $nuevoobj->OBJ_SEC_10     = $request->obj_sec_10;
        $nuevoobj->OBJ_SEC_11     = $request->obj_sec_11;
        $nuevoobj->OBJ_SEC_12     = $request->obj_sec_12;        
        $nuevoobj->OBJ_SEC_13     = $request->obj_sec_13;
        $nuevoobj->OBJ_SEC_14     = $request->obj_sec_13;
        $nuevoobj->OBJ_SEC_15     = $request->obj_sec_15;       
        $nuevoobj->OBJ_SEC_16     = $request->obj_sec_16;
        $nuevoobj->OBJ_SEC_17     = $request->obj_sec_17;
        $nuevoobj->OBJ_SEC_18     = $request->obj_sec_18;
        $nuevoobj->OBJ_SEC_19     = $request->obj_sec_19;       
        $nuevoobj->OBJ_SEC_20     = $request->obj_sec_20;
        $nuevoobj->OBJ_SEC_21     = $request->obj_sec_21;
        $nuevoobj->OBJ_SEC_22     = $request->obj_sec_22;           

        $nuevoobj->OBJ_OPER_EJEC1 = $request->obj_oper_ejec1;
        $nuevoobj->OBJ_OPER_EJEC2 = $request->obj_oper_ejec2;
        $nuevoobj->OBJ_OPER_EJEC3 = $request->obj_oper_ejec3;
        $nuevoobj->OBJ_OPER_EJEC4 = $request->obj_oper_ejec4;
        $nuevoobj->OBJ_OPER_EJEC5 = $request->obj_oper_ejec5;
        $nuevoobj->OBJ_OPER_EJEC6 = $request->obj_oper_ejec6;
        $nuevoobj->OBJ_ODS01      = $request->obj_ods01;
        $nuevoobj->OBJ_ODS02      = $request->obj_ods02;
        $nuevoobj->OBJ_ODS03      = $request->obj_ods03;       
        $nuevoobj->OBJ_ODS04      = $request->obj_ods03;
        $nuevoobj->OBJ_ODS05      = $request->obj_ods05;
        $nuevoobj->OBJ_ODS06      = $request->obj_ods06;
        $nuevoobj->OBJ_ODS07      = $request->obj_ods07;
        $nuevoobj->OBJ_ODS08      = $request->obj_ods08;
        $nuevoobj->OBJ_ODS09      = $request->obj_ods09;       
        $nuevoobj->OBJ_ODS10      = $request->obj_ods10;
        $nuevoobj->OBJ_ODS11      = $request->obj_ods11;
        $nuevoobj->OBJ_ODS12      = $request->obj_ods12;        
        $nuevoobj->OBJ_ODS13      = $request->obj_ods13;
        $nuevoobj->OBJ_ODS14      = $request->obj_ods13;
        $nuevoobj->OBJ_ODS15      = $request->obj_ods15;       
        $nuevoobj->OBJ_ODS16      = $request->obj_ods16;
        $nuevoobj->OBJ_ODS17      = $request->obj_ods17;
        $nuevoobj->OBJ_PDEM01     = $request->obj_pdem01;        
        $nuevoobj->OBJ_PDEM02     = $request->obj_pdem02;                
        $nuevoobj->OBJ_PDEM03     = $request->obj_pdem03;        
        $nuevoobj->OBJ_PDEM04     = $request->obj_pdem04;        
        $nuevoobj->OBJ_PDEM05     = $request->obj_pdem05;        
        $nuevoobj->OBJ_PDEM06     = $request->obj_pdem06;        
        $nuevoobj->OBJ_PDEM07     = $request->obj_pdem07;  

        $nuevoobj->PERIODO_ID1    = $request->periodo_id1;        
        $nuevoobj->MES_ID1        = $request->mes_id1;
        $nuevoobj->DIA_ID1        = $request->dia_id1;

        $nuevoobj->IP           = $ip;
        $nuevoobj->LOGIN        = $nombre;         // Usuario ;
        $nuevoobj->save();

        if($nuevoobj->save() == true){
            toastr()->success('Objetivo del programa registrado.',' ok!',['positionClass' => 'toast-bottom-right']);


            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =       155;    //Registro de aportaciones monetarias
            $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 
                           'FUNCION_ID', 'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 
                           'IP_M', 'LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id,'PROGRAMA_ID' => $xprograma_id,'MES_ID' => $xmes_id,
                                    'PROCESO_ID' => $xproceso_id,'FUNCION_ID'  => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                    'FOLIO'      => $request->prog_id])
                           ->get();
            if($regbitacora->count() <= 0){              // Alta
                $nuevoregBitacora = new regBitacoraModel();              
                $nuevoregBitacora->PERIODO_ID = $xperiodo_id;    // Año de transaccion 
                $nuevoregBitacora->PROGRAMA_ID= $xprograma_id;   // Proyecto JAPEM 
                $nuevoregBitacora->MES_ID     = $xmes_id;        // Mes de transaccion
                $nuevoregBitacora->PROCESO_ID = $xproceso_id;    // Proceso de apoyo
                $nuevoregBitacora->FUNCION_ID = $xfuncion_id;    // Funcion del modelado de procesos 
                $nuevoregBitacora->TRX_ID     = $xtrx_id;        // Actividad del modelado de procesos
                $nuevoregBitacora->FOLIO      = $request->prog_id;     // Folio    
                $nuevoregBitacora->NO_VECES   = 1;               // Numero de veces            
                $nuevoregBitacora->IP         = $ip;             // IP
                $nuevoregBitacora->LOGIN      = $nombre;         // Usuario 
                $nuevoregBitacora->save();
                if($nuevoregBitacora->save() == true)
                    toastr()->success('Trx de Objetivo de programa registrado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error inesperado en trx de objetivo de programa. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id,'PROGRAMA_ID' => $xprograma_id,
                             'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 
                             'TRX_ID' => $xtrx_id, 'FOLIO'      => $request->prog_id])
                             ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id,'PROGRAMA_ID' => $xprograma_id,'MES_ID' => $xmes_id,
                                        'PROCESO_ID' => $xproceso_id,'FUNCION_ID'  => $xfuncion_id,
                                        'TRX_ID'     => $xtrx_id,    'FOLIO'       => $request->prog_id])
                               ->update([
                                         'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'     => $regbitacora->IP       = $ip,
                                         'LOGIN_M'  => $regbitacora->LOGIN_M  = $nombre,
                                         'FECHA_M'  => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('Trx de objetivo de programa actualizada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/             
        }else{
            toastr()->error('Error inesperado en trx de objetivo de programa. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
        }
        return redirect()->route('verobjprog');
    }

    
    /****************** Editar registro de aportación monetaria **********/
    public function actionEditarObjprog($id, $id2){
        $nombre     = session()->get('userlog');
        $pass       = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario    = session()->get('usuario');
        $rango      = session()->get('rango'); 
        $arbol_id   = session()->get('arbol_id');                        

        $regmeses   = regMesesModel::select('MES_ID','MES_DESC')
                      ->get();   
        $regdias    = regDiasModel::select('DIA_ID','DIA_DESC')
                      ->orderBy('DIA_ID','asc')
                      ->get();   
        $regperiodos= regPeriodosModel::select('PERIODO_ID','PERIODO_DESC')
                      ->orderBy('PERIODO_ID','asc')
                      ->get();          
        if(session()->get('rango') !== '0'){     
            $regprograma= regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->where('PROG_ID',$id2)         
                          ->get();          
            $regobjprog = regObjprogModel::select('PERIODO_ID','PROG_ID','OBJ_PROG','OBJ_META',
                          'OBJ_UNI_ATEN','OBJ_COBERTURA','OBJ_REQ_CRITER','OBJ_DOCTOS','OBJ_CRIT_PRIORI',        
                          'OBJ_ZONA_ATEN','OBJ_SECTORES_APOYA',
                          'OBJ_OPER_EJEC1','OBJ_OPER_EJEC2','OBJ_OPER_EJEC3','OBJ_OPER_EJEC4','OBJ_OPER_EJEC5',
                          'OBJ_OPER_EJEC6','OBJ_ODS01','OBJ_ODS02','OBJ_ODS03','OBJ_ODS04','OBJ_ODS05','OBJ_ODS06',
                          'OBJ_ODS07','OBJ_ODS08','OBJ_ODS09','OBJ_ODS10','OBJ_ODS11','OBJ_ODS12','OBJ_ODS13','OBJ_ODS14',
                          'OBJ_ODS15','OBJ_ODS16','OBJ_ODS17',
                          'OBJ_PDEM01','OBJ_PDEM02','OBJ_PDEM03','OBJ_PDEM04','OBJ_PDEM05','OBJ_PDEM06','OBJ_PDEM07',
                          'OBJ_SEC_01','OBJ_SEC_02','OBJ_SEC_03','OBJ_SEC_04','OBJ_SEC_05',
                          'OBJ_SEC_06','OBJ_SEC_07','OBJ_SEC_08','OBJ_SEC_09','OBJ_SEC_10',
                          'OBJ_SEC_11','OBJ_SEC_12','OBJ_SEC_13','OBJ_SEC_14','OBJ_SEC_15',
                          'OBJ_SEC_16','OBJ_SEC_17','OBJ_SEC_18','OBJ_SEC_19','OBJ_SEC_20',
                          'OBJ_SEC_21','OBJ_SEC_22','PERIODO_ID1','MES_ID1','DIA_ID1',                          
                          'OBJ_OBS1','OBJ_OBS2','OBJ_ARC1','OBJ_ARC2','OBJ_STATUS1','OBJ_STATUS2',
                          'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                          ->where('PERIODO_ID',$id)   
                          ->where('PROG_ID'   ,$id2)         
                          ->first();
        }else{
            $regprograma= regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->where('PROG_ID',$id2)         
                          ->get();                    
            $regobjprog = regObjprogModel::select('PERIODO_ID','PROG_ID','OBJ_PROG','OBJ_META',
                          'OBJ_UNI_ATEN','OBJ_COBERTURA','OBJ_REQ_CRITER','OBJ_DOCTOS','OBJ_CRIT_PRIORI',        
                          'OBJ_ZONA_ATEN','OBJ_SECTORES_APOYA',
                          'OBJ_OPER_EJEC1','OBJ_OPER_EJEC2','OBJ_OPER_EJEC3','OBJ_OPER_EJEC4','OBJ_OPER_EJEC5',
                          'OBJ_OPER_EJEC6','OBJ_ODS01','OBJ_ODS02','OBJ_ODS03','OBJ_ODS04','OBJ_ODS05','OBJ_ODS06',
                          'OBJ_ODS07','OBJ_ODS08','OBJ_ODS09','OBJ_ODS10','OBJ_ODS11','OBJ_ODS12','OBJ_ODS13','OBJ_ODS14',
                          'OBJ_ODS15','OBJ_ODS16','OBJ_ODS17',
                          'OBJ_PDEM01','OBJ_PDEM02','OBJ_PDEM03','OBJ_PDEM04','OBJ_PDEM05','OBJ_PDEM06','OBJ_PDEM07',
                          'OBJ_SEC_01','OBJ_SEC_02','OBJ_SEC_03','OBJ_SEC_04','OBJ_SEC_05',
                          'OBJ_SEC_06','OBJ_SEC_07','OBJ_SEC_08','OBJ_SEC_09','OBJ_SEC_10',
                          'OBJ_SEC_11','OBJ_SEC_12','OBJ_SEC_13','OBJ_SEC_14','OBJ_SEC_15',
                          'OBJ_SEC_16','OBJ_SEC_17','OBJ_SEC_18','OBJ_SEC_19','OBJ_SEC_20',
                          'OBJ_SEC_21','OBJ_SEC_22','PERIODO_ID1','MES_ID1','DIA_ID1',                          
                          'OBJ_OBS1','OBJ_OBS2','OBJ_ARC1','OBJ_ARC2','OBJ_STATUS1','OBJ_STATUS2',
                          'FEC_REG','FEC_REG2','IP','LOGIN','FECHA_M','FECHA_M2','IP_M','LOGIN_M')
                          ->where('PERIODO_ID',$id)   
                          ->where('PROG_ID'   ,$id2)         
                          ->first();
        }          
        if($regobjprog->count() <= 0){
            toastr()->error('No existen registros.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.programa.editarObjprog',compact('nombre','usuario','codigo','regperiodos','regmeses','regdias','regprograma','regobjprog'));
    }

    public function actionActualizarObjprog(objprogRequest $request, $id, $id2){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario       = session()->get('usuario');
        $rango         = session()->get('rango');
        $ip            = session()->get('ip');

        $regobjprog = regObjprogModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2]);
        if($regobjprog->count() <= 0)
            toastr()->error('No existe objetivo-programa.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{  
            //********, ***2********* actualizar *****************************/      
            $ymes_id      = (int)date('m');
            $ydia_id      = (int)date('d');
            $mes = regMesesModel::ObtMes($ymes_id);
            $dia = regDiasModel::ObtDia($ydia_id);

            $regobjprog=regObjprogModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2])
                        ->update([                
                                  'OBJ_PROG'          => substr(trim(strtoupper($request->obj_prog))          ,0,3999),
                                  'OBJ_META'          => substr(trim(strtoupper($request->obj_meta))          ,0,3999),                                  
                                  'OBJ_UNI_ATEN'      => substr(trim(strtoupper($request->obj_uni_aten))      ,0,3999),
                                  'OBJ_COBERTURA'     => substr(trim(strtoupper($request->obj_cobertura))     ,0,3999),
                                  'OBJ_REQ_CRITER'    => substr(trim(strtoupper($request->obj_req_criter))    ,0,3999),
                                  'OBJ_DOCTOS'        => substr(trim(strtoupper($request->obj_doctos))        ,0,3999),
                                  'OBJ_CRIT_PRIORI'   => substr(trim(strtoupper($request->obj_crit_priori))   ,0,3999),                                                                                                                                        
                                   
                                  'OBJ_ZONA_ATEN'     => substr(trim(strtoupper($request->obj_zona_aten))     ,0,3999),
                                  'OBJ_SECTORES_APOYA'=> substr(trim(strtoupper($request->obj_sectores_apoya)),0,3999),                          
                                  'OBJ_OPER_EJEC1'    => $request->obj_oper_ejec1,                
                                  'OBJ_OPER_EJEC2'    => $request->obj_oper_ejec2,                  
                                  'OBJ_OPER_EJEC3'    => $request->obj_oper_ejec3,
                                  'OBJ_OPER_EJEC4'    => $request->obj_oper_ejec4,                
                                  'OBJ_OPER_EJEC5'    => $request->obj_oper_ejec5,
                                  'OBJ_OPER_EJEC6'    => $request->obj_oper_ejec6,

                                  'OBJ_SEC_01'        => $request->obj_sec_01,
                                  'OBJ_SEC_02'        => $request->obj_sec_02,
                                  'OBJ_SEC_03'        => $request->obj_sec_03,
                                  'OBJ_SEC_04'        => $request->obj_sec_04,
                                  'OBJ_SEC_05'        => $request->obj_sec_05,
                                  'OBJ_SEC_06'        => $request->obj_sec_06,
                                  'OBJ_SEC_07'        => $request->obj_sec_07,
                                  'OBJ_SEC_08'        => $request->obj_sec_08,
                                  'OBJ_SEC_09'        => $request->obj_sec_09,
                                  'OBJ_SEC_10'        => $request->obj_sec_10,
                                  'OBJ_SEC_11'        => $request->obj_sec_11,
                                  'OBJ_SEC_12'        => $request->obj_sec_12,
                                  'OBJ_SEC_13'        => $request->obj_sec_13,
                                  'OBJ_SEC_14'        => $request->obj_sec_14,
                                  'OBJ_SEC_15'        => $request->obj_sec_15,
                                  'OBJ_SEC_16'        => $request->obj_sec_16,
                                  'OBJ_SEC_17'        => $request->obj_sec_17,
                                  'OBJ_SEC_18'        => $request->obj_sec_18,
                                  'OBJ_SEC_19'        => $request->obj_sec_19,
                                  'OBJ_SEC_20'        => $request->obj_sec_20,
                                  'OBJ_SEC_21'        => $request->obj_sec_21,
                                  'OBJ_SEC_22'        => $request->obj_sec_22,  

                                  'OBJ_ODS01'         => $request->obj_ods01,
                                  'OBJ_ODS02'         => $request->obj_ods02,
                                  'OBJ_ODS03'         => $request->obj_ods03,
                                  'OBJ_ODS04'         => $request->obj_ods04,
                                  'OBJ_ODS05'         => $request->obj_ods05,
                                  'OBJ_ODS06'         => $request->obj_ods06,
                                  'OBJ_ODS07'         => $request->obj_ods07,
                                  'OBJ_ODS08'         => $request->obj_ods08,
                                  'OBJ_ODS09'         => $request->obj_ods09,
                                  'OBJ_ODS10'         => $request->obj_ods10,
                                  'OBJ_ODS11'         => $request->obj_ods11,
                                  'OBJ_ODS12'         => $request->obj_ods12,
                                  'OBJ_ODS13'         => $request->obj_ods13,
                                  'OBJ_ODS14'         => $request->obj_ods14,
                                  'OBJ_ODS15'         => $request->obj_ods15,
                                  'OBJ_ODS16'         => $request->obj_ods16,
                                  'OBJ_ODS17'         => $request->obj_ods17,
                                  'OBJ_PDEM01'        => $request->obj_pdem01,               
                                  'OBJ_PDEM02'        => $request->obj_pdem02,   
                                  'OBJ_PDEM03'        => $request->obj_pdem03,   
                                  'OBJ_PDEM04'        => $request->obj_pdem04,   
                                  'OBJ_PDEM05'        => $request->obj_pdem05,   
                                  'OBJ_PDEM06'        => $request->obj_pdem06,   
                                  'OBJ_PDEM07'        => $request->obj_pdem07,   

                                  'PERIODO_ID1'       => $request->periodo_id1,                
                                  'MES_ID1'           => $request->mes_id1,                
                                  'DIA_ID1'           => $request->dia_id1,                                                                                                                      
                                                                                
                                  'IP_M'              => $ip,
                                  'LOGIN_M'           => $nombre,
                                  'FECHA_M2'          => trim($dia[0]->dia_desc.'/'.$mes[0]->mes_mes.'/'.$id),                                   
                                  'FECHA_M'           => date('Y/m/d')    //date('d/m/Y')                                
                                 ]);
            toastr()->success('Trx de objetivo de programa actualizado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =       156;    //Actualizar aportacion monetaria        
            $regbitacora = regBitacoraModel::select('PERIODO_ID','PROGRAMA_ID','MES_ID','PROCESO_ID','FUNCION_ID', 
                                                    'TRX_ID','FOLIO','NO_VECES','FECHA_REG','IP','LOGIN','FECHA_M', 
                                                    'IP_M', 'LOGIN_M')
                           ->where(['PERIODO_ID' => $xperiodo_id,'PROGRAMA_ID' => $xprograma_id,'MES_ID' => $xmes_id,
                                    'PROCESO_ID' => $xproceso_id,'FUNCION_ID'  => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                    'FOLIO'      => $id2])
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
                    toastr()->success('Trx de objetivo de programa registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error inesperado en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id,'PROGRAMA_ID' => $xprograma_id,
                                                      'MES_ID'     => $xmes_id,    'PROCESO_ID'  => $xproceso_id, 
                                                      'FUNCION_ID' => $xfuncion_id,'TRX_ID'      => $xtrx_id, 
                                                      'FOLIO'      => $id2])
                        ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces ***************************** 
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id,'PROGRAMA_ID' => $xprograma_id,'MES_ID' => $xmes_id, 
                                        'PROCESO_ID' => $xproceso_id,'FUNCION_ID'  => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                        'FOLIO'      => $id2])
                               ->update([
                                         'NO_VECES'=> $regbitacora->NO_VECES = $xno_veces,
                                         'IP_M'    => $regbitacora->IP       = $ip,
                                         'LOGIN_M' => $regbitacora->LOGIN_M  = $nombre,
                                         'FECHA_M' => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('Trx de objetivo de programa actualizado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                     
        }       /************ Termina de actualizar ********************************/
        return redirect()->route('verobjprog');
    }


    public function actionBorrarObjprog($id, $id2){
        //dd($request->all());
        $nombre       = session()->get('userlog');
        $pass         = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        }
        $usuario      = session()->get('usuario');
        $rango        = session()->get('rango');
        $ip           = session()->get('ip');

        /************ Cancela movimiento de aportación monetaria **************************************/
        $regobjprog=regObjprogModel::where(['PERIODO_ID' => $id, 'PROG_ID' => $id2 ]);
        if($regobjprog->count() <= 0)
            toastr()->error('No existe objetivo-programa.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            //**************** Elimina aportación *******************/
            $regobjprog->delete();
            toastr()->success('Objetivo-programa eliminado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            //echo 'Ya entre aboorar registro..........';
            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =       157;     // Cancelación de la aportacion monetaria
            $regbitacora = regBitacoraModel::select('PERIODO_ID', 'PROGRAMA_ID', 'MES_ID', 'PROCESO_ID', 
                           'FUNCION_ID', 'TRX_ID', 'FOLIO', 'NO_VECES', 'FECHA_REG', 'IP', 'LOGIN', 'FECHA_M', 
                           'IP_M', 'LOGIN_M')
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
                    toastr()->success('Trx de eliminar objetivo-programa registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error de Trx de eliminar objetivo-programa. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }else{                   
                //*********** Obtine el no. de veces *****************************
                $xno_veces = regBitacoraModel::where(['PERIODO_ID' => $xperiodo_id, 'PROGRAMA_ID' => $xprograma_id, 
                             'MES_ID' => $xmes_id, 'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 
                             'TRX_ID' => $xtrx_id, 'FOLIO' => $id2])
                             ->max('NO_VECES');
                $xno_veces = $xno_veces+1;                        
                //*********** Termina de obtener el no de veces *****************************         
                $regbitacora = regBitacoraModel::select('NO_VECES','IP_M','LOGIN_M','FECHA_M')
                               ->where(['PERIODO_ID' => $xperiodo_id,'PROGRAMA_ID' => $xprograma_id,'MES_ID' => $xmes_id,
                                        'PROCESO_ID' => $xproceso_id, 'FUNCION_ID' => $xfuncion_id, 'TRX_ID' => $xtrx_id, 
                                        'FOLIO'      => $id2])
                               ->update([
                                        'NO_VECES' => $regbitacora->NO_VECES = $xno_veces,
                                        'IP_M'     => $regbitacora->IP       = $ip,
                                        'LOGIN_M'  => $regbitacora->LOGIN_M  = $nombre,
                                        'FECHA_M'  => $regbitacora->FECHA_M  = date('Y/m/d')  //date('d/m/Y')
                                        ]);
                toastr()->success('Trx de eliminar objetivo-programa actualizado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/    
        }       /************ Termina de eliminar aportación monetaria *************/
        return redirect()->route('verobjprog');
    }    


}
