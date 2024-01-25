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
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <router-link :to="'/catalogos'" class="nav-link active" id="index" data-toggle="pill" aria-controls="custom-content-above-home" aria-selected="true">
                                Explorar archivador
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="'catalogos-nuevo'" class="nav-link" id="nuevo" data-toggle="pill" aria-controls="custom-content-above-profile" aria-selected="true">
                                Nuevo archivador
                            </router-link>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="row justify-content-center mt-2">
                <div class="col-12 ">
                    <div class="card card-primary">
                        <div class="card-header">ARCHIVADORES</div>
                        <div class="card-body">
                            <form action="" @submit.prevent="buscarArchivador()">
                                <div class="row form-group" style="width: 100%;margin-left: -0px;">
                                    <div class="col-sm-2">
                                        <label>Unidad Org</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" :value="getDependenciaUser.idoficina" class="form-control form-control-sm" readonly />
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" :value="getDependenciaUser.nombreofi" class="form-control form-control-sm" />
                                    </div>
                                </div>
                                <div class="row form-group" style="width: 100%;margin-left: -0px;">
                                    <div class="col-sm-6">
                                        <label>Descripción</label>
                                        <input v-model="formData.arch_nombre" type="text" class="form-control form-control-sm" placeholder="Buscar" @change="formData.arch_nombre = formData.arch_nombre.toUpperCase()" />
                                    </div>
                                    <div class="col-sm-3">
                                        <label>Periodo</label>
                                        <select v-model="formData.arch_periodo" class="form-control form-control-sm">
                                            <option :value="null">Opciones</option>
                                            <option v-for="(periodo, indexPeriodo) in getPeriodosCorrelativo" :key="indexPeriodo">{{ periodo.tdco_periodo }}</option>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <br />
                                        <button type="submit" class="btn btn-primary">
                                            <span class="glyphicon glyphicon-search"></span>Buscar
                                        </button>
                                    </div>
                                </div>
                            </form>

                            <div class="box">
                                <div class="box-body">
                                    <pagination :data="archivadores" :limit="3" @pagination-change-page="buscarArchivador" />
                                    <table class="table table-bordered table-condensed table-hover table-sm">
                                        <thead class="bg-lightblue disabled color-palette pd-0">
                                            <tr class="info">
                                                <th nowrap>DESCRIPCION</th>
                                                <th nowrap>PERIODO</th>
                                                <th nowrap>ARCHIVADO_DE</th>
                                                <th nowrap>Editar</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(archivador, index) in archivadores.data" :key="index">
                                                <td nowrap>{{ archivador.arch_nombre }}</td>
                                                <td nowrap>{{ archivador.arch_periodo }}</td>
                                                <td nowrap>{{ archivador.adm_email }}</td>
                                                <td nowrap>
                                                    <!--EDITAR-->
                                                    <router-link v-if="getUsuario.id == archivador.id || archivador.arch_idusuarioa == null" :to="{ name: 'CataArchivadorEdit', params: { id: archivador.idarch } }">
                                                        <a class="btn btn-info btn-xs"><i class="fa fa-edit"></i></a>
                                                    </router-link>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <pagination :data="archivadores" :limit="3" @pagination-change-page="buscarArchivador" />
                                </div>
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
import LaravelVuePagination from 'laravel-vue-pagination'
import Vuex from 'vuex'
export default {

    data() {
        return {
            formData: {
                arch_nombre: null,
                arch_periodo: new Date().getFullYear(),
                idarch: null,
                page: null
            },
            mostrarArchivado: false,
            archivadores: {}

        }
    },

    components: {
        'Pagination': LaravelVuePagination,
    },

    computed: {
        ...Vuex.mapGetters(['getDependenciaUser', 'getPeriodosCorrelativo', 'getUsuario']),

    },

    created() {
        this.obtenerPeriodosCorrelativo();
        this.buscarArchivador()
    },
    methods: {
        ...Vuex.mapActions(['obtenerPeriodosCorrelativo']),

        buscarArchivador(page = 1) {
            // var url = '/tramite/documentoenproceso?page=' + page
            var url = '/archivador?page=' + page
            this.formData.page = page
            axios.get(url, {
                params: this.formData
            }).then(response => {
                this.archivadores = response.data
                this.mostrarArchivado = true
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
