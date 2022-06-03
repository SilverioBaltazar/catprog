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
                <small>7.1 Distrib. beneficiarios metas -</small> 
                <small>Seleccionar para editar o registrar nuevo</small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b7.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp;Distribución de beneficiarios metas </li> 
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <p align="justify"><b style="color:red;">
                            Instrucciones:</b> <b style="color:green;">
                            Requisitar la distribución anual de beneficiarios del programa y/o acción.
                            Este apartado se deberá de requisitar periodicamente de forma anual; esto es cada ejercio fiscal.
                            </b>
                        </p>       
                        {!! Form::open(['route' => 'altanuevodistbenefmetas', 'method' => 'POST','id' => 'nuevodistbenefmetas', 'enctype' => 'multipart/form-data']) !!}
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
                                <div class="col-xs-3 form-group">
                                    <label>Total beneficiarios meta </label>
                                    <input required autocomplete="off" id="benef_meta" name="benef_meta" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="total de beneficiarios meta" value="0">
                                </div>
                            </div>                            

                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>enero meta </label>
                                    <input required autocomplete="off" id="benef_m01" name="benef_m01" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="enero meta" value="0">
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>febrero meta </label>
                                    <input required autocomplete="off" id="benef_m02" name="benef_m02" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="febrero meta" value="0">
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>marzo meta </label>
                                    <input required autocomplete="off" id="benef_m03" name="benef_m03" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="marzo meta" value="0">
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>abril meta </label>
                                    <input required autocomplete="off" id="benef_m04" name="benef_m04" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="abril meta" value="0">
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>mayo meta </label>
                                    <input required autocomplete="off" id="benef_m05" name="benef_m05" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="mayo meta" value="0">
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>junio meta </label>
                                    <input required autocomplete="off" id="benef_m06" name="benef_m06" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="junio meta" value="0">
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>julio meta </label>
                                    <input required autocomplete="off" id="benef_m07" name="benef_m07" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="julio meta" value="0">
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>agosto meta </label>
                                    <input required autocomplete="off" id="benef_m08" name="benef_m08" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="agosto meta" value="0">
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>septiembre meta </label>
                                    <input required autocomplete="off" id="benef_m09" name="benef_m09" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="septiembre meta" value="0">
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>octubre meta </label>
                                    <input required autocomplete="off" id="benef_m10" name="benef_m10" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="octubre meta" value="0">
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>noviembre meta </label>
                                    <input required autocomplete="off" id="benef_m11" name="benef_m11" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="noviembre meta" value="0">
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>diciembre meta </label>
                                    <input required autocomplete="off" id="benef_m12" name="benef_m12" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="diciembre meta" value="0">
                                </div>
                            </div> 

                            <div class="row">
                                <div class="col-md-12 offset-md-5">
                                    {!! Form::submit('Registrar',['class' => 'btn btn-success btn-flat pull-right']) !!}
                                    <a href="{{route('verdistbenefmetas')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
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
    {!! JsValidator::formRequest('App\Http\Requests\distbenefmetasRequest','#nuevodistbenefmetas') !!}
@endsection

@section('javascrpt')
@endsection
