@extends('sicinar.principal')

@section('title','Ver programa')

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
                <small>1. Programa -</small> 
                <small>Seleccionar para editar o registrar nuevo</small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b1.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp;Programa</li> 
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <p align="justify"><b style="color:red;">
                            Instrucciones:</b> <b style="color:green;">
                            Requisitar los datos oficiales del programa y/o acción tal como aparece en las Reglas de operación publicadas 
                            en Gaceta de Gobierno. 
                            </b>
                        </p>                                            

                        <div class="page-header" style="text-align:right;">
                            @if(session()->get('rango') == '4')                                        
                                {{ Form::open(['route' => 'buscarprog', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                                    <div class="form-group">
                                        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Programa']) }}
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-default">
                                            <span class="glyphicon glyphicon-search"></span>
                                        </button>
                                    </div>
                                    <div class="box-header" style="text-align:right;">
                                    <a href="{{route('exportprogexcel')}}" class="btn btn-success" title="Exportar catálogo de programas a formato Excel"><i class="fa fa-file-excel-o"></i> Excel  </a> 
                                    <a href="{{route('nuevoprog')}}" class="btn btn-primary btn_xs" title="Nuevo Programa"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span>Nuevo programa </a>
                                    </div>
                                {{ Form::close() }}
                            @endif
                        </div>

                        <div class="box-body">
                            <table id="tabla1" class="table table-hover table-striped">
                                <thead style="color: brown;" class="justify">
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;">Id.      </th>
                                        <th style="text-align:left;   vertical-align: middle;">Programa y/o acción  </th>
                                        <th style="text-align:left;   vertical-align: middle;">Vertiente </th>
                                        <th style="text-align:left;   vertical-align: middle;">Siglas   </th>     
                                        <th style="text-align:left;   vertical-align: middle;">Tipo     </th>     
                                        <th style="text-align:center; vertical-align: middle;">Activa <br>Inact.</th>
                                        
                                        <th style="text-align:center; vertical-align: middle; width:100px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($regprog as $programa)
                                    <tr>
                                        <td style="tfont-family:'Arial, Helvetica, sans-serif'; font-size:11px; text-align:left; vertical-align: middle;">{{$programa->prog_id}}        
                                        </td>
                                        <td style="tfont-family:'Arial, Helvetica, sans-serif'; font-size:11px; text-align:left; vertical-align: middle;">{{Trim($programa->prog_desc)}}
                                        </td>
                                        <td style="tfont-family:'Arial, Helvetica, sans-serif'; font-size:11px; text-align:left; vertical-align: middle;">{{Trim($programa->prog_verti)}}
                                        </td>                                        
                                        <td style="tfont-family:'Arial, Helvetica, sans-serif'; font-size:11px; text-align:left; vertical-align: middle;">{{$programa->prog_siglas}}     
                                        </td>
                                        <td style="font-family:'Arial, Helvetica, sans-serif'; font-size:11px; text-align:left; vertical-align: middle;">{{$programa->prog_tipo}}     
                                        </td>                                                                                

                                        @if($programa->prog_status1 == 'S')
                                            <td style="font-family:'Arial, Helvetica, sans-serif'; font-size:10px; text-align:center; vertical-align: middle;" title="Activo"><i class="fa fa-check"></i>
                                            </td>                                            
                                        @else
                                            <td style="tfont-family:'Arial, Helvetica, sans-serif'; font-size:10px; text-align:center; vertical-align: middle;" title="Inactivo"><i class="fa fa-times"></i>
                                            </td>                                            
                                        @endif
                                        
                                        <td style="text-align:center;">
                                            <a href="{{route('editarprog',$programa->prog_id)}}" class="btn badge-warning" title="Editar programa"><i class="fa fa-edit"></i></a>
                                            @if(session()->get('rango') == '4')
                                                <a href="{{route('borrarprog',$programa->prog_id)}}" class="btn badge-danger" title="Borrar programa" onclick="return confirm('¿Seguro que desea borrar el programa ?')"><i class="fa fa-times"></i></a>
                                            @endif
                                        </td>                                                                                
                                    </tr>
                                        @if(session()->get('rango') == '0')
                                        <tr>
                                            <td style="text-align:left;"></td>
                                            <td style="text-align:left;"></td>
                                            <td style="text-align:center;"></td>
                                            <td style="text-align:center;"></td>
                                            <td style="text-align:right;"></td>  
                                            <td style="text-align:right;"></td>                                             
                                            <td style="text-align:right;">
                                                <a href="{{route('verdepprog')}}">                                        
                                                <img src="{{ asset('images/fsig.jpg') }}" border="0" width="30" height="30" title="Siguiente apartado">
                                                <img src="{{ asset('images/b2.jpg') }}"   border="0" width="30" height="30" title="2. Datos de la dependencia">
                                                </a>
                                            </td>
                                        </tr>
                                        @endif            

                                    @endforeach
                                </tbody>
                            </table>
                            {!! $regprog->appends(request()->input())->links() !!}
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
