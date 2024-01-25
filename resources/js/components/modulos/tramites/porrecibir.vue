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
                <div class="col-lg-6 col-10">
                    <router-link :to="'/Tramites/Enproceso'" class="btn btn-info btn-sm"><i class="fa-regular fa-circle-left"></i> ir a documentos en proceso</router-link>
                </div>

            </div>

            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="card card-danger card-outline ">
                        <div class="card-header p-1">
                            Documentos por recibir
                            {{ $store.state.usuariologeado.name }}
                        </div>
                        <div class="card-body">
                            <!-- {{-- para las opciones de busqueda --}} -->
                            <div class="row">
                                <div class="col-md-2">
                                    <div class="group">
                                        <label class="text-sm">Registro</label>
                                        <input type="number" class="form-control form-control-sm" v-model="formData.iddocumento" @change="documentoRecibir">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="group">
                                        <label>Documento del Usuario</label>
                                        <select v-model="formData.idadmin" class="form-control form-control-sm" @change="documentoRecibir()" v-if="is('PERSONA')">
                                            <!-- <option :value="null">Todos</option> -->
                                            <option v-for="(usuarios, indexUser) in usersoficinas" :key="indexUser" :value="usuarios.id" v-if="usuarios.id!=1&& usuario.id==usuarios.id">
                                                {{ usuarios.adm_name }} {{ usuarios.adm_lastname }}
                                            </option>
                                        </select>
                                        <select v-model="formData.idadmin" class="form-control form-control-sm" @change="documentoRecibir()" v-else>
                                            <option :value="null">Todos</option>
                                            <option v-for="(usuario, indexUser) in usersoficinas" :key="indexUser" :value="usuario.id" v-if="usuario.id!=1">
                                                {{ usuario.adm_name }} {{ usuario.adm_lastname }}
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <br />
                                    <button type="button" class="btn btn-block btn-primary btn-sm mt-2" @click="documentoRecibir"><i class="fa-regular fa-lightbulb"></i> Buscar</button>
                                </div>
                            </div>
                            <div class="row form-group mt-2">
                                <!-- <button type="button" class="btn btn-success btn-sm"><i class="fa-regular fa-registered"></i> Recepcionar</button> -->
                                <div class="col-sm-8">
                                    <button class="btn btn-success btn-sm" :disabled="!(docRecibir.length > 0)" @click="recepcionarDocumento()">
                                        <i class="fa-regular fa-registered"></i> Recepcionar
                                    </button>
                                </div>
                                <div class="col-4">
                                    <div class="float-right d-none d-sm-inline-block">
                                        <pagination :data="docPorRecibir" :limit="limit" @pagination-change-page="documentoRecibir" />
                                    </div>
                                </div>

                            </div>
                            <!-- {{-- para la relacion de datos --}} -->
                            <div class="row mt-2">

                                <table class=" table table-bordered table-condensed table-hover table-sm">
                                    <thead class="bg-lightblue  disabled color-palette pd-0">
                                        <tr class="info">
                                            <th style="width:7%">REGISTRO<br />EXPEDIENTE</th>
                                            <th style="width:10%">REGISTRO</th>
                                            <th style="width:25%">DOCUMENTO</th>
                                            <th style="width:15%">DESTINO</th>
                                            <th style="width:5%">ARCHIVO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td v-if="docPorRecibir.data.length == 0" colspan="21" class="text-center">
                                                No hay documentos, pruebe cambiando los filtros
                                            </td>
                                        </tr>
                                        <tr v-for="(documento, index) in docPorRecibir.data" :key="index" :set="(dias = moment().diff(moment(documento.created_at), 'days'))" :class="docRecibir.indexOf(documento.idoperacion) >= 0 ? 'danger' : null" @click="selectRecepcion(documento)">
                                            <td>
                                                <span :class="{
                                                                badge: true,
                                                                'badge-danger': dias > 20,
                                                                'badge-warning': dias > 10 && dias <= 20,
                                                                'badge-success': dias <= 10}">{{ dias }} días</span><br />
                                                <strong>Reg.</strong>
                                                <a href="#" @click.prevent.stop="buscarByDocumento({ iddocumento: documento.iddocumento, modal: true })">
                                                    {{ ' ' + ('00000000' + documento.iddocumento).slice(-8) }}</a><br />
                                                <strong>Exp.</strong>{{ ('00000000' + documento.docu_idexma).slice(-8) }}
                                            </td>
                                            <td class="registro">
                                                <strong>Fecha:</strong>{{ documento.docu_fecha_doc }}<br />
                                                <strong>Forma:</strong>{{ documento.oper_forma == 1 ? 'COPIA' : 'ORIGINAL' }}<br />
                                                <strong>Folios:</strong>{{ documento.docu_folios }}
                                            </td>
                                            <td class="documento">
                                                <small>
                                                    <div v-if="documento.tdoc_descripcion != null">
                                                        <strong>Doc:</strong>
                                                        {{ documento.tdoc_descripcion + ' ' }}{{ ('000000' + documento.docu_numero_doc).slice(-6)
                                                    }}{{ documento.docu_origen == 1 ? '-' + documento.docu_fecha_doc.substr(0, 4) : ''
                                                    }}{{ documento.docu_siglas_doc != null ? '-' + documento.docu_siglas_doc : '' }}
                                                    </div>

                                                    <div><strong>Firma:</strong>
                                                        {{ documento.docu_firma }}</div>
                                                    <div><strong>Cargo:</strong>
                                                        {{ documento.docu_cargo }}</div>
                                                    <div><strong>Asunto:</strong>
                                                        {{ documento.docu_asunto }}</div>
                                                    <div><strong>Dependencia:</strong>
                                                        {{ documento.depe_nombre_origen }}</div>
                                                </small>
                                            </td>
                                            <td>
                                                <small>
                                                    <div><strong>Destino:</strong>{{ documento.depe_nombre_destino }}<br /></div>
                                                    <div><strong>Para:</strong>{{
                                                                                    documento.name_usuario_destino != null
                                                                                        ? documento.name_usuario_destino + ' ' + documento.lastname_usuario_destino
                                                                                        : documento.depe_nombre_destino
                                                                                    }}<br /></div>
                                                    <div><strong>Detalle:</strong>{{ documento.docu_detalle }}<br /></div>
                                                    <div><strong>Remitente:</strong>{{ documento.name_usuario + ' '
                                                                                        }}{{ documento.lastname_usuario }}</div>
                                                </small>
                                            </td>
                                            <td>
                                                <div v-if="documento.docu_archivo.length > 0">
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                                <td class="p-0 border-0">
                                                                    <span v-if="documento.docu_digital" class="badge badge-info">DOCUMENTO INGRESADO MPV</span>
                                                                    <span v-else class="badge badge-warning">DOCUMENTO REGISTRADO INTERNAMENTE</span>
                                                                </td>
                                                            </tr>
                                                            <tr v-for="(archivo, indexArchivo) in documento.docu_archivo.filter(d => d.file_mostrar)" :key="indexArchivo">
                                                                <td class="p-0 border-0">
                                                                    <button type="button" class="btn btn-xs btn-link doc-link" @click.stop="imprimirDocumentoPdf({id:archivo.id, id_documento:archivo.id_documento, file_tipo: archivo.file_tipo, file_name: archivo.file_name, tipo:1})">
                                                                        <!-- <span style="color:blue;font-size:80%">{{ getFormatBytes(archivo.file_size) }}</span> -->
                                                                        <!-- <span v-if="archivo.file_principal != null" :class="archivo.file_principal? 'badge badge-danger': 'badge badge-warning'">
                                                                            {{ archivo.file_principal?'P':'A' }}
                                                                        </span> -->
                                                                        <span v-if="archivo.file_principal==0" class="badge badge-danger">P</span>
                                                                        <span v-else class="badge badge-warning">A</span>
                                                                        <span :class="
                                                                                            archivo.file_tipo.indexOf('image') === 0
                                                                                            ? 'glyphicon glyphicon-picture'
                                                                                            : 'glyphicon glyphicon-file'
                                                                                        "></span>
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
                            <div class="row form-group mt-2">
                                <!-- <button type="button" class="btn btn-success btn-sm"><i class="fa-regular fa-registered"></i> Recepcionar</button> -->
                                <div class="col-sm-8">
                                    <button class="btn btn-success btn-sm" :disabled="!(docRecibir.length > 0)" @click="recepcionarDocumento()">
                                        <i class="fa-regular fa-registered"></i> Recepcionar
                                    </button>
                                </div>
                                <div class="col-4">
                                    <div class="float-right d-none d-sm-inline-block">
                                        <pagination :data="docPorRecibir" :limit="limit" @pagination-change-page="documentoRecibir" />
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
    <Modalbusdocumento ref="foo" />

