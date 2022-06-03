@extends('sicinar.principal')

@section('title','Editar Programa')

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
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <div class="content-wrapper">
        <section class="content-header">
            <h1><i class="fa fa-dashboard"></i>&nbsp;&nbsp;Menú.
                <small>1. Ficha del programa -</small> 
                <small> Programa -</small>                
                <small> - Editar</small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b1.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp;Programa - Editar</li> 
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <p align="justify"><b style="color:red;">
                            Instrucciones:</b> <b style="color:green;">
                            Requisita los datos del programa y/o acción
                            </b>
                        </p>                                            
                        {!! Form::open(['route' => ['actualizarprog',$regprog->prog_id], 'method' => 'PUT', 'id' => 'actualizarprog', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label style="color:green;">Id.: {{$regprog->prog_id}} </label>                         
                                </div> 
                            </div>                        
                            <div class="row">
                                <div class="col-xs-10 form-group">
                                    <label >Programa y/o acción (150 caracteres) </label>
                                    <input type="text" class="form-control" name="prog_desc" id="prog_desc" placeholder="Programa y/o acción" value="{{Trim($regprog->prog_desc)}}" required>
                                </div>                                                              
                            </div>
                            <div class="row">
                                <div class="col-xs-10 form-group">
                                    <label >Vertiente (150 caracteres) </label>
                                    <input type="text" class="form-control" name="prog_verti" id="prog_verti" placeholder="Vertiente" value="{{Trim($regprog->prog_verti)}}" required>
                                </div>                                                              
                            </div>
                            <div class="row">
                                <div class="col-xs-10 form-group">
                                    <label >Siglas (150 caracteres)</label>
                                    <input type="text" class="form-control" name="prog_siglas" id="prog_siglas" placeholder="Siglas del programa" value="{{Trim($regprog->prog_siglas)}}" required>
                                </div>  
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">                        
                                    <label>Tipo </label>
                                    <select class="form-control m-bot15" id="prog_tipo" name="prog_tipo" required>
                                        @if($regprog->prog_tipo == 'P')
                                            <option value="P" selected>PROGRAMA</option>
                                            <option value="A">         ACCIÓN  </option>
                                        @else
                                            <option value="P">         PROGRAMA</option>
                                            <option value="A" selected>ACCIÓN  </option>
                                        @endif
                                    </select>
                                </div>               
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Nivel gubernamental responsable </label>
                                    <select class="form-control m-bot15" name="clasificgob_id" id="clasificgob_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar nivel </option>
                                        @foreach($regclasific as $nivel)
                                            @if($nivel->clasificgob_id == $regprog->clasificgob_id)
                                                <option value="{{$nivel->clasificgob_id}}" selected>{{$nivel->clasificgob_desc}}</option>
                                            @else                                        
                                               <option value="{{$nivel->clasificgob_id}}">{{$nivel->clasificgob_id}} - {{$nivel->clasificgob_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>                                     
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Prioridad </label>
                                    <select class="form-control m-bot15" name="prioridad_id" id="prioridad_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar prioridad </option>
                                        @foreach($regprioridad as $prio)
                                            @if($prio->prioridad_id == $regprog->prioridad_id)
                                                <option value="{{$prio->prioridad_id}}" selected>{{$prio->prioridad_desc}}</option>
                                            @else                                        
                                               <option value="{{$prio->prioridad_id}}">{{$prio->prioridad_id}} - {{$prio->prioridad_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>                                     
                            </div> 

                            <div class="row">
                                <div class="col-xs-4 form-group">                        
                                    <label>Activo o Inactivo </label>
                                    <select class="form-control m-bot15" id="prog_status1" name="prog_status1" required>
                                        @if($regprog->prog_status1 == 'S')
                                            <option value="S" selected>Activo  </option>
                                            <option value="N">         Inactivo</option>
                                        @else
                                            <option value="S">         Activo  </option>
                                            <option value="N" selected>Inactivo</option>
                                        @endif
                                    </select>
                                </div>                                                                  
                            </div>

                            <div class="row">                                
                                <div class="col-xs-12 form-group">
                                    <label >Observaciones (200 caracteres)</label>
                                    <textarea class="form-control" name="prog_obs1" id="prog_obs1" rows="2" cols="120" placeholder="Observaciones" required>{{Trim($regprog->prog_obs1)}}
                                    </textarea>
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
                                    <a href="{{route('verprog')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
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
    {!! JsValidator::formRequest('App\Http\Requests\progRequest','#actualizarprog') !!}
@endsection

@section('javascrpt')
<script>
    $('.datepicker').datepicker({
        format: "dd/mm/yyyy",
        startDate: '-29y',
        endDate: '-18y',
        startView: 2,
        maxViewMode: 2,
        clearBtn: true,        
        language: "es",
        autoclose: true
    });
</script>

@endsection
