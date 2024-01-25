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
                            Nueva dependencias
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
                            <!-- <div class="row form-group" style="width: 100%; margin-left: 0px;">
                                <div class="col-sm-6">
                                    <label class="control-label">Logo header de Dependencia(1856x199 pixeles)</label>
                                    <input type="file" name="imagen_header" accept=".JPG,.PNG" class="form-control" >
                                </div>
                                <div class="col-sm-6">
                                    <label class="control-label">Pie de Página de Dependencia(1856x199 pixeles)</label>
                                    <input type="file" name="imagen_footer" accept=".JPG,.PNG" class="form-control">
                                </div>
                            </div> -->
                            <div class="row form-group" style="width: 100%; margin-left: 0px;">
                                <div class="col-sm-4">
                                    <label for="">Ciudad(*):</label>
                                    <input type="text" name="ciudad" class="form-control text-uppercase" v-model="formdepe.ciudad">
                                </div>
                                <div class="col-sm-8">
                                    <label for="">Dirección(*):</label>
                                    <!-- <input type="checkbox" class="checkbox-inline" v-model="formdepe.direccion"> -->
                                    <input type="text" name="ciudad" class="form-control text-uppercase" v-model="formdepe.direccion">
                                </div>
                            </div>

                            <div class="row">
                                <label for="" class="col-sm-4">La dependencia es externa:</label>
                                <div class="form-check col-sm-2">
                                    <input class="form-check-input" type="radio" name="radio1" v-model="formdepe.externo" value="2">
                                    <label class="form-check-label">si</label>
                                </div>
                                <div class="form-check col-sm-2">
                                    <input class="form-check-input" type="radio" name="radio1" v-model="formdepe.externo" value="0">
                                    <label class="form-check-label">No</label>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer clearfix text-center">
                            <button class="btn btn-success btn-sm" @click="guadardepe"><i class="fa fa-save"></i> GUARDAR</button>
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
                nomdepe: null,
                abreviatura: null,
                estado: '',
                ciudad: null,
                agente: null,
                direccion: null,
                externo: 0, //2=externo, 1:unidad orgnaica, 0:depedencia del gore
                // header:null,
                // footer:null,
            },
            errordatos: []

        }
    },

    created() {},
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
        guadardepe() {
            var url = '/nuevodependencia'
            this.verifca();
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
                        this.toast('Fue creado la dependencia exitosamente', 'success');

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

            if (this.formdepe.estado == '') {
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
