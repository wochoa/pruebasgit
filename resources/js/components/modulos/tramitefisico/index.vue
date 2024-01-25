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

            <div class="row justify-content-center mt-2">
                <div class="col-8 ">
                    <div class="card card-primary">
                        <div class="card-header p-1">
                            Recepción de trámite
                        </div>
                        <div class="card-body">
                            <div class="form-group row">
                                <div class=" col-md-3">
                                    <label for="tipo">Tipo documento<span style="color:#FF0000">(*)</span></label>
                                    <select class="form-control form-control-sm" v-model="formtramite.tipo">
                                        <option value=1>DNI</option>
                                        <option value=0>RUC</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="Numero de documento">Numero de documento <span style="color:#FF0000">(*)</span></label>
                                    <input v-model="formtramite.numero" type="text" class="form-control form-control-sm" name="Numero de documento" placeholder="Numero de documento" @keypress.enter.prevent.stop="validar" />

                                </div>
                                <div class="col-md-3 pt-4" id="validoc">
                                    <button class="btn btn-primary btn-sm" v-if="formtramite.tipo == 1" @click="validar">Validar con RENIEC</button>

                                    <button class="btn btn-danger btn-sm" v-else @click="validar">Validar con SUNAT</button>

                                </div>
                            </div>
                            <div class="row">
                                <!-- <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">DNI</label>
                                        <input type="number" class="form-control text-uppercase" v-model="formtramite.dni" @keyup.enter="validareniec">
                                    </div>
                                </div> -->
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="">NOMBRE</label>
                                        <input type="text" class="form-control text-uppercase" v-model="formtramite.nombres">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">TELEFONO</label>
                                        <input type="number" class="form-control" v-model="formtramite.telefono">
                                    </div>
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group">
                                        <label for="">DIRECCION</label>
                                        <input type="text" class="form-control text-uppercase" v-model="formtramite.direccion">
                                    </div>
                                </div>
                            </div>
                            <div class="form-gorup text-center">
                                <button class="btn btn-success btn-sm" @click="generar" :disabled="habilitarboton">Generar registro</button>
                            </div>

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

    <!-- midal resultados con registro de documento y expediente -->
    <div class="modal fade" id="resultadotram">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center">
                        <h3>Registro generado</h3>
                    </div>
                    <h4>
                        <b>REGISTRO DOCUMENTO: {{ ('00000000' + resultado.documento).slice(-8) }} </b>
                    </h4>
                    <h4>
                        <b>REGISTRO EXPEDIENTE: {{ ('00000000' + resultado.expediente).slice(-8) }}</b>
                    </h4>
                </div>
                <div class="modal-footer float-right p-1">
                    <router-link :to="'/Tramites/'+resultado.documento+'/Editar'" class="btn btn-info" data-dismiss="modal"> <i class="fa-solid fa-pen-to-square"></i> Editar trámite</router-link>
                    <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fa-solid fa-arrow-right-from-bracket"></i>Cerrar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</div>
</template>

<script>
// import LaravelVuePagination from 'laravel-vue-pagination';
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

    data() {
        return {
            formtramite: {
                numero: null,
                nombres: null,
                telefono: null,
                direccion: null,
                tipo:1,
                // docu_firma:null,
                // docu_detalle:null,
                // docu_telef:null,
                correo:null
            },
            errordatos: [],
            resultado: {
                documento: null,
                expediente: null
            },
            habilitarboton: false

        }
    },
    computed: {

    },

    created() {

    },
    methods: {
        toast(texto_anuncio, icono) {

            Toast.fire({
                // title:texto_titulo,
                title: '<small><strong>' + texto_anuncio + '</strong></small>',
                icon: icono,
                // text: texto_anuncio
            });
        },
        generar() {
            this.habilitarboton = true
            this.verifca();
            var url = '/generatramitemesapartes';

            if (this.errordatos.length > 0) {
                this.toast('Falta rellenar algunos datos', 'error');
                // $("#mensajeeeror").modal('show')
                this.habilitarboton = false
            } else {
                axios.post(url, this.formtramite)
                    .then(res => {
                        // console.log(res.data)
                        // this.$router.push({
                        //     path: '/Administracion/dependencia'
                        // });
                        this.resultado.documento = res.data.documento;
                        this.resultado.expediente = res.data.expediente;
                        this.limpiar();
                        // $('#resultadotram').modal('show')
                        $('#resultadotram').modal({
                            backdrop: 'static',
                            keyboard: false
                        })
                        this.toast('Fue creado el trámite exitosamente', 'success');
                        this.habilitarboton = false
                    })
            }
        },
        // validareniec() {
        //     var url = '/reniec/' + this.formtramite.numero

        //     axios.get(url)
        //         .then(res => {
        //             // console.log(res.data)
        //             this.formtramite.nombres = res.data.prenombres + ' ' + res.data.apPrimer + ' ' + res.data.apSegundo
        //             this.formtramite.direccion = res.data.direccion
        //             this.formtramite.telefono = res.data.telefono
        //         })
        // },

        verifca() {
            this.errordatos = [];
            if (this.formtramite.numero == null) {
                this.errordatos.push('El campo de dni esta vacio');
            }
            if (this.formtramite.nombres == null) {
                this.errordatos.push('El campo de nombres esta vacio');
            }

            if (this.formtramite.telefono == null) {
                this.errordatos.push('El campo de teléfono esta vacio');
            }
            if (this.formtramite.direccion == null) {
                this.errordatos.push('El campo de dirección esta vacio');
            }

        },
        limpiar() {
            this.formtramite.numero = null
            this.formtramite.nombres = null
            this.formtramite.telefono = null
            this.formtramite.direccion = null
        },
        validar() {
            if (this.formtramite.tipo == 1) { // cuando es con DNI
                this.formtramite.docu_detalle = 'PERSONA NATURAL'
                const params={'dni':this.formtramite.numero}
                axios.post('/reniec', params)
                    .then(res => {
                        // console.log(res.data)
                        this.formtramite.nombres = res.data.prenombres + ' ' + res.data.apPrimer + ' ' + res.data.apSegundo
                        this.formtramite.direccion = res.data.direccion
                        // this.formtramite.docu_domic=res.data.direccion
                        if (res.data.telefono) {
                            this.formtramite.telefono = res.data.telefono
                        }
                        if (res.data.correo) {
                            this.formtramite.correo = res.data.correo
                        }
                        if (res.data.error) {
                            this.toast(res.data.error, 'error');
                        }
                    })

            } else { // cuando es con RUC
                const params={'ruc':this.formtramite.numero}
                axios.post('/sunat', params)
                    .then(res => {
                        // console.log(res.data)
                        this.formtramite.nombres = res.data.ddp_nombre
                        this.formtramite.direccion = res.data.ddp_nomvia + ' - ' + res.data.ddp_refer1
                        if (res.data.telefono) {
                            this.formtramite.telefono = res.data.telefono
                        }
                        if (res.data.correo) {
                            this.formtramite.correo = res.data.correo
                        }
                        if (res.data.error) {
                            this.toast(res.data.error, 'error');
                        }
                    })

            }
        },
    },
        

    
}
</script>

<style lang="css" scoped>
/* .pagination{
           margin-bottom: 0;
       } */
</style>
