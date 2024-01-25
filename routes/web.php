<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\InvokerController;
use App\Http\Controllers\Rolesypermisos;

use App\Http\Controllers\DocumentoExternoController;
use App\Http\Controllers\Mpvcontroller;
use App\Http\Controllers\Reniecsunat;
use App\Http\Controllers\FirmaperuController;
use App\Http\Controllers\ComunicacionInternaController;

use App\Http\Controllers\Tramites\TramitesController;
use App\Http\Controllers\Tramites\ArchivadorController;
use App\Http\Controllers\Tramites\DocumentoController;
use App\Http\Controllers\Tramites\Mesapartesvirtual;
use App\Http\Controllers\Tramites\ReporteController;

use App\Http\Controllers\Administrador\DepedendenciaController;
use App\Http\Controllers\Administrador\UserController;
use App\Http\Controllers\Tipodocumento\TipodocumentoController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();


route::post('/eliminarfile',[Mesapartesvirtual::class, 'eliminarfile'])->name('eliminarfile');

route::get('/mostrararchivo/{idfile}',[InvokerController::class, 'mostrararchivo'])->name('mostrararchivo');

Route::get('invoker/postArguments',[InvokerController::class, 'postArguments'])->name('invoker.postArguments');
Route::post('invoker/upload',[InvokerController::class, 'upload'])->name('invoker.upload');
Route::get('invoker/getArguments',[InvokerController::class, 'getArguments'])->name('invoker.getArguments');
Route::get('invoker/getFile',[InvokerController::class, 'getFile'])->name('invoker.getFile');

// FIRMA PERU FirmaperuController
Route::get('firmaperu/generatoken',[FirmaperuController::class, 'generatoken'])->name('firmaperu.generatoken');
Route::post('firmaperu/parametrogral',[FirmaperuController::class, 'parametrogral'])->name('firmaperu.parametrogral');
Route::get('firmaperu/parametrofirma',[FirmaperuController::class, 'parametrofirma'])->name('firmaperu.parametrofirma');
Route::post('firmaperu/upload',[FirmaperuController::class, 'upload'])->name('firmaperu.upload');

Route::get('firmaperu/versesion',[FirmaperuController::class, 'versesion'])->name('firmaperu.versesion');


// PRUEBA FIRMADOR
Route::get('firmadorperu',[FirmaperuController::class, 'firmadorperu'])->name('firmadorperu');
// FIN DE PRUBEA FIRMADOR


Route::get('documento/printR/{idFile}/{idDocumento}',[InvokerController::class, 'printPdfR'])->name('invoker.printPdfRefirma');

route::get('/alldependencia',[DepedendenciaController::class, 'alldependencia'])->name('alldependencia');
route::post('/nuevodependencia',[DepedendenciaController::class, 'nuevodependencia'])->name('nuevodependencia');
route::get('/dependencia/{id}',[DepedendenciaController::class, 'busdepedencia'])->name('busdepedencia');
route::post('/dependencia/update',[DepedendenciaController::class, 'dependenciaupdate'])->name('dependenciaupdate');

Route::get('unidades/obtenerUnidadOrganica',[DepedendenciaController::class, 'obtenerUnidadOrganica'])->name('unidades.obtenerUnidadOrganica');

route::get('/listardepeexterno',[DepedendenciaController::class, 'listardepeexterno'])->name('listardepeexterno');
route::get('/listardepeexternosinpg',[DepedendenciaController::class, 'listardepeexternosinpg'])->name('listardepeexternosinpg');// sin paginacion

route::get('/listardepe',[DepedendenciaController::class, 'index'])->name('dependencias');
route::get('/oficinas/{coddepe}',[DepedendenciaController::class, 'oficinas'])->name('oficinas');///api/oficinas/unidad/
route::get('/oficinas/unidad/{coddepe}',[DepedendenciaController::class, 'unidad'])->name('unidad');
route::get('/oficinas/nombredepe/{coddepe}',[DepedendenciaController::class, 'nombredepe'])->name('nombredepe');
route::get('/nombredepexuser',[DepedendenciaController::class, 'nombredepexuser'])->name('nombredepexuser');
route::post('/oficina/nueva',[DepedendenciaController::class, 'oficinanueva'])->name('oficinanueva');
route::post('/oficina/update',[DepedendenciaController::class, 'oficinaupdate'])->name('oficinaupdate');

