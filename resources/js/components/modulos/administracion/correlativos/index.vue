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
                <div class="col-sm-12">
                    <div class="card card-primary">
                        <div class="card-header">CORRELATIVOS</div>
                        <div class="card-body">
                            <form action="" @submit.prevent="buscarCorrelativo()">
                                <div class="row form-group" style="width: 100%;margin-left: -0px;">
                                    <div class="col-sm-3">
                                        <label>Periodo</label>
                                        <select v-model="formData.tdco_periodo" class="form-control form-control-sm">
                                            <option :value="null">Seleccione</option>
                                            <option v-for="(periodo, indexPeriodo) in getPeriodosCorrelativo" :key="indexPeriodo" :value="periodo.tdco_periodo">{{
                                                        periodo.tdco_periodo
                                                    }}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <br />
                                        <input v-model="formData.iddependencia" type="text" class="form-control form-control-sm" @change="obtenerUser()" />
                                    </div>
                                    <div class="col-sm-7">
                                        <label>Unidad Org:</label>
                                        <!-- <select v-model="formData.iddependencia" class="form-control form-control-sm" @change="obtenerUser()">
                                            <option :value="null">Seleccione</option>
                                            <option v-for="(unidad, indexUnidad) in getUnidadesDependenciaForCorrelativo(tipoCorrelativos)" :key="indexUnidad" :value="unidad.iddependencia">{{ unidad.depe_nombre }}</option>
                                        </select> -->

                                        <el-select v-model="formData.iddependencia" @change="obtenerUser()" filterable placeholder="Seleccione la dependencia" style="width: 100%;" size="small">
                                                <el-option v-for="(unidad, indexUnidad) in getUnidadesDependenciaForCorrelativo(tipoCorrelativos)" :key="indexUnidad" :label="unidad.depe_sigla+'-'+recortacadena(unidad.depe_nombre)" :value="unidad.iddependencia">
                                                </el-option>
                                            </el-select>
                                    </div>
                                </div>
                                <div id="iducuario" class="row form-group" style="width: 100%;margin-left: -0px;">
                                    <div class="col-sm-5">
                                        <label>Usuario</label>
                                        <select v-model="formData.idadmin" class="form-control form-control-sm">
                                            <option :value="null">Todos</option>
                                            <option v-for="(user, indexUser) in users" :key="indexUser" :value="user.id">{{ user.adm_name }} {{ user.adm_lastname }}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-5">
                                        <label>Tipo de Documento</label>
                                        <select v-model="formData.idtdoc" class="form-control form-control-sm">
                                            <option :value="null">Seleccione</option>
                                            <option v-for="(tipo, indexTipo) in getTiposDocumento" :key="indexTipo" :value="tipo.idtdoc">{{ tipo.tdoc_descripcion }}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <br />
                                        <button type="submit" class="btn btn-primary">
                                            <span class="glyphicon glyphicon-search"></span>Buscar
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <pagination :data="correlativos" :limit="limit" @pagination-change-page="buscarCorrelativo" />
                            <table class="table table-bordered table-condensed table-hover">
                                <thead>
                                    <tr class="info">
                                        <th style="font-size:13px; font-family: Tahoma" nowrap>PERIODO</th>
                                        <th style="font-size:13px; font-family: Tahoma" nowrap>DEPENDENCIA</th>
                                        <th style="font-size:13px; font-family: Tahoma" nowrap>TIPO</th>
                                        <th style="font-size:13px; font-family: Tahoma" nowrap>USUARIO</th>
                                        <th style="font-size:13px; font-family: Tahoma" nowrap>Siguiente_Número</th>
                                        <th style="font-size:13px; font-family: Tahoma" nowrap>Editar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(correlativo, index) in correlativos.data" :key="index">
                                        <td style="font-size:13px; font-family: Tahoma">{{ correlativo.tdco_periodo }}</td>
                                        <td style="font-size:13px; font-family: Tahoma">{{ correlativo.depe_nombre }}</td>
                                        <td style="font-size:13px; font-family: Tahoma">{{ correlativo.tdoc_descripcion }}</td>
                                        <td v-if="correlativo.usuario != 0" style="font-size:13px; font-family: Tahoma">
                                            {{ correlativo.adm_email }}
                                        </td>
                                        <td v-else>&nbsp;</td>
                                        <td v-if="editMode && editId == correlativo.id" style="font-size:13px; font-family: Tahoma, sans-serif">
                                            <input v-model="correlativo.tdco_numero" type="text" class="form-control form-control-sm" />
                                        </td>

                                        <td v-else style="font-size:13px; font-family: Tahoma">{{ correlativo.tdco_numero }}</td>
                                        <td>
                                            <a v-if="editMode && editId == correlativo.id" class="btn btn-success" @click="updateCorrelativo(index)">Guardar</a>
                                            <a v-else class="btn btn-info fa fa-edit" @click="editCorrelativo(correlativo.id)"></a>
                                            <a v-if="editMode && editId == correlativo.id" class="btn btn-danger" @click="cancelCorrelativo(index)">cancelar</a>
                                            <a class="btn btn-danger fa fa-trash" @click="eliminar(correlativo.id)"></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <pagination :data="correlativos" :limit="3" @pagination-change-page="buscarCorrelativo" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import Vuex from 'vuex'
