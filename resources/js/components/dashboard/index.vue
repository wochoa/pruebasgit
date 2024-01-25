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
            <!-- Info boxes -->
            <div class="row">
                <div class="col-md-4">
                    <div class="card" style="box-shadow: -1px 0px 3px 0px rgba(0,0,0,0.50);">
                        <div class="card-body bg-gray">

                            <div class="col-md-12 clearfix">
                                <p class="pull-left" style="color: #fff;"><i class="fa fa-home"></i> Bienvenido(a) :</p>
                                <div class="float-right">
                                    <!-- <button class="btn btn-default btn-sm" ng-click="editPerfil(1)">
                                        <i class="fa fa-refresh"></i> <span style="margin-left: 5px">Actualizar Datos</span>
                                    </button> -->
                                    <router-link :to="{name:'Editar usuario',params:{id:getUsuario.id}}" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i> <span style="margin-left: 5px"></span> Actualizar Datos</router-link>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-4">
                                    <div class="col-md-offset-2 col-md-4">

                                        <img v-if="foto" :src="'data:image/jpg;base64,'+foto" class="mx-auto shadow-sm" style="width: 100px;">
                                        <img v-else :src="'/img/avatar/logo.png'" alt="" class="pull-left img-circle ng-scope" width="100px" height="100px" style="margin: 0 auto">
                                    </div>
                                </div>
                                <div class=" col-xs-6 col-sm-6 col-md-8">

                                    <div class="table-responsive">
                                        <table class="table table-condensed">
                                            <tbody>
                                                <tr>
                                                    <td colspan="2" style="text-align: center; border-top: 0px;">
                                                        {{ getUsuario.fullname }}
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>DNI</td>
                                                    <td class="ng-binding">{{ getUsuario.adm_dni }}</td>
                                                </tr>

                                                <tr>
                                                    <td>Oficina</td>
                                                    <td>{{ getDependenciaUser.nombreofi }}</td>
                                                </tr>
                                                <tr>
                                                    <td>Social</td>
                                                    <td>
                                                        <a href="#" class="btn btn-xs"><i class="fa-brands fa-facebook"></i></a>
                                                        <a href="#" class="btn btn-xs"><i class="fa-brands fa-twitter"></i></a>
                                                        <a href="#" class="btn btn-xs"><i class="fa-brands fa-linkedin"></i></a>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header p-1">
                            <h5>Manuales y videos</h5>
                        </div>
                        <div class="card-footer">
                            <ul class="mailbox-attachments d-flex align-items-stretch clearfix">
                                <li>
                                    <span class="mailbox-attachment-icon"><i class="far fa-file-pdf fa-1x"></i></span>

                                    <div class="mailbox-attachment-info">
                                        <a href="https://drive.google.com/file/d/1RLoEVHdnbAoiV8cVqNhBLEeHbepdNKmD/view?usp=sharing" target="_blank" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i> Trámite documentario.pdf</a>
                                        <span class="mailbox-attachment-size clearfix mt-1">
                                            <span>8,936 MB</span>
                                            <a href="https://drive.google.com/file/d/1RLoEVHdnbAoiV8cVqNhBLEeHbepdNKmD/view?usp=sharing" target="_blank" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                                        </span>
                                    </div>
                                </li>
                                <li>
                                    <span class="mailbox-attachment-icon"><i class="far fa-file-pdf fa-1x"></i></span>

                                    <div class="mailbox-attachment-info">
                                        <a href="https://drive.google.com/file/d/1mg8Hwr4sxYAPfGe6a01iXtuQqBVjETJf/view?usp=sharing" class="mailbox-attachment-name" target="_blank"><i class="fas fa-paperclip"></i> Firma-Digital.pdf</a>
                                        <span class="mailbox-attachment-size clearfix mt-1">
                                            <span>737 KB</span>
                                            <a href="https://drive.google.com/file/d/1mg8Hwr4sxYAPfGe6a01iXtuQqBVjETJf/view?usp=sharing" class="btn btn-default btn-sm float-right" target="_blank"><i class="fas fa-cloud-download-alt"></i></a>
                                        </span>
                                    </div>
                                </li>
                                <li>
                                    <span class="mailbox-attachment-icon"><i class="far fa-file-pdf fa-1x"></i></span>

                                    <div class="mailbox-attachment-info">
                                        <a href="https://drive.google.com/file/d/1UuJctcScWOgfIG71iK1sKsUj4n_eJ3WQ/view?usp=sharing"  target="_blank" class="mailbox-attachment-name"><i class="fas fa-paperclip"></i> Administrador dependencia.pdf</a>
                                        <span class="mailbox-attachment-size clearfix mt-1">
                                            <span>1,199 MB</span>
                                            <a href="https://drive.google.com/file/d/1UuJctcScWOgfIG71iK1sKsUj4n_eJ3WQ/view?usp=sharing" target="_blank" class="btn btn-default btn-sm float-right"><i class="fas fa-cloud-download-alt"></i></a>
                                        </span>
                                    </div>
                                </li>
                                
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="col-md-8">
                    <div class="card pt-3 pb-3 card-danger card-outline">
                        <div class="row ">
                            <div class="col-md-3" align="center">

                                <router-link :to="'/Tramites/Enproceso'" class="text-decoration-none">
                                    <p class="text-danger"><b>Documentos en Proceso de la Oficina</b></p>
                                    <radial-progress-bar :diameter="160" :completed-steps="getInicio.derivadosProceso" :total-steps="getInicio.totalProceso == 0 ? 1 : getInicio.totalProceso" startColor="#ffc107" stopColor="#ffc107" innerStrokeColor="#d3d3d3" stroke-linecap="round" :class="'principal bg-gray'">

                                        <p class="text-warning"><strong>Total: </strong>{{ getInicio.totalProceso }}</p>
                                        <p class="text-warning"><strong>Derivados: </strong>{{ getInicio.derivadosProceso }}</p>
                                        <p class="text-warning"><strong>Pendientes: </strong>{{ getInicio.totalProceso - getInicio.derivadosProceso }}</p>
                                    </radial-progress-bar>
                                </router-link>

                            </div>

                            <div class="col-md-3" align="center">

                                <router-link :to="'/Tramites/Enproceso'" class="text-decoration-none">
                                    <p class="text-danger"><b>Documentos en proceso</b></p>
                                    <radial-progress-bar :diameter="160" :completed-steps="getInicio.usuarioDerivadosProceso" :total-steps="getInicio.usuarioProceso == 0 ? 1 : getInicio.usuarioProceso" startColor="#20c997" stopColor="#20c997" innerStrokeColor="#d3d3d3" stroke-linecap="round">

                                        <p><strong>Total: </strong> {{ getInicio.usuarioProceso }}</p>
                                        <p><strong>Atendidos: </strong>{{ getInicio.usuarioDerivadosProceso }}</p>
                                        <!-- <a :href="routes['tramite.enproceso.index'].route + '#pendiente'"> -->
                                        <strong>Pendientes: </strong>{{ getInicio.usuarioProceso - getInicio.usuarioDerivadosProceso }}
                                        <!-- </a> -->
                                    </radial-progress-bar>
                                </router-link>

                            </div>

                            <div class="col-md-3" align="center">

                                <router-link :to="'/Tramites/Porrecibir'" class="text-decoration-none">
                                    <p class="text-danger"><b>Documentos por recibir</b></p>
                                    <radial-progress-bar :diameter="160" :completed-steps="getInicio.usuarioRecibir" :total-steps="getInicio.totalRecibir == 0 ? 1 : getInicio.totalRecibir" startColor="#6f42c1" stopColor="#6f42c1" innerStrokeColor="#d3d3d3">
                                        <p><strong>Total: </strong>{{ getInicio.totalRecibir }}</p>
                                        <p><strong>Personal: </strong>{{ getInicio.usuarioRecibir }}</p>
                                    </radial-progress-bar>
                                </router-link>

                            </div>

                            <div class="col-md-3" align="center">

                                <router-link :to="'/Tramites/Archivados'" class="text-decoration-none">
                                    <p class="text-danger"><b>Documentos archivados</b></p>

                                    <radial-progress-bar :diameter="160" :completed-steps="getInicio.usuarioArchivados" :total-steps="getInicio.totalArchivado == 0 ? 1 : getInicio.totalArchivado" startColor="#ffc107" stopColor="#ffc107" innerStrokeColor="#d3d3d3" :class="'principal bg-info'">
                                        <p><strong>Total: </strong>{{ getInicio.totalArchivado }}</p>
                                        <p><strong>Personal: </strong>{{ getInicio.usuarioArchivados }}</p>
                                        <strong>Temporal: </strong>{{ getInicio.usuariosArchivadosTemporal }}
                                    </radial-progress-bar>
                                </router-link>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <p class="bg-info pl-2 pr-2 rounded">Total Documento ingresado MPV: {{ getInicio.totalMpv }}</p><br>
                        </div>
                        <div class="col-md-6">
                            <p class="bg-warning pl-2 pr-2 rounded">Documento ingresado MPV para el Usuario: {{ getInicio.usuariosMpv }}</p>
                        </div>
                    </div>
                </div>
            </div>

        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

