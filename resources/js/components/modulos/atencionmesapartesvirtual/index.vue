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
                <div class="col-sm-6">
                    <ul class="nav nav-tabs" id="custom-content-above-tab" role="tablist">

                        <li class="nav-item">
                            <router-link :to="'/Tramites/virtual'" class="nav-link active" id="index" data-toggle="pill" aria-controls="custom-content-above-home" aria-selected="true">
                                Explorar Registros ingresados por MPV
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="'/Tramites/virtual-derivados'" class="nav-link" id="derivados" data-toggle="pill" aria-controls="custom-content-above-home" aria-selected="false">
                                Registros Derivados a Unidad Orgánica
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="'/Tramites/virtual-reporte'" class="nav-link" id="derivados" data-toggle="pill" aria-controls="custom-content-above-home" aria-selected="false">
                                Reportes MPV
                            </router-link>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="row justify-content-center mt-2">
                <div class="col-12 ">
                    <div class="card card-primary">
                        <div class="card-header">SOLICITUDES DE MESA DE PARTES VIRTUAL</div>
                        <div class="card-body">
                            <form @submit.prevent="buscarRegistro">
                                <div class="row form-group" style="width: 100%; margin-left: 0px;">
                                    <div class="col-sm-4"><label></label>
                                        <input type="text" ref="registro" v-model="filtro.id" name="registro" placeholder="Nombre, DNI, RUC" class="form-control"></div>
                                    <div class="col-sm-3">
                                        <label>Estado registro</label>
                                        <select class="form-control" v-model="filtro.docu_estado" @change="buscarRegistro">
                                            <option :value="null">Todos</option>
                                            <option value="0">Registrados</option>
                                            <option value="3">Subsanados</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2"><br>
                                        <button type="submit" class="btn btn-primary">
                                            <span class="glyphicon glyphicon-search"></span> Buscar
                                        </button>
                                    </div>
                                    <div class="col-sm-3"><a href="https://drive.google.com/file/d/1DDT_b2liEYEvcp_ceUPsqsm5hqnxZTbs/view?usp=sharing" target="_blank">
                                            <i class="fa fa-file"></i>
                                            Manual de administrador MPV</a></div>
                                </div>
                            </form>
                            <!-- Modal derivar-->
                            <div id="derivar" class="modal fade" role="dialog">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-body" style="padding: 0;">
                                            <DocuDerivar :derivaciones="derivaciones" />
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" @click="grabarDerivaciones()" v-loading.fullscreen.lock="fullscreenLoading">
                                                <!-- <span v-if="!saving" class="glyphicon glyphicon-floppy-saved"> Guardar</span>
                                                <span v-else class="glyphicon glyphicon-send"> Guardando</span> -->
                                                Guardar derviaciones
                                            </button>
                                            <!-- <button type="button" class="btn btn-default" data-dismiss="modal" :disabled="saving">Cerrar</button> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal editar-->
                            <div id="editar" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Editar Registro</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>

                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Registro a Editar</label>
                                                <ul v-for="(docId, indexDoc) in docIndexes" :key="indexDoc">
                                                    {{
                        ('00000000' + documentos.data[docId].id).slice(-8) +
                          ' - ' +
                          documentos.data[docId].docu_asunto
                      }}
                                                </ul>
                                            </div>
                                            <div class="form-group">
                                                <label>Número</label>
                                                <input v-model="formRegistro.docu_numero_doc" type="number" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label>Sigla</label>
                                                <input v-model="formRegistro.docu_siglas_doc" type="text" class="form-control" @change="formRegistro.docu_siglas_doc = formRegistro.docu_siglas_doc.toUpperCase()" />
                                            </div>
                                            <div class="form-group">
                                                <label>Folios</label>
                                                <input v-model="formRegistro.docu_folios" type="number" class="form-control" />
                                            </div>
                                            <div class="form-group">
                                                <label>Asunto</label>
                                                <input v-model="formRegistro.docu_asunto" type="text" cols="10" rows="3" class="form-control" @change="formRegistro.docu_asunto = formRegistro.docu_asunto.toUpperCase()" />
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal" @click="editar">
                                                Guardar
                                            </button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal archivar-->
                            <div id="archivar" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Enviar observación al solicitante</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>

                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Registro a observar</label>
                                                <ul v-for="(docId, indexDoc) in docIndexes" :key="indexDoc">
                                                    {{
                                                        ('00000000' + documentos.data[docId].id).slice(-8) +
                                                        ' - ' +
                                                        documentos.data[docId].docu_asunto
                                                    }}
                                                </ul>
                                            </div>
                                            <div class="form-group">
                                                <label>Observaciones</label>
                                                <textarea v-model="eleccionArchivador.acciones" cols="10" rows="3" class="form-control"></textarea>
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
                            <!-- Modal transferir-->
                            <div id="transferir" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Transferir Registro</h4>
                                            <button type="button" class="close" data-dismiss="modal">&times;</button>

                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label>Registro a Transferir</label>
                                                <ul v-for="(docId, indexDoc) in docIndexes" :key="indexDoc">
                                                    {{
                        ('00000000' + documentos.data[docId].id).slice(-8) +
                          ' - ' +
                          documentos.data[docId].docu_asunto
                      }}
                                                </ul>
                                            </div>
                                            <div class="form-group">
                                                <label>Dependencias</label>
                                                <select ref="dependencia" v-model="id_dependencia" :class="'col-sm-12'" class="form-control" name="dependencia">
                                                    <option v-for="(dependencia, indexDepe) in getSedes" :key="indexDepe" :value="dependencia.iddependencia">
                                                        {{ dependencia.depe_nombre }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal" @click="transferir">
                                                Guardar
                                            </button>
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group" style="width: 100%;margin-left: -0px;">
                                <div class="col-sm-12">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <p>
                                            <button class="btn btn-sm btn-outline-primary" :disabled="!(docIndexes.length === 1)" @click="mostrar('editar')">
                                                Editar
                                            </button>
                                            <button class="btn btn-sm btn-outline-primary" :disabled="!(docIndexes.length > 0)" @click="mostrar('derivar')">
                                                Derivar
                                            </button>
                                            <button class="btn btn-sm btn-danger" :disabled="!(docIndexes.length > 0)" @click="mostrar('archivar')">
                                                Enviar observaciones al solicitante
                                            </button>
                                            <button class="btn btn-sm btn-outline-primary" :disabled="!(docIndexes.length > 0)" @click="mostrar('transferir')">
                                                Transferir
                                            </button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="box">
                                <div class="box-body">
                                    <pagination :data="documentos" :limit="3" @pagination-change-page="buscarRegistro" />
                                    <table class=" table table-bordered table-condensed table-hover ">
                                        <thead class="bg-lightblue disabled color-palette pd-0">
                                            <tr class="info">
                                                <th>REGISTRO</th>
                                                <th>FECHA</th>
                                                <th>DOCUMENTO</th>
                                                <th>REMITENTE</th>
                                                <th>ARCHIVO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td v-if="documentos.data.length == 0" colspan="21" class="text-center">
                                                    No hay documentos, pruebe cambiando los filtros
                                                </td>
                                            </tr>
                                            <tr v-for="(documento, index) in documentos.data" :key="index" :set="(dias = moment().diff(moment(documento.created_at), 'days'))" :class="{'danger':operSelected.indexOf(documento.id) >= 0, 'success':documento.docu_estado===1}" @click="selectArchivar(documento)">
                                                <td>
                                                    <span :class="{
                          badge: true,
                          'badge-danger': dias > 20,
                          'badge-warning': dias > 10 && dias <= 20,
                          'badge-success': dias <= 10
                        }">{{ dias }} días</span><br />
                                                    <strong>Reg.</strong>
                                                    {{ ' ' + ('000000' + documento.id).slice(-6) }}
                                                    <span :class="
                          documento.docu_estado === 0
                            ? 'badge badge-info'
                            : 'badge badge-warning'
                        ">
                                                        {{ documento.docu_estado === 0?'Registrado':'Subsanado' }}
                                                    </span>
                                                </td>
                                                <td class="registro">
                                                    <strong>Fecha:</strong>{{ moment(documento.created_at).format('DD-MM-YYYY  H:mm:ss') }}<br />
                                                    <strong>Folios:</strong>{{ documento.docu_folios }}
                                                </td>
                                                <td class="documento">
                                                    <strong>Doc:</strong>

                                                    {{ documento.tipo_documento.tdoc_descripcion+' ' }}
                                                    {{ documento.docu_numero_doc != null?(' '+'000000' +documento.docu_numero_doc).slice(-6):'' }}
                                                    {{ '-'+documento.docu_fecha_doc.substr(0, 4)}}{{ documento.docu_siglas_doc != null ? '-' + documento.docu_siglas_doc : '' }}<br />

                                                    <strong>Entidad:</strong>
                                                    {{ documento.docu_detalle }}<br />
                                                    <strong>Firma:</strong>
                                                    {{ documento.docu_firma }}<br />
                                                    <strong>Cargo:</strong>
                                                    {{ documento.docu_cargo }}<br />
                                                    <strong>Asunto:</strong>
                                                    {{ documento.docu_asunto }}
                                                </td>
                                                <td>
                                                    <div>
                                                        <strong>DNI:</strong>{{ documento.docu_dni }}<br />
                                                    </div>
                                                    <div>
                                                        <strong>RUC:</strong>{{ documento.docu_ruc }}<br />
                                                    </div>
                                                    <div><strong>Celular:</strong>{{ documento.docu_telef }}</div>
                                                    <div><strong>eMail:</strong>{{ documento.docu_emailorigen }}</div>
                                                </td>
                                                <td>

                                                    <div v-if="documento.docu_archivo.length>0">
                                                        <div v-for="(archivo, indexArchivo) in documento.docu_archivo.filter(d => d.file_mostrar)" :key="indexArchivo">
                                                            <button type="button" class="btn btn-xs btn-link doc-link" @click.stop="imprimirDocumentoPdf({id:archivo.id, id_documento_externo:archivo.id_documento_externo, file_tipo: archivo.file_tipo, file_name: archivo.file_name, tipo:2})">
                                                                <span style="color:blue;font-size:80%">{{ getFormatBytes(archivo.file_size) }}</span>
                                                                <span v-if="archivo.file_principal != null" :class="archivo.file_principal==0? 'badge badge-danger': 'badge badge-warning'">
                                                                    {{ archivo.file_principal==0?'P':'A' }}
                                                                </span>
                                                                <span :class="
                                                                                            archivo.file_tipo.indexOf('image') === 0
                                                                                                ? 'fa-solid fa-image'
                                                                                                : 'fa-solid fa-file'
                                                                                            "></span>
                                                                {{ archivo.file_name }}
                                                            </button>
                                                        </div>
                                                    </div>

                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <pagination :data="documentos" :limit="3" @pagination-change-page="buscarRegistro" />
                                </div>
                            </div>
                            <div class="row form-group" style="width: 100%;margin-left: -0px;">
                                <div class="col-sm-12">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <p>
                                            <button class="btn btn-sm btn-outline-primary" :disabled="!(docIndexes.length === 1)" @click="mostrar('editar')">
                                                Editar
                                            </button>
                                            <button class="btn btn-sm btn-outline-primary" :disabled="!(docIndexes.length > 0)" @click="mostrar('derivar')">
                                                Derivar
                                            </button>
                                            <button class="btn btn-sm btn-danger" :disabled="!(docIndexes.length > 0)" @click="mostrar('archivar')">
                                                Enviar observaciones al solicitante
                                            </button>
                                            <button class="btn btn-sm btn-outline-primary" :disabled="!(docIndexes.length > 0)" @click="mostrar('transferir')">
                                                Transferir
                                            </button>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    <Modalbusdocumento ref="test" />
