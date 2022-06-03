@extends('sicinar.principal')

@section('title','Ver Objetivo del programa y/o acción')

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
                <small> 3. Objetivo - </small>
                <small> Seleccionar para editar o registrar nuevo</small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b3.jpg') }}" border="0" width="30" height="30">Objetivo</li> 
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <p align="justify"><b style="color:red;">
                            Instrucciones:</b> <b style="color:green;">
                            Requisitar los datos generales del programa y/o acción, Objetivo general, Objetivos particulares, 
                            Población universo de atención, Cobertura: Federal, Estatal, Municipal..., 
                            Requisitos y criterios de selección para ser beneficiario, Documentos a presentar por el solicitante, 
                            Criterios de priorización, Zonas de atención, 
                            sectores a los que se apoya, su operación/ejecución, alineación con los Objetivos del Desarrollo Sostenible (ODS), 
                            con el Programa de Desarrollo del Estado de México (PDEM) en sus pilares temáticos y ejes trasnversales. 
                            Este apartado se deberá de requisitar periodicamente de forma anual; esto es cada ejercio fiscal.
                            </b>
                        </p>       
                        <div class="page-header" style="text-align:right;">
                            @if(session()->get('rango') == '4')                                        
                                {{ Form::open(['route' => 'buscarobjprog', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                                    <div class="form-group">
                                        {{ Form::text('idd', null, ['class' => 'form-control', 'placeholder' => 'id programa']) }}
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-default">
                                            <span class="glyphicon glyphicon-search"></span>
                                        </button>
                                    </div>
                                    <div class="form-group">
                                        <a href="{{route('nuevoobjprog')}}" class="btn btn-primary btn_xs" title="Nuevo objetivo-programa"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span>Nuevo objetivo-programa </a>
                                    </div>                                
                                {{ Form::close() }}
                            @else
                                <div class="form-group">
                                    <a href="{{route('nuevoobjprog')}}" class="btn btn-primary btn_xs" title="Nuevo objetivo-programa"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span>Nuevo objetivo-programa </a>
                                </div>                                                            
                            @endif
                        </div>

                        <div class="box-body">
                            <table id="tabla1" class="table table-hover table-striped">
                                <thead style="color: brown;" class="justify">
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;">Periodo </th>                                        
                                        <th style="text-align:left;   vertical-align: middle;">Id. programa y/o acción </th>
                                        <th style="text-align:left;   vertical-align: middle;">Objetivo(s)  </th>
                                        <th style="text-align:left;   vertical-align: middle;">Zonas de atención  </th>     
                                        <th style="text-align:center; vertical-align: middle; width:100px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($regobjprog as $obj)
                                    <tr>
                                        <td style="text-align:left; vertical-align: middle;">{{$obj->periodo_id}}     </td>
                                        <td style="text-align:left; vertical-align: middle;">
                                            {{$obj->prog_id}}
                                            @foreach($regprograma as $program)
                                                @if($program->prog_id == $obj->prog_id)
                                                    {{Trim($program->prog_desc)}}
                                                    @break
                                                @endif
                                            @endforeach
                                        </td>
                                        <td style="text-align:left; vertical-align: middle;">{{Trim($obj->obj_prog)}} </td>
                                        <td style="text-align:left; vertical-align: middle;">{{Trim($obj->obj_zona_aten)}}</td>
                                                                                
                                        <td style="text-align:center;">
                                            <a href="{{route('editarobjprog',array($obj->periodo_id,$obj->prog_id))}}" class="btn badge-warning" title="Editar Objetivo"><i class="fa fa-edit"></i></a>
                                            @if(session()->get('rango') == '4')
                                                <a href="{{route('borrarobjprog',array($obj->periodo_id,$obj->prog_id))}}" class="btn badge-danger" title="Borrar programa" onclick="return confirm('¿Seguro que desea borrar el objetivo-programa ?')"><i class="fa fa-times"></i></a>
                                            @endif                                            
                                        </td>                                                                                
                                    </tr>
                                        @if(session()->get('rango') == '0')
                                        <tr>
                                            <td style="text-align:left; rowspan=2;">
                                                <a href="{{route('verdepprog')}}">                                        
                                                <img src="{{ asset('images/b2.jpg') }}"   border="0" width="30" height="30" title="2. Datos de la dependencia">
                                                <img src="{{ asset('images/fant.jpg') }}" border="0" width="30" height="30" title="Anterior apartado">
                                                </a>                                            
                                            </td>
                                            <td style="text-align:left;"></td>
                                            <td style="text-align:center;"></td>
                                            <td style="text-align:center;"></td>
                                            <td style="text-align:right; ">
                                                <a href="{{route('verproyectop')}}">                                        
                                                <img src="{{ asset('images/fsig.jpg') }}" border="0" width="30" height="30" title="Siguiente apartado">
                                                <img src="{{ asset('images/b4.jpg') }}"   border="0" width="30" height="30" title="4. Proyecto presupuestal">
                                                </a>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $regobjprog->appends(request()->input())->links() !!}
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