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
        <div class="container-fluid" v-if="is('SUPERADMIN | ADMINISTRADOR')">
            <div class="row">
                <div class="col-sm-6">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <router-link :to="'/Administracion/Publicaciones'" class="nav-link active" id="index" data-toggle="pill" aria-controls="custom-content-above-home" aria-selected="true">
                                VER PUBLICACIONES
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="'/Publicaciones-create'" class="nav-link" id="nuevo" data-toggle="pill" aria-controls="custom-content-above-profile" aria-selected="true">
                                NUEVA PUBLICACION
                            </router-link>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="row justify-content-center mt-2">
                <div class="col-sm-12">
                    <div class="card card-primary">
                        <div class="card-header">PUBLICACIONES</div>
                        <div class="card-body"></div>
                        <div class="box">
                            <pagination :data="publicaciones" :limit="3" @pagination-change-page="buscarPublicaciones" />
                            <table class="table table-bordered table-condensed table-hover">
                                <thead>
                                    <tr class="info">
                                        <th style="font-size:13px; font-family: Tahoma" nowrap>ID</th>
                                        <th style="font-size:13px; font-family: Tahoma" nowrap>SUSTENTO</th>
                                        <th style="font-size:13px; font-family: Tahoma" nowrap>IMAGEN</th>
                                        <th style="font-size:13px; font-family: Tahoma" nowrap>F. INICIO</th>
                                        <th style="font-size:13px; font-family: Tahoma" nowrap>F. FIN</th>
                                        <th style="font-size:13px; font-family: Tahoma" nowrap>ESTADO</th>
                                        <th style="font-size:13px; font-family: Tahoma" nowrap>Editar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(publi, index) in publicaciones.data" :key="index">
                                        <td style="font-size:13px; font-family: Tahoma" nowrap>{{ publi.id }}</td>
                                        <td style="font-size:13px; font-family: Tahoma" nowrap>{{ publi.sustento }}</td>
                                        <td style="font-size:13px; font-family: Tahoma" nowrap>
                                            <img :src="publicarImagenes(publi.id)" alt="" height="80" />
                                        </td>
                                        <td style="font-size:13px; font-family: Tahoma" nowrap>{{ publi.fecha_inicio }}</td>
                                        <td style="font-size:13px; font-family: Tahoma" nowrap>{{ publi.fecha_fin }}</td>
                                        <td style="font-size:13px; font-family: Tahoma" nowrap>
                                            {{ publi.estado == 1 ? 'Activo' : 'Inactivo' }}
                                        </td>
                                        <td style="font-size:13px; font-family: Tahoma" nowrap>
                                            <router-link :to="{ name: 'Editar publicación', params: { id: publi.id } }">
                                                <a class="btn btn-info fa fa-pencil" title="Editar"></a>
                                            </router-link>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <pagination :data="publicaciones" :limit="3" @pagination-change-page="buscarPublicaciones" />
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
import LaravelVuePagination from 'laravel-vue-pagination';
export default {
    data() {
        return {
            formData: {
                page: null
            },
            publicaciones: {}
        }
    },
    components: {
        'Pagination': LaravelVuePagination,
    },

    mounted() {
        this.buscarPublicaciones()
    },

    methods: {
        buscarPublicaciones(page = 1) {
            this.formData.page = page
            axios.get('/comunicacionInterna/index', {
                params: this.formData
            }).then(response => {
                this.publicaciones = response.data
            })
        },

        publicarImagenes(id) {
            var url = '/comunicacionInterna/print/%s'
            return url.replace(/%s/g, id)
        }
    }
}
</script>

<style lang="css" scoped>
/* .pagination{
            margin-bottom: 0;
        } */
</style>
