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
                <div class="card card-primary">
                    <div class="card-header">UNIDAD ORGÁNICA</div>
                    <div class="card-body">
                        <div class="col-md-12">
                            <form @submit.prevent="buscarUnidad()">
                                <div class="row form-group" style="width: 100%;margin-left: -0px;">
                                    <!-- <p v-if="is('SUPERADMIN')">{{ definetipo(1) }}</p> -->
                                    <div class="col-sm-4">
                                        <label for="">Código de Unidad Orgánica</label>
                                        <input v-model="formData.iddependencia" type="text" class="form-control" />
                                    </div>
                                    <div v-if="tipo == 1" class="col-sm-8">
                                        <label for="">Dependencia</label>
                                        <select v-model="formData.depe_depende" :disabled="!(tipo == 1)" class="form-control" @change="buscarUnidad()">
                                            <option :value="null">Seleccione Opción</option>
                                            <option v-for="(sede, indexSede) in getSedes" :key="indexSede" :value="sede.iddependencia">{{ sede.depe_nombre }}</option>
                                        </select>
                                    </div>
                                    <div v-else class="col-sm-8">
                                        <label>Dependencia</label>
                                        <p>{{ getDependenciaNombre(getDependenciaUser.iddependencia) }}</p>
                                    </div>
                                </div>
                                <div class="row form-group" style="width: 100%;margin-left: -0px;">
                                    <div class="col-sm-5">
                                        <label for="">Nombre</label>
                                        <input v-model="formData.depe_nombre" type="text" class="form-control" @change="formData.depe_nombre = formData.depe_nombre.toUpperCase()" />
                                    </div>
                                    <div class="col-sm-5">
                                        <label for="">Representante</label>
                                        <input v-model="formData.depe_representante" type="text" class="form-control" @change="formData.depe_representante = formData.depe_representante.toUpperCase()" />
                                    </div>
                                    <div class="col-sm-2">
                                        <br />
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <span class="glyphicon glyphicon-search"></span>Buscar
                                        </button>
                                    </div>
                                </div>
                            </form>
                            <div v-if="mostrarUnidad" class="box">
                                <div class="box-body">
                                    <pagination :data="dependencias" :limit="3" @pagination-change-page="buscarUnidad" />
                                    <table class="table table-bordered table-condensed table-hover table-sm">
                                        <thead>
                                            <tr class="info">
                                                <th  nowrap>CÓDIGO</th>
                                                <th  nowrap>NOMBRE</th>
                                                <th  nowrap>ABREVIADO</th>
                                                <th  nowrap>SIGLAS</th>
                                                <th  nowrap>REPRESENTANTE</th>
                                                <th  nowrap>DEPENDENCIA</th>
                                                <th  nowrap>EDITAR</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(dependencia, index) in dependencias.data" :key="index">
                                                <td >{{ dependencia.iddependencia }}</td>
                                                <td >{{ dependencia.depe_nombre }}</td>
                                                <td >{{ dependencia.depe_abreviado }}</td>
                                                <td >{{ dependencia.depe_sigla }}</td>
                                                <td >{{ dependencia.depe_representante }}</td>
                                                <td >{{ dependencia.nombre }}</td>
                                                <td>
                                                    <!--EDITAR-->
                                                    <router-link :to="{
                                                                            name: tipo == 1 ? 'AdminUnidadOrganicaEdit' : 'AdminUnidadOrganicaEdit2',
                                                                            params: { id: dependencia.iddependencia }
                                                                        }">
                                                        <a class="btn btn-info fa fa-pencil btn-xs"></a>
                                                    </router-link>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <pagination :data="dependencias" :limit="3" @pagination-change-page="buscarUnidad" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
    
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content -->
    
    </div>
    </template>
    
    <script>
    import Vuex from 'vuex'
    import LaravelVuePagination from 'laravel-vue-pagination';
    export default {
    
        props: {
            routeUnidad: {
                type: String,
                default: ''
            },
            routeDependencias: {
                type: String,
                default: ''
            },
            tipo: {
                type: Number,
                default: 1
            },
            // limit: {
            //     type: Number,
            //     default: 3
            // }
        },
    
        data() {
            return {
                formData: {
                    iddependencia: null,
                    depe_depende: null,
                    depe_nombre: null,
                    depe_representante: null,
                    tipo: this.tipo,
                    page: null
                },
                mostrarUnidad: false,
                dependencias: []
            }
        },
        components: {
            'pagination': LaravelVuePagination,
        },
    
        computed: {
            ...Vuex.mapGetters(['getSedes', 'getDependenciaUser', 'getDependenciaNombre'])
        },
    
        mounted() {
    
            if (this.tipo == 2) {
                var este = this
                window.setTimeout(function () {
                    // code to run after 5 seconds...
                    este.formData.depe_depende = este.getDependenciaUser.iddependencia
                    este.buscarUnidad()
                }, 1500)
            }
        },
    
        methods: {
            buscarUnidad(page = 1) {
                this.formData.page = page
                axios.get('/unidadesdepe', {
                    params: this.formData
                }).then(response => {
                    this.dependencias = response.data
                    this.mostrarUnidad = true;
                })
            }
        }
    }
    </script>
    
    <style scoped>
    input,
    textarea {
        text-transform: uppercase;
    }
    </style>
    