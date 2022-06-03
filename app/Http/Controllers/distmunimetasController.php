<?php
//***********************************************************************************************************/
//* File:       distmunimentasController.php
//* Proyecto:   Sistema Catalogo de programas catprog
//¨Función:     Clases para el modulo de distribución anual por municipio
//* Autor:      Ing. Silverio Baltazar Barrientos Zarate
//* Modifico:   Ing. Silverio Baltazar Barrientos Zarate
//* Fecha act.: mayo 2022
//* @Derechos reservados. Gobierno del Estado de México
//************************************************************************************************************/

namespace App\Http\Controllers;
 
use Illuminate\Http\Request;

use App\Http\Requests\distmunimetasRequest;

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

class distmunimetasController extends Controller
{

    public function actionBuscarDistmunimetas(Request $request)
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
                         ->where('ENTIDADFEDERATIVA_ID','=',15)
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
            toastr()->error('No existe Distribución por municipio','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }            
        return view('sicinar.distrib_mun.verDistmunimetas', compact('nombre','usuario','codigo','regprogramas','regmunicipios','regperiodos','regdistmuni'));
    }

    public function actionVerDistmunimetas(){
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
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_META',
                                   'CP_DISTRIB_MUNICIPIOS.BENEF_META',
                                   'CP_DISTRIB_MUNICIPIOS.BENE_META',
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
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_M12'
                                   )
                         ->orderBy('CP_DISTRIB_MUNICIPIOS.PERIODO_ID'  ,'DESC')
                         ->orderBy('CP_DISTRIB_MUNICIPIOS.PROG_ID'     ,'DESC')
                         ->orderBy('CP_DISTRIB_MUNICIPIOS.MUNICIPIO_ID','DESC')                         
                         ->paginate(50);
        }else{           
            $regdistmuni=regDistmunicipioModel::join('CP_CAT_PROGRAMAS','CP_CAT_PROGRAMAS.PROG_ID','=',
                                                                        'CP_DISTRIB_MUNICIPIOS.PROG_ID')
                          ->select('CP_DISTRIB_MUNICIPIOS.PERIODO_ID',
                                   'CP_DISTRIB_MUNICIPIOS.PROG_ID',
                                   'CP_DISTRIB_MUNICIPIOS.MUNICIPIO_ID',
                                   'CP_CAT_PROGRAMAS.PROG_DESC',
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_META',
                                   'CP_DISTRIB_MUNICIPIOS.BENEF_META',
                                   'CP_DISTRIB_MUNICIPIOS.BENE_META',
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
                                   'CP_DISTRIB_MUNICIPIOS.FINAN_M12'
                                   )
                         ->where(  'CP_DISTRIB_MUNICIPIOS.PROG_ID'   ,$codigo)                             
                        ->orderBy( 'CP_DISTRIB_MUNICIPIOS.PERIODO_ID','DESC')
                        ->orderBy( 'CP_DISTRIB_MUNICIPIOS.PROG_ID'   ,'DESC')
                        ->orderBy('CP_DISTRIB_MUNICIPIOS.MUNICIPIO_ID','DESC')    
                        ->paginate(50);          
        }                         
        if($regdistmuni->count() <= 0){
            toastr()->error('No existe Distribución por municipio','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.distrib_mun.verDistmunimetas',compact('nombre','usuario','codigo','regmunicipios','regdistmuni'));
    }

    public function actionNuevoDistmunimetas(){
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
        $regmunicipios= regMunicipiosModel::select('MUNICIPIO_ID','MUNICIPIO')
                        ->where('ENTIDADFEDERATIVA_ID','=',15)
                        ->orderBy('MUNICIPIO','asc')
                        ->get();    
        if(session()->get('rango') !== '0'){                                                                                
            $regprogramas=regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->orderBy('PROG_ID','asc')
                          ->get();                                    
            $regdistmuni =regDistmunicipioModel::select('PERIODO_ID','PROG_ID','MUNICIPIO_ID','FINAN_META',
                          'FINAN_M01','FINAN_M02','FINAN_M03','FINAN_M04','FINAN_M05','FINAN_M06',
                          'FINAN_M07','FINAN_M08','FINAN_M09','FINAN_M10','FINAN_M11','FINAN_M12',
                          'FINAN_MT01','FINAN_MT02','FINAN_MT03','FINAN_MT04','FINAN_MS01','FINAN_MS02','FINAN_MA01',
                          'BENEF_META',
                          'BENEF_M01','BENEF_M02','BENEF_M03','BENEF_M04','BENEF_M05','BENEF_M06',
                          'BENEF_M07','BENEF_M08','BENEF_M09','BENEF_M10','BENEF_M11','BENEF_M12',
                          'BENEF_MT01','BENEF_MT02','BENEF_MT03','BENEF_MT04','BENEF_MS01','BENEF_MS02','BENEF_MA01',
                          'BENE_META',
                          'BENE_M01','BENE_M02','BENE_M03','BENE_M04','BENE_M05','BENE_M06',
                          'BENE_M07','BENE_M08','BENE_M09','BENE_M10','BENE_M11','BENE_M12',
                          'BENE_MT01','BENE_MT02','BENE_MT03','BENE_MT04','BENE_MS01','BENE_MS02','BENE_MA01'
                          )
                          ->orderBy('PERIODO_ID','asc')
                          ->orderBy('PROG_ID'   ,'asc')
                          ->get();
        }else{ 
            $regprogramas=regProgramasModel::select('PROG_ID','PROG_DESC')
                          ->where('PROG_ID',$codigo) 
                          ->get();                                    
            $regdistmuni =regDistmunicipioModel::select('PERIODO_ID','PROG_ID','MUNICIPIO_ID','FINAN_META',
                          'FINAN_M01','FINAN_M02','FINAN_M03','FINAN_M04','FINAN_M05','FINAN_M06',
                          'FINAN_M07','FINAN_M08','FINAN_M09','FINAN_M10','FINAN_M11','FINAN_M12',
                          'FINAN_MT01','FINAN_MT02','FINAN_MT03','FINAN_MT04','FINAN_MS01','FINAN_MS02','FINAN_MA01',
                          'BENEF_META',
                          'BENEF_M01','BENEF_M02','BENEF_M03','BENEF_M04','BENEF_M05','BENEF_M06',
                          'BENEF_M07','BENEF_M08','BENEF_M09','BENEF_M10','BENEF_M11','BENEF_M12',
                          'BENEF_MT01','BENEF_MT02','BENEF_MT03','BENEF_MT04','BENEF_MS01','BENEF_MS02','BENEF_MA01',
                          'BENE_META',
                          'BENE_M01','BENE_M02','BENE_M03','BENE_M04','BENE_M05','BENE_M06',
                          'BENE_M07','BENE_M08','BENE_M09','BENE_M10','BENE_M11','BENE_M12',
                          'BENE_MT01','BENE_MT02','BENE_MT03','BENE_MT04','BENE_MS01','BENE_MS02','BENE_MA01'
                          )
                          ->where(  'PROG_ID'   ,$codigo) 
                          ->orderBy('PERIODO_ID','asc')
                          ->orderBy('PROG_ID'   ,'asc')
                          ->get();            
        }
        return view('sicinar.distrib_mun.nuevoDistmunimetas',compact('nombre','usuario','codigo','regprogramas','regmunicipios','regperiodos','regdistmuni'));
    }

    public function actionAltaNuevoDistmunimetas(Request $request){
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
        $regdistmuni = regDistmunicipioModel::where(['PERIODO_ID'  => $request->periodo_id,
                                                     'PROG_ID'     => $request->prog_id,
                                                     'MUNICIPIO_ID'=> $request->municipio_id]);
        if($regdistmuni->count() > 0)
            toastr()->error('Ya existe Distribución por municipio.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
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
            /*********************** Beneficiarios *********************/
            /***********************************************************/            
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

            /*********************** Beneficios ************************/
            /***********************************************************/
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
            //$iid = $regdistmunicipioModel::count(*);
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
            $nuevaiap->MUNICIPIO_ID    = $request->municipio_id;
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
                toastr()->success('Distribución por municipio dada de alta.','ok!',['positionClass' => 'toast-bottom-right']);

                /************ Bitacora inicia *************************************/ 
                setlocale(LC_TIME, "spanish");        
                $xip          = session()->get('ip');
                $xperiodo_id  = (int)date('Y');
                $xprograma_id = 1;
                $xmes_id      = (int)date('m');
                $xproceso_id  =         3;
                $xfuncion_id  =      3001;
                $xtrx_id      =        47;    //Alta
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
                        toastr()->success('Trx de Distribución por municipio dada de alta en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                    else
                        toastr()->error('Error de trx de Distribución por municipio en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
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
                    toastr()->success('Trx de Distribución por municipio actualizado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                }   /************ Bitacora termina *************************************/ 
            }else{
                toastr()->error('Error de trx de Distribución por municipio. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
            }
        }
        return redirect()->route('verdistmunimetas');
    }

    public function actionEditarDistmunimetas($id, $id2, $id3){
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
        $regmunicipios= regMunicipiosModel::select('MUNICIPIO_ID','MUNICIPIO')
                        ->where('ENTIDADFEDERATIVA_ID','=',15)
                        ->orderBy('MUNICIPIO','asc')
                        ->get();    
        $regprogramas = regProgramasModel::select('PROG_ID','PROG_DESC')
                        ->orderBy('PROG_ID','asc')
                        ->get();                                 
        $regdistmuni  = regDistmunicipioModel::select('PERIODO_ID','PROG_ID','MUNICIPIO_ID','FINAN_META',
                        'FINAN_M01','FINAN_M02','FINAN_M03','FINAN_M04','FINAN_M05','FINAN_M06',
                        'FINAN_M07','FINAN_M08','FINAN_M09','FINAN_M10','FINAN_M11','FINAN_M12',
                        'FINAN_MT01','FINAN_MT02','FINAN_MT03','FINAN_MT04','FINAN_MS01','FINAN_MS02','FINAN_MA01',
                        'BENEF_META',
                        'BENEF_M01','BENEF_M02','BENEF_M03','BENEF_M04','BENEF_M05','BENEF_M06',
                        'BENEF_M07','BENEF_M08','BENEF_M09','BENEF_M10','BENEF_M11','BENEF_M12',
                        'BENEF_MT01','BENEF_MT02','BENEF_MT03','BENEF_MT04','BENEF_MS01','BENEF_MS02','BENEF_MA01',
                        'BENE_META',
                        'BENE_M01','BENE_M02','BENE_M03','BENE_M04','BENE_M05','BENE_M06',
                        'BENE_M07','BENE_M08','BENE_M09','BENE_M10','BENE_M11','BENE_M12',
                        'BENE_MT01','BENE_MT02','BENE_MT03','BENE_MT04','BENE_MS01','BENE_MS02','BENE_MA01'
                        )
                        ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'MUNICIPIO_ID' => $id3])
                        ->first();
        //dd($id,'segundo.....'.$id2, $regdistmuni->count() );
        if($regdistmuni->count() <= 0){
            toastr()->error('No existe Distribución por municipio.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.distrib_mun.editarDistmunimetas',compact('nombre','usuario','codigo','regprogramas','regmunicipios','regperiodos','regdistmuni'));
    }

    public function actionActualizarDistmunimetas(distmunimetasRequest $request, $id, $id2, $id3){
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
        //dd('hola.....',$id, $id2, $id3,$regdistmuni);
        if($regdistmuni->count() <= 0)
            toastr()->error('No existe Distribución por municipio.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
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
            //*********** Beneficviarios *************************/
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

            //*********** Beneficios *****************************/        
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

            //*********** Actualizarn items **********************/
            $regdistmuni = regDistmunicipioModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'MUNICIPIO_ID' => $id3])
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
            toastr()->success('Distribución por municipio actualizado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =        48;    //Actualizar 
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
                    toastr()->success('Trx de actualización de Distribución por municipio registrado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error Trx de fuentes de Distribución por municipio actualizado en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
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
                toastr()->success('Trx de actualización de Distribución por municipio registrado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                     
        }       /************ Actualizar *******************************************/
        return redirect()->route('verdistmunimetas');
    }

    public function actionBorrarDistmunimetas($id, $id2, $id3){
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
        $regdistmuni  = regDistmunicipioModel::select('*')
                        ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2,'MUNICIPIO_ID' => $id3]);
        if($regdistmuni->count() <= 0)
            toastr()->error('No existe Distribución por municipio.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            $regdistmuni->delete();
            toastr()->success('Distribución por municipio eliminado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            //echo 'Ya entre a borrar registro..........';
            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =        49;     // Baja 

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
                    toastr()->success('Trx de baja de Distribución por municipio registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error en Trx de baja de Distribución por municipio en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
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
                toastr()->success('Trx de Distribución por municipio registrado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                 
        }       /************* Termina de eliminar **********************************/
        return redirect()->route('verdistmunimetas');
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
        $xtrx_id      =        50;            // Exportar a formato Excel
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
        $xtrx_id      =        51;       //Exportar a formato PDF
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
