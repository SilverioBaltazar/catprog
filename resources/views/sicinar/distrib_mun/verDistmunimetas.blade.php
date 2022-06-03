@extends('sicinar.principal')

@section('title','Ver Distribución por municipio')

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
                <small>9.1 Dist. municipio metas -</small> 
                <small>Seleccionar para editar</small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b9.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp;Distribución por municipio metas </li> 
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <p align="justify"><b style="color:red;">
                            Instrucciones:</b> <b style="color:green;">
                            Requisitar la distribución anual por municipio de: Financiamiento, beneficiarios y beneficios (metas) del programa y/o acción.
                            Este apartado se deberá de requisitar periodicamente de forma anual; esto es cada ejercio fiscal.
                            </b>
                        </p>       
                        <div class="page-header" style="text-align:right;">
                            @if(session()->get('rango') == '4')                                        
                                {{ Form::open(['route' => 'buscardistmunimetas', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                                    <div class="form-group">
                                        {{ Form::text('idd', null, ['class' => 'form-control', 'placeholder' => 'id programa']) }}
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-default">
                                            <span class="glyphicon glyphicon-search"></span>
                                        </button>
                                    </div>
                                    <div class="box-header" style="text-align:right;">
                                        <a href="{{route('nuevodistmunimetas')}}" class="btn btn-primary btn_xs" title="Nueva distribución por municipio"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span>Nueva distribución por municipio </a> 
                                    </div>
                                {{ Form::close() }}
                            @else
                                <div class="box-header" style="text-align:right;">
                                     <a href="{{route('nuevodistmunimetas')}}" class="btn btn-primary btn_xs" title="Nueva distribución por municipios"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span>Nueva distribución por municipio </a> 
                                </div>              
                            @endif
                        </div>

                        <div class="box-body">
                            <table id="tabla1" class="table table-striped table-bordered table-sm">
                                <thead style="color: brown;" class="justify">
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;font-size:11px;">Periodo</th>
                                        <th style="text-align:left;   vertical-align: middle;">                      </th>
                                        <th style="text-align:left;   vertical-align: middle;">                      </th>                                        
                                        <th colspan="04" style="text-align:center;vertical-align: middle;">$ Metas   </th>
                                        <th style="text-align:center; vertical-align: middle; "></th>
                                    </tr>                                
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Fiscal             </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Programa y/o acción</th>  
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Municipio          </th>                                          
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">$ Total<br>Prespup.</th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Total<br>Beneficiados</th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Total<br>Beneficios  </th>                                                                                
                                        <th style="text-align:center; vertical-align: middle;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($regdistmuni as $mun)
                                    <tr>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{$mun->periodo_id}} </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">
                                        {{$mun->prog_id.' '.Trim($mun->prog_desc)}}
                                        </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">
                                        {{$mun->municipio_id}}
                                        @foreach($regmunicipios as $muni)
                                            @if( $muni->municipio_id == $mun->municipio_id)
                                                {{Trim($muni->municipio)}}
                                                @break
                                            @endif
                                        @endforeach                                            
                                        </td>                                        
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($mun->finan_meta,2)}} </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($mun->benef_meta,0)}} </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($mun->bene_meta ,0)}} </td>
                                        <td style="text-align:center;">
                                            <a href="{{route('editardistmunimetas',array($mun->periodo_id,$mun->prog_id,$mun->municipio_id) )}}" class="btn badge-warning" title="Editar"><i class="fa fa-edit"></i></a>
                                            @if(session()->get('rango') == '4')
                                                <a href="{{route('borrardistmunimetas',array($mun->periodo_id,$mun->prog_id,$mun->municipio_id) )}}" class="btn badge-danger" title="Eliminar distribución anual por municipio del programa" onclick="return confirm('¿Seguro que desea eliminar la distribución anual por municipio?')"><i class="fa fa-times"></i></a>
                                            @endif    
                                        </td> 
                                    </tr>
                                    @if(session()->get('rango') == '0')
                                        <tr>
                                            <td style="text-align:left; rowspan=2;">
                                                <a href="{{route('verdistbeneavan')}}">                                        
                                                <img src="{{ asset('images/b8.jpg') }}"   border="0" width="30" height="30" title="8.2 Dist. de beneficios avances">
                                                </a>                                            
                                            </td>
                                            <td style="text-align:left;">
                                                <a href="{{route('verdistbeneavan')}}">                                        
                                                <img src="{{ asset('images/fant.jpg') }}" border="0" width="30" height="30" title="Anterior apartado">
                                                </a>                                                                                            
                                            </td>
                                            <td style="text-align:left;"></td>
                                            <td style="text-align:left;"></td>
                                            
                                            <td style="text-align:center;"></td>
                                            <td style="text-align:right;"></td>
                                            <td style="text-align:right; ">
                                                <a href="{{route('verdistmuniavan')}}">                                        
                                                <img src="{{ asset('images/fsig.jpg') }}" border="0" width="30" height="30" title="Siguiente apartado">
                                                <img src="{{ asset('images/b9.jpg') }}"   border="0" width="30" height="30" title="9.2 Distribución por municipio avances">
                                                </a>
                                            </td>
                                        </tr>
                                    @endif

                                    @endforeach
                                </tbody>
                            </table>
                            {!! $regdistmuni->appends(request()->input())->links() !!}
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
