@extends('sicinar.principal')

@section('title','Editar distribución por municipio avances')

@section('links')
    <link rel="stylesheet" href="{{ asset('bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endsection

@section('nombre')
    {{$nombre}}
@endsection

@section('usuario')
    {{$usuario}}
@endsection

@section('content')
    <!DOCTYPE html>
    <html lang="es">
    <div class="content-wrapper">
        <section class="content-header">
            <!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
            <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
            <h1><i class="fa fa-dashboard"></i>&nbsp;&nbsp;Menú.
                <small>Ficha del programa -</small> 
                <small>9.1 Dist. municipio avances -</small> 
                <small> Editar </small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b9.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp;Distribución por municipio avances </li> 
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <p align="justify"><b style="color:red;">
                            Instrucciones:</b> <b style="color:green;"> 
                            Requisitar la distribución anual por municipio de: Financiamiento, beneficiarios y beneficios (avances) del programa y/o acción.
                            Este apartado se deberá de requisitar periodicamente de forma anual; esto es cada ejercio fiscal.
                            </b>
                        </p>       
                        {!! Form::open(['route' => ['actualizardistmuniavan',$regdistmuni->periodo_id,$regdistmuni->prog_id,$regdistmuni->municipio_id], 'method' => 'PUT', 'id' => 'actualizardistmuniavan', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">

                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <input type="hidden" id="periodo_id"   name="periodo_id"   value="{{$regdistmuni->periodo_id}}">  
                                    <input type="hidden" id="prog_id"      name="prog_id"      value="{{$regdistmuni->prog_id}}">   
                                    <input type="hidden" id="municipio_id" name="municipio_id" value="{{$regdistmuni->municipio_id}}">   
                                    <input type="hidden" id="benef_meta"   name="benef_meta"  value="{{$regdistmuni->bene_meta}}">   
                                    <input type="hidden" id="benef_m01"    name="benef_m01"   value="{{$regdistmuni->bene_m01}}">   
                                    <input type="hidden" id="benef_m02"    name="benef_m02"   value="{{$regdistmuni->bene_m02}}">   
                                    <input type="hidden" id="benef_m03"    name="benef_m03"   value="{{$regdistmuni->bene_m03}}">   
                                    <input type="hidden" id="benef_m04"    name="benef_m04"   value="{{$regdistmuni->bene_m04}}">   
                                    <input type="hidden" id="benef_m05"    name="benef_m05"   value="{{$regdistmuni->bene_m05}}">   
                                    <input type="hidden" id="benef_m06"    name="benef_m06"   value="{{$regdistmuni->bene_m06}}">   
                                    <input type="hidden" id="benef_m07"    name="benef_m07"   value="{{$regdistmuni->bene_m07}}">   
                                    <input type="hidden" id="benef_m08"    name="benef_m08"   value="{{$regdistmuni->bene_m08}}">   
                                    <input type="hidden" id="benef_m09"    name="benef_m09"   value="{{$regdistmuni->bene_m09}}">   
                                    <input type="hidden" id="benef_m10"    name="benef_m10"   value="{{$regdistmuni->bene_m10}}">   
                                    <input type="hidden" id="benef_m11"    name="benef_m011"  value="{{$regdistmuni->bene_m11}}">   
                                    <input type="hidden" id="benef_m12"    name="benef_m012"  value="{{$regdistmuni->bene_m12}}">

                                    <input type="hidden" id="bene_meta"    name="bene_meta"   value="{{$regdistmuni->bene_meta}}">   
                                    <input type="hidden" id="bene_m01"     name="bene_m01"    value="{{$regdistmuni->bene_m01}}">   
                                    <input type="hidden" id="bene_m02"     name="bene_m02"    value="{{$regdistmuni->bene_m02}}">   
                                    <input type="hidden" id="bene_m03"     name="bene_m03"    value="{{$regdistmuni->bene_m03}}">   
                                    <input type="hidden" id="bene_m04"     name="bene_m04"    value="{{$regdistmuni->bene_m04}}">   
                                    <input type="hidden" id="bene_m05"     name="bene_m05"    value="{{$regdistmuni->bene_m05}}">   
                                    <input type="hidden" id="bene_m06"     name="bene_m06"    value="{{$regdistmuni->bene_m06}}">   
                                    <input type="hidden" id="bene_m07"     name="bene_m07"    value="{{$regdistmuni->bene_m07}}">   
                                    <input type="hidden" id="bene_m08"     name="bene_m08"    value="{{$regdistmuni->bene_m08}}">   
                                    <input type="hidden" id="bene_m09"     name="bene_m09"    value="{{$regdistmuni->bene_m09}}">   
                                    <input type="hidden" id="bene_m10"     name="bene_m10"    value="{{$regdistmuni->bene_m10}}">   
                                    <input type="hidden" id="bene_m11"     name="bene_m011"   value="{{$regdistmuni->bene_m11}}">   
                                    <input type="hidden" id="bene_m12"     name="bene_m012"   value="{{$regdistmuni->bene_m12}}">

                                    <input type="hidden" id="finan_meta"   name="finan_meta"  value="{{$regdistmuni->finan_meta}}">   
                                    <input type="hidden" id="finan_m01"    name="finan_m01"   value="{{$regdistmuni->finan_m01}}">   
                                    <input type="hidden" id="finan_m02"    name="finan_m02"   value="{{$regdistmuni->finan_m02}}">   
                                    <input type="hidden" id="finan_m03"    name="finan_m03"   value="{{$regdistmuni->finan_m03}}">   
                                    <input type="hidden" id="finan_m04"    name="finan_m04"   value="{{$regdistmuni->finan_m04}}">   
                                    <input type="hidden" id="finan_m05"    name="finan_m05"   value="{{$regdistmuni->finan_m05}}">   
                                    <input type="hidden" id="finan_m06"    name="finan_m06"   value="{{$regdistmuni->finan_m06}}">   
                                    <input type="hidden" id="finan_m07"    name="finan_m07"   value="{{$regdistmuni->finan_m07}}">   
                                    <input type="hidden" id="finan_m08"    name="finan_m08"   value="{{$regdistmuni->finan_m08}}">   
                                    <input type="hidden" id="finan_m09"    name="finan_m09"   value="{{$regdistmuni->finan_m09}}">   
                                    <input type="hidden" id="finan_m10"    name="finan_m10"   value="{{$regdistmuni->finan_m10}}">   
                                    <input type="hidden" id="finan_m11"    name="finan_m011"  value="{{$regdistmuni->finan_m11}}">   
                                    <input type="hidden" id="finan_m12"    name="finan_m012"  value="{{$regdistmuni->finan_m12}}">                                                                           
                          
                                    <label style="color:green;">Periodo: </label>
                                    &nbsp;&nbsp;{{$regdistmuni->periodo_id}} 
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                                    
                                    <label style="color:green;">Programa y/o acción: </label>
                                        &nbsp;&nbsp;{{$regdistmuni->prog_id}}
                                        @foreach($regprogramas as $program)
                                                @if($program->prog_id == $regdistmuni->prog_id)
                                                    {{Trim($program->prog_desc)}}
                                                    @break
                                                @endif
                                        @endforeach   
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                                    
                                    <label style="color:green;">Municipio: </label>
                                        &nbsp;&nbsp;{{$regdistmuni->municipio_id}}
                                        @foreach($regmunicipios as $muni)
                                                @if($muni->municipio_id == $regdistmuni->municipio_id)
                                                    {{Trim($muni->municipio)}}
                                                    @break
                                                @endif
                                        @endforeach                                         

                                </div>   
                            </div>
             
                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label><b style="background-color:orange;color:white;text-align:center;"> Presupuesto </b>
                                    &nbsp;&nbsp;
                                    <b style="color:green;">$ Meta total: </b>
                                    </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->finan_meta,2)}}
                                </div>
                            </div>                            

                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">$ ene: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->finan_m01,2)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">$ feb: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->finan_m02,2)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">$ mar:  </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->finan_m03,2)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">$ abr: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->finan_m04,2)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">$ may: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->finan_m05,2)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">$ jun: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->finan_m06,2)}}
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">$ jul: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->finan_m07,2)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">$ ago: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->finan_m08,2)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">$ sep: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->finan_m09,2)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">$ oct: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->finan_m10,2)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">$ nov: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->finan_m11,2)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">$ dic: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->finan_m12,2)}}
                                </div>
                            </div> 

                            <div class="row">     
                                <div class="col-xs-3 form-group">
                                    <label><b style="background-color:orange;color:white;text-align:center;"> Presupuesto </b>
                                    &nbsp;&nbsp;
                                    <b>$ Avance total: </b>
                                    </label>
                                    <input required autocomplete="off" id="finan_avance" name="finan_avance" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ total de avance" value="{{$regdistmuni->finan_avance}}" required>
                                </div>
                            </div>                            

                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>$ ene </label>
                                    <input required autocomplete="off" id="finan_a01" name="finan_a01" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ enero avance" value="{{$regdistmuni->finan_a01}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ feb </label>
                                    <input required autocomplete="off" id="finan_a02" name="finan_a02" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ febrero avance" value="{{$regdistmuni->finan_a02}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ mar  </label>
                                    <input required autocomplete="off" id="finan_a03" name="finan_a03" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ marzo avance" value="{{$regdistmuni->finan_a03}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ abr </label>
                                    <input required autocomplete="off" id="finan_a04" name="finan_a04" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ abril avance" value="{{$regdistmuni->finan_a04}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ may </label>
                                    <input required autocomplete="off" id="finan_a05" name="finan_a05" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ mayo avance" value="{{$regdistmuni->finan_a05}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ jun </label>
                                    <input required autocomplete="off" id="finan_a06" name="finan_a06" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ junio avance" value="{{$regdistmuni->finan_a06}}" required>
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>$ jul </label>
                                    <input required autocomplete="off" id="finan_a07" name="finan_a07" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ julio avance" value="{{$regdistmuni->finan_a07}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ ago </label>
                                    <input required autocomplete="off" id="finan_a08" name="finan_a08" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ agosto avance" value="{{$regdistmuni->finan_a08}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ sep </label>
                                    <input required autocomplete="off" id="finan_a09" name="finan_a09" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ septiembre avance" value="{{$regdistmuni->finan_a09}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ oct </label>
                                    <input required autocomplete="off" id="finan_a10" name="finan_a10" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ octubre avance" value="{{$regdistmuni->finan_a10}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ nov </label>
                                    <input required autocomplete="off" id="finan_a11" name="finan_a11" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ noviembre avance" value="{{$regdistmuni->finan_a11}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ dic </label>
                                    <input required autocomplete="off" id="finan_a12" name="finan_a12" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ diciembre avance" value="{{$regdistmuni->finan_a12}}" required>
                                </div>
                            </div> 
 

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label><b style="background-color:orange;color:white;text-align:center;"> Beneficiarios </b>
                                    &nbsp;&nbsp;
                                    <b style="color:green;">Meta total: </b>
                                    </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->benef_meta,0)}}
                                </div>
                            </div>                            
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">ene: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->benef_m01,0)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">feb: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->benef_m02,0)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">mar:  </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->benef_m03,0)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">abr: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->benef_m04,0)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">may: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->benef_m05,0)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">jun: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->benef_m06,0)}}
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">jul: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->benef_m07,0)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">ago: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->benef_m08,0)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">sep: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->benef_m09,0)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">oct: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->benef_m10,0)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">nov: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->benef_m11,0)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">dic: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->benef_m12,0)}}
                                </div>
                            </div> 

                            <div class="row">     
                                <div class="col-xs-3 form-group">
                                    <label><b style="background-color:orange;color:white;text-align:center;"> Beneficiarios </b>
                                    &nbsp;&nbsp;
                                    <b>Avance total: </b>
                                    </label>
                                    <input required autocomplete="off" id="benef_avance" name="benef_avance" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="total de avance" value="{{$regdistmuni->benef_avance}}" required>
                                </div>
                            </div>                            

                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>ene </label>
                                    <input required autocomplete="off" id="benef_a01" name="benef_a01" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="enero avance" value="{{$regdistmuni->benef_a01}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>feb </label>
                                    <input required autocomplete="off" id="benef_a02" name="benef_a02" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="febrero avance" value="{{$regdistmuni->benef_a02}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>mar  </label>
                                    <input required autocomplete="off" id="benef_a03" name="benef_a03" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="marzo avance" value="{{$regdistmuni->benef_a03}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>abr </label>
                                    <input required autocomplete="off" id="benef_a04" name="benef_a04" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="abril avance" value="{{$regdistmuni->benef_a04}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>may </label>
                                    <input required autocomplete="off" id="benef_a05" name="benef_a05" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="mayo avance" value="{{$regdistmuni->benef_a05}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>jun </label>
                                    <input required autocomplete="off" id="benef_a06" name="benef_a06" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="junio avance" value="{{$regdistmuni->benef_a06}}" required>
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>jul </label>
                                    <input required autocomplete="off" id="benef_a07" name="benef_a07" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="julio avance" value="{{$regdistmuni->benef_a07}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>ago </label>
                                    <input required autocomplete="off" id="benef_a08" name="benef_a08" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="agosto avance" value="{{$regdistmuni->benef_a08}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>sep </label>
                                    <input required autocomplete="off" id="benef_a09" name="benef_a09" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="septiembre avance" value="{{$regdistmuni->benef_a09}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>oct </label>
                                    <input required autocomplete="off" id="benef_a10" name="benef_a10" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="octubre avance" value="{{$regdistmuni->benef_a10}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>nov </label>
                                    <input required autocomplete="off" id="benef_a11" name="benef_a11" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="noviembre avance" value="{{$regdistmuni->benef_a11}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>dic </label>
                                    <input required autocomplete="off" id="benef_a12" name="benef_a12" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="diciembre avance" value="{{$regdistmuni->benef_a12}}" required>
                                </div>
                            </div> 


                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label><b style="background-color:orange;color:white;text-align:center;"> Beneficios </b>
                                    &nbsp;&nbsp;
                                    <b style="color:green;">Meta total: </b>
                                    </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->bene_meta,0)}}
                                </div>
                            </div>                 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">ene: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->bene_m01,0)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">feb: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->bene_m02,0)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">mar:  </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->bene_m03,0)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">abr: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->bene_m04,0)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">may: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->bene_m05,0)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">jun: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->bene_m06,0)}}
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">jul: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->bene_m07,0)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">ago: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->bene_m08,0)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">sep: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->bene_m09,0)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">oct: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->bene_m10,0)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">nov: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->bene_m11,0)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">dic: </label>
                                    &nbsp;&nbsp;{{number_format($regdistmuni->bene_m12,0)}}
                                </div>
                            </div> 

                            <div class="row">     
                                <div class="col-xs-3 form-group">
                                    <label><b style="background-color:orange;color:white;text-align:center;"> Beneficios </b>
                                    &nbsp;&nbsp;
                                    <b>Avance total: </b>
                                    </label>
                                    <input required autocomplete="off" id="bene_avance" name="bene_avance" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="total de avance" value="{{$regdistmuni->bene_avance}}" required>
                                </div>
                            </div>                            

                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>ene </label>
                                    <input required autocomplete="off" id="bene_a01" name="bene_a01" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="enero avance" value="{{$regdistmuni->bene_a01}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>feb </label>
                                    <input required autocomplete="off" id="bene_a02" name="bene_a02" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="febrero avance" value="{{$regdistmuni->bene_a02}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>mar  </label>
                                    <input required autocomplete="off" id="bene_a03" name="bene_a03" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="marzo avance" value="{{$regdistmuni->bene_a03}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>abr </label>
                                    <input required autocomplete="off" id="bene_a04" name="bene_a04" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="abril avance" value="{{$regdistmuni->bene_a04}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>may </label>
                                    <input required autocomplete="off" id="bene_a05" name="bene_a05" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="mayo avance" value="{{$regdistmuni->bene_a05}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>jun </label>
                                    <input required autocomplete="off" id="bene_a06" name="bene_a06" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="junio avance" value="{{$regdistmuni->bene_a06}}" required>
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>jul </label>
                                    <input required autocomplete="off" id="bene_a07" name="bene_a07" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="julio avance" value="{{$regdistmuni->bene_a07}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>ago </label>
                                    <input required autocomplete="off" id="bene_a08" name="bene_a08" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="agosto avance" value="{{$regdistmuni->bene_a08}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>sep </label>
                                    <input required autocomplete="off" id="bene_a09" name="bene_a09" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="septiembre avance" value="{{$regdistmuni->bene_a09}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>oct </label>
                                    <input required autocomplete="off" id="bene_a10" name="bene_a10" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="octubre avance" value="{{$regdistmuni->bene_a10}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>nov </label>
                                    <input required autocomplete="off" id="bene_a11" name="bene_a11" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="noviembre avance" value="{{$regdistmuni->bene_a11}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>dic </label>
                                    <input required autocomplete="off" id="bene_a12" name="bene_a12" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="diciembre avance" value="{{$regdistmuni->bene_a12}}" required>
                                </div>
                            </div>                                                         
                            <div class="row">
                                @if(count($errors) > 0)
                                    <div class="alert alert-danger" role="alert">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="col-md-12 offset-md-5">
                                    {!! Form::submit('Registrar',['class' => 'btn btn-success btn-flat pull-right']) !!}
                                    <a href="{{route('verdistmuniavan')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
                                </div>
                            </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('request')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\distmuniavancesRequest','#actualizardistmuniavan') !!}
@endsection

@section('javascrpt')
@endsection
