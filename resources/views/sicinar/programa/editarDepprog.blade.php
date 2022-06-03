@extends('sicinar.principal')

@section('title','Editar programa - dep.')

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
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <div class="content-wrapper">
        <section class="content-header">
            <h1><i class="fa fa-dashboard"></i>&nbsp;&nbsp;Menú.
                <small>Ficha del programa -</small>
                <small>2. Datos de la dependencia -</small>
                <small>Editar </small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b2.jpg') }}" border="0" width="30" height="30">Datos dependencia</li> 
            </ol>            
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <p align="justify"><b style="color:red;">
                            Instrucciones:</b> <b style="color:green;">
                            Requisitar los datos del programa - dependencia y/o organismo auxiliar
                            </b>
                        </p>                                            
                        {!! Form::open(['route' => ['actualizardepprog',$regdepprogs->prog_id], 'method' => 'PUT', 'id' => 'actualizardepprog', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="row">    
                                <div class="col-xs-10 form-group">
                                    <input type="hidden" id="prog_id" name="prog_id" value="{{$regdepprogs->prog_id}}">                                  
                                    <label >Programa: </label><br>
                                    <td style="text-align:left; vertical-align: middle;">   
                                        {{$regdepprogs->prog_id}}
                                        @foreach($regprograma as $programa)
                                            @if($programa->prog_id == $regdepprogs->prog_id)
                                                    {{Trim($programa->prog_desc)}}
                                                    @break
                                            @endif
                                        @endforeach
                                    </td>                                     
                                </div> 
                            </div>

                            <div class="row">    
                                <div class="col-xs-12 form-group">
                                    <label >Dependencia y/o organismo auxiliar </label>
                                    <select class="form-control m-bot15" name="depen_id1" id="depen_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar </option>
                                        @foreach($regdepen as $depen)
                                            @if($depen->depen_id == $regdepprogs->depen_id1)
                                                <option value="{{$depen->depen_id}}" selected>{{trim($depen->depen_id).' '.substr(trim($depen->depen_desc),0,80)}}</option>
                                            @else                                        
                                               <option value="{{$depen->depen_id}}">{{trim($depen->depen_id).' '.substr(trim($depen->depen_desc),0,80)}} </option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>   
                            </div>

                            <div class="row">                                    
                                <div class="col-xs-12 form-group">
                                    <label >Unidad admon. responsable del operar el programa y/o acción </label>
                                    <select class="form-control m-bot15" name="depen_id2" id="depen_id2" required>
                                        <option selected="true" disabled="disabled">Seleccionar mes de ingreso </option>
                                        @foreach($regdepen as $depen2)
                                            @if($depen2->depen_id == $regdepprogs->depen_id2)
                                                <option value="{{$depen2->depen_id}}" selected>{{trim($depen2->depen_id).' '.substr(trim($depen2->depen_desc),0,80)}}</option>
                                            @else                                        
                                               <option value="{{$depen2->depen_id}}">{{trim($depen2->depen_id).' '.substr(trim($depen2->depen_desc),0,80)}} </option>
                                            @endif
                                        @endforeach
                                    </select>                                    
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
                                    <a href="{{route('verdepprog')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
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
    {!! JsValidator::formRequest('App\Http\Requests\depenprogsRequest','#actualizardepprog') !!}
@endsection

@section('javascrpt')
@endsection


