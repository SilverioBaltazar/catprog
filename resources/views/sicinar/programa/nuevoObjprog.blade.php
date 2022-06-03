@extends('sicinar.principal')

@section('title','Nueva Objetivo del programa')

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
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <div class="content-wrapper">
        <section class="content-header">
            <h1><i class="fa fa-dashboard"></i>&nbsp;&nbsp;Menú.
                <small>Ficha del programa - </small>
                <small> 3. Objetivo - </small>
                <small> Nuevo</small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b3.jpg') }}" border="0" width="30" height="30">Objetivo</li> 
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">

                    <div class="box box-success">
                        {!! Form::open(['route' => 'altanuevoobjprog', 'method' => 'POST','id' => 'nuevoobjprog', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">
                            <div class="row">
                                <div class="col-xs-6 form-group">
                                    <label >Periodo  </label>
                                    <select class="form-control m-bot15" name="periodo_id" id="periodo_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar periodo </option>
                                        @foreach($regperiodos as $periodo)
                                            <option value="{{$periodo->periodo_id}}">{{$periodo->periodo_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>    
                            </div>           
                            <div class="row">                     
                                <div class="col-xs-6 form-group">
                                    <label >Programa y/o acción </label>
                                    <select class="form-control m-bot15" name="prog_id" id="prog_id" required>
                                        <option selected="true" disabled="disabled">Seleccionar programa y/o acción </option>
                                        @foreach($regprograma as $prog)
                                            <option value="{{$prog->prog_id}}">{{$prog->prog_id.' '.trim($prog->prog_desc)}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>                                                               
                            </div>

                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label >1. Describir el o los objetivos del programa y/o acción (4,000 caracteres)</label>
                                    <textarea class="form-control" name="obj_prog" id="obj_prog" rows="4" cols="120" placeholder="Objetivo(s) del programa y/o acción" required>
                                    </textarea>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label >2. Principales metas de Fin, Propósito y Componentes (4,000 caracteres)</label>
                                    <textarea class="form-control" name="obj_meta" id="obj_meta" rows="4" cols="120" placeholder="Principales metas de Fin, Propósito y Componentes" required>
                                    </textarea>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label >3. Identificación y cuatificación de la población potencial, objetivo y atendida
                                    (desagregada por sexo, grupos de eda, población indígena y municipios cuando aplique) (4,000 caracteres)</label>
                                    <textarea class="form-control" name="obj_uni_aten" id="obj_uni_aten" rows="4" cols="120" placeholder="Identificación y cuatificación de la población potencial, objetivo" required>
                                    </textarea>
                                </div>                                
                            </div>                            
                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label >4. Cobertura y mecanismos de focalización del programa y/o acción (4,000 caracteres)</label>
                                    <textarea class="form-control" name="obj_cobertura" id="obj_cobertura" rows="4" cols="120" placeholder="Cobertura y mecanismos de focalización del programa y/o acción" required>
                                    </textarea>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label >5. Requisitos y criterios de selección del beneficiario (4,000 caracteres)</label>
                                    <textarea class="form-control" name="obj_req_criter" id="obj_req_criter" rows="4" cols="120" placeholder="Requisitos y criterios de selección del beneficiario" required>
                                    </textarea>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label >6. Documentos solicitados (4,000 caracteres)</label>
                                    <textarea class="form-control" name="obj_doctos" id="obj_doctos" rows="4" cols="120" placeholder="Documentos solicitados" required>
                                    </textarea>
                                </div>                                
                            </div>
                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label >7. Criterios de priorización (4,000 caracteres)</label>
                                    <textarea class="form-control" name="obj_crit_priori" id="obj_crit_priori" rows="4" cols="120" placeholder="Criterios de priorización" required>
                                    </textarea>
                                </div>                                
                            </div>                                                                                                                                                                        
                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label >8. Especificar las zonas de atención (4,000 caracteres)</label>
                                    <textarea class="form-control" name="obj_zona_aten" id="obj_zona_aten" rows="4" cols="120" placeholder="Zonas de atención" required>
                                    </textarea>
                                </div>                                
                            </div>            
                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label >9. Sectores que se apoyan con el programa y/o acción</label><br>
                                    <input type="checkbox" name="obj_sec_01" id="obj_sec_01" value="1" placeholder="Sector Desarrollo Social - Social " required>
                                    &nbsp; Sector Desarrollo Social - Social &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_sec_02" id="obj_sec_02" value="2" placeholder="Sector Desarrollo Social - Educación" required>
                                    &nbsp; Sector Desarrollo Social - Educación &nbsp;&nbsp;&nbsp;&nbsp; <br>
                                    <input type="checkbox" name="obj_sec_03" id="obj_sec_03" value="3" placeholder="Sector Desarrollo Social - Cultura y Turismo" required>
                                    &nbsp; Sector Desarrollo Social - Cultura y Turismo &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_sec_04" id="obj_sec_04" value="4" placeholder="Sector Desarrollo Social - Salud y Seguridad" required>
                                    &nbsp; Sector Desarrollo Social - Salud y Seguridad &nbsp;&nbsp;&nbsp;&nbsp;<br>
                                    <input type="checkbox" name="obj_sec_05" id="obj_sec_05" value="5" placeholder="Sector Desarrollo Territorial - Desarrollo Urbano y Regional" required>
                                    &nbsp; Sector Desarrollo Territorial - Desarrollo Urbano y Regional  &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_sec_06" id="obj_sec_06" value="6" placeholder="Sector Desarrollo Territorial - Energía Asequible no contaminante" required>
                                    &nbsp; Sector Desarrollo Territorial - Energía Asequible no contaminante &nbsp;&nbsp;&nbsp;&nbsp;<br>

                                    <input type="checkbox" name="obj_sec_07" id="obj_sec_07" value="7" placeholder="Sector Desarrollo Territorial - Medio Ambiente" required>
                                    &nbsp; Sector Desarrollo Territorial - Medio Ambiente &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_sec_08" id="obj_sec_08" value="8" placeholder="Sector Desarrollo Territorial - Manejo y Control de Recursos Hidrícos" required>
                                    &nbsp; Sector Desarrollo Territorial - Manejo y Control de Recursos Hidrícos &nbsp;&nbsp;&nbsp;&nbsp; <br>
                                    <input type="checkbox" name="obj_sec_09" id="obj_sec_09" value="9" placeholder="Sector Seguridad - Seguridad Pública" required>
                                    &nbsp; Sector Seguridad - Seguridad Pública &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_sec_10" id="obj_sec_10" value="10" placeholder="Sector Seguridad - Procuraduria e impartición de Justicia" required>
                                    &nbsp; Sector Seguridad - Procuraduria e impartición de Justicia &nbsp;&nbsp;&nbsp;&nbsp;<br>
                                    <input type="checkbox" name="obj_sec_11" id="obj_sec_11" value="11" placeholder="Sector Seguridad - Protección de los Derechos Humanos" required>
                                    &nbsp; Sector Seguridad - Protección de los Derechos Humanos  &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_sec_12" id="obj_sec_12" value="12" placeholder="Sector Gobierno - Administración y Finanzas" required>
                                    &nbsp; Sector Gobierno - Administración y Finanzas &nbsp;&nbsp;&nbsp;&nbsp;<br>                                    

                                    <input type="checkbox" name="obj_sec_13" id="obj_sec_13" value="13" placeholder="Sector Gobierno - Gobernabilidad" required>
                                    &nbsp; Sector Gobierno - Gobernabilidad &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_sec_14" id="obj_sec_14" value="14" placeholder="Sector Gobierno - Sistema Anticorrupción" required>
                                    &nbsp; Sector Gobierno - Sistema Anticorrupción &nbsp;&nbsp;&nbsp;&nbsp; <br>
                                    <input type="checkbox" name="obj_sec_15" id="obj_sec_15" value="15" placeholder="Sector Gobierno - Gobierno digital" required>
                                    &nbsp; Sector Gobierno - Gobierno digital &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_sec_16" id="obj_sec_16" value="16" placeholder="Sector Gobierno - Órganos electorales" required>
                                    &nbsp; Sector Gobierno - Órganos electorales &nbsp;&nbsp;&nbsp;&nbsp;<br>
                                    <input type="checkbox" name="obj_sec_17" id="obj_sec_17" value="17" placeholder="Poderes Legislativo y Judicial - Legislativo" required>
                                    &nbsp; Poderes Legislativo y Judicial - Legislativo &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_sec_18" id="obj_sec_18" value="18" placeholder="Poderes Legislativo y Judicial - Judicial" required>
                                    &nbsp; Poderes Legislativo y Judicial - Judicial &nbsp;&nbsp;&nbsp;&nbsp;<br>  

                                    <input type="checkbox" name="obj_sec_19" id="obj_sec_19" value="19" placeholder="Sector Desarrollo Económico - Empleo " required>
                                    &nbsp; Sector Desarrollo Económico - Empleo  &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_sec_20" id="obj_sec_20" value="20" placeholder="Sector Desarrollo Económico - Movilidad" required>
                                    &nbsp; Sector Desarrollo Económico - Movilidad &nbsp;&nbsp;&nbsp;&nbsp; <br>
                                    <input type="checkbox" name="obj_sec_21" id="obj_sec_21" value="21" placeholder="Sector Desarrollo Económico - Económico" required>
                                    &nbsp; Sector Desarrollo Económico - Económico &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_sec_22" id="obj_sec_22" value="22" placeholder="Sector Desarrollo Económico - Agropecuario" required>
                                    &nbsp; Sector GobieSector Desarrollo Económico - Agropecuario  &nbsp;&nbsp;&nbsp;&nbsp;<br>
                                </div>                                
                            </div>    
                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <label >10. La operación/ejecución del programa y/o acción es</label><br>
                                    <input type="checkbox" name="obj_oper_ejec1" id="obj_oper_ejec1" value="F" placeholder="Federal" required>
                                    &nbsp; Federal &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_oper_ejec2" id="obj_oper_ejec2" value="E" placeholder="Estatal" required>
                                    &nbsp; Estatal &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_oper_ejec3" id="obj_oper_ejec3" value="M" placeholder="Municipal" required>
                                    &nbsp; Municipal &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_oper_ejec4" id="obj_oper_ejec4" value="P" placeholder="Privado" required>
                                    &nbsp; Privado &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_oper_ejec5" id="obj_oper_ejec5" value="O" placeholder="Otro" required>
                                    &nbsp; Otro &nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="checkbox" name="obj_oper_ejec6" id="obj_oper_ejec6" value="N" placeholder="No definido" required>
                                    &nbsp; No definido &nbsp;&nbsp;&nbsp;&nbsp;
                                </div>
                            </div>
                            <div class="row">
                                <label >11. Señalar a cuáles de los 17 Objetivos de la Agenda 2030 se alinea el programa y/o acción</label><br>
                                <div class="col-xs-8 form-group" style="text-align:left;">
                                    <img src="{{ asset('images/AGENDA2030.JPG') }}" title="Agenda 2030" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>
                                </div>
                                <div class="col-xs-5 form-group" style="text-align:center;">
                                    <img src="{{ asset('images/ODS.JPG') }}"        title="Objetivos del Desarrollo Sostenible" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>
                                </div>       
                            </div>
                            <div class="row">           
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods01" id="obj_ods01" value="S" placeholder="ODS 1" required>
                                    <img src="{{ asset('images/ODSd1.GIF') }}"   title="ODS 1" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>   
                                    &nbsp;&nbsp;
                                </div>
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods02" id="obj_ods02" value="S" placeholder="ODS 2" required>
                                    <img src="{{ asset('images/ODSd2.GIF') }}"  title="ODS 2" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>                                    
                                    &nbsp;&nbsp;
                                </div>
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods03" id="obj_ods03" value="S" placeholder="ODS 3" required>
                                    <img src="{{ asset('images/ODSd3.GIF') }}"  title="ODS 3" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>                                    
                                </div>    
                            </div>
                            <div class="row">                                                                                     
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods04" id="obj_ods04" value="S" placeholder="ODS 4" required>
                                    <img src="{{ asset('images/ODSd4.GIF') }}"  title="ODS 4" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>                                    
                                    &nbsp;&nbsp;
                                </div>
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods05" id="obj_ods05" value="S" placeholder="ODS 5" required>
                                    <img src="{{ asset('images/ODSd5.GIF') }}"  title="ODS 5" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>                                       
                                    &nbsp;&nbsp;
                                </div>
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods06" id="obj_ods06" value="S" placeholder="ODS 6" required>
                                    <img src="{{ asset('images/ODSd6.GIF') }}"  title="ODS 6" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>                                         
                                </div>
                            </div> 
                            <div class="row">                                      
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods07" id="obj_ods07" value="S" placeholder="ODS 7" required>
                                    <img src="{{ asset('images/ODSd7.GIF') }}"   title="ODS 7" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>   
                                    &nbsp;&nbsp;
                                </div>
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods08" id="obj_ods08" value="S" placeholder="ODS 8" required>
                                    <img src="{{ asset('images/ODSd8.GIF') }}"  title="ODS 8" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>                                    
                                    &nbsp;&nbsp;
                                </div>
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods09" id="obj_ods09" value="S" placeholder="ODS 9" required>
                                    <img src="{{ asset('images/ODSd9.GIF') }}"  title="ODS 9" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>                                    
                                </div>    
                            </div>
                            <div class="row">                                                  
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods10" id="obj_ods10" value="S" placeholder="ODS 10" required>
                                    <img src="{{ asset('images/ODSd10.GIF') }}"  title="ODS 10" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>                                    
                                    &nbsp;&nbsp;
                                </div>
                                <div class="col-xs-4 form-group" style="text-align:left;">                                    
                                    <input type="checkbox" name="obj_ods11" id="obj_ods11" value="S" placeholder="ODS 11" required>
                                    <img src="{{ asset('images/ODSd11.GIF') }}"  title="ODS 11" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>                                       
                                    &nbsp;&nbsp;
                                </div>
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods12" id="obj_ods12" value="S" placeholder="ODS 12" required>
                                    <img src="{{ asset('images/ODSd12.GIF') }}"  title="ODS 12" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>                                         
                                </div>                  
                            </div>
                            <div class="row">                                                  
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods13" id="obj_ods13" value="S" placeholder="ODS 13" required>
                                    <img src="{{ asset('images/ODSd13.GIF') }}"   title="ODS 13" />   
                                    &nbsp;&nbsp;
                                </div>
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods14" id="obj_ods14" value="S" placeholder="ODS 14" required>
                                    <img src="{{ asset('images/ODSd14.GIF') }}"  title="ODS 14" />                                    
                                    &nbsp;&nbsp;
                                </div>
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods15" id="obj_ods15" value="S" placeholder="ODS 15" required>
                                    <img src="{{ asset('images/ODSd15.GIF') }}"  title="ODS 15" />                                    
                                </div>    
                            </div>
                            <div class="row">                                                  
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods16" id="obj_ods16" value="S" placeholder="ODS 16" required>
                                    <img src="{{ asset('images/ODSd16.GIF') }}"  title="ODS 16" />                                    
                                    &nbsp;&nbsp;&nbsp;
                                </div>
                                <div class="col-xs-4 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_ods17" id="obj_ods17" value="S" placeholder="ODS 17" required>
                                    <img src="{{ asset('images/ODSd17.GIF') }}"  title="ODS 17" />  
                                </div>                                                                
                            </div>

                            <div class="row">
                                <div class="col-xs-12 form-group" style="text-align:center;">
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
                                    <input type="checkbox" name="obj_pdem01" id="obj_pdem01" value="S" placeholder="Pilar Social" required>
                                    <img src="{{ asset('images/pdem_pilarsocial.jpg') }}"   width="80" height="80" title="Pilar Social"/>   
                                    &nbsp;&nbsp;
                                </div>
                                <div class="col-xs-3 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_pdem02" id="obj_pdem02" value="S" placeholder="Pilar económico" required>
                                    <img src="{{ asset('images/PDEM_PILARECONOM.JPG') }}"  width="80" height="80" title="Pilar económico"/>
                                    &nbsp;&nbsp;
                                </div>
                                <div class="col-xs-3 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_pdem03" id="obj_pdem03" value="S" placeholder="Pilar territorial" required>
                                    <img src="{{ asset('images/PDEM_PILARTERRITORIAL.JPG') }}"  width="80" height="80" title="Pilar territorial"/>                                    
                                    &nbsp;&nbsp;
                                </div>    
                                <div class="col-xs-3 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_pdem04" id="obj_pdem04" value="S" placeholder="Pilar seguridad" required>
                                    <img src="{{ asset('images/PDEM_PILARSEGURIDAD.JPG') }}" width="80" height="80" title="Pilar seguridad" />                                    
                                </div>                                    
                            </div>

                            <div class="row">
                                <div class="col-xs-3 form-group" style="text-align:center;">
                                    <img src="{{ asset('images/ejes_transversales.jpg') }}" title="Ejes transversales" style="text-align:center;margin-right: 15px;vertical-align: middle;"/>
                                </div>
                            </div>
                            <div class="row">           
                                <div class="col-xs-3 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_pdem05" id="obj_pdem05" value="S" placeholder="Igualdad de genero" required>
                                    <img src="{{ asset('images/pdem_et1.jpg') }}"  width="80" height="80" title="Igualdad de genero"/>   
                                    &nbsp;&nbsp;&nbsp;
                                </div>
                                <div class="col-xs-3 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_pdem06" id="obj_pdem06" value="S" placeholder="Gobierno capaz y responsable" required>
                                    <img src="{{ asset('images/pdem_et2.jpg') }}" width="80" height="80" title="Gobierno capaz y responsable" />
                                    &nbsp;&nbsp;&nbsp;
                                </div>
                                <div class="col-xs-3 form-group" style="text-align:left;">
                                    <input type="checkbox" name="obj_pdem07" id="obj_pdem07" value="S" placeholder="Conectividad y tecnologia para el buen gobierno" required>
                                    <img src="{{ asset('images/pdem_et3.jpg') }}" width="80" height="80" title="Conectividad y tecnologia para el buen gobierno" />                                    
                                </div>    
                            </div>

                            <div class="row">    
                                <div class="col-xs-4 form-group">
                                    <label >13. Fecha de inicio del programa y/o acción - Año </label>
                                    <select class="form-control m-bot15" name="periodo_id1" id="periodo_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar año</option>
                                        @foreach($regperiodos as $anio)
                                            <option value="{{$anio->periodo_id}}">{{$anio->periodo_desc}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>   
                                <div class="col-xs-4 form-group">
                                    <label >Mes </label>
                                    <select class="form-control m-bot15" name="mes_id1" id="mes_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar mes</option>
                                        @foreach($regmeses as $mes)
                                            <option value="{{$mes->mes_id}}">{{$mes->mes_desc}} </option>
                                        @endforeach
                                    </select>                                    
                                </div>    
                                <div class="col-xs-4 form-group">
                                    <label >Día </label>
                                    <select class="form-control m-bot15" name="dia_id1" id="dia_id1" required>
                                        <option selected="true" disabled="disabled">Seleccionar día</option>
                                        @foreach($regdias as $dia)
                                            <option value="{{$dia->dia_id}}">{{$dia->dia_desc}} </option>
                                        @endforeach
                                    </select>                                    
                                </div>                                    
                            </div>                            

                            <div class="row">
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
    {!! JsValidator::formRequest('App\Http\Requests\objprogRequest','#nuevoobjprog') !!}
@endsection

@section('javascrpt')

@endsection