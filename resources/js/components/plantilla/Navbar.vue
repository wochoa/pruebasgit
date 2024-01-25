<template>
<div>
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light dropdown-legacy text-sm">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <!-- <div v-if="is('index_mpv')"> -->
            <!-- Show admin tools -->
            <!-- <li class="nav-item d-none d-sm-inline-block">
                    <router-link :to="'/'" class="nav-link">Inicio</router-link>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <router-link :to="'/'" class="nav-link">Buscar Documento</router-link>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <router-link :to="'/'" class="nav-link">Reportes</router-link>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <router-link :to="'/'" class="nav-link">Archivadores</router-link>
                </li> -->

            <!-- </div> -->
            <!-- <li class="nav-item d-none d-sm-inline-block">
                <a href="#" @click="muestramodal" class="nav-link">Cambiar dependencia </a>
            </li> -->
            <li class="nav-item d-none d-sm-inline-block">
                <a href="#" @click="muestramodal" class="nav-link"> <b>Oficina actual:</b> {{ $store.state.ofiseleccionado.nombreofi }}</a>
            </li>

        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Navbar Search -->
            <!-- <li class="nav-item">
                <a class="nav-link" data-widget="navbar-search" href="#" role="button">
                    <i class="fas fa-search"></i>
                </a>
                <div class="navbar-search-block">
                    <form class="form-inline">
                        <div class="input-group input-group-sm row">
                            <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                            <div class="input-group-append">
                                <button class="btn btn-navbar" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                                <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </li> -->

            <!-- Notifications Dropdown Menu -->
            <!-- <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#" >
                    <i class="far fa-bell"></i>
                    <span class="badge badge-warning navbar-badge">15</span>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" >
                    <span class="dropdown-item dropdown-header">15 Notifications</span>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-envelope mr-2"></i> 4 new messages
                        <span class="float-right text-muted text-sm">3 mins</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-users mr-2"></i> 8 friend requests
                        <span class="float-right text-muted text-sm">12 hours</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li> -->
            <li class="nav-item pr-2">
                <!-- <input type="text" v-model="getCodigoBusqueda" class="form-control form-control-sm" placeholder="Buscar documento" @keyup.enter="buscarDocumento"> -->
                <input type="text" v-model="getCodigoBusqueda" class="form-control form-control-sm" placeholder="Buscar documento" @keyup.enter="buscarDocumentoPopup">
            </li>
            <li class="nav-item pr-1">
                <button class="btn btn-sm btn-warning" @click="buscarDocumentoPopup()">Documento</button>
            </li>
            <li class="nav-item">
                <button class="btn btn-sm btn-info" @click="buscarExpedientePopup()">Expediente</button>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                    <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <li class="nav-item" v-if="mode==0">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button" @click="cambiomodooscuro">
                    <i class="fa-regular fa-moon"></i>
                </a>
            </li>
            <li class="nav-item" v-else>
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button" @click="cambiomodoclaro">
                    <i class="fa-solid fa-sun"></i>
                </a>
            </li>
            <!-- <li class="nav-item">
                <a class="nav-link" href="#" role="button" @click.prevent="cerrar">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </li> -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-user"></i>
                    <!-- <span class="badge badge-warning navbar-badge">15</span> -->
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <!-- <span class="dropdown-item dropdown-header">15 Notifications</span> -->
                    <!-- <div class="dropdown-divider"></div> -->
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-user mr-2"></i> Ver mi perfil
                        <!-- <span class="float-right text-muted text-sm">3 mins</span> -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item" data-toggle="modal" data-target="#password">
                        <i class="fas fa-key mr-2"></i> Cambiar mi contraseña
                        <!-- <span class="float-right text-muted text-sm">12 hours</span> -->
                    </a>
                    <div class="dropdown-divider"></div>
                    <!-- <a href="#" class="dropdown-item">
                        <i class="fas fa-file mr-2"></i> 3 new reports
                        <span class="float-right text-muted text-sm">2 days</span>
                    </a> -->
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item dropdown-footer" @click.prevent="cerrar">Cerrar sesión</a>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- <Modalbusdocumento ref="doc" /> -->
    <!-- asignar oficina -->
    <div class="modal fade" id="seloficina">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">SELECCIONE LA OFICINA ASIGNADA</label>
                        <select class="form-control form-control-sm" v-model="depeuser">
                            <option v-for="(ofi, index) in oficinasdeluser" :key="index" :value="ofi.iddependencia">
                                {{ ofi.depe_nombre }}
                            </option>

                        </select>

                    </div>
                </div>
                <div class="modal-footer float-right p-1">
                    <!-- <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button> -->
                    <button type="button" class="btn btn-danger" @click.prevent="ingresaroficina">Continuar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- cambiar contraseña  -->
    <div class="modal fade" id="password">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5>Cambiar contraseña</h5>
                </div>
                <div class="modal-body">

                    <!-- <div class="form-group">
                        <label for="">Contraseña actual:</label>
                        <input type="password" class="form-control form-control-sm" v-model="formpass.actual">
                    </div> -->
                    <div class="form-group">
                        <label for="">Nueva contraseña:</label>
                        <input type="password" class="form-control form-control-sm" v-model="formpass.nueva">
                    </div>
                    <div class="form-group">
                        <label for="">Vuelva a ingresar la nueva contraseña:</label>
                        <input type="password" class="form-control form-control-sm" v-model="formpass.renueva" @keyup.enter="actualizapassword">
                    </div>

                </div>
                <div class="modal-footer float-right p-1">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" @click="actualizapassword">Actualizar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- mensaje error  -->
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

    <!-- comunicados  -->
    <div class="modal fade" id="comunicados">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <!-- {{ comunicados }} -->
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

                        <div class="carousel-inner text-center">
                            <div v-for="(item, index) in comunicados.datos" :key="index" class="carousel-item" :class="(index==0)?'active':''">
                                <img class="d-block w-100" :src="publicarImagenes(item.id)" alt="First slide">
                                <a :href="item.url" class="text-decoration-none btn btn-warning btn-sm lh-1 text-uppercase">
                                    <i class="fas fa-arrow-circle-right"></i> {{item.sustento}}
                                </a>
                            </div>
                          
                        </div>

                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-custom-icon" aria-hidden="true">
                                <i class="fas fa-chevron-left"></i>
                            </span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-custom-icon" aria-hidden="true">
                                <i class="fas fa-chevron-right"></i>
                            </span>
                            <span class="sr-only">Next</span>
                        </a>
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
import $ from 'jquery';
import swal from 'sweetalert2';
import Modalbusdocumento from '../modulos/tramites/Modalresultado.vue'
import {
    mapGetters
} from 'vuex';
import axios from 'axios';
window.Swal = swal;

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
    name: 'StdvNavbar',
    props: ['ruta', 'usuario'],

    data() {
        return {
            depeuser: this.usuario.depe_id,

            mode: 0, // 0 modo light 1:modo moon
            capturadato: null,
            formData: {
                iddocumento: null,
                modal: false
            },
            getCodigoBusqueda: null,
            formpass: {
                // actual: null,
                nueva: null,
                renueva: null
            },
            errordatos: [],
            comunicados: [],
            // cuentacomunicados:0

        }
    },
    components: {
        Modalbusdocumento
    },
    computed: {

        ...mapGetters(['oficinasdeluser']), // leemos el geter para utilizar en este componente los usuarios de la oficina al que pertenece

    },
    mounted() {
        if (this.usuario.depe_id == 0) {
            this.muestramodal();
        } else {
            this.nombre_dependencia(this.usuario.depe_id)
        }
        // this.depeuser=this.usuario.depe_id
        this.alertacomunicado();

    },
    methods: {
        // recogemos el nombre de la depedendencia
        nombre_dependencia(id) {
            // var url = '/oficinas/nombredepe/' + id;
            var url = '/consulta_user/' + id + '/false/0/' + this.usuario.id;

            axios.get(url)
                .then(res => {
                    this.datosuser = res.data;

                    const datos = {
                        nombreofi: this.datosuser.user_representante.nombreoficina,
                        idoficina: this.datosuser.user_representante.idoficina,
                        iddependencia: this.datosuser.user_representante.iddependencia,
                        firma: this.datosuser.user_representante.firma_tramite,
                        cargo: this.datosuser.user_representante.cargo_tramite,
                        siglasdocumento: this.datosuser.user_representante.siglas_tramite,
                        correlativo: this.datosuser.tipodoc.correlativo,
                        idcreador: this.datosuser.user_representante.iduser,
                        ciudad: this.datosuser.user_representante.ciudad,
                        direccion: this.datosuser.user_representante.direccion,
                        clavedoc: this.datosuser.clavedoc,
                        listaoficinasdepedencia: this.datosuser.dependencias, //listado de unidades a la unidad ejecutora que pertenece el usuario
                        oficinadepe: this.datosuser.oficinadepe
                    }

                    this.$store.commit('DATOS_OFICINA', datos)

                });
        },
        toast(texto_anuncio, icono) {

            Toast.fire({
                // title:texto_titulo,
                title: '<small><strong>' + texto_anuncio + '</strong></small>',
                icon: icono,
                // text: texto_anuncio
            });
        },
        alertacomunicado() {
            var url = '/comunicadoactivo'
            axios.get(url)
                .then(res => {
                    this.comunicados = res.data
                    const estado=this.comunicados.estado
                    // this.cuentacomunicados=this.comunicados.datos.length
                    if(estado!=0)
                    {
                        $('#comunicados').modal('show');
                    }
                    
                })

        },
        cambiomodooscuro() {
            this.mode = 1;
            document.body.classList.add('dark-mode'); //bg-gray
            //document.nav.classList.add('bg-gray');
            $(".main-header").addClass("bg-gray");
        },
        cambiomodoclaro() {
            this.mode = 0;
            document.body.classList.remove('dark-mode'); //bg-gray
            //document.nav.classList.add('bg-gray');
            $(".main-header").removeClass("bg-gray");
        },
        muestramodal() {
            // $('#seloficina').modal('show')
            $('#seloficina').modal({
                backdrop: 'static',
                keyboard: false
            })

        },
        ingresaroficina() {
            var url = '/usuariosunidad/' + this.depeuser;

            axios.get(url)
                .then(resp => {
                    // this.commit('USERS_OFICINA', resp.data)
                    this.$store.commit('USERS_OFICINA', resp.data)
                    this.nombre_dependencia(this.depeuser)

                    this.$store.dispatch('listadeoficinadelusuario');
                    this.$store.dispatch('Userlogeado');
                    this.$store.dispatch('obtenerArchivadores');

                    location.reload();
                    // this.$emit('tipostramite')

                    // this.toast('Excelente acaba a:<br>'+this.$store.state.nombredepe_seleccionado , 'success');
                    $('#seloficina').modal('hide')
                })
        },

        cerrar() {
            // Swal.fire('Test!', 'Hello test message','success');
            Swal.fire({
                    title: "Está a punto de cerrar sesión?",
                    text: "Si cierras la sesión, no podrás continuar el la plataforma",
                    type: "danger",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Cerrar sesión",
                    closeOnConfirm: false
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire('Sesión finalizado', 'Usted está saliendo de la plataforma', 'success')
                        var url = '/cerrarsesion';
                        axios.post(url).then(response => {
                            location.reload();
                        });

                    } else {
                        Swal.fire('Sesión cancelado', 'Usted continúa en la plataforma', 'error')

                    }
                });
        },
        buscarByDocumento(idocumentomodal) // abre modal
        {
            // this.datomodal=idocumentomodal
            //this.formData=idocumentomodal

            axios.get('/documento/buscarDocumento', {
                params: idocumentomodal
            }).then(response => {

                if (response.data.operaciones.length > 0) {
                    this.$refs.doc.buscardocumento(idocumentomodal)
                } else {
                    // alert('No hay datos que mostrar, el registro no existe')
                    // Swal.fire('El registro no existe', 'No hay datos que mostrar', 'info')
                    this.toast('No hay datos que mostrar, el registro no existe', 'info');
                }
            })

        },
        // buscarDocumento() {
        //     if (this.getCodigoBusqueda > 0) this.buscarByDocumento({
        //         iddocumento: this.getCodigoBusqueda,
        //         modal: true
        //     })
        //     else {
        //         // Swal.fire('Digite bien el Registro', 'No hay datos que mostrar', 'error')
        //         this.toast('Digite bien el Registro', 'error');
        //     }
        // },
        buscarDocumentoPopup() {
            this.formData.iddocumento = this.getCodigoBusqueda
            if (this.formData.iddocumento > 0) {
                this.formData.modal = false
                axios.get('/documento/buscarDocumento', {
                    params: this.formData
                }).then(response => {
                    if (response.data.operaciones.length > 0) {
                        var route = '/buscar/buscarModal/%s'
                        route = route.replace(/%s/g, this.formData.iddocumento)
                        window.open(route, 'Visor', 'width=1000,height=750')
                        //console.log(this.operaciones[0].oper_detalledestino.length);
                    } else {
                        // alert('No hay datos que mostrar, el registro no existe')
                        // Swal.fire('El registro no existe', 'No hay datos que mostrar', 'info')
                        this.toast('No hay datos que mostrar, el registro no existe', 'error');
                    }
                })
                // var route = '/buscar/buscarModal/%s'
                //         route = route.replace(/%s/g, this.formData.iddocumento)
                //         window.open(route, 'Visor', 'width=1000,height=750')
            } else {
                // Swal.fire('Digite bien el Registro', 'No hay datos que mostrar', 'error')
                this.toast('Digite bien el Registro', 'error');
            }
        },
        buscarExpedientePopup() {
            this.formData.iddocumento = this.getCodigoBusqueda
            if (this.formData.iddocumento > 0) {
                axios.get('/expediente', {
                    params: this.formData
                }).then(response => {
                    if (response.data.length > 0) {
                        var route = '/buscar/buscarExpedienteModal/%s'
                        route = route.replace(/%s/g, this.formData.iddocumento)
                        window.open(route, 'VisorExpe', 'width=1000, height=750')
                    } else {
                        // alert('No hay datos que mostrar, el expediente no existe')
                        this.toast('No hay datos que mostrar, el expediente no existe', 'error');
                    }
                })
            } else {
                // alert('Digite bien el expediente')
                this.toast('Digite bien el Registro', 'error');
            }
        },

        actualizapassword() {

            this.verifca();

            var url = '/actualizapassword'
            if (this.errordatos.length > 0) {
                this.toast('Falta rellenar algunos datos', 'error');
                $("#mensajeeeror").modal('show')
            } else {
                axios.post(url, this.formpass)
                    .then(res => {

                        this.toast(res.data.msg, res.data.tipo);
                        $('#password').modal('hide');
                        // console.log(res.data.msg)
                        this.limpiar();

                    })
            }

        },

        verifca() {
            this.errordatos = [];
            // if (this.formpass.actual == null) {
            //     this.errordatos.push('El campo de contraseña actual está vacio');
            // }
            if (this.formpass.nueva == null) {
                this.errordatos.push('El campo de nueva contraseña está vacio');
            }

            if (this.formpass.renueva == null) {
                this.errordatos.push('El campo de vuelva a ingresar nueva contraseña está vacio');
            }
            if (this.formpass.renueva != this.formpass.nueva) {
                this.errordatos.push('Las nuevas contraseña no concuerdan');
            }

        },
        limpiar() {
            this.formpass.nueva = null
            this.formpass.renueva = null
        },
        publicarImagenes(id) {
            var url = '/comunicacionInterna/print/%s'
            return url.replace(/%s/g, id)
        }

    }
};
</script>

<style lang="scss" scoped>
.el-carousel__item h3 {
    color: #475669;
    font-size: 18px;
    opacity: 0.75;
    // line-height: 300px;
    margin: 0;
}

.el-carousel__item:nth-child(2n) {
    background-color: #99a9bf;
}

.el-carousel__item:nth-child(2n+1) {
    background-color: #d3dce6;
}

//   .el-carousel__container{
//     position: relative;
//     height: 700px !important;
//   }
</style>
