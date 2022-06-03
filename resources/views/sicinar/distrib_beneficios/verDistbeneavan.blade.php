@extends('sicinar.principal')

@section('title','Ver distribución de beneficios avances')

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
                <small>8.2 Distrib. beneficios avances -</small> 
                <small>Seleccionar para editar </small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b8.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp;Distribución de beneficios avances </li> 
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <p align="justify"><b style="color:red;">
                            Instrucciones:</b> <b style="color:green;">
                            Requisitar la distribución anual de beneficios (avances) del programa y/o acción.
                            Este apartado se deberá de requisitar periodicamente de forma anual; esto es cada ejercio fiscal.
                            </b>
                        </p>       
                        <div class="page-header" style="text-align:right;">
                            @if(session()->get('rango') == '4')                                        
                                {{ Form::open(['route' => 'buscardistbeneavan', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
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
                                        <th colspan="13" style="text-align:center;vertical-align: middle;">$ Metas / Avances</th>
                                        <th style="text-align:center; vertical-align: middle; "></th>
                                    </tr>                                
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Fiscal             </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Programa y/o acción</th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Total<br>Avance </th>
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
                                    @foreach($regdistbene as $ben)
                                    <tr>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{$ben->periodo_id}} </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">
                                        {{$ben->prog_id.' '.Trim($ben->prog_desc)}}
                                        </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->bene_meta,2)}} </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->bene_m01,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->bene_m02,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->bene_m03,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->bene_m04,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->bene_m05,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->bene_m06,2)}}  </td>

                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->bene_m07,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->bene_m08,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->bene_m09,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->bene_m10,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->bene_m11,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->bene_m12,2)}}  </td>                                        
                                        <td style="text-align:center;">     </td> 
                                    </tr>
                                    <tr>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">     </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">     </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->bene_avance,2)}} </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->bene_a01,2)}}  </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->bene_a02,2)}}  </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->bene_a03,2)}}  </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->bene_a04,2)}}  </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->bene_a05,2)}}  </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->bene_a06,2)}}  </td>

                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->bene_a07,2)}}  </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->bene_a08,2)}}  </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->bene_a09,2)}}  </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->bene_a10,2)}}  </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->bene_a11,2)}}  </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->bene_a12,2)}}  </td>                                        
                                        <td style="color:orange;text-align:center;">
                                            <a href="{{route('editardistbeneavan',array($ben->periodo_id,$ben->prog_id) )}}" class="btn badge-warning" title="Editar avances"><i class="fa fa-edit"></i></a>
                                            @if(session()->get('rango') == '4')
                                                <a href="{{route('borrardistbeneavan',array($ben->periodo_id,$ben->prog_id) )}}" class="btn badge-danger" title="Eliminar distribución anual de beneficios del programa" onclick="return confirm('¿Seguro que desea eliminar la distribución anual de beneficios del programa?')"><i class="fa fa-times"></i></a>
                                            @endif    
                                        </td> 
                                    </tr>                                    
                                    @if(session()->get('rango') == '0')
                                        <tr>
                                            <td style="text-align:left; rowspan=2;">
                                                <a href="{{route('verdistbenemetas')}}">                                        
                                                <img src="{{ asset('images/b8.jpg') }}"   border="0" width="30" height="30" title="8.1 Distribución de beneficios metas">
                                                </a>                                            
                                            </td>
                                            <td style="text-align:left;">
                                                <a href="{{route('verdistbenemetas')}}">                                        
                                                <img src="{{ asset('images/fant.jpg') }}" border="0" width="30" height="30" title="Anterior apartado">
                                                </a>                                                                                            
                                            </td>
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
                                            <td style="text-align:right;">
                                                <a href="{{route('verdistmunimetas')}}">                                        
                                                <img src="{{ asset('images/fsig.jpg') }}" border="0" width="30" height="30" title="Siguiente apartado">
                                                </a>                                                
                                            </td>
                                            <td style="text-align:right; ">
                                                <a href="{{route('verdistmunimetas')}}">   
                                                <img src="{{ asset('images/b9.jpg') }}"   border="0" width="30" height="30" title="9.1 Distribución por municipio avances">
                                                </a>
                                            </td>
                                        </tr>
                                    @endif

                                    @endforeach
                                </tbody>
                            </table>
                            {!! $regdistbene->appends(request()->input())->links() !!}
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
