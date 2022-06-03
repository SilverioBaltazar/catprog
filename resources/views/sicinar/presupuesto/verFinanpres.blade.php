@extends('sicinar.principal')

@section('title','Ver programa de trabajo')

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
                <small>Ficha del programa - </small>
                <small> 4. Financiamiento - </small>
                <small> Seleccionar para editar o registrar nuevo</small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b4.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp;Financiamiento</li> 
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box">
                        <p align="justify"><b style="color:red;">
                            Instrucciones:</b> <b style="color:green;">
                            El financiamiento presupuestal del programa y/o acción es obligatorio conforme al presupuesto de ingresos y egresos
                            del periodo correspondiente; Integrar los archivos digitales de: Oficio y Expediente técnico Anexo 1, 
                            Matriz Marco Lógico MML, Acta de última sesión de seguimiento al programa.... 
                            Este proceso se deberá de realizar periodicamente de forma anual.
                            Se requiere escanear a una resolución de 300 ppp en blanco y negro.
                            </b>
                        </p>       
                        <div class="page-header" style="text-align:right;">
                            @if(session()->get('rango') == '4')    
                                {{ Form::open(['route' => 'buscarfinanpres', 'method' => 'GET', 'class' => 'form-inline pull-right']) }}
                                    <div class="form-group">
                                        {{ Form::text('nameiap', null, ['class' => 'form-control', 'placeholder' => 'programa']) }}
                                    </div>                                             
                                    <div class="form-group">
                                        {{ Form::text('proy', null, ['class' => 'form-control', 'placeholder' => 'Proyecto']) }}
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-default">
                                            <span class="glyphicon glyphicon-search"></span>
                                        </button>
                                    </div>
                                    <div class="form-group">   
                                        <a href="{{route('nuevofinanpres')}}" class="btn btn-primary btn_xs" title="Nuevo Financiamiento"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span><small>Nuevo financiamiento</small></a>
                                    </div>                                
                                {{ Form::close() }}
                            @else
                                <div class="form-group">   
                                    <a href="{{route('nuevofinanpres')}}" class="btn btn-primary btn_xs" title="Nuevo Financiamiento"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span><small>Nuevo financiamiento</small></a>
                                </div>                                
                            @endif                                
                        </div>

                        <div class="box-body">
                            <table id="tabla1" class="table table-hover table-striped">
                                <thead style="color: brown;" class="justify">
                                    <tr>
                                        <th style="text-align:left;   vertical-align: middle;">Periodo        </th>
                                        <th style="text-align:left;   vertical-align: middle;">Id. Programa y/o acción</th>
                                        <th style="text-align:left;   vertical-align: middle;">Id. Proyecto   </th>                                        
                                        <th style="text-align:left;   vertical-align: middle;">Oficio y Expediente<br>técnico Anexo 1    </th>
                                        <th style="text-align:left;   vertical-align: middle;">Matriz Marco <br>Logico MML </th>
                                        <th style="text-align:left;   vertical-align: middle;">Acta de últ. sesión<br>de seguimiento al prog.</th>
                                        <th style="text-align:left;   vertical-align: middle;">Matriz finan.  </th>
                                        <th style="text-align:left;   vertical-align: middle;">Fec.Reg.       </th>
                                        
                                        <th style="text-align:center; vertical-align: middle; width:100px;">Acciones</th>
                                        <th style="text-align:center; vertical-align: middle; width:100px;">Funciones</th>
                                    </tr>
                                </thead> 
                                <tbody>
                                    @foreach($regfinanpres as $finan)

                                    <tr>
                                        <td style="text-align:left; vertical-align: middle; font-size:09px;">{{$finan->periodo_id}}</td>
                                        <td style="text-align:left; vertical-align: middle; font-size:09px;">{{$finan->prog_id}}   
                                            @foreach($regprogramas as $program)
                                                @if($program->prog_id == $finan->prog_id)
                                                    {{Trim($program->prog_desc)}}
                                                    @break 
                                                @endif
                                            @endforeach 
                                        </td>                                          
                                        <td style="text-align:left; vertical-align: middle; font-size:09px;">{{$finan->proy_id}}     
                                            @foreach($regproyectos as $proyecto)
                                                @if($proyecto->proy_id == $finan->proy_id)
                                                    {{Trim($proyecto->proy_desc)}}
                                                    @break 
                                                @endif
                                            @endforeach                                         
                                        </td>                                        
                                        @if(!empty($finan->finan_arc1)&&(!is_null($finan->finan_arc1)))
                                            <td style="color:darkgreen;text-align:center; vertical-align:middle;font-size:10px;" title="Archivo digital de Oficio y Expediente técnico Anexo 1 en formato PDF">
                                                <a href="/images/{{$finan->finan_arc1}}" class="btn btn-danger" title="Archivo digital de Oficio y Expediente técnico Anexo 1 en formato PDF"><i class="fa fa-file-pdf-o"></i>
                                                </a>
                                                <a href="{{route('editarfinanpres1',array($finan->periodo_id,$finan->prog_id))}}" class="btn badge-warning" title="Editar Archivo digital de Oficio y Expediente técnico Anexo 1 en formato PDF"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;font-size:10px;" title="Archivo digital de Oficio y Expediente técnico Anexo 1 en formato PDF"><i class="fa fa-times"></i>
                                                <a href="{{route('editarfinanpres1',array($finan->periodo_id,$finan->prog_id))}}" class="btn badge-warning" title="Editar Archivo digital de Oficio y Expediente técnico Anexo 1 en formato PDF"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>   
                                        @endif
                                        @if(!empty($finan->finan_arc2)&&(!is_null($finan->finan_arc2)))
                                            <td style="color:darkgreen;text-align:center; vertical-align: middle;font-size:10px;" title="Archivo digital de Matriz Marco Lógico MML en formato PDF">
                                                <a href="/images/{{$finan->finan_arc2}}" class="btn btn-danger" title="Archivo digital de Matriz Marco Lógico MML en formato PDF "><i class="fa fa-file-pdf-o"></i>
                                                </a>
                                                <a href="{{route('editarfinanpres2',array($finan->periodo_id,$finan->prog_id))}}" class="btn badge-warning" title="Editar Archivo digital de Matriz Marco Lógico MML en formato PDF "><i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;font-size:10px;" title="Archivo digital de Matriz Marco Lógico MML en formato PDF"><i class="fa fa-times"></i>
                                                <a href="{{route('editarfinanpres2',array($finan->periodo_id,$finan->prog_id))}}" class="btn badge-warning" title="Editar Archivo digital de Matriz Marco Lógico MML en formato PDF"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>   
                                        @endif
                                        @if(!empty($finan->finan_arc3)&&(!is_null($finan->finan_arc3)))
                                            <td style="color:darkgreen;text-align:center; vertical-align: middle;font-size:10px;" title="Archivo digital de Acta de última sesión de seguimiento al prog. en formato PDF">
                                                <a href="/images/{{$finan->finan_arc3}}" class="btn btn-danger" title="Acta de última sesión de seguimiento al prog."><i class="fa fa-file-pdf-o"></i>
                                                </a>
                                                <a href="{{route('editarfinanpres3',array($finan->periodo_id,$finan->prog_id))}}" class="btn badge-warning" title="Editar Archivo digital de Acta de última sesión de seguimiento al prog. en formato PDF"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>
                                        @else
                                            <td style="color:darkred; text-align:center; vertical-align: middle;font-size:10px;" title="Archivo digital de Acta de última sesión de seguimiento al prog. en formato PDF"><i class="fa fa-times"></i>
                                                <a href="{{route('editarfinanpres3',array($finan->periodo_id,$finan->prog_id))}}" class="btn badge-warning" title="Editar archivo digital de Acta de última sesión de seguimiento al prog. en formato PDF"><i class="fa fa-edit"></i>
                                                </a>
                                            </td>   
                                        @endif

                                        <td style="text-align:center; vertical-align: middle;"><small>
                                            @foreach($totactivs as $partida)
                                                @if($partida->periodo_id == $finan->periodo_id && $partida->prog_id == $finan->prog_id)
                                                    @if(!empty($partida->totpresupuesto)&&(!is_null($partida->totpresupuesto)))
                                                       <b style="color:darkgreen;">{{$partida->totpresupuesto}}</b>
                                                    @else
                                                       <b style="color:darkred;">0 Falta Matriz de finan. presupuestal</b>
                                                    @endif
                                                    @break
                                                @endif
                                            @endforeach </small>
                                        </td>                                                                                 
                                        <td style="text-align:left; vertical-align: middle; font-size:09px;">{{date("d/m/Y",strtotime($finan->fec_reg))}}</td>
                                        
                                        <td style="text-align:center;">
                                            <a href="{{route('editarfinanpres',array($finan->periodo_id,$finan->prog_id))}}" class="btn badge-warning" title="Editar programa de trabajo"><i class="fa fa-edit"></i>
                                            </a>
                                            @if(session()->get('rango') == '4')
                                                <a href="{{route('borrarfinanpres',array($finan->periodo_id,$finan->prog_id))}}" class="btn badge-danger" title="Borrar programa de trabajo" onclick="return confirm('¿Seguro que desea borrar financiamiento presupuestal?')"><i class="fa fa-times"></i></a>
                                            @endif                                                  
                                        </td>
                                        <td style="text-align:center;">
                                            <a href="{{route('exportfinanprespdf',array($finan->periodo_id,$finan->prog_id))}}" class="btn btn-danger" title="Financiamiento presupuestal en formato PDF"><i class="fa fa-file-pdf-o"></i>
                                            <small> PDF</small>
                                            </a>
                                            <a href="{{route('verfinanpresd',array($finan->periodo_id,$finan->prog_id))}}" class="btn btn-primary btn_xs" title="Ver matriz de financiamiento presupuestal"><i class="fa fa-file-new-o"></i><span class="glyphicon glyphicon-plus"></span><small>Presupuesto</small>
                                            </a>
                                        </td>
                                    </tr>
                                        @if(session()->get('rango') == '0')
                                        <tr>
                                            <td style="text-align:left; rowspan=2;">
                                                <a href="{{route('verobjprog')}}">                                        
                                                <img src="{{ asset('images/b3.jpg') }}"   border="0" width="30" height="30" title="3. Objetivo del programa y/o acción">
                                                <img src="{{ asset('images/fant.jpg') }}" border="0" width="30" height="30" title="Anterior apartado">
                                                </a>                                            
                                            </td>
                                            <td style="text-align:left;"></td>
                                            <td style="text-align:center;"></td>
                                            <td style="text-align:center;"></td>
                                            <td style="text-align:center;"></td>
                                            <td style="text-align:right;"></td>
                                            <td style="text-align:right; ">
                                                <a href="{{route('verfinpres')}}">                                        
                                                <img src="{{ asset('images/fsig.jpg') }}" border="0" width="30" height="30" title="Siguiente apartado">
                                                <img src="{{ asset('images/b5.jpg') }}"   border="0" width="30" height="30" title="Financiamiento">
                                                </a>
                                            </td>
                                        </tr>
                                        @endif                                    
                                    @endforeach
                                </tbody>
                            </table>
                            {!! $regfinanpres->appends(request()->input())->links() !!}
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
