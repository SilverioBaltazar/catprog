@extends('sicinar.principal')

@section('title','Ver cuestionario de diagnóstico')

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
                <small>12. Directorio -</small> 
                <small>Seleccionar para editar o registrar nuevo</small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b12.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp;Directorio </li> 
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <p align="justify"><b style="color:red;">
                            Instrucciones:</b> <b style="color:green;">
                            Requisitar el directorio del programa y/o acción.
                            Este apartado se deberá de requisitar periodicamente de forma anual; esto es cada ejercio fiscal.
                            </b>
                        </p>       
                        <div class="page-header" style="text-align:right;">
                            @if(session()->get('rango') == '4')                                        
                                {{ Form::open(['route' => 'buscardirectorio', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                                    <div class="form-group">
                                        {{ Form::text('idd', null, ['class' => 'form-control', 'placeholder' => 'id programa']) }}
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-default">
                                            <span class="glyphicon glyphicon-search"></span>
                                        </button>
                                    </div>
                                    <div class="box-header" style="text-align:right;">
                                        <a href="{{route('nuevodirectorio')}}" class="btn btn-primary btn_xs" title="Generar directorio"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span>Nuevo directorio </a> 
                                    </div>
                                {{ Form::close() }}
                            @else
                                <div class="box-header" style="text-align:right;">
                                     <a href="{{route('nuevodirectorio')}}" class="btn btn-primary btn_xs" title="Generar directorio"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span>Nuevo directorio </a> 
                                </div>              
                            @endif
                        </div>

                        <div class="box-body">
                            <table id="tabla1" class="table table-striped table-bordered table-sm">
                                <thead style="color: brown;" class="justify">
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;font-size:11px;">Periodo   </th>
                                        <th style="text-align:left;   vertical-align: middle;">                         </th>
                                        <th colspan="04" style="text-align:center;vertical-align: middle;">Enlace institucional de padrones</th>
                                        <th style="text-align:center; vertical-align: middle; "></th>
                                    </tr>                                

                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Fiscal             </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Programa y/o acción</th>  
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Nombre   </th>  
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Cargo    </th>  
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">E-mail   </th>  
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Teléfono </th>  
                                        <th style="text-align:center; vertical-align: middle;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($regdirectorio as $ben)
                                    <tr>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{$ben->periodo_id}} </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{$ben->prog_id}}
                                        @foreach($regprogramas as $program)
                                            @if($program->prog_id == $ben->prog_id)
                                                {{Trim($program->prog_desc)}}
                                                @break
                                            @endif
                                        @endforeach                                        
                                        </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{trim($ben->dir_nombre_3)}}</td>                
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{trim($ben->dir_cargo_3)}}</td>   
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{trim($ben->dir_email_3)}}</td>                
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{trim($ben->dir_tel_3)}}</td>                                                        

                                        <td style="text-align:center;">
                                            <a href="{{route('editardirectorio',array($ben->periodo_id,$ben->prog_id) )}}" class="btn badge-warning" title="Editar"><i class="fa fa-edit"></i></a>
                                            @if(session()->get('rango') == '4')
                                                <a href="{{route('borrardirectorio',array($ben->periodo_id,$ben->prog_id) )}}" class="btn badge-danger" title="Eliminar directorio del programa" onclick="return confirm('¿Seguro que desea eliminar directorio del programa?')"><i class="fa fa-times"></i></a>
                                            @endif    
                                        </td> 
                                    </tr>
                                    @if(session()->get('rango') == '0')
                                        <tr>
                                            <td style="text-align:left; rowspan=2;">
                                                <a href="{{route('verdirectorio')}}">                                        
                                                <img src="{{ asset('images/b11.jpg') }}"  border="0" width="30" height="30" title="11. directorio">
                                                <img src="{{ asset('images/fant.jpg') }}" border="0" width="30" height="30" title="Anterior apartado">
                                                </a>                                            
                                            </td>
                                            <td style="text-align:left;"></td>
                                            <td style="text-align:center;"></td>
                                            <td style="text-align:center;"></td>
                                            <td style="text-align:center;"></td>
                                            <td style="text-align:right;"></td>
                                            <td style="text-align:right; ">
                                                <a href="{{route('verdirectorio')}}">                                        
                                                <img src="{{ asset('images/fsig.jpg') }}" border="0" width="30" height="30" title="Siguiente apartado">
                                                <img src="{{ asset('images/b1.jpg') }}"  border="0" width="30" height="30" title="1. Datos del programa">
                                                </a>
                                            </td>
                                        </tr>
                                    @endif

                                    @endforeach
                                </tbody>
                            </table>
                            {!! $regdirectorio->appends(request()->input())->links() !!}
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
