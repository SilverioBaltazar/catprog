@extends('sicinar.principal')

@section('title','Nuevo directorio')

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
    <meta charset="utf-8">
    <div class="content-wrapper">
        <section class="content-header">
            <h1><i class="fa fa-dashboard"></i>&nbsp;&nbsp;Menú.
                <small>Ficha del programa -</small> 
                <small>12. Directorio -</small> 
                <small> Nuevo</small>
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
                        {!! Form::open(['route' => 'altanuevodirectorio', 'method' => 'POST','id' => 'nuevodirectorio', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">

                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >Periodo fiscal </label>
                                    <select class="form-control m-bot15" name="periodo_id" id="periodo_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar periodo fiscal</option>
                                        @foreach($regperiodos as $periodo)
                                            <option value="{{$periodo->periodo_id}}">{{$periodo->periodo_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>
                            </div>                            

                            <div class="row">                     
                                <div class="col-xs-6 form-group">
                                    <label >Programa y/o acción </label>
                                    <select class="form-control m-bot15" name="prog_id" id="prog_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar programa y/o acción </option>
                                        @foreach($regprogramas as $prog)
                                            <option value="{{$prog->prog_id}}">{{$prog->prog_id.' '.trim($prog->prog_desc)}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>                                                               
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Nombre completo de quien elaboró </label>
                                    <input type="text" class="form-control" name="dir_nombre_1" id="dir_nombre_1" placeholder="apellido paterno, materno y nombre(s)"  required>
                                </div>  
                            </div>
                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >Cargo </label>
                                    <input type="text" class="form-control" name="dir_cargo_1" id="dir_cargo_1" placeholder="Cargo" required>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >e-mail </label>
                                    <input type="text" class="form-control" name="dir_email_1" id="dir_email_1" placeholder="e-mail" required>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >Teléfono </label>
                                    <input type="text" class="form-control" name="dir_tel_1" id="dir_tel_1" placeholder="Teléfono" required>
                                </div>
                            </div>                            

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Nombre completo de quien valido </label>
                                    <input type="text" class="form-control" name="dir_nombre_2" id="dir_nombre_2" placeholder="apellido paterno, materno y nombre(s)"  required>
                                </div>  
                            </div>
                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >Cargo </label>
                                    <input type="text" class="form-control" name="dir_cargo_2" id="dir_cargo_2" placeholder="Cargo" required>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >e-mail </label>
                                    <input type="text" class="form-control" name="dir_email_2" id="dir_email_2" placeholder="e-mail" required>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >Teléfono </label>
                                    <input type="text" class="form-control" name="dir_tel_2" id="dir_tel_2" placeholder="Teléfono" required>
                                </div>
                            </div>        


                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Nombre completo del enlace institucional de padrones </label>
                                    <input type="text" class="form-control" name="dir_nombre_3" id="dir_nombre_3" placeholder="apellido paterno, materno y nombre(s)"  required>
                                </div>  
                            </div>
                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >Cargo </label>
                                    <input type="text" class="form-control" name="dir_cargo_3" id="dir_cargo_3" placeholder="Cargo" required>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >e-mail </label>
                                    <input type="text" class="form-control" name="dir_email_3" id="dir_email_3" placeholder="e-mail" required>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >Teléfono </label>
                                    <input type="text" class="form-control" name="dir_tel_3" id="dir_tel_3" placeholder="Teléfono" required>
                                </div>
                            </div>        

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Nombre completo del responsable de actualizar la información en sistema </label>
                                    <input type="text" class="form-control" name="dir_nombre_4" id="dir_nombre_4" placeholder="apellido paterno, materno y nombre(s)"  required>
                                </div>  
                            </div>
                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >Cargo </label>
                                    <input type="text" class="form-control" name="dir_cargo_4" id="dir_cargo_4" placeholder="Cargo" required>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >e-mail </label>
                                    <input type="text" class="form-control" name="dir_email_4" id="dir_email_4" placeholder="e-mail" required>
                                </div>
                            </div>
                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >Teléfono </label>
                                    <input type="text" class="form-control" name="dir_tel_4" id="dir_tel_4" placeholder="Teléfono" required>
                                </div>
                            </div>        
                            <div class="row">
                                <div class="col-md-12 offset-md-5">
                                    {!! Form::submit('Registrar',['class' => 'btn btn-success btn-flat pull-right']) !!}
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
    {!! JsValidator::formRequest('App\Http\Requests\directorioRequest','#nuevodirectorio') !!}
@endsection

@section('javascrpt')
@endsection