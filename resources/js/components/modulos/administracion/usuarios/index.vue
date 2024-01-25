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
        <div class="container-fluid" v-if="is('SUPERADMIN | ADMINISTRADOR')">
            <div class="row">
                <div class="col-lg-6 col-10">
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#adduser"><i class="fa-solid fa-user-plus"></i> Nuevo usuario</button>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="card card-primary card-outline ">
                        <div class="card-header p-1">
                            Listado de usuarios asignados por unidades
                        </div>
                        <div class="card-body">

                            <!-- {{-- para las opciones de busqueda --}} -->
                            <form action="" @submit.prevent="buscarUsuario()">
                                <div class="row  mb-2">

                                    <div class="col-md-2">
                                        <div class="group">
                                            <label for="" class="text-sm">DNI</label>
                                            <input type="number" class="form-control form-control-sm" v-model="formData.adm_dni">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="group">
                                            <label for="" class="text-sm">NOMBRES</label>
                                            <input type="text" class="form-control form-control-sm" v-model="formData.adm_name" @change="formData.adm_name = formData.adm_name.toUpperCase()">
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="group">
                                            <label for="" class="text-sm">APELLIDOS</label>
                                            <input type="text" class="form-control form-control-sm" v-model="formData.adm_lastname" @change="formData.adm_lastname = formData.adm_lastname.toUpperCase()">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="group">
                                            <label for="" class="text-sm">OFICINAS</label>

                                            <!-- <select class="form-control form-control-sm" @change="buscarUsuario()" v-model="formData.depe_id">
                                                <option value="">Todos</option>
                                                <option v-for="of in getDependenciaUser.listaoficinasdepedencia" :value="of.iddependencia">{{ recortacadena(of.depe_nombre) }}</option>
                                            </select> -->

                                            <el-select v-model="formData.depe_id" @change="buscarUsuario()" filterable placeholder="Seleccione la dependencia" style="width: 100%;" size="small">
                                                <el-option value="" label="Todos"></el-option>
                                                <el-option v-for="(dependencia, indexDepe) in getDependenciaUser.listaoficinasdepedencia" :key="indexDepe" :label="recortacadena(dependencia.depe_nombre)" :value="dependencia.iddependencia">
                                                </el-option>
                                            </el-select>

                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="group">
                                            <label for="" class="text-sm">Estado</label>
                                            <select class="form-control form-control-sm" @change="buscarUsuario()" v-model="formData.adm_estado">
                                                <option value="">Todos</option>
                                                <option value="1">ACTIVO</option>
                                                <option value="2">DESAHIBILITADO</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2"><label for=""></label>
                                        <button type="submit" class="btn btn-block btn-primary btn-sm mt-1"><i data-feather="search" class="me-25"></i> Buscar</button>
                                    </div>

                                </div>
                            </form>
                            <!-- paginacion -->
                            <div class="row form-group pt-2 border-top">
                                <div class="demo-inline-spacing">

                                </div>
                            </div>
                            <!-- {{-- para la relacion de datos --}} -->
                            <div class="row mt-2">
                                <table class=" table table-bordered table-condensed table-hover table-sm">
                                    <thead class="bg-lightblue  disabled color-palette pd-0">
                                        <tr class="info">
                                            <th><small><strong>ID</strong></small></th>
                                            <th><small><strong>NOMBRES</strong></small></th>

                                            <th><small><strong>CARGO</strong></small></th>
                                            <th><small><strong>FECH VIGENCIA</strong></small></th>
                                            <th><small><strong>ACTIVO</strong></small></th>
                                            <th><small><strong>FECHA HABILITACION</strong></small></th>
                                            <th><small><strong>ACCIONES</strong></small></th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="user in users.data" v-if="user.adm_email!='SUPERADMIN'">

                                            <td>{{ user.id }}</td>
                                            <td>{{ user.adm_name }} {{ user.adm_lastname }}<br>
                                                <strong>DNI</strong>:{{user.adm_dni }}<br>
                                                <strong>Correo</strong>:{{user.adm_correo }}<br>
                                                <strong>Usuario</strong>:{{user.adm_email }}</td>

                                            <td>{{ user.adm_cargo }}</td>
                                            <td>{{ user.adm_vigencia}}</td>
                                            <td v-if="user.adm_estado==1" class="text-center text-success">

                                                <i class="fa-solid fa-toggle-on" @click="activar(2,user.id )"></i>

                                            </td>
                                            <td v-else class="text-center text-danger">

                                                <!-- <i class="fa-solid fa-person-circle-xmark"></i> -->
                                                <i class="fa-solid fa-toggle-off" @click="activar(1,user.id )"></i>

                                            </td>
                                            <td>{{ moment(user.created_at).format('DD-MM-YYYY  h:mm:ss') }}</td>
                                            <td class="text-center">
                                                <router-link :to="{name:'Editar usuario',params:{id:user.id }}"><i class="fa-solid fa-user-pen"></i></router-link>
                                                <!-- <router-link :to="{name:'Editar usuario',params:{id:user.id }}"><i class="fa-solid fa-landmark"></i></router-link> -->
                                            </td>

                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                        <div class="card-footer clearfix">
                            <Pagination :data="users" :limit="3" @pagination-change-page="buscarUsuario" />
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.container-fluid -->
        <div v-else class="container-fluid">
            <div class="row justify-content-center mt-2">
                <div class="col-lg-6 col-10">

                    <div class="alert alert-warning alert-dismissible">
                        <!-- <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> -->
                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alerta!</h5>
                        Usted no tiene acceso a este módulo <br>
                        <router-link :to="'/'" class="btn btn-dark btn-xs text-decoration-none">
                            Salir de esta sección
                        </router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
    <!-- MODAL agregar usuarios -->
    <div class="modal fade" id="adduser">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header pt-1 pb-1">
                    <h4 class="modal-title">Agregar usuarios</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        x
                    </button>
                </div>
                <div class="modal-body p-0">
                    <!-- <h5><b>Datos del usuario:</b> </h5> -->
                    <div class="card mb-0">
                        <div class="card-header bg-primary p-1">
                            Datos del usuario
                        </div>
                        <div class="card-body pb-0">
                            <div class="row">
                                <!-- <label class="col-sm-3">DNI</label> -->
                                <div class="col-sm-4">
                                    <input type="number" name="dni" class="form-control form-control-sm" v-model="formuser.adm_dni" @keyup.enter="validareniec" placeholder="Digite su número de DNI">
                                </div>
                                <div class="col-sm-2">
                                    <button class="btn btn-sm btn-primary" @click="validareniec">Validar reniec</button>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-3"><label class="control-label">Nombre <span class="text-danger">*</span></label>
                                    <input name="nombre" type="text" class="form-control form-control-sm text-uppercase" v-model="formuser.adm_name">
                                </div>
                                <div class="col-sm-4"><label class="control-label">Apellido <span class="text-danger">*</span></label>
                                    <input name="apellido" type="text" class="form-control form-control-sm text-uppercase" v-model="formuser.adm_lastname">
                                </div>
                                <div class="col-sm-5"><label class="control-label">Cargo <span class="text-danger">*</span></label>
                                    <input name="cargo" type="text" class="form-control form-control-sm text-uppercase" v-model="formuser.adm_cargo">
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-4"><label class="control-label">Email <span class="text-danger">*</span></label> <input type="email" name="email" class="form-control form-control-sm text-uppercase" v-model="formuser.adm_correo"></div>
                                <div class="col-sm-3"><label class="control-label">Iniciales</label> <input type="text" name="inicial" class="form-control form-control-sm text-uppercase" v-model="formuser.adm_inicial"></div>
                                <div class="col-sm-5"><label>Profesión <span class="text-danger">*</span></label> <input type="text" class="form-control form-control-sm text-uppercase" v-model="formuser.adm_con_especialidad"></div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-4"><label class="control-label">Telefono <span class="text-danger">*</span></label> <input type="number" name="ntelf" class="form-control form-control-sm" v-model="formuser.adm_telefono"></div>
                                <div class="col-sm-8"><label>Dirección<span class="text-danger">*</span></label> <input type="text" class="form-control form-control-sm text-uppercase" v-model="formuser.adm_direccion"></div>
                            </div>
                            <div class="form-group row" v-if="is('SUPERADMIN')">
                                <label for="" class="col-sm-2">Dependencia</label>
                                <!-- <label for="" class="col-sm-2">{{ retornadepedencia(getDependenciaUser.iddependencia,getDependenciaUser.listaoficinasdepedencia) }}</label> -->

                                <div class="col-sm-8">
                                    <!-- <select class="form-control form-control-sm" v-model="formuser.iddependencia" @change="oficinasxdepednencias()">
                                        <option v-for="dep in getSedes" :value="dep.iddependencia">{{ recortacadena(dep.depe_nombre) }}</option>
                                    </select> -->
                                    <el-select v-model="formuser.iddependencia" @change="oficinasxdepednencias()" filterable placeholder="Seleccione la dependencia" style="width: 100%;" size="small">
                                        <el-option v-for="(dependencia, indexDepe) in getSedes" :key="indexDepe" :label="recortacadena(dependencia.depe_nombre)" :value="dependencia.iddependencia">
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>
                            <div class="row form-group">
                                <label for="" class="col-sm-2" style="display: none;" v-if="is('ADMINISTRADOR')">{{ retornadepedencia(getDependenciaUser.iddependencia,getDependenciaUser.oficinadepe) }}</label>
                                <div class="col-sm-2"><label class="control-label">Unidad Org <span class="text-danger">*</span></label></div>
                                <div class="col-sm-2"><input class="form-control form-control-sm" v-model="formuser.depe_id"></div>
                                <div class="col-sm-8">
                                    <!-- <select class="form-control form-control-sm" v-model="formuser.depe_id">
                                        <option v-for="of in oficinasdepe" :value="of.iddependencia">{{ recortacadena(of.depe_nombre) }}</option>
                                    </select> -->
                                    <el-select v-model="formuser.depe_id" filterable placeholder="Seleccione la dependencia" style="width: 100%;" size="small">
                                        <el-option v-for="(dependencia, indexDepe) in oficinasdepe" :key="indexDepe" :label="recortacadena(dependencia.depe_nombre)" :value="dependencia.iddependencia">
                                        </el-option>
                                    </el-select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card mb-0">
                        <div class="card-header bg-primary p-1">
                            Datos de la cuenta
                        </div>
                        <div class="card-body pb-0">
                            <div class="row form-group">
                                <div class="col-sm-3"><label class="control-label">Usuario <span class="text-danger">*</span></label>
                                    <input type="text" name="usuario" class="form-control form-control-sm text-uppercase" v-model="formuser.adm_dni" disabled></div>
                                <div class="col-sm-3"><label class="control-label">Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password" placeholder="Password" class="form-control form-control-sm" v-model="formuser.adm_password"></div>
                                <div class="col-sm-3"><label class="control-label">Repite Password <span class="text-danger">*</span></label>
                                    <input type="password" name="password_confirmation" placeholder="Password, otra vez" class="form-control form-control-sm" v-model="formuser.adm_password2"></div>
                                <div class="col-sm-3"><label>Solicitar cambio contraseña</label>
                                    <div>
                                        <label><input type="radio" class="radio-inline" value="" v-model="formuser.adm_primer_logeo">Si</label>
                                        <label><input type="radio" class="radio-inline" value="1" v-model="formuser.adm_primer_logeo">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row form-group">
                                <div class="col-sm-3"><label class="control-label">Vigente Hasta <span class="text-danger">*</span></label>
                                    <input type="date" name="vigencia" class="form-control form-control-sm" v-model="formuser.adm_vigencia">
                                </div>
                                <div class="col-sm-3"><label class="control-label">Estado <span class="text-danger">*</span></label>
                                    <select name="estado" class="form-control form-control-sm" v-model="formuser.adm_estado">
                                        <option value="1">Activo</option>
                                        <option value="2">Inactivo</option>
                                    </select></div>
                                <div class="col-sm-6">
                                    <label>Observaciones</label>
                                    <input type="text" class="form-control form-control-sm" v-model="formuser.adm_observacion">
                                </div>
                            </div>
                            <div class="form-group" v-if="is('ADMINISTRADOR')">
                                <label for="">Roles asignado <span class="text-danger">*</span></label>
                                <!-- <select class="form-control form-control-sm" placeholder="Seleccione el rol a asignar" v-model="formuser.rolesasignado">
                                    <option v-for="rol in formuser.datoroles.roles" v-if="rol.name!='SUPERADMIN'" :value="rol.name">{{ rol.name }}</option>
                                </select> -->
                                <el-select v-model="formuser.rolesasignado" multiple filterable placeholder="Selecione su rol" size="small" style="width: 100%;">
                                    <el-option v-for="rol in formuser.datoroles.roles" v-if="rol.name!='SUPERADMIN'" :key="rol.id" :label="rol.name" :value="rol.name">
                                    </el-option>
                                </el-select>
                            </div>
                            <div class="form-group" v-if="is('SUPERADMIN')">
                                <label for="">Roles asignado <span class="text-danger">*</span></label>
                                <!-- <select class="form-control form-control-sm" placeholder="Seleccione el rol a asignar" v-model="formuser.rolesasignado">
                                    <option v-for="rol in formuser.datoroles.roles" :value="rol.name">{{ rol.name }}</option>
                                </select> -->
                                <el-select v-model="formuser.rolesasignado" multiple filterable placeholder="Selecione su rol" size="small" style="width: 100%;">
                                    <el-option v-for="rol in formuser.datoroles.roles" :key="rol.id" :label="rol.name" :value="rol.name">
                                    </el-option>
                                </el-select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" v-show="habilitaguardar" @click="guardar">Agregar</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    <!-- valida datos y muestra erro si faltan algunos -->
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
import LaravelVuePagination from 'laravel-vue-pagination';
import moment from 'moment'
import axios from 'axios';
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
    props: ['usuario', 'routeInvokerGet', 'routeInvokerPost'],
    data() {
        return {
            users: {},
            formData: {
                id: null,
                adm_dni: null,
                adm_name: null,
                adm_lastname: null,
                adm_tipo: null,
                adm_estado: null,
                depe_id: this.usuario.depe_id,
                page: null
            },
            pagination: {
                'total': 0,
                'current_page': 0,
                'per_page': 0,
                'last_page': 0,
                'from': 0,
                'to': 0
            },
            offset: 3,
            ruta: this.$attrs.ruta,

            formuser: {
                adm_name: '',
                adm_lastname: '',
                adm_inicial: '',
                adm_con_especialidad: '',
                adm_email: '',
                adm_password: '',
                adm_password2: '',
                adm_estado: 1,
                adm_cargo: '',
                adm_correo: '',
                adm_vigencia: '',
                adm_esjefe: '',
                adm_telefono: '',
                adm_direccion: '',
                adm_dni: '',
                adm_observacion: '',
                depe_id: this.usuario.depe_id, //codigo de oficina
                iddependencia: '', // depedencias sede gore, etc
                tipousuario: '', //1: (funcionarios y servidores), 2: terceros
                adm_primer_logeo: "1",
                datoroles: [],
                rolesasignado: []
            },
            oficinasdepe: [],
            habilitaguardar: true,
            errordatos: []

        }
    },
    components: {
        'Pagination': LaravelVuePagination,
    },
    computed: {
        // ...Vuex.mapGetters(['usersoficinas', 'getArchivadores', 'getFormatBytes']),
        ...Vuex.mapGetters([
            // 'getDependenciaNombre',
            // 'getUsuariosActivo',
            // 'getUsuariosActivoNombre',
            'getDependenciaUser',
            'getSedes'
        ]),

    },

    created() {
        this.buscarUsuario();
        this.getroles();
    },
    methods: {
        moment(a) {
            return moment(a)
        },
        toast(texto_anuncio, icono) {

            Toast.fire({
                // title:texto_titulo,
                title: '<small><strong>' + texto_anuncio + '</strong></small>',
                icon: icono,
                // text: texto_anuncio
            });
        },
        buscarUsuario(page) {
            this.formData.page = page
            axios.get('/listauser', {
                    params: this.formData
                })
                .then(response => {
                    this.users = response.data
                    // this.pagination = response.data.paginacion
                })
        },

        getroles() {
            var url = '/rolesypermisos'
            axios.get(url)
                .then(res => {
                    // const dat=res.data
                    this.formuser.datoroles = res.data
                })
        },
        validareniec() {
            var url = '/reniec/' + this.formuser.adm_dni

            this.compruebaexisteuser()

            axios.get(url)
                .then(res => {
                    // console.log(res.data)
                    this.formuser.adm_name = res.data.prenombres
                    this.formuser.adm_lastname = res.data.apPrimer + ' ' + res.data.apSegundo
                    this.formuser.adm_inicial = res.data.prenombres.substr(0, 1) + res.data.apPrimer.substr(0, 1) + res.data.apSegundo.substr(0, 1)
                    this.formuser.adm_direccion = res.data.direccion
                    this.formuser.adm_telefono = res.data.telefono
                    this.formuser.adm_correo = res.data.correo
                })
        },
        compruebaexisteuser() {
            var url = '/duplicado/' + this.formuser.adm_dni
            axios.get(url)
                .then(res => {
                    // console.log(res.data)
                    if (res.data.status == 1) {
                        this.toast('El usuario ingresado ya existe en el registro de la Base de Datos', 'error');
                        this.habilitaguardar = false
                    } else {
                        this.toast('El usuario ingresado es nuevo', 'info');
                        this.habilitaguardar = true
                    }
                })
        },
        retornadepedencia(id, oficinasdepe) {
            this.formuser.iddependencia = id
            this.oficinasdepe = oficinasdepe
            // this.oficinasxdepednencias();
            return id;
        },
        activar(estado, iduser) {
            var url = '/estadouser'
            const param = {
                'id': iduser,
                'estado': estado
            }
            axios.post(url, param)
                .then(res => {
                    // console.log(res.data)
                    this.toast('Fue actualizado el estado del usuario', 'success');
                    this.buscarUsuario();
                    // setTimeout(function () {
                    //     window.location.reload();
                    // }, 3001);
                })
        },
        guardar() {
            var url = '/nuevousuario';

            // if (this.formuser.adm_dni) {
            // this.compruebaexisteuser()
            // }
            // if (this.habilitaguardar == true) {
            this.verifica();
            // }

            if (this.errordatos.length > 0) {
                this.toast('Falta rellenar algunos datos', 'error');
                // $("#mensajeeeror").modal('show')
            } else {

                axios.post(url, this.formuser)
                    .then(res => {
                        // console.log(res.data);
                        this.toast('Fue creado el usuario exitosamente', 'success');
                        this.limpiadatos();
                        // $("#mensajeeeror").modal('hide')
                        $("#adduser").modal('hide')
                        // this.listauser();
                        this.buscarUsuario();
                    })
            }

        },
        oficinasxdepednencias() {
            this.formuser.depe_id = ''
            // this.formuser.iddependencia  = event.target.value;
            var url = '/oficinas/' + this.formuser.iddependencia
            axios.get(url)
                .then(res => {
                    // console.log(res.data)
                    this.oficinasdepe = res.data.listadepe.data
                })
        },
        verifica() {
            this.errordatos = [];
            if (this.formuser.adm_name == '') {
                this.errordatos.push('El campo de nombre está vacio');
            }
            if (this.formuser.adm_lastname == '') {
                this.errordatos.push('El campo de apellido está vacio');
            }
            if (this.formuser.adm_inicial == '') {
                this.errordatos.push('El campo de iniciales está vacio');
            }
            if (this.formuser.adm_con_especialidad == '') {
                this.errordatos.push('El campo de especialidad está vacio');
            }
            if (this.formuser.adm_correo == '') {
                this.errordatos.push('El campo de direccion está vacio');
            }
            if (this.formuser.adm_cargo == '') {
                this.errordatos.push('El campo de cargo está vacio');
            }
            if (this.formuser.adm_dni == '') {
                this.errordatos.push('El campo de DNI está vacio');
            }
            if (this.formuser.adm_telefono == '') {
                this.errordatos.push('El campo de direccion está vacio');
            }
            if (this.formuser.adm_direccion == '') {
                this.errordatos.push('El campo de direccion está vacio');
            }
            if (this.formuser.depe_id == '') {
                this.errordatos.push('El campo de unidad orgánica está vacio');
            }
            if (this.formuser.adm_password == '') {
                this.errordatos.push('El campo de contraseña está vacio');
            }
            if (this.formuser.adm_password2 == '') {
                this.errordatos.push('El campo de repita la contraseña está vacio');
            }
            if (this.formuser.adm_vigencia == '') {
                this.errordatos.push('El campo de vigencia fecha está vacio');
            }
            if (this.formuser.adm_estado == '') {
                this.errordatos.push('El campo de estado está vacio');
            }
            if (this.formuser.rolesasignado == []) {
                this.errordatos.push('El campo de roles asignado está vacio');
            }
            if (this.formuser.adm_password != this.formuser.adm_password2) {
                this.errordatos.push('Las conraseñas ingresadas no concuerdan');
            }
        },
        limpiadatos() {
            this.formuser.adm_name = ''
            this.formuser.adm_lastname = ''
            this.formuser.adm_inicial = ''
            this.formuser.adm_con_especialidad = ''
            this.formuser.adm_correo = ''
            this.formuser.adm_cargo = ''
            this.formuser.adm_dni = ''
            this.formuser.adm_telefono = ''
            this.formuser.adm_direccion = ''
            this.formuser.depe_id = ''
            this.formuser.adm_password = ''
            this.formuser.adm_password2 = ''
            this.formuser.adm_vigencia = ''
            this.formuser.adm_estado = ''
            this.formuser.rolesasignado = ''
        },
        recortacadena(cadena) {
            if (cadena.length >= 80) {
                var adicional = '....';
            } else {
                var adicional = '';
            }
            let extraida = cadena.substring(0, 80);
            return extraida + adicional;
        }

    }
}
</script>

<style lang="css" scoped>
/* .pagination{
        margin-bottom: 0;
    } */
</style>
