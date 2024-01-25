<template>
<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $route.name }}</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <router-link :to="'/'">Dashboard</router-link>
                        </li>
                        <li class="breadcrumb-item active">{{ $route.name }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="content">
        <div class="container-fluid">
            <div class="row mt-10">
                <div class="col-lg-6 col-10">
                    <router-link :to="'/Tramites/Enproceso'" class="btn btn-info btn-sm"><i class="fa-regular fa-circle-left"></i>Volver a documentos en proceso</router-link>
                </div>

            </div>

            <div class="row mt-2">

                <div class="col-12">
                    <div class="card card-primary card-outline card-revenue-budget">

                        <div class="card-body pt-1">

                            <div class="row">

                                <div class="col-sm-6 revenue-report-wrapper border-right">
                                    <div class="form-group row">
                                        <label class="col-sm-3"><small>Expediente</small>:</label>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control form-control-sm" v-if="formdocumentos.expediente" disabled placeholder="N°" v-model="formdocumentos.expediente">
                                        </div>
                                        <div class="col-sm-6">
                                            <small>respuesta de expediente</small>
                                        </div>
                                    </div>
                                    <div class="form-group row border-bottom">
                                        <label class="col-sm-3"><small>Referencias:</small></label>
                                        <div class="col-sm-9">
                                            <div class="table-responsive">
                                                <table class="table table-hover table-bordered table-sm">
                                                    <tbody>
                                                        <tr>
                                                            <td width="185"><input type="number" class="form-control form-control-sm" placeholder="Reg. documento" v-model="formdocumentos.camporeferencia"></td>
                                                            <td class="text-center" @click.prevent="agregarreferenias"><i class="fa-solid fa-plus me-25"></i></td>
                                                        </tr>
                                                        <tr v-for="(find, index) in formdocumentos.array_referencias">
                                                            <td width="90%">
                                                                <input v-model="find.value" :key="index" class="form-control form-control-sm text-uppercase" placeholder="Referencia"></td>
                                                            <td>
                                                                <button class="btn btn-default btn-sm" @click.prevent="eliminarefe(index)"><i class="fa-solid fa-trash-can"></i></button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <label class="col-sm-3"><small>Forma de registro:</small></label>
                                        <div class="col-sm-9">
                                            <div class="demo-inline-spacing">
                                                <div class="form-check form-check-inline" style="margin-top: 0rem !important;">
                                                    <input type="radio" name="inlineRadioOptions" value="1" checked v-model="formdocumentos.frregistro" disabled />
                                                    <label class="form-check-label"><small>Interno</small></label>
                                                </div>
                                                <div class="form-check form-check-inline" style="margin-top: 0rem !important;">
                                                    <input type="radio" name="inlineRadioOptions" value="2" v-model="formdocumentos.frregistro" disabled />
                                                    <label class="form-check-label"><small>Para externo</small></label>
                                                </div>

                                            </div>
                                        </div>

                                    </div>

                                    <template v-if="formbuscardoc.formatram==1">
                                        <div class="form-group row">
                                            <label class="col-sm-3"><small>Tipo:</small></label>

                                            <div class="col-sm-6">
                                                <div class="demo-inline-spacing">

                                                    <div class="form-check form-check-inline" style="margin-top: 0rem !important;">
                                                        <input type="checkbox" v-model="formdocumentos.tipotramite" :value="1" disabled />
                                                        <label class="form-check-label"><small>Documento Personal</small></label>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3"><small>Unidad Org:</small></label>
                                            <div class="col-sm-9">
                                                <small>{{ formdocumentos.codigounidad }} - {{ formdocumentos.nombre_oficina }}</small>
                                            </div>

                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3"><small>Firma:</small></label>
                                            <div class="col-sm-9">
                                                <small>{{ formdocumentos.firma }}</small>
                                            </div>

                                        </div>
                                        <div class="form-group row border-bottom">
                                            <label class="col-sm-3"><small>Cargo:</small></label>
                                            <div class="col-sm-9">
                                                <small>{{ formdocumentos.cargo}}</small>
                                            </div>

                                        </div>
                                    </template>
                                    <template v-else>

                                        <div class="border p-1">
                                            <div class="form-group row">
                                                <label for="" class="col-sm-3">Entidad:</label>
                                                <div class="col-sm-2">
                                                    <input type="number" class="form-control form-control-sm" v-model="formdocumentos.codigounidad">
                                                </div>
                                                <div class="col-sm-7">
                                                    <select class="form-control form-control-sm" v-model="formdocumentos.codigounidad">
                                                        <option v-for="lista in listadependenciasext" :key="lista.iddependencia" v-text="lista.depe_nombre" :value="lista.iddependencia"></option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="" class="col-sm-3">DNI/RUC:</label>
                                                <div class="col-sm-4">
                                                    <select class="form-control form-control-sm" v-model="rucdni">
                                                        <option value="1">
                                                            DNI
                                                        </option>
                                                        <option value="2">
                                                            RUC
                                                        </option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-5" v-if="rucdni==1">
                                                    <input type="text" name="dni" placeholder="DNI" class="form-control form-control-sm" v-model="formdocumentos.dni">
                                                </div>
                                                <div class="col-sm-5" v-else>
                                                    <input type="text" name="dni" placeholder="RUC" class="form-control form-control-sm" v-model="formdocumentos.ruc">
                                                </div>

                                            </div>
                                            <div class="form-group row">
                                                <label for="" class="col-sm-3">Firma:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="firma" class="form-control form-control-sm text-uppercase" v-model="formdocumentos.firma">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="" class="col-sm-3">Cargo:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="cargo" class="form-control form-control-sm text-uppercase" v-model="formdocumentos.cargo">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="" class="col-sm-3">Celular:</label>
                                                <div class="col-sm-9">
                                                    <input type="text" name="celular" class="form-control form-control-sm" v-model="formdocumentos.telefono">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="" class="col-sm-3">Correo electrónico:</label>
                                                <div class="col-sm-9">
                                                    <input type="email" name="correo" class="form-control form-control-sm" v-model="formdocumentos.docu_emailorigen">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="" class="col-sm-3">Dirección:</label>
                                                <div class="col-sm-9">
                                                    <input type="email" name="direccion" class="form-control form-control-sm text-uppercase" v-model="formdocumentos.direccion">
                                                </div>
                                            </div>
                                        </div>

                                    </template>

                                    <div class="form-group row">
                                        <label class="col-sm-3"><small>Fecha:</small></label>
                                        <div class="col-sm-6">
                                            <input type="date" class="form-control form-control-sm" placeholder="N°" v-model="formdocumentos.fechatramite" id="fechadate">
                                        </div>

                                    </div>
                                    <div class="form-group row" v-if="formdocumentos.frregistro==2">
                                        <label class="col-sm-3"><small>Tipo de Documento:</small></label>
                                        <div class="col-sm-9">

                                            <select v-model="formdocumentos.tipodocumento" :class="'form-control form-control-sm '+valida_tipodoc" placeholder="Elijir el documento" required>
                                                <option v-for="list in listadocumento" :key="list.idtdoc" :value="list.idtdoc"><small>{{ list.tdoc_descripcion }}</small></option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="form-group row" v-if="formdocumentos.frregistro==1">
                                        <label class="col-sm-3"><small>Documentos:</small></label>
                                        <div class="col-sm-9">
                                            <span class="badge badge-primary">{{ formdocumentos.tdoc_descripcion }} {{ formdocumentos.correlativodoc }}-{{ formdocumentos.siglasdoucmento }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group row" v-if="formdocumentos.frregistro==2">
                                        <label class="col-sm-3"><small>Número y Siglas:</small></label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control form-control-sm" v-model="formdocumentos.correlativodoc">
                                        </div>
                                        <div class="col-sm-7">
                                            <input type="text" class="form-control form-control-sm text-uppercase" v-model="formdocumentos.siglasdoucmento">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3"><small>Forma Recepción:</small></label>
                                        <div class="col-sm-3">
                                            <select class="form-control form-control-sm" v-model="formdocumentos.formarecepcion">
                                                <option value="1">DIRECTA</option>
                                                <option value="2">FAX</option>
                                                <option value="3">VIA WEB</option>
                                                <option value="5">CEN.MED. S.M.CAUTIVO</option>
                                            </select>
                                        </div>
                                        <label class="col-sm-3"><small>Prioridad:</small></label>
                                        <div class="col-sm-3">
                                            <select class="form-control form-control-sm" v-model="formdocumentos.prioridad">
                                                <option value="1">NORMAL</option>
                                                <option value="2">URGENTE</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3"><small>Folios:</small></label>
                                        <div class="col-sm-3">
                                            <input type="number" :class="'form-control form-control-sm  '+ valida_folios" placeholder="N°" v-model="formdocumentos.folios">
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-3"><small>Asunto:</small></label>
                                        <div class="col-sm-9">
                                            <textarea :class="'form-control form-control-sm text-uppercase '+ valida_asunto" rows="2" placeholder="Asunto" v-model="formdocumentos.asunto"></textarea>
                                        </div>

                                    </div>
                                </div>

                                <div class="col-md-6 p-0">

                                    <div class="card-body pt-1">

                                        <h6><small>Derivacion de documento</small></h6>
                                        <div class="form-group row">
                                            <label class="col-sm-3"><small>Forma:</small></label>

                                            <div class="col-sm-6">
                                                <div class="demo-inline-spacing">

                                                    <div class="form-check form-check-inline" style="margin-top: 0rem !important;">
                                                        <input class="form-check-input" type="checkbox" value="unchecked" v-model="formdocumentos.formaderivacion" />
                                                        <label class="form-check-label"><small>Copia</small></label>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3"><small>U.Organica:</small></label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control form-control-sm" placeholder="Cod." v-model="formdocumentos.cod_unidad" @keyup="capturaiddepe()">
                                            </div>
                                            <div class="col-sm-7">
                                                <!-- <select class="form-control form-control-sm" v-model="formdocumentos.cod_unidad" @change="capturaiddepe()">
                                                    <option v-for="lista in listadependencias" :key="lista.iddependencia" v-text="lista.depe_nombre" :value="lista.iddependencia"></option>
                                                </select> -->

                                                <el-select v-model="formdocumentos.textdepe" @change="buscaid()" filterable placeholder="Seleccione la dependencia" style="width: 100%;" size="small">
                                                    <el-option v-for="(lista, indexDepe) in listadependencias" :key="indexDepe" :label="lista.depe_sigla+'-'+recortacadena(lista.depe_nombre)" :value="lista.iddependencia">
                                                    </el-option>
                                                </el-select>


                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="col-sm-3"><small>Detalle:</small></label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm text-uppercase" placeholder="N°" v-model="formdocumentos.detalle">
                                            </div>

                                        </div>
                                        <div class="form-group row" id="divusers" v-show="showdiv">
                                            <label class="col-sm-3"><small>Usuario:</small></label>

                                            <div class="col-sm-9">
                                                <select class="form-control form-control-sm" v-model="formdocumentos.usuario" @change="detalleuser">
                                                    <template v-for="itemuser in listadouser">
                                                        <option v-if="itemuser.id!=formdocumentos.iduser && itemuser.adm_email!='SUPERADMIN'" v-text="itemuser.adm_name+' '+itemuser.adm_lastname" :value="itemuser.id"></option>
                                                    </template>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">

                                            <div class="col-sm-3">
                                                <label><small>Proveido de atención:</small></label>
                                                <button type="button" class="btn btn-outline-primary btn-sm " @click.prevent="agregarderivacion"><i class="fa-regular fa-calendar-plus"></i> <small>Añadir</small></button>
                                            </div>
                                            <div class="col-sm-9">
                                                <textarea class="form-control form-control-sm text-uppercase" rows="2" v-model="formdocumentos.proveido"></textarea>

                                                <!-- <button type="button" class="btn btn-outline-danger btn-sm "><i class="fa-regular fa-trash-can"></i><small>Limpiar</small></button> -->
                                            </div>

                                        </div>
                                        <div class="form-group row" v-show="showtabladerivaciones">
                                            <table id="tabla" class="table table-bordered table-hover table-sm">
                                                <thead>
                                                    <tr class="bg-info disabled color-palette">
                                                        <th><small>FORMA</small></th>
                                                        <th><small>UNIDAD ORGANICA</small></th>
                                                        <th><small>DETALLE</small></th>
                                                        <th><small>USUARIO</small></th>
                                                        <th><small>PROVEIDO</small></th>
                                                        <th></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr v-for="(der, index) in formdocumentos.derivaciones">

                                                        <td><small>{{ der.textforma }}</small></td>
                                                        <td><small>{{ der.vnomoficina }}</small></td>
                                                        <td><small>{{ der.vdetalle }}</small></td>
                                                        <td><small>{{ der.vnombreuser }}</small></td>
                                                        <td><small>{{ der.vproveido }}</small></td>
                                                        <td><button class="btn btn-default btn-sm" @click.prevent="eliminaderivacion(index)"><i class="fa-solid fa-trash-can"></i></button></td>
                                                    </tr>

                                                    <tr v-for="(editder, index) in formdocumentos.derivacionesedit" v-if="editder.oper_acciones">

                                                        <td><small>{{ (editder.oper_forma==0)?'ORIGINAL':'COPIA' }}</small></td>
                                                        <td><small>{{ editder.depe_destino }}</small></td>
                                                        <td><small>{{ editder.oper_detalledestino }}</small></td>
                                                        <td><small>{{ editder.dest_representante }}</small></td>
                                                        <td colspan="2"><small>{{ editder.oper_acciones }}</small></td>

                                                    </tr>

                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="form-group row mt-1 border-top pt-1">
                                            <label class="col-sm-4"><small>Archivo(principal en PDF):</small></label>
                                            <div class="col-sm-3" v-show="btn_cargarpdf">

                                                <button class="btn btn-success btn-sm">
                                                    <input type="file" name="docu_archivo" accept=".pdf" style="position: absolute; z-index: 2; top: 0px; left: 10%; opacity: 0; line-height: 2;background-color: transparent; color: transparent;max-width: 60%;max-width: 68%;" id="files" ref="files" @change="handleFilesUpload( $event )"><i class="fa-regular fa-file-pdf"></i> Cargar
                                                </button>
                                            </div>

                                            <div class="col-sm-4" v-show="btn_sincronizar">

                                                <button class="btn btn-success btn-sm">
                                                    <input type="file" name="docu_archivo" accept=".pdf" style="position: absolute; z-index: 2; top: 0px; left: 10%; opacity: 0; line-height: 2;background-color: transparent; color: transparent;max-width: 60%;max-width: 68%;" id="files" ref="files" @change="handleFilesUpload( $event )">

                                                    <i class="fa-regular fa-file-word"></i> Cargar
                                                </button>
                                            </div>

                                        </div>

                                        <div class="form-group row mt-1" v-show="btn_anexo">
                                            <label class="col-sm-4"><small>Anexos( máx.4 archivos):</small></label>
                                            <div class="col-sm-3">
                                                <button class="btn btn-warning btn-sm">
                                                    <input type="file" name="docu_archivo" accept="application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" style="position: absolute; z-index: 2; top: 0px; left: 10%; line-height: 2; opacity: 0; background-color: transparent; color: transparent;max-width: 68%;" id="anexos" multiple ref="anexos" @change="carganexos( $event )"><i class="fa-regular fa-file-pdf"></i> Cargar
                                                </button>
                                            </div>
                                            <div class="col-sm-5">
                                                <small>(PDF, Imágenes, Word y Excel)</small>
                                            </div>

                                        </div>

                                        <!-- mostrar los archivos cargados -->
                                        <div class="form-group  mt-1">

                                            <div v-for="(file, key) in files" class="row border-top">

                                                <div class="col-sm-7" v-if="getFileExtension3(file.name)=='pdf'">

                                                    <i class="fa-regular fa-file-pdf"></i>
                                                    <small class="text-primary">{{ file.name }} <span class="badge float-right badge-light-info badge-pill">{{tamaniofile(file.size)}}</span></small>
                                                </div>
                                                <div class="col-sm-7" v-else>

                                                    <i class="fa-regular fa-file-word"></i><small class="text-primary">{{ file.name }} <span class="badge float-right badge-light-info badge-pill">{{tamaniofile(file.size)}}</span></small>
                                                </div>
                                                <div class="col-sm-3 pt-1">
                                                    <!-- <div class="progress" style="height: 6px;"><div role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="50" class="progress-bar" style="width: 50%;"></div></div> -->

                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                            <!-- <span class="sr-only">60% Complete (warning)</span> -->
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2 ">
                                                    <span class="badge badge-primary">p</span>
                                                    <span class="badge float-right badge-light-danger badge-pill" v-on:click="removeFile( key )"><i class="fa-solid fa-trash-can"></i></span>
                                                </div>

                                            </div>
                                            <!-- para anexos -->
                                            <div v-for="(file_a, key) in anexosfiles" class="row border-top">

                                                <div class="col-sm-7" v-if="getFileExtension3(file_a.name)=='pdf'">

                                                    <i class="fa-regular fa-file-pdf"></i>
                                                    <small class="text-primary">{{ file_a.name }} <span class="badge float-right badge-light-info badge-pill">{{tamaniofile(file_a.size)}}</span></small>
                                                </div>
                                                <div class="col-sm-7" v-else>

                                                    <i class="fa-regular fa-file-word"></i><small class="text-primary">{{ file_a.name }} <span class="badge float-right badge-light-info badge-pill">{{tamaniofile(file_a.size)}}</span></small>
                                                </div>
                                                <div class="col-sm-3 pt-1">
                                                    <!-- <div class="progress" style="height: 6px;"><div role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="50" class="progress-bar" style="width: 50%;"></div></div> -->

                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-striped bg-warning progress-bar-animated" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                            <!-- <span class="sr-only">60% Complete (warning)</span> -->
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2 ">
                                                    <span class="badge badge-warning">A</span>
                                                    <span class="badge float-right badge-light-danger badge-pill" v-on:click="removeFileanexos( key )"><i class="fa-solid fa-trash-can"></i></span>
                                                </div>

                                            </div>

                                            <!-- mostrar archivos cuando se carga para editar -->
                                            <div v-for="(digi, key) in docdigitales" class="row border-top">

                                                <div class="col-sm-7" v-if="digi.file_tipo=='application/pdf'">

                                                    <i class="fa-regular fa-file-pdf"></i>
                                                    <small class="text-primary">{{ digi.file_name }} <span class="badge float-right badge-light-info badge-pill">{{tamaniofile(digi.file_size)}}</span></small>
                                                </div>
                                                <div class="col-sm-7" v-else>

                                                    <i class="fa-regular fa-file-word"></i><small class="text-primary">{{ digi.file_name }} <span class="badge float-right badge-light-info badge-pill">{{tamaniofile(digi.file_size)}}</span></small>
                                                </div>
                                                <div class="col-sm-3 pt-1">

                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2" v-if="digi.file_principal==0">
                                                    <span class="badge badge-primary">p</span>
                                                    <span class="badge float-right badge-light-danger badge-pill" v-on:click="eliminar_principal( key,digi.id )"><i class="fa-solid fa-trash-can"></i></span>
                                                </div>
                                                <div class="col-sm-2" v-else>
                                                    <span class="badge badge-warning">A</span>
                                                    <span class="badge float-right badge-light-danger badge-pill" v-on:click="eliminar_anexos( key,digi.id  )"><i class="fa-solid fa-trash-can"></i></span>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="form-group row mt-1 p-2" style="background: #63c7d6">
                                            <div class="text-center">

                                                <button type="submit" class="btn btn-danger btn-sm" @click="update_tramite"><i class="fa-regular fa-floppy-disk"></i> Guardar</button>
                                            </div>
                                        </div>

                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
        </div>

        <!-- RESULTADO DE LA CREACION DE Documento -->
        <div id="resultadodoc" class="modal-dialog" style="max-width:350px !important; display: none">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title">
                        <i class="glyphicon glyphicon-menu-right"></i>&#160;&#160; ReFirma Invoker
                    </div>
                </div>
                <div class="modal-body">
                    <div class="row" style="display: inherit;">
                        <div class="col-sm-12 text-center">
                            <br />

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <br />
                            <div id="status">ss</div>
                            <br />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <docu-invoker ref="foo" :iframe="iframe" :route-invoker-get="routeInvokerGet" :route-invoker-post="routeInvokerPost" :usuario="usuario" :ruta="ruta" @firmado="firmado" />

    </div>

    <div class="modal fade" id="mensajeeeror">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="callout callout-danger" v-for="erro in errordatos">
                        <h5>{{ erro }}</h5>
                    </div>
                </div>
                <div class="modal-footer float-right p-1">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>
</template>

<script>
// import DocuInvoker from './DocuInvoker'
import VDragged from 'v-dragged'
import DocuInvoker from './DocuInvoker'
import Vue from 'vue'
import Swal from 'sweetalert2';
import axios from 'axios';
window.$ = window.jQuery = require('jquery')
Vue.use(VDragged);
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        //toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
});

