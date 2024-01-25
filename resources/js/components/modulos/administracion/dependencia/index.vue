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
        <div class="container-fluid" v-if="is('SUPERADMIN')">
            <div class="row">
                <div class="col-lg-6 col-10">
                    <router-link :to="'/Administracion/dependencia/crear'" class="btn btn-info btn-sm"><i class="fa-solid fa-house-user"></i> Nueva dependencia</router-link>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="card card-primary card-outline ">
                        <div class="card-header p-1">
                            Dependencias
                        </div>
                        <div class="card-body">

                            <!-- {{-- para las opciones de busqueda --}} -->
                            <div class="row  mb-2">
                                <div class="col-md-2">
                                    <div class="group">
                                        <label for="" class="text-sm">Codigo dependencia</label>
                                        <input type="number" class="form-control form-control-sm">
                                    </div>
                                </div>

                                <div class="col-md-8">
                                    <div class="group">
                                        <label for="" class="text-sm">Nombre</label>
                                        <input type="text" class="form-control form-control-sm ">
                                    </div>
                                </div>
                                <div class="col-md-2"><label for=""></label>
                                    <button type="button" class="btn btn-block btn-primary btn-sm mt-1"><i data-feather="search" class="me-25"></i> Buscar</button>
                                </div>
                            </div>
                            <div class="row form-group pt-2 border-top">
                                <div class="demo-inline-spacing">
                                    <ul class="pagination pagination-sm m-0 float-left">
                                        <li class="page-item" v-if="pagination.current_page > 1">
                                            <a class="page-link" href="#" @click.prevent="cambiopagina(pagination.current_page-1)">«</a>
                                        </li>

                                        <li class="page-item" v-if="pagination.current_page > 5">
                                            <a class="page-link" href="#" @click.prevent="cambiopagina(1)">1</a>
                                        </li>

                                        <!-- mostrar los puntos -->
                                        <li class="page-item" v-if="pagination.current_page > 5">
                                            <a class="page-link">...</a>
                                        </li>

                                        <li class="page-item" v-for="page in pagesNumber" :key="page.id" :class="[page==isActived ? 'active':'']">
                                            <a class="page-link" href="#" @click.prevent="cambiopagina(page)">{{ page }}</a>
                                        </li>

                                        <!-- mostrar los puntos -->
                                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                            <a class="page-link">...</a>
                                        </li>

                                        <!-- MOSTRAR LA ULTIMA PAGINA -->
                                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                            <a class="page-link" href="#" @click.prevent="cambiopagina(pagination.last_page)">{{ pagination.last_page }}</a>
                                        </li>

                                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                            <a class="page-link" href="#" @click.prevent="cambiopagina(pagination.current_page+1)">»</a>
                                        </li>
                                    </ul>

                                </div>
                            </div>
                            <!-- {{-- para la relacion de datos --}} -->
                            <div class="row mt-2">
                                <table class=" table table-bordered table-condensed table-hover table-sm">
                                    <thead class="bg-info  disabled color-palette pd-0">
                                        <tr class="info">
                                            <th><small><strong>Codigo</strong></small></th>
                                            <th><small><strong>NOMBRE DEPENDENCIA</strong></small></th>
                                            <th><small><strong>CIUDAD</strong></small></th>
                                            <th><small><strong>DIRECCION</strong></small></th>

                                            <th><small><strong>ABREVIATURA</strong></small></th>

                                            <th><small><strong>ACCIONES</strong></small></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="depe in dependencias" :key="depe.iddependencia">

                                            <td><small>{{ depe.iddependencia }}</small></td>
                                            <td><small>{{ depe.depe_nombre }} </small></td>
                                            <td><small>{{ depe.depe_ciudad }} </small></td>
                                            <td><small>{{ depe.depe_direccion}} </small></td>
                                            <td><small>{{ depe.depe_abreviado }}</small></td>

                                            <td class="text-center">

                                                <router-link :to="{name:'Editar dependencias',params:{iddepe:depe.iddependencia }}" class="btn btn-primary btn-xs"><i class="fa-solid fa-house-flag"></i> Editar</router-link>
                                                <router-link :to="{name:'Listado oficinas',params:{iddep:depe.iddependencia }}" class="btn btn-info btn-xs"><i class="fa-solid fa-eye"></i> Oficinas</router-link>
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div class="card-footer clearfix">
                            <ul class="pagination pagination-sm m-0 float-left">
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <a class="page-link" href="#" @click.prevent="cambiopagina(pagination.current_page-1)">«</a>
                                </li>

                                <li class="page-item" v-if="pagination.current_page > 5">
                                    <a class="page-link" href="#" @click.prevent="cambiopagina(1)">1</a>
                                </li>

                                <!-- mostrar los puntos -->
                                <li class="page-item" v-if="pagination.current_page > 5">
                                    <a class="page-link">...</a>
                                </li>

                                <li class="page-item" v-for="page in pagesNumber" :key="page.id" :class="[page==isActived ? 'active':'']">
                                    <a class="page-link" href="#" @click.prevent="cambiopagina(page)">{{ page }}</a>
                                </li>

                                <!-- mostrar los puntos -->
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link">...</a>
                                </li>

                                <!-- MOSTRAR LA ULTIMA PAGINA -->
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiopagina(pagination.last_page)">{{ pagination.last_page }}</a>
                                </li>

                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiopagina(pagination.current_page+1)">»</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
        <div v-else class="container-fluid">
            <div class="row justify-content-center mt-2">
                <div class="col-lg-6 col-10">

                    <div class="alert alert-warning alert-dismissible">
                        <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> -->
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alerta!</h5>
                        Usted no tiene acceso a este módulo <br>
                        <router-link :to="'/'" class="btn btn-dark btn-xs text-decoration-none">
                            Salir de esta sección
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->

</div>
</template>

<script>
// import LaravelVuePagination from 'laravel-vue-pagination';

export default {

    data() {
        return {
            dependencias: {},
            pagination: {
                'total': 0,
                'current_page': 0,
                'per_page': 0,
                'last_page': 0,
                'from': 0,
                'to': 0
            },
            offset: 3,

        }
    },
    computed: {
        isActived: function () {
            return this.pagination.current_page;
        },
        pagesNumber: function () {
            if (!this.pagination.to) {
                return [];
            }
            var from = this.pagination.current_page - this.offset; //TODO offset
            if (from < 1) {
                from = 1;
            }

            var to = from + (this.offset * 2);
            if (to >= this.pagination.last_page) {
                to = this.pagination.last_page
            }

            var pagesarray = [];
            while (from <= to) {
                pagesarray.push(from);
                from++;
            }
            return pagesarray;
        },
    },

    created() {
        this.listauser()
    },
    methods: {
        listauser(page) {

            axios.get('/listardepe?page=' + page)
                .then(response => {
                    this.dependencias = response.data.listadepe.data
                    this.pagination = response.data.paginacion
                })
        },
        cambiopagina: function (page) {
            this.pagination.current_page = page;
            this.listauser(page);
        }

    }
}
</script>

<style lang="css" scoped>
/* .pagination{
        margin-bottom: 0;
    } */
</style>
