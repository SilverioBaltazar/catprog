@extends('sicinar.principal')

@section('title','Editar curso')

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
                <small>5. Beneficios -</small> 
                <small>Seleccionar para editar o registrar nuevo</small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b5.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp;Beneficios - Programa </li> 
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <p align="justify"><b style="color:red;">
                            Instrucciones:</b> <b style="color:green;">
                            Requisitar los beneficios otorgados en el programa y/o acción.
                            Este apartado se deberá de requisitar periodicamente de forma anual; esto es cada ejercio fiscal.
                            </b>
                        </p>       
                        {!! Form::open(['route' => ['actualizarbenefprog',$regbenefprog->periodo_id,$regbenefprog->prog_id,$regbenefprog->benef_id], 'method' => 'PUT', 'id' => 'actualizarbenefprog', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">

                            <div class="row">
                                <div class="col-xs-6 form-group">
                                    <input type="hidden" id="periodo_id" name="periodo_id" value="{{$regbenefprog->periodo_id}}">  
                                    <input type="hidden" id="prog_id"    name="prog_id" value="{{$regbenefprog->prog_id}}">   
                                    <input type="hidden" id="benef_id"   name="benef_id" value="{{$regbenefprog->benef_id}}">   
                                    <label style="color:green;">Periodo: 
                                    &nbsp;&nbsp;{{$regbenefprog->periodo_id}} 
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                                    </label>                         

                                    <label style="color:green;">Programa y/o acción:
                                        &nbsp;&nbsp;{{$regbenefprog->prog_id}}
                                        @foreach($regprogramas as $program)
                                                @if($program->prog_id == $regbenefprog->prog_id)
                                                    {{Trim($program->prog_desc)}}
                                                    @break
                                                @endif
                                        @endforeach                  
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                    
                                    </label>

                                    <label style="color:green;">Beneficio: </label>
                                        &nbsp;&nbsp;{{$regbenefprog->benef_id}}
                                        @foreach($regbeneficios as $ben)
                                            @if($ben->benef_id == $regbenefprog->benef_id)
                                                {{Trim($ben->benef_desc)}}
                                                @break                                        
                                            @endif
                                        @endforeach
                                    </label>
                                </div>   
                            </div>
                            <div class="row">
                                <div class="col-xs-8 form-group">
                                    <label >Descripción del beneficio </label>
                                    <input type="text" class="form-control" name="benef_desc" id="benef_desc" placeholder="Descripción del beneficio" value="{{$regbenefprog->benef_desc}}" required>
                                </div>
                            </div>
                            <div class="row">    
                                <div class="col-xs-4 form-group">
                                    <label >Periodicidad </label>
                                    <select class="form-control m-bot15" name="periodici_id" id="periodici_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar periodicidad </option>
                                        @foreach($regperiodici as $per)
                                            @if($per->periodici_id == $regbenefprog->periodici_id)
                                                <option value="{{$per->periodici_id}}" selected>{{$per->periodici_id.' '.Trim($per->periodici_desc)}}</option>
                                            @else                                        
                                                <option value="{{$per->periodici_id}}">{{$per->periodici_id.' '.Trim($per->periodici_desc)}} </option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>   
                            </div>

                            <div class="row">                                    
                                <div class="col-xs-2 form-group">
                                    <label >$ Costo unitario </label>
                                    <input type="text" class="form-control" name="benef_costounit" id="benef_costounit" placeholder="Costo unitario" value="{{$regbenefprog->benef_costounit}}" required>
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
                                    <a href="{{route('verbenefprog')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
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
    {!! JsValidator::formRequest('App\Http\Requests\benefprogRequest','#actualizarbenefprog') !!}
@endsection

@section('javascrpt')
@endsection