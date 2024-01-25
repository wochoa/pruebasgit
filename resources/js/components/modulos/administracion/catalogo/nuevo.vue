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
                            <router-link :to="'/catalogos'" :class="'nav-link'" id="index" data-toggle="pill" aria-controls="custom-content-above-home" aria-selected="false">
                                Explorar archivador
                            </router-link>
                        </li>
                        <li class="nav-item" v-if="$route.params.id == null">
                            <router-link :to="'/catalogos-nuevo'" :class="'nav-link active'" id="nuevo" data-toggle="pill" aria-controls="custom-content-above-home" aria-selected="true">
                                Nuevo archivador
                            </router-link>
                        </li>
                        <li class="nav-item" v-else>
                            <router-link :to="'#'" :class="'nav-link active'" id="nuevo" data-toggle="pill" aria-controls="custom-content-above-home" aria-selected="true">
                                Editar archivador
                            </router-link>
                        </li>

                    </ul>

                </div>
            </div>
            <div class="row justify-content-center mt-2">
                <div class="col-12 ">
                    <div class="card card-primary">
                        <!-- <div class="card-header">ARCHIVADORES</div> -->
                        <div v-if="$route.params.id == null" class="card-header">ARCHIVADORES</div>
                        <div v-else class="card-header">EDITAR ARCHIVADOR</div>
                        <div class="card-body">
                            <form action="" @submit.prevent="guardarArchivador()">
                                <div class="row form-group" style="width: 100%;margin-left: -0px;">
                                    <div class="col-sm-1">
                                        <label>Ambito:</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <input v-model="archivador.arch_idusuarioa" type="checkbox" /> Archivador Personal
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Unidad Organica:</label>
                                    </div>
                                    <div class="col-sm-1">
                                        <input type="text" :value="getDependenciaUser.idoficina" class="form-control" readonly />
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" :value="getDependenciaUser.nombreofi" class="form-control" readonly />
                                    </div>
                                </div>
                                <div v-if="archivador.arch_idusuarioa" class="row form-group" style="width: 100%;margin-left: -0px;">
                                    <div class="col-sm-1">
                                        <label>Usuario</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" :value="getUsuario.adm_name + ' ' + getUsuario.adm_lastname" class="form-control" readonly />
                                    </div>
                                </div>
                                <div class="row form-group" style="width: 100%;margin-left: -0px;">
                                    <div :class="'col-sm-7'">
                                        <label>Descripción</label>
                                        <input ref="nombre" v-model="archivador.arch_nombre" type="text" class="form-control text-uppercase" name="nombre" />

                                    </div>
                                    <div class="col-sm-3">
                                        <label>Periodo</label>
                                        <input v-model="archivador.arch_periodo" type="text" class="form-control" readonly />
                                    </div>
                                    <div class="col-sm-2">
                                        <br />
                                        <button v-if="$route.params.id == null" class="btn btn-primary" type="submit">Registrar</button>
                                        <button v-else class="btn btn-primary" type="submit">Actualizar</button>
                                    </div>
                                </div>
                            </form>

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
// import LaravelVuePagination from 'laravel-vue-pagination';
import Vuex from 'vuex'
export default {

    data() {
        return {
            archivador: {
                arch_nombre: null,
                arch_periodo: new Date().getFullYear(),
                arch_idusuarioa: false
            },
            edicionArchivador: true

        }
    },

    computed: {
        // ...Vuex.mapGetters(['getDependenciaUser', 'getPeriodosCorrelativo', 'getUsuario']),
        ...Vuex.mapGetters(['getDependenciaUser', 'getUsuario'])

    },
    mounted() {

        if (this.$route.params.id > 0 || this.$route.params.id != null) {
            this.obtenerArchivador()
        }
    },

    created() {

    },
    methods: {
        // ...Vuex.mapActions(['getuseroficina']),
        guardarArchivador() {
            // this.$validator.validate().then(result => {
            //     if (result) {
                    axios.post('/archivador', this.archivador).then(response => {
                        // console.log('guardado')
                        this.$store.dispatch('obtenerArchivadores');
                        this.$router.push('/catalogos')
                    })
                // } else {
                //     console.log('incompleto')
                // }
            // })
        },

        obtenerArchivador() {
            var url='/archivador/%s'
            axios
                .get(url.replace(/%s/g, this.$route.params.id))
                .then(response => (this.archivador = response.data))
        }

    }
}
</script>

<style lang="css" scoped>
/* .pagination{
                       margin-bottom: 0;
                   } */
</style>
