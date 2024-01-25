<template>
<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">{{ $route.name }} </h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <router-link :to="'/'">Dashboard</router-link>
                        </li>
                        <li class="breadcrumb-item">
                            <router-link :to="'/Administracion/usuarios'">Usuarios</router-link>
                        </li>
                        <li class="breadcrumb-item active">{{ $route.name }}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <!-- <router-link  class="btn btn-info btn-sm" @click="router.go(-1)"><i class="fa-regular fa-circle-left"></i> Volver</router-link> -->
                    <button class="btn btn-info btn-sm btn-block" @click="retroceder()"><i class="fa-regular fa-circle-left"></i> Volver</button>

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline mt-2">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <!-- <img class="profile-user-img img-fluid img-circle" :src="ruta+'/dist/img/user4-128x128.jpg'" alt="User profile picture"> -->
                                <!-- <img class="profile-user-img img-fluid img-circle" :src="ruta+'/dist/img/user4-128x128.jpg'" alt="User profile picture"> -->
                                <img v-if="filluser.foto" :src="'data:image/jpg;base64,'+filluser.foto" class="profile-user-img img-fluid img-circle">
                                <img v-else src="/img/avatar/logo.png" class="profile-user-img img-fluid img-circle">
                            </div>

                            <h4 class="profile-username text-center">{{filluser.nombre}} {{filluser.apellidos}}</h4>

                            <p class="text-muted text-center">{{filluser.cargo}}</p>

                            <ul class="list-group list-group-unbordered mb-1">
                                <li class="list-group-item">
                                    <b>Correo</b> <a class="float-right">{{filluser.correo}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>Telefono</b> <a class="float-right">{{filluser.telefono}}</a>
                                </li>
                                <li class="list-group-item">
                                    <b>DNI</b> <a class="float-right">{{filluser.dni}}</a>
                                </li>
                            </ul>
                            <!-- <a href="#" class="btn btn-primary btn-block" ><b>Actualizar avatar</b></a> -->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
                <!-- puede actualizar cualquier usuario de cualquuier dependencia -->
                <div class="col-md-9" v-if="is('SUPERADMIN | ADMINISTRADOR')">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">

                                <!-- <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Linea de tiempo</a></li> -->
                                <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Configuración</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">

                                <div class="active tab-pane" id="settings">
                                    <!-- <form class="form-horizontal"> -->
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Nombre</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm text-uppercase" placeholder="Name" v-model="filluser.nombre">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Apellidos</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm text-uppercase" placeholder="Apellidos" v-model="filluser.apellidos">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Iniciales nombre</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm text-uppercase" placeholder="Apellidos" v-model="filluser.iniciales">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control form-control-sm" placeholder="Email" v-model="filluser.correo">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Direccion</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm text-uppercase" placeholder="Name" v-model="filluser.direccion">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">DNI</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm" placeholder="Name" v-model="filluser.dni">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputExperience" class="col-sm-2 col-form-label">Número celular</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm" placeholder="Name" v-model="filluser.telefono">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Cargo</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm text-uppercase" placeholder="Skills" v-model="filluser.cargo">
                                        </div>
                                    </div>

                                    <div class="form-group row" v-if="is('SUPERADMIN | ADMINISTRADOR')">
                                        <label class="col-sm-2 col-form-label">Vigencia</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control form-control-sm" placeholder="Name" v-model="filluser.fechavigencia">
                                        </div>
                                    </div>
                                    <div class="form-group row" v-if="is('SUPERADMIN | ADMINISTRADOR')">
                                        <label class="col-sm-2 col-form-label">Estado</label>
                                        <div class="col-sm-10">
                                            <template v-if="filluser.estado==1">
                                                <i class="fa-solid fa-toggle-on text-success"></i>Activado
                                            </template>
                                            <template v-else>
                                                <i class="fa-solid fa-toggle-off text-danger"></i> Desactivado
                                            </template>
                                        </div>
                                    </div>
                                    <div class="form-group row" v-if="is('SUPERADMIN | ADMINISTRADOR')">
                                        <label class="col-sm-2 col-form-label">Roles</label>
                                        <div class="col-sm-10">
                                            <el-select v-model="filluser.rolesdeluser" multiple filterable placeholder="Selecione su rol" size="small" style="width: 100%;">
                                                <el-option v-if="is('SUPERADMIN')" v-for="item in rolesgeneral" :key="item.id" :label="item.name" :value="item.name">
                                                </el-option>
                                                <el-option   v-for="item in rolesgeneral" :key="item.id"  v-if="item.name!='SUPERADMIN'" :label="item.name" :value="item.name">
                                                </el-option>
                                            </el-select>
                                        </div>
                                    </div>
                                    <div class="form-group row" v-if="is('SUPERADMIN | ADMINISTRADOR')">
                                        <label class="col-sm-2 col-form-label">Unidad orgánica(asignado)</label>
                                        <!-- <div class="col-sm-2">
                                                <input type="text" class="form-control form-control-sm" placeholder="Codigo" v-model="filluser.iddependencia">
                                            </div> -->
                                        <div class="col-sm-8">

                                            <button class="btn btn-xs btn-primary" @click="nuevaoficina"><i class="fa fa-file-medical"></i> Asignar unidad </button>
                                            <table class="table table-bordered table-sm table-hover">

                                                <tbody>
                                                    <tr v-for="item in oficinas">
                                                        <td>{{ item.depe_nombre }}</td>
                                                        <td>
                                                            <button class="btn btn-xs btn-primary" @click="editarofina(item.iduserof)"><i class="fa fa-edit"></i> </button>
                                                            <button class="btn btn-xs btn-danger" @click="eliminaroficina(item.iduserof,item.depe_nombre)"><i class="fa fa-trash"></i> </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button class="btn btn-danger" @click="actuazardatosgeneral">Actualizar datos</button>
                                        </div>
                                    </div>
                                    <!-- </form> -->
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>

                <div class="col-md-9" v-else>
                    <div class="card" v-if="usuario.id==datosuser.id">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">

                                <!-- <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Linea de tiempo</a></li> -->
                                <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Configuración</a></li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">

                                <div class="active tab-pane" id="settings">
                                    <!-- <form class="form-horizontal"> -->
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Nombre</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm text-uppercase" placeholder="Name" v-model="filluser.nombre">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Apellidos</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm text-uppercase" placeholder="Apellidos" v-model="filluser.apellidos">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Iniciales nombre</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm text-uppercase" placeholder="Apellidos" v-model="filluser.iniciales">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="email" class="form-control form-control-sm" placeholder="Email" v-model="filluser.correo">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Direccion</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm text-uppercase" placeholder="Name" v-model="filluser.direccion">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">DNI</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm" placeholder="Name" v-model="filluser.dni">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputExperience" class="col-sm-2 col-form-label">Número celular</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm" placeholder="Name" v-model="filluser.telefono">
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label class="col-sm-2 col-form-label">Cargo</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control form-control-sm text-uppercase" placeholder="Skills" v-model="filluser.cargo">
                                        </div>
                                    </div>

                                    <div class="form-group row" v-if="is('SUPERADMIN | ADMINISTRADOR')">
                                        <label class="col-sm-2 col-form-label">Vigencia</label>
                                        <div class="col-sm-10">
                                            <input type="date" class="form-control form-control-sm" placeholder="Name" v-model="filluser.fechavigencia">
                                        </div>
                                    </div>
                                    <div class="form-group row" v-if="is('SUPERADMIN | ADMINISTRADOR')">
                                        <label class="col-sm-2 col-form-label">Estado</label>
                                        <div class="col-sm-10">
                                            <template v-if="filluser.estado==1">
                                                <i class="fa-solid fa-toggle-on text-success"></i>Activado
                                            </template>
                                            <template v-else>
                                                <i class="fa-solid fa-toggle-off text-danger"></i> Desactivado
                                            </template>
                                        </div>
                                    </div>
                                    <div class="form-group row" v-if="is('SUPERADMIN | ADMINISTRADOR')">
                                        <label class="col-sm-2 col-form-label">Roles</label>
                                        <div class="col-sm-10">
                                            <el-select v-model="filluser.rolesdeluser" multiple filterable placeholder="Selecione su rol" size="small" style="width: 100%;">
                                                <el-option v-for="item in rolesgeneral" :key="item.id" :label="item.name" :value="item.name">
                                                </el-option>
                                            </el-select>
                                        </div>
                                    </div>
                                    <div class="form-group row" v-if="is('SUPERADMIN | ADMINISTRADOR')">
                                        <label class="col-sm-2 col-form-label">Unidad orgánica(asignado)</label>
                                        <!-- <div class="col-sm-2">
                                                <input type="text" class="form-control form-control-sm" placeholder="Codigo" v-model="filluser.iddependencia">
                                            </div> -->
                                        <div class="col-sm-8">

                                            <button class="btn btn-xs btn-primary" @click="nuevaoficina"><i class="fa fa-file-medical"></i> Asignar unidad </button>
                                            <table class="table table-bordered table-sm table-hover">

                                                <tbody>
                                                    <tr v-for="item in oficinas">
                                                        <td>{{ item.depe_nombre }}</td>
                                                        <td>
                                                            <button class="btn btn-xs btn-primary" @click="editarofina(item.iduserof)"><i class="fa fa-edit"></i> </button>
                                                            <button class="btn btn-xs btn-danger" @click="eliminaroficina(item.iduserof,item.depe_nombre)"><i class="fa fa-trash"></i> </button>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>

                                        </div>

                                    </div>

                                    <div class="form-group row">
                                        <div class="offset-sm-2 col-sm-10">
                                            <button class="btn btn-danger" @click="actuazardatosgeneral">Actualizar datos</button>
                                        </div>
                                    </div>
                                    <!-- </form> -->
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <div v-else>
                        <div class="alert alert-warning alert-dismissible">
                            <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> -->
                            <h5><i class="icon fas fa-exclamation-triangle"></i> Alerta!</h5>
                            Usted no tiene acceso para modificar otro usuario<br>
                            <!-- <router-link :to="'/Administracion/usuarios/edit/'+usuario.id" class="btn btn-dark btn-xs text-decoration-none">
                            Editar mi cuenta
                        </router-link> -->
                            <button class="btn btn-dark btn-xs" @click="cambiarcuenta">
                                Editar mi cuenta
                            </button>
                        </div>
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
    <!-- modal editar/nuevo acceso a unidad orgnaica -->
    <div class="modal fade" id="nuevoedit">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header pt-1 pb-0" v-if="tipoedicion==2">
                    <h5 class="modal-title">Edicion de la unidad </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-close"></i>
                    </button>
                </div>
                <div class="modal-header pt-1 pb-0" v-else>
                    <h5 class="modal-title">Nueva asignación </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <i class="fa fa-close"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group row">
                        <label class="col-sm-2">Unidad:</label>
                        <div class="col-sm-10">
                            <select v-model="formacceso.idunidad" class="form-control form-control-sm">
                                <option v-for="depe in getUnidadesForDerivacion" :value="depe.iddependencia">{{ depe.depe_nombre }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3">Cargo que tendrá:</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control form-control-sm text-uppercase" v-model="formacceso.cargo" placeholder="ejem. Presidente comité, Jefe de Encargado de almacén">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-3">Rol asignación:</label>
                        <div class="col-sm-9">
                            <!-- <select v-model="formacceso.acceso" class="form-control form-control-sm">
                                <option v-for="rol in rolesgeneral" :value="rol.name">{{ rol.name }}</option>
                            </select> -->

                            <div class="form-group" v-if="is('ADMINISTRADOR')">
                                <!-- <label for="">Rol asignación:<span class="text-danger">*</span></label> -->
                                <select class="form-control form-control-sm" placeholder="Seleccione el rol a asignar" v-model="formacceso.acceso">
                                    <option v-for="rol in rolesgeneral" v-if="rol.name!='SUPERADMIN'" :value="rol.name">{{ rol.name }}</option>
                                </select>
                            </div>
                            <div class="form-group" v-if="is('SUPERADMIN')">
                                <!-- <label for="">Rol asignación: <span class="text-danger">*</span></label> -->
                                <select class="form-control form-control-sm" placeholder="Seleccione el rol a asignar" v-model="formacceso.acceso">
                                    <option v-for="rol in rolesgeneral" :value="rol.name">{{ rol.name }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer float-right p-1">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary" v-if="tipoedicion==2" @click="guardarasignacion">Actualizar</button>
                    <button type="button" class="btn btn-primary" v-else @click="guardarasignacion">Agregar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

</div>
</template>

<script>
import Vuex from 'vuex'
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
        usuario: {
            type: Object,
            default: () => ({})
        },
        ruta: {
            type: String,
            default: ''
        },
        routeInvokerGet: {
            type: String,
            default: ''
        },
        routeInvokerPost: {
            type: String,
            default: ''
        }
    },
    name: '',
    data() {
        return {
            filluser: {
                iduser: this.$attrs.id,
                nombre: '',
                apellidos: '',
                iniciales: '',
                usuario: '',
                contrasena: '',
                estado: '',
                cargo: '',
                correo: '',
                foto: '',
                dni: '',
                direccion: '',
                fechavigencia: '',
                telefono: '',
                avatar: '',
                rolesdeluser: [],
                iddependencia: ''
            },
            formacceso: {
                iduserof: '',
                iduser: this.$attrs.id,
                idunidad: '',
                acceso: '',
                cargo: '',
                estado: 1, //1: activo, 2: inactivo
            },
            datosuser: [],
            oficinas: [],
            tipoedicion: 1,
            rolesgeneral: []

        }
    },
    computed: {
        ...Vuex.mapGetters(['getUnidadesForDerivacion']),

    },
    components: {

    },

    mounted() {
        this.getusuarios();
        this.cargaroles();

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
        getusuarios() {
            var url = '/listauser/' + this.$attrs.id;
            axios.get(url)
                .then((result) => {
                    // console.log(result.data)
                    this.datosuser = result.data.datos
                    this.oficinas = result.data.oficinas

                    /// asignamos los datos a las variables
                    this.filluser.nombre = this.datosuser.adm_name;
                    this.filluser.apellidos = this.datosuser.adm_lastname;
                    this.filluser.iniciales = this.datosuser.adm_inicial;
                    this.filluser.usuario = this.datosuser.adm_email;
                    this.filluser.contrasena = this.datosuser.adm_password;
                    this.filluser.estado = this.datosuser.adm_estado;
                    this.filluser.cargo = this.datosuser.adm_cargo;
                    this.filluser.correo = this.datosuser.adm_correo;
                    this.filluser.dni = this.datosuser.adm_dni;
                    this.filluser.direccion = this.datosuser.adm_direccion;
                    this.filluser.fechavigencia = this.datosuser.adm_vigencia;
                    this.filluser.telefono = this.datosuser.adm_telefono;
                    this.filluser.avatar = this.datosuser.avatar;
                    this.filluser.foto = result.data.foto;
                    this.filluser.iddependencia = this.datosuser.depe_id;
                    this.filluser.rolesdeluser = result.data.rolesuser;
                });
        },
        cargaroles() {
            var url = '/rolesypermisos'
            axios.get(url)
                .then(res => {
                    this.rolesgeneral = res.data.roles
                })
        },
        retroceder() {
            window.history.back();
        },
        editarofina(idofiuser) {
            $('#nuevoedit').modal('show');
            this.tipoedicion = 2
            var url = '/buscauserofi/' + idofiuser
            axios.get(url)
                .then(res => {
                    // console.log(res.data)
                    this.formacceso = res.data
                })
        },
        eliminaroficina(idofiuser, oficina) {
            var url = '/updateoficinauser'
            const param = {
                'idofiuser': idofiuser,
                'estado': 2
            }
            let borrar = confirm('Está seguro de eliminar la asignacion de la unidad que pertenece: ' + oficina)
            if (borrar == true) {
                axios.post(url, param)
                    .then(res => {
                        // console.log(res.data)
                        this.$store.dispatch('listadeoficinadelusuario');
                        this.getusuarios();
                        this.toast('Fue eliminado la asignación exitosamente', 'success');
                    })
            }

        },
        nuevaoficina() {
            $('#nuevoedit').modal('show');
        },
        guardarasignacion() {
            var url = '/nuevaasignacion'
            axios.post(url, this.formacceso)
                .then(res => {
                    // console.log(res.data)
                    $('#nuevoedit').modal('hide');
                    this.getusuarios();
                    this.toast('Fue agregado la nueva asignación de manera exitosamente', 'success');
                    // location.reload();
                    setTimeout(function () {
                        window.location.reload();
                    }, 3001);
                })
        },
        actuazardatosgeneral() {
            var url = '/actualizauser';
            const param = {
                'adm_name': this.filluser.nombre,
                'adm_lastname': this.filluser.apellidos,
                'adm_cargo': this.filluser.cargo,
                'adm_estado': this.filluser.estado,
                'adm_dni': this.filluser.dni,
                'adm_telefono': this.filluser.telefono,
                'adm_correo': this.filluser.correo,
                'id': this.filluser.iduser,
                'adm_vigencia': this.filluser.fechavigencia,
                'adm_direccion': this.filluser.direccion,
                'adm_inicial': this.filluser.iniciales,
                'roles': this.filluser.rolesdeluser
            }
            axios.post(url, param)
                .then(res => {
                    // console.log(res.data)
                    this.toast('Fue actualizado los datos de manera exitosamente', 'success');
                    this.getusuarios();
                })
        },
        cambiarcuenta() {
            this.$router.push({
                name: 'Editar usuario',
                params: {
                    id: this.usuario.id
                }
            })
            setTimeout(function () {
                window.location.reload();
            }, 1001);

        }

    }
}
</script>

<style lang="css" scoped>

</style>
