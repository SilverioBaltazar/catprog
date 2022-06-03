@extends('sicinar.principal')

@section('title','Editar Financiamiento')

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
                        {!! Form::open(['route' => ['actualizardistbenefmetas',$regdistbenef->periodo_id,$regdistbenef->prog_id], 'method' => 'PUT', 'id' => 'actualizardistbenefmetas', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">

                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <input type="hidden" id="periodo_id"  name="periodo_id"  value="{{$regdistbenef->periodo_id}}">  
                                    <input type="hidden" id="prog_id"     name="prog_id"     value="{{$regdistbenef->prog_id}}">   
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
                                <div class="col-xs-3 form-group">
                                    <label>Total beneficiarios meta </label>
                                    <input required autocomplete="off" id="benef_meta" name="benef_meta" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="total de beneficiarios meta" value="{{$regdistbenef->benef_meta}}" required>
                                </div>
                            </div>                            

                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>enero meta </label>
                                    <input required autocomplete="off" id="benef_m01" name="benef_m01" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="enero meta" value="{{$regdistbenef->benef_m01}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>febrero meta </label>
                                    <input required autocomplete="off" id="benef_m02" name="benef_m02" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="febrero meta" value="{{$regdistbenef->benef_m02}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>marzo meta </label>
                                    <input required autocomplete="off" id="benef_m03" name="benef_m03" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="marzo meta" value="{{$regdistbenef->benef_m03}}" required>
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>abril meta </label>
                                    <input required autocomplete="off" id="benef_m04" name="benef_m04" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="abril meta" value="{{$regdistbenef->benef_m04}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>mayo meta </label>
                                    <input required autocomplete="off" id="benef_m05" name="benef_m05" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="mayo meta" value="{{$regdistbenef->benef_m05}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>junio meta </label>
                                    <input required autocomplete="off" id="benef_m06" name="benef_m06" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="junio meta" value="{{$regdistbenef->benef_m06}}" required>
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>julio meta </label>
                                    <input required autocomplete="off" id="benef_m07" name="benef_m07" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="julio meta" value="{{$regdistbenef->benef_m07}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>agosto meta </label>
                                    <input required autocomplete="off" id="benef_m08" name="benef_m08" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="agosto meta" value="{{$regdistbenef->benef_m08}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>septiembre meta </label>
                                    <input required autocomplete="off" id="benef_m09" name="benef_m09" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="septiembre meta" value="{{$regdistbenef->benef_m09}}" required>
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>octubre meta </label>
                                    <input required autocomplete="off" id="benef_m10" name="benef_m10" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="octubre meta" value="{{$regdistbenef->benef_m10}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>noviembre meta </label>
                                    <input required autocomplete="off" id="benef_m11" name="benef_m11" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="noviembre meta" value="{{$regdistbenef->benef_m11}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>diciembre meta </label>
                                    <input required autocomplete="off" id="benef_m12" name="benef_m12" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="diciembre meta" value="{{$regdistbenef->benef_m12}}" required>
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
    {!! JsValidator::formRequest('App\Http\Requests\distbenefmetasRequest','#actualizardistbenefmetas') !!}
@endsection

@section('javascrpt')
@endsection
