<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\distbenefavancesRequest;

use App\regPeriodosModel;
use App\regProgramasModel;
use App\regDistbenefModel;
use App\regBitacoraModel;

// Exportar a excel 
use Maatwebsite\Excel\Facades\Excel;
// Exportar a pdf
use PDF;
//use Options;

class distbenefavanController extends Controller
{


    public function actionVerDistbenefavan(){
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
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_M12',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_AVANCE',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_A01',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_A02',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_A03',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_A04',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_A05',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_A06',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_A07',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_A08',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_A09',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_A10',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_A11',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_A12'
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
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_M12',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_AVANCE',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_A01',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_A02',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_A03',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_A04',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_A05',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_A06',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_A07',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_A08',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_A09',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_A10',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_A11',
                                   'CP_DISTRIB_BENEFICIARIOS.BENEF_A12'                                   
                                  )
                          ->where(  'CP_DISTRIB_BENEFICIARIOS.PROG_ID'   ,$codigo)                              
                          ->orderBy('CP_DISTRIB_BENEFICIARIOS.PERIODO_ID','DESC')
                          ->orderBy('CP_DISTRIB_BENEFICIARIOS.PROG_ID'   ,'DESC')
                          ->paginate(50);
        }           
        if($regdistbenef->count() <= 0){
            toastr()->error('No existen distribución de beneficiarios','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }          
        return view('sicinar.distrib_beneficiarios.verDistbenefavan',compact('nombre','usuario','codigo','regprogramas','regdistbenef'));
    }

    public function actionEditarDistbenefavan($id, $id2){
        $nombre        = session()->get('userlog');
        $pass          = session()->get('passlog');
        if($nombre == NULL AND $pass == NULL){
            return view('sicinar.login.expirada');
        } 
        $usuario       = session()->get('usuario'); 
        $rango         = session()->get('rango');
        $codigo        = session()->get('codigo');         

        $regprogramas = regProgramasModel::select('PROG_ID','PROG_DESC')
                        ->orderBy('PROG_ID','asc')
                        ->get();                                 
        $regdistbenef = regDistbenefModel::select('*')
                         ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2])
                         ->first();
        //dd($id,'segundo.....'.$id2, $regdistbenef->count() );
        if($regdistbenef->count() <= 0){
            toastr()->error('No existe distribución de beneficiarios.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.distrib_beneficiarios.editarDistbenefavances',compact('nombre','usuario','codigo','regprogramas','regdistbenef'));
    }

    public function actionActualizarDistbenefavan(distbenefavancesRequest $request, $id, $id2){
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
            //************ Obtiene valores metas programados **********//
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

            //*********** Actualizarn items **********************
            $regdistbenef = regDistbenefModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2])
                               ->update([                
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
            $xtrx_id      =        33;    //Actualizar 
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
        return redirect()->route('verdistbenefavan');
    }


    public function actionBorrarDistbenefavan($id, $id2){
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
        $regdistbenef = $regDistbenefModel::select('PERIODO_ID','PROG_ID','BENEF_META','BENEF_AVANCE',
                        'BENEF_M01','BENEF_M02','BENEF_M03','BENEF_M04','BENEF_M05','BENEF_M06',
                        'BENEF_M07','BENEF_M08','BENEF_M09','BENEF_M10','BENEF_M11','BENEF_M12',
                        'BENEF_MT01','BENEF_MT02','BENEF_MT03','BENEF_MT04','BENEF_MS01','BENEF_MS02','BENEF_MA01',
                        'BENEF_A01','BENEF_A02','BENEF_A03','BENEF_A04','BENEF_A05','BENEF_A06',
                        'BENEF_A07','BENEF_A08','BENEF_A09','BENEF_A10','BENEF_A11','BENEF_A12',
                        'BENEF_AT01','BENEF_AT02','BENEF_AT03','BENEF_AT04','BENEF_AS01','BENEF_AS02','BENEF_AA01'
                        )
                         ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2]);
        if($regdistbenef->count() <= 0)
            toastr()->error('No existe Distribución de beneficiarios.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            $regdistbenef->delete();
            toastr()->success('Distribución de beneficiarios eliminado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            //echo 'Ya entre a borrar registro..........';
            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =        34;     // Baja de IAP

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
                    toastr()->success('Trx de baja de Distribución de beneficiarios registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error en Trx de baja de Distribución de beneficiarios en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
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
                toastr()->success('Trx de Distribución de beneficiarios registrado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                 
        }       /************* Termina de eliminar **********************************/
        return redirect()->route('verdistbenefavan');
    }    


}
