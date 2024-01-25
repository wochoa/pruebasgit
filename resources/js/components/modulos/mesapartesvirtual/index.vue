<template>
<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4 class="m-0"><strong>{{ $route.name }}</strong></h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <router-link :to="'/registro/seguimiento'" class="btn btn-sm btn-danger">Ver estado de mi trámite</router-link>
                        </li>
                        <!-- <li class="breadcrumb-item active">{{ $route.name }}</li> -->
                    </ol>
                </div><!-- /.col -->
            </div>
        </div>
    </div>
    <!-- /.content-header -->

    <!-- Main content -->

    <div class="content">
        <div class="container">

            <div class="row">

                <div class="col-12">
                    <div class="card card-primary card-outline card-outline-tabs">
                        <!-- <div class="card-header">
                            <h5>{{ $route.name }}</h5>
                        </div> -->

                        <div class="card-body" style="    background-color: #dddddd; background-image: url('/img/fondo.svg');">
                            <div class="row justify-content-center pt-3 pb-3">
                                <label class="">Elije la dependencia:</label>
                                <div class="col-sm-6">
                                    <!-- <select v-model="formpersona.id_dependencia" class="form-control form-control-sm">
                                        <option value="">Seleccione la dependencia</option>
                                        <option v-for="(dependencia, indexDepe) in dependencias" :key="indexDepe" :value="dependencia.iddependencia">
                                            {{ dependencia.depe_nombre }}
                                        </option>

                                    </select> -->
                                    <el-select v-model="formpersona.id_dependencia" filterable placeholder="Seleccione la dependencia" style="width: 100%;" size="small">
                                        <!-- <el-option label="Elije la dependencia:" value=""></el-option> -->
                                        <el-option v-for="(dependencia, indexDepe) in dependencias" :key="indexDepe" :label="dependencia.depe_nombre" :value="dependencia.iddependencia">
                                        </el-option>
                                    </el-select>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="timeline-steps">
                                        <div class="timeline-step">
                                            <div class="timeline-content" @click="volver">
                                                <div v-if="activostep==1" class="inner-circle"></div>
                                                <div v-if="activostep==2" class="inner-circle2"></div>
                                                <p class="h6 mt-3 mb-1" v-if="activostep==1" :class="'text-success fondoblancotext'"><b>DATOS DEL REMITENTE</b></p>
                                                <p class="h6 mt-3 mb-1" v-if="activostep==2" :class="'text-secondary fondoblancotext'"><b>DATOS DEL REMITENTE</b></p>

                                            </div>
                                        </div>
                                        <div class="timeline-step" @click="siguiente">
                                            <div class="timeline-content">
                                                <div v-if="activostep==2" class="inner-circle"></div>
                                                <div v-else class="inner-circle"></div>
                                                <!-- <p class="h6 mt-3 mb-1">2004</p> -->
                                                <p class="h6 mt-3 mb-1" v-if="activostep==2" :class="'text-success fondoblancotext'"><b>DATOS DEL DOCUMENTO</b></p>
                                                <p class="h6 mt-3 mb-1" v-else :class="'text-secondary fondoblancotext'"><b>DATOS DEL DOCUMENTO</b></p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <div class="card" v-show="vistapersonal">
                                <div class="card-header">
                                    <h5 class="modal-title">DATOS DEL REMITENTE</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <div class=" col-md-6">
                                            <label for="tipo">Tipo documento de identidad <span style="color:#FF0000">(*)</span></label>
                                            <select class="form-control form-control-sm" v-model="formpersona.tipo">
                                                <option value=1>DNI</option>
                                                <option value=0>RUC</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="Numero de documento">Numero de documento <span style="color:#FF0000">(*)</span></label>
                                            <input v-model="formpersona.numero" type="text" class="form-control form-control-sm" name="Numero de documento" placeholder="Numero de documento" @keypress.enter.prevent.stop="validar" />

                                        </div>
                                        <div class="col-md-2 pt-4" id="validoc">
                                            <button class="btn btn-primary btn-sm" v-if="formpersona.tipo == 1" @click="validar">Validar con RENIEC</button>

                                            <button class="btn btn-danger btn-sm" v-else @click="validar">Validar con SUNAT</button>

                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="detalle" class="col">Entidad <span style="color:#FF0000">(*)</span></label>

                                        <input id="detalle" ref="detalle" v-model="formpersona.docu_detalle" type="text" name="detalle" class="form-control form-control-sm text-uppercase" />

                                    </div>
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Firmante <span style="color:#FF0000">(*)</span></label>
                                                <input ref="firma" v-model="formpersona.docu_firma" type="email" name="firma" class="form-control form-control-sm text-uppercase" />
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Dirección <span style="color:#FF0000">(*)</span></label>

                                                <input ref="direccion" v-model="formpersona.docu_domic" type="text" name="direccion" class="form-control form-control-sm text-uppercase" />

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="control-label">Celular <span style="color:#FF0000">(*)</span></label>

                                                <input ref="celular" v-model="formpersona.docu_telef" type="text" class="form-control form-control-sm" name="celular" />

                                            </div>
                                        </div>

                                        <div :class="'col-md-6'">
                                            <div class="form-group">
                                                <label class="control-label">Cargo</label>

                                                <input ref="cargo" v-model="formpersona.docu_cargo" type="text" name="cargo" class="form-control form-control-sm text-uppercase" @change="docu_cargo = docu_cargo.totext-uppercase()" />

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group col-md-6">
                                            <label class="control-label">Corre electrónico
                                                <span style="color:#FF0000">(*)</span>
                                            </label>

                                            <input type="mail" name="Términos y Condiciones" v-model="formpersona.correo" class="form-control form-control-sm " />

                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="control-label">Términos y Condiciones
                                                <span style="color:#FF0000">(*)</span>
                                            </label>
                                            <div>
                                                <label class="control-label" style="font-weight:500;">
                                                    <input type="checkbox" v-model="formpersona.aceptotermino" name="Términos y Condiciones" /> Acepto que las
                                                    comunicaciones del Gobierno Regional Cusco sean enviadas a
                                                    la dirección de correo electrónico y celular que proporcione.</label>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="border-red">
                                        <div class="row">
                                            <div class="col-sm-8" style="color: red"></div>
                                            <!-- <div class="col-sm-8" v-html="message" style="color: red"></div> -->
                                            <div class="col-sm-2 text-danger">
                                                <a href="https://drive.google.com/file/d/1ZQhFQqkZudzit2zgqteSBKx2AqS3uwnr/view?usp=sharing" target="_blank">
                                                    <i class="fa-solid fa-file-pdf fa-1x"></i>Manual de usuario</a>
                                            </div>
                                            <button class="btn btn-primary btn-sm col-sm-2" type="button" @click="siguiente">
                                                <span class="icon icon-redo2 fs-18">Continuar <i class="fa-solid fa-circle-arrow-right"></i></span>
                                            </button>

                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="card" v-show="vitsadocumento">
                                <div class="card-header">
                                    <h5 class="modal-title">DATOS DEL DOCUMENTO</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Fecha Documento</label>
                                        <div class="col-sm-5">
                                            <input v-model="fromdocus.docu_fecha_doc" type="date" name="docu_fecha_doc" disabled="disabled" class="form-control form-control-sm"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="tipo" class="col-sm-2 col-form-label">Tipo Documento</label>
                                        <div class="col-sm-5">
                                            <select v-model="fromdocus.docu_idtipodocumento" class="form-control form-control-sm" aria-required="true" aria-invalid="false">
                                                <option v-for="item in tipodocumento" :value="item.idtdoc">{{ item.tdoc_descripcion }}</option>
                                                <!-- <option value="1">OFICIO</option>
                                                <option value="2">OFICIO MULTIPLE</option> -->
                                            </select>
                                        </div>
                                        <div class="col-sm-3">
                                            <p style="color: rgb(0, 102, 204);">*Puede modificar a otro tipo de documento de ser necesario</p>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="numero de documento" class="col-sm-2 col-form-label">Número y Siglas</label>
                                        <div class="col-sm-3">
                                            <input type="number" v-model="fromdocus.docu_numero_doc" placeholder="Ingrese número documento" class="form-control form-control-sm text-right">
                                        </div>
                                        <div class="col-sm-7">
                                            <input type="text" v-model="fromdocus.docu_siglas_doc" placeholder="Ingrese sigla" class="form-control form-control-sm text-uppercase">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="folios" class="col-sm-2 col-form-label">Folios</label>
                                        <div class="col-sm-3"><input type="number" v-model="fromdocus.docu_folios" placeholder="Ingrese el número de folios" class="form-control form-control-sm"></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="asunto" class="col-sm-2 col-form-label">Asunto</label>
                                        <div class="col-sm-10">
                                            <textarea v-model="fromdocus.docu_asunto" placeholder="Ingrese el asunto de su solicitud" class="form-control form-control-sm text-uppercase" aria-required="true" aria-invalid="false"></textarea>
                                        </div>
                                    </div>
                                    <div v-show="desactivabtnprincipal" class="form-group row" v-if="this.fromdocus.fileprincipal.length<1">
                                        <label for="fileInput" class="col-sm-2 col-form-label">Archivo a adjuntar</label>
                                        <div class="col-sm-2"><button type="button" class="btn btn-sm btn-success">
                                                Agregar archivo principal
                                                <input type="file" size="40" name="docu_archivo" accept=".pdf" style="position: absolute; z-index: 2; top: 0px; left: 0px; opacity: 0; background-color: transparent; color: transparent;" ref="files" @change="principal( $event )"></button>
                                        </div>
                                        <div class="col-sm-6">
                                            <label class="control-label">(Para el documento principal el formato es PDF)</label>
                                        </div>
                                    </div>
                                    <div v-show="desactivabtnprincipal" class="form-group row" v-if="this.fromdocus.fileanexos.length<4">
                                        <div class="col-sm-2"><label for="file_anexo">Anexos a adjuntar</label></div>
                                        <div class="col-sm-2"><button type="button" class="btn btn-sm btn-warning">
                                                Agregar anexos
                                                <input type="file" size="40" name="docu_archivo" accept=".pdf" multiple="multiple" style="position: absolute; z-index: 2; top: 0px; left: 0px; opacity: 0; background-color: transparent; color: transparent;" ref="anexos" @change="carganexos( $event )"></button>
                                        </div>
                                        <div class="col-sm-6"><label class="control-label">(Para los anexos el máximo de 4 archivos de formato PDF)</label></div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="asunto" class="col-sm-2 col-form-label"></label>
                                        <div class="col-sm-10">
                                            <b>NOTA:</b> Los archivos cargados entre principal y anexos no debe de superar los {{ tamaniofile(max_size) }}
                                        </div>
                                    </div>

                                    <!-- cuando ponemos los archivos para editar -->
                                    <div class="form-group  row justify-content-center mt-2 border" v-if="fromdocus.docu_archivo.length>0">
                                        <div class="col-7">
                                            <div v-for="(file, key) in fromdocus.docu_archivo" class="row border-top">

                                                <div class="col-sm-7" v-if="file.name=='pdf'">

                                                    <p class="text-primary"><i class="fa-regular fa-file-pdf"></i> {{ file.file_name }} <span class="badge float-right badge-light-info badge-pill">{{tamaniofile(file.file_size)}}</span></p>
                                                </div>
                                                <div class="col-sm-7" v-else>

                                                    <p class="text-primary"><i class="fa-regular fa-file"></i> {{ file.file_name }} <span class="badge float-right badge-light-info badge-pill">{{tamaniofile(file.file_size)}}</span></p>
                                                </div>
                                                <div class="col-sm-3 pt-1">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2 ">
                                                    <span class="badge badge-primary" v-if="file.file_principal==0">p {{ desactivap(file.file_size) }}</span>
                                                    <span class="badge badge-warning" v-else>A {{ desactivap(file.file_size) }}</span>
                                                    <span class="badge badge-light"> <a :href="'/mostrararchivo/'+file.id" target="_blank"><i class="fa fa-eye"></i></a> </span>
                                                    <span class="badge float-right badge-light-danger badge-pill" v-on:click="eliminarfile(key,file.id,file.file_principal )"><i class="fa-solid fa-trash-can"></i></span>
                                                </div>

                                            </div>

                                        </div>
                                        <!-- <div class="col-sm-3 float-right">
                                            <h5 class="text-center">Total</h5>
                                            <h2 class="text-center">{{ tamaniofile(uploading_size) }}</h2>
                                        </div> -->
                                    </div>
                                    <!-- mostrar los archivos cargados -->
                                    <div class="form-group  row justify-content-center mt-2 border" v-if="(fromdocus.fileprincipal.length||fromdocus.fileanexos.length)">

                                        <div class="col-7">
                                            <div v-for="(file, key) in fromdocus.fileprincipal" class="row border-top">

                                                <div class="col-sm-7" v-if="getFileExtension3(file.name)=='pdf'">

                                                    <p class="text-primary"><i class="fa-regular fa-file-pdf"></i> {{ file.name }} <span class="badge float-right badge-light-info badge-pill">{{tamaniofile(file.size)}}</span></p>
                                                </div>
                                                <div class="col-sm-7" v-else>

                                                    <p class="text-primary"><i class="fa-regular fa-file"></i> {{ file.name }} <span class="badge float-right badge-light-info badge-pill">{{tamaniofile(file.size)}}</span></p>
                                                </div>
                                                <div class="col-sm-3 pt-1">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2 ">
                                                    <span class="badge badge-primary">p</span>
                                                    <span class="badge float-right badge-light-danger badge-pill" v-on:click="removeFile( key,file.size )"><i class="fa-solid fa-trash-can"></i></span>
                                                </div>

                                            </div>
                                            <!-- para anexos -->
                                            <div v-for="(file_a, key) in fromdocus.fileanexos" class="row border-top">

                                                <div class="col-sm-7" v-if="getFileExtension3(file_a.name)=='pdf'">

                                                    <p class="text-primary"><i class="fa-regular fa-file-pdf"></i> {{ file_a.name }} <span class="badge float-right badge-light-info badge-pill">{{tamaniofile(file_a.size)}}</span></p>
                                                </div>
                                                <div class="col-sm-7" v-else>

                                                    <p class="text-primary"><i class="fa-regular fa-file"></i> {{ file_a.name }} <span class="badge float-right badge-light-info badge-pill">{{tamaniofile(file_a.size)}}</span></p>
                                                </div>
                                                <div class="col-sm-3 pt-1">
                                                    <div class="progress progress-xs">
                                                        <div class="progress-bar progress-bar-striped bg-warning progress-bar-animated" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-sm-2 ">
                                                    <span class="badge badge-warning">A</span>
                                                    <span class="badge float-right badge-light-danger badge-pill" v-on:click="removeFileanexos( key,file_a.size )"><i class="fa-solid fa-trash-can"></i></span>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-sm-3 float-right">
                                            <h5 class="text-center">Total</h5>
                                            <h2 class="text-center">{{ tamaniofile(uploading_size) }}</h2>
                                        </div>

                                    </div>

                                    <div class="form-group text-right">
                                        <button class="btn btn-success btn-sm" @click="guardar" v-if="formpersona.id" v-loading.fullscreen.lock="fullscreenLoading"><i class="fa fa-save"></i> Subsanar</button>
                                        <button class="btn btn-success btn-sm" @click="guardar" v-else v-loading.fullscreen.lock="fullscreenLoading"><i class="fa fa-save"></i> Guardar</button>
                                    </div>
                                </div>
                            </div>

                            <!-- /.card -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content -->
    </div>
    <!-- comunicado mesa de partes virtual  -->
    <div id="hoursOpened" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Mesa de partes virtual - Hora: {{ currentTime() }}</h4>
                </div>
                <div class="modal-body" v-html="textmpv">
                    <!-- <div class="form-group" v-html="message" style="color: red"></div> -->
                    <!-- <h4 class="text-danger">
                        NOTA:
                    </h4>
                    <ul>
                        <li class="text-justify">
                            La Plataforma Virtual de Atención a la Ciudadanía del Gobierno Regional de Cusco, está habilitada las veinticuatro (24) horas del día, durante los siete (7) días de la semana. Sin embargo, la recepción de los documentos se efectúa luego de la validación del cumplimiento de los requisitos establecidos en el TUO de la Ley N° 27444 y el Texto Único de Procedimientos Administrativos del Gobierno Regional de Cusco (en adelante, TUPA), de corresponder, de acuerdo con el horario de Mesa de Partes Presencial del Gobierno Regional de Cusco (lunes a viernes de 08:30 a.m. a 04:30 p.m.).

                        </li>
                        <li class="text-justify">
                            En cumplimiento de lo dispuesto en la Ley N° 29733, Ley de Protección de Datos Personales, desde el momento de su ingreso y/o utilización de la Plataforma Virtual de Atención a la Ciudadanía, los/las administrados/as dan expresamente su consentimiento para el tratamiento de los datos personales que por ellos sean facilitados o que se faciliten a través de la Plataforma Virtual de Atención a la Ciudadanía.
                        </li>
                    </ul> -->
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-danger" @click="cerrarmodal">Cerrar</button>
                    <!-- <a href="/registro/mpv/obs/3" target="_blank" class="btn btn-success btn-sm ">Ver estado de mi trámite</a> -->
                </div>
            </div>
        </div>
    </div>

    <!-- modal error remitente -->
    <div class="modal fade" id="mensajeeeror">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="callout callout-danger p-1" v-for="erro in errordatospersona">
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
    <!-- modal error documento -->
    <div class="modal fade" id="mensajeeerordoc">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="callout callout-danger p-1" v-for="erro in errordocumento">
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
    <!-- RESULTADO TRAMITE -->
    <div class="modal fade" id="resultramite">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Registro generado</h4>
                    <!-- <button type="button" class="close" data-dismiss="modal">X</button> -->
                </div>
                <div class="modal-body pb-0">
                    <div class="form-group">
                        <p>Estimado(a) Sr(a): <strong>{{ documento.docu_firma }}</strong>
                            , Se le comunica a usted que ha registrado su trámite,queda a la espera del responsable de Mesa de Partes Virtual para su atención.<br></p>
                        <p><b>Datos de trámite:</b></p>
                        <ul>
                            <li><strong>Dependencia Remitida: </strong> {{ nameDependencia() }}</li>
                            <li><strong>Asunto: </strong>{{ documento.docu_asunto }}</li>
                            <li><strong>Entidad: </strong>{{ documento.docu_detalle }}</li>
                            <li><strong>Firmante: </strong>{{ documento.docu_firma }}</li>
                            <li v-if="documento.docu_dni"><strong>DNI: </strong>{{ documento.docu_dni }}</li>
                            <li v-if="documento.docu_ruc"><strong>RUC: </strong>{{ documento.docu_ruc }}</li>
                            <li><strong>Teléfono: </strong>{{ documento.docu_telef }}</li>
                            <li><strong>eMail: </strong>{{ documento.docu_emailorigen }}</li>
                            <li><strong>Fecha envio: </strong>{{ moment(documento.created_at).format('DD-MM-YYYY  H:mm:ss') }}</li>

                        </ul>
                        <div class="alert alert-info text-center mb-1" role="alert">
                            <h4 class="alert-heading">
                                <strong>CÓDIGO: </strong>{{ documento.codigo}},
                                <b v-if="documento.docu_dni"> DNI:{{ documento.docu_dni }}</b>
                                <b v-if="documento.docu_ruc"> RUC:{{ documento.docu_ruc }}</b>,
                                <b>eMail: {{ documento.docu_emailorigen }}</b></h4>
                            (Datos necesarios para hecer el seguimiento)<br>
                            <a href="/registro/seguimiento" target="_blank" class="btn btn-sm btn-danger text-decoration-none">Puede hacer seguimiento en este enlace</a>

                        </div>

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
import axios from 'axios';
import moment from 'moment'
import {
    Loading
} from 'element-ui';

