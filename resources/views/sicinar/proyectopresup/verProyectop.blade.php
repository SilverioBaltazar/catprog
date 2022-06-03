@extends('sicinar.principal')

@section('title','Ver cursos')

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
                <small>4. Proyecto prersupuestal -</small> 
                <small>Seleccionar para editar o registrar nuevo</small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b4.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp;Proyecto presupuestal</li> 
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <p align="justify"><b style="color:red;">
                            Instrucciones:</b> <b style="color:green;">
                            Requisitar los datos del proyecto presupuestal. 
                            Este apartado se deberá de requisitar periodicamente de forma anual; esto es cada ejercio fiscal.
                            </b>
                        </p>       
                        <div class="page-header" style="text-align:right;">
                            @if(session()->get('rango') == '4')                                        
                                {{ Form::open(['route' => 'buscarproyectop', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                                    <div class="form-group">
                                        {{ Form::text('idd', null, ['class' => 'form-control', 'placeholder' => 'id programa']) }}
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-default">
                                            <span class="glyphicon glyphicon-search"></span>
                                        </button>
                                    </div>
                                    <div class="box-header" style="text-align:right;">
                                        <a href="{{route('nuevoproyectop')}}" class="btn btn-primary btn_xs" title="Nuevo proyecto presupuestal"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span>Nuevo proyecto presupuestal</a> 
                                    </div>
                                {{ Form::close() }}
                            @else
                                <div class="box-header" style="text-align:right;">
                                    <a href="{{route('nuevoproyectop')}}" class="btn btn-primary btn_xs" title="Nuevo proyecto presupuestal"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span>Nuevo proyecto presupuestal</a> 
                                </div>              
                            @endif
                        </div>

                        <div class="box-body">
                            <table id="tabla1" class="table table-striped table-bordered table-sm">
                                <thead style="color: brown;" class="justify">
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;">Periodo <br>Fiscal   </th>
                                        <th style="text-align:left;   vertical-align: middle;">Programa y/o acción  </th>
                                        <th style="text-align:left;   vertical-align: middle;">Proyecto presupuestal</th>
                                        <th style="text-align:left;   vertical-align: middle;">$ Monto <br>Presup.  </th>
                                        <th style="text-align:center; vertical-align: middle;">$ Monto <br>Autoriz. </th>
                                        <th style="text-align:center; vertical-align: middle; width:100px;">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($regproyectopres as $proy)
                                    <tr>
                                        <td style="text-align:left; vertical-align: middle;">{{$proy->periodo_id}} </td>
                                        <td style="text-align:left; vertical-align: middle;">{{$proy->prog_id}}
                                        @foreach($regprogramas as $program)
                                            @if($program->prog_id == $proy->prog_id)
                                                {{Trim($program->prog_desc)}}
                                                @break
                                            @endif
                                        @endforeach                                        
                                        </td>
                                        <td style="text-align:left; vertical-align: middle;">{{$proy->proy_id.' '.Trim($proy->proy_desc)}}</td>
                                        <td style="text-align:left; vertical-align: middle;">{{number_format($proy->monto_presup,2)}}  </td>
                                        <td style="text-align:left; vertical-align: middle;">{{number_format($proy->monto_autorizado,2)}}  </td>
                                        <td style="text-align:center;">
                                            <a href="{{route('editarproyectop',array($proy->periodo_id,$proy->prog_id) )}}" class="btn badge-warning" title="Editar"><i class="fa fa-edit"></i></a>
                                            @if(session()->get('rango') == '4')
                                                <a href="{{route('borrarproyectop',array($proy->periodo_id,$proy->prog_id) )}}" class="btn badge-danger" title="Eliminar proyecto presupuestal" onclick="return confirm('¿Seguro que desea eliminar proyecto presupuestal?')"><i class="fa fa-times"></i></a>
                                            @endif    
                                        </td> 
                                    </tr>
                                    @if(session()->get('rango') == '0')
                                        <tr>
                                            <td style="text-align:left; rowspan=2;">
                                                <a href="{{route('verobjprog')}}">                                        
                                                <img src="{{ asset('images/b3.jpg') }}"   border="0" width="30" height="30" title="3. Onjetivo">
                                                </a>                                            
                                            </td>
                                            <td style="text-align:left;">
                                                <a href="{{route('verobjprog')}}">                                        
                                                <img src="{{ asset('images/fant.jpg') }}" border="0" width="30" height="30" title="Anterior apartado">
                                                </a>                                                                                            
                                            </td>
                                            <td style="text-align:center;"></td>
                                            <td style="text-align:center;"></td>
                                            <td style="text-align:right;"></td>
                                            <td style="text-align:right; ">
                                                <a href="{{route('verbenefprog')}}">                                        
                                                <img src="{{ asset('images/fsig.jpg') }}" border="0" width="30" height="30" title="Siguiente apartado">
                                                <img src="{{ asset('images/b5.jpg') }}"   border="0" width="30" height="30" title="Beneficios - Programas">
                                                </a>
                                            </td>
                                        </tr>
                                    @endif

                                    @endforeach
                                </tbody>
                            </table>
                            {!! $regproyectopres->appends(request()->input())->links() !!}
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