import LaravelVuePagination from 'laravel-vue-pagination';
import axios from 'axios';

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
        routeCorrelativo: {
            type: String,
            default: ''
        },
        routeUser: {
            type: String,
            default: ''
        },
        routeUpdate: {
            type: String,
            default: ''
        },
        tipoCorrelativos: {
            type: Number,
            default: 1
        },
        limit: {
            type: Number,
            default: 3
        }
    },

    data() {
        return {
            formData: {
                tdco_periodo: null,
                iddependencia: null,
                idtdoc: null,
                idadmin: null,
                page: null
            },
            mostrarCorrelativo: false,
            correlativos: {},
            users: [],
            editMode: false,
            editId: null
        }
    },
    components: {
        'Pagination': LaravelVuePagination,
    },

    computed: {
        ...Vuex.mapGetters(['getUnidadesDependenciaForCorrelativo', 'getTiposDocumento', 'getPeriodosCorrelativo']),

        checkUnidad() {
            let unidades = this.getUnidadesDependenciaForCorrelativo(this.tipoCorrelativos)
            let oneDependencia = unidades.filter(d => d.iddependencia == this.formData.iddependencia)[0]
            if (oneDependencia != undefined) {
                return true
            } else {
                return false
            }
        }
    },

    mounted() {
        this.obtenerPeriodosCorrelativo()
        this.cargatipodocumento()
    },

    methods: {
        ...Vuex.mapActions(['obtenerPeriodosCorrelativo']),

        cargatipodocumento() {
            var url = '/tiposdocumentos/interno'
            axios.get(url)
                .then(res => {
                    this.$store.commit('llenarTiposDocumento', res.data)
                })

        },

        toast(texto_anuncio, icono) {

            Toast.fire({
                // title:texto_titulo,
                title: '<small><strong>' + texto_anuncio + '</strong></small>',
                icon: icono,
                // text: texto_anuncio
            });
        },

        buscarCorrelativo(page = 1) {
            if (this.checkUnidad) {
                this.formData.page = page
                axios.get('/administrador/correlativos', {
                    params: this.formData
                }).then(response => {
                    this.correlativos = response.data
                    this.mostrarCorrelativo = true
                })
            } else {
                // alert('Seleccione Una Unidad Organica que pertenezca a la Dependencia')
                this.toast('Seleccione Una Unidad Organica que pertenezca a la Dependencia', 'warning');
                this.users = []
            }
        },

        obtenerUser() {
            if (this.checkUnidad) {
                var url = '/usuarios/obtenerUserDependenciaActivo'
                const parm = {
                    depe_id: this.formData.iddependencia
                }
                axios.get(url, {
                    params: parm
                }).then(response => {
                    this.users = response.data
                })
            } else {
                alert('Seleccione Una Unidad Organica que pertenezca a la Dependencia')
                this.toast('Seleccione Una Unidad Organica que pertenezca a la Dependencia', 'warning');
                this.users = []
            }
        },

        editCorrelativo(index) {
            this.editId = index
            this.editMode = true
        },

        updateCorrelativo(index) {
            var url = '/administrador/correlativos/%s'
            const params = {
                tdco_numero: this.correlativos.data[index].tdco_numero
            }

            axios.put(url.replace(/%s/g, this.editId), params).then(response => {
                //this.correlativos.data[index]=response.data;
                this.editId = null
                this.editMode = false
            })
        },
        eliminar(index)
        {
            var url='/administrador/eliminarcorrelativo'
            const params = {
                id:index
            }
            axios.post(url,params).then(res=>{
                    // console.log(index)

                    this.toast(res.data.respuesta, 'success');

                    this.buscarCorrelativo()
                }
            )
        },

        cancelCorrelativo(index) {
            this.editId = null
            this.editMode = false
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
