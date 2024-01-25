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
                            <router-link :to="'/Administracion/tipodocumentos'" class="nav-link active" id="index" data-toggle="pill" aria-controls="custom-content-above-home" aria-selected="true">
                                EXPLORAR TIPO DE DOCUMENTOS
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="'/tipoDocumento-create'" class="nav-link" id="nuevo" data-toggle="pill" aria-controls="custom-content-above-profile" aria-selected="true">
                                NUEVO TIPO DOCUMENTO
                            </router-link>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="card card-primary">
                <div class="card-header">TIPOS DE DOCUMENTOS</div>
                <div class="card-body">
                    <div class="col-md-12">
                        <form action="" @submit.prevent="buscarTipoDocumento()">
                            <div class="form-group">
                                <div class="input-group">
                                    <input v-model="formData.tdoc_descripcion" type="text" class="form-control" @change="formData.tdoc_descripcion = formData.tdoc_descripcion.toUpperCase()" />
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-primary">
                                            <span class="glyphicon glyphicon-search"></span> Buscar
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </form>
                        <div class="box">
                            <div class="box-body">
                                <table class="table table-bordered table-condensed table-hover table-sm">
                                    <thead class="bg-lightblue disabled color-palette pd-0">
                                        <tr class="info">
                                            <th  nowrap>ID</th>
                                            <th  nowrap>DESCRIPCION</th>
                                            <th  nowrap>ABREVIATURA</th>
                                            <th  nowrap>FORMATO</th>
                                            <th  nowrap>USADO MPV</th>
                                            <th  nowrap>EDITAR</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(tipo, index) in tipoDocumentos.data" :key="index">
                                            <td >{{ tipo.idtdoc }}</td>
                                            <td >{{ tipo.tdoc_descripcion }}</td>
                                            <td >{{ tipo.tdoc_abreviado }}</td>
                                            <td >{{ tipo.nombre_archivo }}</td>
                                            <td >{{ tipo.tdoc_mpv?'SI':'NO' }}</td>
                                            <td>
                                                <!--EDITAR-->
                                                <router-link :to="{ name: 'Editar tipo documento', params: { id: tipo.idtdoc } }">
                                                    <a class="btn btn-info btn-xs fa fa-pencil"></a>
                                                </router-link>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <pagination :data="tipoDocumentos" :limit="3" @pagination-change-page="buscarTipoDocumento" />
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
import LaravelVuePagination from 'laravel-vue-pagination';

export default {

    props: {
        routeTipo: {
            type: String,
            default: ''
        },
        limit: {
            type: Number,
            default: 3
        }
    },

    data() {
        return {
            formData: {
                tdoc_descripcion: null,
                page: null
            },
            mostrarTipo: false,
            tipoDocumentos: {}
        }
    },
    components: {
        'Pagination': LaravelVuePagination,
    },

    created: function () {
        this.buscarTipoDocumento()
    },

    methods: {
        buscarTipoDocumento(page = 1) {
            var url = '/tipoDocumento'
            this.formData.page = page
            axios.get(url, {
                params: this.formData
            }).then(response => {
                this.tipoDocumentos = response.data
                this.mostrarTipo = true
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
