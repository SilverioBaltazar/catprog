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
                <small>10.1 Indicador metas -</small> 
                <small>Seleccionar para editar o registrar nuevo</small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b10.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp;Indicador metas </li> 
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <p align="justify"><b style="color:red;">
                            Instrucciones:</b> <b style="color:green;">
                            Requisitar los datos del indicador metas del programa y/o acción.
                            Este apartado se deberá de requisitar periodicamente de forma anual; esto es cada ejercio fiscal.
                            </b>
                        </p>       
                        <div class="page-header" style="text-align:right;">
                            @if(session()->get('rango') == '4')                                        
                                {{ Form::open(['route' => 'buscarindimetas', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                                    <div class="form-group">
                                        {{ Form::text('idd', null, ['class' => 'form-control', 'placeholder' => 'id programa']) }}
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-default">
                                            <span class="glyphicon glyphicon-search"></span>
                                        </button>
                                    </div>
                                    <div class="box-header" style="text-align:right;">
                                        <a href="{{route('nuevoindimetas')}}" class="btn btn-primary btn_xs" title="Nuevo indicador"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span>Nuevo indicador </a> 
                                    </div>
                                {{ Form::close() }}
                            @else
                                <div class="box-header" style="text-align:right;">
                                    <a href="{{route('nuevoindimetas')}}" class="btn btn-primary btn_xs" title="Nuevo  indicador"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span>Nuevo  indicador </a> 
                                </div>              
                            @endif
                        </div>

                        <div class="box-body">
                            <table id="tabla1" class="table table-striped table-bordered table-sm">
                                <thead style="color: brown;" class="justify">
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;font-size:11px;">Periodo   </th>
                                        <th style="text-align:left;   vertical-align: middle;">      </th>
                                        <th style="text-align:left;   vertical-align: middle;">      </th>
                                        <th style="text-align:left;   vertical-align: middle;">      </th>
                                        <th style="text-align:left;   vertical-align: middle;">      </th>
                                        <th style="text-align:left;   vertical-align: middle;">      </th>
                                        <th style="text-align:left;   vertical-align: middle;">      </th>
                                        <th colspan="13" style="text-align:center;vertical-align: middle;">$ Metas </th>
                                        <th style="text-align:center; vertical-align: middle; "></th>
                                    </tr>                                
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Fiscal             </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Programa y/o acción</th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Indicador         </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Fórmula           </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Clase        </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Tipo         </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Dimensión    </th>
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
                                    @foreach($regindicador as $ben)
                                    <tr>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{$ben->periodo_id}} </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">
                                        {{$ben->prog_id.' '.Trim($ben->prog_desc)}}
                                        </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">
                                        {{$ben->indi_id.' '.Trim($ben->indi_desc)}}
                                        </td>                              
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">
                                        {{Trim($ben->indi_formula)}}
                                        </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">
                                        {{$ben->iclase_id}}
                                        @foreach($regiclase as $clase)
                                            @if($clase->iclase_id == $ben->iclase_id)
                                                {{Trim($clase->iclase_desc)}}
                                                @break
                                            @endif
                                        @endforeach                                        
                                        </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">
                                        {{$ben->itipo_id}}
                                        @foreach($regitipo as $tipo)
                                            @if($tipo->itipo_id == $ben->itipo_id)
                                                {{Trim($tipo->itipo_desc)}}
                                                @break
                                            @endif
                                        @endforeach                                        
                                        </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">
                                        {{$ben->idimension_id}}
                                        @foreach($regidimen as $dimen)
                                            @if($dimen->idimension_id == $ben->idimension_id)
                                                {{Trim($dimen->idimension_desc)}}
                                                @break
                                            @endif
                                        @endforeach                                        
                                        </td>                                                                                                                        
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_meta,2)}} </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_m01,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_m02,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_m03,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_m04,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_m05,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_m06,2)}}  </td>

                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_m07,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_m08,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_m09,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_m10,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_m11,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_m12,2)}}  </td>                                        
                                        <td style="text-align:center;">
                                            <a href="{{route('editarindimetas',array($ben->periodo_id,$ben->prog_id,$ben->indi_id) )}}" class="btn badge-warning" title="Editar"><i class="fa fa-edit"></i></a>
                                            @if(session()->get('rango') == '4')
                                                <a href="{{route('borrarindimetas',array($ben->periodo_id,$ben->prog_id,$ben->indi_id) )}}" class="btn badge-danger" title="Eliminar el indicador del programa" onclick="return confirm('¿Seguro que desea eliminar el indicador del programa?')"><i class="fa fa-times"></i></a>
                                            @endif    
                                        </td> 
                                    </tr>
                                    @endforeach
                                    @if(session()->get('rango') == '0')
                                        <tr>
                                            <td style="text-align:left; rowspan=2;">
                                                <a href="{{route('verdistmuniavan')}}">                                        
                                                <img src="{{ asset('images/b9.jpg') }}"   border="0" width="30" height="30" title="9.2 Dist. por municipio avances">
                                                </a>                                            
                                            </td>
                                            <td style="text-align:left;">
                                                <a href="{{route('verdistmuniavan')}}">                                        
                                                <img src="{{ asset('images/fant.jpg') }}" border="0" width="30" height="30" title="Anterior apartado">
                                                </a>    
                                            </td>                                                                                    
                                            <td style="text-align:left;"></td>
                                            <td style="text-align:left;"></td>
                                            <td style="text-align:left;"></td>                                            
                                            <td style="text-align:left;"></td>
                                            <td style="text-align:left;"></td>                                              
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
                                            <td style="text-align:right;">
                                                <a href="{{route('verindiavan')}}">                                        
                                                <img src="{{ asset('images/fsig.jpg') }}" border="0" width="30" height="30" title="Siguiente apartado">
                                                </a>                                                
                                            </td>                                                                                                                                    
                                            <td style="text-align:right; ">
                                                <a href="{{route('verindiavan')}}">                
                                                <img src="{{ asset('images/b10.jpg') }}"   border="0" width="30" height="30" title="10.2 Indicadores avances">
                                                </a>
                                            </td>
                                        </tr>
                                    @endif

                                </tbody>
                            </table>
                            {!! $regindicador->appends(request()->input())->links() !!}
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
