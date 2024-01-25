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
                            <router-link :to="'/Tramites/virtual'" class="nav-link" id="index" data-toggle="pill" aria-controls="custom-content-above-home" aria-selected="false">
                                Explorar Registros ingresados por MPV
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="'/Tramites/virtual-derivados'" class="nav-link active" id="derivados" data-toggle="pill" aria-controls="custom-content-above-home" aria-selected="true">
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
                <div class="col-sm-12">
                    <div class="card card-primary">
                        <div class="card-header">SOLICITUDES DE MESA DE PARTES VIRTUAL</div>
                        <div class="card-body">
                            <form @submit.prevent="buscarRegistro">
                                <div class="row" style="width: 100%;margin-left: -0px;">
                                    <div class="col-sm-4">
                                        <label></label>
                                        <input ref="registro" v-model="filtro.id" type="text" name="registro" placeholder="Nombre, DNI, RUC" class="form-control" />
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group date">
                                            <label>Fecha Desde:</label>
                                            <input v-model="filtro.fecha_desde" type="date" class="form-control" @change="putHasta" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group date">
                                            <label>Fecha Hasta:</label>
                                            <input v-model="filtro.fecha_hasta" type="date" class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <br />
                                        <button type="submit" class="btn btn-primary">
                                            <span class="glyphicon glyphicon-search"></span> Buscar
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <div class="box">
                                <div class="box-body">
                                    <pagination :data="documentos" :limit="3" @pagination-change-page="buscarRegistro" />
                                    <table class=" table table-bordered table-condensed table-hover ">
                                        <thead class="bg-lightblue disabled color-palette pd-0">
                                            <tr class="info">
                                                <th style="width:7%">REGISTRO/EXPEDIENTE</th>
                                                <th style="width:15%">FECHA</th>
                                                <th style="width:40%">DOCUMENTO</th>
                                                <th style="width:10%">REMITENTE</th>
                                                <th style="width:10%">DESTINO</th>
                                                <th style="width:10%">ARCHIVO</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td v-if="documentos.data.length === 0" colspan="21" class="text-center">
                                                    No hay documentos, pruebe cambiando los filtros
                                                </td>
                                            </tr>
                                            <tr v-for="(documento, index) in documentos.data" :key="index" :set="(dias = moment().diff(moment(documento.created_at), 'days'))">
                                                <td>
                                                    <span :class="{
                        badge: true,
                        'badge-danger': dias > 20,
                        'badge-warning': dias > 10 && dias <= 20,
                        'badge-success': dias <= 10
                      }">{{ dias }} días</span><br />
                                                    <strong>Reg.</strong>
                                                    <a href="#" target="_blank" @click.prevent.stop="buscarByDocumento({ iddocumento: documento.iddocumento, modal: true })">{{ ' ' + ('00000000' + documento.iddocumento).slice(-8) }}</a><br />
                                                    <strong>Exp.</strong>{{ ' ' + ('00000000' + documento.docu_idexma).slice(-8) }}<br />
                                                    <span :class="documento.docu_estado === 2? 'badge badge-info': 'badge badge-warning'">
                                                        {{ documento.docu_estado === 2?'Derivado':'' }}
                                                    </span>
                                                </td>
                                                <td class="registro">
                                                    <strong>Fecha:</strong>{{ moment(documento.created_at).format('DD-MM-YYYY  H:mm:ss') }}<br />
                                                    <strong>Folios:</strong>{{ documento.docu_folios }}
                                                </td>
                                                <td class="documento">
                                                  <div><strong>Doc:</strong>
                                                    
                                                        {{ documento.tipo_documento.tdoc_descripcion+' ' }}
                                                        {{ documento.docu_numero_doc != null?(' '+'000000' +documento.docu_numero_doc).slice(-6):'' }}
                                                        {{ '-'+documento.docu_fecha_doc.substr(0, 4)
                      }}{{ documento.docu_siglas_doc != null ? '-' + documento.docu_siglas_doc : '' }}
                                                    </div>
                                                    <div><strong>Entidad:</strong>
                                                    {{ documento.docu_detalle }}</div>
                                                    <div><strong>Firma:</strong>
                                                    {{ documento.docu_firma }}</div>
                                                    <div><strong>Cargo:</strong>
                                                    {{ documento.docu_cargo }}<br /></div>
                                                    <div><strong>Asunto:</strong>
                                                    {{ documento.docu_asunto }}</div>
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
                                                    <div v-if="documento.operacion.length>0">
                                                        <strong>Destino:</strong>{{ documento.operacion[0].dependencia_destino.depe_nombre }}<br />
                                                    </div>
                                                    <div v-if="documento.operacion.length>0&&documento.operacion[0].oper_usuid_d">
                                                        <strong>Para:</strong>{{ getUsuariosActivoNombre(documento.operacion[0].oper_usuid_d) }}<br />
                                                    </div>
                                                </td>

                                                <td>
                                                    <div v-if="documento.docu_archivo.length>0">
                                                        <table>
                                                            <tbody>
                                                                <tr v-for="(archivo, indexArchivo) in documento.docu_archivo.filter(d => d.file_mostrar)" :key="indexArchivo">
                                                                    <td>
                                                                        <button type="button" class="btn btn-xs btn-link doc-link" @click.stop="imprimirDocumentoPdf({id:archivo.id, id_documento_externo:archivo.id_documento_externo, file_tipo: archivo.file_tipo, file_name: archivo.file_name, tipo:2})">
                                                                            <span style="color:blue;font-size:80%">{{ getFormatBytes(archivo.file_size) }}</span>
                                                                            <span v-if="archivo.file_principal != null" :class="
                                    archivo.file_principal
                                      ? 'badge badge-danger'
                                      : 'badge badge-warning'
                                  ">
                                                                                {{ archivo.file_principal?'P':'A' }}
                                                                            </span>
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
                                    <pagination :data="documentos" :limit="3" @pagination-change-page="buscarRegistro" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <Modalbusdocumento ref="foo" />
