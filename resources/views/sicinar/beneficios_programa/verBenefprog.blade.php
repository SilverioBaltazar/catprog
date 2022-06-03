@extends('sicinar.principal')

@section('title','Ver cursos')

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
                <small>5. Beneficios -</small> 
                <small>Seleccionar para editar o registrar nuevo</small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b5.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp;Beneficios </li> 
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <p align="justify"><b style="color:red;">
                            Instrucciones:</b> <b style="color:green;">
                            Requisitar los beneficios otorgados en el programa y/o acción.
                            Este apartado se deberá de requisitar periodicamente de forma anual; esto es cada ejercio fiscal.
                            </b>
                        </p>       
                        <div class="page-header" style="text-align:right;">
                            @if(session()->get('rango') == '4')                                        
                                {{ Form::open(['route' => 'buscarbenefprog', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                                    <div class="form-group">
                                        {{ Form::text('idd', null, ['class' => 'form-control', 'placeholder' => 'id programa']) }}
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-default">
                                            <span class="glyphicon glyphicon-search"></span>
                                        </button>
                                    </div>
                                    <div class="box-header" style="text-align:right;">
                                        <a href="{{route('nuevobenefprog')}}" class="btn btn-primary btn_xs" title="Nuevo beneficio"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span>Nuevo beneficio </a> 
                                    </div>
                                {{ Form::close() }}
                            @else
                                <div class="box-header" style="text-align:right;">
                                    <a href="{{route('nuevobenefprog')}}" class="btn btn-primary btn_xs" title="Nuevo beneficio"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span>Nuevo beneficio </a> 
                                </div>              
                            @endif
                        </div>

                        <div class="box-body">
                            <table id="tabla1" class="table table-striped table-bordered table-sm">
                                <thead style="color: brown;" class="justify">
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;">Periodo <br>Fiscal   </th>
                                        <th style="text-align:left;   vertical-align: middle;">Programa y/o acción  </th>
                                        <th style="text-align:left;   vertical-align: middle;">Beneficio            </th>
                                        <th style="text-align:left;   vertical-align: middle;">Descripción del Beneficio</th>
                                        <th style="text-align:left;   vertical-align: middle;">Periodicidad         </th>
                                        <th style="text-align:center; vertical-align: middle;">$ Costo <br>Unitario </th>
                                        <th style="text-align:center; vertical-align: middle; width:100px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($regbenefprog as $ben)
                                    <tr>
                                        <td style="text-align:left; vertical-align: middle;">{{$ben->periodo_id}} </td>
                                        <td style="text-align:left; vertical-align: middle;">{{$ben->prog_id}}
                                        @foreach($regprogramas as $program)
                                            @if($program->prog_id == $ben->prog_id)
                                                {{Trim($program->prog_desc)}}
                                                @break
                                            @endif
                                        @endforeach                                        
                                        </td>
                                        <td style="text-align:left; vertical-align: middle;">
                                        {{$ben->benef_id}}
                                        @foreach($regbeneficios as $benef)
                                            @if($benef->benef_id == $ben->benef_id)
                                                {{Trim($benef->benef_desc)}}
                                                @break
                                            @endif
                                        @endforeach                                                                        
                                        </td>
                                        <td style="text-align:left; vertical-align: middle;">{{Trim($ben->benef_desc)}}</td>
                                        <td style="text-align:left; vertical-align: middle;">{{$ben->periodici_id.' '.Trim($ben->periodici_desc)}}</td>
                                        <td style="text-align:left; vertical-align: middle;">{{number_format($ben->benef_costounit,2)}}  </td>
                                        <td style="text-align:center;">
                                            <a href="{{route('editarbenefprog',array($ben->periodo_id,$ben->prog_id,$ben->benef_id) )}}" class="btn badge-warning" title="Editar"><i class="fa fa-edit"></i></a>
                                            @if(session()->get('rango') == '4')
                                                <a href="{{route('borrarproyectop',array($ben->periodo_id,$ben->prog_id,$ben->benef_id) )}}" class="btn badge-danger" title="Eliminar beneficio del programa" onclick="return confirm('¿Seguro que desea eliminar beneficio del programa?')"><i class="fa fa-times"></i></a>
                                            @endif    
                                        </td> 
                                    </tr>
                                    @if(session()->get('rango') == '0')
                                        <tr>
                                            <td style="text-align:left; rowspan=2;">
                                                <a href="{{route('verproyectop')}}">                                        
                                                <img src="{{ asset('images/b4.jpg') }}"   border="0" width="30" height="30" title="4. Proyecto presupuestal">
                                                </a>                                            
                                            </td>
                                            <td style="text-align:left;">
                                                <a href="{{route('verproyectop')}}">                                        
                                                <img src="{{ asset('images/fant.jpg') }}" border="0" width="30" height="30" title="Anterior apartado">
                                                </a>                                                                              
                                            </td>
                                            <td style="text-align:center;"></td>
                                            <td style="text-align:center;"></td>
                                            <td style="text-align:center;"></td>
                                            <td style="text-align:right;"></td>
                                            <td style="text-align:right; ">
                                                <a href="{{route('verfinanmetas')}}">                                        
                                                <img src="{{ asset('images/fsig.jpg') }}" border="0" width="30" height="30" title="Siguiente apartado">
                                                <img src="{{ asset('images/b6.jpg') }}"   border="0" width="30" height="30" title="6. Financiamiento">
                                                </a>
                                            </td>
                                        </tr>
                                    @endif

                                    @endforeach
                                </tbody>
                            </table>
                            {!! $regbenefprog->appends(request()->input())->links() !!}
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