export default {
    props: ['ruta', 'usuario', 'routeInvokerGet', 'routeInvokerPost'],
    data() {
        return {
            formbuscardoc: {
                iddoc: this.$route.params.doc,
                idexpediente: null,
                formatram: null, //1: interno, 2: externo
            },
            formdocumentos: {
                expediente: '',
                referencias: '',
                array_referencias: [], // referencias al documento
                json_referencias: [], // referencias al documento en formato json
                camporeferencia: '',
                frregistro: 1, // tramite interno 1  externo 2
                codigounidad: '', // captura de tabla admin a donde pertenece el usuario
                nombre_oficina: '',
                tipotramite: 0, //o: represnetante oficina 1: tramite personal
                idusercreador: '', // iduser el id de user el que crea
                firma: '',
                cargo: '',
                telefono: '',
                direccion: '',
                firmadestino: '', //firma de destino
                cargodestino: '', // cargo destino
                fechatramite: '', // new Date().toISOString().substr(0, 10),
                tipodocumento: '', //codigo del tipo de documento
                correlativodoc: '',
                siglasdoucmento: '',
                tdoc_descripcion: '',
                ciudad: '',
                direccion: '',
                clavedoc: '',
                formarecepcion: 1,
                prioridad: 1,
                dni: '',
                ruc: '',
                iduser: '',
                folios: '',
                asunto: '',
                docu_emailorigen: '',
                formaderivacion: false,
                cod_unidad: '', // codigo unidad a donde derviva
                unidadorganica: '', // nombre unidad a quien se deriva
                detalle: '',
                usuario: '', //codigo de usuario a quien se deriva cuando es en la misma unidad
                proveido: '', // proveido destino
                derivaciones: [], // las unidades dondde derivaran respectivas unidades
                derivacionesedit: [],
                json_derivaciones: [], //las unidades dondde derivaran respectivas unidades en formato json
                textdepe:''
            },
            listadocumento: {},
            datosuser: {},
            listadependencias: {},
            listadependenciasext: {},
            nombredocumento: '',
            nombredoc_export: '',
            listadouser: {},
            representantedestino: {},
            showdiv: false,
            mostrarpdf: true,
            mdlInvoker: true,
            mostrarposicionfrima: false,
            showtabladerivaciones: false,
            isDisabled_btngenerar: false,
            btn_sincronizar: false,
            btn_anexo: true,
            btn_cargarpdf: true,
            btn_cargarword: true,
            rucdni: 1, //1:dni, 2:ruc

            modal: false,
            files: [], // principal
            anexosfiles: [], // para anexos
            /// validaciones /////
            valida_tipodoc: '',
            valida_folios: '',
            valida_asunto: '',

            docdigitales: [],

            //  deatalleuser:{}

            // DATOS PARA REFIRMA INVOKER
            iframe: {
                src: null,
                loaded: false,
                type: null
            },
            // archivo existente para firmar
            ArchivoFirma: '', // retorno del patch de pdf cargado para ser firmado
            Existe: 0, // 0:no existe el archivo para la firma, 1: existe archiv para firma => activamos el boton para firmar
            EstadoFirma: false, // habilitar boton firmar digitalmente
            btngenerartramite: true,
            btngenerarnewtramite: false,
            idfile: '',
            idtramdoc: '',
            errordatos: []

        }
    },

    components: {
        DocuInvoker
    },
    mounted() {
        // this.tipostramite();
        this.listadodocumento();
        this.fechasistema();

        if (this.formbuscardoc.iddoc) {
            this.buscaexpediente(this.formbuscardoc.iddoc);
        }
        //this.img = this.imgs.s_load
        //         let today = new Date().toISOString().substring(0, 10);
        // document.querySelector("#fechadate").value = today;
        //this.formdocumentos.fechasistema=new Date().toISOString().substring(0, 10)

    },
    methods: {

        // toast(texto_titulo,texto_anuncio,icono)
        toast(texto_anuncio, icono) {

            Toast.fire({
                // title:texto_titulo,
                title: '<small><strong>' + texto_anuncio + '</strong></small>',
                icon: icono,
                // text: texto_anuncio
            });
        },
        buscaexpediente(regdoc) {
            var url = '/documento/buscarDocumento?iddocumento=' + regdoc;
            axios.get(url)
                .then(res => {
                    // console.log(res.data)
                    this.formbuscardoc.idexpediente = res.data.documento.expediente
                    this.formbuscardoc.formatram = res.data.documento.docu_origen // 1: interno,2:externo
                    this.formdocumentos.expediente = res.data.documento.expediente
                    this.formdocumentos.frregistro = res.data.documento.docu_origen // 1: interno,2:externo
                    this.formdocumentos.tipotramite = res.data.documento.docu_tipo

                    this.formdocumentos.firma = res.data.documento.docu_firma;
                    this.formdocumentos.cargo = res.data.documento.docu_cargo;
                    this.formdocumentos.siglasdoucmento = res.data.documento.docu_siglas_doc;
                    this.formdocumentos.correlativodoc = res.data.documento.docu_numero_doc;
                    this.formdocumentos.codigounidad = res.data.documento.docu_iddependencia;
                    this.formdocumentos.idusercreador = res.data.documento.docu_idusuario;
                    this.formdocumentos.nombre_oficina = res.data.documento.unidad;
                    this.formdocumentos.tdoc_descripcion = res.data.documento.tdoc_descripcion;
                    this.formdocumentos.folios = res.data.documento.docu_folios;
                    this.formdocumentos.asunto = res.data.documento.docu_asunto;
                    this.formdocumentos.telefono = res.data.documento.docu_telef;
                    this.formdocumentos.docu_emailorigen = res.data.documento.docu_emailorigen;
                    this.formdocumentos.fechatramite = res.data.documento.docu_fecha_doc;
                    this.formdocumentos.direccion = res.data.documento.docu_domic;
                    this.formdocumentos.derivacionesedit = res.data.operaciones
                    this.listadependencias = res.data.dependencias;
                    this.formdocumentos.dni = res.data.documento.docu_dni;
                    this.formdocumentos.ruc = res.data.documento.docu_ruc;
                    this.formdocumentos.iduser = res.data.documento.docu_idusuario;
                    this.formdocumentos.tipodocumento = res.data.documento.docu_idtipodocumento;

                    if (this.formdocumentos.dni) {
                        this.rucdni = 1
                    } else {
                        this.rucdni = 2
                    }
                    // si el tramite es externo, => this.formdocumentos.codigounidad=0
                    // if(this.formdocumentos.frregistro==2)
                    // {
                    //     this.formdocumentos.codigounidad=0;// xq esto no pertenece a ningina unidad organica
                    // }

                    this.depeexternos();
                    this.docdigitales = res.data.digitales;
                    if (res.data.digitales.length) {
                        if (res.data.digitales[0].file_principal == 0) {
                            this.btn_cargarpdf = false
                        }

                    }
                    if (this.formdocumentos.derivacionesedit.length > 1) {
                        this.showtabladerivaciones = true
                    }

                })
        },
        depeexternos() {
            var url = '/listardepeexternosinpg'
            axios.get(url)
                .then(res => {
                    this.listadependenciasext = res.data;
                })
        },
        verificacion() {
            this.errordatos = [];
            if (this.formdocumentos.firma == '' || this.formdocumentos.firma == null) {
                this.errordatos.push('El campo de firma esta vacio');
            }
            if (this.formdocumentos.cargo == '' || this.formdocumentos.cargo == null) {
                this.errordatos.push('El campo de cargo esta vacio');
            }
            if (this.formbuscardoc.formatram == 2) {
                if (this.formdocumentos.telefono == '' || this.formdocumentos.telefono == null) {
                    this.errordatos.push('El campo de estado esta vacio');
                }
                if (this.formdocumentos.docu_emailorigen == '' || this.formdocumentos.docu_emailorigen == null) {
                    this.errordatos.push('El campo de correo electrónico esta vacio');
                }
            }

            if (this.formdocumentos.tipodocumento == '' || this.formdocumentos.tipodocumento == null) {
                this.errordatos.push('El campo de tipo documento esta vacio');
            }
            if (this.formdocumentos.correlativodoc == 0 || this.formdocumentos.correlativodoc == '') {
                this.errordatos.push('El campo número de documento está vacio o en cero(0)');
            }
            if (this.formdocumentos.siglasdoucmento == '' || this.formdocumentos.siglasdoucmento == null) {
                this.errordatos.push('El campo de siglas del documento está vacio');
            }
            if (this.formdocumentos.folios == '' || this.formdocumentos.folios == null) {
                this.errordatos.push('El campo de folios del documento está vacio');
            }
            if (this.formdocumentos.asunto == '' || this.formdocumentos.asunto == null) {
                this.errordatos.push('El campo de asunto del documento está vacio');
            }
        },

        listadodocumento() {
            axios.get('/tipodocumento')
                .then(response => {
                    this.listadocumento = response.data.listadoc;
                    //this.pagination=response.data.paginacion
                })
        },
        fechasistema() {
            const hoy = new Date();
            // const year = hoy.getFullYear();
            // const mes = hoy.getMonth();
            // const dia = hoy.getDate();

            // var mesdo = mes < 10 ? "0" + mes : mes;
            // var diado = dia < 10 ? "0" + dia : dia;

            this.formdocumentos.fechatramite = hoy.toISOString().substring(0, 10); // year + '-' + mesdo + '-' + diado;
            //alert(this.formdocumentos.fechatramite)
        },

        ////////////////////////////////////////////////////////////////////////////////////////////

        capturaiddepe() {
            var url = '/listauserdepe/' + + this.formdocumentos.cod_unidad;
            axios.get(url)
                .then(response => {
                    this.listadouser = response.data.usuarios;
                    this.representantedestino = response.data.representantes;

                    this.formdocumentos.firmadestino = this.representantedestino[0].depe_representante;
                    this.formdocumentos.cargodestino = this.representantedestino[0].depe_cargo;
                    this.formdocumentos.unidadorganica = this.representantedestino[0].depe_nombre;
                    this.formdocumentos.textdepe = this.representantedestino[0].depe_sigla+'-'+this.representantedestino[0].depe_nombre;

                });

            if (parseInt(this.formdocumentos.cod_unidad) == this.formdocumentos.codigounidad) { //alert('son iguales');

                this.showdiv = true;

            } else {
                //    $("#divusers").hide(); 
                this.showdiv = false;
            }

        },
        buscaid()// busca id de la dependencia
        {
            this.formdocumentos.cod_unidad=this.formdocumentos.textdepe
            this.capturaiddepe()

        },
        detalleuser() {
            var url = '/detalleuserderivacion/' + this.formdocumentos.usuario;
            axios.get(url)
                .then(response => {
                    this.formdocumentos.firmadestino = response.data.detalleuser[0].adm_name + ' ' + response.data.detalleuser[0].adm_lastname;
                    this.formdocumentos.cargodestino = response.data.detalleuser[0].adm_cargo;
                    // this.formdocumentos.unidadorganica=response.data.detalleuser[0].depe_id;
                });
            //alert(url);
        },
        agregarreferenias() {
            // aqui hacemos la consulta para averiguar el doc. si existe, de lo contrario permanecera como sigue.
            //camporeferencia

            var textfere = null; // 
            var cpmrefe = this.formdocumentos.camporeferencia;

            var url = '/buscaregdoc/' + cpmrefe;

            axios
                .get(url)
                .then(response => {
                    textfere = response.data.resultado;
                    cpmrefe = response.data.codigo;

                    const thtml = {
                        coddoc: cpmrefe,
                        value: textfere
                    }
                    let jsonthtml = '{"coddoc":"' + cpmrefe + '","value":"' + textfere + '"}';

                    if (cpmrefe != '0') {
                        this.formdocumentos.array_referencias.push(thtml);
                        this.formdocumentos.json_referencias.push(jsonthtml);
                    }

                }).catch(error => {
                    cpmrefe = 0;
                    textfere = null;
                    const thtml = {
                        coddoc: cpmrefe,
                        value: textfere
                    }
                    let jsonthtml = '{"coddoc":"' + cpmrefe + '","value":"' + textfere + '"}';
                    this.formdocumentos.array_referencias.push(thtml);
                    this.formdocumentos.json_referencias.push(jsonthtml);
                })

            this.formdocumentos.camporeferencia = '';
        },
        eliminarefe(valor) {

            this.formdocumentos.array_referencias.splice(valor, 1);
            this.formdocumentos.json_referencias.splice(valor, 1);
        },
        agregarderivacion() {
            var vforma = 0; //this.formdocumentos.formaderivacion;
            const vcodigoofcina = this.formdocumentos.cod_unidad;
            const vnomoficina = this.formdocumentos.unidadorganica;
            const vdetalle = this.formdocumentos.detalle;
            const vcoduser = this.formdocumentos.usuario;
            const vnombreuser = this.formdocumentos.firmadestino;
            const vproveido = this.formdocumentos.proveido;
            var vtextforma = '';
            if (this.formdocumentos.formaderivacion == false) {
                vtextforma = 'ORIGINAL';
                vforma = 0;
            } else {
                vtextforma = 'COPIA';
                vforma = 1;
            }

            if (vcodigoofcina && vproveido) {
                let vhtml = {
                    'forma': vforma,
                    'textforma': vtextforma,
                    'codigo': vcodigoofcina,
                    'vnomoficina': vnomoficina,
                    'vdetalle': vdetalle,
                    'vcoduser': vcoduser,
                    'vnombreuser': vnombreuser,
                    'vproveido': vproveido
                };
                let Jsonvhtml = '{"forma":"' + vforma + '","vtextforma":"' + vtextforma + '","vcodigoofcina":"' + vcodigoofcina + '","vnomoficina":"' + vnomoficina + '","vdetalle":"' + vdetalle + '","vcoduser":"' + vcoduser + '","vnombreuser":"' + vnombreuser + '","vproveido":"' + vproveido + '"}';

                this.formdocumentos.derivaciones.push(vhtml);
                this.formdocumentos.json_derivaciones.push(Jsonvhtml);
                this.showtabladerivaciones = true;
            }

            this.formdocumentos.detalle = '';
            this.formdocumentos.usuario = '';
            //this.formdocumentos.firmadestino='';
            this.formdocumentos.proveido = '';

        },
        eliminaderivacion(idder) {
            this.formdocumentos.derivaciones.splice(idder, 1);
            this.formdocumentos.json_derivaciones.splice(idder, 1);
        },
        eliminaderivacionedit(idder) {
            this.formdocumentos.derivacionesedit.splice(idder, 1);
            if (this.formdocumentos.derivacionesedit.length == 1) {
                this.showtabladerivaciones = false;
            }

        },
        // carga de archivos word o pdf
        handleFilesUpload(event) {
            let uploadedFiles = event.target.files;

            /*
            Adds the uploaded file to the files array
            */
            for (var i = 0; i < uploadedFiles.length; i++) {

                this.files.push(uploadedFiles[i]);
                this.btn_sincronizar = false
                this.btn_cargarpdf = false
                this.btn_cargarword = false
            }
        },

        /*
            Removes a select file the user has uploaded
        */
        removeFile(key) {
            this.files.splice(key, 1);
            this.btn_sincronizar = true
        },
        carganexos(event) {

            let uploadedFiles = event.target.files;

            /*
            Adds the uploaded file to the files array
            */
            for (var i = 0; i < uploadedFiles.length; i++) {
                // const ext=this.getFileExtension3(uploadedFiles[i].name);
                // const tam=this.tamaniofile(uploadedFiles[i].size);
                // const archivofile={'extension':ext,'nombrefile':uploadedFiles[i].name,'tamanio':uploadedFiles[i].size,'tamanio_desc':tam};
                this.anexosfiles.push(uploadedFiles[i]);
                this.btn_anexo = false
            }
        },
        removeFileanexos(key, id) {

            let borrar = confirm('Si elimina el archivo se borrarra definitivamente de nuestros registros, ¿Está seguro de eliminar?')
            if (borrar == true) {

                var url = '/eliminarfile'
                const param = {
                    id: id
                }

                axios.post(url, param)
                    .then(res => {

                        this.anexosfiles.splice(key, 1);
                        this.btn_anexo = true
                        //finaliza el borrado del array
                        this.toast(res.data.msg, res.data.tipo);
                    })

            }
        },
        eliminar_principal(key, id) {

            // .valueOf....................

            let borrar = confirm('Si elimina el archivo se borrarra definitivamente de nuestros registros, ¿Está seguro de eliminar?')
            if (borrar == true) {

                var url = '/eliminarfile'
                const param = {
                    id: id
                }

                axios.post(url, param)
                    .then(res => {

                        this.docdigitales.splice(key, 1);
                        this.btn_cargarpdf = true
                        //finaliza el borrado del array
                        this.toast(res.data.msg, res.data.tipo);
                    })

            }

        },
        eliminar_anexos(key) {
            this.docdigitales.splice(key, 1);
            this.btn_anexo = true
        },

        getFileExtension3(filename) {
            return filename.slice((filename.lastIndexOf(".") - 1 >>> 0) + 2);
        },
        tamaniofile(tamanio) {
            var sizeByte = tamanio;
            if (sizeByte >= 1024) {
                var sizekiloBytes = parseFloat(sizeByte / 1024).toFixed(2);
                if (sizekiloBytes >= 1024) {
                    var sizeMegaBytes = parseFloat(sizekiloBytes / 1024).toFixed(2);
                    var tamanio = sizeMegaBytes + 'MB'
                } else {
                    var tamanio = sizekiloBytes + 'KB'
                }
            } else {
                var tamanio = sizeByte + 'Bytes'
            }

            return tamanio;

        },

        update_tramite() {
            this.verificacion();

            //let formData = new FormData();
            let formData = new FormData()
            /*
                Iterate over any file sent over appending the files
                to the form data.
            */
            // carga el pdf principal
            for (var i = 0; i < this.files.length; i++) {
                let file = this.files[i];
                formData.append('files[' + i + ']', file, file.name); // archivo del documento principal
                //alert(file.name);
            }
            // carga el pdf anexos
            for (var i = 0; i < this.anexosfiles.length; i++) {
                let file = this.anexosfiles[i];
                formData.append('anexosfiles[' + i + ']', file, file.name); // anexos del documento
                //alert(file.name);
            }

            // para derivaciones
            for (var i = 0; i < this.formdocumentos.json_derivaciones.length; i++) {
                let deriv = this.formdocumentos.json_derivaciones[i];
                formData.append('derivaciones[' + i + ']', deriv); // derivaciones
                //alert(file.name);
            }

            // para doucumento referencias
            for (var i = 0; i < this.formdocumentos.json_referencias.length; i++) {
                let refe = this.formdocumentos.json_referencias[i];
                formData.append('referencias[' + i + ']', refe); // anexos del documento
                //alert(file.name);
            }

            // VALORES PARA ACTUALIZAR TRAMITE

            formData.append("iddocumento", this.formbuscardoc.iddoc); // id de documento a modificar

            formData.append("fexpediente", this.formbuscardoc.idexpediente); // id de documento a modificar
            formData.append("ffrregistro", this.formdocumentos.frregistro); // forma de registro
            formData.append("fcodigounidad", this.formdocumentos.codigounidad); // captura de tabla admin a donde pertenece el usuario

            formData.append("fidusercreador", this.formdocumentos.idusercreador); // id del usuario quien realiza el tramite
            formData.append("ffirma", this.formdocumentos.firma); // del quien crea el documento
            formData.append("fcargo", this.formdocumentos.cargo); // cargo del que crea el documento

            formData.append("ftelefono", this.formdocumentos.telefono); // cargo del que crea el documento

            // formData.append("ffirmadestino", this.formdocumentos.firmadestino); //firma de destino
            // formData.append("fcargodestino", this.formdocumentos.cargodestino); // cargo destino

            formData.append("ffechatramite", this.formdocumentos.fechatramite); // fecha del tramite
            formData.append("ftipodocumento", this.formdocumentos.tipodocumento); //codigo del tipo de documento
            formData.append("fcorrelativodoc", this.formdocumentos.correlativodoc); // correlativo del numero de documento
            formData.append("fsiglasdoucmento", this.formdocumentos.siglasdoucmento); // siglas de documento 2022-GRH-GRPPAT/SGMTD

            formData.append("fformarecepcion", this.formdocumentos.formarecepcion); //1 directa
            formData.append("fprioridad", this.formdocumentos.prioridad); //1 normal
            formData.append("ffolios", this.formdocumentos.folios); // folios de doc
            formData.append("fasunto", this.formdocumentos.asunto); // asunto del tramite
            formData.append("femail", this.formdocumentos.docu_emailorigen); // email del tramitante
            formData.append("fdni", this.formdocumentos.dni); // email del tramitante
            formData.append("fruc", this.formdocumentos.ruc); // email del tramitante

            // FIN DE VALORES

            var url = '/actualizaciontramite';

            if (this.errordatos.length > 0) {
                this.toast('Algunos campos son obligatorios', 'error');
                $("#mensajeeeror").modal('show')
            } else {
                axios.post(url, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(response => {
                        // console.log(response.data);
                        this.$router.push({
                            path: '/Tramites/Enproceso'
                        });
                        this.toast('Fue actualizado su trámite exitosamente', 'success');
                        // this.tipostramite();
                        //location.reload();
                    })
                    .catch(function () {
                        // console.log('FAILURE!!');
                    });
            }

        },

        firmadigital(documento) {

            this.$refs.foo.initInvoker('W', documento)
        },

        firmado() {
            //this.buscarDocumentos()
        },

        verpdf() {
            this.mostrarpdf = true;
            this.mostrarposicionfrima = false;
        },
        ocultarpdf() {
            this.mostrarpdf = false;
            this.mostrarposicionfrima = true;
        },
        recortacadena(cadena) {
            if (cadena.length >= 80) {
                var adicional = '....';
            } else {
                var adicional = '';
            }
            let extraida = cadena.substring(0, 80);
            return extraida + adicional;
        }

    }
}
</script>

<style lang="css" scoped>
.form-group {
    margin-bottom: 0rem !important;
}

.el-select {
    width: 100% !important;

}

.elementsm {
    height: 30px !important;
    line-height: 30px !important;
    font-size: 0.7875rem !important;
}

.progress-xs {
    height: 7px !important;
}

.amayusculas {
    text-transform: uppercase;
}
</style>
