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
                            <router-link :to="'/Administracion/Publicaciones'" class="nav-link" id="index" data-toggle="pill" aria-controls="custom-content-above-home" aria-selected="false">
                                VER PUBLICACIONES
                            </router-link>
                        </li>
                        <li class="nav-item">
                            <router-link :to="'/Publicaciones-create'" class="nav-link active" id="nuevo" data-toggle="pill" aria-controls="custom-content-above-profile" aria-selected="true">
                                NUEVA PUBLICACION
                            </router-link>
                        </li>

                    </ul>
                </div>
            </div>
            <div class="row justify-content-center mt-2">
                <div class="col-sm-12">
                    <form @submit.prevent="guardarPublicacion()">
                        <div class="card card-primary">
                            <div class="card-header">LLENE LOS DATOS DE LA NUEVA PUBLICACIÓN</div>
                            <div class="card-body">
                                <div class="form-group row mb-0" >
                                    <div :class="'col-sm-6'">
                                        <label class="control-label">Contenido del comunicado</label>
                                        <input ref="sustento" v-model="publicacion.sustento" type="text" class="form-control form-control-sm" name="sustento"/>
                                        <!-- <span v-show="errors.has('sustento')" class="help-block">{{ errors.first('sustento') }}</span> -->
                                    </div>
                                    <div class="col-sm-6">
                                        <br />
                                        <p>
                                            <strong>Las imagenes deberan de tener una resolución de 482(ancho)x640(alto) px. Esto para que se visualice correctamente
                                                en la portada y no atentar contra el rendimiento del Portal web</strong>
                                        </p>
                                        <br />
                                    </div>
                                </div>
                                <div class="form-group row" >
                                    
                                        <label class="control-label">Url:</label>
                                        <div class="col-sm-10">
                                            <input ref="sustento" v-model="publicacion.url" type="text" class="form-control form-control-sm"/>
                                        </div>                                    
                                </div>
                                <div class="form-group row" style="width: 100%;margin-left: -0px;">
                                    <div :class="'col-sm-2'">
                                        <label class="control-label">Inicio difusión</label>
                                        <input ref="fecha_inicio" v-model="publicacion.fecha_inicio" type="date" class="form-control form-control-sm" name="fecha_inicio" />
                                        <!-- <span v-show="errors.has('fecha_inicio')" class="help-block">{{ errors.first('fecha_inicio') }}</span> -->
                                    </div>
                                    <div :class="'col-sm-2'">
                                        <label class="control-label">Fin difusión</label>
                                        <input ref="fecha_fin" v-model="publicacion.fecha_fin" type="date" class="form-control form-control-sm" name="fecha_fin" />
                                        <!-- <span v-show="errors.has('fecha_fin')" class="help-block">{{ errors.first('fecha_fin') }}</span> -->
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Estado</label>
                                        <select v-model="publicacion.estado" class="form-control form-control-sm">
                                            <option :value="null">Seleccione</option>
                                            <option value="1">Activo</option>
                                            <option value="2">Inactivo</option>
                                        </select>
                                    </div>
                                    <div :class="'col-sm-4'">
                                        <label class="control-label">Imagen</label>
                                        <input ref="imagen" class="form-control form-control-sm" type="file" name="imagen" accept="image/jpg, image/png" @change="processFile($event)" />

                                        <!-- <span v-show="errors.has('imagen')" class="help-block">{{ errors.first('imagen') }}</span> -->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-primary">
                            <div class="panel-body text-right">
                                <button class="btn btn-primary" type="submit">Registrar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

</div>
</template>

<script>
// import LaravelVuePagination from 'laravel-vue-pagination';
export default {
    data() {
        return {
            publicacion: {
                id: null,
                id_solicitante: this.usuario.id,
                sustento: null,
                imagen: null,
                fecha_inicio: null,
                fecha_fin: null,
                url:null,
                estado: null
            }
        }
    },

    props: ['usuario'],

    mounted() {
        if (this.$route.params.id > 0 || this.$route.params.id != null) this.obtenerPublicacion()
    },

    methods: {
        processFile(event) {
            this.publicacion.imagen = event.target.files[0]
        },

        guardarPublicacion() {
            var urlref='/comunicacionInterna/create'
            // this.$validator.validate().then(result => {
                // if (result) {
                    let f = new FormData()
                    f.append('id', this.publicacion.id)
                    f.append('id_solicitante', this.publicacion.id_solicitante)
                    f.append('sustento', this.publicacion.sustento)
                    f.append('imagen', this.publicacion.imagen)
                    f.append('fecha_inicio', this.publicacion.fecha_inicio)
                    f.append('fecha_fin', this.publicacion.fecha_fin)
                    f.append('estado', this.publicacion.estado)
                    f.append('url', this.publicacion.url)
                    axios.post(urlref, f, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(response => {
                        // console.log('guardado')
                        this.$router.push('/Administracion/Publicaciones')
                    })
                // } else {
                //     console.log('incompleto')
                // }
            // })
        },

        obtenerPublicacion() {
            var url='/comunicacionInterna/%s'
            axios.get(url.replace(/%s/g, this.$route.params.id)).then(response => {
                this.publicacion = response.data
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
