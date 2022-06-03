@extends('sicinar.principal')

@section('title','Ver Financiamiento avances')

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
                <small>10.2 Indicador avances -</small> 
                <small>Seleccionar para editar </small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b10.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp;Indicador avances </li> 
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <p align="justify"><b style="color:red;">
                            Instrucciones:</b> <b style="color:green;">
                            Requisitar los datos del indicador avances del programa y/o acción.
                            Este apartado se deberá de requisitar periodicamente de forma anual; esto es cada ejercio fiscal.
                            </b>
                        </p>       
                        <div class="page-header" style="text-align:right;">
                            @if(session()->get('rango') == '4')                                        
                                {{ Form::open(['route' => 'buscarindiavan', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
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
                                        <th style="text-align:left;   vertical-align: middle;">      </th>
                                        <th style="text-align:left;   vertical-align: middle;">      </th>
                                        <th style="text-align:left;   vertical-align: middle;">      </th>
                                        <th style="text-align:left;   vertical-align: middle;">      </th>
                                        <th style="text-align:left;   vertical-align: middle;">      </th>
                                        <th style="text-align:left;   vertical-align: middle;">      </th>
                                        <th colspan="13" style="text-align:center;vertical-align: middle;">Metas y vances</th>
                                        <th style="text-align:center; vertical-align: middle; "></th>
                                    </tr>                                
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Fiscal             </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Programa y/o acción</th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Indicador          </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Fórmula            </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Clase              </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Tipo               </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">Dimensión          </th>
                                        <th style="text-align:left;   vertical-align: middle;font-size:10px;">meta<br>Avance            </th>
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
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_meta,0)}} </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_m01,0)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_m02,0)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_m03,0)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_m04,0)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_m05,0)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_m06,0)}}  </td>

                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_m07,0)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_m08,0)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_m09,0)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_m10,0)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_m11,0)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_m12,0)}}  </td>                                        
                                        <td style="text-align:center;">     </td> 
                                    </tr>
                                    <tr>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">     </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">     </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">     </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">     </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">     </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">     </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">     </td>                                        
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_avance,0)}} </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_a01,0)}}  </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_a02,0)}}  </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_a03,0)}}  </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_a04,0)}}  </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_a05,0)}}  </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_a06,0)}}  </td>

                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_a07,0)}}  </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_a08,0)}}  </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_a09,0)}}  </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_a10,0)}}  </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_a11,0)}}  </td>
                                        <td style="color:orange;text-align:left; vertical-align: middle;font-size:09px;">{{number_format($ben->indi_a12,0)}}  </td>                                        
                                        <td style="color:orange;text-align:center;">
                                            <a href="{{route('editarindiavan',array($ben->periodo_id,$ben->prog_id,$ben->indi_id) )}}" class="btn badge-warning" title="Editar avances"><i class="fa fa-edit"></i></a>
                                            @if(session()->get('rango') == '4')
                                                <a href="{{route('borrarindiavan',array($ben->periodo_id,$ben->prog_id,$ben->indi_id) )}}" class="btn badge-danger" title="Eliminar indicador avances del programa" onclick="return confirm('¿Seguro que desea eliminar el indicador de avances del programa?')"><i class="fa fa-times"></i></a>
                                            @endif    
                                        </td> 
                                    </tr>                                    

                                    @endforeach
                                    @if(session()->get('rango') == '0')
                                        <tr>
                                            <td style="text-align:left; rowspan=2;">
                                                <a href="{{route('verindimetas')}}">                                        
                                                <img src="{{ asset('images/b10.jpg') }}"   border="0" width="30" height="30" title="10.1 Indicador metas">
                                                </a>                                            
                                            </td>
                                            <td style="text-align:left;">
                                                <a href="{{route('verindimetas')}}">                                        
                                                <img src="{{ asset('images/fant.jpg') }}" border="0" width="30" height="30" title="Anterior apartado">
                                                </a>                                                                             
                                            </td>
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
                                            <td style="text-align:right;"></td>                                            
                                            <td style="text-align:right;">
                                                <a href="{{route('verdiagnostico')}}">                                        
                                                <img src="{{ asset('images/fsig.jpg') }}" border="0" width="30" height="30" title="Siguiente apartado">
                                                </a>                                                
                                            </td>
                                            <td style="text-align:right; ">
                                                <a href="{{route('verdiagnostico')}}">  
                                                <img src="{{ asset('images/b11.jpg') }}"   border="0" width="30" height="30" title="11. Diagnóstico">
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
