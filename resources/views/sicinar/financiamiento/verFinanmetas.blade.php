@extends('sicinar.principal')

@section('title','Ver Financiamiento')

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
                <small>6.1 Financiamiento metas -</small> 
                <small>Seleccionar para editar o registrar nuevo</small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b6.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp;Financiamiento metas </li> 
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <p align="justify"><b style="color:red;">
                            Instrucciones:</b> <b style="color:green;">
                            Requisitar las fuentes de financiamiento y distribución presupuestal anual del programa y/o acción.
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
                                        <a href="{{route('nuevofinanmetas')}}" class="btn btn-primary btn_xs" title="Nuevo financiamiento"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span>Nuevo financiamiento </a> 
                                    </div>
                                {{ Form::close() }}
                            @else
                                <div class="box-header" style="text-align:right;">
                                    <a href="{{route('nuevofinanmetas')}}" class="btn btn-primary btn_xs" title="Nueva financiamiento"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span>Nuevo financiamiento </a> 
                                </div>              
                            @endif
                        </div>

                        <div class="box-body">
                            <table id="tabla1" class="table table-striped table-bordered table-sm">
                                <thead style="color: brown;" class="justify">
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;font-size:11px;">Periodo   </th>
                                        <th style="text-align:left;   vertical-align: middle;">      </th>
                                        <th style="text-align:left;   vertical-align: middle;">               </th>
                                        <th colspan="13" style="text-align:center;vertical-align: middle;">$ Metas </th>
                                        <th style="text-align:center; vertical-align: middle; "></th>
                                    </tr>                                
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Fiscal             </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Programa y/o acción</th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Fuente             </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Total<br>presup.   </th>
                                        <th style="text-align:left;   vertical-align: middle;">Ene        </th>
                                        <th style="text-align:left;   vertical-align: middle;">Feb        </th>
                                        <th style="text-align:left;   vertical-align: middle;">Mar        </th>
                                        <th style="text-align:left;   vertical-align: middle;">Abr        </th>
                                        <th style="text-align:left;   vertical-align: middle;">May        </th>
                                        <th style="text-align:left;   vertical-align: middle;">Jun        </th>
                                        <th style="text-align:left;   vertical-align: middle;">Jul        </th>
                                        <th style="text-align:left;   vertical-align: middle;">Ago        </th>
                                        <th style="text-align:left;   vertical-align: middle;">Sep        </th>
                                        <th style="text-align:left;   vertical-align: middle;">Oct        </th>
                                        <th style="text-align:left;   vertical-align: middle;">Nov        </th>
                                        <th style="text-align:left;   vertical-align: middle;">Dic        </th>
                                        <th style="text-align:center; vertical-align: middle;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($regfinan as $ben)
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
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">
                                        {{$ben->ftefinan_id.' '.Trim($ben->ftefinan_desc)}}                 </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->finan_meta,2)}} </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->finan_m01,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->finan_m02,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->finan_m03,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->finan_m04,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->finan_m05,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->finan_m06,2)}}  </td>

                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->finan_m07,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->finan_m08,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->finan_m09,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->finan_m10,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->finan_m11,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->finan_m12,2)}}  </td>                                        
                                        <td style="text-align:center;">
                                            <a href="{{route('editarfinanmetas',array($ben->periodo_id,$ben->prog_id,$ben->ftefinan_id) )}}" class="btn badge-warning" title="Editar"><i class="fa fa-edit"></i></a>
                                            @if(session()->get('rango') == '4')
                                                <a href="{{route('borrarfinanmetas',array($ben->periodo_id,$ben->prog_id,$ben->ftefinan_id) )}}" class="btn badge-danger" title="Eliminar fuente de financiamiento del programa" onclick="return confirm('¿Seguro que desea eliminar la fuente de financiamiento del programa?')"><i class="fa fa-times"></i></a>
                                            @endif    
                                        </td> 
                                    </tr>

                                    @endforeach
                                    @if(session()->get('rango') == '0')
                                        <tr>
                                            <td style="text-align:left; rowspan=2;">
                                                <a href="{{route('verbenefprog')}}">                                        
                                                <img src="{{ asset('images/b5.jpg') }}"   border="0" width="30" height="30" title="5. Beneficios">
                                                </a>                                            
                                            </td>
                                            <td style="text-align:left;">
                                                <a href="{{route('verbenefprog')}}">                                        
                                                <img src="{{ asset('images/fant.jpg') }}" border="0" width="30" height="30" title="Anterior apartado">
                                                </a>                                                                                            
                                            </td>
                                            <td style="text-align:center;"></td>
                                            <td style="text-align:center;"></td>
                                            <td style="text-align:center;"></td>
                                            <td style="text-align:center;"></td>
                                            <td style="text-align:center;"></td>
                                            <td style="text-align:center;"></td>                                            
                                            <td style="text-align:right;"></td>
                                            <td style="text-align:right;"></td>
                                            <td style="text-align:right;"></td>
                                            <td style="text-align:right;"></td>
                                            <td style="text-align:right;"></td>
                                            <td style="text-align:right;"></td>
                                            <td style="text-align:right;"></td>
                                            <td style="text-align:right;">
                                                <a href="{{route('verfinanavances')}}">                                        
                                                <img src="{{ asset('images/fsig.jpg') }}" border="0" width="30" height="30" title="Siguiente apartado">
                                                </a>                                                
                                            </td>                                            
                                            <td style="text-align:right; ">
                                                <a href="{{route('verfinanavances')}}">  
                                                <img src="{{ asset('images/b6.jpg') }}" border="0" width="30" height="30" title="6.2 Financiamiento avances">
                                                </a>
                                            </td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                            {!! $regfinan->appends(request()->input())->links() !!}
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
