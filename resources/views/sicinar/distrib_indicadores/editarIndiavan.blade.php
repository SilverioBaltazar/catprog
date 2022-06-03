@extends('sicinar.principal')

@section('title','Editar indicador avances')

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
                <small>10.2 Indicador avances -</small> 
                <small>Seleccionar para editar</small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b10.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp;Indicador avances </li> 
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <p align="justify"><b style="color:red;">
                            Instrucciones:</b> <b style="color:green;"> 
                            Requisitar los datos del indicador avances del programa y/o acción.
                            Este apartado se deberá de requisitar periodicamente de forma anual; esto es cada ejercio fiscal.
                            </b>
                        </p>       
                        {!! Form::open(['route' => ['actualizarindiavan',$regindicador->periodo_id,$regindicador->prog_id,$regindicador->indi_id], 'method' => 'PUT', 'id' => 'actualizarindiavan', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">

                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <input type="hidden" id="periodo_id"    name="periodo_id"    value="{{$regindicador->periodo_id}}">  
                                    <input type="hidden" id="prog_id"       name="prog_id"       value="{{$regindicador->prog_id}}">   
                                    <input type="hidden" id="indi_id"       name="indi_id"       value="{{$regindicador->indi_id}}">
                                    <input type="hidden" id="iclase_id"     name="iclase_id"     value="{{$regindicador->iclase_id}}">   
                                    <input type="hidden" id="itipo_id"      name="itipo_id"      value="{{$regindicador->itipo_id}}">   
                                    <input type="hidden" id="idimension_id" name="idimension_id" value="{{$regindicador->idimension_id}}">   
                                    <input type="hidden" id="indi_meta"  name="indi_meta"  value="{{$regindicador->indi_meta}}">   
                                    <input type="hidden" id="indi_m01"   name="indi_m01"   value="{{$regindicador->indi_m01}}">   
                                    <input type="hidden" id="indi_m02"   name="indi_m02"   value="{{$regindicador->indi_m02}}">   
                                    <input type="hidden" id="indi_m03"   name="indi_m03"   value="{{$regindicador->indi_m03}}">   
                                    <input type="hidden" id="indi_m04"   name="indi_m04"   value="{{$regindicador->indi_m04}}">   
                                    <input type="hidden" id="indi_m05"   name="indi_m05"   value="{{$regindicador->indi_m05}}">   
                                    <input type="hidden" id="indi_m06"   name="indi_m06"   value="{{$regindicador->indi_m06}}">   
                                    <input type="hidden" id="indi_m07"   name="indi_m07"   value="{{$regindicador->indi_m07}}">   
                                    <input type="hidden" id="indi_m08"   name="indi_m08"   value="{{$regindicador->indi_m08}}">   
                                    <input type="hidden" id="indi_m09"   name="indi_m09"   value="{{$regindicador->indi_m09}}">   
                                    <input type="hidden" id="indi_m10"   name="indi_m10"   value="{{$regindicador->indi_m10}}">   
                                    <input type="hidden" id="indi_m11"   name="indi_m011"  value="{{$regindicador->indi_m11}}">   
                                    <input type="hidden" id="indi_m12"   name="indi_m012"  value="{{$regindicador->indi_m12}}">   

                                    <label style="color:green;">Periodo: </label>
                                    &nbsp;&nbsp;{{$regindicador->periodo_id}} 
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                                    
                                    <label style="color:green;">Programa y/o acción: </label>
                                        &nbsp;&nbsp;{{$regindicador->prog_id}}
                                        @foreach($regprogramas as $program)
                                                @if($program->prog_id == $regindicador->prog_id)
                                                    {{Trim($program->prog_desc)}}
                                                    @break
                                                @endif
                                        @endforeach                  
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                                      
                                </div>   
                            </div>
                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label style="color:green;">Indicador: </label>
                                    &nbsp;&nbsp;{{$regindicador->indi_id.' '.Trim($regindicador->indi_desc)}}
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                                    
                                    <label style="color:green;">Fórmula: </label>
                                        &nbsp;&nbsp;{{Trim($regindicador->indi_formula)}}
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                                                        
                                </div>   
                            </div>                                                    
                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label style="color:green;">Clase: </label>
                                    &nbsp;&nbsp;{{$regindicador->iclase_id}} 
                                        @foreach($regiclase as $clase)
                                                @if($clase->iclase_id == $regindicador->iclase_id)
                                                    {{Trim($clase->iclase_desc)}}
                                                    @break
                                                @endif
                                        @endforeach                  

                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                                    
                                    <label style="color:green;">Tipo: </label>
                                        &nbsp;&nbsp;{{$regindicador->itipo_id}}
                                        @foreach($regitipo as $tipo)
                                                @if($tipo->itipo_id == $regindicador->itipo_id)
                                                    {{Trim($tipo->itipo_desc)}}
                                                    @break
                                                @endif
                                        @endforeach                  
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                    
                                    
                                    <label style="color:green;">Dimensión: </label>
                                        &nbsp;&nbsp;{{$regindicador->idimension_id}}
                                        @foreach($regidimen as $dimen)
                                            @if($dimen->idimension_id == $regindicador->idimension_id)
                                                {{Trim($dimen->idimension_desc)}}
                                                @break                                        
                                            @endif
                                        @endforeach
                                </div>   
                            </div>                            

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label><b style="background-color:orange;color:white;text-align:center;"> Metas </b>
                                    &nbsp;&nbsp;
                                    <b style="color:green;">Total: </b>
                                    </label>
                                    &nbsp;&nbsp;{{number_format($regindicador->indi_meta,0)}}
                                </div>
                            </div>           

                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">ene: </label>
                                    &nbsp;&nbsp;{{number_format($regindicador->indi_m01,0)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">feb: </label>
                                    &nbsp;&nbsp;{{number_format($regindicador->indi_m02,0)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">mar:  </label>
                                    &nbsp;&nbsp;{{number_format($regindicador->indi_m03,0)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">abr: </label>
                                    &nbsp;&nbsp;{{number_format($regindicador->indi_m04,0)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">may: </label>
                                    &nbsp;&nbsp;{{number_format($regindicador->indi_m05,0)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">jun: </label>
                                    &nbsp;&nbsp;{{number_format($regindicador->indi_m06,0)}}
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">jul: </label>
                                    &nbsp;&nbsp;{{number_format($regindicador->indi_m07,0)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">ago: </label>
                                    &nbsp;&nbsp;{{number_format($regindicador->indi_m08,0)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">sep: </label>
                                    &nbsp;&nbsp;{{number_format($regindicador->indi_m09,0)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">oct: </label>
                                    &nbsp;&nbsp;{{number_format($regindicador->indi_m10,0)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">nov: </label>
                                    &nbsp;&nbsp;{{number_format($regindicador->indi_m11,0)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">dic: </label>
                                    &nbsp;&nbsp;{{number_format($regindicador->indi_m12,0)}}
                                </div>
                            </div> 


                            <div class="row">     
                                <div class="col-xs-3 form-group">
                                    <label><b style="background-color:orange;color:white;text-align:center;"> Avances </b>
                                    &nbsp;&nbsp;
                                    <b>Total </b>
                                    </label>
                                    <input required autocomplete="off" id="indi_avance" name="indi_avance" min="0" max="999999999.99" class="form-control" type="decimal(9,0)" placeholder="total de avance" value="{{$regindicador->indi_avance}}" required>
                                </div>
                            </div>                            

                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>ene </label>
                                    <input required autocomplete="off" id="indi_a01" name="indi_a01" min="0" max="999999999.99" class="form-control" type="decimal(9,0)" placeholder="enero avance" value="{{$regindicador->indi_a01}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>feb </label>
                                    <input required autocomplete="off" id="indi_a02" name="indi_a02" min="0" max="999999999.99" class="form-control" type="decimal(9,0)" placeholder="febrero avance" value="{{$regindicador->indi_a02}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>mar  </label>
                                    <input required autocomplete="off" id="indi_a03" name="indi_a03" min="0" max="999999999.99" class="form-control" type="decimal(9,0)" placeholder="marzo avance" value="{{$regindicador->indi_a03}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>abr </label>
                                    <input required autocomplete="off" id="indi_a04" name="indi_a04" min="0" max="999999999.99" class="form-control" type="decimal(9,0)" placeholder="abril avance" value="{{$regindicador->indi_a04}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>may </label>
                                    <input required autocomplete="off" id="indi_a05" name="indi_a05" min="0" max="999999999.99" class="form-control" type="decimal(9,0)" placeholder="mayo avance" value="{{$regindicador->indi_a05}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>jun </label>
                                    <input required autocomplete="off" id="indi_a06" name="indi_a06" min="0" max="999999999.99" class="form-control" type="decimal(9,0)" placeholder="junio avance" value="{{$regindicador->indi_a06}}" required>
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>jul </label>
                                    <input required autocomplete="off" id="indi_a07" name="indi_a07" min="0" max="999999999.99" class="form-control" type="decimal(9,0)" placeholder="julio avance" value="{{$regindicador->indi_a07}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>ago </label>
                                    <input required autocomplete="off" id="indi_a08" name="indi_a08" min="0" max="999999999.99" class="form-control" type="decimal(9,0)" placeholder="agosto avance" value="{{$regindicador->indi_a08}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>sep </label>
                                    <input required autocomplete="off" id="indi_a09" name="indi_a09" min="0" max="999999999.99" class="form-control" type="decimal(9,0)" placeholder="septiembre avance" value="{{$regindicador->indi_a09}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>oct </label>
                                    <input required autocomplete="off" id="indi_a10" name="indi_a10" min="0" max="999999999.99" class="form-control" type="decimal(9,0)" placeholder="octubre avance" value="{{$regindicador->indi_a10}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>nov </label>
                                    <input required autocomplete="off" id="indi_a11" name="indi_a11" min="0" max="999999999.99" class="form-control" type="decimal(9,0)" placeholder="noviembre avance" value="{{$regindicador->indi_a11}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>dic </label>
                                    <input required autocomplete="off" id="indi_a12" name="indi_a12" min="0" max="999999999.99" class="form-control" type="decimal(9,0)" placeholder="diciembre avance" value="{{$regindicador->indi_a12}}" required>
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
                                    <a href="{{route('verindiavan')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
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
    {!! JsValidator::formRequest('App\Http\Requests\indiavanRequest','#actualizarindiavan') !!}
@endsection

@section('javascrpt')
@endsection
