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
                        {!! Form::open(['route' => ['actualizarfinanpres',$regfinanpres->periodo_id, $regfinanpres->prog_id], 'method' => 'PUT', 'id' => 'actualizarfinanpres', 'enctype' => 'multipart/form-data']) !!}
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
                                    <label >Clave o código de proyecto conforme a la estructura programática de la contabilidad gubernamental  </label>
                                    <select class="form-control m-bot15" name="proy_id" id="proy_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar clave o código de proyecto </option>
                                        @foreach($regproyectos as $proyecto)
                                            @if($proyecto->proy_id == $regfinanpres->proy_id)
                                                <option value="{{$proyecto->proy_id}}" selected>{{$proyecto->proy_id.' '.trim($proyecto->proy_desc)}}</option>
                                            @else                                        
                                               <option value="{{$proyecto->proy_id}}">{{$proyecto->proy_id.' '.trim($proyecto->proy_desc)}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div> 
                            </div>
           
                            @if(!empty($regfinanpres->finan_arc1)||(!is_null($regfinanpres->finan_arc1)))
                                <div class="row">               
                                    <div class="col-xs-6 form-group">                            
                                        <label >Archivo digital de Oficio y Expediente técnico Anexo 1 en formato PDF </label><br>
                                        <a href="/images/{{$regfinanpres->finan_arc1}}" class="btn btn-danger" title="Archivo digital de Oficio y Expediente técnico Anexo 1 en formato PDF"><i class="fa fa-file-pdf-o"></i><small>PDF</small>
                                        </a>{{$regfinanpres->finan_arc1}}
                                    </div>
                                    <div class="col-xs-6 form-group">                                        
                                        <label>
                                        <iframe width="400" height="400" src="{{ asset('images/'.$regfinanpres->finan_arc1) }}" frameborder="0"></iframe> 
                                        </label>                                       
                                    </div>
                                </div>                                        
                            @else
                                <div class="row">               
                                    <div class="col-xs-6 form-group">
                                        <label >Archivo digital de Oficio y Expediente técnico Anexo 1 en formato PDF </label><br>
                                        <b style="color:darkred;">** Pendiente **</b>
                                    </div>
                                </div>
                            @endif

                            @if(!empty($regfinanpres->finan_arc2)||(!is_null($regfinanpres->finan_arc2)))
                                <div class="row">               
                                    <div class="col-xs-6 form-group">                                                        
                                        <label >Archivo digital de Matriz Marco Lógico MML en formato PDF </label><br>
                                        <a href="/images/{{$regfinanpres->finan_arc2}}" class="btn btn-danger" title="Archivo digital de Matriz Marco Lógico MML en formato PDF"><i class="fa fa-file-pdf-o"></i><small>PDF</small>
                                        </a>{{$regfinanpres->finan_arc2}}
                                    </div>
                                    <div class="col-xs-6 form-group">                                        
                                        <label>
                                        <iframe width="400" height="400" src="{{ asset('images/'.$regfinanpres->finan_arc2) }}" frameborder="0"></iframe> 
                                        </label>                                       
                                    </div>                                    
                                </div>
                            @else
                                <div class="row">               
                                    <div class="col-xs-6 form-group">                            
                                        <label >Archivo digital de Matriz Marco Lógico MML en formato PDF </label><br>
                                        <b style="color:darkred;">** Pendiente **</b>
                                        <input type="hidden" name="doc_id8" id="doc_id8" value="14">
                                    </div>
                                </div>
                            @endif
                                </div>  
                            </div>

                            @if(!empty($regfinanpres->finan_arc3)||(!is_null($regfinanpres->finan_arc3)))
                                <div class="row">               
                                    <div class="col-xs-6 form-group">                                                        
                                        <label >Archivo digital de Acta de última sesión de seguimiento al prog. en formato PDF </label><br>
                                        <a href="/images/{{$regfinanpres->finan_arc3}}" class="btn btn-danger" title="Archivo digital de Acta de última sesión de seguimiento al prog. en formato PDF"><i class="fa fa-file-pdf-o"></i><small>PDF</small>
                                        </a>{{$regfinanpres->finan_arc3}}
                                    </div>
                                    <div class="col-xs-6 form-group">                                        
                                        <label>
                                        <iframe width="400" height="400" src="{{ asset('images/'.$regfinanpres->finan_arc3) }}" frameborder="0"></iframe> 
                                        </label>                                       
                                    </div>
                                </div>
                            @else
                                <div class="row">               
                                    <div class="col-xs-6 form-group">                                                        
                                        <label >Archivo digital de Acta de última sesión de seguimiento al prog. en formato PDF </label><br>
                                        <b style="color:darkred;">** Pendiente **</b>
                                    </div>
                                </div>
                            @endif

                            <div class="row">                                
                                <div class="col-xs-12 form-group">
                                    <label >Observaciones (2,000 carácteres)</label>
                                    <textarea class="form-control" name="finan_obs1" id="finan_obs" rows="3" cols="120" placeholder="Observaciones (2,000 carácteres)" required>{{Trim($regfinanpres->finan_obs1)}}
                                    </textarea>
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
                                    <a href="{{route('verfinanpres')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar
                                    </a>
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
    {!! JsValidator::formRequest('App\Http\Requests\finanpresRequest','#actualizarfinanpres') !!}
@endsection

@section('javascrpt')
@endsection