route::post('/oficina/update',[DepedendenciaController::class, 'oficinaupdate'])->name('oficinaupdate');
Route::get('/unidadesdepe', [DepedendenciaController::class, 'unidades'])->name('depeunidades');

route::get('/listauser',[UserController::class, 'index'])->name('usuarios');// todo los usuarios para paginacion

route::get('/alluser',[UserController::class, 'alluser'])->name('alluser');// todo los usuarios sin paginacion
route::get('/listauser/{id}',[UserController::class, 'buscar'])->name('buscarusuarios');
route::get('/nombreuser/{id}',[UserController::class, 'nombreuser'])->name('nombreuser');

route::get('/listauserdepe/{id}',[UserController::class, 'listauserdepe'])->name('listauserdepe');
route::get('/representante/{id}',[UserController::class, 'representante'])->name('representante');
route::get('/detalleuserderivacion/{id}',[UserController::class, 'detalleuserderivacion'])->name('detalleuserderivacion');
route::get('/usuariosunidad/{depe}',[UserController::class, 'usuariosunidad'])->name('usuariosunidad');//lista user segun el id del user loeagdo
route::get('/oficinasdelusuario',[UserController::class, 'oficinasdelusuario'])->name('oficinasdelusuario');//el usuario logueado a que oficinas pertenece
route::get('/usuarios/obtenerUserDependenciaActivo',[UserController::class, 'obtenerUserDependenciaActivo'])->name('obtenerUserDependenciaActivo');
route::get('/usuarios/obtenerUserDependenciaActivoreport',[UserController::class, 'obtenerUserDependenciaActivoreport'])->name('obtenerUserDependenciaActivoreport');


route::post('/updateoficinauser',[UserController::class, 'updateoficinauser'])->name('updateoficinauser');// decativamos al usuario que pertenece a una oficina
route::post('/nuevaasignacion',[UserController::class, 'nuevaasignacion'])->name('nuevaasignacion');// nueva asignacion a la oficina
route::get('/buscauserofi/{id}',[UserController::class, 'buscauserofi'])->name('buscauserofi');// nueva asignacion a la oficina
route::post('/actualizauser',[UserController::class, 'actualizauser'])->name('actualizauser');// actualizar usuario en la tabla admin
route::post('/estadouser',[UserController::class, 'estadouser'])->name('estadouser');// actualizar usuario en la tabla admin





route::get('/datouserlogeado',[UserController::class, 'datouserlogeado'])->name('datouserlogeado');//datos del usuario logeado
route::post('/cerrarsesion',[UserController::class, 'cerrarsesion'])->name('cerrarsesion');//datos del usuario logeado



route::get('/exportaword',[TramitesController::class, 'exportaword'])->name('exportaword');

route::get('/buscaregdoc/{id?}',[TramitesController::class, 'buscaregdoc'])->name('buscaregdoc');

route::post('/generacionnuevotramite',[TramitesController::class, 'generacionnuevotramite'])->name('generacionnuevotramite');
route::post('/actualizaciontramite',[TramitesController::class, 'actualizaciontramite'])->name('actualizaciontramite');

// generar tramite por mesa de partes fisico
route::post('/generatramitemesapartes',[TramitesController::class, 'generatramitemesapartes'])->name('generatramitemesapartes');

route::get('/buscatipodocumento/{id}/{tipotram}', [TipodocumentoController::class, 'buscatipodocumento'])->name('buscatipodocumento');

Route::get('tipodocumento', [TipodocumentoController::class, 'index'])->name('lista');
Route::get('tipoDocumento', [TipodocumentoController::class, 'tipoDocumento'])->name('tipoDocumento.index');
Route::get('tipoDocumento/{id}', [TipodocumentoController::class, 'show'])->name('tipoDocumento.show');
Route::post('tipoDocumento', [TipodocumentoController::class, 'store'])->name('tipoDocumento.store');
Route::get('/documentompv', [TipodocumentoController::class, 'mpv'])->name('mpv');
Route::get('/tiposdocumentos/interno', [TipodocumentoController::class, 'interno'])->name('interno');
//administrador-correlativo
Route::get('/administrador/correlativos', [TipodocumentoController::class, 'correlativos'])->name('administrador.correlativos');
Route::put('/administrador/correlativos/{id}', [TipodocumentoController::class, 'update'])->name('administrador.update');
Route::post('/administrador/eliminarcorrelativo', [TipodocumentoController::class, 'destroy'])->name('administrador.destroy');

