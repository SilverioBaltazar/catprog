@extends('sicinar.principal')

@section('title','Nueva actividad del programa de trabajo')

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
                <small>Ficha del programa - </small>
                <small> 4. Financiamiento - </small>
                <small> Nuevo</small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b4.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp;Financiamiento-Matriz de Presupuesto</li> 
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        
                        {!! Form::open(['route' => 'altanuevofinanpresd', 'method' => 'POST','id' => 'nuevofinanpresd', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">

                            <table id="tabla1" class="table table-hover table-striped">
                                <tr>
                                @foreach($regfinanpres as $finan)
                                    <td style="text-align:left; vertical-align: middle; color:green;">   
                                        <input type="hidden" id="periodo_id" name="periodo_id" value="{{$finan->periodo_id}}">
                                        <label>Periodo: </label>{{$finan->periodo_id}}                                        
                                    </td>
                                    <td style="text-align:center; vertical-align: middle; color:green;"> 
                                        <input type="hidden" id="prog_id" name="prog_id" value="{{$finan->prog_id}}">  
                                        <label>Programa y/o acción: </label>
                                        {{$finan->prog_id}}    
                                        @foreach($regprogramas as $program)
                                            @if($program->prog_id == $finan->prog_id)
                                                {{Trim($program->prog_desc)}}
                                                @break
                                            @endif
                                        @endforeach
                                    </td>
                                @endforeach     
                                </tr>      
                            </table>                      

                            <div class="row">
                                <div class="col-xs-6 form-group">
                                    <label >Periodo fiscal </label>
                                    <select class="form-control m-bot15" name="periodo_id2" id="periodo_id2" required>
                                        <option selected="true" disabled="disabled">Seleccionar periodo fiscal </option>
                                        @foreach($regperiodos as $periodo)
                                            <option value="{{$periodo->periodo_id}}">{{$periodo->periodo_desc}}</option>
                                        @endforeach
                                    </select>                                  
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 form-group">
                                    <label >Fuente de financiamiento presupuestal </label>
                                    <select class="form-control m-bot15" name="fuente_id" id="fuente_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar Fuente de financiamiento presupuestal </option>
                                        @foreach($regfuente as $fuente)
                                            <option value="{{$fuente->fuente_id}}">{{$fuente->fuente_id.' '.trim($fuente->fuente_desc)}}</option>
                                        @endforeach
                                    </select>                                  
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 form-group">
                                    <label >Clasificación del tipo de gasto </label>
                                    <select class="form-control m-bot15" name="ctgasto_id" id="ctgasto_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar Clasificación del tipo de gasto </option>
                                        @foreach($regtipogasto as $gasto)
                                            <option value="{{$gasto->ctgasto_id}}">{{$gasto->ctgasto_id.' '.trim($gasto->ctgasto_desc)}}</option>
                                        @endforeach
                                    </select>                                  
                                </div>
                            </div>   
                            <div class="row">
                                <div class="col-xs-6 form-group">
                                    <label >Clasificación CONAC </label>
                                    <select class="form-control m-bot15" name="conac_id" id="conac_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar Clasificación CONAC</option>
                                        @foreach($regconac as $conac)
                                            <option value="{{$conac->conac_id}}">{{$conac->conac_id.' '.trim($conac->conac_desc)}}</option>
                                        @endforeach
                                    </select>                                  
                                </div>
                            </div>   
                            <div class="row">
                                <div class="col-xs-8 form-group">
                                    <label >Subsector programático presupuestal </label>
                                    <select class="form-control m-bot15" name="subsector_id" id="subsector_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar Subsector programático presupuestal</option>
                                        @foreach($regsubsector as $subsector)
                                            <option value="{{$subsector->subsector_id}}">{{$subsector->subsector_id.' '.trim($subsector->sector_desc).'-'.trim($subsector->subsector_desc)}}</option>
                                        @endforeach
                                    </select>                                  
                                </div>
                            </div>   

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Presupuesto total anual asignado $ </label>
                                    <input type="number" min="0" max="999999999999.99" class="form-control" name="det_total" id="det_total" placeholder="Total del presupuesto anual" required>
                                </div> 
                                <div class="col-xs-4 form-group">
                                    <label >Porcentaje [1..100] % </label>
                                    <input type="number" min="0" max="999" class="form-control" name="det_porcen" id="det_porcen" placeholder="Porcentaje" required>
                                </div> 
                            </div>

                            <div class="row">
                                <div class="col-md-12 offset-md-5">
                                    {!! Form::submit('Registrar',['class' => 'btn btn-success btn-flat pull-right']) !!}
                                    @foreach($regfinanpres as $finan)
                                       <a href="{{route('verfinanpresd',array($finan->periodo_id,$finan->prog_id))}}" role="button" id="cancelar" class="btn btn-danger">Cancelar
                                       </a>
                                       @break
                                    @endforeach                                       
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
    {!! JsValidator::formRequest('App\Http\Requests\finanpresdetRequest','#nuevofinanpresd') !!}
@endsection

@section('javascrpt')
@endsection
