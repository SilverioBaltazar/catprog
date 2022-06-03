@extends('sicinar.principal')

@section('title','Editar Objetivo del programa')

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
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <div class="content-wrapper">
        <section class="content-header">
            <h1><i class="fa fa-dashboard"></i>&nbsp;&nbsp;Menú.
                <small>Ficha del programa - </small>
                <small> 3. Objetivo - </small>
                <small> Editar</small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b3.jpg') }}" border="0" width="30" height="30">Objetivo</li> 
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">

                        {!! Form::open(['route' => ['actualizarobjprog',$regobjprog->periodo_id,$regobjprog->prog_id], 'method' => 'PUT', 'id' => 'actualizarobjprog', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="row">    
                                <div class="col-xs-6 form-group">
                                    <input type="hidden" id="periodo_id" name="periodo_id" value="{{$regobjprog->periodo_id}}">  
                                    <label style="color:green;">Periodo: {{$regobjprog->periodo_id}} 
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                                    </label>                         
                                </div> 
                            </div>

                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <input type="hidden" id="prog_id" name="prog_id" value="{{$regobjprog->prog_id}}">                                  
                                    <label style="color:green;">Programa y/o acción : {{$regobjprog->prog_id}}
                                        @foreach($regprograma as $program)
                                                @if($program->prog_id == $regobjprog->prog_id)
                                                    {{Trim($program->prog_desc)}}
                                                    @break
                                                @endif
                                        @endforeach                                    
                                    </label>
                                </div>                              
                            </div>

                            <div class="row">                                
                                <div class="col-xs-12 form-group">
                                    <label >1. Describir el o los objetivos del programa y/o acción (4,000 caracteres)</label>
                                    <textarea class="form-control" name="obj_prog" id="obj_prog" rows="4" cols="120" placeholder="Objetivo(s) del programa y/o acción" required>
                                    {{Trim($regobjprog->obj_prog)}}
                                    </textarea>
                                </div>                                
                            </div>
                            <div class="row">                                
                                <div class="col-xs-12 form-group">
                                    <label >2. Principales metas de Fin, Propósito y Componentes (4,000 caracteres)</label>
                                    <textarea class="form-control" name="obj_meta" id="obj_meta" rows="4" cols="120" placeholder="Fin, propósito y componentes del programa y/o acción" required>
                                    {{Trim($regobjprog->obj_meta)}}
                                    </textarea>
                                </div>                                
                            </div>                            
                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label >3. Identificación y cuatificación de la población potencial, objetivo y atendida
                                    (desagregada por sexo, grupos de eda, población indígena y municipios cuando aplique) (4,000 caracteres)</label>
                                    <textarea class="form-control" name="obj_uni_aten" id="obj_uni_aten" rows="4" cols="120" placeholder="Identificación y cuatificación de la población potencial, objetivo y atendida" required>
                                    {{Trim($regobjprog->obj_uni_aten)}}
                                    </textarea>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label >4. Cobertura y mecanismos de focalización del programa y/o acción (4,000 caracteres)</label>
                                    <textarea class="form-control" name="obj_cobertura" id="obj_cobertura" rows="4" cols="120" placeholder="Cobertura y mecanismos de focalización" required>
                                    {{Trim($regobjprog->obj_cobertura)}}
                                    </textarea>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label >5. Requisitos y criterios de selección del beneficiario (4,000 caracteres)</label>
                                    <textarea class="form-control" name="obj_req_criter" id="obj_req_criter" rows="4" cols="120" placeholder="Requisitos y criterios de selección del beneficiario" required>
                                    {{Trim($regobjprog->obj_req_criter)}}
                                    </textarea>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label >6. Documentos solicitados (4,000 caracteres)</label>
                                    <textarea class="form-control" name="obj_doctos" id="obj_doctos" rows="4" cols="120" placeholder="Documentos solicitados" required>
                                    {{Trim($regobjprog->obj_doctos)}}
                                    </textarea>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label >7. Criterios de priorización (4,000 caracteres)</label>
                                    <textarea class="form-control" name="obj_crit_priori" id="obj_crit_priori" rows="4" cols="120" placeholder="Criterios de priorización" required>
                                    {{Trim($regobjprog->obj_crit_priori)}}
                                    </textarea>
                                </div>                                
                            </div>                                                                                                                                                                        

                            <div class="row">                                
                                <div class="col-xs-12 form-group">
                                    <label >8. Especificar las zonas de atención (4,000 caracteres)</label>
                                    <textarea class="form-control" name="obj_zona_aten" id="obj_zona_aten" rows="4" cols="120" placeholder="Espeficique las zonas de atención " required>{{Trim($regobjprog->obj_zona_aten)}}
                                    </textarea>
                                </div>                                
                            </div>        
                            <div class="row">                                
                                <div class="col-xs-12 form-group">
                                    <label >9. Sectores que se apoyan con el programa y/o acción</label><br>
                                    <input type="checkbox" name="obj_sec_01" id="obj_sec_01" value="1" placeholder="Sector Desarrollo Social - Social " 
                                    @if(old('obj_sec_01',$regobjprog->obj_sec_01)=="1") checked @endif required>
                                    &nbsp; Sector Desarrollo Social - Social &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_sec_02" id="obj_sec_02" value="2" placeholder="Sector Desarrollo Social - Educación" 
                                    @if(old('obj_sec_02',$regobjprog->obj_sec_02)=="2") checked @endif required>
                                    &nbsp; Sector Desarrollo Social - Educación &nbsp;&nbsp;&nbsp;&nbsp;  <br>
                                    <input type="checkbox" name="obj_sec_03" id="obj_sec_03" value="3" placeholder="Sector Desarrollo Social - Cultura y Turismo" 
                                    @if(old('obj_sec_03',$regobjprog->obj_sec_03)=="3") checked @endif required>
                                    &nbsp; Sector Desarrollo Social - Cultura y Turismo &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_sec_04" id="obj_sec_04" value="4" placeholder="Sector Desarrollo Social - Salud y Seguridad" 
                                    @if(old('obj_sec_04',$regobjprog->obj_sec_04)=="4") checked @endif required>
                                    &nbsp; Sector Desarrollo Social - Salud y Seguridad &nbsp;&nbsp;&nbsp;&nbsp; <br>
                                    <input type="checkbox" name="obj_sec_05" id="obj_sec_05" value="5" placeholder="Sector Desarrollo Social - Desarrollo Urbano y Regional" 
                                    @if(old('obj_sec_05',$regobjprog->obj_sec_05)=="5") checked @endif required>
                                    &nbsp; Sector Desarrollo Territorial - Desarrollo Urbano y Regional &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_sec_06" id="obj_sec_06" value="6" placeholder="Sector Desarrollo Territorial - Energía Asequible no contaminante" 
                                    @if(old('obj_sec_06',$regobjprog->obj_sec_06)=="6") checked @endif required>
                                    &nbsp; Sector Desarrollo Territorial - Energía Asequible no contaminante &nbsp;&nbsp;&nbsp;&nbsp;<br>

                                    <input type="checkbox" name="obj_sec_07" id="obj_sec_07" value="7" placeholder="Sector Desarrollo Territorial - Medio Ambiente " 
                                    @if(old('obj_sec_07',$regobjprog->obj_sec_07)=="7") checked @endif required>
                                    &nbsp; Sector Desarrollo Territorial - Medio Ambiente &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_sec_08" id="obj_sec_08" value="8" placeholder="Sector Desarrollo Territorial - Manejo y Control de Recursos Hidrícos" 
                                    @if(old('obj_sec_08',$regobjprog->obj_sec_08)=="8") checked @endif required>
                                    &nbsp; Sector Desarrollo Territorial - Manejo y Control de Recursos Hidrícos &nbsp;&nbsp;&nbsp;&nbsp;<br>
                                    <input type="checkbox" name="obj_sec_09" id="obj_sec_09" value="9" placeholder="Sector Seguridad - Seguridad Pública" 
                                    @if(old('obj_sec_09',$regobjprog->obj_sec_09)=="9") checked @endif required>
                                    &nbsp; Sector Seguridad - Seguridad Pública &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_sec_10" id="obj_sec_10" value="10" placeholder="Sector Seguridad - Procuraduria e impartición de Justicia" 
                                    @if(old('obj_sec_10',$regobjprog->obj_sec_10)=="10") checked @endif required>
                                    &nbsp; Sector Seguridad - Procuraduria e impartición de Justicia &nbsp;&nbsp;&nbsp;&nbsp;<br>
                                    <input type="checkbox" name="obj_sec_11" id="obj_sec_11" value="11" placeholder="Sector Seguridad - Protección de los Derechos Humanos" 
                                    @if(old('obj_sec_11',$regobjprog->obj_sec_11)=="11") checked @endif required>
                                    &nbsp; Sector Seguridad - Protección de los Derechos Humanos &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_sec_12" id="obj_sec_12" value="12" placeholder="Sector Gobierno - Administración y Finanzas " 
                                    @if(old('obj_sec_12',$regobjprog->obj_sec_12)=="12") checked @endif required>
                                    &nbsp; Sector Gobierno - Administración y Finanzas &nbsp;&nbsp;&nbsp;&nbsp;  <br>

                                    <input type="checkbox" name="obj_sec_13" id="obj_sec_13" value="13" placeholder="Sector Gobierno - Gobernabilidad " 
                                    @if(old('obj_sec_13',$regobjprog->obj_sec_13)=="13") checked @endif required>
                                    &nbsp; Sector Gobierno - Gobernabilidad &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_sec_14" id="obj_sec_14" value="14" placeholder="Sector Gobierno - Sistema Anticorrupción" 
                                    @if(old('obj_sec_14',$regobjprog->obj_sec_14)=="14") checked @endif required>
                                    &nbsp; Sector Gobierno - Sistema Anticorrupción &nbsp;&nbsp;&nbsp;&nbsp; <br>
                                    <input type="checkbox" name="obj_sec_15" id="obj_sec_15" value="15" placeholder="Sector Gobierno - Gobierno digital" 
                                    @if(old('obj_sec_15',$regobjprog->obj_sec_15)=="15") checked @endif required>
                                    &nbsp; Sector Gobierno - Gobierno digital &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_sec_16" id="obj_sec_16" value="16" placeholder="Sector Gobierno - Órganos electorales" 
                                    @if(old('obj_sec_16',$regobjprog->obj_sec_16)=="16") checked @endif required>
                                    &nbsp; Sector Gobierno - Órganos electorales &nbsp;&nbsp;&nbsp;&nbsp; <br>
                                    <input type="checkbox" name="obj_sec_17" id="obj_sec_17" value="17" placeholder="Poderes Legislativo y Judicial - Legislativo " 
                                    @if(old('obj_sec_17',$regobjprog->obj_sec_17)=="17") checked @endif required>
                                    &nbsp; Poderes Legislativo y Judicial - Legislativo &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_sec_18" id="obj_sec_18" value="18" placeholder="Poderes Legislativo y Judicial - Judicial " 
                                    @if(old('obj_sec_18',$regobjprog->obj_sec_18)=="18") checked @endif required>
                                    &nbsp; Poderes Legislativo y Judicial - Judicial &nbsp;&nbsp;&nbsp;&nbsp; <br>                                                                       

                                    <input type="checkbox" name="obj_sec_19" id="obj_sec_19" value="19" placeholder="Sector Desarrollo Económico - Empleo " 
                                    @if(old('obj_sec_19',$regobjprog->obj_sec_19)=="19") checked @endif required>
                                    &nbsp; Sector Desarrollo Económico - Empleo  &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_sec_20" id="obj_sec_20" value="20" placeholder="Sector Desarrollo Económico - Movilidad" 
                                    @if(old('obj_sec_20',$regobjprog->obj_sec_20)=="20") checked @endif required>
                                    &nbsp; Sector Desarrollo Económico - Movilidad &nbsp;&nbsp;&nbsp;&nbsp; <br>
                                    <input type="checkbox" name="obj_sec_21" id="obj_sec_21" value="21" placeholder="Sector Desarrollo Económico - Económico" 
                                    @if(old('obj_sec_21',$regobjprog->obj_sec_21)=="21") checked @endif required>
                                    &nbsp; Sector Desarrollo Económico - Económico &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_sec_22" id="obj_sec_22" value="22" placeholder="Sector Desarrollo Económico - Agropecuario" 
                                    @if(old('obj_sec_22',$regobjprog->obj_sec_22)=="22") checked @endif required>
                                    &nbsp; Sector Desarrollo Económico - Agropecuario &nbsp;&nbsp;&nbsp;&nbsp; 
                                </div>                                
                            </div>                                    

                            <div class="row">
                                <div class="col-xs-8 form-group">
                                    <label >10. La operación/ejecución del programa y/o acción es </label><br>
                                    <input type="checkbox" name="obj_oper_ejec1" id="obj_oper_ejec1" value="F" placeholder="Federal " 
                                    @if(old('obj_oper_ejec1',$regobjprog->obj_oper_ejec1)=="F") checked @endif required>
                                    &nbsp; Federal &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_oper_ejec2" id="obj_oper_ejec2" value="E" placeholder="Estatal" 
                                    @if(old('obj_oper_ejec2',$regobjprog->obj_oper_ejec2)=="E") checked @endif required>
                                    &nbsp; Estatal &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_oper_ejec3" id="obj_oper_ejec3" value="M" placeholder="Municipal" 
                                    @if(old('obj_oper_ejec3',$regobjprog->obj_oper_ejec3)=="M") checked @endif required>
                                    &nbsp; Municipal &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_oper_ejec4" id="obj_oper_ejec4" value="P" placeholder="Privado" 
                                    @if(old('obj_oper_ejec4',$regobjprog->obj_oper_ejec4)=="P") checked @endif required>
                                    &nbsp; Privado &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_oper_ejec5" id="obj_oper_ejec5" value="O" placeholder="Otro" 
                                    @if(old('obj_oper_ejec5',$regobjprog->obj_oper_ejec5)=="O") checked @endif required>
                                    &nbsp; Otro &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_oper_ejec6" id="obj_oper_ejec6" value="N" placeholder="No definido" 
                                    @if(old('obj_oper_ejec6',$regobjprog->obj_oper_ejec6)=="N") checked @endif required>
                                    &nbsp; No definido &nbsp;&nbsp;&nbsp;&nbsp;
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xs-8 form-group">
                                    <label >11. Señalar a cuáles de los 17 Objetivos de la Agenda 2030 se alinea el programa y/o acción</label><br>
                                    <div class="col-xs-5 form-group" style="text-align:left;">
                                         <img src="{{ asset('images/AGENDA2030.JPG') }}" title="Agenda 2030" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>
                                    </div>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <div class="col-xs-5 form-group" style="text-align:center;">
                                         <img src="{{ asset('images/ODS.JPG') }}"        title="Objetivos del Desarrollo Sostenible" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>
                                    </div>       
                                </div>
                            </div>
                            <div class="row">                         
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods01" id="obj_ods01" value="S" placeholder="ODS 1"
                                    @if(old('obj_ods01',$regobjprog->obj_ods01)=="S") checked @endif required>
                                    <img src="{{ asset('images/ODSd1.GIF') }}"   title="ODS 1" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>   
                                    &nbsp;&nbsp;&nbsp;
                                </div>
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods02" id="obj_ods02" value="S" placeholder="ODS 2" 
                                    @if(old('obj_ods02',$regobjprog->obj_ods02)=="S") checked @endif required>
                                    <img src="{{ asset('images/ODSd2.GIF') }}"  title="ODS 2" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>                                    
                                    &nbsp;&nbsp;&nbsp;
                                </div>
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods03" id="obj_ods03" value="S" placeholder="ODS 3" 
                                    @if(old('obj_ods03',$regobjprog->obj_ods03)=="S") checked @endif required>
                                    <img src="{{ asset('images/ODSd3.GIF') }}"  title="ODS 3" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>                                    
                                </div>    
                            </div>
                            <div class="row">                                                                                     
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods04" id="obj_ods04" value="S" placeholder="ODS 4" 
                                    @if(old('obj_ods04',$regobjprog->obj_ods04)=="S") checked @endif required>
                                    <img src="{{ asset('images/ODSd4.GIF') }}"  title="ODS 4" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>                                    
                                    &nbsp;&nbsp;&nbsp;
                                </div>
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods05" id="obj_ods05" value="S" placeholder="ODS 5" 
                                    @if(old('obj_ods05',$regobjprog->obj_ods05)=="S") checked @endif required>
                                    <img src="{{ asset('images/ODSd5.GIF') }}"  title="ODS 5" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>                                       
                                    &nbsp;&nbsp;&nbsp;
                                </div>
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods06" id="obj_ods06" value="S" placeholder="ODS 6" 
                                    @if(old('obj_ods06',$regobjprog->obj_ods06)=="S") checked @endif required>
                                    <img src="{{ asset('images/ODSd6.GIF') }}"  title="ODS 6" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>                                         
                                </div>
                            </div>
                            <div class="row">                                      
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods07" id="obj_ods07" value="S" placeholder="ODS 7" 
                                    @if(old('obj_ods07',$regobjprog->obj_ods07)=="S") checked @endif required>
                                    <img src="{{ asset('images/ODSd7.GIF') }}"   title="ODS 7" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>   
                                    &nbsp;&nbsp;&nbsp;
                                </div>
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods08" id="obj_ods08" value="S" placeholder="ODS 8" 
                                    @if(old('obj_ods08',$regobjprog->obj_ods08)=="S") checked @endif required>
                                    <img src="{{ asset('images/ODSd8.GIF') }}"  title="ODS 8" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>                                    
                                    &nbsp;&nbsp;&nbsp;
                                </div>
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods09" id="obj_ods09" value="S" placeholder="ODS 9" 
                                    @if(old('obj_ods09',$regobjprog->obj_ods09)=="S") checked @endif required>
                                    <img src="{{ asset('images/ODSd9.GIF') }}"  title="ODS 9" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>                                    
                                </div>    
                            </div>
                            <div class="row">                                                  
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods10" id="obj_ods10" value="S" placeholder="ODS 10" 
                                    @if(old('obj_ods10',$regobjprog->obj_ods10)=="S") checked @endif required>
                                    <img src="{{ asset('images/ODSd10.GIF') }}"  title="ODS 10" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>                                    
                                    &nbsp;&nbsp;&nbsp;
                                </div>
                                <div class="col-xs-4 form-group" style="text-align:left;">                                    
                                    <input type="checkbox" name="obj_ods11" id="obj_ods11" value="S" placeholder="ODS 11" 
                                    @if(old('obj_ods11',$regobjprog->obj_ods11)=="S") checked @endif required>
                                    <img src="{{ asset('images/ODSd11.GIF') }}"  title="ODS 11" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>                                       
                                    &nbsp;&nbsp;&nbsp;
                                </div>
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods12" id="obj_ods12" value="S" placeholder="ODS 12" 
                                    @if(old('obj_ods12',$regobjprog->obj_ods12)=="S") checked @endif required>
                                    <img src="{{ asset('images/ODSd12.GIF') }}"  title="ODS 12" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>                                         
                                </div>                  
                            </div>
                            <div class="row">                                                  
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods13" id="obj_ods13" value="S" placeholder="ODS 13" 
                                    @if(old('obj_ods13',$regobjprog->obj_ods13)=="S") checked @endif required>
                                    <img src="{{ asset('images/ODSd13.GIF') }}"   title="ODS 13" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>   
                                    &nbsp;&nbsp;&nbsp;
                                </div>
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods14" id="obj_ods14" value="S" placeholder="ODS 14" 
                                    @if(old('obj_ods14',$regobjprog->obj_ods14)=="S") checked @endif required>
                                    <img src="{{ asset('images/ODSd14.GIF') }}"  title="ODS 14" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>                                    
                                    &nbsp;&nbsp;&nbsp;
                                </div>
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods15" id="obj_ods15" value="S" placeholder="ODS 15" 
                                    @if(old('obj_ods15',$regobjprog->obj_ods15)=="S") checked @endif required>
                                    <img src="{{ asset('images/ODSd15.GIF') }}"  title="ODS 15" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>                                    
                                </div>    
                            </div>
                            <div class="row">                                                  
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods16" id="obj_ods16" value="S" placeholder="ODS 16" 
                                    @if(old('obj_ods16',$regobjprog->obj_ods16)=="S") checked @endif required>
                                    <img src="{{ asset('images/ODSd16.GIF') }}"  title="ODS 16" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>                                    
                                    &nbsp;&nbsp;&nbsp;
                                </div>
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods17" id="obj_ods17" value="S" placeholder="ODS 17" 
                                    @if(old('obj_ods17',$regobjprog->obj_ods17)=="S") checked @endif required>
                                    <img src="{{ asset('images/ODSd17.GIF') }}"  title="ODS 17" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>                                       
                                    &nbsp;&nbsp;&nbsp;
                                </div>                                                                
                            </div>

                            <div class="row">
                                <div class="col-xs-12 form-group" style="text-align:left;">
                                    <label >12. Señalar a que pilares y ejes transversales del Plan de Desarrollo del Estado de México (PDEM) se alinea el programa y/o acción</label><br>
                                    <img src="{{ asset('images/PDEM.JPG') }}" title="Plan de Desarrollo del Estado de México" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-3 form-group" style="text-align:left;">
                                    <img src="{{ asset('images/pilares.jpg') }}" title="Pilares" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>
                                </div>
                            </div>
                            <div class="row">           
                                <div class="col-xs-3 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_pdem01" id="obj_pdem01" value="S" placeholder="Pilar Social" 
                                    @if(old('obj_pdem01',$regobjprog->obj_pdem01)=="S") checked @endif required>
                                    <img src="{{ asset('images/pdem_pilarsocial.jpg') }}" width="80" height="80"  title="Pilar Social" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>   
                                    &nbsp;&nbsp;
                                </div>
                                <div class="col-xs-3 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_pdem02" id="obj_pdem02" value="S" placeholder="Pilar económico" 
                                    @if(old('obj_pdem02',$regobjprog->obj_pdem02)=="S") checked @endif required>
                                    <img src="{{ asset('images/PDEM_PILARECONOM.JPG') }}"  width="80" height="80" title="Pilar económico" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>   
                                    &nbsp;&nbsp;
                                </div>
                                <div class="col-xs-3 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_pdem03" id="obj_pdem03" value="S" placeholder="Pilar territorial" 
                                    @if(old('obj_pdem03',$regobjprog->obj_pdem03)=="S") checked @endif required>
                                    <img src="{{ asset('images/PDEM_PILARTERRITORIAL.JPG') }}" width="80" height="80" title="Pilar territorial" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>   
                                    &nbsp;&nbsp;
                                </div>
                                <div class="col-xs-3 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_pdem04" id="obj_pdem04" value="S" placeholder="Pilar seguridad" 
                                    @if(old('obj_pdem04',$regobjprog->obj_pdem04)=="S") checked @endif required>
                                    <img src="{{ asset('images/PDEM_PILARSEGURIDAD.JPG') }}" width="80" height="80" title="Pilar seguridad" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>   
                                    &nbsp;&nbsp;
                                </div>                                
                            </div>

                            <div class="row">
                                <div class="col-xs-3 form-group" style="text-align:center;">
                                    <img src="{{ asset('images/ejes_transversales.jpg') }}" title="Ejes transversales" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>
                                </div>
                            </div>                            
                            <div class="row">           
                                <div class="col-xs-3 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_pdem05" id="obj_pdem05" value="S" placeholder="Igualdad de genero" 
                                    @if(old('obj_pdem05',$regobjprog->obj_pdem05)=="S") checked @endif required>
                                    <img src="{{ asset('images/pdem_et1.jpg') }}" width="80" height="80" title="Igualdad de genero" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>   
                                    &nbsp;&nbsp;
                                </div>
                                <div class="col-xs-3 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_pdem06" id="obj_pdem06" value="S" placeholder="Gobierno capaz y responsable" 
                                    @if(old('obj_pdem06',$regobjprog->obj_pdem06)=="S") checked @endif required>
                                    <img src="{{ asset('images/pdem_et2.jpg') }}" width="80" height="80" title="Gobierno capaz y responsable" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>   
                                    &nbsp;&nbsp;
                                </div>
                                <div class="col-xs-3 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_pdem07" id="obj_pdem07" value="S" placeholder="Conectividad y tecnologia para el buen gobierno" 
                                    @if(old('obj_pdem07',$regobjprog->obj_pdem07)=="S") checked @endif required>
                                    <img src="{{ asset('images/pdem_et3.jpg') }}" width="80" height="80" title="Conectividad y tecnologia para el buen gobierno" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>   
                                    &nbsp;&nbsp;
                                </div>
                            </div>

                            <div class="row">    
                                <div class="col-xs-4 form-group">
                                    <label >13. Fecha de inicio del programa y/o acción - Año </label>
                                    <select class="form-control m-bot15" name="periodo_id1" id="periodo_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar año </option>
                                        @foreach($regperiodos as $anio)
                                            @if($anio->periodo_id == $regobjprog->periodo_id1)
                                                <option value="{{$anio->periodo_id}}" selected>{{$anio->periodo_desc}}</option>
                                            @else                                        
                                               <option value="{{$anio->periodo_id}}">{{$anio->periodo_desc}}</option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>   
                                <div class="col-xs-4 form-group">
                                    <label >Mes </label>
                                    <select class="form-control m-bot15" name="mes_id1" id="mes_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar mes  </option>
                                        @foreach($regmeses as $mes)
                                            @if($mes->mes_id == $regobjprog->mes_id1)
                                                <option value="{{$mes->mes_id}}" selected>{{$mes->mes_desc}}</option>
                                            @else                                        
                                               <option value="{{$mes->mes_id}}">{{$mes->mes_desc}} </option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>    
                                <div class="col-xs-4 form-group">
                                    <label >Día </label>
                                    <select class="form-control m-bot15" name="dia_id1" id="dia_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar día </option>
                                        @foreach($regdias as $dia)
                                            @if($dia->dia_id == $regobjprog->dia_id1)
                                                <option value="{{$dia->dia_id}}" selected>{{$dia->dia_desc}}</option>
                                            @else                                        
                                               <option value="{{$dia->dia_id}}">{{$dia->dia_desc}} </option>
                                            @endif
                                        @endforeach
                                    </select>                                    
                                </div>                                    
                            </div>

                            <div class="row">
                                @if(count($errors) > 0)
                                    <div class="alert alert-danger" role="alert">
                                        <ul>
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="col-md-12 offset-md-5">
                                    {!! Form::submit('Registrar',['class' => 'btn btn-success btn-flat pull-right']) !!}
                                    <a href="{{route('verobjprog')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
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
    {!! JsValidator::formRequest('App\Http\Requests\objprogRequest','#actualizarobjprog') !!}
@endsection

@section('javascrpt')

@endsection