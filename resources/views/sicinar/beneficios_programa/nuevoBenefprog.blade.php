@extends('sicinar.principal')

@section('title','Registro de beneficios - programa')

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
                        {!! Form::open(['route' => 'altanuevobenefprog', 'method' => 'POST','id' => 'nuevobenefprog', 'enctype' => 'multipart/form-data']) !!}
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
                                <div class="col-xs-6 form-group">
                                    <label >Beneficio </label>
                                    <select class="form-control m-bot15" name="benef_id" id="benef_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar beneficio </option>
                                        @foreach($regbeneficios as $proy)
                                            <option value="{{$proy->benef_id}}">{{$proy->benef_id.' '.trim($proy->benef_desc)}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>                                                               
                            </div>
                            <div class="row">                                
                                <div class="col-xs-8 form-group">
                                    <label>Descripción del beneficio</label>
                                    <input id="benef_desc" name="benef_desc" class="form-control" placeholder="Descripción del beneficio" value="">
                                </div>
                            </div>
                            <div class="row">                     
                                <div class="col-xs-4 form-group">
                                    <label >Periodicidad </label>
                                    <select class="form-control m-bot15" name="periodici_id" id="periodici_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar periodicidad </option>
                                        @foreach($regperiodici as $peri)
                                            <option value="{{$peri->periodici_id}}">{{$peri->periodici_id.' '.trim($peri->periodici_desc)}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>                                                               
                            </div>                            

                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>$ Costo unitario </label>
                                    <input required autocomplete="off" id="benef_costounit" name="benef_costounit" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ Costo unitario" value="">
                                </div>
                            </div>                            

                            <div class="row">
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
    {!! JsValidator::formRequest('App\Http\Requests\benefprogRequest','#nuevobenefprog') !!}
@endsection

@section('javascrpt')

@endsection