route::get('consulta_user/{iddepe}/{tipotram}/{seldoc}/{id}',[TramitesController::class, 'consulta_user'])->name('consulta_user');
route::get('tramite/documentoenproceso',[TramitesController::class, 'documentoenproceso'])->name('documentoenproceso'); 

route::get('tramite/porRecibir',[TramitesController::class, 'porRecibir'])->name('porRecibir');
route::get('tramite/archivados',[TramitesController::class, 'archivados'])->name('archivados');
// Route::get('documento/archivados', 'Tramite\DocumentoController@archivados')->name('documento.archivados');

Route::get('documento/buscarDocumento', [DocumentoController::class,'buscarDocumento'])->name('documento.buscarDocumento');
Route::post('documento/buscardocumentofile', [DocumentoController::class,'buscardocumentofile'])->name('documento.buscardocumentofile');

Route::get('expediente', [DocumentoController::class,'buscarexpediente'])->name('expediente.index');

Route::get('documento/print/{name}', [DocumentoController::class,'printPdf'])->name('documento.printPdf');
Route::post('documento/documentoDerivar', [DocumentoController::class,'documentoDerivar'])->name('documento.documentoDerivar');
Route::post('documento/documentoArchivar', [DocumentoController::class,'documentoArchivar'])->name('documento.documentoArchivar');
Route::post('documento/recepcionar', [DocumentoController::class,'recepcionar'])->name('documento.recepcionar');
Route::post('documento/devolverProceso', [DocumentoController::class,'devolverProceso'])->name('documento.devolverProceso');



Route::post('documento/generarObservacion', [DocumentoController::class,'generarObservacion'])->name('documento.generarObservacion');
Route::post('documento/eliminarDerivacion', [DocumentoController::class,'eliminarDerivacion'])->name('documento.eliminarDerivacion');


Route::post('documento/documentoAdjuntar', [DocumentoController::class,'documentoAdjuntar'])->name('documento.documentoAdjuntar');


// //mostrar vista de buscarModal
Route::get('buscar/buscarModal/{id}', [TramitesController::class,'buscarModal'])->name('buscar.buscarModal');

//mostrar vista de buscar expediente
Route::get('buscar/buscarExpedienteModal/{id}', [TramitesController::class,'buscarExpedienteModal'])->name('buscar.buscarExpedienteModal');



// ROLES Y PERMISOS
Route::get('rolesypermisos', [Rolesypermisos::class,'index'])->name('Rolesypermisos');
Route::post('addpermisos', [Rolesypermisos::class,'addpermisos'])->name('addpermisos');
Route::post('updatepermisos', [Rolesypermisos::class,'updatepermisos'])->name('updatepermisos');
Route::get('verpermisos/{idrol}', [Rolesypermisos::class,'verpermisos'])->name('verpermisos');
Route::post('quitarperdelrol', [Rolesypermisos::class,'quitarperdelrol'])->name('quitarperdelrol');
Route::post('agregarperdelrol', [Rolesypermisos::class,'agregarperdelrol'])->name('agregarperdelrol');

// PUBLICACIONES
Route::get('/comunicacionInterna/index', [ComunicacionInternaController::class,'index'])->name('comunicacionIntena.index');
Route::post('/comunicacionInterna/create', [ComunicacionInternaController::class,'store'])->name('comunicacionIntena.store');
Route::get('/comunicacionInterna/print/{id}', [ComunicacionInternaController::class,'printImagenes'])->name('comunicacionIntena.printImagenes');
Route::get('/comunicacionInterna/{id}', [ComunicacionInternaController::class,'show'])->name('comunicacionIntena.show');
Route::get('/comunicadoactivo',[ComunicacionInternaController::class,'activos'])->name('comunicadoactivo');

// route::get('/comunicacion-dashboard',[ComunicacionInternaController::class,'dashboard'])->name('coumnicacion.dashboard');

route::get('tramite/obtenerTotal',[TramitesController::class, 'obtenerTotal'])->name('obtenerTotal');// para el dashboard

