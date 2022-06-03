@extends('sicinar.principal')

@section('title','Indicador metas')

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
                <small>10.1 Indicador metas -</small> 
                <small> Nuevo</small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b10.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp;Indicador metas </li> 
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
                        {!! Form::open(['route' => 'altanuevoindimetas', 'method' => 'POST','id' => 'nuevoindimetas', 'enctype' => 'multipart/form-data']) !!}
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
                                <div class="col-xs-12 form-group">
                                    <label >Nombre del indicador </label>
                                    <input type="text" class="form-control" name="indi_desc" id="indi_desc" placeholder="Digitar nombre del indicador" value="" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label >Fórmula del indicador </label>
                                    <input type="text" class="form-control" name="indi_formula" id="indi_formula" placeholder="Digitar la fórmula del indicador" value="" required>
                                </div>
                            </div>
                            <div class="row">                     
                                <div class="col-xs-4 form-group">
                                    <label >Clase de indicador </label>
                                    <select class="form-control m-bot15" name="iclase_id" id="iclase_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar Clase de indicador </option>
                                        @foreach($regiclase as $clase)
                                            <option value="{{$clase->iclase_id}}">{{$clase->iclase_id.' '.trim($clase->iclase_desc)}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>                                                               
                            </div>
                            <div class="row">                     
                                <div class="col-xs-4 form-group">
                                    <label >Tipo de indicador </label>
                                    <select class="form-control m-bot15" name="itipo_id" id="itipo_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar Tipo de indicador </option>
                                        @foreach($regitipo as $tipo)
                                            <option value="{{$tipo->itipo_id}}">{{$tipo->itipo_id.' '.trim($tipo->itipo_desc)}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>                                                               
                            </div>
                            <div class="row">                     
                                <div class="col-xs-4 form-group">
                                    <label >Dimensión del indicador </label>
                                    <select class="form-control m-bot15" name="idimension_id" id="idimension_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar Dimensión del indicador </option>
                                        @foreach($regidimen as $dimen)
                                            <option value="{{$dimen->idimension_id}}">{{$dimen->idimension_id.' '.trim($dimen->idimension_desc)}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>                                                               
                            </div>                            
                            <div class="row">                                                                
                                <div class="col-xs-3 form-group">
                                    <label> Meta total </label>
                                    <input required autocomplete="off" id="indi_meta" name="indi_meta" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ total del presupuesto meta" value="0">
                                </div>
                            </div>                            

                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>$ enero meta </label>
                                    <input required autocomplete="off" id="indi_m01" name="indi_m01" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ enero meta" value="0">
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ febrero meta </label>
                                    <input required autocomplete="off" id="indi_m02" name="indi_m02" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ febrero meta" value="0">
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ marzo meta </label>
                                    <input required autocomplete="off" id="indi_m03" name="indi_m03" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ marzo meta" value="0">
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>$ abril meta </label>
                                    <input required autocomplete="off" id="indi_m04" name="indi_m04" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ abril meta" value="0">
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ mayo meta </label>
                                    <input required autocomplete="off" id="indi_m05" name="indi_m05" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ mayo meta" value="0">
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ junio meta </label>
                                    <input required autocomplete="off" id="indi_m06" name="indi_m06" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ junio meta" value="0">
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>$ julio meta </label>
                                    <input required autocomplete="off" id="indi_m07" name="indi_m07" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ julio meta" value="0">
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ agosto meta </label>
                                    <input required autocomplete="off" id="indi_m08" name="indi_m08" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ agosto meta" value="0">
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ septiembre meta </label>
                                    <input required autocomplete="off" id="indi_m09" name="indi_m09" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ septiembre meta" value="0">
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>$ octubre meta </label>
                                    <input required autocomplete="off" id="indi_m10" name="indi_m10" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ octubre meta" value="0">
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ noviembre meta </label>
                                    <input required autocomplete="off" id="indi_m11" name="indi_m11" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ noviembre meta" value="0">
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ diciembre meta </label>
                                    <input required autocomplete="off" id="indi_m12" name="indi_m12" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ diciembre meta" value="0">
                                </div>
                            </div> 

                            <div class="row">
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
    {!! JsValidator::formRequest('App\Http\Requests\indimetasRequest','#nuevoindimetas') !!}
@endsection

@section('javascrpt')
@endsection
