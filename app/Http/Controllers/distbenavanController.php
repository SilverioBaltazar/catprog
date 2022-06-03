<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\distbeneavancesRequest;

use App\regPeriodosModel;
use App\regProgramasModel;
use App\regDistbeneModel;
use App\regBitacoraModel;

// Exportar a excel 
use Maatwebsite\Excel\Facades\Excel;
// Exportar a pdf
use PDF;
//use Options;

class distbenavanController extends Controller
{


    public function actionVerDistbeneavan(){
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
            $regdistbene =regDistbeneModel::join('CP_CAT_PROGRAMAS','CP_CAT_PROGRAMAS.PROG_ID', '=', 
                                                                   'CP_DISTRIB_BENEFICIOS.PROG_ID')
                          ->select('CP_DISTRIB_BENEFICIOS.PERIODO_ID',
                                   'CP_DISTRIB_BENEFICIOS.PROG_ID',
                                   'CP_CAT_PROGRAMAS.PROG_DESC',
                                   'CP_DISTRIB_BENEFICIOS.BENE_META',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M01', 
                                   'CP_DISTRIB_BENEFICIOS.BENE_M02',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M03',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M04',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M05',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M06', 
                                   'CP_DISTRIB_BENEFICIOS.BENE_M07',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M08',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M09',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M10', 
                                   'CP_DISTRIB_BENEFICIOS.BENE_M11',                              
                                   'CP_DISTRIB_BENEFICIOS.BENE_M12',
                                   'CP_DISTRIB_BENEFICIOS.BENE_AVANCE',
                                   'CP_DISTRIB_BENEFICIOS.BENE_A01',
                                   'CP_DISTRIB_BENEFICIOS.BENE_A02',
                                   'CP_DISTRIB_BENEFICIOS.BENE_A03',
                                   'CP_DISTRIB_BENEFICIOS.BENE_A04',
                                   'CP_DISTRIB_BENEFICIOS.BENE_A05',
                                   'CP_DISTRIB_BENEFICIOS.BENE_A06',
                                   'CP_DISTRIB_BENEFICIOS.BENE_A07',
                                   'CP_DISTRIB_BENEFICIOS.BENE_A08',
                                   'CP_DISTRIB_BENEFICIOS.BENE_A09',
                                   'CP_DISTRIB_BENEFICIOS.BENE_A10',
                                   'CP_DISTRIB_BENEFICIOS.BENE_A11',
                                   'CP_DISTRIB_BENEFICIOS.BENE_A12'
                                   )
                          ->orderBy('CP_DISTRIB_BENEFICIOS.PERIODO_ID','DESC')
                          ->orderBy('CP_DISTRIB_BENEFICIOS.PROG_ID'   ,'DESC')
                          ->paginate(50);
        }else{            
            $regdistbene =regDistbeneModel::join('CP_CAT_PROGRAMAS','CP_CAT_PROGRAMAS.PROG_ID', '=', 
                                                                   'CP_DISTRIB_BENEFICIOS.PROG_ID')
                          ->select('CP_DISTRIB_BENEFICIOS.PERIODO_ID',
                                   'CP_DISTRIB_BENEFICIOS.PROG_ID',
                                   'CP_CAT_PROGRAMAS.PROG_DESC',
                                   'CP_DISTRIB_BENEFICIOS.BENE_META',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M01', 
                                   'CP_DISTRIB_BENEFICIOS.BENE_M02',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M03',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M04',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M05',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M06', 
                                   'CP_DISTRIB_BENEFICIOS.BENE_M07',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M08',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M09',
                                   'CP_DISTRIB_BENEFICIOS.BENE_M10', 
                                   'CP_DISTRIB_BENEFICIOS.BENE_M11',                              
                                   'CP_DISTRIB_BENEFICIOS.BENE_M12',
                                   'CP_DISTRIB_BENEFICIOS.BENE_AVANCE',
                                   'CP_DISTRIB_BENEFICIOS.BENE_A01',
                                   'CP_DISTRIB_BENEFICIOS.BENE_A02',
                                   'CP_DISTRIB_BENEFICIOS.BENE_A03',
                                   'CP_DISTRIB_BENEFICIOS.BENE_A04',
                                   'CP_DISTRIB_BENEFICIOS.BENE_A05',
                                   'CP_DISTRIB_BENEFICIOS.BENE_A06',
                                   'CP_DISTRIB_BENEFICIOS.BENE_A07',
                                   'CP_DISTRIB_BENEFICIOS.BENE_A08',
                                   'CP_DISTRIB_BENEFICIOS.BENE_A09',
                                   'CP_DISTRIB_BENEFICIOS.BENE_A10',
                                   'CP_DISTRIB_BENEFICIOS.BENE_A11',
                                   'CP_DISTRIB_BENEFICIOS.BENE_A12'                                   
                                  )
                          ->where(  'CP_DISTRIB_BENEFICIOS.PROG_ID'   ,$codigo)                              
                          ->orderBy('CP_DISTRIB_BENEFICIOS.PERIODO_ID','DESC')
                          ->orderBy('CP_DISTRIB_BENEFICIOS.PROG_ID'   ,'DESC')
                          ->paginate(50);
        }           
        //dd($regDistbene,$regDistbene->count());
        if($regdistbene->count() <= 0){
            toastr()->error('No existen distribución de beneficios','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }          
        return view('sicinar.distrib_beneficios.verDistbeneavan',compact('nombre','usuario','codigo','regprogramas','regdistbene'));
    }

    public function actionEditarDistbeneavan($id, $id2){
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
        $regdistbene  = regDistbeneModel::select('*')
                        ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2])
                        ->first();
        //dd($id,'segundo.....'.$id2, $regDistbene->count() );
        if($regdistbene->count() <= 0){
            toastr()->error('No existe distribución de beneficios.','Lo siento!',['positionClass' => 'toast-bottom-right']);
        }
        return view('sicinar.distrib_beneficios.editarDistbeneavan',compact('nombre','usuario','codigo','regprogramas','regdistbene'));
    }

    public function actionActualizarDistbeneavan(distbeneavancesRequest $request, $id, $id2){
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
        $regDistbene = regDistbeneModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2]);
        //dd('hola.....',$regDistbene);
        if($regDistbene->count() <= 0)
            toastr()->error('No existe distribución de beneficios.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
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

            //*********** Actualizarn items **********************
            $regDistbene = regDistbeneModel::where(['PERIODO_ID' => $id,'PROG_ID' => $id2])
                               ->update([                
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
            toastr()->success('distribución de beneficios actualizado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =       146;    //Actualizar OSC        
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
                    toastr()->success('Trx de actualización de distribución de beneficios registrado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error Trx de distribución de beneficios  actualizado en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
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
                toastr()->success('Trx de actualización de distribución de beneficios registrado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                     
        }       /************ Actualizar *******************************************/
        return redirect()->route('verdistbeneavan');
    }


    public function actionBorrarDistbeneavan($id, $id2){
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
        $regDistbene = $regDistbeneModel::select('PERIODO_ID','PROG_ID','BENE_META','BENE_AVANCE',
                        'BENE_M01','BENE_M02','BENE_M03','BENE_M04','BENE_M05','BENE_M06',
                        'BENE_M07','BENE_M08','BENE_M09','BENE_M10','BENE_M11','BENE_M12',
                        'BENE_MT01','BENE_MT02','BENE_MT03','BENE_MT04','BENE_MS01','BENE_MS02','BENE_MA01',
                        'BENE_A01','BENE_A02','BENE_A03','BENE_A04','BENE_A05','BENE_A06',
                        'BENE_A07','BENE_A08','BENE_A09','BENE_A10','BENE_A11','BENE_A12',
                        'BENE_AT01','BENE_AT02','BENE_AT03','BENE_AT04','BENE_AS01','BENE_AS02','BENE_AA01'
                        )
                         ->where(['PERIODO_ID' => $id,'PROG_ID' => $id2]);
        if($regDistbene->count() <= 0)
            toastr()->error('No existe distribución de beneficios.','¡Por favor volver a intentar!',['positionClass' => 'toast-bottom-right']);
        else{        
            $regDistbene->delete();
            toastr()->success('distribución de beneficios eliminado.','¡Ok!',['positionClass' => 'toast-bottom-right']);

            //echo 'Ya entre a borrar registro..........';
            /************ Bitacora inicia *************************************/ 
            setlocale(LC_TIME, "spanish");        
            $xip          = session()->get('ip');
            $xperiodo_id  = (int)date('Y');
            $xprograma_id = 1;
            $xmes_id      = (int)date('m');
            $xproceso_id  =         3;
            $xfuncion_id  =      3001;
            $xtrx_id      =       147;     // Baja de IAP

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
                    toastr()->success('Trx de baja de distribución de beneficios registrada en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
                else
                    toastr()->error('Error en Trx de baja de distribución de beneficios en bitacora. Por favor volver a interlo.','Ups!',['positionClass' => 'toast-bottom-right']);
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
                toastr()->success('Trx de distribución de beneficios registrado en Bitacora.','¡Ok!',['positionClass' => 'toast-bottom-right']);
            }   /************ Bitacora termina *************************************/                 
        }       /************* Termina de eliminar **********************************/
        return redirect()->route('verdistbeneavan');
    }    


}
