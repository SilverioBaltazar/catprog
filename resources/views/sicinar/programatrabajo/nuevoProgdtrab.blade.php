@extends('sicinar.principal')

@section('title','Nueva actividad del programa de trabajo')

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
    <meta charset="utf-8">
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Menú
                <small> Requisitos de operación</small>                
                <small> Programa de trabajo - Nueva actividad </small>                
            </h1>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        
                        {!! Form::open(['route' => 'AltaNuevoProgdtrab', 'method' => 'POST','id' => 'nuevoProgdtrab', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">

                            <table id="tabla1" class="table table-hover table-striped">
                                <tr>
                                @foreach($regprogtrab as $progtrab)
                                    <td style="text-align:left; vertical-align: middle; color:green;">   
                                        <input type="hidden" id="folio" name="folio" value="{{$progtrab->folio}}">  
                                        <label>Folio: </label>{{$progtrab->folio}}
                                    </td>                                                                 
                                    <td style="text-align:left; vertical-align: middle; color:green;">   
                                        <input type="hidden" id="periodo_id" name="periodo_id" value="{{$progtrab->periodo_id}}">
                                        <label>Periodo fiscal: </label>{{$progtrab->periodo_id}}                                        
                                    </td>
                                    <td style="text-align:center; vertical-align: middle; color:green;"> 
                                        <input type="hidden" id="osc_id" name="osc_id" value="{{$progtrab->osc_id}}">  
                                        <label>OSC: </label>
                                        @foreach($regosc as $osc)
                                            @if($osc->osc_id == $progtrab->osc_id)
                                                {{$osc->osc_desc}}
                                                @break
                                            @endif
                                        @endforeach
                                    </td>
                                    <td style="text-align:right; vertical-align: middle;">   
                                        <input type="hidden" id="periodo_id1" name="periodo_id1" value="{{$progtrab->periodo_id1}}">  
                                        <input type="hidden" id="mes_id1" name="mes_id1" value="{{$progtrab->mes_id1}}">  
                                        <input type="hidden" id="dia_id1" name="dia_id1" value="{{$progtrab->dia_id1}}">  
                                        <label>Responsable: </label>{{$progtrab->responsable}}
                                    </td>                                     
                                </tr>      
                                @endforeach     
                            </table>                      

                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label >Programa (500 carácteres)</label>
                                    <textarea class="form-control" name="programa_desc" id="programa_desc" rows="2" cols="120" placeholder="Programa (500 carácteres)" required>
                                    </textarea>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label >Actividad (500 carácteres)</label>
                                    <textarea class="form-control" name="actividad_desc" id="actividad_desc" rows="2" cols="120" placeholder="Actividad (300 carácteres)" required>
                                    </textarea>
                                </div>                                
                            </div>    
                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label >Objetivo (500 carácteres)</label>
                                    <textarea class="form-control" name="objetivo_desc" id="objetivo_desc" rows="2" cols="120" placeholder="Objetivo (300 carácteres)" required>
                                    </textarea>
                                </div>                                
                            </div>             

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Unidad de medida </label>
                                    <select class="form-control m-bot15" name="umedida_id" id="umedida_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar unidad de medida </option>
                                        @foreach($regumedida as $umedida)
                                            <option value="{{$umedida->umedida_id}}">{{$umedida->umedida_desc}}</option>
                                        @endforeach
                                    </select>                                  
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Meta programada enero </label>
                                    <input type="number" min="0" max="999999999999" class="form-control" name="mesp_01" id="mesp_01" placeholder="Meta programa de enero" required>
                                </div> 
                                <div class="col-xs-4 form-group">
                                    <label >Meta programada febrero </label>
                                    <input type="number" min="0" max="999999999999" class="form-control" name="mesp_02" id="mesp_02" placeholder="Meta programa de febrero" required>
                                </div> 
                                <div class="col-xs-4 form-group">
                                    <label >Meta programada marzo </label>
                                    <input type="number" min="0" max="999999999999" class="form-control" name="mesp_03" id="mesp_03" placeholder="Meta programa de marzo" required>
                                </div> 
                            </div>

                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >Meta programada abril </label>
                                    <input type="number" min="0" max="999999999999" class="form-control" name="mesp_04" id="mesp_04" placeholder="Meta programa de abril" required>
                                </div> 
                                <div class="col-xs-4 form-group">
                                    <label >Meta programada mayo </label>
                                    <input type="number" min="0" max="999999999999" class="form-control" name="mesp_05" id="mesp_05" placeholder="Meta programa de mayo" required>
                                </div> 
                                <div class="col-xs-4 form-group">
                                    <label >Meta programada junio </label>
                                    <input type="number" min="0" max="999999999999" class="form-control" name="mesp_06" id="mesp_06" placeholder="Meta programa de junio" required>
                                </div> 
                            </div>

                            <div class="row">
                                <div class="col-xs-4 form-group">
                                    <label >Meta programada julio </label>
                                    <input type="number" min="0" max="999999999999" class="form-control" name="mesp_07" id="mesp_07" placeholder="Meta programa de julio" required>
                                </div> 
                                <div class="col-xs-4 form-group">
                                    <label >Meta programada agosto </label>
                                    <input type="number" min="0" max="999999999999" class="form-control" name="mesp_08" id="mesp_08" placeholder="Meta programa de agosto" required>
                                </div> 
                                <div class="col-xs-4 form-group">
                                    <label >Meta programada septiembre </label>
                                    <input type="number" min="0" max="999999999999" class="form-control" name="mesp_09" id="mesp_09" placeholder="Meta programa de septiembre" required>
                                </div> 
                            </div>

                            <div class="row">                                
                                <div class="col-xs-4 form-group">
                                    <label >Meta programada octubre </label>
                                    <input type="number" min="0" max="999999999999" class="form-control" name="mesp_10" id="mesp_10" placeholder="Meta programa de octubre" required>
                                </div> 
                                <div class="col-xs-4 form-group">
                                    <label >Meta programada noviembre </label>
                                    <input type="number" min="0" max="999999999999" class="form-control" name="mesp_11" id="mesp_11" placeholder="Meta programa de noviembre" required>
                                </div> 
                                <div class="col-xs-4 form-group">
                                    <label >Meta programada diciembre </label>
                                    <input type="number" min="0" max="999999999999" class="form-control" name="mesp_12" id="mesp_12" placeholder="Meta programa de diciembre" required>
                                </div> 
                            </div>
                           
                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label >Observaciones (300 carácteres)</label>
                                    <textarea class="form-control" name="dobs_1" id="dobs_1" rows="2" cols="120" placeholder="Objetivo (300 carácteres)" required>
                                    </textarea>
                                </div>                                
                            </div>                                                        

                            <div class="row">
                                <div class="col-md-12 offset-md-5">
                                    {!! Form::submit('Dar de alta',['class' => 'btn btn-success btn-flat pull-right']) !!}
                                    @foreach($regprogtrab as $progtrab)
                                       <a href="{{route('verProgdtrab',$progtrab->folio)}}" role="button" id="cancelar" class="btn btn-danger">Cancelar
                                       </a>
                                       @break
                                    @endforeach                                       
                                </div>                                
                            </div>                            

                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('request')
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.1/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\progdtrabRequest','#nuevoProgdtrab') !!}
@endsection

@section('javascrpt')
<script>
    function soloNumeros(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key);
       letras = "1234567890";
       especiales = "8-37-39-46";
       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }
        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }    

    function soloAlfa(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key);
       letras = "abcdefghijklmnñopqrstuvwxyz ABCDEFGHIJKLMNÑOPQRSTUVWXYZ.";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }
        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }

    function soloLetras(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key);
       letras = "abcdefghijklmnñopqrstuvwxyz ABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }
        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }
    function general(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key);
       letras = "abcdefghijklmnñopqrstuvwxyz ABCDEFGHIJKLMNÑOPQRSTUVWXYZ1234567890,.;:-_<>!%()=?¡¿/*+";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }
        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }
    function soloAlfaSE(e){
       key = e.keyCode || e.which;
       tecla = String.fromCharCode(key);
       letras = "abcdefghijklmnñopqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ0123456789";
       especiales = "8-37-39-46";

       tecla_especial = false
       for(var i in especiales){
            if(key == especiales[i]){
                tecla_especial = true;
                break;
            }
        }
        if(letras.indexOf(tecla)==-1 && !tecla_especial){
            return false;
        }
    }    
</script>

<script>
    $('.datepicker').datepicker({
        format: "dd/mm/yyyy",
        startDate: '-29y',
        endDate: '-18y',
        startView: 2,
        maxViewMode: 2,
        clearBtn: true,        
        language: "es",
        autoclose: true
    });
</script>

@endsection
