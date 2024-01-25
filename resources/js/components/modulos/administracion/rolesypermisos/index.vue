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
        <div class="container-fluid"  v-if="is('SUPERADMIN')">
            <div class="row">
                <div class="col-lg-6 col-10">
                    <router-link :to="'/Tramites/Enproceso'" class="btn btn-info btn-sm"><i class="fa-regular fa-circle-left"></i> ir a documentos en proceso</router-link>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6">
                    <div class="card card-primary card-outline ">
                        <div class="card-header p-1">
                            ROLES
                        </div>
                        <div class="card-body">

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="">Rol</label>

                                        <input type="text" class="form-control form-control-sm" v-model="nombrerol" placeholder="Ingrese el rol" onkeyup="javascript:this.value=this.value.toUpperCase();">

                                    </div>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="">Permisos</label>
                                <el-select v-model="permisosrol" multiple filterable placeholder="Selecione su permiso" size="small" style="width: 100%;">
                                    <el-option v-for="item in datos.permisos" :key="item.id" :label="item.name" :value="item.id">
                                    </el-option>
                                </el-select>
                            </div>
                            <div class="float-right">
                                <button class="btn btn-sm btn-primary" @click="agregarrol"><i class="fa-solid fa-plus"></i> Agregar rol</button>
                            </div>
                            <h5>Lista de roles</h5>

                            <table class="table table-bordered table-hover table-sm mt-3">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Roles</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="rol in datos.roles">
                                        <td>{{ rol.id }}</td>
                                        <td>{{ rol.name }}</td>
                                        <td>
                                            <button class="bt btn btn-warning btn-xs" @click="editarrol(rol.id,rol.name)"><i class="fa-solid fa-pen-to-square"></i></button>
                                            <button class="bt btn btn-info btn-xs" @click="editarrol(rol.id,rol.name)"><i class="fa-solid fa-eye"></i></button>
                                            <button class="bt btn btn-danger btn-xs" @click="eliminarrol(rol.id)"><i class="fa-solid fa-trash-can"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- <div class="card-footer clearfix">
                            ejemplo
                        </div> -->
                    </div>
                </div>
                <div class="col-md-4" v-show="mostrarpermiso">
                    <div class="card card-primary card-outline ">
                        <div class="card-header p-1">
                            <h5>Lista de Permisos del rol : <b>{{ nombrerol }}</b> </h5>
                        </div>
                        <div class="card-body">

                            <table class="table table-bordered table-hover table-sm">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Permiso</th>
                                        <th>Asignación</th>
                                        <!-- <th>Acciones</th> -->
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="per in datos.permisos">
                                        <td>{{ per.id }}</td>
                                        <td>{{ per.name }}</td>
                                        <td v-if="verificaasignacion(per.id)==1">
                                            <button class="btn btn-xs btn-success" @click.prevent="quitarpermiso(per.id)"><i class="fa-solid fa-toggle-on"></i></button>
                                        </td>
                                        <td v-else>
                                            <button class="btn btn-xs btn-danger" @click.prevent="asinarpermiso(per.id)"><i class="fa-solid fa-toggle-off"></i></button>
                                        </td>
                                        <!-- <td>
                                            <button class="bt btn btn-warning btn-sm" @click="editarpermiso(per.id,per.name)"><i class="fa-solid fa-pen-to-square"></i></button>
                                            <button class="bt btn btn-danger btn-sm" @click="eliminarpermiso"><i class="fa-solid fa-trash-can"></i></button>
                                        </td> -->
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- <div class="card-footer clearfix">
                            ejemplo
                        </div> -->
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

    <!-- MODAL EDITAR PERMISO -->
    <div class="modal fade" id="editpermiso">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">EDITAR PERMISO</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">Permiso</label>
                        <input type="text" v-model="formpermiso.nomper" class="form-control form-control-sm" onkeyup="javascript:this.value=this.value.toUpperCase();">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">CERRAR</button>
                    <button type="button" class="btn btn-primary" @click.prevent="updatepermiso">GUARDAR</button>
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
import axios from 'axios';
import swal from 'sweetalert2';
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

    data() {
        return {
            nombrepermiso: null,
            nombrerol: null,
            formpermiso: {
                idper: null,
                nomper: null
            },
            datos: [],
            permisootorgado: [],
            permisosrol: [],
            mostrarpermiso: false,
            idrol:'',
            nombrerol:''

        }
    },
    mounted() {
        this.rolerypermisos();

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
        agregarpermiso() {
            var url = '/addpermisos'
            var datos = {
                'nuevopermiso': this.nombrepermiso
            }
            axios.post(url, datos)
                .then(res => {
                    // console.log(res.data)
                    this.toast('se agrego correctamente', 'success');
                })

            this.rolerypermisos();

        },
        rolerypermisos() {
            var url = '/rolesypermisos'
            axios.get(url)
                .then(res => {
                    this.datos = res.data
                })
        },
        agregarrol() {

        },
        editarpermiso(id, nombre) {
            $('#editpermiso').modal('show');
            this.formpermiso.idper = id;
            this.formpermiso.nomper = nombre;
        },
        updatepermiso() {
            var url = '/updatepermisos'
            var datos = {
                'id': this.formpermiso.idper,
                'nombre': this.formpermiso.nomper
            }
            axios.post(url, datos)
                .then(res => {
                    // console.log(res.data)
                    this.toast('se actualizó correctamente', 'success');
                    this.rolerypermisos();
                    $('#editpermiso').modal('hide');
                })
        },
        eliminarpermiso() {

        },
        editarrol(id,nombre) {
            var url = '/verpermisos/' + id;
            axios.get(url)
                .then(res => {
                    // console.log(res.data)
                    this.permisootorgado = res.data
                    this.idrol=id
                    this.nombrerol=nombre
                    if (this.permisootorgado.length) {
                        this.mostrarpermiso = true
                        this.rolerypermisos();
                    }
                    
                })
        },
        verificaasignacion(idper) {
            if (this.permisootorgado.length) {
                const search = this.permisootorgado.filter(idpermiso => idpermiso.id === idper);
                if(search.length)
                {
                    // var hmtl='<button class="btn btn-xs btn-success" @click.prevent="quitarpermiso('+idper+')"><i class="fa-solid fa-toggle-on"></i></button>'
                    var dato=1
                }
                else{
                    // var hmtl='<button class="btn btn-xs btn-danger" @click.prevent="asinarpermiso('+idper+')"><i class="fa-solid fa-toggle-off"></i></button>'
                    var dato=0
                }
                return dato;
                
            }

        },
        quitarpermiso(id)
        {
           const param={
            'idrol':this.idrol,
            'idpermiso':id
           }
           axios.post('/quitarperdelrol',param)
           .then(res=>{
            // console.log(res.data)
            this.editarrol(this.idrol,this.nombrerol)
           })
        },
        asinarpermiso(id)
        {
            const param={
            'idrol':this.idrol,
            'idpermiso':id
           }
           axios.post('/agregarperdelrol',param)
           .then(res=>{
            this.editarrol(this.idrol,this.nombrerol)
            // console.log(res.data)
           })
        },
        eliminarrol() {

        }

    }
}
</script>

<style lang="css" scoped>
/* .pagination{
           margin-bottom: 0;
       } */
</style>
