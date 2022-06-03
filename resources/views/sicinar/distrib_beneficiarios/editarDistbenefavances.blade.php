@extends('sicinar.principal')

@section('title','Editar Financiamiento avances')

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
                <small>7.2 Distrib. beneficiarios avances -</small> 
                <small>Seleccionar para editar </small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b7.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp;Distribución de beneficiarios avances </li> 
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <p align="justify"><b style="color:red;">
                            Instrucciones:</b> <b style="color:green;"> 
                            Requisitar la distribución anual de beneficiarios (avances) del programa y/o acción.
                            Este apartado se deberá de requisitar periodicamente de forma anual; esto es cada ejercio fiscal.
                            </b>
                        </p>       
                        {!! Form::open(['route' => ['actualizardistbenefavan',$regdistbenef->periodo_id,$regdistbenef->prog_id], 'method' => 'PUT', 'id' => 'actualizardistbenefavan', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">

                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <input type="hidden" id="periodo_id"  name="periodo_id"  value="{{$regdistbenef->periodo_id}}">  
                                    <input type="hidden" id="prog_id"     name="prog_id"     value="{{$regdistbenef->prog_id}}">   
                                    <input type="hidden" id="benef_meta"  name="benef_meta"  value="{{$regdistbenef->benef_meta}}">   
                                    <input type="hidden" id="benef_m01"   name="benef_m01"   value="{{$regdistbenef->benef_m01}}">   
                                    <input type="hidden" id="benef_m02"   name="benef_m02"   value="{{$regdistbenef->benef_m02}}">   
                                    <input type="hidden" id="benef_m03"   name="benef_m03"   value="{{$regdistbenef->benef_m03}}">   
                                    <input type="hidden" id="benef_m04"   name="benef_m04"   value="{{$regdistbenef->benef_m04}}">   
                                    <input type="hidden" id="benef_m05"   name="benef_m05"   value="{{$regdistbenef->benef_m05}}">   
                                    <input type="hidden" id="benef_m06"   name="benef_m06"   value="{{$regdistbenef->benef_m06}}">   
                                    <input type="hidden" id="benef_m07"   name="benef_m07"   value="{{$regdistbenef->benef_m07}}">   
                                    <input type="hidden" id="benef_m08"   name="benef_m08"   value="{{$regdistbenef->benef_m08}}">   
                                    <input type="hidden" id="benef_m09"   name="benef_m09"   value="{{$regdistbenef->benef_m09}}">   
                                    <input type="hidden" id="benef_m10"   name="benef_m10"   value="{{$regdistbenef->benef_m10}}">   
                                    <input type="hidden" id="benef_m11"   name="benef_m011"  value="{{$regdistbenef->benef_m11}}">   
                                    <input type="hidden" id="benef_m12"   name="benef_m012"  value="{{$regdistbenef->benef_m12}}">   
                          
                                    <label style="color:green;">Periodo: </label>
                                    &nbsp;&nbsp;{{$regdistbenef->periodo_id}} 
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                                    
                                    <label style="color:green;">Programa y/o acción: </label>
                                        &nbsp;&nbsp;{{$regdistbenef->prog_id}}
                                        @foreach($regprogramas as $program)
                                                @if($program->prog_id == $regdistbenef->prog_id)
                                                    {{Trim($program->prog_desc)}}
                                                    @break
                                                @endif
                                        @endforeach                  
                                </div>   
                            </div>
                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label style="background-color:orange;color:white;text-align:center;"><b> ---- Metas ----</b> </label>
                                </div>   
                            </div> 

                            <div class="row">                                                                
                                <div class="col-xs-3 form-group">
                                    <label style="color:green;">Total: </label>
                                    &nbsp;&nbsp;{{number_format($regdistbenef->benef_meta,2)}}
                                </div>
                            </div>                            

                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">ene: </label>
                                    &nbsp;&nbsp;{{number_format($regdistbenef->benef_m01,2)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">feb: </label>
                                    &nbsp;&nbsp;{{number_format($regdistbenef->benef_m02,2)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">mar:  </label>
                                    &nbsp;&nbsp;{{number_format($regdistbenef->benef_m03,2)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">abr: </label>
                                    &nbsp;&nbsp;{{number_format($regdistbenef->benef_m04,2)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">may: </label>
                                    &nbsp;&nbsp;{{number_format($regdistbenef->benef_m05,2)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">jun: </label>
                                    &nbsp;&nbsp;{{number_format($regdistbenef->benef_m06,2)}}
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">jul: </label>
                                    &nbsp;&nbsp;{{number_format($regdistbenef->benef_m07,2)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">ago: </label>
                                    &nbsp;&nbsp;{{number_format($regdistbenef->benef_m08,2)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">sep: </label>
                                    &nbsp;&nbsp;{{number_format($regdistbenef->benef_m09,2)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">oct: </label>
                                    &nbsp;&nbsp;{{number_format($regdistbenef->benef_m10,2)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">nov: </label>
                                    &nbsp;&nbsp;{{number_format($regdistbenef->benef_m11,2)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">dic: </label>
                                    &nbsp;&nbsp;{{number_format($regdistbenef->benef_m12,2)}}
                                </div>
                            </div> 

                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label style="background-color:orange;color:white;text-align:center;"><b> ---- Avances ----</b> </label>
                                </div>   
                            </div> 

                            <div class="row">                                                                
                                <div class="col-xs-3 form-group">
                                    <label>Avance total </label>
                                    <input required autocomplete="off" id="benef_avance" name="benef_avance" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="total de avance" value="{{$regdistbenef->benef_avance}}" required>
                                </div>
                            </div>                            

                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>ene </label>
                                    <input required autocomplete="off" id="benef_a01" name="benef_a01" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="enero avance" value="{{$regdistbenef->benef_a01}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>feb </label>
                                    <input required autocomplete="off" id="benef_a02" name="benef_a02" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="febrero avance" value="{{$regdistbenef->benef_a02}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>mar  </label>
                                    <input required autocomplete="off" id="benef_a03" name="benef_a03" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="marzo avance" value="{{$regdistbenef->benef_a03}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>abr </label>
                                    <input required autocomplete="off" id="benef_a04" name="benef_a04" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="abril avance" value="{{$regdistbenef->benef_a04}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>may </label>
                                    <input required autocomplete="off" id="benef_a05" name="benef_a05" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="mayo avance" value="{{$regdistbenef->benef_a05}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>jun </label>
                                    <input required autocomplete="off" id="benef_a06" name="benef_a06" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="junio avance" value="{{$regdistbenef->benef_a06}}" required>
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>jul </label>
                                    <input required autocomplete="off" id="benef_a07" name="benef_a07" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="julio avance" value="{{$regdistbenef->benef_a07}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>ago </label>
                                    <input required autocomplete="off" id="benef_a08" name="benef_a08" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="agosto avance" value="{{$regdistbenef->benef_a08}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>sep </label>
                                    <input required autocomplete="off" id="benef_a09" name="benef_a09" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="septiembre avance" value="{{$regdistbenef->benef_a09}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>oct </label>
                                    <input required autocomplete="off" id="benef_a10" name="benef_a10" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="octubre avance" value="{{$regdistbenef->benef_a10}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>nov </label>
                                    <input required autocomplete="off" id="benef_a11" name="benef_a11" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="noviembre avance" value="{{$regdistbenef->benef_a11}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>dic </label>
                                    <input required autocomplete="off" id="benef_a12" name="benef_a12" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="diciembre avance" value="{{$regdistbenef->benef_a12}}" required>
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
                                    <a href="{{route('verdistbenefavan')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
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
    {!! JsValidator::formRequest('App\Http\Requests\distbenefavancesRequest','#actualizardistbenefavances') !!}
@endsection

@section('javascrpt')
@endsection