// catalogo
// archicadores
// Route::resource('archivador', [ArchivadorController::class,'obtenerArchivadores']);
Route::get('archivador/obtenerArchivadores', [ArchivadorController::class,'obtenerArchivadores'])->name('archivador.obtenerArchivadores');
Route::get('/archivador', [ArchivadorController::class,'index'])->name('archivador.index');
Route::get('/archivador/{id}', [ArchivadorController::class,'show'])->name('archivador.show');
Route::post('/archivador', [ArchivadorController::class,'store'])->name('archivador.store');


// DESA DE PARTES VIRTUAL
Route::get('/mesapartes', [Mesapartesvirtual::class,'index'])->name('mesapartesvirtual.index');
Route::get('/mesapartes/{id}/{token}', [Mesapartesvirtual::class,'editmpv'])->name('mesapartesvirtual.editmpv');
Route::post('/mesapartesbuscar', [Mesapartesvirtual::class,'buscarmpv'])->name('mesapartesvirtual.buscarmpv');
Route::post('/nuevotramiteexterno', [TramitesController::class, 'nuevoDocExterno'])->name('mesapartesvirtual.nuevoDocExterno');
Route::get('/documentosdigitales', [Mesapartesvirtual::class,'documentosdigitales'])->name('mesapartesvirtual.documentosdigitales');
Route::get('/dependenciaMesaPartesVirtual', [DepedendenciaController::class,'dependenciaMesaPartesVirtual'])->name('dependencia.dependenciaMesaPartesVirtual');
// Route::post('/mpv/derivar', 'Tramite\DocumentoExternoController@derivar')->middleware('auth');
Route::post('/mpv/derivar', [DocumentoExternoController::class,'derivar'])->middleware('auth');
Route::get('/mpv/derivados', [DocumentoExternoController::class,'derivados'])->middleware('auth');
Route::get('/mpv/pdf', [DocumentoExternoController::class,'pdf'])->middleware('auth');
Route::get('/mensajempv', [Mesapartesvirtual::class,'mensajempv'])->name('mensajempv');

route::get('/mpv',[DocumentoExternoController::class,'index'])->name('mpv.index');
Route::post('/mpv/archivar', [DocumentoExternoController::class,'archivar'])->middleware('auth');
Route::post('/mpv/transferir', [DocumentoExternoController::class,'transferir']);
Route::post('/mpv/{mpv}', [DocumentoExternoController::class,'editar'])->middleware('auth');


route::get('/registro/seguimiento',[DocumentoExternoController::class,'seguimiento'])->name('seguimiento');
route::post('/consulta/tramiteexterno',[DocumentoExternoController::class,'consultaexterno'])->name('consultaexterno');

// reportes
// Route::get('reporte/obtenerReporte', 'Tramite\ReporteController@obtenerReporte')->name('reporte.obtenerReporte');
Route::get('reporte/obtenerReporte', [ReporteController::class,'obtenerReporte'])->name('reporte.obtenerReporte');
Route::resource('/tramite/reportes', 'App\Http\Controllers\Tramites\ReporteController');

// Reniecsunat
// route::get('/reniec/{dni}',[Reniecsunat::class, 'reniec'])->name('reniec');
route::post('/reniec',[Reniecsunat::class, 'reniec'])->name('reniec');
// route::get('/sunat/{ruc}',[Reniecsunat::class, 'sunat'])->name('sunat');
route::post('/sunat',[Reniecsunat::class, 'sunat'])->name('sunat');

route::get('/duplicado/{dni}',[UserController::class, 'duplicado'])->name('duplicado');// usuarios duplicados
route::post('/nuevousuario',[UserController::class, 'nuevousuario'])->name('nuevousuario');// usuarios duplicados
route::post('/actualizapassword',[UserController::class, 'actualizapassword'])->name('actualizapassword');// usuarios duplicados

// actualizamos correo y telefono del tramitante
route::post('updatetelenocorreo',[Reniecsunat::class, 'updatetelenocorreo'])->name('updatetelenocorreo');

// pruebas
route::get('/prueba',[TipodocumentoController::class, 'prueba'])->name('prueba');
route::get('/css/adminlte.css.map', [App\Http\Controllers\HomeController::class, 'index'])->name('redirect');



Route::get('/{any?}', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->where('any','.*');
