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
                    <router-link :to="'/Administracion/dependencia/'" class="btn btn-info btn-xs"><i class="fa-regular fa-circle-left"></i> Volver a dependencias</router-link>
                    <button data-toggle="modal" data-target="#oficina" class="btn btn-success btn-xs" @click.prevent="nuevaoficina()"><i class="fa-solid fa-house-chimney-medical"></i> Nueva oficina</button>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="card card-primary card-outline ">
                        <div class="card-header p-1">
                            Dependencias: <strong>{{ nombredepe }}</strong>
                        </div>
                        <div class="card-body">

                            <!-- {{-- para las opciones de busqueda --}} -->
                            <div class="row  mb-2">
                                <div class="col-md-2">
                                    <div class="group">
                                        <label for="" class="text-sm">Codigo oficina</label>
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
                                            <th><small><strong>NOMBRE OFICINA</strong></small></th>

                                            <th><small><strong>ABREVIATURA</strong></small></th>
                                            <th><small><strong>REPRESENTANTE</strong></small></th>
                                            <th><small><strong>DEPENDENCIA</strong></small></th>

                                            <th><small><strong>ACCIONES</strong></small></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="depe in dependencias" :key="depe.iddependencia">

                                            <td class="text-xs">{{ depe.iddependencia }}</td>
                                            <td class="text-xs">{{ depe.depe_nombre }}</td>
                                            <td class="text-xs">{{ depe.depe_abreviado }}</td>
                                            <td class="text-xs">{{ depe.depe_representante }}<br>CARGO: {{ depe.depe_cargo }}</td>

                                            <td class="text-xs">{{ nombredepe }}</td>

                                            <td class="text-center" nowrap>

                                                <!-- <router-link :to="{name:'Editar dependencias',params:{id:depe.iddependencia }}" class="btn btn-primary btn-xs"><i class="fa-solid fa-house-flag"></i> Editar</router-link> -->
                                                <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#oficina" @click.prevent="editandooficina(depe.iddependencia,2)">
                                                    <i class="fa fa-edit"></i>
                                                </button>
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
    </div>
    <!-- /.content -->

    <!-- modales -->
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
                            <input type="text" name="" id="" class="form-control form-control-sm text-uppercase" v-model="filloficina.nombre_oficina">
                        </div>
                        <div class="col-3">
                            <label for="">Abreviado oficina:</label>
                            <input type="text" name="" id="" class="form-control form-control-sm text-uppercase" v-model="filloficina.abreviado" placeholder="eje. SGMTI">
                        </div>
                        <div class="col-3">
                            <label for="">Siglas de Documentos:</label>
                            <input type="text" name="" id="" class="form-control form-control-sm text-uppercase" v-model="filloficina.siglas" placeholder="eje. GRC-GEPPAT/SGMTI">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-3">
                            <label for="">DNI:</label>
                            <input type="text" name="" id="" class="form-control form-control-sm text-uppercase" v-model="filloficina.dni" @keyup="verificausuario()">
                        </div>
                        <div class="col-3">
                            <label for="">Representante:</label>
                            <input type="text" name="" id="" class="form-control form-control-sm text-uppercase" v-model="filloficina.representante">
                        </div>
                        <div class="col-3">
                            <label for="">Cargo:</label>
                            <input type="text" name="" id="" class="form-control form-control-sm text-uppercase" v-model="filloficina.cargo">
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
                            <input type="text" name="" id="" class="form-control form-control-sm" v-model="filloficina.diasmaxenproceso">
                        </div>
                        <div class="col-3">
                            <label for="">Estado:</label>
                            <select name="" id="" class="form-control form-control-sm">
                                <template v-if="filloficina.estado==1">
                                    <option value="1" selected>Activo</option>
                                    <option value="0">Desactivado</option>
                                </template>
                            </select>
                        </div>
                        <div class="col-3">
                            <label for="">Observaciones:</label>
                            <input type="text" name="" id="" class="form-control form-control-sm" v-model="filloficina.observaciones">
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="exampleInputFile">Imagen cabecera(1856x199px)</label>
                                <input type="file" class="form-control form-control-sm" @change="cabecera($event )" accept="image/*">
                                <span>{{ filloficina.membrete }}</span>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="exampleInputFile">Imagen footer</label>
                                <input type="file" class="form-control form-control-sm" @change="footer($event)" accept="image/*">
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
            dependencias: {},
            iddepe: this.$attrs.iddep,
            nombredepe: '',
            pagination: {
                'total': 0,
                'current_page': 0,
                'per_page': 0,
                'last_page': 0,
                'from': 0,
                'to': 0
            },
            offset: 2,

            filloficina: {
                idoficina: null,
                nombre_oficina: null,
                abreviado: null,
                siglas: null,
                representante: null,
                cargo: null,
                dni: null,
                depe_depende: this.$attrs.iddep,
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
            tipoedicion: 1, //1: nueva oficina, 2: editar oficina

            datosoficina: [],
            errordatos: []

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
        this.listaroficina()
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
        listaroficina(page) {

            axios.get('/oficinas/' + this.$attrs.iddep + '?page=' + page) // CONSULTA DE OFICINAS DE LA DEPENDENCIA 3 P.E
                .then(response => {
                    this.dependencias = response.data.listadepe.data // LISTA DE OFICINA DE LA DEPENDENDENCIA 3 P.E
                    this.nombredepe = response.data.nombre_dependencia // nombredepe= SEDE CENTRAL
                    this.pagination = response.data.paginacion
                })
        },
        cambiopagina: function (page) {
            this.pagination.current_page = page;
            this.listaroficina(page);
        },
        editandooficina: function (id,tipo) { // id:2 SUB GERENCIA DE MODERNIZACION Y TRANSFORMACION DIGITAL
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
                        this.listaroficina();
                        this.toast('Fue creado la Unidad exitosamente', 'success');
                    });
            }

        },
        cabecera(event) {
            this.filloficina.membrete = event.target.files[0];
        },
        footer(event) {
            this.filloficina.footer = event.target.files[0];
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
                        this.listaroficina();
                        this.toast('Fue actualizado la Unidad exitosamente', 'success');
                    });
            }

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
        verificausuario()// verifica si existe en BD y devuelve el nombre completo para el representante de la oficina
        {
            var url = '/reniec/' + this.filloficina.dni

            axios.get(url)
                .then(res => {
                    // console.log(res.data)
                    this.filloficina.representante = res.data.prenombres+' '+res.data.apPrimer + ' ' + res.data.apSegundo
                    
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
