@extends('sicinar.principal')

@section('title','Nuevo registro de financiamiento presupuestal del programa y/o acción')

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
    <div class="content-wrapper">
        <section class="content-header">
            <h1><i class="fa fa-dashboard"></i>&nbsp;&nbsp;Menú.
                <small>Ficha del programa - </small>
                <small> 4. Financiamiento - </small>
                <small> Nuevo</small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b4.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp;Financiamiento</li> 
            </ol>    
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <div class="box-header">
                            <h3 class="box-title"><p align="justify"><b style="color:red;">
                            Instrucciones:</b> <b style="color:green;">
                            El financiamiento presupuestal del programa y/o acción es obligatorio conforme al presupuesto de ingresos y egresos
                            del periodo correspondiente; Integrar los archivos digitales de: Oficio y Expediente técnico Anexo 1, 
                            Matriz Marco Lógico MML, Acta de última sesión de seguimiento al programa.... 
                            Este proceso se deberá de realizar periodicamente de forma anual.
                            Se requiere escanear a una resolución de 300 ppp en blanco y negro.
                            </b></p>
                            </h3>
                        </div>                    
                        {!! Form::open(['route' => 'altanuevofinanpres', 'method' => 'POST','id' => 'nuevofinanpres', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="row">                                
                                <div class="col-xs-8 form-group">
                                    <label >Periodo </label>
                                    <select class="form-control m-bot15" name="periodo_id" id="periodo_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar periodo </option>
                                        @foreach($regperiodos as $periodo)
                                            <option value="{{$periodo->periodo_id}}">{{$periodo->periodo_id.' '.$periodo->periodo_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>   
                            </div>     
                            <div class="row">                                
                                <div class="col-xs-8 form-group">
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
                                <div class="col-xs-8 form-group">
                                    <label >Clave o código de proyecto conforme a la estructura programática de la contabilidad gubernamental </label>
                                    <select class="form-control m-bot15" name="proy_id" id="proy_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar clave o código de proyecto </option>
                                        @foreach($regproyectos as $proyecto)
                                            <option value="{{$proyecto->proy_id}}">{{$proyecto->proy_id.' '.trim($proyecto->proy_desc)}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>   
                            </div>                                 
                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label style="background-color:yellow;color:red"><b>Nota importante:</b> Los archivos digitales PDF, NO deberán ser mayores a 1,500 kBytes en tamaño.  </label>
                                </div>   
                            </div>
                            <div class="row">               
                                <div class="col-xs-6 form-group">
                                    <label >Archivo digital de Oficio y Expediente técnico Anexo 1 en formato PDF </label>
                                    <input type="hidden" name="doc_id12" id="doc_id12" value="17">
                                    <input type="file" class="text-md-center" style="color:red" name="finan_arc1" id="finan_arc1" placeholder="Subir archivo digital de Oficio y Expediente técnico Anexo 1 en formato PDF">
                                </div>  
                            </div>

                            <div class="row">               
                                <div class="col-xs-6 form-group">
                                    <label >Archivo digital de Matriz Marco Lógico MML en formato PDF </label>
                                    <input type="hidden" name="doc_id13" id="doc_id13" value="18">
                                    <input type="file" class="text-md-center" style="color:red" name="finan_arc2" id="finan_arc2" placeholder="Subir archivo digital de Matriz Marco Lógico MML en el IFREM en formato PDF">
                                </div>   
                            </div>             

                            <div class="row">               
                                <div class="col-xs-6 form-group">
                                    <label >Archivo digital de Acta de última sesión de seguimiento al prog. en formato PDF </label>
                                    <input type="hidden" name="doc_id14" id="doc_id14" value="9">
                                    <input type="file" class="text-md-center" style="color:red" name="finan_arc3" id="finan_arc3" placeholder="Subir archivo digital de Acta de última sesión de seguimiento al prog. en formato PDF">
                                </div>   
                            </div> 
 
                             <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label >Observaciones del programa y/o acción (2,000 caracteres)</label>
                                    <textarea class="form-control" name="finan_obs1" id="finan_obs1" rows="3" cols="120" placeholder="Observaciones del programa y/o acción" required></textarea>
                                </div>                                
                            </div>

                            <div class="row">
                                <div class="col-md-12 offset-md-5">
                                    {!! Form::submit('Registrar',['class' => 'btn btn-success btn-flat pull-right']) !!}
                                    <a href="{{route('verfinanpres')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
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
    {!! JsValidator::formRequest('App\Http\Requests\finanpresRequest','#nuevofinanpres') !!} 
@endsection

@section('javascrpt')
@endsection
