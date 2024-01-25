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

            <div class="card card-danger card-outline">
                <div class="card-header p-1">
                    Documentos archivados

                </div>
                <div class="card-body">
                    <form @submit.prevent="buscarDocArchivados()">
                        <div class="row form-group">

                            <div class="col-sm-3">
                                <label>Documentos del Usuario</label>
                                <select v-model="formData.oper_idusuario" class="form-control form-control-sm" @change="buscarDocArchivados()">
                                    <option :value="null">Todos</option>
                                    <option v-for="(user, indexUser) in usersoficinas" :key="indexUser" :value="user.id">{{ user.adm_name }}</option>
                                </select>
                            </div>
                            <div class="col-sm-4">
                                <label>Archivador</label>
                                <select v-model="formData.idarch" class="form-control form-control-sm" @change="buscarDocArchivados()">
                                    <option :value="null">Todos</option>
                                    <option v-for="(archivador, indexArchivado) in getArchivadores" :key="indexArchivado" :value="archivador.idarch">
                                        {{ archivador.arch_periodo + '/' + archivador.arch_nombre }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-sm-2">
                                <label>Forma</label>
                                <select v-model="formData.oper_tarchi_id" class="form-control form-control-sm">
                                    <option :value="null">Todos</option>
                                    <option value="0">Temporal</option>
                                    <option value="1">Definitivo</option>
                                </select>
                            </div>
                            <div :class="'col-sm-2'">
                                <label>Registro</label>
                                <input ref="registro" v-model="formData.iddocumento" type="text" name="registro" class="form-control form-control-sm" />
                                <!-- <span v-show="errors.has('registro')" class="help-block">{{ errors.first('registro') }}</span> -->
                            </div>
                            <div class="col-sm-1">
                                <br />
                                <button class="btn btn-primary" type="submit">
                                    <span class="glyphicon glyphicon-search"></span> Buscar
                                </button>
                            </div>

                        </div>
                    </form>
                    <div class="row form-group">
                        <div class="col-sm-8">

                            <button class="btn btn-sm btn-success" :disabled="!puedeDevolver || docDevolveProceso.length == 0" @click="devolverProceso()">
                                <span class=""></span>Devolver a en proceso
                            </button>

                        </div>
                        <div class="col-sm-4">
                            <div class="float-right d-none d-sm-inline-block">
                                <pagination :data="archivados" :limit="3" @pagination-change-page="buscarDocArchivados" />
                            </div>

                        </div>
                    </div>
                    <!--TABLA-->
                    <div class="row mt-2">

                        <table class="table table-bordered table-condensed table-hover">
                            <thead class="bg-lightblue disabled color-palette pd-0">
                                <tr class="info">
                                    <th style="width:7%">Registro</th>
                                    <th style="width:7%">Adjuntado_al</th>
                                    <th style="width:16%">Archivador</th>
                                    <th style="width:40%">Documento</th>
                                    <th style="width:20%">Detalles</th>
                                    <th style="width:10%">Archivos</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td v-if="archivados.data.length == 0" colspan="21" class="text-center">
                                        No hay documentos, pruebe cambiando los filtros
                                    </td>
                                </tr>
                                <tr v-for="(documento, index) in archivados.data" :key="index" :class="docDevolveProceso.indexOf(documento.idoperacion) >= 0 ? 'danger' : null" @click="selectDevolverProceso(documento)">
                                    <td>
                                        <strong>Reg.</strong>
                                        <a href="#" @click.prevent.stop="buscarByDocumento({ iddocumento: documento.iddocumento, modal: true })">{{ ' ' + ('00000000' + documento.iddocumento).slice(-8) }}</a>
                                    </td>
                                    <td v-if="documento.oper_iddocumento_adj != null" class="registro">
                                        <strong>Reg.</strong>{{ ('00000000' + documento.oper_iddocumento_adj).slice(-8) }}
                                    </td>
                                    <td v-else class="registro">&nbsp;</td>
                                    <td v-if="documento.arch_nombre != null" class="registro">
                                        {{ documento.arch_periodo + ' / ' }}{{ documento.arch_nombre }}
                                    </td>
                                    <td v-else class="registro">&nbsp;</td>
                                    <td class="documento">
                                        <small>
                                            <div v-if="documento.tdoc_descripcion != null">
                                                <strong>Doc:</strong>
                                                {{ documento.tdoc_descripcion + ' ' }}{{ ('000000' + documento.docu_numero_doc).slice(-6)
                                                }}{{ documento.docu_origen == 1 ? '-' + documento.docu_fecha_doc.substr(0, 4) : ''
                                                }}{{ documento.docu_siglas_doc != null ? '-' + documento.docu_siglas_doc : null }}
                                            </div>
                                            <div v-else>&nbsp;</div>
                                            <div><strong>Firma:</strong>
                                                {{ documento.docu_firma }}</div>
                                            <div><strong>Cargo:</strong>
                                                {{ documento.docu_cargo }}</div>
                                            <div><strong>Asunto:</strong>
                                                {{ documento.docu_asunto }}</div>
                                            <div><strong>Dependencia:</strong>
                                                {{ documento.depe_nombre }}</div>
                                        </small>
                                    </td>
                                    <td>
                                        <small>
                                            <div><strong>Detalle:</strong>{{ documento.oper_acciones }}<br /></div>
                                            <div><strong>Fecha:</strong>{{ documento.fecha_archivado }}<br /></div>
                                            <div><strong>Usuario:</strong>{{ documento.adm_name + ' ' }}{{ documento.adm_lastname }}</div>
                                        </small>
                                    </td>
                                    <td>
                                        <div v-if="documento.docu_archivo.length > 0">
                                            <table>
                                                <tbody>
                                                    <tr class="p-0">
                                                        <td class="p-0 border-0">
                                                            <span v-if="documento.docu_digital" class="badge badge-info">DOCUMENTO INGRESADO MPV</span>
                                                            <span v-else class="badge badge-warning">DOCUMENTO REGISTRADO INTERNAMENTE</span>
                                                        </td>
                                                    </tr>
                                                    <tr v-for="(archivo, indexArchivo) in documento.docu_archivo.filter(d => d.file_mostrar)" :key="indexArchivo" class="p-0">
                                                        <td class="p-0 border-0">
                                                            <button type="button" class="btn btn-xs btn-link doc-link" @click.stop="imprimirDocumentoPdf({id:archivo.id, id_documento:archivo.id_documento, file_tipo: archivo.file_tipo, file_name: archivo.file_name, tipo:1})">
                                                                <span style="color:blue;font-size:80%">{{ getFormatBytes(archivo.file_size) }}</span>
                                                                <span v-if="archivo.file_principal != null" :class="archivo.file_principal? 'badge badge-danger': 'badge badge-warning'">
                                                                    {{ archivo.file_principal?'P':'A' }}
                                                                </span>
                                                                <span :class=" archivo.file_tipo.indexOf('image') === 0? 'glyphicon glyphicon-picture': 'glyphicon glyphicon-file'"></span>
                                                                {{ archivo.file_name }}
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                    <!--FIN TABLA -->
                    <div class="row form-group">
                        <div class="col-sm-8">

                            <button class="btn btn-sm btn-success" :disabled="!puedeDevolver || docDevolveProceso.length == 0" @click="devolverProceso()">
                                <span class=""></span>Devolver a en proceso
                            </button>

                        </div>
                        <div class="col-sm-4">
                            <div class="float-right d-none d-sm-inline-block">
                                <pagination :data="archivados" :limit="3" @pagination-change-page="buscarDocArchivados" />
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /.content -->
        <Modalbusdocumento ref="test" />
    </div>
</div>
</template>

<script>
import Vuex from 'vuex'
import LaravelVuePagination from 'laravel-vue-pagination'
import Modalbusdocumento from './Modalresultado.vue'

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

    props: {
        routePrintPdf: {
            type: String,
            default: ''
        },
        routeArchivado: {
            type: String,
            default: ''
        },
        routeDevolver: {
            type: String,
            default: ''
        },
        routeUsuariosDependencia: {
            type: String,
            default: ''
        },
        routeArchivadores: {
            type: String,
            default: ''
        },
        usuario: {

        },
        limit: {
            type: Number,
            default: 3
        }
    },

    data() {
        return {
            puedeDevolver: true,
            formData: {
                oper_idusuario: this.usuario.id,
                idarch: null,
                iddocumento: null,
                oper_tarchi_id: null,
                page: null
            },
            archivados: {
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
            docDevolveProceso: [],
            mostrarDocumentos: true
        }
    },
    components: {
        'Pagination': LaravelVuePagination,
        Modalbusdocumento

    },

    computed: {
        ...Vuex.mapGetters(['usersoficinas', 'getArchivadores', 'getFormatBytes'])
    },

    mounted() {
        if (location.hash == '#temporal') this.formData.oper_tarchi_id = 0
        this.buscarDocArchivados()
        // this.obtenerArchivadores()
    },

    methods: {
        // ...Vuex.mapActions([
        //     'buscarByDocumento',
        //     'obtenerArchivadores',
        //     'imprimirDocumentoPdf'
        // ]),

        toast(texto_anuncio, icono) {

            Toast.fire({
                // title:texto_titulo,
                title: '<small><strong>' + texto_anuncio + '</strong></small>',
                icon: icono,
                // text: texto_anuncio
            });
        },

        buscarDocArchivados(page = 1) {
            // this.$validator.validate().then(result => {
            //     if (result) {
            this.formData.page = page
            axios.get('/tramite/archivados', {
                params: this.formData
            }).then(reponse => {
                this.archivados = reponse.data
            })
            // } else {
            //     console.log('incompleto')
            // }
            // })
        },

        selectDevolverProceso(documento) {
            if (this.docDevolveProceso.indexOf(documento.idoperacion) == -1) {
                this.docDevolveProceso.push(documento.idoperacion)
            } else {
                this.docDevolveProceso.splice(this.docDevolveProceso.indexOf(documento.idoperacion), 1)
            }
        },

        devolverProceso() {
            if (confirm('Esta seguro de devolver en proceso el documento?')) {
                const params = {
                    devolver: this.docDevolveProceso
                }
                this.puedeDevolver = false
                axios.post('/documento/devolverProceso', params).then(response => {
                    this.toast('Documento devuelto a procesos', 'success');
                    this.buscarDocArchivados()
                    this.docDevolveProceso = []
                    this.puedeDevolver = true
                })
            }
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
    width: 75px;
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