</div>
</template>

<script>
import axios from 'axios';
import RadialProgressBar from 'vue-radial-progress'
import Vuex from 'vuex'
export default {
    name: 'StdvIndex',

    data() {
        return {
            completedSteps: 5,
            totalSteps: 10,
            gradientAnimation: 10,
            getInicio: {
                totalDocGenerados: 1,
                usuarioDocGenerados: 0,
                totalPlantilla: 1,
                usuarioPlantilla: 0,
                totalArchivados: 1,
                usuarioArchivados: 0,
                totalRecibir: 1,
                usuarioRecibir: 0,
                totalProceso: 1,
                derivadosProceso: 0,
                usuarioProceso: 1,
                usuarioDerivadosProceso: 0,
                usuariosArchivadosTemporal: 0,
                totalMpv: 0,
                usuariosMpv: 0
            },
            foto: ''
        };
    },

    components: {
        RadialProgressBar
    },

    mounted() {
        this.datosparagrafico();
        if (this.$attrs.usuario.adm_dni) {
            this.fotografia(this.$attrs.usuario.adm_dni)
        }
    },
    computed: {
        // ...Vuex.mapGetters(['getDependenciaUser', 'getPeriodosCorrelativo', 'getUsuario']),
        ...Vuex.mapGetters(['getDependenciaUser', 'getUsuario'])

    },
    methods: {
        datosparagrafico() {
            var url = '/tramite/obtenerTotal';
            axios.get(url)
                .then(response => {
                    this.getInicio.totalProceso = response.data.totalProceso
                    this.getInicio.derivadosProceso = response.data.derivadosProceso
                    this.getInicio.usuarioProceso = response.data.usuarioProceso
                    this.getInicio.totalRecibir = response.data.totalRecibir
                    this.getInicio.usuarioRecibir = response.data.usuarioRecibir
                    this.getInicio.totalArchivado = response.data.totalArchivado
                    this.getInicio.usuarioArchivados = response.data.usuarioArchivados
                    this.getInicio.usuarioDerivadosProceso = response.data.usuarioDerivadosProceso
                    this.getInicio.usuariosArchivadosTemporal = response.data.usuariosArchivadosTemporal
                    this.getInicio.totalMpv = response.data.totalMpv
                    this.getInicio.usuariosMpv = response.data.usuariosMpv
                });
        },
        fotografia(dni) {

            var url = '/reniec/' + dni
            axios.get(url)
                .then(res => {
                    this.foto = res.data.foto
                })

        },
        comunicados()
        {
            var url='/'
        }
    },
};
</script>

<style lang="scss" scoped>
.col-centered {
    float: none;
    margin: 0 auto;
}
</style>