import Swal from 'sweetalert2';
window.$ = window.jQuery = require('jquery')

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
// import FormDocumento from '../mesapartesvirtual/FormDocumento.vue'
export default {
    name: 'mesapartesvirtual',

    data() {
        return {
            formpersona: {
                id: '',
                tipo: 1, //1=reniec, 0=sunat
                tipoadministrado: 'PERSONA NATURAL', //OTRAS EMPRESAS para buscar el ID en la tabla dependencia
                numero: '',
                docu_detalle: '',
                docu_firma: '',
                docu_domic: '',
                docu_telef: '',
                correo: '',
                docu_cargo: '',
                aceptotermino: false,
                id_dependencia: '',
                token: this.$route.params.token,

            },

            documento: { // para mostrar el el modal
                docu_firma: null,
                docu_asunto: null,
                docu_detalle: null,
                docu_dni: null,
                docu_ruc: null,
                docu_telef: null,
                docu_emailorigen: null,
                created_at: null,
                codigo: null
            },
            max_size: 41943040,
            uploading_size: 0,
            fromdocus: {
                docu_fecha_doc: '',
                docu_idtipodocumento: '',
                docu_numero_doc: '',
                docu_siglas_doc: '',
                docu_folios: '',
                docu_asunto: '',
                docu_archivo: [],
                fileprincipal: [],
                fileanexos: [],
            },

            dependencias: [],
            tipodocumento: [],

            errordatospersona: [],
            errordocumento: [],
            now: new Date(),
            activostep: 1, //para datos personales
            vitsadocumento: false,
            vistapersonal: true,
            star: false,
            desactivabtnprincipal: true,
            fullscreenLoading: false,
            textmpv: ''

        };
    },
    components: {
        // FormDocumento
    },
    created() {
        setInterval(() => {
            this.now = new Date()
        }, 1000)

        this.fromdocus.docu_fecha_doc = this.now.toISOString().substring(0, 10);
    },

    mounted() {
        this.abremodal();
        this.depenciamespartes();
        this.cargatipodocumento();

        // const params = {
        //     id: this.$route.params.id
        // }
        if (this.$route.params.id) {
            this.formpersona.id = this.$route.params.id
            this.iniciadatos(this.$route.params.id, this.$route.params.token)
            this.activostep = 2;
        }

    },

    methods: {
        toast(texto_anuncio, icono) {

            Toast.fire({
                // title:texto_titulo,
                title: '<small><strong>' + texto_anuncio + '</strong></small>',
                icon: icono,
                // text: texto_anuncio
            });
        },
        moment(a) {
            return moment(a)
        },
        abremodal() {
            var url = '/mensajempv'
            axios.get(url)
                .then(res => {
                    this.textmpv = res.data.data
                })

            $('#hoursOpened').modal('show')

        },
        iniciadatos(id, token) {
            var url = '/mesapartesbuscar'
            const param = {
                id: id,
                token: token
            }
            axios.post(url, param)
                .then(res => {
                    // console.log(res.data)
                    if (res.data.status == 1) {
                        this.formpersona = res.data.document[0]
                        // this.fromdocus=res.data.document[0]
                        this.formpersona.correo = res.data.document[0].docu_emailorigen
                        this.formpersona.aceptotermino = true
                        if (res.data.document[0].docu_dni) {
                            this.formpersona.tipo = 1;
                            this.formpersona.numero = res.data.document[0].docu_dni
                        } else {
                            this.formpersona.tipo = 0;
                            this.formpersona.numero = res.data.document[0].docu_ruc
                        }

                        this.fromdocus.docu_fecha_doc = res.data.document[0].docu_fecha_doc
                        this.fromdocus.docu_idtipodocumento = res.data.document[0].docu_idtipodocumento
                        this.fromdocus.docu_numero_doc = res.data.document[0].docu_numero_doc
                        this.fromdocus.docu_siglas_doc = res.data.document[0].docu_siglas_doc
                        this.fromdocus.docu_folios = res.data.document[0].docu_folios
                        this.fromdocus.docu_asunto = res.data.document[0].docu_asunto
                        this.fromdocus.docu_archivo = res.data.files
                        this.toast(res.data.msg, res.data.tipo);

                    } else {
                        this.toast(res.data.msg, res.data.tipo);
                        this.$router.push('/mesapartes')
                    }

                })
        },
        currentTime() {

            let hours = this.now.getHours(),
                minutes = ('00' + this.now.getMinutes()).slice(-2),
                seconds = ('00' + this.now.getSeconds()).slice(-2)
            let suffix = 'AM'
            if (hours >= 12) {
                suffix = 'PM'
                hours = hours - 12
            }
            if (hours === 0) {
                hours = 12
            }
            return hours + ':' + minutes + ':' + seconds + ' ' + suffix
        },
        principal(event) {
            let uploadedFiles = event.target.files[0];

            this.uploading_size = uploadedFiles.size

            this.fromdocus.fileprincipal.push(uploadedFiles);

        },
        removeFile(key, tam) {
            this.fromdocus.fileprincipal.splice(key, 1);
            this.uploading_size = this.uploading_size - tam
        },
        removeFileanexos(key, tam) {
            this.fromdocus.fileanexos.splice(key, 1);
            this.uploading_size = this.uploading_size - tam
        },
        carganexos(event) {

            let uploadedFiles = event.target.files;
            var sumaanexo = 0
            /*
            Adds the uploaded file to the files array
            */
            for (var i = 0; i < uploadedFiles.length; i++) {

                this.fromdocus.fileanexos.push(uploadedFiles[i]);
                sumaanexo = sumaanexo + uploadedFiles[i].size
                // this.btn_anexo = false
            }
            if (this.fromdocus.fileanexos.length > 4) { // cuando supera la cantidad de archivos
                alert('supera el numero de cantidad de archivos cargagados')
                this.fromdocus.fileanexos = []
                sumaanexo = 0
            } else { // cuando es permitido la cantidad
                this.uploading_size = this.uploading_size + sumaanexo
            }
        },

        cerrarmodal() {
            $('#hoursOpened').modal('hide')
        },
        validar() {
            if (this.formpersona.tipo == 1) { // cuando es con DNI
                this.formpersona.docu_detalle = 'PERSONA NATURAL'
                const params={'dni':this.formpersona.numero}
                axios.post('/reniec',params)
                    .then(res => {
                        // console.log(res.data)
                        this.formpersona.docu_firma = res.data.prenombres + ' ' + res.data.apPrimer + ' ' + res.data.apSegundo
                        this.formpersona.docu_domic = res.data.direccion
                        // this.formpersona.docu_domic=res.data.direccion
                        if (res.data.telefono) {
                            this.formpersona.docu_telef = res.data.telefono
                        }
                        if (res.data.correo) {
                            this.formpersona.correo = res.data.correo
                        }
                        if (res.data.error) {
                            this.toast(res.data.error, 'error');
                        }
                    })

            } else { // cuando es con RUC
                const params={'ruc':this.formpersona.numero}
                axios.post('/sunat',params)
                    .then(res => {
                        // console.log(res.data)
                        this.formpersona.docu_detalle = res.data.ddp_nombre
                        this.formpersona.docu_domic = res.data.ddp_nomvia + ' - ' + res.data.ddp_refer1
                        if (res.data.telefono) {
                            this.formpersona.docu_telef = res.data.telefono
                        }
                        if (res.data.correo) {
                            this.formpersona.correo = res.data.correo
                        }
                        if (res.data.error) {
                            this.toast(res.data.error, 'error');
                        }
                    })

            }
        },
        siguiente() {
            this.verifcapersona()
            if (this.errordatospersona.length > 0) {
                this.toast('Falta rellenar algunos datos', 'error');
                $("#mensajeeeror").modal('show')
            } else {
                this.vitsadocumento = true
                this.vistapersonal = false
                this.activostep = 2

                ///// ACTUALIZAMOS LOS DNI Y TELEFONO
                var url = '/updatetelenocorreo'
                axios.post(url, this.formpersona)
                    .then(res => {
                        // console.log(res.data)
                    })
            }

        },
        volver() {
            this.activostep = 1
            this.vitsadocumento = false
            this.vistapersonal = true
        },

        depenciamespartes() {
            var url = '/dependenciaMesaPartesVirtual'
            axios.get(url)
                .then(res => {
                    this.dependencias = res.data
                })
        },
        cargatipodocumento() {
            var url = '/documentompv'
            axios.get(url).then(response => {
                this.tipodocumento = response.data
            })
        },
        nameDependencia() {
            let sede = this.dependencias.filter(d => d.iddependencia === this.formpersona.id_dependencia)[0]
            if (sede !== undefined) {
                return sede.depe_nombre
            } else {
                return 'SEDE NO SELECCIONADO'
            }
        },
        guardar() {

            this.verifcapersona();
            this.validadocumento();
            if (this.errordatospersona.length > 0) {
                this.toast('Falta rellenar algunos datos del remitente', 'error');
                $("#mensajeeeror").modal('show')

            } else if (this.errordocumento.length > 0) {
                this.toast('Falta rellenar algunos datos del documento', 'error');
                $("#mensajeeerordoc").modal('show')

            } else {
                if (this.uploading_size <= this.max_size) {
                    //let formData = new FormData();
                    let formData = new FormData()

                    // carga el pdf principal
                    // formData.append('principal', this.fromdocus.fileprincipal);
                    for (var i = 0; i < this.fromdocus.fileprincipal.length; i++) {
                        let file = this.fromdocus.fileprincipal[i];
                        formData.append('principal[' + i + ']', file, file.name); // anexos del documento
                        //alert(file.name);
                    }

                    // carga el pdf anexos
                    for (var i = 0; i < this.fromdocus.fileanexos.length; i++) {
                        let file = this.fromdocus.fileanexos[i];
                        formData.append('anexos[' + i + ']', file, file.name); // anexos del documento
                        //alert(file.name);
                    }

                    // VALORES PARA CREAR NUEVO TRAMITE
                    if (this.formpersona.tipo == 1) {
                        formData.append("docu_dni", this.formpersona.numero);
                        formData.append("docu_ruc", '');
                        formData.append("tipoadministrado", 'PERSONA NATURAL');
                    } else {
                        formData.append("docu_ruc", this.formpersona.numero);
                        formData.append("docu_dni", '');
                        formData.append("tipoadministrado", 'OTRAS EMPRESAS');
                    }

                    //  $("#resultramite").modal('show')

                    formData.append("id", this.formpersona.id);
                    formData.append("docu_firma", this.formpersona.docu_firma);
                    formData.append("docu_domic", this.formpersona.docu_domic);
                    formData.append("docu_detalle", this.formpersona.docu_detalle);
                    formData.append("docu_cargo", this.formpersona.docu_cargo);
                    formData.append("docu_telef", this.formpersona.docu_telef);
                    formData.append("docu_emailorigen", this.formpersona.correo);

                    formData.append("docu_fecha_doc", this.fromdocus.docu_fecha_doc);
                    formData.append("docu_idtipodocumento", this.fromdocus.docu_idtipodocumento);
                    formData.append("docu_numero_doc", this.fromdocus.docu_numero_doc);
                    formData.append("docu_siglas_doc", this.fromdocus.docu_siglas_doc);
                    formData.append("docu_folios", this.fromdocus.docu_folios);
                    formData.append("docu_asunto", this.fromdocus.docu_asunto);
                    formData.append("id_dependencia", this.formpersona.id_dependencia);

                    // FIN DE VALORES
                    this.fullscreenLoading = true;
                    var url = '/nuevotramiteexterno'

                    axios.post(url, formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        })
                        .then(res => {
                            // console.log(res.data)
                            this.fullscreenLoading = false;
                            this.documento = res.data.documento

                            $('#resultramite').modal({
                                backdrop: 'static',
                                keyboard: false
                            })

                            // this.$router.push({
                            //     path: '/mesapartes'
                            // });
                            this.toast('Fue enviado su trámite exitosamente', 'success');
                            this.limpiartodo();
                            this.volver() // muestra la primera vista de datos personales

                        })

                } else {
                    this.toast('Los archivos cargados suoeran los: ' + this.tamaniofile(this.uploading_size), 'error');
                }

            }
        },
        verifcapersona() {
            this.errordatospersona = [];
            if (this.formpersona.id_dependencia == '') {
                this.errordatospersona.push('El campo dependencia no fue seleccionado');
            }
            if (this.formpersona.numero == '') {
                this.errordatospersona.push('El campo número de documento está vacio');
            }
            if (this.formpersona.docu_detalle == '') {
                this.errordatospersona.push('El campo de entidad está vacio');
            }

            if (this.formpersona.docu_firma == '') {
                this.errordatospersona.push('El campo de firmante está vacio');
            }
            if (this.formpersona.docu_domic == '') {
                this.errordatospersona.push('El campo dirección está vacio');
            }
            if (this.formpersona.docu_telef == '') {
                this.errordatospersona.push('El campo celular está vacio');
            }
            if (this.formpersona.correo == '') {
                this.errordatospersona.push('El campo correo está vacio');
            }
            if (this.formpersona.aceptotermino == false) {
                this.errordatospersona.push('El campo términos y condiciones está vacio');
            }

        },
        validadocumento() {
            this.errordocumento = [];
            if (this.formpersona.id_dependencia == '') {
                this.errordocumento.push('El campo dependencia no fue seleccionado');
            }
            if (this.fromdocus.docu_idtipodocumento == '') {
                this.errordocumento.push('El campo tipo de documento está vacio');
            }
            if (this.fromdocus.docu_numero_doc == '') {
                this.errordocumento.push('El campo número de doumento está vacio');
            }

            if (this.fromdocus.docu_siglas_doc == '') {
                this.errordocumento.push('El campo siglas del documento está vacio');
            }
            if (this.fromdocus.docu_folios == '') {
                this.errordocumento.push('El campo folios está vacio');
            }
            if (this.fromdocus.docu_asunto == '') {
                this.errordocumento.push('El campo asunto está vacio');
            }
            if (!this.fromdocus.fileprincipal.length) {
                this.errordocumento.push('No se adjuntó archivo principal');
            }

        },
        limpiartodo() {
            // this.formpersona.id_dependencia = ''
            this.formpersona.numero = ''
            this.formpersona.docu_detalle = ''
            this.formpersona.docu_firma = ''
            this.formpersona.docu_firma = ''
            this.formpersona.docu_domic = ''
            this.formpersona.docu_telef = ''
            this.formpersona.correo = ''
            this.formpersona.aceptotermino = false
            this.fromdocus.docu_idtipodocumento = ''
            this.fromdocus.docu_numero_doc = ''
            this.fromdocus.docu_siglas_doc = ''
            this.fromdocus.docu_folios = ''
            this.fromdocus.docu_asunto = ''
            this.fromdocus.fileprincipal = []
            this.fromdocus.fileanexos = []
        },
        tamaniofile(tamanio) {
            var sizeByte = tamanio;
            // this.uploading_size=this.uploading_size+sizeByte;

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
        getFileExtension3(filename) {
            return filename.slice((filename.lastIndexOf(".") - 1 >>> 0) + 2);
        },
        desactivap(size) {
            this.desactivabtnprincipal = false
            //    exit(0)
        },
        eliminarfile(key, id, tipo) {

            let borrar = confirm('Si elimina el archivo se borrarra definitivamente de nuestros registros, ¿Está seguro de eliminar?')
            if (borrar == true) {

                var url = '/eliminarfile'
                const param = {
                    id: id
                }

                axios.post(url, param)
                    .then(res => {
                        // console.log(res.data)
                        // borrado del array
                        this.fromdocus.docu_archivo.splice(key, 1);
                        if (this.fromdocus.docu_archivo.length > 0) {
                            this.desactivabtnprincipal = false
                        } else {
                            this.desactivabtnprincipal = true
                        }
                        //finaliza el borrado del array
                        this.toast(res.data.msg, res.data.tipo);
                    })

            }

        }
    },
};
</script>