</div>
</template>

<script>
import LaravelVuePagination from 'laravel-vue-pagination';
import Vuex from 'vuex'
import Modalbusdocumento from '../tramites/Modalresultado.vue'
import moment from 'moment'
export default {
    name: 'MpvDerivative',
    props: {
        routes: {
            type: [Object, String],
            default: '/getRoute'
        },
        routeDocumento: {
            type: String,
            default: '/tramite/buscar/buscarModal/%s'
        },
    },

    data() {
        return {
            filtro: {
                id: null,
                fecha_desde: null,
                fecha_hasta: null,
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
        }
    },
    computed: {
        ...Vuex.mapGetters([
            'getDependenciaNombre',
            'getUsuariosActivoNombre',
            'getFormatBytes'
        ])
    },
    components: {
        'Pagination': LaravelVuePagination,
        Modalbusdocumento,
    },

    mounted() {
        let date = new Date() // Or the date you'd like converted.
        let isoDate = new Date(date.getTime() - date.getTimezoneOffset() * 60000).toISOString()
        this.filtro.fecha_hasta = isoDate.slice(0, 10)
        this.filtro.fecha_desde = isoDate.slice(0, 10)

        this.buscarRegistro()
        // this.obtenerRutas(this.routes)
        // this.obtenerJsonAll()
    },

    methods: {
        ...Vuex.mapActions([
            'obtenerJsonAll',
            'obtenerRutas',
            // 'buscarByDocumento'
        ]),

        moment(a) {
            return moment(a)
        },

        putHasta() {
            this.filtro.fecha_hasta = this.filtro.fecha_desde
        },

        buscarRegistro(page = 1) {
            var url = '/mpv/derivados'
            this.filtro.page = page
            axios.get(url, {
                    params: this.filtro
                })
                .then(response => {
                    this.documentos = response.data
                })
        },

        // recargar(iddocumento) {
        //     window.open(this.routeDocumento.replace(/%s/g, iddocumento), 'visorExp', 'width=1000, height=750')
        // },
        
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
