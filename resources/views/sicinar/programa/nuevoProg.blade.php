@extends('sicinar.principal')

@section('title','Nueva OSC')

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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <div class="content-wrapper">
        <section class="content-header"> 
            <h1><i class="fa fa-dashboard"></i>&nbsp;&nbsp;Menú.
                <small>1. Ficha del programa</small>
                <small> - Programa</small>
                <small> - Nuevo   </small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b1.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp; Programa - Nuevo</li> 
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
                        {!! Form::open(['route' => 'altanuevoprog', 'method' => 'POST','id' => 'altanuevoprog', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-10 form-group">
                                    <label >Programa y/o acción (150 caracteres)</label>
                                    <input type="text" class="form-control" name="prog_desc" id="prog_desc" placeholder="Digitar el programa y/o acción" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-10 form-group">
                                    <label >Vertiente (150 caracteres)</label>
                                    <input type="text" class="form-control" name="prog_verti" id="prog_verti" placeholder="Digitar la vertiente" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-10 form-group">
                                    <label >Siglas (150 caracteres)</label>
                                    <input type="text" class="form-control" name="prog_siglas" id="prog_siglas" placeholder="Digitar las siglas" required>
                                </div>  
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">                        
                                    <label>Tipo </label>
                                    <select class="form-control m-bot15" id="prog_tipo" name="prog_tipo" required>
                                            <option value="P">PROGRAMA</option>
                                            <option value="A">ACCIÓN  </option>
                                    </select>
                                </div>      
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label>Nivel gubernamental responsable </label>
                                    <select class="form-control m-bot15" name="clasificgob_id" id="clasificgob_id" required>
                                        <option value=""> </option> 
                                        @foreach($regclasific as $nivel)
                                            <option value="{{$nivel->clasificgob_id}}">{{trim($nivel->clasificgob_desc)}}</option>
                                        @endforeach   
                                    </select>
                                </div>             
                            </div>
                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label>Prioridad </label>
                                    <select class="form-control m-bot15" name="prioridad_id" id="prioridad_id" required>
                                        <option value=""> </option> 
                                        @foreach($regprioridad as $prioridad)
                                            <option value="{{$prioridad->prioridad_id}}">{{trim($prioridad->prioridad_desc)}}</option>
                                        @endforeach   
                                    </select>
                                </div>             
                            </div>                            
                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label >Observaciones (200 caracteres)</label>
                                    <textarea class="form-control" name="prog_obs1" id="prog_obs1" rows="2" cols="120" placeholder="Observaciones" required>
                                    </textarea>
                                </div>                                
                            </div>


                            <div class="row">
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
    {!! JsValidator::formRequest('App\Http\Requests\progRequest','#altanuevoprog') !!}
@endsection

@section('javascrpt')
<script>
  function soloAlfa(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key);
       letras = "abcdefghijklmnñopqrstuvwxyz ABCDEFGHIJKLMNÑOPQRSTUVWXYZ.";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }
        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }

    function general(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key);
       letras = "abcdefghijklmnñopqrstuvwxyz ABCDEFGHIJKLMNÑOPQRSTUVWXYZ1234567890,.;:-_<>!%()=?¡¿/*+";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }
        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }
</script>

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