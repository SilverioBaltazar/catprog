@extends('sicinar.principal')

@section('title','Ver distribución por municipio avances')

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
                <small>9.1 Dist. municipio avances -</small> 
                <small>Seleccionar para editar </small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b9.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp;Dist. municipio avances </li> 
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <p align="justify"><b style="color:red;">
                            Instrucciones:</b> <b style="color:green;">
                            Requisitar la distribución anual por municipio de: Financiamiento, beneficiarios y beneficios (avances) del programa y/o acción.
                            Este apartado se deberá de requisitar periodicamente de forma anual; esto es cada ejercio fiscal.
                            </b>
                        </p>       
                        <div class="page-header" style="text-align:right;">
                            @if(session()->get('rango') == '4')                                        
                                {{ Form::open(['route' => 'buscardistmuniavan', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                                    <div class="form-group">
                                        {{ Form::text('idd', null, ['class' => 'form-control', 'placeholder' => 'id programa']) }}
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-default">
                                            <span class="glyphicon glyphicon-search"></span>
                                        </button>
                                    </div>
                                {{ Form::close() }}
                            @endif
                        </div>

                        <div class="box-body">
                            <table id="tabla1" class="table table-striped table-bordered table-sm">
                                <thead style="color: brown;" class="justify">
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;font-size:11px;">Periodo   </th>
                                        <th style="text-align:left;   vertical-align: middle;">               </th>
                                        <th style="text-align:left;   vertical-align: middle;">               </th>
                                        <th colspan="13" style="text-align:center;vertical-align: middle;">$ Metas / Avances</th>
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
                                    @foreach($regdistmuni as $ben)
                                    <tr>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{$ben->periodo_id}} </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">
                                        {{$ben->prog_id.' '.Trim($ben->prog_desc)}}
                                        </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">
                                        {{$ben->municipio_id}}
                                        @foreach($regmunicipios as $muni)
                                            @if( $muni->municipio_id == $ben->municipio_id)
                                                {{Trim($muni->municipio)}}
                                                @break
                                            @endif
                                        @endforeach                                            
                                        </td>                                                                                
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->finan_meta,2)}} </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->benef_meta,0)}} </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->bene_meta ,0)}} </td>
                                        <td style="text-align:center;">     </td> 
                                    </tr>
                                    <tr>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">     </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">     </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">     </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->finan_avance,2)}} </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->benef_avance,0)}} </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->bene_avance ,0)}} </td>

                                        <td style="color:orange;text-align:center;">
                                            <a href="{{route('editardistmuniavan',array($ben->periodo_id,$ben->prog_id,$ben->municipio_id) )}}" class="btn badge-warning" title="Editar avances"><i class="fa fa-edit"></i></a>
                                            @if(session()->get('rango') == '4')
                                                <a href="{{route('borrardistmuniavan',array($ben->periodo_id,$ben->prog_id,$ben->municipio_id) )}}" class="btn badge-danger" title="Eliminar distribución por municipio del programa" onclick="return confirm('¿Seguro que desea eliminar la distribución por municipio del programa?')"><i class="fa fa-times"></i></a>
                                            @endif    
                                        </td> 
                                    </tr>                                    
                                    @if(session()->get('rango') == '0')
                                        <tr>
                                            <td style="text-align:left; rowspan=2;">
                                                <a href="{{route('verdistmunimetas')}}">                                        
                                                <img src="{{ asset('images/b9.jpg') }}"   border="0" width="30" height="30" title="9.1 Distribución por municipio metas">
                                                <img src="{{ asset('images/fant.jpg') }}" border="0" width="30" height="30" title="Anterior apartado">
                                                </a>                                            
                                            </td>
                                            <td style="text-align:left;"></td>
                                            <td style="text-align:center;"></td>
                                            <td style="text-align:center;"></td>
                                            <td style="text-align:center;"></td>
                                            <td style="text-align:right;"></td>
                                            <td style="text-align:right; ">
                                                <a href="{{route('verindimetas')}}">                                        
                                                <img src="{{ asset('images/fsig.jpg') }}" border="0" width="30" height="30" title="Siguiente apartado">
                                                <img src="{{ asset('images/b10.jpg') }}"   border="0" width="30" height="30" title="10.1 Indicadoreas metas">
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