</div>
</template>

<script>
import LaravelVuePagination from 'laravel-vue-pagination';
import Vuex from 'vuex'
import Modalbusdocumento from '../tramites/Modalresultado.vue'
import DocuDerivar from '../tramites/DocuDerivar.vue'
import moment from 'moment'

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

    data() {
        return {
            filtro: {
                id: null,
                docu_estado: null,
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
            formRegistro: {
                id: null,
                docu_numero_doc: null,
                docu_siglas_doc: null,
                docu_folios: null,
                docu_asunto: null
            },
            eleccionArchivador: {
                forma: 1,
                idarch: null, //colocar un archivador por default
                acciones: null,
                iddocumento: null,
                tipoDoc: null
            },
            id_dependencia: null,
            derivaciones: [],
            docIndexes: [],
            operSelected: [],
            saving: false,
            fullscreenLoading: false

        }
    },
    components: {
        'Pagination': LaravelVuePagination,
        Modalbusdocumento,
        DocuDerivar
    },
    mounted() {
        this.buscarRegistro(1)
        // this.obtenerRutas(this.routes)
        // this.obtenerJsonAll()
    },
    computed: {
        ...Vuex.mapGetters(['getSedes'])
    },

    created() {

    },
    methods: {

        moment(a) {
            return moment(a)
        },
        toast(texto_anuncio, icono) {

            Toast.fire({
                // title:texto_titulo,
                title: '<small><strong>' + texto_anuncio + '</strong></small>',
                icon: icono,
                // text: texto_anuncio
            });
        },

        buscarRegistro(page = 1) {
            var url = '/mpv'
            this.filtro.page = page
            axios.get(url, {
                params: this.filtro
            }).then(response => {
                this.documentos = response.data
                this.operSelected = []
                this.docIndexes = []
            })
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
        imprimirDocumentoPdf(data) {
            this.$refs.test.imprimirDocumentoPdf(data)
        },
        mostrar(accion) {
            if (this.docIndexes.length === 0) {
                // toastr.warning('debe de seleccionar al menos un documento!!')
                this.toast('Debe de seleccionar al menos un documento!!', 'warning');
            } else {
                switch (accion) {
                    case 'editar': {
                        $('#editar').modal({
                            backdrop: 'static',
                            keyboard: false
                        })
                        this.formRegistro.id = this.documentos.data[this.docIndexes[0]].id
                        this.formRegistro.docu_numero_doc = this.documentos.data[this.docIndexes[0]].docu_numero_doc
                        this.formRegistro.docu_siglas_doc = this.documentos.data[this.docIndexes[0]].docu_siglas_doc
                        this.formRegistro.docu_folios = this.documentos.data[this.docIndexes[0]].docu_folios
                        this.formRegistro.docu_asunto = this.documentos.data[this.docIndexes[0]].docu_asunto
                    }
                    break
                case 'derivar': {
                    this.derivaciones = []
                    $('#derivar').modal({
                        backdrop: 'static',
                        keyboard: false
                    })
                }
                break
                case 'archivar': {
                    if (this.verificarDerivado()) {
                        // toastr.warning('no se puede archivar un documento que se encuentre derivado!!')
                        this.toast('No se puede archivar un documento que se encuentre derivado!!', 'warning');
                    } else {
                        $('#archivar').modal({
                            backdrop: 'static',
                            keyboard: false
                        })
                    }
                }
                break
                case 'transferir': {
                    if (this.verificarDerivado()) {
                        // toastr.warning('no se puede transferir un documento que se encuentre derivado!!')
                        this.toast('No se puede transferir un documento que se encuentre derivado!!', 'warning');
                    } else {
                        $('#transferir').modal({
                            backdrop: 'static',
                            keyboard: false
                        })
                    }
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
        grabarDerivaciones() {
            this.fullscreenLoading = true;
            const params = {
                operSelected: this.operSelected,
                derivaciones: this.derivaciones
            }
            // alert('hola mundo');
            if (!this.saving) {
                this.saving = true
                var url = '/mpv/derivar'
                axios.post(url, params)
                    .then(response => {
                        // console.log(response.data)

                        if (response.data.status) {
                            this.fullscreenLoading = false;
                            $('#derivar').modal('hide')
                            this.toast(response.data.msg, 'success');

                            this.saving = false
                            this.buscarRegistro()
                        }
                    })
                    .catch(error => {
                        // console.log('Ocurrio un error guardar la derivacion, verifique su conexion a internet e intentelo nuevamente')
                        this.saving = false
                        this.buscarRegistro()
                        $('#derivar').modal('hide')
                    })
            }
        },
        selectArchivar(documento) {
            if (this.operSelected.indexOf(documento.id) === -1 && this.docIndexes.indexOf(this.documentos.data.indexOf(documento)) === -1) {
                this.operSelected.push(documento.id)
                this.docIndexes.push(this.documentos.data.indexOf(documento))
            } else {
                this.operSelected.splice(this.operSelected.indexOf(documento.id), 1)
                this.docIndexes.splice(this.docIndexes.indexOf(this.documentos.data.indexOf(documento)), 1)
            }
        },
        documentoAccion() {
            const params = {
                idDocumento: this.operSelected,
                motivo: this.eleccionArchivador.acciones
            }
            var url = '/mpv/archivar'
            // return axios.post('/mpv/archivar', data)
            axios.post(url, params).then(response => {
                this.operSelected = []
                this.docIndexes = []
                this.buscarRegistro()
            })

        },
        transferir() {
            const params = {
                idDocumento: this.operSelected,
                id_dependencia: this.id_dependencia
            }
            var url = '/mpv/transferir'
            // axios.post('/mpv/transferir', data)
            axios.post(url, params).then(response => {
                this.operSelected = []
                this.docIndexes = []
                // toastr.success('se transfirió con éxito!')
                this.toast('se transfirió con éxito!', 'success');
                this.buscarRegistro()
            })
        },
        editar() {
            var url = '/mpv/' + this.formRegistro.id
            // axios.post(url, this.formRegistro)
            axios.post(url, this.formRegistro).then(response => {
                this.operSelected = []
                this.docIndexes = []
                this.buscarRegistro()
            })
        }
    }
}
</script>

<style lang="css" scoped>
/* .pagination{
               margin-bottom: 0;
           } */
</style>
