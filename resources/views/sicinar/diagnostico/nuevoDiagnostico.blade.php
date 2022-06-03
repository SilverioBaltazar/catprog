@extends('sicinar.principal')

@section('title','Listado de nuevos artículos en la cédula')

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
    <meta charset="utf-8">
    <div class="content-wrapper">
        <section class="content-header">
            <h1><i class="fa fa-dashboard"></i>&nbsp;&nbsp;Menú.
                <small>Ficha del programa -</small> 
                <small>11. Diagnóstico -</small> 
                <small>Nuevo</small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b11.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp;Diagnóstico </li> 
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">

                    {!! Form::open(['route' => 'altanuevodiagnostico', 'method' => 'POST','id' => 'nuevodiagnostico', 'enctype' => 'multipart/form-data']) !!}
                    <div class="box box-success">
                        <p align="justify"><b style="color:red;">
                            Instrucciones:</b> <b style="color:green;">
                            Requisitar el cuestionario de diagnóstico del programa y/o acción.
                            Este apartado se deberá de requisitar periodicamente de forma anual; esto es cada ejercio fiscal.
                            </b>
                        </p>       
                        
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
                        </div>
                    </div>

                    <table id="tabla1" class="table table-hover table-striped">
                        <tr>
                            <th style="color:green;text-align:left; vertical-align: middle;">Pregunta    </th>
                            <th style="color:green;text-align:left; vertical-align: middle;">Link, URL o dirección electrónica</th>
                        </tr>
                        @foreach($regpreguntas as $arti)
                            <tr>
                                <td style="text-align:justify;vertical-align:middle; width:50px;">
                                    <input type="hidden" id="preg_id[]"   name="preg_id[]"   value="{{$arti->preg_id}}">  
                                    <input type="hidden" id="preg_desc[]" name="preg_desc[]" value="{{$arti->preg_desc}}">  
                                    <b style="color: gray;font-size:11px;">{{trim($arti->preg_desc)}}</b>
                                </td>
                            
                                <td style="text-align:justify;vertical-align:middle; width:50px; color:yellow;font-size:10px;" > 
                                    <input type="text" class="form-control" name="preg_url[]" id="preg_url[]" placeholder="Link o dirección electrónica" required>
                                </td>                                  
                            </tr>
                        @endforeach
                    </table>

                    <div class="row">
                            <div class="col-md-12 offset-md-5">
                                {!! Form::submit('Registrar',['class' => 'btn btn-success btn-flat pull-right']) !!}
                                <a href="{{route('verdiagnostico')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
                            </div>                                
                    </div>        

                    {!! Form::close() !!}
                </div>
            </div>
        </section>
    </div>
@endsection

@section('request')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\diagnosticopregsRequest','#nuevodiagnostico') !!}
@endsection

@section('javascrpt')
@endsection
