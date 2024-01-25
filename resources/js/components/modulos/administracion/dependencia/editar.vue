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
                <div class="col-sm-4">
                    <button class="btn btn-info btn-sm " @click="retroceder()"><i class="fa-regular fa-circle-left"></i> Volver</button>
                </div>
            </div>
            <div class="row mt-2">

                <div class="col-md-12">
                    <div class="card card-primary card-outline ">
                        <div class="card-header p-1">
                            Editar dependencias
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-froup">
                                        <label for="">Nombre de la Dependencia(*)</label>
                                        <input type="text" class="form-control form-control-sm text-uppercase" v-model="formdepe.nomdepe">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-froup">
                                        <label for="">Nombre Abreviado(*)</label>
                                        <input type="text" class="form-control form-control-sm text-uppercase" v-model="formdepe.abreviatura">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">Estado(*)</label>
                                        <select class="form-control form-control-sm" v-model="formdepe.estado">
                                            <option value="">Seleccione opción</option>
                                            <option value="1">Activo</option>
                                            <option value="2">Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row form-group" style="width: 100%; margin-left: 0px;">
                                <div class="col-sm-4">
                                    <label for="">Ciudad(*)</label>
                                    <input type="text" name="ciudad" class="form-control text-uppercase" v-model="formdepe.ciudad">
                                </div>
                                <div class="col-sm-8">
                                    <label for="">Dirección(*):</label>
                                    <!-- <input type="checkbox" class="checkbox-inline" v-model="formdepe.direccion"> -->
                                    <input type="text" name="ciudad" class="form-control text-uppercase" v-model="formdepe.direccion">
                                </div>
                            </div>

                        </div>
                        <div class="card-footer clearfix text-center">
                            <button class="btn btn-success btn-sm" @click="actualizar"><i class="fa fa-save"></i> GUARDAR</button>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

    <div class="modal fade" id="mensajeeeror">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="callout callout-danger" v-for="erro in errordatos">
                        <h5>{{ erro }}</h5>
                    </div>
                </div>
                <div class="modal-footer float-right p-1">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</div>
</template>

<script>
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
    name: '',
    data() {
        return {
            formdepe: {
                iddepe: this.$attrs.iddepe,
                nomdepe: null,
                abreviatura: null,
                estado: null,
                ciudad: null,
                direccion: null,
                // header:null,
                // footer:null,
            },
            errordatos: []

        }
    },
    props: [],
    components: {

    },
    created() {
        this.buscardepe();
    },
    mounted() {},
    methods: {
        toast(texto_anuncio, icono) {

            Toast.fire({
                // title:texto_titulo,
                title: '<small><strong>' + texto_anuncio + '</strong></small>',
                icon: icono,
                // text: texto_anuncio
            });
        },
        buscardepe() {
            var url = '/dependencia/' + this.formdepe.iddepe;
            axios.get(url)
                .then(res => {
                    // console.log(res.data);
                    // this.formdepe=res.data;
                    this.formdepe.nomdepe = res.data[0].depe_nombre;
                    this.formdepe.estado = res.data[0].depe_estado;
                    this.formdepe.abreviatura = res.data[0].depe_abreviado;
                    this.formdepe.ciudad = res.data[0].depe_ciudad;
                    this.formdepe.direccion = res.data[0].depe_direccion;

                });

        },
        actualizar() {
            this.verifca();
            var url = '/dependencia/update';

            if (this.errordatos.length > 0) {
                this.toast('Falta rellenar algunos datos', 'error');
                // $("#mensajeeeror").modal('show')
            } else {
                axios.post(url, this.formdepe)
                    .then(res => {
                        // console.log(res.data)
                        this.$router.push({
                            path: '/Administracion/dependencia'
                        });
                        this.toast('Fue actualizado la dependencia exitosamente', 'success');

                    })
            }

        },
        verifca() {
            this.errordatos = [];
            if (this.formdepe.nomdepe == null) {
                this.errordatos.push('El campo de dependencia esta vacio');
            }
            if (this.formdepe.abreviatura == null) {
                this.errordatos.push('El campo de abreviatura esta vacio');
            }

            if (this.formdepe.estado == null) {
                this.errordatos.push('El campo de estado esta vacio');
            }
            if (this.formdepe.ciudad == null) {
                this.errordatos.push('El campo de ciudad esta vacio');
            }
            if (this.formdepe.direccion == null) {
                this.errordatos.push('El campo de direccion esta vacio');
            }
        },

        retroceder() {
            window.history.back();
        }
    }
}
</script>

<style lang="css" scoped>

</style>
