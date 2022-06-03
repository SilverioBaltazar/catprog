@extends('sicinar.principal')

@section('title','Editar directorio')

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
                <small>Ficha del programa -</small> 
                <small>12. Directorio -</small> 
                <small> Editar</small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b12.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp;Directorio </li> 
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <p align="justify"><b style="color:red;">
                            Instrucciones:</b> <b style="color:green;">
                            Requisitar el directorio del programa y/o acción.
                            Este apartado se deberá de requisitar periodicamente de forma anual; esto es cada ejercio fiscal.
                            </b>
                        </p>       
                        {!! Form::open(['route' => ['actualizardirectorio',$regdirectorio->periodo_id,$regdirectorio->prog_id], 'method' => 'PUT', 'id' => 'actualizardirectorio', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                           
                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <input type="hidden" id="periodo_id"  name="periodo_id"  value="{{$regdirectorio->periodo_id}}">  
                                    <input type="hidden" id="prog_id"     name="prog_id"     value="{{$regdirectorio->prog_id}}">   
                                    <label style="color:green;">Periodo: </label>
                                    &nbsp;&nbsp;{{$regdirectorio->periodo_id}} 
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                                    
                                    <label style="color:green;">Programa y/o acción: </label>
                                        &nbsp;&nbsp;{{$regdirectorio->prog_id}}
                                        @foreach($regprogramas as $program)
                                                @if($program->prog_id == $regdirectorio->prog_id)
                                                    {{Trim($program->prog_desc)}}
                                                    @break
                                                @endif
                                        @endforeach                  
                                </div>   
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Nombre completo de quien elaboró </label>
                                    <input type="text" class="form-control" name="dir_nombre_1" id="dir_nombre_1" placeholder="apellido paterno, materno y nombre(s)" value="{{$regdirectorio->dir_nombre_1}}"  required>
                                </div>  
                            </div>
                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >Cargo </label>
                                    <input type="text" class="form-control" name="dir_cargo_1" id="dir_cargo_1" placeholder="Cargo"  value="{{$regdirectorio->dir_cargo_1}}" required>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >e-mail </label>
                                    <input type="text" class="form-control" name="dir_email_1" id="dir_email_1" placeholder="e-mail" value="{{$regdirectorio->dir_email_1}}" required>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >Teléfono </label>
                                    <input type="text" class="form-control" name="dir_tel_1" id="dir_tel_1" placeholder="Teléfono" value="{{$regdirectorio->dir_tel_1}}" required>
                                </div>
                            </div>                            

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Nombre completo de quien valido </label>
                                    <input type="text" class="form-control" name="dir_nombre_2" id="dir_nombre_2" placeholder="apellido paterno, materno y nombre(s)" value="{{$regdirectorio->dir_nombre_2}}"  required>
                                </div>  
                            </div>
                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >Cargo </label>
                                    <input type="text" class="form-control" name="dir_cargo_2" id="dir_cargo_2" placeholder="Cargo" value="{{$regdirectorio->dir_cargo_2}}" required>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >e-mail </label>
                                    <input type="text" class="form-control" name="dir_email_2" id="dir_email_2" placeholder="e-mail" value="{{$regdirectorio->dir_email_2}}" required>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >Teléfono </label>
                                    <input type="text" class="form-control" name="dir_tel_2" id="dir_tel_2" placeholder="Teléfono" value="{{$regdirectorio->dir_tel_2}}" required>
                                </div>
                            </div>        


                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Nombre completo del enlace institucional de padrones </label>
                                    <input type="text" class="form-control" name="dir_nombre_3" id="dir_nombre_3" placeholder="apellido paterno, materno y nombre(s)" value="{{$regdirectorio->dir_nombre_3}}" required>
                                </div>  
                            </div>
                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >Cargo </label>
                                    <input type="text" class="form-control" name="dir_cargo_3" id="dir_cargo_3" placeholder="Cargo" value="{{$regdirectorio->dir_cargo_3}}" required>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >e-mail </label>
                                    <input type="text" class="form-control" name="dir_email_3" id="dir_email_3" placeholder="e-mail" value="{{$regdirectorio->dir_email_3}}" required>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >Teléfono </label>
                                    <input type="text" class="form-control" name="dir_tel_3" id="dir_tel_3" placeholder="Teléfono" value="{{$regdirectorio->dir_tel_3}}" required>
                                </div>
                            </div>        

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Nombre completo del responsable de actualizar la información en sistema </label>
                                    <input type="text" class="form-control" name="dir_nombre_4" id="dir_nombre_4" placeholder="apellido paterno, materno y nombre(s)" value="{{$regdirectorio->dir_nombre_4}}" required>
                                </div>  
                            </div>
                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >Cargo </label>
                                    <input type="text" class="form-control" name="dir_cargo_4" id="dir_cargo_4" placeholder="Cargo" value="{{$regdirectorio->dir_cargo_4}}" required>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >e-mail </label>
                                    <input type="text" class="form-control" name="dir_email_4" id="dir_email_4" placeholder="e-mail" value="{{$regdirectorio->dir_email_4}}" required>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >Teléfono </label>
                                    <input type="text" class="form-control" name="dir_tel_4" id="dir_tel_4" placeholder="Teléfono" value="{{$regdirectorio->dir_tel_4}}" required>
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
                                    {!! Form::submit('Guardar',['class' => 'btn btn-success btn-flat pull-right']) !!}
                                    <a href="{{route('verdirectorio')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
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
    {!! JsValidator::formRequest('App\Http\Requests\directorioRequest','#actualizardirectorio') !!}
@endsection

@section('javascrpt')
@endsection

