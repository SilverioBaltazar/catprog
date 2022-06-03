@extends('sicinar.principal')

@section('title','Ver matriz de presupuesto')

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
                <small> Seleccionar para editar o registrar nuevo</small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b4.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp;Financiamiento-Matriz de Presupuesto</li> 
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">

                        <table id="tabla1" class="table table-hover table-striped">
                            @foreach($regfinanpres as $finan)
                            <tr>
                                <td style="text-align:left; vertical-align: middle;">   
                                </td>                                                                 
                                <td style="text-align:left; vertical-align: middle;">   
                                </td>
                                <td style="text-align:center; vertical-align: middle;"> 
                                </td>
                                <td style="text-align:right; vertical-align: middle;">   
                                    <a href="{{route('verfinanpres')}}" role="button" id="cancelar" class="btn btn-success"><small>Regresar a financiamiento</small>
                                    </a>
                                    <a href="{{route('nuevofinanpresd',array($finan->periodo_id,$finan->prog_id))}}" class="btn btn-primary btn_xs" title="Nuevo presupuesto del programa y/o acción"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span><small>Nuevo presupuesto</small>
                                    </a>
                                </td>                                     
                            </tr>                                                   
                            @endforeach                                 
                            @foreach($regfinandet as $matriz)                            
                            <tr>                            
                                <td style="text-align:left; vertical-align: middle; color:green;">   
                                    <input type="hidden" id="periodo_id" name="periodo_id" value="{{$matriz->periodo_id}}">  
                                    <label>Periodo: </label>{{$matriz->periodo_id}}
                                </td>                                                                 
                                <td style="text-align:center; vertical-align: middle; color:green;"> 
                                    <input type="hidden" id="prog_id" name="prog_id" value="{{$matriz->prog_id}}">  
                                    <label>Programa y/o acción: </label>
                                    {{$matriz->prog_id}}
                                    @foreach($regprogramas as $program)
                                        @if($program->prog_id == $matriz->prog_id)
                                            {{trim($program->osc_desc)}}
                                            @break
                                        @endif
                                    @endforeach
                                </td>
                            </tr>        
                            @endforeach     
                        </table>

                        <div class="box-body">
                            <table id="tabla1" class="table table-hover table-striped">
                                <thead style="color: brown;" class="justify">
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;">#      </th>
                                        <th style="text-align:left;   vertical-align: middle;">Periodo<br>Fiscal</th>
                                        <th style="text-align:left;   vertical-align: middle;">Fuente<br>Finan. </th>
                                        <th style="text-align:left;   vertical-align: middle;">Clasif.<br>Tipo gasto</th>
                                        <th style="text-align:left;   vertical-align: middle;">Clasif.<br>CONAC </th>
                                        <th style="text-align:left;   vertical-align: middle;">Sector<br>Subsector</th>
                                        <th style="text-align:left;   vertical-align: middle;">Total <br>Presup. $</th>
                                        <th style="text-align:left;   vertical-align: middle;">Porc. %           </th> 
                                        <th style="text-align:center; vertical-align: middle; width:100px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($regfinandet as $matriz)
                                    <tr>
                                        <td style="text-align:left; vertical-align: middle;">{{$matriz->det_npartida}}</td>                                        
                                        <td style="text-align:left; vertical-align: middle;">{{$matriz->periodo_id2}} </td>
                                        <td style="text-align:left; vertical-align: middle;">   
                                        {{$matriz->fuente_id}}                                        
                                        @foreach($regfuente as $fuente)
                                            @if($fuente->fuente_id == $matriz->fuente_id)
                                                {{trim($fuente->fuente_desc)}}
                                                @break                                        
                                            @endif
                                        @endforeach                               
                                        </td>
                                        <td style="text-align:left; vertical-align: middle;">   
                                        {{$matriz->ctgasto_id}}                                        
                                        @foreach($regtipogasto as $gasto)
                                            @if($gasto->ctgasto_id == $matriz->ctgasto_id)
                                                {{trim($gasto->ctgasto_desc)}}
                                                @break                                        
                                            @endif
                                        @endforeach                               
                                        </td>
                                        <td style="text-align:left; vertical-align: middle;">   
                                        {{$matriz->conac_id}}                                          
                                        @foreach($regconac as $conac)
                                            @if($conac->conac_id == $matriz->conac_id)
                                                {{trim($conac->conac_desc)}}
                                                @break                                        
                                            @endif
                                        @endforeach
                                        </td>    
                                        <td style="text-align:left; vertical-align: middle;">   
                                        {{$matriz->subsector_id}}                                          
                                        @foreach($regsubsector as $subsector)
                                            @if($subsector->subsector_id == $matriz->subsector_id)
                                                {{trim($subsector->sector_desc).' '.trim($subsector->subsector_desc)}}
                                                @break                                        
                                            @endif
                                        @endforeach
                                        </td>                                                                                                                    
                                        <td style="text-align:left; vertical-align: middle;">{{number_format($matriz->det_total,2)}}</td>
                                        <td style="text-align:left; vertical-align: middle;">{{number_format($matriz->det_porcen,0)}}</td>
                                        
                                        <td style="text-align:center;">
                                            <a href="{{route('editarfinanpresd',array($matriz->periodo_id,$matriz->prog_id,$matriz->det_npartida) )}}" class="btn badge-warning" title="Editar partida presupuestal"><i class="fa fa-edit"></i>
                                            </a>
                                            <a href="{{route('borrarfinanpresd',array($matriz->periodo_id,$matriz->prog_id,$matriz->det_npartida) )}}" class="btn badge-danger" title="Borrar partida presupuestal" onclick="return confirm('¿Seguro que desea borrar partida presupuestal?')"><i class="fa fa-times"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $regfinandet->appends(request()->input())->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('request')
@endsection

@section('javascrpt')
@endsection

