@extends('sicinar.principal')

@section('title','Ver Funciones de procesos')

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
                <small>2. Datos de la dependencia -</small>
                <small>Seleccionar para editar </small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b2.jpg') }}" border="0" width="30" height="30">Datos de la dependencia</li> 
            </ol>
        </section> 
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <p align="justify"><b style="color:red;">
                            Instrucciones:</b> <b style="color:green;">
                            Requisitar los datos de la dependencia y/o organismo auxiliar responsable del programa y/o acción. 
                            </b>
                        </p>                                            

                        <div class="box-body">
                            <table id="tabla1" class="table table-striped table-bordered table-sm">
                                <thead style="color: brown;" class="justify">
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;">Id. programa</th>
                                        <th style="text-align:left;   vertical-align: middle;">Id. Dependencia y/o organismo auxiliar resp. </th>
                                        <th style="text-align:left;   vertical-align: middle;">Id. Unidad admon. que opera el programa y/o acción</th> 
                                        <th style="text-align:center; vertical-align: middle;">Fecha <br>registro</th>
                                        <th style="text-align:center; vertical-align: middle;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($regdepprogs  as $depprog) 
                                    <tr>
                                        <td style="text-align:left; vertical-align: middle;">{{$depprog->prog_id}}  
                                            @foreach($regprograma as $programa)
                                                @if($programa->prog_id == $depprog->prog_id)
                                                    {{trim($programa->prog_desc)}}
                                                    @break 
                                                @endif
                                            @endforeach                                        
                                        </td>
                                    
                                        <td style="text-align:left; vertical-align: middle;">
                                        @if(!empty($depprog->depen_id1)&&(!is_null($depprog->depen_id1)))
                                            {{$depprog->depen_id1}}  
                                            @foreach($regdepen as $depen)
                                                @if($depen->depen_id == $depprog->depen_id1)
                                                    {{trim($depen->depen_desc)}}
                                                    @break 
                                                @endif
                                            @endforeach                                                                                
                                        @else
                                            *** pendiente ***
                                        @endif
                                        </td>
                                        <td style="text-align:left; vertical-align: middle;">
                                        @if(!empty($depprog->depen_id2)&&(!is_null($depprog->depen_id2)))                                        
                                            {{$depprog->depen_id2}}  
                                            @foreach($regdepen as $depen)
                                                @if($depen->depen_id == $depprog->depen_id2)
                                                    {{trim($depen->depen_desc)}}
                                                    @break 
                                                @endif
                                            @endforeach     
                                        @else
                                            *** pendiente ***
                                        @endif                                            
                                        </td>                                        
                                        <td style="text-align:center; vertical-align: middle;">{{date("d/m/Y", strtotime($depprog->fecha_reg))}}</td>
                                        <td style="text-align:center;">
                                            <a href="{{route('editardepprog',$depprog->prog_id)}}" class="btn badge-warning" title="Editar "><i class="fa fa-edit"></i></a>
                                            @if(session()->get('rango') == '4')
                                            <a href="{{route('borrardepprog',$depprog->prog_id)}}" class="btn badge-danger"  title="Borrar " onclick="return confirm('¿Seguro que desea borrar?')"><i class="fa fa-times"></i></a>
                                            @endif
                                        </td>                                                                                
                                    </tr>
                                        @if(session()->get('rango') == '0')
                                        <tr>
                                            <td style="text-align:left; rowspan=2;">
                                                <a href="{{route('verprog')}}">                                        
                                                <img src="{{ asset('images/b1.jpg') }}"   border="0" width="30" height="30" title="1. Programa">
                                                <img src="{{ asset('images/fant.jpg') }}" border="0" width="30" height="30" title="Anterior apartado">
                                                </a>                                            
                                            </td>
                                            <td style="text-align:left;"></td>
                                            <td style="text-align:center;"></td>
                                            <td style="text-align:right; ">
                                                <a href="{{route('verobjprog')}}">                                        
                                                <img src="{{ asset('images/fsig.jpg') }}" border="0" width="30" height="30" title="Siguiente apartado">
                                                <img src="{{ asset('images/b3.jpg') }}"   border="0" width="30" height="30" title="3. Objetivo del programa">
                                                </a>
                                            </td>
                                        </tr>
                                        @endif                                                                        
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $regdepprogs->appends(request()->input())->links() !!}
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
