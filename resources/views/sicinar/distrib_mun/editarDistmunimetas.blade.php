@extends('sicinar.principal')

@section('title','Editar distribución de beneficios')

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
    <!DOCTYPE html>
    <html lang="es">
    <div class="content-wrapper">
        <section class="content-header">
            <!--<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />-->
            <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
            <h1><i class="fa fa-dashboard"></i>&nbsp;&nbsp;Menú.
                <small>Ficha del programa -</small> 
                <small>9.1 Dist. municipio metas -</small> 
                <small>Seleccionar para editar </small>
            </h1>
            <ol class="breadcrumb">
                <li><img src="{{ asset('images/b9.jpg') }}" border="0" width="30" height="30">&nbsp;&nbsp;Distribución por municipio metas </li> 
            </ol>
        </section>
        <section class="content">
            <div class="row">
                <div class="col-md-12">
                    <div class="box box-success">
                        <p align="justify"><b style="color:red;">
                            Instrucciones:</b> <b style="color:green;"> 
                            Requisitar la distribución anual por municipio de: Financiamiento, beneficiarios y beneficios (metas) del programa y/o acción.
                            Este apartado se deberá de requisitar periodicamente de forma anual; esto es cada ejercio fiscal.
                            </b>
                        </p>       
                        {!! Form::open(['route' => ['actualizardistmunimetas',$regdistmuni->periodo_id,$regdistmuni->prog_id,$regdistmuni->municipio_id], 'method' => 'PUT', 'id' => 'actualizardistmunimetas', 'enctype' => 'multipart/form-data']) !!}
                        <div class="box-body">

                            <div class="row">
                                <div class="col-xs-12 form-group">
                                    <input type="hidden" id="periodo_id"   name="periodo_id"   value="{{$regdistmuni->periodo_id}}">  
                                    <input type="hidden" id="prog_id"      name="prog_id"      value="{{$regdistmuni->prog_id}}">   
                                    <input type="hidden" id="municipio_id" name="municipio_id" value="{{$regdistmuni->municipio_id}}">   
                                    <label style="color:green;">Periodo: </label>
                                    &nbsp;&nbsp;{{$regdistmuni->periodo_id}} 
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                                    
                                    <label style="color:green;">Programa y/o acción: </label>
                                        &nbsp;&nbsp;{{$regdistmuni->prog_id}}
                                        @foreach($regprogramas as $program)
                                                @if($program->prog_id == $regdistmuni->prog_id)
                                                    {{Trim($program->prog_desc)}}
                                                    @break
                                                @endif
                                        @endforeach                  
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
                                    
                                    <label style="color:green;">Municipio: </label>
                                        &nbsp;&nbsp;{{$regdistmuni->municipio_id}}
                                        @foreach($regmunicipios as $muni)
                                                @if($muni->municipio_id == $regdistmuni->municipio_id)
                                                    {{Trim($muni->municipio)}}
                                                    @break
                                                @endif
                                        @endforeach                                         
                                </div>   
                            </div>

                            <div class="row">                                                                
                                <div class="col-xs-3 form-group">
                                    <label>$ Presupuesto total meta </label>
                                    <input required autocomplete="off" id="finan_meta" name="finan_meta" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ total del presupuesto meta" value="{{$regdistmuni->finan_meta}}" required>
                                </div>
                            </div>                            

                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>$ enero meta </label>
                                    <input required autocomplete="off" id="finan_m01" name="finan_m01" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ enero meta" value="{{$regdistmuni->finan_m01}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ febrero meta </label>
                                    <input required autocomplete="off" id="finan_m02" name="finan_m02" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ febrero meta" value="{{$regdistmuni->finan_m02}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ marzo meta </label>
                                    <input required autocomplete="off" id="finan_m03" name="finan_m03" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ marzo meta" value="{{$regdistmuni->finan_m03}}" required>
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>$ abril meta </label>
                                    <input required autocomplete="off" id="finan_m04" name="finan_m04" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ abril meta" value="{{$regdistmuni->finan_m04}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ mayo meta </label>
                                    <input required autocomplete="off" id="finan_m05" name="finan_m05" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ mayo meta" value="{{$regdistmuni->finan_m05}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ junio meta </label>
                                    <input required autocomplete="off" id="finan_m06" name="finan_m06" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ junio meta" value="{{$regdistmuni->finan_m06}}" required>
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>$ julio meta </label>
                                    <input required autocomplete="off" id="finan_m07" name="finan_m07" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ julio meta" value="{{$regdistmuni->finan_m07}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ agosto meta </label>
                                    <input required autocomplete="off" id="finan_m08" name="finan_m08" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ agosto meta" value="{{$regdistmuni->finan_m08}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ septiembre meta </label>
                                    <input required autocomplete="off" id="finan_m09" name="finan_m09" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ septiembre meta" value="{{$regdistmuni->finan_m09}}" required>
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>$ octubre meta </label>
                                    <input required autocomplete="off" id="finan_m10" name="finan_m10" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ octubre meta" value="{{$regdistmuni->finan_m10}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ noviembre meta </label>
                                    <input required autocomplete="off" id="finan_m11" name="finan_m11" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ noviembre meta" value="{{$regdistmuni->finan_m11}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>$ diciembre meta </label>
                                    <input required autocomplete="off" id="finan_m12" name="finan_m12" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="$ diciembre meta" value="{{$regdistmuni->finan_m12}}" required>
                                </div>
                            </div> 

                            <div class="row">                                                                
                                <div class="col-xs-3 form-group">
                                    <label>Total beneficiarios meta </label>
                                    <input required autocomplete="off" id="benef_meta" name="benef_meta" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="total de beneficiarios meta" value="{{$regdistmuni->benef_meta}}" required>
                                </div>
                            </div>                            

                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>enero meta </label>
                                    <input required autocomplete="off" id="benef_m01" name="benef_m01" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="enero meta" value="{{$regdistmuni->benef_m01}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>febrero meta </label>
                                    <input required autocomplete="off" id="benef_m02" name="benef_m02" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="febrero meta" value="{{$regdistmuni->benef_m02}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>marzo meta </label>
                                    <input required autocomplete="off" id="benef_m03" name="benef_m03" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="marzo meta" value="{{$regdistmuni->benef_m03}}" required>
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>abril meta </label>
                                    <input required autocomplete="off" id="benef_m04" name="benef_m04" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="abril meta" value="{{$regdistmuni->benef_m04}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>mayo meta </label>
                                    <input required autocomplete="off" id="benef_m05" name="benef_m05" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="mayo meta" value="{{$regdistmuni->benef_m05}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>junio meta </label>
                                    <input required autocomplete="off" id="benef_m06" name="benef_m06" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="junio meta" value="{{$regdistmuni->benef_m06}}" required>
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>julio meta </label>
                                    <input required autocomplete="off" id="benef_m07" name="benef_m07" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="julio meta" value="{{$regdistmuni->benef_m07}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>agosto meta </label>
                                    <input required autocomplete="off" id="benef_m08" name="benef_m08" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="agosto meta" value="{{$regdistmuni->benef_m08}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>septiembre meta </label>
                                    <input required autocomplete="off" id="benef_m09" name="benef_m09" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="septiembre meta" value="{{$regdistmuni->benef_m09}}" required>
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>octubre meta </label>
                                    <input required autocomplete="off" id="benef_m10" name="benef_m10" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="octubre meta" value="{{$regdistmuni->benef_m10}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>noviembre meta </label>
                                    <input required autocomplete="off" id="benef_m11" name="benef_m11" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="noviembre meta" value="{{$regdistmuni->benef_m11}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>diciembre meta </label>
                                    <input required autocomplete="off" id="benef_m12" name="benef_m12" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="diciembre meta" value="{{$regdistmuni->benef_m12}}" required>
                                </div>
                            </div> 


                            <div class="row">                                                                
                                <div class="col-xs-3 form-group">
                                    <label>Total beneficios meta </label>
                                    <input required autocomplete="off" id="bene_meta" name="bene_meta" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="total de beneficiarios meta" value="{{$regdistmuni->bene_meta}}" required>
                                </div>
                            </div>                            

                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>enero meta </label>
                                    <input required autocomplete="off" id="bene_m01" name="bene_m01" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="enero meta" value="{{$regdistmuni->bene_m01}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>febrero meta </label>
                                    <input required autocomplete="off" id="bene_m02" name="bene_m02" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="febrero meta" value="{{$regdistmuni->bene_m02}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>marzo meta </label>
                                    <input required autocomplete="off" id="bene_m03" name="bene_m03" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="marzo meta" value="{{$regdistmuni->bene_m03}}" required>
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>abril meta </label>
                                    <input required autocomplete="off" id="bene_m04" name="bene_m04" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="abril meta" value="{{$regdistmuni->bene_m04}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>mayo meta </label>
                                    <input required autocomplete="off" id="bene_m05" name="bene_m05" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="mayo meta" value="{{$regdistmuni->bene_m05}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>junio meta </label>
                                    <input required autocomplete="off" id="bene_m06" name="bene_m06" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="junio meta" value="{{$regdistmuni->bene_m06}}" required>
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>julio meta </label>
                                    <input required autocomplete="off" id="bene_m07" name="bene_m07" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="julio meta" value="{{$regdistmuni->bene_m07}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>agosto meta </label>
                                    <input required autocomplete="off" id="bene_m08" name="bene_m08" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="agosto meta" value="{{$regdistmuni->bene_m08}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>septiembre meta </label>
                                    <input required autocomplete="off" id="bene_m09" name="bene_m09" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="septiembre meta" value="{{$regdistmuni->bene_m09}}" required>
                                </div>
                            </div> 
                            <div class="row">                                                                
                                <div class="col-xs-2 form-group">
                                    <label>octubre meta </label>
                                    <input required autocomplete="off" id="bene_m10" name="bene_m10" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="octubre meta" value="{{$regdistmuni->bene_m10}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>noviembre meta </label>
                                    <input required autocomplete="off" id="bene_m11" name="bene_m11" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="noviembre meta" value="{{$regdistmuni->bene_m11}}" required>
                                </div>
                                <div class="col-xs-2 form-group">
                                    <label>diciembre meta </label>
                                    <input required autocomplete="off" id="bene_m12" name="bene_m12" min="0" max="999999999.99" class="form-control" type="decimal(9,2)" placeholder="diciembre meta" value="{{$regdistmuni->bene_m12}}" required>
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
                                    <a href="{{route('verdistmunimetas')}}" role="button" id="cancelar" class="btn btn-danger">Cancelar</a>
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
    {!! JsValidator::formRequest('App\Http\Requests\distmunimetasRequest','#actualizardistmunimetas') !!}
@endsection

@section('javascrpt')
@endsection
