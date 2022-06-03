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
                <small>6.2 Financiamiento avances -</small> 
                <small>Seleccionar para editar o registrar nuevo</small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b6.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp;Financiamiento avances </li> 
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <p align="justify"><b style="color:red;">
                            Instrucciones:</b> <b style="color:green;"> 
                            Requisitar las fuentes de financiamiento y distribución presupuestal anual (avances) del programa y/o acción.
                            Este apartado se deberá de requisitar periodicamente de forma anual; esto es cada ejercio fiscal.
                            </b>
                        </p>       
                        {!! Form::open(['route' => ['actualizarfinanavances',$regfinan->periodo_id,$regfinan->prog_id,$regfinan->ftefinan_id], 'method' => 'PUT', 'id' => 'actualizarfinanavances', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">

                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <input type="hidden" id="periodo_id"  name="periodo_id"  value="{{$regfinan->periodo_id}}">  
                                    <input type="hidden" id="prog_id"     name="prog_id"     value="{{$regfinan->prog_id}}">   
                                    <input type="hidden" id="ftefinan_id" name="ftefinan_id" value="{{$regfinan->ftefinan_id}}">
                                    <label style="color:green;">Periodo: </label>
                                    &nbsp;&nbsp;{{$regfinan->periodo_id}} 
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                                    
                                    <label style="color:green;">Programa y/o acción: </label>
                                        &nbsp;&nbsp;{{$regfinan->prog_id}}
                                        @foreach($regprogramas as $program)
                                                @if($program->prog_id == $regfinan->prog_id)
                                                    {{Trim($program->prog_desc)}}
                                                    @break
                                                @endif
                                        @endforeach                  
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                    
                                    
                                    <label style="color:green;">Fuente de financiamiento: </label>
                                        &nbsp;&nbsp;{{$regfinan->ftefinan_id}}
                                        @foreach($regfuentefinan as $ben)
                                            @if($ben->ftefinan_id == $regfinan->ftefinan_id)
                                                {{Trim($ben->ftefinan_desc)}}
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
                                    <label style="color:green;">$ Presupuesto total: </label>
                                    &nbsp;&nbsp;{{number_format($regfinan->finan_meta,2)}}
                                </div>
                            </div>                            

                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">$ ene: </label>
                                    &nbsp;&nbsp;{{number_format($regfinan->finan_m01,2)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">$ feb: </label>
                                    &nbsp;&nbsp;{{number_format($regfinan->finan_m02,2)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">$ mar:  </label>
                                    &nbsp;&nbsp;{{number_format($regfinan->finan_m03,2)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">$ abr: </label>
                                    &nbsp;&nbsp;{{number_format($regfinan->finan_m04,2)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">$ may: </label>
                                    &nbsp;&nbsp;{{number_format($regfinan->finan_m05,2)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">$ jun: </label>
                                    &nbsp;&nbsp;{{number_format($regfinan->finan_m06,2)}}
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">$ jul: </label>
                                    &nbsp;&nbsp;{{number_format($regfinan->finan_m07,2)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">$ ago: </label>
                                    &nbsp;&nbsp;{{number_format($regfinan->finan_m08,2)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">$ sep: </label>
                                    &nbsp;&nbsp;{{number_format($regfinan->finan_m09,2)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">$ oct: </label>
                                    &nbsp;&nbsp;{{number_format($regfinan->finan_m10,2)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">$ nov: </label>
                                    &nbsp;&nbsp;{{number_format($regfinan->finan_m11,2)}}
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label style="color:green;">$ dic: </label>
                                    &nbsp;&nbsp;{{number_format($regfinan->finan_m12,2)}}
                                </div>
                            </div> 

                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label style="background-color:orange;color:white;text-align:center;"><b> ---- Avances ----</b> </label>
                                </div>   
                            </div> 

                            <div class="row">                                                                
                                <div class="col-xs-3 form-group">
                                    <label>$ Avance total </label>
                                    <input required autocomplete="off" id="finan_avance" name="finan_avance" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ total de avance" value="{{$regfinan->finan_avance}}" required>
                                </div>
                            </div>                            

                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>$ ene </label>
                                    <input required autocomplete="off" id="finan_a01" name="finan_a01" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ enero avance" value="{{$regfinan->finan_a01}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ feb </label>
                                    <input required autocomplete="off" id="finan_a02" name="finan_a02" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ febrero avance" value="{{$regfinan->finan_a02}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ mar  </label>
                                    <input required autocomplete="off" id="finan_a03" name="finan_a03" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ marzo avance" value="{{$regfinan->finan_a03}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ abr </label>
                                    <input required autocomplete="off" id="finan_a04" name="finan_a04" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ abril avance" value="{{$regfinan->finan_a04}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ may </label>
                                    <input required autocomplete="off" id="finan_a05" name="finan_a05" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ mayo avance" value="{{$regfinan->finan_a05}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ jun </label>
                                    <input required autocomplete="off" id="finan_a06" name="finan_a06" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ junio avance" value="{{$regfinan->finan_a06}}" required>
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>$ jul </label>
                                    <input required autocomplete="off" id="finan_a07" name="finan_a07" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ julio avance" value="{{$regfinan->finan_a07}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ ago </label>
                                    <input required autocomplete="off" id="finan_a08" name="finan_a08" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ agosto avance" value="{{$regfinan->finan_a08}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ sep </label>
                                    <input required autocomplete="off" id="finan_a09" name="finan_a09" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ septiembre avance" value="{{$regfinan->finan_a09}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ oct </label>
                                    <input required autocomplete="off" id="finan_a10" name="finan_a10" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ octubre avance" value="{{$regfinan->finan_a10}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ nov </label>
                                    <input required autocomplete="off" id="finan_a11" name="finan_a11" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ noviembre avance" value="{{$regfinan->finan_a11}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ dic </label>
                                    <input required autocomplete="off" id="finan_a12" name="finan_a12" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ diciembre avance" value="{{$regfinan->finan_a12}}" required>
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
                                    <a href="{{route('verfinanavances')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
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
    {!! JsValidator::formRequest('App\Http\Requests\finanavancesRequest','#actualizarfinanavances') !!}
@endsection

@section('javascrpt')
@endsection
