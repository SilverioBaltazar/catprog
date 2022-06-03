@extends('sicinar.principal')

@section('title','Editar cuestionario de diagnóstico archivo digital PDF')

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
                <small>Ficha del programa -</small> 
                <small>11. Diagnóstico -</small> 
                <small> Editar</small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b11.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp;Diagnóstico </li> 
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <p align="justify"><b style="color:red;">
                            Instrucciones:</b> <b style="color:green;">
                            Requisitar el cuestionario de diagnóstico del programa y/o acción.
                            Este apartado se deberá de requisitar periodicamente de forma anual; esto es cada ejercio fiscal.
                            </b>
                        </p>                    
                        {!! Form::open(['route' => ['actualizardiagnostico1',$regdiagnostico->periodo_id,$regdiagnostico->prog_id,$regdiagnostico->preg_id], 'method' => 'PUT', 'id' => 'actualizardiagnostico1', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <input type="hidden" name="periodo_id" id="periodo_id" value="{{$regdiagnostico->periodo_id}}">  
                                    <input type="hidden" name="prog_id"    id="prog_id"    value="{{$regdiagnostico->prog_id}}">
                                    <input type="hidden" name="preg_id"    id="preg_id"    value="{{$regdiagnostico->preg_id}}">
                                    <label style="color:green;">Periodo fiscal: </label>
                                    &nbsp;&nbsp;{{$regdiagnostico->periodo_id}} 
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                                    
                                    <label style="color:green;">Programa y/o acción: </label>
                                        &nbsp;&nbsp;{{$regdiagnostico->prog_id}}
                                        @foreach($regprogramas as $program)
                                                @if($program->prog_id == $regdiagnostico->prog_id)
                                                    {{Trim($program->prog_desc)}}
                                                    @break
                                                @endif
                                        @endforeach                  
                                    <br>
                                    <label style="color:green;">Pregunta de diagnóstico: </label>
                                    {{$regdiagnostico->preg_desc}}
                                </div>   
                            </div>

                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label style="background-color:yellow;color:red"><b>Nota importante:</b>&nbsp;&nbsp;El archivo digital PDF, NO deberá ser mayor a 2,500 kBytes en tamaño.  </label>
                                </div>   
                            </div>  
                            @if (!empty($regdiagnostico->preg_arc)||!is_null($regdiagnostico->preg_arc)) 
                                <div class="row">               
                                    <div class="col-xs-6 form-group">
                                        <label >Archivo de digital en formato PDF </label><br>
                                        <label ><a href="/storage/{{$regdiagnostico->preg_arc}}" class="btn btn-danger" title="Archivo digital en formato PDF"><i class="fa fa-file-pdf-o"></i>PDF
                                        </a>&nbsp;&nbsp;&nbsp;{{$regdiagnostico->preg_arc}}
                                        </label>
                                    </div>   
                                    <div class="col-xs-6 form-group">                                        
                                        <label>
                                        <iframe width="400" height="400" src="{{ asset('storage/'.$regdiagnostico->preg_arc)}}" frameborder="0"></iframe> 
                                        </label>                                       
                                    </div>                                    
                                </div>
                                <div class="row">               
                                    <div class="col-xs-6 form-group">
                                        <label >Actualizar archivo digital en formato PDF </label>
                                        <input type="file" class="text-md-center" style="color:red" name="preg_arc" id="preg_arc" placeholder="Subir archivo digital en formato PDF " >
                                    </div>      
                                </div>
                            @else     <!-- se captura archivo 1 -->
                                <div class="row">               
                                    <div class="col-xs-6 form-group">
                                        <label >Archivo digital en formato PDF</label>
                                        <input type="file" class="text-md-center" style="color:red" name="preg_arc" id="preg_arc" placeholder="Subir archivo digital en formato PDF" >
                                    </div>                      
                                </div>                          
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
                                    {!! Form::submit('Guardar',['class' => 'btn btn-success btn-flat pull-right']) !!}
                                    <a href="{{route('verdiagnostico')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
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
        {!! JsValidator::formRequest('App\Http\Requests\diagnostico1Request','#actualizardiagnostico1') !!}
@endsection

@section('javascrpt')
@endsection
