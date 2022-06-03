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
                <small>4. Proyecto prersupuestal -</small> 
                <small>Seleccionar para editar o registrar nuevo</small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b4.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp;Proyecto presupuestal</li> 
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <p align="justify"><b style="color:red;">
                            Instrucciones:</b> <b style="color:green;">
                            Requisitar los datos del proyecto presupuestal. 
                            Este apartado se deberá de requisitar periodicamente de forma anual; esto es cada ejercio fiscal.
                            </b>
                        </p>       
                        {!! Form::open(['route' => ['actualizarproyectop',$regproyectopres->periodo_id, $regproyectopres->prog_id], 'method' => 'PUT', 'id' => 'actualizarproyectop', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">

                            <div class="row">
                                <div class="col-xs-6 form-group">
                                    <input type="hidden" id="periodo_id" name="periodo_id" value="{{$regproyectopres->periodo_id}}">  
                                    <input type="hidden" id="prog_id"    name="prog_id"    value="{{$regproyectopres->prog_id}}">    
                                    <label style="color:green;">Periodo: 
                                    &nbsp;&nbsp;{{$regproyectopres->periodo_id}} 
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                                    </label>                         

                                    <label style="color:green;">Programa y/o acción:
                                        &nbsp;&nbsp;{{$regproyectopres->prog_id}}
                                        @foreach($regprogramas as $program)
                                                @if($program->prog_id == $regproyectopres->prog_id)
                                                    {{Trim($program->prog_desc)}}
                                                    @break
                                                @endif
                                        @endforeach                                    
                                    </label>
                                </div>                              
                            </div>

                            <div class="row">    
                                <div class="col-xs-6 form-group">
                                    <label >Estructura programática - Proyecto </label>
                                    <input type="hidden" id="proy_idd" name="proy_idd" value="{{$regproyectopres->proy_id}}">                                  
                                    <select class="form-control m-bot15" name="proy_id" id="proy_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar proyecto </option>
                                        @foreach($regproyectos as $proy)
                                            @if($proy->proy_id == $regproyectopres->proy_id)
                                                <option value="{{$proy->proy_id}}" selected>{{$proy->proy_id.' '.Trim($proy->proy_desc)}}</option>
                                            @else                                        
                                               <option value="{{$proy->proy_id}}">{{$proy->proy_id.' '.Trim($proy->proy_desc)}} </option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>   
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >$ Monto presupuestado </label>
                                    <input type="text" class="form-control" name="monto_presup" id="monto_presup" placeholder="Monto presupuestado" value="{{$regproyectopres->monto_presup}}" required>
                                </div>
                            </div>

                            <div class="row">                                    
                                <div class="col-xs-4 form-group">
                                    <label >$ Monto autorizado</label>
                                    <input type="text" class="form-control" name="monto_autorizado" id="monto_autorizado" placeholder="Monto autorizado" value="{{$regproyectopres->monto_autorizado}}" required>
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
                                    <a href="{{route('verproyectop')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
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
    {!! JsValidator::formRequest('App\Http\Requests\proyectopRequest','#actualizarproyectop') !!}
@endsection

@section('javascrpt')
@endsection