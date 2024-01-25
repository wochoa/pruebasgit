<template>
<div>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-warning elevation-4">
        <!-- Brand Logo -->
        <!-- <router-link :to="'/'" class="brand-link text-decoration-none">
            <img :src="ruta+'/dist/img/AdminLTELogo.png'" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light ">Administrador</span>
        </router-link> -->
        <img :src="ruta+'/img/logo2.png'" alt="User Image" width="250">

        <!-- Sidebar -->
        <div class="sidebar mt-2">
            <!-- Sidebar user panel (optional) -->
            <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <div class="image">
                    <img :src="ruta+'/img/logo2.png'" class="img-circle elevation-2" alt="User Image">
                    <img v-if="foto" :src="'data:image/jpg;base64,'+foto" class="pull-left img-circle ng-scope" width="100px" height="100px" style="margin: 0 auto">
                    <img v-else :src="this.ruta+'/img/avatar/logo.png'" alt="" class="pull-left img-circle ng-scope" width="100px" height="100px" style="margin: 0 auto">
                </div>
                <div class="info">
                    <router-link :to="{name:'Editar usuario',params:{id:usuario.id }}" class="d-block text-decoration-none">{{usuario.fullname}}</router-link>
                </div>

            </div> -->


            <!-- SidebarSearch Form -->
            <div class="form-inline">
                <div class="input-group" data-widget="sidebar-search">
                    <input class="form-control form-control-sidebar" type="search" placeholder="Buscar" aria-label="Search">
                    <div class="input-group-append">
                        <button class="btn btn-sidebar">
                            <i class="fas fa-search fa-fw"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                    <li class="nav-item" v-if="can('dashboard')">
                        <router-link :to="'/'" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </router-link>

                        <!-- <a href="pages/widgets.html" class="nav-link">
                            <i class="nav-icon fas fa-th"></i>
                            <p>
                                Dashboard
                                <span class="right badge badge-danger">New</span>
                            </p>
                        </a> -->
                    </li>
                    <li class="nav-item" v-if="can('index_tramite')">
                        <a href="#" class="nav-link">
                            <i class="fa-solid fa-users-gear"></i>
                            <p>
                                TRAMITE DOCUMENTARIO
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item" v-if="can('nuevo_tramite')">
                                <router-link :to="'/Tramites/Nuevotramite'" class="nav-link">
                                    <i class="fa-solid fa-file-medical"></i>
                                    <p>NUEVO TRÁMITE</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="can('despacho_tramite')">
                                <router-link :to="'/Tramites/Enproceso'" class="nav-link">
                                    <i class="fa-solid fa-plane-departure"></i>
                                    <p>EN PROCESO</p>

                                </router-link>
                            </li>
                            <li class="nav-item" v-if="can('recepcion_tramite')">
                                <router-link :to="'/Tramites/Porrecibir'" class="nav-link">
                                    <i class="fa-solid fa-download"></i>
                                    <p>RECEPCION</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="can('archivados_tramite')">
                                <router-link :to="'/Tramites/Archivados'" class="nav-link">
                                    <i class="fa-regular fa-folder-open"></i>
                                    <p>ARCHIVADOS</p>
                                </router-link>
                            </li>

                        </ul>
                    </li>
                    <li class="nav-item" v-if="can('catalogo_archivador')">
                        <router-link :to="'/catalogos'" class="nav-link">
                            <i class="fa-solid fa-file-zipper"></i>
                            <p>CATÁLOGO ARCHIVADORES</p>
                        </router-link>

                    </li>
                    <li class="nav-item" v-if="can('index_mesapartes')">
                        <a href="#" class="nav-link">
                            <i class="fa-solid fa-users-gear"></i>
                            <p>
                                MESA DE PARTES
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item" v-if="can('mesapartes_fisico')">
                                <router-link :to="'/Tramites/Fisico'" class="nav-link">
                                    <i class="fa-solid fa-users-between-lines"></i>
                                    <p>MESA PARTES FISICO</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="can('mesapartes_virtual')">
                                <router-link :to="'/Tramites/virtual'" class="nav-link">
                                    <i class="fa-solid fa-users-rectangle"></i>
                                    <p>MESA PARTES VIRTUAL</p>
                                </router-link>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item" v-if="can('index_reportes')">
                        <router-link :to="'/Reportes'" class="nav-link">
                            <i class="fa-solid fa-bars-staggered"></i>
                            <p>REPORTES</p>
                        </router-link>

                    </li>

                    <!-- <li class="nav-item" v-if="can('index_reportes')">
                        <a href="#" class="nav-link">
                            <i class="fa-solid fa-users-gear"></i>
                            <p>
                                REPORTES
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item" v-if="can('mesapartes_fisico')">
                                <router-link :to="'/Tramites/Fisico'" class="nav-link">
                                    <i class="fa-solid fa-users-between-lines"></i>
                                    <p>DOC. GENERADOS POR UNI.ORG.</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="can('mesapartes_virtual')">
                                <router-link :to="'/Tramites/virtual'" class="nav-link">
                                    <i class="fa-solid fa-users-rectangle"></i>
                                    <p>DOC. RECIBIDOS</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="can('mesapartes_virtual')">
                                <router-link :to="'/Tramites/virtual'" class="nav-link">
                                    <i class="fa-solid fa-users-rectangle"></i>
                                    <p>DOCUMENTOS ARCHVIVADOS</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="can('mesapartes_virtual')">
                                <router-link :to="'/Tramites/virtual'" class="nav-link">
                                    <i class="fa-solid fa-users-rectangle"></i>
                                    <p>DOCUMENTOS EN PROCESO</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="can('mesapartes_virtual')">
                                <router-link :to="'/Tramites/virtual'" class="nav-link">
                                    <i class="fa-solid fa-users-rectangle"></i>
                                    <p>DOCUMENTOS DERIVADOS</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="can('mesapartes_virtual')">
                                <router-link :to="'/Tramites/virtual'" class="nav-link">
                                    <i class="fa-solid fa-users-rectangle"></i>
                                    <p>FORMATO. DOC.DERIVADOS/RECIBIR</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="can('mesapartes_virtual')">
                                <router-link :to="'/Tramites/virtual'" class="nav-link">
                                    <i class="fa-solid fa-users-rectangle"></i>
                                    <p>DOCUMENTO TRAMITADOS</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="can('mesapartes_virtual')">
                                <router-link :to="'/Tramites/virtual'" class="nav-link">
                                    <i class="fa-solid fa-users-rectangle"></i>
                                    <p>ARCHIVADORES</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="can('mesapartes_virtual')">
                                <router-link :to="'/Tramites/virtual'" class="nav-link">
                                    <i class="fa-solid fa-users-rectangle"></i>
                                    <p>HOJA DE TRAMITE</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="can('mesapartes_virtual')">
                                <router-link :to="'/Tramites/virtual'" class="nav-link">
                                    <i class="fa-solid fa-users-rectangle"></i>
                                    <p>ADMINISTRAR USUARIOS</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="can('mesapartes_virtual')">
                                <router-link :to="'/Tramites/virtual'" class="nav-link">
                                    <i class="fa-solid fa-users-rectangle"></i>
                                    <p>USUARIOS</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="can('mesapartes_virtual')">
                                <router-link :to="'/Tramites/virtual'" class="nav-link">
                                    <i class="fa-solid fa-users-rectangle"></i>
                                    <p>DOCUMENTO EXTERNO XDEPEDENCIA</p>
                                </router-link>
                            </li>
                        </ul>
                    </li> -->

                    <li class="nav-item" v-if="can('interoperabilidad')">
                        <a href="#" class="nav-link">
                            <i class="fa-solid fa-users-gear"></i>
                            <p>
                                INTEROPERABILIDAD
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-header">DESPACHO</li>
                            <li class="nav-item">
                                <router-link :to="'/despacho/pendientes'" class="nav-link">
                                    <i class="nav-icon far fa-calendar-alt"></i>
                                    <p>
                                        Pendientes
                                        <span class="badge badge-info right">2</span>
                                    </p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="'/despacho/enviados'" class="nav-link">
                                    <i class="nav-icon far fa-image"></i>
                                    <p>
                                        Enviados
                                    </p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="'/despacho/recepcionados'" class="nav-link">
                                    <i class="nav-icon fas fa-columns"></i>
                                    <p>
                                        Repecionados
                                    </p>
                                </router-link>
                            </li>

                            <li class="nav-item">
                                <router-link :to="'/despacho/observados'" class="nav-link">
                                    <i class="nav-icon fas fa-file"></i>
                                    <p>Observados</p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="'/despacho/subsanados'" class="nav-link">
                                    <i class="nav-icon fas fa-file"></i>
                                    <p>Subsanados</p>
                                </router-link>
                            </li>

                            <li class="nav-header">RECEPCION</li>
                            <li class="nav-item">
                                <router-link :to="'/recepcion/pendientes'" class="nav-link">
                                    <i class="nav-icon far fa-calendar-alt"></i>
                                    <p>
                                        Pendientes
                                        <span class="badge badge-info right">2</span>
                                    </p>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="'/recepcion/recepcionados'" class="nav-link">
                                    <i class="nav-icon fas fa-columns"></i>
                                    <p>
                                        Repecionados
                                    </p>
                                </router-link>
                            </li>

                            <li class="nav-item">
                                <router-link :to="'/recepcion/observados'" class="nav-link">
                                    <i class="nav-icon fas fa-file"></i>
                                    <p>Observados</p>
                                </router-link>
                            </li>

                        </ul>
                    </li>
                    <li class="nav-item" v-if="can('index_administracion')">
                        <a href="#" class="nav-link">
                            <i class="fa-solid fa-users-gear"></i>
                            <p>
                                ADMINISTRACION
                                <i class="fas fa-angle-left right"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item" v-if="can('index_entidadexterna')">
                                <router-link :to="'/Administracion/dependenciaExterna'" class="nav-link">
                                    <i class="fa-solid fa-house-signal"></i>
                                    <p>ENTIDADES EXTERNAS</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="can('index_unidadorganica')">
                                <router-link :to="'/Administracion/unidadorganicas'" class="nav-link">
                                    <i class="fa-solid fa-house-user"></i>
                                    <p>UNIDADES ORGANICAS</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="can('index_unidadorganicaxdepe')">
                                <router-link :to="'/Administracion/unidaddependencia'" class="nav-link">
                                    <i class="fa-solid fa-house-flag"></i>
                                    <p>UNIDADES x DEPENDENCIA</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="can('index_dependencia')">
                                <router-link :to="'/Administracion/dependencia'" class="nav-link">
                                    <i class="fa-solid fa-building-columns"></i>
                                    <p>DEPENDENCIA</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="can('index_tipodocumento')">
                                <router-link :to="'/Administracion/tipodocumentos'" class="nav-link">
                                    <i class="fa-solid fa-file-import"></i>
                                    <p>TIPO DOCUMENTO</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="can('index_correlativo')">
                                <router-link :to="'/Administracion/correlativos'" class="nav-link">
                                    <i class="fa-solid fa-c"></i>
                                    <p>DOCUMENTO CORRELATIVO</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="can('index_usuarios')">
                                <router-link :to="'/Administracion/usuarios'" class="nav-link">
                                    <i class="fa-regular fa-circle-user nav-icon"></i>
                                    <p>USUARIOS</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="can('index_anuncios')">
                                <router-link :to="'/Administracion/Publicaciones'" class="nav-link">
                                    <i class="fa-solid fa-vault nav-icon"></i>
                                    <p>PUBLICAR ANUNCIOS</p>
                                </router-link>
                            </li>
                            <li class="nav-item" v-if="can('index_atenderfoliosasuntos')">
                                <router-link :to="'/Administracion/foliosasunto'" class="nav-link">
                                    <!-- <i class="fa-solid fa-vault nav-icon"></i> -->
                                    <i class="fa-solid fa-paperclip"></i>
                                    <p>FOLIOS Y ASUNTO</p>
                                </router-link>
                            </li>
                            <li class="nav-item border-top" v-if="can('index_roles')">
                                <router-link :to="'/Administracion/rolesypermisos'" class="nav-link">
                                    <i class="fa-solid fa-key"></i>
                                    <p>ROLES Y PERMISOS</p>
                                </router-link>
                            </li>

                        </ul>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</div>
</template>

<script>
import axios from 'axios'
export default {
    name: 'StdvSidebar',
    props: ['ruta', 'usuario'],

    data() {
        return {
            foto:'',
            dni:this.usuario.adm_dni
        };
    },

    mounted() {
        if(this.usuario.adm_dni)
        {
            this.fotografia(this.usuario.adm_dni)
        }
    },

    methods: {
        fotografia(dni) {

            var url = '/reniec/' + dni
            axios.get(url)
                .then(res => {
                    this.foto = res.data.foto
                })

        }
    },
};
</script>

<style lang="scss" scoped>

</style>
