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
                <small>11. Diagnóstico -</small> 
                <small>Seleccionar para editar o registrar nuevo</small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b11.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp;Diagnóstico </li> 
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <p align="justify"><b style="color:red;">
                            Instrucciones:</b> <b style="color:green;">
                            Requisitar el cuestionario de diagnóstico del programa y/o acción.
                            Este apartado se deberá de requisitar periodicamente de forma anual; esto es cada ejercio fiscal.
                            </b>
                        </p>       
                        <div class="page-header" style="text-align:right;">
                            @if(session()->get('rango') == '4')                                        
                                {{ Form::open(['route' => 'buscardiagnostico', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                                    <div class="form-group">
                                        {{ Form::text('idd', null, ['class' => 'form-control', 'placeholder' => 'id programa']) }}
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-default">
                                            <span class="glyphicon glyphicon-search"></span>
                                        </button>
                                    </div>
                                    <div class="box-header" style="text-align:right;">
                                        <a href="{{route('nuevodiagnostico')}}" class="btn btn-primary btn_xs" title="Generar diagnóstico"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span>Nuevo cuestionario de diagnóstico </a> 
                                    </div>
                                {{ Form::close() }}
                            @else
                                <div class="box-header" style="text-align:right;">
                                     <a href="{{route('nuevodiagnostico')}}" class="btn btn-primary btn_xs" title="Generar diagnóstico"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span>Nuevo cuestionario de diagnóstico </a> 
                                </div>              
                            @endif
                        </div>

                        <div class="box-body">
                            <table id="tabla1" class="table table-striped table-bordered table-sm">
                                <thead style="color: brown;" class="justify">
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Periodo<br>Fiscal             </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Programa y/o acción</th>  
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Pregunta   </th>  
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Link o URL </th>  
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">PDF        </th>  
                                        <th style="text-align:center; vertical-align: middle;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($regdiagnostico as $ben)
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
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{$ben->preg_id}}
                                        @foreach($regpreguntas as $preg)
                                            @if($preg->preg_id == $ben->preg_id)
                                                {{Trim($preg->preg_desc)}}
                                                @break
                                            @endif
                                        @endforeach                                        
                                        </td>                

                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{$ben->preg_url}} </td>
                                        @if(!empty($ben->preg_arc)&&(!is_null($ben->preg_arc)))
                                            <td style="color:darkgreen;text-align:center; vertical-align:middle;font-size:10px;" title="Archivo digital en formato PDF">
                                                <a href="/storage/{{$ben->preg_arc}}" class="btn btn-danger" title="Archivo digital en formato PDF"><i class="fa fa-file-pdf-o"></i>
                                                </a>
                                                <a href="{{route('editardiagnostico1',array($ben->periodo_id,$ben->prog_id,$ben->preg_id))}}" class="btn badge-warning" title="Editar archivo digital en formato PDF"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;font-size:10px;" title="Archivo digital en formato PDF"><i class="fa fa-times"></i>
                                                <a href="{{route('editardiagnostico1',array($ben->periodo_id,$ben->prog_id,$ben->preg_id))}}" class="btn badge-warning" title="Editar archivo digital en formato PDF"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>   
                                        @endif

                                        <td style="text-align:center;">
                                            <a href="{{route('editardiagnostico',array($ben->periodo_id,$ben->prog_id,$ben->preg_id) )}}" class="btn badge-warning" title="Editar"><i class="fa fa-edit"></i></a>
                                            @if(session()->get('rango') == '4')
                                                <a href="{{route('borrardiagnostico',array($ben->periodo_id,$ben->prog_id,$ben->preg_id) )}}" class="btn badge-danger" title="Eliminar distribución anual de beneficiarios del programa" onclick="return confirm('¿Seguro que desea eliminar la distribución anual de beneficiarios?')"><i class="fa fa-times"></i></a>
                                            @endif    
                                        </td> 
                                    </tr>
                                    @endforeach
                                    @if(session()->get('rango') == '0')
                                        <tr>
                                            <td style="text-align:left; rowspan=2;">
                                                <a href="{{route('verindiavan')}}">                                        
                                                <img src="{{ asset('images/b10.jpg') }}"  border="0" width="30" height="30" title="10.2 Indicador avances">
                                                </a>                                            
                                            </td>
                                            <td style="text-align:left;">
                                                <a href="{{route('verindiavan')}}">                                        
                                                <img src="{{ asset('images/fant.jpg') }}" border="0" width="30" height="30" title="Anterior apartado">
                                                </a>                                                                                            
                                            </td>
                                            <td style="text-align:center;"></td>
                                            <td style="text-align:center;"></td>
                                            <td style="text-align:right;">
                                                <a href="{{route('verdirectorio')}}">                                        
                                                <img src="{{ asset('images/fsig.jpg') }}" border="0" width="30" height="30" title="Siguiente apartado">
                                                </a>                                                
                                            </td>
                                            <td style="text-align:right; ">
                                                <a href="{{route('verdirectorio')}}">                                        
                                                <img src="{{ asset('images/b12.jpg') }}"  border="0" width="30" height="30" title="12. Directorio">
                                                </a>
                                            </td>
                                        </tr>
                                    @endif                                    
                                </tbody>
                            </table>
                            {!! $regdiagnostico->appends(request()->input())->links() !!}
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
