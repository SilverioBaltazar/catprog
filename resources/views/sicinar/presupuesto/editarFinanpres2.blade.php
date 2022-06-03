@extends('sicinar.principal')

@section('title','Editar financiamiento')

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
                <small> Editar</small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b4.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp;Financiamiento</li> 
            </ol>    
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <p align="justify"><b style="color:red;">
                            Instrucciones:</b> <b style="color:green;">
                            El financiamiento presupuestal del programa y/o acción es obligatorio conforme al presupuesto de ingresos y egresos
                            del periodo correspondiente; Integrar los archivos digitales de: Oficio y Expediente técnico Anexo 1, 
                            Matriz Marco Lógico MML, Acta de última sesión de seguimiento al programa.... 
                            Este proceso se deberá de realizar periodicamente de forma anual.
                            Se requiere escanear a una resolución de 300 ppp en blanco y negro.
                            </b>
                        </p>
                        {!! Form::open(['route' => ['actualizarfinanpres2',$regfinanpres->periodo_id, $regfinanpres->prog_id], 'method' => 'PUT', 'id' => 'actualizarfinanpres2', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="row">                            
                                <div class="col-xs-6 form-group" style="color:green;">
                                    <input type="hidden" name="periodo_id" id="periodo_id" value="{{$regfinanpres->periodo_id}}">                                
                                    <label>Periodo <br>
                                        {{$regfinanpres->periodo_id}}
                                    </label>
                                </div>              
                            </div>
                            <div class="row">                                                                                                         
                                <div class="col-xs-10 form-group">
                                    <input type="hidden" name="prog_id" id="prog_id" value="{{$regfinanpres->prog_id}}">
                                    <label>programa y/o acción &nbsp;&nbsp;&nbsp; </label><br>
                                    @foreach($regprogramas as $program)
                                        @if($program->prog_id == $regfinanpres->prog_id)
                                            <label style="color:green;">{{$regfinanpres->prog_id.' '.trim($program->prog_desc)}}</label>
                                            @break
                                        @endif
                                    @endforeach
                                </div>  
                            </div>

                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label style="background-color:yellow;color:red"><b>Nota importante:</b>&nbsp;&nbsp;El archivo digital PDF, NO deberá ser mayor a 1,500 kBytes en tamaño.  </label>
                                </div>   
                            </div>  
                            @if (!empty($regfinanpres->finan_arc2)||!is_null($regfinanpres->finan_arc2))   
                                <div class="row">
                                    <div class="col-xs-6 form-group">
                                        <label >Archivo digital de Matriz Marco Lógico MML en formato PDF </label><br>
                                        <label ><a href="/images/{{$regfinanpres->finan_arc2}}" class="btn btn-danger" title="Subir archivo digital de Matriz Marco Lógico MML en formato PDF "><i class="fa fa-file-pdf-o"></i>PDF
                                        </a>&nbsp;&nbsp;&nbsp;{{$regfinanpres->finan_arc2}}
                                        </label>
                                    </div>   
                                    <div class="col-xs-6 form-group">                                        
                                        <label>
                                        <iframe width="400" height="400" src="{{ asset('images/'.$regfinanpres->finan_arc2) }}" frameborder="0"></iframe> 
                                        </label>                                       
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-6 form-group">
                                        <label >Actualizar archivo digital de Matriz Marco Lógico MML en formato PDF </label>
                                        <input type="file" class="text-md-center" style="color:red" name="finan_arc2" id="finan_arc2" placeholder="Subir archivo digital de Matriz Marco Lógico MML en formato PDF " >
                                    </div>      
                                </div>
                            @else     <!-- se captura archivo 1 -->
                                <div class="row">
                                    <div class="col-xs-6 form-group">
                                        <label >Archivo digital de Matriz Marco Lógico MML en formato PDF</label>
                                        <input type="file" class="text-md-center" style="color:red" name="finan_arc2" id="finan_arc2" placeholder="Subir archivo digital de Matriz Marco Lógico MML en formato PDF " >
                                    </div>                                                
                                <div class="row">                                    
                            @endif 

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
    {!! JsValidator::formRequest('App\Http\Requests\finanpres2Request','#actualizarfinanpres2') !!}
@endsection

@section('javascrpt')
@endsection
