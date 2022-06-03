<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/  

Route::get('/', function () {
    return view('sicinar.login.loginInicio');
});

    Route::group(['prefix' => 'control-interno'], function() {
    Route::post('menu', 'usuariosController@actionLogin')->name('login');
    Route::get('status-sesion/expirada', 'usuariosController@actionExpirada')->name('expirada');
    Route::get('status-sesion/terminada','usuariosController@actionCerrarSesion')->name('terminada');
 
    // Auto registro en sistema
    Route::get( 'Autoregistro/usuario'              ,'usuariosController@actionAutoregUsu')->name('autoregusu');
    Route::post('Autoregistro/usuario/registro'     ,'usuariosController@actionRegaltaUsu')->name('regaltausu');
    Route::get( 'Autoregistro/{id}/editarbienvenida','usuariosController@actioneditarBienve')->name('editarbienve');        

    // BackOffice del sistema
    Route::get('BackOffice/usuarios'                ,'usuariosController@actionNuevoUsuario')->name('nuevoUsuario');
    Route::post('BackOffice/usuarios/alta'          ,'usuariosController@actionAltaUsuario')->name('altaUsuario');
    Route::get('BackOffice/buscar/todos'            ,'usuariosController@actionBuscarUsuario')->name('buscarUsuario');        
    Route::get('BackOffice/usuarios/todos'          ,'usuariosController@actionVerUsuario')->name('verUsuarios');
    Route::get('BackOffice/usuarios/{id}/editar'    ,'usuariosController@actionEditarUsuario')->name('editarUsuario');
    Route::put('BackOffice/usuarios/{id}/actualizar','usuariosController@actionActualizarUsuario')->name('actualizarUsuario');
    Route::get('BackOffice/usuarios/{id}/Borrar'    ,'usuariosController@actionBorrarUsuario')->name('borrarUsuario');    
    Route::get('BackOffice/usuario/{id}/activar'    ,'usuariosController@actionActivarUsuario')->name('activarUsuario');
    Route::get('BackOffice/usuario/{id}/desactivar' ,'usuariosController@actionDesactivarUsuario')->name('desactivarUsuario');

    Route::get('BackOffice/usuario/{id}/{id2}/email','usuariosController@actionEmailRegistro')->name('emailregistro');    

    //Catalogos
    //Procesos
    Route::get('proceso/nuevo'      ,'catprocesosController@actionNuevoProceso')->name('nuevoProceso');
    Route::post('proceso/alta'      ,'catprocesosController@actionAltaNuevoProceso')->name('AltaNuevoProceso');
    Route::get('proceso/ver'        ,'catprocesosController@actionVerProceso')->name('verProceso');
    Route::get('proceso/{id}/editar','catprocesosController@actionEditarProceso')->name('editarProceso');
    Route::put('proceso/{id}/update','catprocesosController@actionActualizarProceso')->name('actualizarProceso');
    Route::get('proceso/{id}/Borrar','catprocesosController@actionBorrarProceso')->name('borrarProceso');    
    Route::get('proceso/excel'      ,'catprocesosController@exportCatProcesosExcel')->name('downloadprocesos');
    Route::get('proceso/pdf'        ,'catprocesosController@exportCatProcesosPdf')->name('catprocesosPDF');
    //Funciones de procesos
    Route::get('funcion/nuevo'      ,'catfuncionesController@actionNuevaFuncion')->name('nuevaFuncion');
    Route::post('funcion/alta'      ,'catfuncionesController@actionAltaNuevaFuncion')->name('AltaNuevaFuncion');
    Route::get('funcion/ver'        ,'catfuncionesController@actionVerFuncion')->name('verFuncion');
    Route::get('funcion/{id}/editar','catfuncionesController@actionEditarFuncion')->name('editarFuncion');
    Route::put('funcion/{id}/update','catfuncionesController@actionActualizarFuncion')->name('actualizarFuncion');
    Route::get('funcion/{id}/Borrar','catfuncionesController@actionBorrarFuncion')->name('borrarFuncion');    
    Route::get('funcion/excel'      ,'catfuncionesController@exportCatFuncionesExcel')->name('downloadfunciones');
    Route::get('funcion/pdf'        ,'catfuncionesController@exportCatFuncionesPdf')->name('catfuncionesPDF');    
    //Actividades
    Route::get('actividad/nuevo'      ,'cattrxController@actionNuevaTrx')->name('nuevaTrx');
    Route::post('actividad/alta'      ,'cattrxController@actionAltaNuevaTrx')->name('AltaNuevaTrx');
    Route::get('actividad/ver'        ,'cattrxController@actionVerTrx')->name('verTrx');
    Route::get('actividad/{id}/editar','cattrxController@actionEditarTrx')->name('editarTrx');
    Route::put('actividad/{id}/update','cattrxController@actionActualizarTrx')->name('actualizarTrx');
    Route::get('actividad/{id}/Borrar','cattrxController@actionBorrarTrx')->name('borrarTrx');    
    Route::get('actividad/excel'      ,'cattrxController@exportCatTrxExcel')->name('downloadtrx');
    Route::get('actividad/pdf'        ,'cattrxController@exportCatTrxPdf')->name('cattrxPDF');
    
    //Ficha del programa y/o acción
    //Programa
    Route::get('programa/nuevo'       ,'programasController@actionNuevoProg')->name('nuevoprog');
    Route::post('programaalta'        ,'programasController@actionAltaNuevoProg')->name('altanuevoprog');
    Route::get('programa/ver'         ,'programasController@actionVerProg')->name('verprog');
    Route::get('programa/buscar'      ,'programasController@actionBuscarProg')->name('buscarprog');            
    Route::get('programa/{id}/editar' ,'programasController@actionEditarProg')->name('editarprog');
    Route::put('programa/{id}/update' ,'programasController@actionActualizarProg')->name('actualizarprog');
    Route::get('programa/{id}/Borrar' ,'programasController@actionBorrarProg')->name('borrarprog');    
    Route::get('programa/excel'       ,'programasController@actionExportProgExcel')->name('exportprogexcel');
    Route::get('programa/pdf'         ,'programasController@actionExportProgPdf')->name('exportprogpdf');    

    //Datos de la dependencia
    Route::get('dep_prog/nuevo'      ,'depenProgsController@actionNuevoDepprog')->name('nuevodepprog');
    Route::post('dep_prog/alta'      ,'depenProgsController@actionAltaNuevoDepprog')->name('altanuevoprog');
    Route::get('dep_prog/ver'        ,'depenProgsController@actionVerDepprog')->name('verdepprog');
    Route::get('dep_prog/{id}/editar','depenProgsController@actionEditarDepprog')->name('editardepprog');
    Route::put('dep_prog/{id}/update','depenProgsController@actionActualizarDepprog')->name('actualizardepprog');
    Route::get('dep_prog/{id}/Borrar','depenProgsController@actionBorrarDepprog')->name('borrardepprog');    
    Route::get('dep_prog/excel'      ,'depenProgsController@actionExportDepprogExcel')->name('exportdepprogexcel');
    Route::get('dep_prog/pdf'        ,'depenProgsController@actionExportDepprogPdf')->name('exportdepprogpdf');    

    // III. Objetivo 
    Route::get('obj_prog/nuevo'            ,'objprogController@actionNuevoObjprog')->name('nuevoobjprog');
    Route::post('obj_prog/alta'            ,'objprogController@actionAltaNuevoObjprog')->name('altanuevoobjprog');
    Route::get('obj_prog/ver'              ,'objprogController@actionVerObjprog')->name('verobjprog');
    Route::get('obj_prog/buscar'           ,'objprogController@actionBuscarObjprog')->name('buscarobjprog');                    
    Route::get('obj_prog/{id}/{id2}/edit'  ,'objprogController@actionEditarObjprog')->name('editarobjprog');
    Route::put('obj_prog/{id}/{id2}/update','objprogController@actionActualizarObjprog')->name('actualizarobjprog');
    Route::get('obj_prog/{id}/{id2}/Borrar','objprogController@actionBorrarObjprog')->name('borrarobjprog');
    Route::get('obj_prog/excel'            ,'objprogController@actionExportObjprogExcel')->name('exportobjprogexcel');
    Route::get('obj_prog/pdf'              ,'objprogController@actionExportObjprogPdf')->name('exportobjprogpdf');

    // IV. Proyecto Presupuestal
    Route::get('proyectop/nuevo'             ,'proyectopresController@actionNuevoProyectop')->name('nuevoproyectop');
    Route::post('proyectop/alta'             ,'proyectopresController@actionAltaNuevoProyectop')->name('altanuevoproyectop');
    Route::get('proyectop/ver'               ,'proyectopresController@actionVerProyectop')->name('verproyectop');
    Route::get('proyectop/buscar'            ,'proyectopresController@actionBuscarProyectop')->name('buscarproyectop');    
    Route::get('proyectop/{id}/{id2}/editar' ,'proyectopresController@actionEditarProyectop')->name('editarproyectop');
    Route::put('proyectop/{id}/{id2}/update' ,'proyectopresController@actionActualizarProyectop')->name('actualizarproyectop');
    Route::get('proyectop/{id}/{id2}/Borrar' ,'proyectopresController@actionBorrarProyectop')->name('borrarproyectop');
    Route::get('proyectop/excel/{id}/{id2}'  ,'proyectopresController@actionExportProyectopExcel')->name('exportproyectopexcel');
    Route::get('proyectop/pdf/{id}/{id2}'    ,'proyectopresController@actionExportProyectopPdf')->name('exportproyectoppdf');

    // V. Beneficios del programa y/o acción
    Route::get('beneficiosp/nuevo'           ,'benefprogController@actionNuevoBenefprog')->name('nuevobenefprog');
    Route::post('beneficiosp/alta'           ,'benefprogController@actionAltaNuevoBenefprog')->name('altanuevobenefprog');
    Route::get('beneficiosp/ver'             ,'benefprogController@actionVerBenefprog')->name('verbenefprog');
    Route::get('beneficiosp/buscar'          ,'benefprogController@actionBuscarBenefprog')->name('buscarbenefprog');    
    Route::get('beneficiosp/{id}/{id2}/{id3}/editar','benefprogController@actionEditarBenefprog')->name('editarbenefprog');
    Route::put('beneficiosp/{id}/{id2}/{id3}/update','benefprogController@actionActualizarBenefprog')->name('actualizarbenefprog');
    Route::get('beneficiosp/{id}/{id2}/{id3}/Borrar','benefprogController@actionBorrarBenefprog')->name('borrarbenefprog');
    Route::get('beneficiosp/excel/{id}/{id2}/{id3}' ,'benefprogController@actionExportBenefprogExcel')->name('exportbenefprogexcel');
    Route::get('beneficiosp/pdf/{id}/{id2}/{id3}'   ,'benefprogController@actionExportBenefprogPdf')->name('exportbenefprogpdf');

    // VI.1 Financiamiento metas
    Route::get('finan_metas/nuevo'                  ,'finanmetasController@actionNuevoFinanmetas')->name('nuevofinanmetas');
    Route::post('finan_metas/alta'                  ,'finanmetasController@actionAltaNuevoFinanmetas')->name('altanuevofinanmetas');
    Route::get('finan_metas/ver'                    ,'finanmetasController@actionVerFinanmetas')->name('verfinanmetas');
    Route::get('finan_metas/buscar'                 ,'finanmetasController@actionBuscarFinanmetas')->name('buscarfinanmetas');    
    Route::get('finan_metas/{id}/{id2}/{id3}/editar','finanmetasController@actionEditarFinanmetas')->name('editarfinanmetas');
    Route::put('finan_metas/{id}/{id2}/{id3}/update','finanmetasController@actionActualizarFinanmetas')->name('actualizarfinanmetas');
    Route::get('finan_metas/{id}/{id2}/{id3}/Borrar','finanmetasController@actionBorrarFinanmetas')->name('borrarfinanmetas');
    Route::get('finan_metas/excel/{id}/{id2}/{id3}' ,'finanmetasController@actionExportFinanmetasExcel')->name('exportfinanmetasexcel');
    Route::get('finan_metas/pdf/{id}/{id2}/{id3}'   ,'finanmetasController@actionExportFinanmetasPdf')->name('exportfinanmetaspdf');

    // VI.2 Financiamiento avances
    Route::get('finan_avances/nuevo'                  ,'finanavancesController@actionNuevoFinanavances')->name('nuevofinanavances');
    Route::post('finan_avances/alta'                  ,'finanavancesController@actionAltaNuevoFinanavances')->name('altanuevofinanavances');
    Route::get('finan_avances/ver'                    ,'finanavancesController@actionVerFinanavances')->name('verfinanavances');
    Route::get('finan_avances/buscar'                 ,'finanavancesController@actionBuscarFinanavances')->name('buscarfinanavances');    
    Route::get('finan_avances/{id}/{id2}/{id3}/editar','finanavancesController@actionEditarFinanavances')->name('editarfinanavances');
    Route::put('finan_avances/{id}/{id2}/{id3}/update','finanavancesController@actionActualizarFinanavances')->name('actualizarfinanavances');
    Route::get('finan_avances/{id}/{id2}/{id3}/Borrar','finanavancesController@actionBorrarFinanavances')->name('borrarfinanavances');
    Route::get('finan_avances/excel/{id}/{id2}/{id3}' ,'finanavancesController@actionExportFinanavancesExcel')->name('exportfinanavancesexcel');
    Route::get('finan_avances/pdf/{id}/{id2}/{id3}'   ,'finanavancesController@actionExportFinanavancesPdf')->name('exportfinanavancespdf');    

    // VII.1 Distribución de beneficiarios metas
    Route::get('Distbenef_metas/nuevo'            ,'distbenefmetasController@actionNuevoDistbenefmetas')->name('nuevodistbenefmetas');
    Route::post('Distbenef_metas/alta'            ,'distbenefmetasController@actionAltaNuevoDistbenefmetas')->name('altanuevodistbenefmetas');
    Route::get('Distbenef_metas/ver'              ,'distbenefmetasController@actionVerDistbenefmetas')->name('verdistbenefmetas');
    Route::get('Distbenef_metas/buscar'           ,'distbenefmetasController@actionBuscarDistbenefmetas')->name('buscardistbenefmetas');    
    Route::get('Distbenef_metas/{id}/{id2}/editar','distbenefmetasController@actionEditarDistbenefmetas')->name('editardistbenefmetas');
    Route::put('Distbenef_metas/{id}/{id2}/update','distbenefmetasController@actionActualizarDistbenefmetas')->name('actualizardistbenefmetas');
    Route::get('Distbenef_metas/{id}/{id2}/Borrar','distbenefmetasController@actionBorrarDistbenefmetas')->name('borrardistbenefmetas');
    Route::get('Distbenef_metas/excel/{id}/{id2}' ,'distbenefmetasController@actionExportDistbenefmetasExcel')->name('exportdistbenefmetasexcel');
    Route::get('Distbenef_metas/pdf/{id}/{id2}'   ,'distbenefmetasController@actionExportDistbenefmetasPdf')->name('exportdistbenefmetaspdf');

    // VII.2 Distribución de beneficiarios avances
    //Route::get('Distbenef_avances/nuevo'            ,'distbenefavanController@actionNuevoDistbenefavan')->name('nuevodistbenefavan');
    //Route::post('Distbenef_avances/alta'            ,'distbenefavanController@actionAltaNuevoDistbenefavan')->name('altanuevodistbenefavan');
    Route::get('Distbenef_avances/ver'              ,'distbenefavanController@actionVerDistbenefavan')->name('verdistbenefavan');
    Route::get('Distbenef_avances/buscar'           ,'distbenefavanController@actionBuscarDistbenefavan')->name('buscardistbenefavan');    
    Route::get('Distbenef_avances/{id}/{id2}/editar','distbenefavanController@actionEditarDistbenefavan')->name('editardistbenefavan');
    Route::put('Distbenef_avances/{id}/{id2}/update','distbenefavanController@actionActualizarDistbenefavan')->name('actualizardistbenefavan');
    Route::get('Distbenef_avances/{id}/{id2}/Borrar','distbenefavanController@actionBorrarDistbenefavan')->name('borrardistbenefavan');
    //Route::get('Distbenef_avances/excel/{id}/{id2}' ,'distbenefavanController@actionExportDistbenefavanExcel')->name('exportdistbenefavanexcel');
    //Route::get('Distbenef_avances/pdf/{id}/{id2}'   ,'distbenefavanController@actionExportDistbenefavanPdf')->name('exportdistbenefavanpdf');    

    // VIII.1 Distribución de beneficios metas
    Route::get('Distben_metas/nuevo'            ,'distbenmetasController@actionNuevoDistbenemetas')->name('nuevodistbenemetas');
    Route::post('Distben_metas/alta'            ,'distbenmetasController@actionAltaNuevoDistbenemetas')->name('altanuevodistbenemetas');
    Route::get('Distben_metas/ver'              ,'distbenmetasController@actionVerDistbenemetas')->name('verdistbenemetas');
    Route::get('Distben_metas/buscar'           ,'distbenmetasController@actionBuscarDistbenemetas')->name('buscardistbenemetas');    
    Route::get('Distben_metas/{id}/{id2}/editar','distbenmetasController@actionEditarDistbenemetas')->name('editardistbenemetas');
    Route::put('Distben_metas/{id}/{id2}/update','distbenmetasController@actionActualizarDistbenemetas')->name('actualizardistbenemetas');
    Route::get('Distben_metas/{id}/{id2}/Borrar','distbenmetasController@actionBorrarDistbenemetas')->name('borrardistbenemetas');
    Route::get('Distben_metas/excel/{id}/{id2}' ,'distbenmetasController@actionExportDistbenemetasExcel')->name('exportdistbenemetasexcel');
    Route::get('Distben_metas/pdf/{id}/{id2}'   ,'distbenmetasController@actionExportDistbenemetasPdf')->name('exportdistbenemetaspdf');

    // VIII.2 Distribución de beneficios avances
    Route::get('Distben_avances/nuevo'            ,'distbenavanController@actionNuevoDistbeneavan')->name('nuevodistbeneavan');
    Route::post('Distben_avances/alta'            ,'distbenavanController@actionAltaNuevoDistbeneavan')->name('altanuevodistbeneavan');
    Route::get('Distben_avances/ver'              ,'distbenavanController@actionVerDistbeneavan')->name('verdistbeneavan');
    Route::get('Distben_avances/buscar'           ,'distbenavanController@actionBuscarDistbeneavan')->name('buscardistbeneavan');    
    Route::get('Distben_avances/{id}/{id2}/editar','distbenavanController@actionEditarDistbeneavan')->name('editardistbeneavan');
    Route::put('Distben_avances/{id}/{id2}/update','distbenavanController@actionActualizarDistbeneavan')->name('actualizardistbeneavan');
    Route::get('Distben_avances/{id}/{id2}/Borrar','distbenavanController@actionBorrarDistbeneavan')->name('borrardistbeneavan');
    Route::get('Distben_avances/excel/{id}/{id2}' ,'distbenavanController@actionExportDistbeneavanExcel')->name('exportdistbeneavanexcel');
    Route::get('Distben_avances/pdf/{id}/{id2}'   ,'distbenavanController@actionExportDistbeneavanPdf')->name('exportdistbeneavanpdf');

    // IX.1 Distribución por municipio metas
    Route::get('Distmuni_metas/nuevo'            ,'distmunimetasController@actionNuevoDistmunimetas')->name('nuevodistmunimetas');
    Route::post('Distmuni_metas/alta'            ,'distmunimetasController@actionAltaNuevoDistmunimetas')->name('altanuevodistmunimetas');
    Route::get('Distmuni_metas/ver'              ,'distmunimetasController@actionVerDistmunimetas')->name('verdistmunimetas');
    Route::get('Distmuni_metas/buscar'           ,'distmunimetasController@actionBuscarDistmunimetas')->name('buscardistmunimetas');    
    Route::get('Distmuni_metas/{id}/{id2}/{id3}/editar','distmunimetasController@actionEditarDistmunimetas')->name('editardistmunimetas');
    Route::put('Distmuni_metas/{id}/{id2}/{id3}/update','distmunimetasController@actionActualizarDistmunimetas')->name('actualizardistmunimetas');
    Route::get('Distmuni_metas/{id}/{id2}/{id3}/Borrar','distmunimetasController@actionBorrarDistmunimetas')->name('borrardistmunimetas');
    Route::get('Distmuni_metas/excel/{id}/{id2}/{id3}' ,'distmunimetasController@actionExportDistmunimetasExcel')->name('exportdistmunimetasexcel');
    Route::get('Distmuni_metas/pdf/{id}/{id2}/{id3}'   ,'distmunimetasController@actionExportDistmunimetasPdf')->name('exportdistmunimetaspdf');

    // XI.2 Distribución por municipio avances
    Route::get('Distmuni_avances/nuevo'            ,'distmuniavanController@actionNuevoDistmuniavan')->name('nuevodistmuniavan');
    Route::post('Distmuni_avances/alta'            ,'distmuniavanController@actionAltaNuevoDistmuniavan')->name('altanuevodistmuniavan');
    Route::get('Distmuni_avances/ver'              ,'distmuniavanController@actionVerDistmuniavan')->name('verdistmuniavan');
    Route::get('Distmuni_avances/buscar'           ,'distmuniavanController@actionBuscarDistmuniavan')->name('buscardistmuniavan');    
    Route::get('Distmuni_avances/{id}/{id2}/{id3}/editar','distmuniavanController@actionEditarDistmuniavan')->name('editardistmuniavan');
    Route::put('Distmuni_avances/{id}/{id2}/{id3}/update','distmuniavanController@actionActualizarDistmuniavan')->name('actualizardistmuniavan');
    Route::get('Distmuni_avances/{id}/{id2}/{id3}/Borrar','distmuniavanController@actionBorrarDistmuniavan')->name('borrardistmuniavan');
    Route::get('Distmuni_avances/excel/{id}/{id2}/{id3}' ,'distmuniavanController@actionExportDistmuniavanExcel')->name('exportdistmuniavanexcel');
    Route::get('Distmuni_avances/pdf/{id}/{id2}/{id3}'   ,'distmuniavanController@actionExportDistmuniavanPdf')->name('exportdistmuniavanpdf');

    // X.1 Indicador metas
    Route::get('indicador_metas/nuevo'                  ,'indimetasController@actionNuevoIndimetas')->name('nuevoindimetas');
    Route::post('indicador_metas/alta'                  ,'indimetasController@actionAltaNuevoIndimetas')->name('altanuevoindimetas');
    Route::get('indicador_metas/ver'                    ,'indimetasController@actionVerIndimetas')->name('verindimetas');
    Route::get('indicador_metas/buscar'                 ,'indimetasController@actionBuscarIndimetas')->name('buscarindimetas');    
    Route::get('indicador_metas/{id}/{id2}/{id3}/editar','indimetasController@actionEditarIndimetas')->name('editarindimetas');
    Route::put('indicador_metas/{id}/{id2}/{id3}/update','indimetasController@actionActualizarIndimetas')->name('actualizarindimetas');
    Route::get('indicador_metas/{id}/{id2}/{id3}/Borrar','indimetasController@actionBorrarIndimetas')->name('borrarindimetas');
    Route::get('indicador_metas/excel/{id}/{id2}/{id3}' ,'indimetasController@actionExportIndimetasExcel')->name('exportindimetasexcel');
    Route::get('indicador_metas/pdf/{id}/{id2}/{id3}'   ,'indimetasController@actionExportIndimetasPdf')->name('exportindimetaspdf');

    // X.2 Indicadores avances
    Route::get('indicador_avances/nuevo'                  ,'indiavanController@actionNuevoIndiavan')->name('nuevoindiavan');
    Route::post('indicador_avances/alta'                  ,'indiavanController@actionAltaNuevoIndiavan')->name('altanuevoindiavan');
    Route::get('indicador_avances/ver'                    ,'indiavanController@actionVerIndiavan')->name('verindiavan');
    Route::get('indicador_avances/buscar'                 ,'indiavanController@actionBuscarIndiavan')->name('buscarindiavan');    
    Route::get('indicador_avances/{id}/{id2}/{id3}/editar','indiavanController@actionEditarIndiavan')->name('editarindiavan');
    Route::put('indicador_avances/{id}/{id2}/{id3}/update','indiavanController@actionActualizarIndiavan')->name('actualizarindiavan');
    Route::get('indicador_avances/{id}/{id2}/{id3}/Borrar','indiavanController@actionBorrarIndiavan')->name('borrarindiavan');
    Route::get('indicador_avances/excel/{id}/{id2}/{id3}' ,'indiavanController@actionExportIndiavanExcel')->name('exportindiavanexcel');
    Route::get('indicador_avances/pdf/{id}/{id2}/{id3}'   ,'indiavanController@actionExportIndiavanPdf')->name('exportindiavanpdf');    

    // XI Diagnóstico
    Route::get('diagnostico/nuevo'                  ,'diagnosticoController@actionNuevoDiagnostico')->name('nuevodiagnostico');
    Route::post('diagnostico/alta'                  ,'diagnosticoController@actionAltaNuevoDiagnostico')->name('altanuevodiagnostico');
    Route::get('diagnostico/ver'                    ,'diagnosticoController@actionVerDiagnostico')->name('verdiagnostico');
    Route::get('diagnostico/buscar'                 ,'diagnosticoController@actionBuscarDiagnostico')->name('buscardiagnostico');    
    Route::get('diagnostico/{id}/{id2}/{id3}/editar','diagnosticoController@actionEditarDiagnostico')->name('editardiagnostico');
    Route::put('diagnostico/{id}/{id2}/{id3}/update','diagnosticoController@actionActualizarDiagnostico')->name('actualizardiagnostico');
    Route::get('diagnostico/{id}/{id2}/{id3}/Borrar','diagnosticoController@actionBorrarDiagnostico')->name('borrardiagnostico');
    Route::get('diagnostico/excel/{id}/{id2}/{id3}' ,'diagnosticoController@actionExportDiagnosticoExcel')->name('exportdiagnosticoexcel');
    Route::get('diagnostico/pdf/{id}/{id2}/{id3}'   ,'diagnosticoController@actionExportDiagnosticoPdf')->name('exportdiagnosticopdf');    

    Route::get('diagnostico/{id}/{id2}/{id3}/editar1','diagnosticoController@actionEditarDiagnostico1')->name('editardiagnostico1');
    Route::put('diagnostico/{id}/{id2}/{id3}/update1','diagnosticoController@actionActualizarDiagnostico1')->name('actualizardiagnostico1');

    // XII Directorio
    Route::get('directorio/nuevo'            ,'directorioController@actionNuevoDirectorio')->name('nuevodirectorio');
    Route::post('directorio/alta'            ,'directorioController@actionAltaNuevoDirectorio')->name('altanuevodirectorio');
    Route::get('directorio/ver'              ,'directorioController@actionVerDirectorio')->name('verdirectorio');
    Route::get('directorio/buscar'           ,'directorioController@actionBuscarDirectorio')->name('buscardirectorio');    
    Route::get('directorio/{id}/{id2}/editar','directorioController@actionEditarDirectorio')->name('editardirectorio');
    Route::put('directorio/{id}/{id2}/update','directorioController@actionActualizarDirectorio')->name('actualizardirectorio');
    Route::get('directorio/{id}/{id2}/Borrar','directorioController@actionBorrarDirectorio')->name('borrardirectorio');
    Route::get('directorio/excel/{id}/{id2}' ,'directorioController@actionExportDirectorioExcel')->name('exportdirectorioexcel');
    Route::get('directorio/pdf/{id}/{id2}'   ,'directorioController@actionExportDirectorioPdf')->name('exportdirectoriopdf');    


    //Finaciamiento y presupuesto anual del programa y/o acción
    Route::get('finan_pres/nuevo'             ,'finanpresupController@actionNuevoFinanpres')->name('nuevofinanpres');
    Route::post('finan_pres/alta'             ,'finanpresupController@actionAltaNuevoFinanpres')->name('altanuevofinanpres');
    Route::get('finan_pres/ver'               ,'finanpresupController@actionVerFinanpres')->name('verfinanpres');
    Route::get('finan_pres/buscar'            ,'finanpresupController@actionBuscarFinanpres')->name('buscarfinanpres');    
    Route::get('finan_pres/{id}/{id2}/editar' ,'finanpresupController@actionEditarFinanpres')->name('editarfinanpres');
    Route::put('finan_pres/{id}/{id2}/update' ,'finanpresupController@actionActualizarFinanpres')->name('actualizarfinanpres');
    Route::get('finan_pres/{id}/{id2}/editar1','finanpresupController@actionEditarFinanpres1')->name('editarfinanpres1');
    Route::put('finan_pres/{id}/{id2}/update1','finanpresupController@actionActualizarFinanpres1')->name('actualizarfinanpres1');
    Route::get('finan_pres/{id}/{id2}/editar2','finanpresupController@actionEditarFinanpres2')->name('editarfinanpres2');
    Route::put('finan_pres/{id}/{id2}/update2','finanpresupController@actionActualizarFinanpres2')->name('actualizarfinanpres2');
    Route::get('finan_pres/{id}/{id2}/editar3','finanpresupController@actionEditarFinanpres3')->name('editarfinanpres3');
    Route::put('finan_pres/{id}/{id2}/update3','finanpresupController@actionActualizarFinanpres3')->name('actualizarfinanpres3');    
    Route::get('finan_pres/{id}/{id2}/Borrar' ,'finanpresupController@actionBorrarFinanpres')->name('borrarfinanpres');
    Route::get('finan_pres/excel/{id}/{id2}'  ,'finanpresupController@actionExportFinanpresExcel')->name('exportfinanpresexcel');
    Route::get('finan_pres/pdf/{id}/{id2}'    ,'finanpresupController@actionExportFinanpresPdf')->name('exportfinanprespdf');

    Route::get('finan_presdt/{id}/{id2}/nuevo'       ,'finanpresupController@actionNuevoFinanpresd')->name('nuevofinanpresd');
    Route::post('finan_presdt/alta'                  ,'finanpresupController@actionAltaNuevoFinanpresd')->name('altanuevofinanpresd');
    Route::get('finan_presdt/{id}/{id2}/verdet'      ,'finanpresupController@actionVerFinanpresd')->name('verfinanpresd');
    Route::get('finan_presdt/{id}/{id2}/{id3}/editar','finanpresupController@actionEditarFinanpresd')->name('editarfinanpresd');
    Route::put('finan_presdt/{id}/{id2}/{id3}/update','finanpresupController@actionActualizarFinanpresd')->name('actualizarfinanpresd');
    Route::get('finan_presdt/{id}/{id2}/{id3}/Borrar','finanpresupController@actionBorrarFinanpresd')->name('borrarfinanpresd');

    //tipos de archivos
    Route::get('formato/nuevo'              ,'formatosController@actionNuevoFormato')->name('nuevoFormato');
    Route::post('formato/nuevo/alta'        ,'formatosController@actionAltaNuevoFormato')->name('AltaNuevoFormato');
    Route::get('formato/ver/todos'          ,'formatosController@actionVerFormatos')->name('verFormatos');
    Route::get('formato/{id}/editar/formato','formatosController@actionEditarFormato')->name('editarFormato');
    Route::put('formato/{id}/actualizar'    ,'formatosController@actionActualizarFormato')->name('actualizarFormato');
    Route::get('formato/{id}/Borrar'        ,'formatosController@actionBorrarFormato')->name('borrarFormato');    
    Route::get('formato/excel'              ,'formatosController@exportCatRubrosExcel')->name('downloadrubros');
    Route::get('formato/pdf'                ,'formatosController@exportCatRubrosPdf')->name('catrubrosPDF');     

    //catalogo de documentos
    Route::get('docto/buscar/todos'        ,'doctosController@actionBuscarDocto')->name('buscarDocto');    
    Route::get('docto/nuevo'               ,'doctosController@actionNuevoDocto')->name('nuevoDocto');
    Route::post('docto/nuevo/alta'         ,'doctosController@actionAltaNuevoDocto')->name('AltaNuevoDocto');
    Route::get('docto/ver/todos'           ,'doctosController@actionVerDoctos')->name('verDoctos');
    Route::get('docto/{id}/editar/formato' ,'doctosController@actionEditarDocto')->name('editarDocto');
    Route::put('docto/{id}/actualizar'     ,'doctosController@actionActualizarDocto')->name('actualizarDocto');    
    Route::get('docto/{id}/editar/formato1','doctosController@actionEditarDocto1')->name('editarDocto1');
    Route::put('docto/{id}/actualizar1'    ,'doctosController@actionActualizarDocto1')->name('actualizarDocto1');
    Route::get('docto/{id}/Borrar'         ,'doctosController@actionBorrarDocto')->name('borrarDocto');    
    Route::get('docto/excel'               ,'doctosController@exportCatDoctosExcel')->name('catDoctosExcel');
    Route::get('docto/pdf'                 ,'doctosController@exportCatDoctosPdf')->name('catDoctosPDF');     

    //Municipios sedesem
    Route::get('municipio/ver/todos','catalogosmunicipiosController@actionVermunicipios')->name('verMunicipios');
    Route::get('municipio/excel'    ,'catalogosmunicipiosController@exportCatmunicipiosExcel')->name('downloadmunicipios');
    Route::get('municipio/pdf'      ,'catalogosmunicipiosController@exportCatmunicipiosPdf')->name('catmunicipiosPDF');
    
    //OSC
    //Directorio
    Route::get('oscs/nueva'           ,'oscController@actionNuevaOsc')->name('nuevaOsc');
    Route::post('oscs/nueva/alta'     ,'oscController@actionAltaNuevaOsc')->name('AltaNuevaOsc');
    Route::get('oscs/ver/todas'       ,'oscController@actionVerOsc')->name('verOsc');
    Route::get('oscs/buscar/todas'    ,'oscController@actionBuscarOsc')->name('buscarOsc');    
    Route::get('oscs/{id}/editar/oscs','oscController@actionEditarOsc')->name('editarOsc');
    Route::put('oscs/{id}/actualizar' ,'oscController@actionActualizarOsc')->name('actualizarOsc');
    Route::get('oscs/{id}/Borrar'     ,'oscController@actionBorrarOsc')->name('borrarOsc');
    Route::get('oscs/excel'           ,'oscController@exportOscExcel')->name('oscexcel');
    Route::get('oscs/pdf'             ,'oscController@exportOscPdf')->name('oscPDF');

    Route::get('oscs/{id}/editar/osc1','oscController@actionEditarOsc1')->name('editarOsc1');
    Route::put('oscs/{id}/actualizar1','oscController@actionActualizarOsc1')->name('actualizarOsc1'); 
    Route::get('oscs/{id}/editar/osc2','oscController@actionEditarOsc2')->name('editarOsc2');
    Route::put('oscs/{id}/actualizar2','oscController@actionActualizarOsc2')->name('actualizarOsc2');        
 
    Route::get('oscs5/ver/todas'       ,'oscController@actionVerOsc5')->name('verOsc5');
    Route::get('oscs5/{id}/editar/oscs','oscController@actionEditarOsc5')->name('editarOsc5');
    Route::put('oscs5/{id}/actualizar' ,'oscController@actionActualizarOsc5')->name('actualizarOsc5');    
      
    //Requisitos Jurídicos
    Route::get('rjuridicos/nueva'              ,'rJuridicosController@actionNuevaJur')->name('nuevaJur');
    Route::post('rjuridicos/nueva/alta'        ,'rJuridicosController@actionAltaNuevaJur')->name('AltaNuevaJur');  
    Route::get('rjuridicos/buscar/todos'       ,'rJuridicosController@actionBuscarJur')->name('buscarJur');          
    Route::get('rjuridicos/ver/todasj'         ,'rJuridicosController@actionVerJur')->name('verJur');
    Route::get('rjuridicos/{id}/editar/jur'  ,'rJuridicosController@actionEditarJur')->name('editarJur');
    Route::put('rjuridicos/{id}/actualizarj'   ,'rJuridicosController@actionActualizarJur')->name('actualizarJur'); 
    Route::get('rjuridicos/{id}/Borrarj'       ,'rJuridicosController@actionBorrarJur')->name('borrarJur');

    Route::get('rjuridicos/{id}/editar/rjur12','rJuridicosController@actionEditarJur12')->name('editarJur12');
    Route::put('rjuridicos/{id}/actualizarj12','rJuridicosController@actionActualizarJur12')->name('actualizarJur12');    
    Route::get('rjuridicos/{id}/editar/rjur13','rJuridicosController@actionEditarJur13')->name('editarJur13');
    Route::put('rjuridicos/{id}/actualizarj13','rJuridicosController@actionActualizarJur13')->name('actualizarJur13'); 
    Route::get('rjuridicos/{id}/editar/rjur14','rJuridicosController@actionEditarJur14')->name('editarJur14');
    Route::put('rjuridicos/{id}/actualizarj14','rJuridicosController@actionActualizarJur14')->name('actualizarJur14');
    Route::get('rjuridicos/{id}/editar/rjur15','rJuridicosController@actionEditarJur15')->name('editarJur15');
    Route::put('rjuridicos/{id}/actualizarj15','rJuridicosController@actionActualizarJur15')->name('actualizarJur15');

    //Requisitos de operación
    //Padron de beneficiarios
    Route::get('padron/nueva'           ,'padronController@actionNuevoPadron')->name('nuevoPadron');
    Route::post('padron/nueva/alta'     ,'padronController@actionAltaNuevoPadron')->name('AltaNuevoPadron');
    Route::get('padron/ver/todas'       ,'padronController@actionVerPadron')->name('verPadron');
    Route::get('padron/buscar/todas'    ,'padronController@actionBuscarPadron')->name('buscarPadron');    
    Route::get('padron/{id}/editar/padron','padronController@actionEditarPadron')->name('editarPadron');
    Route::put('padron/{id}/actualizar' ,'padronController@actionActualizarPadron')->name('actualizarPadron');
    Route::get('padron/{id}/Borrar'     ,'padronController@actionBorrarPadron')->name('borrarPadron');
    Route::get('padron/excel'           ,'padronController@actionExportPadronExcel')->name('ExportPadronExcel');
    Route::get('padron/pdf'             ,'padronController@actionExportPadronPdf')->name('ExportPadronPdf');

    //Programa de trabajo
    Route::get('programat/nuevo'           ,'progtrabController@actionNuevoProgtrab')->name('nuevoProgtrab');
    Route::post('programat/nuevo/alta'     ,'progtrabController@actionAltaNuevoProgtrab')->name('AltaNuevoProgtrab');
    Route::get('programat/ver/todos'       ,'progtrabController@actionVerProgtrab')->name('verProgtrab');
    Route::get('programat/buscar/todos'    ,'progtrabController@actionBuscarProgtrab')->name('buscarProgtrab');    
    Route::get('programat/{id}/editar/progt','progtrabController@actionEditarProgtrab')->name('editarProgtrab');
    Route::put('programat/{id}/actualizar' ,'progtrabController@actionActualizarProgtrab')->name('actualizarProgtrab');
    Route::get('programat/{id}/Borrar'     ,'progtrabController@actionBorrarProgtrab')->name('borrarProgtrab');
    Route::get('programat/excel/{id}'      ,'progtrabController@actionExportProgtrabExcel')->name('ExportProgtrabExcel');
    Route::get('programat/pdf/{id}/{id2}'  ,'progtrabController@actionExportProgtrabPdf')->name('ExportProgtrabPdf');

    Route::get('programadt/{id}/nuevo'         ,'progtrabController@actionNuevoProgdtrab')->name('nuevoProgdtrab');
    Route::post('programadt/nuevo/alta'   ,'progtrabController@actionAltaNuevoProgdtrab')->name('AltaNuevoProgdtrab');
    Route::get('programadt/{id}/ver/todosd'         ,'progtrabController@actionVerProgdtrab')->name('verProgdtrab');
    Route::get('programadt/{id}/{id2}/editar/progdt','progtrabController@actionEditarProgdtrab')->name('editarProgdtrab');
    Route::put('programadt/{id}/{id2}/actualizardt' ,'progtrabController@actionActualizarProgdtrab')->name('actualizarProgdtrab');
    Route::get('programadt/{id}/{id2}/Borrardt','progtrabController@actionBorrarProgdtrab')->name('borrarProgdtrab');

    //Informe de labores - Programa de trabajo
    //Route::get('informe/nuevo'           ,'informeController@actionNuevoInforme')->name('nuevoInforme');
    //Route::post('informe/nuevo/alta'     ,'informeController@actionAltaNuevoInforme')->name('AltaNuevoInforme');
    Route::get('informe/ver/todos'       ,'informeController@actionVerInformes')->name('verInformes');
    Route::get('informe/buscar/todos'    ,'informeController@actionBuscarInforme')->name('buscarInforme');    
    //Route::get('informe/{id}/editar/inflab','informeController@actionEditarInforme')->name('editarInforme');
    //Route::put('informe/{id}/actualizar' ,'informeController@actionActualizarInforme')->name('actualizarInforme');
    //Route::get('informe/{id}/Borrar'     ,'informeController@actionBorrarInforme')->name('borrarInforme');
    //Route::get('informe/excel/{id}'      ,'informeController@actionExportInformeExcel')->name('ExportInformeExcel');
    Route::get('informe/pdf/{id}/{id2}'  ,'informeController@actionExportInformePdf')->name('ExportInformePdf');

    Route::get('informe/{id}/ver/todosi','informeController@actionVerInformelab')->name('verInformelab');
    //Route::get('informe/{id}/nuevo'     ,'informeController@actionNuevoInformelab')->name('nuevoInformelab');
    //Route::post('informe/nuevo/alta'    ,'informeController@actionAltaNuevoInformelab')->name('altaNuevoInformelab'); 
    Route::get('informe/{id}/{id2}/editar/inflabdet'    ,'informeController@actionEditarInformelab')->name('editarInformelab');
    Route::put('informe/{id}/{id2}/actualizarinflabdet' ,'informeController@actionActualizarInformelab')->name('actualizarInformelab');
    //Route::get('informe/{id}/{id2}/Borrarinflabdet'     ,'informeController@actionBorrarInformelab')->name('borrarInformelab');


    //Requisitos operativos
    Route::get('rop/ver/todasc'          ,'rOperativosController@actionVerReqop')->name('verReqop');
    Route::get('rop/buscar/todos'        ,'rOperativosController@actionBuscarReqop')->name('buscarReqop');        
    Route::get('rop/nueva'               ,'rOperativosController@actionNuevoReqop')->name('nuevoReqop');
    Route::post('rop/nueva/alta'         ,'rOperativosController@actionAltaNuevoReqop')->name('AltaNuevoReqop');      
    Route::get('rop/{id}/editar/reqop'   ,'rOperativosController@actionEditarReqop')->name('editarReqop');
    Route::put('rop/{id}/actualizarreqop','rOperativosController@actionActualizarReqop')->name('actualizarReqop'); 
    Route::get('rop/{id}/Borrarreqop'    ,'rOperativosController@actionBorrarReqop')->name('borrarReqop');

    Route::get('rop/{id}/editar/reqop1'   ,'rOperativosController@actionEditarReqop1')->name('editarReqop1');
    Route::put('rop/{id}/actualizarreqop1','rOperativosController@actionActualizarReqop1')->name('actualizarReqop1');    

    Route::get('rop/{id}/editar/reqop2'   ,'rOperativosController@actionEditarReqop2')->name('editarReqop2');
    Route::put('rop/{id}/actualizarreqop2','rOperativosController@actionActualizarReqop2')->name('actualizarReqop2'); 

    Route::get('rop/{id}/editar/reqop3'   ,'rOperativosController@actionEditarReqop3')->name('editarReqop3');
    Route::put('rop/{id}/actualizarreqop3','rOperativosController@actionActualizarReqop3')->name('actualizarReqop3');    

    Route::get('rop/{id}/editar/reqc9'   ,'rOperativosController@actionEditarReqc9')->name('editarReqc9');
    Route::put('rop/{id}/actualizarreqc9','rOperativosController@actionActualizarReqc9')->name('actualizarReqc9');    

    //Requisitos administrativos
    // Otros requisitos admon.  
    Route::get('rcontables/ver/todasc'         ,'rContablesController@actionVerReqc')->name('verReqc');
    Route::get('rcontables/buscar/todos'       ,'rContablesController@actionBuscarReqc')->name('buscarReqc');        
    Route::get('rcontables/nueva'              ,'rContablesController@actionNuevoReqc')->name('nuevoReqc');
    Route::post('rcontables/nueva/alta'        ,'rContablesController@actionAltaNuevoReqc')->name('AltaNuevoReqc');      
    Route::get('rcontables/{id}/editar/reqc'   ,'rContablesController@actionEditarReqc')->name('editarReqc');
    Route::put('rcontables/{id}/actualizarreqc','rContablesController@actionActualizarReqc')->name('actualizarReqc'); 
    Route::get('rcontables/{id}/Borrarreqc'    ,'rContablesController@actionBorrarReqc')->name('borrarReqc');

    Route::get('rcontables/{id}/editar/reqc6'   ,'rContablesController@actionEditarReqc6')->name('editarReqc6');
    Route::put('rcontables/{id}/actualizarreqc6','rContablesController@actionActualizarReqc6')->name('actualizarReqc6');    

    Route::get('rcontables/{id}/editar/reqc7'   ,'rContablesController@actionEditarReqc7')->name('editarReqc7');
    Route::put('rcontables/{id}/actualizarreqc7','rContablesController@actionActualizarReqc7')->name('actualizarReqc7'); 

    Route::get('rcontables/{id}/editar/reqc8'   ,'rContablesController@actionEditarReqc8')->name('editarReqc8');
    Route::put('rcontables/{id}/actualizarreqc8','rContablesController@actionActualizarReqc8')->name('actualizarReqc8');    

    Route::get('rcontables/{id}/editar/reqc9'   ,'rContablesController@actionEditarReqc9')->name('editarReqc9');
    Route::put('rcontables/{id}/actualizarreqc9','rContablesController@actionActualizarReqc9')->name('actualizarReqc9');    

    Route::get('rcontables/{id}/editar/reqc11'   ,'rContablesController@actionEditarReqc11')->name('editarReqc11');
    Route::put('rcontables/{id}/actualizarreqc11','rContablesController@actionActualizarReqc11')->name('actualizarReqc11');  

    Route::get('rcontables/{id}/editar/reqc10'   ,'rContablesController@actionEditarReqc10')->name('editarReqc10');
    Route::put('rcontables/{id}/actualizarreqc10','rContablesController@actionActualizarReqc10')->name('actualizarReqc10');     
    Route::get('rcontables/{id}/editar/reqc11'   ,'rContablesController@actionEditarReqc11')->name('editarReqc11'); 
    Route::put('rcontables/{id}/actualizarreqc11','rContablesController@actionActualizarReqc11')->name('actualizarReqc11');
    
    // quotas de 5 al millar meses
    Route::get('rcontables/{id}/editar/reqc1002'   ,'rContablesController@actionEditarReqc1002')->name('editarReqc1002');
    Route::put('rcontables/{id}/actualizarreqc1002','rContablesController@actionActualizarReqc1002')->name('actualizarReqc1002');
    Route::get('rcontables/{id}/editar/reqc1003'   ,'rContablesController@actionEditarReqc1003')->name('editarReqc1003');
    Route::put('rcontables/{id}/actualizarreqc1003','rContablesController@actionActualizarReqc1003')->name('actualizarReqc1003');
    Route::get('rcontables/{id}/editar/reqc1004'   ,'rContablesController@actionEditarReqc1004')->name('editarReqc1004');
    Route::put('rcontables/{id}/actualizarreqc1004','rContablesController@actionActualizarReqc1004')->name('actualizarReqc1004');
    Route::get('rcontables/{id}/editar/reqc1005'   ,'rContablesController@actionEditarReqc1005')->name('editarReqc1005');
    Route::put('rcontables/{id}/actualizarreqc1005','rContablesController@actionActualizarReqc1005')->name('actualizarReqc1005');
    Route::get('rcontables/{id}/editar/reqc1006'   ,'rContablesController@actionEditarReqc1006')->name('editarReqc1006');
    Route::put('rcontables/{id}/actualizarreqc1006','rContablesController@actionActualizarReqc1006')->name('actualizarReqc1006');
    Route::get('rcontables/{id}/editar/reqc1007'   ,'rContablesController@actionEditarReqc1007')->name('editarReqc1007');
    Route::put('rcontables/{id}/actualizarreqc1007','rContablesController@actionActualizarReqc1007')->name('actualizarReqc1007');
    Route::get('rcontables/{id}/editar/reqc1008'   ,'rContablesController@actionEditarReqc1008')->name('editarReqc1008');
    Route::put('rcontables/{id}/actualizarreqc1008','rContablesController@actionActualizarReqc1008')->name('actualizarReqc1008');
    Route::get('rcontables/{id}/editar/reqc1009'   ,'rContablesController@actionEditarReqc1009')->name('editarReqc1009');
    Route::put('rcontables/{id}/actualizarreqc1009','rContablesController@actionActualizarReqc1009')->name('actualizarReqc1009');
    Route::get('rcontables/{id}/editar/reqc1010'   ,'rContablesController@actionEditarReqc1010')->name('editarReqc1010');
    Route::put('rcontables/{id}/actualizarreqc1010','rContablesController@actionActualizarReqc1010')->name('actualizarReqc1010');
    Route::get('rcontables/{id}/editar/reqc1011'   ,'rContablesController@actionEditarReqc1011')->name('editarReqc1011');
    Route::put('rcontables/{id}/actualizarreqc1011','rContablesController@actionActualizarReqc1011')->name('actualizarReqc1011');
    Route::get('rcontables/{id}/editar/reqc1012'   ,'rContablesController@actionEditarReqc1012')->name('editarReqc1012');
    Route::put('rcontables/{id}/actualizarreqc1012','rContablesController@actionActualizarReqc1012')->name('actualizarReqc1012');

    // Validar y autorizar Incripción al RSE
    Route::get('validar/ver/irse'             ,'validarrseController@actionVerIrse')->name('verirse');
    Route::get('validar/buscar/irse'          ,'validarrseController@actionBuscarIrse')->name('buscarirse');  
    Route::get('validar/nueva'                ,'validarrseController@actionNuevoValrse')->name('nuevoValrse');
    Route::post('validar/nueva/alta'          ,'validarrseController@actionAltaNuevoValrse')->name('AltaNuevoValrse');    
    Route::get('validar/{id}/editar/valrse'   ,'validarrseController@actionEditarValrse')->name('editarValrse');
    Route::put('validar/{id}/actualizarvalrse','validarrseController@actionActualizarValrse')->name('actualizarValrse'); 
    Route::get('validar/{id}/BorrarValrse'    ,'validarrseController@actionBorrarValrse')->name('borrarValrse');
    Route::get('validar/{id}/{id2}/pdf'       ,'validarrseController@actionIrsePDF')->name('irsePDF');   
    
    //5. Solicitud de constancia de renovación del Objeto social
    Route::get('sconst/ver/todasc'          ,'constanciasController@actionVerConst')->name('verConst');
    Route::get('sconst/buscar/todos'        ,'constanciasController@actionBuscarConst')->name('buscarConst');        
    Route::get('sconst/nueva'               ,'constanciasController@actionNuevaConst')->name('nuevaConst');
    Route::post('sconst/nueva/alta'         ,'constanciasController@actionAltaNuevaConst')->name('AltaNuevaConst');      
    Route::get('sconst/{id}/editar/const'   ,'constanciasController@actionEditarConst')->name('editarConst');
    Route::put('sconst/{id}/actualizarconst','constanciasController@actionActualizarConst')->name('actualizarConst'); 
    Route::get('sconst/{id}/Borrarconst'    ,'constanciasController@actionBorrarConst')->name('borrarConst');

    Route::get('sconst/{id}/editar/const1'   ,'constanciasController@actionEditarConst1')->name('editarConst1');
    Route::put('sconst/{id}/actualizarconst1','constanciasController@actionActualizarConst1')->name('actualizarConst1'); 

    // Agenda
    //Programar diligencias
    Route::get('progdil/nuevo'           ,'progdilController@actionNuevoProgdil')->name('nuevoProgdil');
    Route::post('progdil/nuevo/alta'     ,'progdilController@actionAltaNuevoProgdil')->name('AltaNuevoProgdil');
    Route::get('progdil/ver/todas'       ,'progdilController@actionVerProgdil')->name('verProgdil');
    Route::get('progdil/buscar/todas'    ,'progdilController@actionBuscarProgdil')->name('buscarProgdil');    
    Route::get('progdil/{id}/editar/progdilig','progdilController@actionEditarProgdil')->name('editarProgdil');
    Route::put('progdil/{id}/actualizar' ,'progdilController@actionActualizarProgdil')->name('actualizarProgdil');
    Route::get('progdil/{id}/Borrar'     ,'progdilController@actionBorrarProgdil')->name('borrarProgdil');
    //Route::get('progdil/excel'           ,'progdilController@exportProgdilExcel')->name('ProgdilExcel');
    Route::get('progdil/{id}/pdf'        ,'progdilController@actionMandamientoPDF')->name('mandamientoPDF');

    Route::get('progdil/reporte/reportepv','progdilController@actionReporteProgvisitas')->name('reporteProgvisitas');
    Route::post('progdil/pdf/reportepv'   ,'progdilController@actionProgramavisitasPdf')->name('programavisitasPdf');
    Route::get('progdil/reporte/reporteexe' ,'progdilController@actionReporteProgvisitasExcel')->name('reporteProgvisitasExcel');
    Route::post('progdil/Excel//reporteexel','progdilController@actionProgramavisitasExcel')->name('programavisitasExcel');

    //Visitas de diligencia
    Route::get('visitas/nueva'             ,'visitasController@actionNuevaVisita')->name('nuevaVisita');
    Route::post('visitas/nueva/alta'       ,'visitasController@actionAltaNuevaVisita')->name('altaNuevaVisita');
    Route::get('visitas/ver/todas'         ,'visitasController@actionVerVisitas')->name('verVisitas');
    Route::get('visitas/buscar/todas'      ,'visitasController@actionBuscarVisita')->name('buscarVisita');    
    Route::get('visitas/{id}/editar/visita','visitasController@actionEditarVisita')->name('editarVisita');
    Route::put('visitas/{id}/actualizar'   ,'visitasController@actionActualizarVisita')->name('actualizarVisita');
    Route::get('visitas/{id}/Borrar'       ,'visitasController@actionBorrarVisita')->name('borrarVisita');   
    //Route::get('visitas/excel'           ,'visitasController@exportVisitasExcel')->name('VisitasExcel');
    Route::get('visitas/{id}/pdf'          ,'visitasController@actionActaVisitaPDF')->name('actavisitaPDF'); 

    //Indicadores
    Route::get('indicador/ver/todos'        ,'indicadoresController@actionVerCumplimiento')->name('vercumplimiento');
    Route::get('indicador/buscar/todos'     ,'indicadoresController@actionBuscarCumplimiento')->name('buscarcumplimiento');    
    Route::get('indicador/ver/todamatriz'   ,'indicadoresController@actionVermatrizCump')->name('vermatrizcump');
    Route::get('indicador/buscar/matriz'    ,'indicadoresController@actionBuscarmatrizCump')->name('buscarmatrizcump');      
    Route::get('indicador/ver/todasvisitas' ,'indicadoresController@actionVerCumplimientovisitas')->name('vercumplimientovisitas');
    Route::get('indicador/buscar/allvisitas','indicadoresController@actionBuscarCumplimientovisitas')->name('buscarcumplimientovisitas');    
    Route::get('indicador/{id}/oficiopdf'   ,'indicadoresController@actionOficioInscripPdf')->name('oficioInscripPdf'); 

    //Estadísticas
    //OSC
    Route::get('numeralia/graficaixedo'   ,'estadisticaOscController@OscxEdo')->name('oscxedo');
    Route::get('numeralia/graficaixmpio'  ,'estadisticaOscController@OscxMpio')->name('oscxmpio');
    Route::get('numeralia/graficaixrubro' ,'estadisticaOscController@OscxRubro')->name('oscxrubro');    
    Route::get('numeralia/graficaixrubro2','estadisticaOscController@OscxRubro2')->name('oscxrubro2'); 
    Route::get('numeralia/filtrobitacora' ,'estadisticaOscController@actionVerBitacora')->name('verbitacora');        
    Route::post('numeralia/estadbitacora' ,'estadisticaOscController@Bitacora')->name('bitacora'); 
    Route::get('numeralia/mapaxmpio'      ,'estadisticaOscController@actiongeorefxmpio')->name('georefxmpio');            
    Route::get('numeralia/mapas'          ,'estadisticaOscController@Mapas')->name('verMapas');        
    Route::get('numeralia/mapas2'         ,'estadisticaOscController@Mapas2')->name('verMapas2');        
    Route::get('numeralia/mapas3'         ,'estadisticaOscController@Mapas3')->name('verMapas3');        

    //padrón
    Route::get('numeralia/graficpadxedo'    ,'estadisticaPadronController@actionPadronxEdo')->name('padronxedo');
    //Route::get('numeralia/graficpadxmpio' ,'estadisticaPadronController@actionPadronxMpio')->name('padronxmpio');
    Route::get('numeralia/graficpadxserv'   ,'estadisticaPadronController@actionPadronxServicio')->name('padronxservicio');
    Route::get('numeralia/graficpadxsexo'   ,'estadisticaPadronController@actionPadronxsexo')->name('padronxsexo');
    Route::get('numeralia/graficpadxedad'   ,'estadisticaPadronController@actionPadronxedad')->name('padronxedad');
    Route::get('numeralia/graficpadxranedad','estadisticaPadronController@actionPadronxRangoedad')->name('padronxrangoedad');

    //Agenda
    Route::get('numeralia/graficaagenda1'     ,'progdilController@actionVerProgdilGraficaxmes')->name('verprogdilgraficaxmes');    
    Route::post('numeralia/graficaagendaxmes' ,'progdilController@actionProgdilGraficaxmes')->name('progdilgraficaxmes');
    Route::get('numeralia/graficaagenda2'     ,'progdilController@actionVerprogdilGraficaxtipo')->name('verprogdilgraficaxtipo');        
    Route::post('numeralia/graficaagendaxtipo','progdilController@actionProgdilGraficaxtipo')->name('progdilgraficaxtipo');

    // Email related routes
    Route::get('mail/ver/todos'        ,'mailController@actionVerContactos')->name('vercontactos');
    Route::get('mail/buscar/todos'     ,'mailController@actionBuscarContactos')->name('buscarcontactos');    
    Route::get('mail/{id}/editar/email','mailController@actionEditarEmail')->name('editaremail');
    //Route::put('mail/{id}/email'     ,'mailController@actionEmail')->name('Email'); 

    Route::get('mail/email'            ,'mailController@actionEmail')->name('Email'); 
    Route::put('mail/emailbienvenida'  ,'mailController@actionEmailBienve')->name('emailbienve'); 
    //Route::post('mail/send'          ,'mailController@send')->name('send');     
});