</div>
</template>

<script>
import Modalbusdocumento from './Modalresultado.vue'
import moment from 'moment'
import LaravelVuePagination from 'laravel-vue-pagination'
import {
    mapGetters
} from 'vuex';

export default {
    name: '',
    props: ['ruta', 'usuario'],
    data() {
        return {
            puedeRecibir: true,
            datomodal: {},
            formData: {
                iddocumento: null,
                idadmin: this.usuario.id, //null,
                page: null
            },
            docPorRecibir: {
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
            docRecibir: [],
            mostrarDocumentos: true,
            tipoDoc: null,
            derivaciones: [{
                oper_acciones: null,
                oper_depeid_d: null,
                oper_detalledestino: null,
                oper_forma: false,
                oper_usuid_d: null
            }],
            mq: 'desktop',
            limit: 3
        }
    },
    components: {
        'Pagination': LaravelVuePagination,
        Modalbusdocumento

    },
    created() {

    },
    computed: {

        ...mapGetters(['usersoficinas']), // leemos el geter para utilizar en este componente los usuarios de la oficina al que pertenece

    },
    mounted() {
        this.documentoRecibir()
        //this.formData.idadmin = this.usuario.id

    },
    methods: {
        // ...Vuex.mapActions(['imprimirDocumentoPdf']),

        documentoRecibir(page = 1) {
            var url = '/tramite/porRecibir';

            this.formData.page = page
            axios.get(url, {
                params: this.formData
            }).then(response => {
                this.docPorRecibir = response.data
                this.docRecibir = []
            })
        },

        selectRecepcion(documento) {
            //console.log(this.docRecibir.indexOf(documento.idoperacion));
            if (this.docRecibir.indexOf(documento.idoperacion) == -1) {
                this.docRecibir.push(documento.idoperacion)
            } else {
                this.docRecibir.splice(this.docRecibir.indexOf(documento.idoperacion), 1)
            }
        },

        recepcionarDocumento() {
            var url = '/documento/recepcionar';

            if (confirm('Esta seguro de recepcionar el documento?')) {
                const params = {
                    recibir: this.docRecibir,
                    derivaciones: this.derivaciones,
                    tipoDoc: this.tipoDoc
                }
                this.puedeRecibir = false
                axios.post(url, params).then(response => {
                    this.documentoRecibir()
                    this.docRecibir = []
                    this.puedeRecibir = true
                    // console.log(response.data)
                })
            }
        },

        moment(a) {
            return moment(a)
        },

        getFormatBytes() {

        },
        buscarByDocumento(idocumentomodal) // abre modal
        {
            // this.datomodal=idocumentomodal
            this.$refs.foo.buscardocumento(idocumentomodal)

        },
        imprimirDocumentoPdf(data) {
            this.$refs.foo.imprimirDocumentoPdf(data)
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
    width: 72px;
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
