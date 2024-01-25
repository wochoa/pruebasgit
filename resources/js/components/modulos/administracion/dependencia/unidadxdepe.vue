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
                <div class="col-lg-6 col-10">
                    <!-- <router-link :to="'/Administracion/dependencia/'" class="btn btn-info btn-xs"><i class="fa-regular fa-circle-left"></i> Volver a dependencias</router-link> -->
                    <button data-toggle="modal" data-target="#oficina" class="btn btn-success btn-xs" @click.prevent="nuevaoficina()"><i class="fa-solid fa-house-chimney-medical"></i> Nueva oficina</button>
                </div>
            </div>
            <div class="card card-primary mt-2">
                <div class="card-header">UNIDAD ORGÁNICA</div>
                <div class="card-body">
                    <div class="col-md-12">
                        <form @submit.prevent="buscarUnidad()">
                            <div class="row form-group" style="width: 100%;margin-left: -0px;">
                                <!-- <p v-if="is('SUPERADMIN')">{{ definetipo(1) }}</p> -->
                                <div class="col-sm-4">
                                    <label for="">Código de Unidad Orgánica</label>
                                    <input v-model="formData.iddependencia" type="text" class="form-control form-control-sm" />
                                </div>
                                <div v-if="tipo == 1" class="col-sm-8">
                                    <label for="">Dependencia</label>
                                    <select v-model="formData.depe_depende" :disabled="!(tipo == 1)" class="form-control form-control-sm" @change="buscarUnidad()">
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
                                    <input v-model="formData.depe_nombre" type="text" class="form-control form-control-sm" @change="formData.depe_nombre = formData.depe_nombre.toUpperCase()" />
                                </div>
                                <div class="col-sm-5">
                                    <label for="">Representante</label>
                                    <input v-model="formData.depe_representante" type="text" class="form-control form-control-sm" @change="formData.depe_representante = formData.depe_representante.toUpperCase()" />
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
                                    <thead class="bg-lightblue disabled color-palette pd-0">
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
                                                <!-- <router-link :to="{
                                                                        name: tipo == 1 ? 'AdminUnidadOrganicaEdit' : 'AdminUnidadOrganicaEdit2',
                                                                        params: { id: dependencia.iddependencia }
                                                                    }">
                                                    <a class="btn btn-info fa fa-pencil"></a>
                                                </router-link> -->
                                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#oficina" @click.prevent="editandooficina(dependencia.iddependencia ,2)">
                                                    <i class="fa fa-edit"></i>
                                                </button>
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

    <!-- editar o nueva oficina -->
    <div class="modal fade" id="oficina">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header pt-1 pb-0" v-if="tipoedicion==2">
                    <h5 class="modal-title">Edicion de la unidad : <strong>{{ filloficina.nombre_oficina }}</strong> </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-close"></i>
                    </button>
                </div>
                <div class="modal-header pt-1 pb-0" v-else>
                    <h5 class="modal-title">Nueva oficina </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <div class="col-6">
                            <label for="">Nombre oficina:</label>
                            <input type="text" class="form-control form-control-sm form-control form-control-sm-sm text-uppercase" v-model="filloficina.nombre_oficina">
                        </div>
                        <div class="col-3">
                            <label for="">Abreviado oficina:</label>
                            <input type="text" class="form-control form-control-sm form-control form-control-sm-sm text-uppercase" v-model="filloficina.abreviado" placeholder="eje. SGMTI">
                        </div>
                        <div class="col-3">
                            <label for="">Siglas de Documentos:</label>
                            <input type="text" class="form-control form-control-sm form-control form-control-sm-sm text-uppercase" v-model="filloficina.siglas" placeholder="eje. GRC-GEPPAT/SGMTI">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            <label for="">DNI:</label>
                            <input type="text" class="form-control form-control-sm form-control form-control-sm-sm text-uppercase" v-model="filloficina.dni" @keyup="verificausuario()">
                        </div>
                        <div class="col-3">
                            <label for="">Representante:</label>
                            <input type="text" class="form-control form-control-sm form-control form-control-sm-sm text-uppercase" v-model="filloficina.representante">
                        </div>
                        <div class="col-3">
                            <label for="">Cargo:</label>
                            <input type="text" class="form-control form-control-sm form-control form-control-sm-sm text-uppercase" v-model="filloficina.cargo">
                        </div>
                        <div class="col-3">
                            <label for="">Re.Tramite:</label>
                            <div class="custom-control custom-radio">

                                <input type="radio" v-model="filloficina.recibetramite" value="1">
                                <label for="customRadio1">SI</label>

                                <input type="radio" v-model="filloficina.recibetramite" value="0">
                                <label for="customRadio1">NO</label>

                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            <label for="">Es MPV:</label>
                            <div class="custom-control custom-radio">
                                <input type="radio" v-model="filloficina.mpv" value="1">
                                <label for="customRadio1">SI</label>

                                <input type="radio" v-model="filloficina.mpv" value="0">
                                <label for="customRadio1">NO</label>
                            </div>
                        </div>
                        <div class="col-3">
                            <label for=""># Días.Máx.atención Exp:</label>
                            <input type="text" class="form-control form-control-sm form-control form-control-sm-sm" v-model="filloficina.diasmaxenproceso">
                        </div>
                        <div class="col-3">
                            <label for="">Estado:</label>
                            <select class="form-control form-control-sm form-control form-control-sm-sm">
                                <template v-if="filloficina.estado==1">
                                    <option value="1" selected>Activo</option>
                                    <option value="0">Desactivado</option>
                                </template>
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="">Observaciones:</label>
                            <input type="text" class="form-control form-control-sm form-control form-control-sm-sm" v-model="filloficina.observaciones">
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="exampleInputFile">Imagen cabecera(1856x199px)</label>
                                <input type="file" class="form-control form-control-sm form-control form-control-sm-sm" @change="cabecera($event )" accept="image/*">
                                <span>{{ filloficina.membrete }}</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="exampleInputFile">Imagen footer</label>
                                <input type="file" class="form-control form-control-sm form-control form-control-sm-sm" @change="footer($event)" accept="image/*">
                                <span>{{ filloficina.footer }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer text-right pt-1 pb-0">
                    <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
                    <button type="button" class="btn btn-primary float-right" @click="actualizar" v-if="tipoedicion==2">Actualizar</button>
                    <button type="button" class="btn btn-primary float-right" @click="guardarnuevo" v-else>Guardar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- fin modale -->

</div>
</template>

<script>
import Vuex from 'vuex'
import LaravelVuePagination from 'laravel-vue-pagination';

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
            default: 2
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
                tipo: 2, //this.tipo,
                page: null
            },
            mostrarUnidad: false,
            dependencias: [],

            filloficina: {
                idoficina: null,
                nombre_oficina: null,
                abreviado: null,
                siglas: null,
                representante: null,
                cargo: null,
                dni: null,
                depe_depende: '',
                superior: null,
                tipo: null,
                proyectado: null,
                estado: null,
                observaciones: null,
                recibetramite: null,
                diasmaxenproceso: null,
                mpv: null,
                membrete: null,
                footer: null
            },
            tipoedicion: 1,
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
                este.filloficina.depe_depende = este.getDependenciaUser.iddependencia
                este.buscarUnidad()
            }, 1500)
        }
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
        buscarUnidad(page = 1) {
            this.formData.page = page
            axios.get('/unidadesdepe', {
                params: this.formData
            }).then(response => {
                this.dependencias = response.data
                this.mostrarUnidad = true;
            })
        },
        guardarnuevo() {

            this.verifca();
            let formData = new FormData()
            var url = '/oficina/nueva';
            formData.append('cabecera', this.filloficina.membrete);

            formData.append('footer', this.filloficina.footer);

            formData.append("nombre_oficina", this.filloficina.nombre_oficina);
            formData.append("depe_depe", this.filloficina.depe_depende);
            formData.append("abreviado", this.filloficina.abreviado);
            formData.append("siglas", this.filloficina.siglas);
            formData.append("representante", this.filloficina.representante);
            formData.append("cargo", this.filloficina.cargo);
            formData.append("dni", this.filloficina.dni);
            formData.append("recibetramite", this.filloficina.recibetramite);
            formData.append("mpv", this.filloficina.mpv);
            formData.append("diasmaxenproceso", this.filloficina.diasmaxenproceso);
            formData.append("observaciones", this.filloficina.observaciones);
            formData.append("estado", this.filloficina.estado);

            // alert(this.errordatos.length)
            const valor = this.errordatos.length;

            if (valor > 0) {
                this.toast('Falta rellenar algunos datos', 'error');
                // $("#mensajeeeror").modal('show')
            } else {
                axios.post(url, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(response => {
                        // console.log(response.data)
                        $('#oficina').modal('hide');
                        this.buscarUnidad();
                        this.toast('Fue creado la Unidad exitosamente', 'success');
                    });
            }

        },
        actualizar() {
            this.verifca();
            let formData = new FormData()
            var url = '/oficina/update';
            formData.append('cabecera', this.filloficina.membrete);
            formData.append('footer', this.filloficina.footer);

            formData.append('idoficina', this.filloficina.idoficina);

            formData.append("nombre_oficina", this.filloficina.nombre_oficina);
            formData.append("depe_depe", this.filloficina.depe_depende);
            formData.append("abreviado", this.filloficina.abreviado);
            formData.append("siglas", this.filloficina.siglas);
            formData.append("representante", this.filloficina.representante);
            formData.append("cargo", this.filloficina.cargo);
            formData.append("dni", this.filloficina.dni);
            formData.append("recibetramite", this.filloficina.recibetramite);
            formData.append("mpv", this.filloficina.mpv);
            formData.append("diasmaxenproceso", this.filloficina.diasmaxenproceso);
            formData.append("observaciones", this.filloficina.observaciones);
            formData.append("estado", this.filloficina.estado);

            if (this.errordatos.length > 0) {
                this.toast('Falta rellenar algunos datos', 'error');
                // $("#mensajeeeror").modal('show')
            } else {
                axios.post(url, formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    })
                    .then(response => {
                        // console.log(response.data)
                        $('#oficina').modal('hide');
                        this.buscarUnidad();
                        this.toast('Fue actualizado la Unidad exitosamente', 'success');
                    });
            }

        },
        nuevaoficina() {
            this.tipoedicion = 1;
            this.filloficina.idoficina = null
            this.filloficina.nombre_oficina = null
            this.filloficina.abreviado = null
            this.filloficina.siglas = null
            this.filloficina.representante = null
            this.filloficina.cargo = null
            this.filloficina.dni = null
            this.filloficina.recibetramite = 0
            this.filloficina.mpv = 0
            this.filloficina.diasmaxenproceso = 30
            this.filloficina.observaciones = null
            this.filloficina.estado = 1
            this.filloficina.membrete = null
            this.filloficina.footer = null
        },
        cabecera(event) {
            this.filloficina.membrete = event.target.files[0];
        },
        footer(event) {
            this.filloficina.footer = event.target.files[0];
        },
        verificausuario() // verifica si existe en BD y devuelve el nombre completo para el representante de la oficina
        {
            var url = '/reniec/' + this.filloficina.dni

            axios.get(url)
                .then(res => {
                    // console.log(res.data)
                    this.filloficina.representante = res.data.prenombres + ' ' + res.data.apPrimer + ' ' + res.data.apSegundo

                })
        },
        verifca() {

            this.errordatos = [];
            if (this.filloficina.nombre_oficina == null) {
                this.errordatos.push('El campo de nombre está vacio');
            }
            if (this.filloficina.abreviado == null) {
                this.errordatos.push('El campo de abreviatura está vacio');
            }

            if (this.filloficina.siglas == null) {
                this.errordatos.push('El campo de siglas está vacio');
            }
            if (this.filloficina.dni == null) {
                this.errordatos.push('El campo de dni está vacio');
            }

            if (this.filloficina.representante == null) {
                this.errordatos.push('El campo de representante está vacio');
            }
            if (this.filloficina.cargo == null) {
                this.errordatos.push('El campo de cargo esta vacio');
            }
            if (this.filloficina.diasmaxenproceso == null) {
                this.errordatos.push('El campo de días máximo de atención está vacio');
            }
            if (this.filloficina.membrete == null) {
                this.errordatos.push('El campo de imagen cabecera está vacio');
            }
            if (this.filloficina.footer == null) {
                this.errordatos.push('El campo de imagen footer está vacio');
            }
        },
        editandooficina: function (id, tipo) { // id:2 SUB GERENCIA DE MODERNIZACION Y TRANSFORMACION DIGITAL
            //  alert(id);
            axios.get('/oficinas/unidad/' + id)
                .then((response) => {
                    this.datosoficina = response.data;
                    this.filloficina.idoficina = id
                    this.filloficina.nombre_oficina = this.datosoficina[0].depe_nombre
                    this.filloficina.abreviado = this.datosoficina[0].depe_abreviado
                    this.filloficina.siglas = this.datosoficina[0].depe_sigla
                    this.filloficina.representante = this.datosoficina[0].depe_representante
                    this.filloficina.cargo = this.datosoficina[0].depe_cargo
                    this.filloficina.dni = this.datosoficina[0].depe_dni
                    this.filloficina.recibetramite = this.datosoficina[0].depe_recibetramite
                    this.filloficina.mpv = this.datosoficina[0].depe_mesa_virtual
                    this.filloficina.diasmaxenproceso = this.datosoficina[0].depe_diasmaxenproceso //
                    this.filloficina.observaciones = this.datosoficina[0].depe_observaciones
                    this.filloficina.estado = this.datosoficina[0].depe_estado
                    this.filloficina.membrete = this.datosoficina[0].depe_imagen_header
                    this.filloficina.footer = this.datosoficina[0].depe_imagen_footer

                    //console.log(response.data)
                    this.tipoedicion = 2;
                })
        },
    }
}
</script>

<style scoped>
input,
textarea {
    text-transform: uppercase;
}
</style>