<style lang="scss" scoped>
/* agregado para linea de tiempo :horizontal */
body {
    margin-top: 20px;
}

.timeline-steps {
    display: flex;
    justify-content: center;
    flex-wrap: wrap
}

.timeline-steps .timeline-step {
    align-items: center;
    display: flex;
    flex-direction: column;
    position: relative;
    margin: 1rem
}

@media (min-width:768px) {
    .timeline-steps .timeline-step:not(:last-child):after {
        content: "";
        display: block;
        border-top: .25rem dotted #b30505;
        width: 6.46rem;
        position: absolute;
        left: 9.5rem;
        top: .3125rem
    }

    .timeline-steps .timeline-step:not(:first-child):before {
        content: "";
        display: block;
        border-top: .25rem dotted #b30505;
        width: 6.8125rem;
        position: absolute;
        right: 9.5rem;
        top: .3125rem
    }
}

.timeline-steps .timeline-content {
    width: 15rem;
    text-align: center
}

.timeline-steps .timeline-content .inner-circle {
    border-radius: 1.5rem;
    height: 1rem;
    width: 1rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background-color: #b30505
}

.timeline-steps .timeline-content .inner-circle2 {
    border-radius: 1.5rem;
    height: 1rem;
    width: 1rem;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background-color: #b30505
}

.timeline-steps .timeline-content .inner-circle:before {
    content: "";
    background-color: #b30505;
    display: inline-block;
    height: 3rem;
    width: 3rem;
    min-width: 3rem;
    border-radius: 6.25rem;
    opacity: .5
}

.timeline-steps .timeline-content .inner-circle2:before {
    content: "";
    background-color: #035e0c;
    display: inline-block;
    height: 3rem;
    width: 3rem;
    min-width: 3rem;
    border-radius: 6.25rem;
    opacity: .5
}

.content-wrapper {
    background-color: #cbcbcb !important;
}
.fondoblancotext{
    background-color: #fdfdfd;
    border-radius: 4px;
}
</style>
