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

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-6 col-12">

                    <router-link :to="'/Tramites/Nuevotramite'" class="btn btn-primary btn-sm"><i class="fa-regular fa-file"></i> Crear nuevo documento</router-link>

                </div>

            </div>

            <!-- Modal enviar por interoperabilidad-->
            <!-- <div id="enviar" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Interoperabilidad con otras Instituciones</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Registro para pasar a despacho a otra Entidad del Estado</label>
                                <ul v-for="(docId, indexDoc) in docIndexes" :key="indexDoc">
                                    {{
                      ('00000000' + documentos.data[docId].iddocumento).slice(-8) +
                        ' - ' +
                        documentos.data[docId].tdoc_descripcion
                    }}
                                </ul>
                            </div>
                            <div class="form-group">
                                <label>Tipo entidad</label>
                                <select v-model="categoria_id" class="form-control" @change="buscarEntidad">
                                    <option :value="null">Seleccione</option>
                                    <option v-for="(categoria, indexCategoria) in categorias" :key="indexCategoria" :value="categoria.codcat">{{ categoria.descripcion }}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Entidad</label>
                                <select v-model="formEntidad.sident" class="form-control">
                                    <option :value="null">Seleccione</option>
                                    <option v-for="(entidad, indexEntidad) in entidades.filter( d => d.vrucent !== 0)" :key="indexEntidad" :value="entidad.sident">{{ entidad.vnoment }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" :disabled="saving || (formEntidad.sident===null)" @click="grabarEnvio">
                                Guardar
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div> -->
            <!-- Modal derivar-->
            <div id="derivar" class="modal fade" role="dialog">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-body" style="padding: 0;">
                            <docu-derivar :derivaciones="derivaciones" />
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" :disabled="saving || (derivaciones.length===0)" @click="grabarDerivaciones()">
                                <span v-if="!saving" class="glyphicon glyphicon-floppy-saved"> Guardar</span>
                                <span v-else class="glyphicon glyphicon-send"> Guardando</span>
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal" :disabled="saving">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal archivar-->
            <div id="archivar" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <!-- <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Archivar documento</h4> -->
                            <h5 class="modal-title">Archivar documento</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Registro a archivar</label>
                                <ul v-for="(docId, indexDoc) in docIndexes" :key="indexDoc">
                                    {{
                      ('00000000' + documentos.data[docId].iddocumento).slice(-8) +
                        ' - ' +
                        documentos.data[docId].tdoc_descripcion
                    }}
                                </ul>
                            </div>
                            <div class="form-group">
                                <label>Forma</label>
                                <select v-model="eleccionArchivador.forma" class="form-control">
                                    <option :value="null">Seleccione</option>
                                    <option value="0">Temporal</option>
                                    <option value="1">Definitivo</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Archivador</label>
                                <select v-model="eleccionArchivador.idarch" class="form-control">
                                    <option :value="null">Seleccione</option>
                                    <option v-for="(archivador, indexArchivador) in getArchivadores" :key="indexArchivador" :value="archivador.idarch">{{
                      archivador.arch_periodo + '/' + archivador.arch_nombre
                    }}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Acciones</label>
                                <textarea v-model="eleccionArchivador.acciones" cols="10" rows="3" class="form-control" @change="eleccionArchivador.acciones = eleccionArchivador.acciones.toUpperCase()"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal" @click="documentoAccion()">
                                Guardar
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal adjuntar-->
            <div id="adjuntar" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">

                            <h5 class="modal-title">Adjuntar documentos</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Registro a adjuntar</label>
                                <ul v-for="(docId, indexDocId) in docIndexes" :key="indexDocId">
                                    {{
                      ('00000000' + documentos.data[docId].iddocumento).slice(-8) +
                        ' - ' +
                        documentos.data[docId].tdoc_descripcion
                    }}
                                </ul>
                            </div>
                            <div class="form-group">
                                <label>Registro</label>
                                <input v-model="eleccionArchivador.iddocumento" type="text" class="form-control" />
                            </div>
                            <div class="form-group">
                                <label>Acciones</label>
                                <textarea v-model="eleccionArchivador.acciones" cols="10" rows="3" class="form-control" @change="eleccionArchivador.acciones = eleccionArchivador.acciones.toUpperCase()"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal" @click="documentoAccion()">
                                Guardar
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal observacion-->
            <div id="observacion" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">

                            <h5 class="modal-title">Observación</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Registro a observar</label>
                                <ul v-for="(docId, indexObservar) in docIndexes" :key="indexObservar">
                                    {{
                      ('00000000' + documentos.data[docId].iddocumento).slice(-8) +
                        ' - ' +
                        documentos.data[docId].tdoc_descripcion
                    }}
                                </ul>
                            </div>
                            <div class="form-group">
                                <label>Observación</label>
                                <textarea v-model="docObservar.oper_detalledestino" cols="10" rows="3" class="form-control" @change="docObservar.oper_detalledestino = docObservar.oper_detalledestino.toUpperCase()"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal" @click="generarObservacion()">
                                Guardar
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Modal Liberar Documento-->
            <div id="liberar" class="modal fade" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">

                            <h5 class="modal-title">Liberar documento</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Motivo</label>
                                <textarea v-model="docLiberar.oper_acciones" class="form-control" cols="10" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" data-dismiss="modal" @click="liberarDocumento()">
                                Guardar
                            </button>
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="card card-primary card-outline ">
                        <div class="card-header p-1">
                            Documentos en proceso

                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-2">
                                    <div class="group">
                                        <label class="text-sm">Registro</label>
                                        <input type="number" class="form-control form-control-sm" v-model="formData.iddocumento">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="group">
                                        <label class="text-sm">Documento del usuario</label>
                                        <select v-model="formData.idadmin" class="form-control form-control-sm" @change="buscarDocumentos()">
                                            <option :value="null">Todos</option>
                                            <option v-for="(usuario, indexUser) in usersoficinas" :key="indexUser" :value="usuario.id" v-if="usuario.id!=1">
                                                {{ usuario.adm_name }} {{ usuario.adm_lastname }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="group">
                                        <label class="text-sm">Estado documento</label>
                                        <select v-model="formData.oper_idtope" class="form-control form-control-sm" @change="buscarDocumentos()">
                                            <option :value="null">Todos</option>
                                            <option value="1">Pendientes</option>
                                            <option value="2">Procesados</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="group">
                                        <label class="text-sm">Tipo documento</label>
                                        <select v-model="formData.docu_digital" class="form-control form-control-sm" @change="buscarDocumentos()">
                                            <option :value="null">Todos</option>
                                            <option value="1">Tramite Electrónico</option>
                                            <option value="0">Tramite manual</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2"><label></label>
                                    <button type="button" class="btn btn-block btn-info btn-sm mt-1" @click.prevent="buscarDocumentos()"><i class="fa-solid fa-magnifying-glass"></i> Buscar</button>
                                </div>
                            </div>
                            <!-- <div class="row form-group mt-2">
                                <div class="demo-inline-spacing">
                                    <button type="button" class="btn btn-outline-primary btn-sm "><i class="far fa-edit"></i> Editar</button>
                                    <button type="button" class="btn btn-outline-primary btn-sm"><i class="fa-regular fa-paper-plane"></i> Derivar</button>
                                    <button type="button" class="btn btn-outline-primary btn-sm"><i class="fa-regular fa-folder-open"></i> Archivar</button>
                                    <button type="button" class="btn btn-danger btn-sm"><i class="fa-regular fa-trash-can"></i> Eliminar derivacion</button>
                                    <button type="button" class="btn btn-outline-primary btn-sm"><i class="fa-regular fa-square-plus"></i> Adjuntar</button>
                                    <button type="button" class="btn btn-info btn-sm"><i class="fa-regular fa-window-restore"></i> Responder</button>

                                </div>
                            </div> -->
                            <div class="row form-group mt-2">
                                <div class="col-8">
                                    <MenuDocuBuscar :userid="formData.idadmin" :doc-indexes="docIndexes" :documentos="documentos" @mostrar="mostrar" @editar="editar" @eliminarDerivacion="eliminarDerivacion" @responder="responder" />
                                </div>
                                <div class="col-4">
                                    <div class="float-right d-none d-sm-inline-block">
                                        <pagination :data="documentos" :limit="3" @pagination-change-page="buscarDocumentos" />
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-2">
                                <table class=" table table-bordered table-condensed table-hover">
                                    <thead class="bg-lightblue disabled color-palette pd-0">
                                        <tr class="info">
                                            <th style="width:7%">REGISTRO<br />EXPEDIENTE</th>
                                            <th style="width:15%">REGISTRO</th>
                                            <th style="width:40%">DOCUMENTO</th>
                                            <th style="width:10%">DESTINO</th>
                                            <th style="width:10%">ARCHIVO</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td v-if="documentos.data.length == 0" colspan="21" class="text-center">
                                                No hay documentos, pruebe cambiando los filtros
                                            </td>
                                        </tr>
                                        <tr v-for="(documento, index) in documentos.data" :key="index" :set="(dias = moment().diff(moment(documento.created_at), 'days'))" :class="operSelected.indexOf(documento.idoperacion) >= 0 ? 'danger': documento.depe_destino != null? 'success': 'blanco' " @click="selectArchivar(documento)">
                                            <td>
                                                <span :class="{
                                                            badge: true,
                                                            'badge-danger': dias > 20,
                                                            'badge-warning': dias > 10 && dias <= 20,
                                                            'badge-success': dias <= 10
                                                        }">{{ dias }} días</span><br />
                                                <small>
                                                    <strong>Reg.</strong>
                                                    <a href="#" @click.prevent.stop="buscarByDocumento({ iddocumento: documento.iddocumento, modal: true })">
                                                        {{ ' ' + ('00000000' + documento.iddocumento).slice(-8) }}</a><br />

                                                    <strong>Exp.</strong>{{ ' ' + ('00000000' + documento.docu_idexma).slice(-8) }}<br />
                                                    {{ documento.oper_idtope == 1 ? 'REGISTRADO' : 'DERIVADO' }}
                                                </small>
                                            </td>
                                            <td class="registro">
                                                <small>
                                                    <strong>Fecha:</strong>{{ moment(documento.created_at).format('DD-MM-YYYY  h:mm:ss') }}<br />
                                                    <strong>Forma:</strong>{{ documento.oper_forma == 1 ? 'COPIA' : 'ORIGINAL' }}<br />
                                                    <strong>Folios:</strong>{{ documento.docu_folios }}<br />
                                                    <strong>Proveido:</strong>{{ documento.proveido }}
                                                </small>
                                            </td>
                                            <td style="white-space:nowrap;width:1%;" class="documento">
                                                <small>

                                                    <div><strong>Doc:</strong>
                                                        {{ documento.tdoc_descripcion + ' ' }}{{ ('000000' + documento.docu_numero_doc).slice(-6)
                                                    }}{{ documento.docu_origen == 1 ? '-' + documento.docu_fecha_doc.substr(0, 4) : ''
                                                    }}{{ documento.docu_siglas_doc != null ? '-' + documento.docu_siglas_doc : '' }}
                                                    </div>

                                                    <div><strong>Firma:</strong>{{ documento.docu_firma }}</div>

                                                    <div><strong>Cargo:</strong>{{ documento.docu_cargo }}</div>

                                                    <div><strong>Asunto:</strong> {{ documento.docu_asunto }}</div>

                                                    <div><strong>Dependencia: </strong>
                                                        <!-- {{ getDependenciaNombre(documento.depe_origen) }}  -->
                                                        {{ $store.getters.Getnombredepe(documento.depe_origen)}}
                                                    </div>
                                                </small>
                                            </td>
                                            <td>
                                                <small>
                                                    <div v-if="documento.depe_destino != null">
                                                        <div>
                                                            <strong>Destino:</strong>
                                                            <!-- {{ getDependenciaNombre(documento.depe_destino) }} -->
                                                            {{ $store.getters.Getnombredepe(documento.depe_destino)}}
                                                            <br />
                                                        </div>
                                                        <div v-if="documento.oper_usuid_d != 0">
                                                            <strong>Para:</strong>
                                                            <!-- {{ getUsuariosActivoNombre(documento.oper_usuid_d) }} -->
                                                            {{ documento.nameuser_destino }} {{ documento.lastnameuser_destino }}

                                                            <br />
                                                        </div>
                                                        <div><strong>Acciones:</strong>{{ documento.oper_acciones }}</div>
                                                    </div>
                                                    <div v-if="documento.depe_destino == null && documento.oper_detalledestino != null">
                                                        <div>
                                                            <strong>Observacion:</strong>{{ documento.oper_detalledestino != null ?documento.oper_detalledestino : 'Ninguna' }}
                                                        </div>
                                                    </div>
                                                </small>
                                            </td>
                                            <td width="20%">
                                                <div v-if="documento.docu_archivo.length>0">
                                                    <span v-if="documento.docu_digital==0" class="bg-warning tipospan pl-1"><i class="fa-solid fa-lock"></i> Tramite Electrónico</span>
                                                    <span v-if="documento.docu_digital==1" class="bg-info tipospan pl-1"><i class="fa-solid fa-lock"></i> Doc. ingresado por MPV</span>
                                                    <div v-for="(archivo, indexArchivo) in documento.docu_archivo.filter(d => d.file_mostrar)" :key="indexArchivo">
                                                        <div class="float-left">
                                                            <button type="button" class="btn btn-sm btn-link doc-link" @click.stop="imprimirDocumentoPdf({id:archivo.id, id_documento:archivo.id_documento, file_tipo: archivo.file_tipo, file_name: archivo.file_name,tipo:1})">
                                                                <!-- <a :href="ruta+'/'+archivo.file_url" target="_blank"> -->
                                                                <small style="font-size: 13px;">
                                                                    <span style="color:blue;font-size:11px">{{ getFormatBytes(archivo.file_size) }}</span>
                                                                    <!-- <span v-if="archivo.file_principal != null" :class="
                                                                                archivo.file_principal
                                                                                    ? 'badge badge-danger'
                                                                                    : 'badge badge-warning'
                                                                                ">
                                                                        {{ archivo.file_principal?'P':'A' }}
                                                                    </span> -->
                                                                    <span v-if="archivo.file_principal==0" class="badge badge-danger">P</span>
                                                                    <span v-else class="badge badge-warning">A</span>

                                                                    <span :class="
                                                                            archivo.file_tipo.indexOf('image') === 0
                                                                            ? 'fa-solid fa-image'
                                                                            : 'fa-solid fa-file'
                                                                        "></span>
                                                                    {{ archivo.file_name }}
                                                                </small>
                                                                <!-- </a> -->
                                                            </button>
                                                        </div>
                                                        <div class="d-flex flex-column align-items-end pr-1">
                                                            <button v-if="archivo.file_tipo === 'application/pdf'" class="btn btn-xs btn-success mt-1" @click.stop="firmar({idfile:archivo.id, id_documento:archivo.id_documento,'ruta_archivo':archivo.file_url,'existearchivo':Existe})">
                                                                <span class="glyphicon glyphicon-pencil"></span> Firmar
                                                            </button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>

                            <div class="row form-group mt-2">
                                <div class="col-8">
                                    <MenuDocuBuscar :userid="formData.idadmin" :doc-indexes="docIndexes" :documentos="documentos" @mostrar="mostrar" @editar="editar" @eliminarDerivacion="eliminarDerivacion" @responder="responder" />
                                </div>
                                <div class="col-4">
                                    <div class="float-right d-none d-sm-inline-block">
                                        <pagination :data="documentos" :limit="3" @pagination-change-page="buscarDocumentos" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

    <!-- ........................... -->
    <Modalbusdocumento ref="test" />
    <!-- ...................... -->
    <docu-invoker ref="foo" :iframe="iframe" :route-invoker-get="routeInvokerGet" :route-invoker-post="routeInvokerPost" :ruta="ruta" @firmado="firmado" />
</div>
</template>

<script>
import moment from 'moment'
import LaravelVuePagination from 'laravel-vue-pagination'
import DocuInvoker from './DocuInvoker'
import Modalbusdocumento from './Modalresultado.vue'
import MenuDocuBuscar from './MenuDocuBuscar.vue'

import DocuDerivar from './DocuDerivar.vue'

import {
    mapGetters
} from 'vuex';
// import Vuex from 'vuex'

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

export default {
    props: ['ruta', 'usuario', 'routeInvokerGet', 'routeInvokerPost'],

    data() {
        return {
            formData: {
                iddocumento: null,
                idadmin: this.usuario.id,
                oper_idtope: null,
                docu_digital: null,
                page: null
            },
            documentos: {
                current_page: null,
                data: [],
                from: null,
                last_page: null,
                next_page_url: null,
                path: null,
                per_page: null,
                prev_page_url: null,
                to: null,
                total: null
            },
            eleccionArchivador: {
                forma: null,
                idarch: null,
                acciones: null,
                iddocumento: null,
                tipoDoc: null
            },
            docLiberar: {
                oper_detalledestino: 'Liberación de registro',
                oper_acciones: null
            },
            docObservar: {
                oper_detalledestino: null
            },
            operSelected: [],
            docIndexes: [],

            derivaciones: [],
            saving: false,
            // DATOS PARA REFIRMA INVOKER
            iframe: {
                src: null,
                loaded: false,
                type: null
            },
            // getUsuariosActivo: [],
            listadependencias: '',
            // listausuarios:[],
            deriradoausuario: '',
            datconsulta: [],

            // archivo existente para firmar
            ArchivoFirma: null, // retorno del patch de pdf cargado para ser firmado
            Existe: 0, // 0:no existe el archivo para la firma, 1: existe archiv para firma => activamos el boton para firmar

        }
    },
    components: {
        'Pagination': LaravelVuePagination,
        DocuInvoker,
        Modalbusdocumento,
        MenuDocuBuscar,
        DocuDerivar

    },
    computed: {
        ...mapGetters(['usersoficinas', 'getArchivadores']),
        // ...mapGetters(['getdepexCode'],2)

    },
    created() {

        // console.log()
        this.listadependencias = this.$store.state.alldependencias;
    },
    mounted() {
        this.buscarDocumentos();
        // this.datconsulta=this.$store.dispatch('GetdepeporID',2)
        // this.datconsulta=this.$store.getters.GetdepeporID[2]

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

        // ...Vuex.mapActions(['imprimirDocumentoPdf']),
        moment(a) {
            return moment(a)
        },

        buscarDocumentos(page = 1) {
            var url = '/tramite/documentoenproceso?page=' + page
            // this.$validator.validate().then(result => {
            //     if (result) {
            //         this.formData.page = page
            axios.get(url, {
                params: this.formData
            }).then(response => {
                this.documentos = response.data
                this.operSelected = []
                this.docIndexes = []
            })
            //     } else {
            //         console.log('incompleto')
            //     }
            // })
        },
        selectArchivar(documento) {
            if (this.operSelected.indexOf(documento.idoperacion) === -1 && this.docIndexes.indexOf(this.documentos.data.indexOf(documento)) === -1) {
                this.operSelected.push(documento.idoperacion)
                this.docIndexes.push(this.documentos.data.indexOf(documento))
            } else {
                this.operSelected.splice(this.operSelected.indexOf(documento.idoperacion), 1)
                this.docIndexes.splice(this.docIndexes.indexOf(this.documentos.data.indexOf(documento)), 1)
            }
        },

        getFormatBytes(bytes) {
            if (bytes != null) {
                if (bytes === 0) return '0 Bytes';
                const decimals = 2
                const k = 1024;
                const dm = decimals < 0 ? 0 : decimals;
                const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

                const i = Math.floor(Math.log(bytes) / Math.log(k));

                return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
            } else {
                return ''
            }

        },

        mostrar(accion) {
            if (this.docIndexes.length === 0) {
                // toastr.warning('debe de seleccionar al menos un documento!!')
                this.toast('Debe de seleccionar al menos un documento!!', 'warning');
            } else {
                switch (accion) {
                    case 'enviar': {
                        if (this.verificarDerivado()) {
                            // toastr.warning('no puede enviar un documento que se encuentre derivado!!')
                            this.toast('No puede enviar un documento que se encuentre derivado!!', 'warning');
                        } else {
                            $('#enviar').modal()
                            axios.get(this.routeCuo).then(response => {
                                if (response.data.status) {
                                    this.cuo = response.data.data.cou
                                } else {
                                    alert('CUO no encontrado')
                                }
                            })
                        }
                    }
                    break
                case 'derivar': {
                    var a = this.docIndexes.filter(id => this.documentos.data[id].oper_forma === 1)
                    // this.llenarDerivarSoloCopia(a.length > 0)
                    console.log(a.length)
                    this.derivaciones = []
                    $('#derivar').modal({
                        backdrop: 'static',
                        keyboard: false
                    })
                }
                break
                case 'archivar': {
                    if (this.verificarDerivado()) {
                        // toastr.warning('no puede archivar un documento que se encuentre derivado!!')
                        this.toast('No puede archivar un documento que se encuentre derivado!!', 'warning');
                    } else {
                        $('#archivar').modal()
                    }
                }
                break
                case 'adjuntar': {
                    if (this.verificarDerivado()) {
                        // toastr.warning('no puede adjuntar un documento que se encuentre derivado!!')
                        this.toast('No puede adjuntar un documento que se encuentre derivado!!', 'warning');
                    } else {
                        $('#adjuntar').modal()
                    }
                }
                break
                case 'liberar': {
                    $('#liberar').modal()
                }
                break
                case 'observacion': {
                    $('#observacion').modal()
                }
                break
                }
            }
        },

        verificarDerivado() {
            var r = false
            for (var i = 0; i < this.docIndexes.length; i++) {
                if (this.documentos.data[this.docIndexes[i]].depe_destino != null) {
                    r = true
                    break
                }
            }
            return r
        },

        eliminarDerivacion() {
            var url = '/documento/eliminarDerivacion'
            if (confirm('Esta seguro de eliminar la derivación?')) {
                const params = {
                    devolver: this.operSelected
                }
                axios.post(url, params).then(response => {
                    if (response.data.status) {
                        // toastr.success(response.data.msg)
                        this.toast(response.data.msg, 'success');
                        this.operSelected = []
                        this.docIndexes = []
                        this.buscarDocumentos()
                    }
                })
            }
        },
        grabarDerivaciones() {
            const params = {
                operSelected: this.operSelected,
                derivaciones: this.derivaciones
            }
            if (!this.saving) {
                var url='/documento/documentoDerivar'
                this.saving = true

                axios.post(url, params)
                    .then(response => {
                        if (response.data.status) {
                            toastr.success(response.data.msg)
                            this.buscarDocumentos()
                            $('#derivar').modal('hide')
                            this.saving = false
                        }
                    })
                    .catch(error => {
                        console.log('Ocurrio un error guardar la derivacion, verifique su conexion a internet e intentelo nuevamente')
                        this.saving = false
                        $('#derivar').modal('hide')
                        this.buscarDocumentos()
                    })
            }
        },
        liberarDocumento() {
            if (confirm('Esta seguro de liberar el documento')) {
                const params = {
                    idOperacion: this.operSelected,
                    datoOperacion: this.docLiberar
                }
                axios.post(this.routeLiberarDocumento, params).then(response => {
                    if (response.data.status) {
                        toastr.success(response.data.msg)
                        this.operSelected = []
                        this.docIndexes = []
                        this.buscarDocumentos()
                    }
                })
            }
        },

        generarObservacion() {
            var url = '/documento/generarObservacion'
            if (confirm('Esta seguro de agregar una observación')) {
                const params = {
                    idOperacion: this.operSelected,
                    datoOperacion: this.docObservar
                }
                axios.post(url, params).then(response => {
                    if (response.data.status) {
                        // toastr.success(response.data.msg)
                        this.toast(response.data.msg, 'success');
                        this.operSelected = []
                        this.docIndexes = []
                        this.docObservar.oper_detalledestino = null
                        this.buscarDocumentos()
                    }
                })
            }
        },
        responder() {

            if (this.verificarDerivado()) {
                toastr.warning('no puede responder un documento que se encuentre derivado!!')
            } else {
                if (this.docIndexes.length > 0) {
                    this.$router.push({
                        name: 'Responder documento',
                        params: {
                            idrecepcion: this.documentos.data[this.docIndexes[0]].iddocumento,
                            operaciones: this.operSelected
                        }
                    })
                }
            }
        },

        editar() {
            if (this.docIndexes.length === 1) {
                if (this.documentos.data[this.docIndexes[0]].docu_doc_generado == null) {
                    this.$router.push({
                        name: 'Editar trámite',
                        params: {
                            doc: this.documentos.data[this.docIndexes[0]].iddocumento
                        }
                    })
                } else {
                    this.$router.push({
                        name: 'DocuGeneradoEdit2',
                        params: {
                            id: this.documentos.data[this.docIndexes[0]].docu_doc_generado
                        }
                    })
                }
            }
        },
        documentoAccion() {
            const params = {
                idDocumento: this.operSelected,
                datoDocumento: this.eleccionArchivador
            }
            if (this.eleccionArchivador.iddocumento == null) {
                if (this.eleccionArchivador.idarch != null || this.eleccionArchivador.forma != null) {
                    axios.post('/documento/documentoArchivar', params).then(response => {
                        this.operSelected = []
                        this.docIndexes = []
                        this.buscarDocumentos()
                        this.toast('Se ha archivo correctamente!!', 'success');
                    })
                } else {
                    alert('seleccione un archivador y la forma de archivamiento')
                }
            } else {
                if (this.eleccionArchivador.iddocumento > 0) {
                    axios.post('/documento/documentoAdjuntar', params).then(response => {
                        this.operSelected = []
                        this.docIndexes = []
                        this.buscarDocumentos()
                        this.toast('Se ha adjuntado el(los) archivo(s) correctamente!!', 'success');
                    })
                } else {
                    alert('Digite bien el registro')
                }
            }
        },

        firmar(documento) {

            this.$refs.foo.initInvoker('W', documento)
        },
        firmado() {
            this.buscarDocumentos();
        },
        buscarByDocumento(idocumentomodal) // abre modal
        {
            // this.datomodal=idocumentomodal
            this.$refs.test.buscardocumento(idocumentomodal)

        },
        imprimirDocumentoPdf(data) {
            this.$refs.test.imprimirDocumentoPdf(data)
        }

    }
}
</script>

<style lang="css" scoped>
.success {
    background-color: #dff0d8;
    color: black;
}

/* .danger {
    background-color: #f2dede;
    color: black;
} */

.blanco {
    color: black;
    background-color: #fff;
}

.dark-mode .danger {
    background-color: #af7b7b;
    color: black;
}

.dark-mode .danger:hover {
    background-color: #af7b7b;
    color: black;
}

.dark-mode .blanco {
    color: #a7a7a7;
    background-color: #343a40;
}

.dark-mode .blanco:hover {
    color: #a7a7a7;
    background-color: #2f3235;
    border-color: #6c757d;
}

.table tbody tr td,
.table thead tr th {
    font-size: 12px;
    font-family: Tahoma;
    vertical-align: middle;
    padding: 2px 0px;
}

td {
    border: 1px solid rgba(0, 0, 0, 0.071);
}

.badge {
    font-size: 12px !important;
}

.documento strong {
    width: 70px;
    display: inline-block;
}

.registro strong {
    width: 60px;
    display: inline-block;
}

.doc-link {
    width: 200px;
    text-overflow: ellipsis;
    text-align: left;
    white-space: nowrap;
    overflow: hidden;
    margin-bottom: 0;
}

.tipospan {
    font-size: 11px !important;
    border-radius: 5px;
    padding-left: 1px;
    padding-right: 1px;
}

.badge {
    font-size: 11px !important;
    font-weight: 300 !important;
}
</style>
