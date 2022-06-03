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
                <small>10.1 Indicador metas -</small> 
                <small>Seleccionar para editar</small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b10.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp;Indicador metas  </li> 
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <p align="justify"><b style="color:red;">
                            Instrucciones:</b> <b style="color:green;"> 
                            Requisitar los datos del indicador metas del programa y/o acción.
                            Este apartado se deberá de requisitar periodicamente de forma anual; esto es cada ejercio fiscal.
                            </b>
                        </p>       
                        {!! Form::open(['route' => ['actualizarindimetas',$regindicador->periodo_id,$regindicador->prog_id,$regindicador->indi_id], 'method' => 'PUT', 'id' => 'actualizarindimetas', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">

                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <input type="hidden" id="periodo_id"  name="periodo_id"  value="{{$regindicador->periodo_id}}">  
                                    <input type="hidden" id="prog_id"     name="prog_id"     value="{{$regindicador->prog_id}}">   
                                    <input type="hidden" id="indi_id"     name="indi_id"     value="{{$regindicador->indi_id}}">
                                    <label style="color:green;">Periodo: </label>
                                    &nbsp;&nbsp;{{$regindicador->periodo_id}} 
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                                    
                                    <label style="color:green;">Programa y/o acción: </label>
                                        &nbsp;&nbsp;{{$regindicador->prog_id}}
                                        @foreach($regprogramas as $program)
                                                @if($program->prog_id == $regindicador->prog_id)
                                                    {{Trim($program->prog_desc)}}
                                                    @break
                                                @endif
                                        @endforeach                  
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;                    
                                    
                                    <label style="color:green;">id. Indicador: </label>
                                        &nbsp;&nbsp;{{$regindicador->indi_id}}                                    
                                </div>   
                            </div>
                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label >Nombre del indicador </label>
                                    <input type="text" class="form-control" name="indi_desc" id="indi_desc" placeholder="Digitar nombre del indicador" value="{{Trim($regindicador->indi_desc)}}" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label >Fórmula del indicador </label>
                                    <input type="text" class="form-control" name="indi_formula" id="indi_formula" placeholder="Digitar la fórmula del indicador" value="{{trim($regindicador->indi_formula)}}" required>
                                </div>
                            </div>
                            <div class="row">    
                                <div class="col-xs-4 form-group">
                                    <label >Clase de indicador </label>
                                    <select class="form-control m-bot15" name="iclase_id" id="iclase_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar clase de indicador </option>
                                        @foreach($regiclase as $clase)
                                            @if($clase->iclase_id == $regindicador->iclase_id)
                                                <option value="{{$clase->iclase_id}}" selected>{{$clase->iclase_desc}}</option>
                                            @else                                        
                                               <option value="{{$clase->iclase_id}}">{{$clase->iclase_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div> 
                            </div>
                            <div class="row">    
                                <div class="col-xs-4 form-group">
                                    <label >Tipo de indicador </label>
                                    <select class="form-control m-bot15" name="itipo_id" id="itipo_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar tipo de indicador </option>
                                        @foreach($regitipo as $tipo)
                                            @if($tipo->itipo_id == $regindicador->itipo_id)
                                                <option value="{{$tipo->itipo_id}}" selected>{{$tipo->itipo_desc}}</option>
                                            @else                                        
                                               <option value="{{$tipo->itipo_id}}">{{$tipo->itipo_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div> 
                            </div>
                            <div class="row">    
                                <div class="col-xs-4 form-group">
                                    <label >Dimensión de indicador </label>
                                    <select class="form-control m-bot15" name="idimension_id" id="idimension_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar dimensión del indicador </option>
                                        @foreach($regidimen as $dime)
                                            @if($dime->idimension_id == $regindicador->idimension_id)
                                                <option value="{{$dime->idimension_id}}" selected>{{$dime->idimension_desc}}</option>
                                            @else                                        
                                               <option value="{{$dime->idimension_id}}">{{$dime->idimension_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div> 
                            </div>                            
                            <div class="row">                                                                
                                <div class="col-xs-3 form-group">
                                    <label>Meta total </label>
                                    <input required autocomplete="off" id="indi_meta" name="indi_meta" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="meta total" value="{{$regindicador->indi_meta}}" required>
                                </div>
                            </div>                            

                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>enero meta </label>
                                    <input required autocomplete="off" id="indi_m01" name="indi_m01" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="enero meta" value="{{$regindicador->indi_m01}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>febrero meta </label>
                                    <input required autocomplete="off" id="indi_m02" name="indi_m02" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="febrero meta" value="{{$regindicador->indi_m02}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>marzo meta </label>
                                    <input required autocomplete="off" id="indi_m03" name="indi_m03" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="marzo meta" value="{{$regindicador->indi_m03}}" required>
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>abril meta </label>
                                    <input required autocomplete="off" id="indi_m04" name="indi_m04" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="abril meta" value="{{$regindicador->indi_m04}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>mayo meta </label>
                                    <input required autocomplete="off" id="indi_m05" name="indi_m05" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="mayo meta" value="{{$regindicador->indi_m05}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>junio meta </label>
                                    <input required autocomplete="off" id="indi_m06" name="indi_m06" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="junio meta" value="{{$regindicador->indi_m06}}" required>
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>julio meta </label>
                                    <input required autocomplete="off" id="indi_m07" name="indi_m07" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="julio meta" value="{{$regindicador->indi_m07}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>agosto meta </label>
                                    <input required autocomplete="off" id="indi_m08" name="indi_m08" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="agosto meta" value="{{$regindicador->indi_m08}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>septiembre meta </label>
                                    <input required autocomplete="off" id="indi_m09" name="indi_m09" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="septiembre meta" value="{{$regindicador->indi_m09}}" required>
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>octubre meta </label>
                                    <input required autocomplete="off" id="indi_m10" name="indi_m10" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="octubre meta" value="{{$regindicador->indi_m10}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>noviembre meta </label>
                                    <input required autocomplete="off" id="indi_m11" name="indi_m11" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="noviembre meta" value="{{$regindicador->indi_m11}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>diciembre meta </label>
                                    <input required autocomplete="off" id="indi_m12" name="indi_m12" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="diciembre meta" value="{{$regindicador->indi_m12}}" required>
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
                                    <a href="{{route('verindimetas')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
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
    {!! JsValidator::formRequest('App\Http\Requests\indimetasRequest','#actualizarindimetas') !!}
@endsection

@section('javascrpt')
@endsection
