<template>
<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!-- <h1 class="m-0"> MESA DE PARTES <small>DIGITAL</small></h1> -->
                    <h5 class="m-0">{{ $route.name }}</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <router-link :to="'/mesapartes'" class="btn btn-sm btn-info">Volver a MPV</router-link>
                        </li>
                        <!-- <li class="breadcrumb-item active">{{ $route.name }}</li> -->
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->

    <div class="content">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Consulta de trámites</h4>
                        </div>
                        <!-- <div class="panel-heading">Consulta de documento</div> -->
                        <div class="card-body">
                            <p class="text-center">Esta sección es para buscar documentos y ver su estado situacional, para ello debe ingresar el correo, dni/ruc y código que se proporcionó al momento de tramitar.</p>

                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Ingrese su correo</label>
                                        <input type="email" v-model="formdatos.correo" placeholder="Ingrese su correo que proporcionó" class="form-control form-control-sm" name="correo">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">Ingrese DNI/RUC</label>
                                        <input type="number" v-model="formdatos.numero" placeholder="Ingrese su Dni/Ruc que proporcionó" class="form-control form-control-sm" name="dni">
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="">Ingrese el Código.</label>
                                        <input type="text" v-model="formdatos.codigo" placeholder="Ingrese el código propocionado por el sistema" class="form-control form-control-sm" name="codigo">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group mt-4">
                                        <button type="button" class="btn btn-primary btn-sm LoginButton" @click="cunsultatramite"><i class="fa fa-search"></i> Consultar</button>
                                    </div>

                                </div>
                            </div>

                            <div class="row" v-show="resultado">
                                <div class="col-sm-12">
                                    <table class="table table-bordered table-hover table-sm" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>DETALLES DOCUMENTO</th>
                                                <th>FIRMANTE</th>
                                                <th>DEPENDENCIA TRAMITE</th>
                                                <th>MOTIVO OBS</th>
                                                <th>FECHA OBS</th>
                                                <th nowrap>Link para subsanar</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            <tr v-for="item in tramitesexternos">
                                                <td><small>{{ item.id }}</small></td>

                                                <td><small><b>Documento:</b> {{ item.tdoc_descripcion }} N° {{ item.docu_numero_doc }}-{{ item.docu_siglas_doc }}</small> <br>
                                                    <small><b>Folios:</b>{{ item.docu_folios }}</small> <br>
                                                    <small><b>Asunto:</b>{{ item.docu_asunto }}</small> <br>
                                                    <small><b>Fecha trámite:</b>{{ item.docu_fecha_doc }}</small>
                                                </td>
                                                <td>
                                                    {{ item.docu_firma }} <br>
                                                    <small v-if="item.docu_dni"><b>DNI/RUC:</b>{{ item.docu_dni }}</small> <br>
                                                    <small v-if="item.docu_ruc"><b>DNI/RUC:</b>{{ item.docu_ruc }}</small>
                                                    <b>Teléfono:</b>{{ item.docu_telef }} <br>
                                                    <b>Correo:</b>{{ item.docu_emailorigen }} <br>
                                                </td>
                                                <td>
                                                    <small>
                                                        {{ item.depe_nombre }}
                                                    </small>
                                                </td>
                                                <td>
                                                    <template v-if="item.docu_motivo_archivamiento ">
                                                        <small>
                                                            {{item.docu_motivo_archivamiento}}
                                                        </small>
                                                    </template>

                                                    <template v-else-if="item.docu_estado!=1">
                                                        <p class="text-center">
                                                            <span class="badge bg-success text-sm"><small>No presenta observación</small></span>
                                                        </p>
                                                    </template>
                                                </td>

                                                <td nowrap>
                                                    <template v-if="item.observ_at">
                                                        <small><b>F.observación:</b>
                                                            {{item.observ_at}}
                                                        </small><br>
                                                    </template>
                                                    <template v-if="item.subs_at">
                                                        <small><b>F.subsanación:</b>
                                                            {{item.subs_at}}
                                                        </small>
                                                    </template>
                                                </td>
                                                <td>

                                                    <div v-if="item.docu_estado==0">
                                                        <p><small>Pendiente de verificación y recepción por el/la responsable de Mesa de Partes Virtual</small></p>
                                                    </div>
                                                    <div v-if="item.docu_estado==1">
                                                        <small><a :href="'/mesapartes/'+item.id+'/'+item.docu_token" target="_blank" class="btn btn-danger btn-sm">Subsanar</a></small> <br>
                                                    </div>
                                                    <div v-if="item.docu_estado==2">
                                                        <p><small><strong>Reg. Doc:</strong>
                                                                <a :href="'/tramite/buscar/buscarModal/'+item.iddocumento">{{item.iddocumento}} </a><br>
                                                                <strong>Reg. Exp:</strong>
                                                                <a :href="'/tramite/buscar/buscarExpedienteModal/'+item.docu_idexma" target="_blank">{{item.docu_idexma}} </a> </small></p>
                                                    </div>
                                                    <div v-if="item.docu_estado==3">
                                                        <p><b>Usted ha subsanado</b>, sin embargo, está pendiente de verificación y recepción por el/la responsable de Mesa de Partes Virtual</p>
                                                    </div>

                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content -->
    </div>
    <!-- modal error documento -->
    <div class="modal fade" id="mensajeeeror">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="callout callout-danger p-1" v-for="erro in errordatos">
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
// import FormDocumento from '../mesapartesvirtual/FormDocumento.vue'
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
    name: 'mesapartesvirtual',

    data() {
        return {
            formdatos: {
                correo: '',
                numero: '',
                codigo: ''
            },
            resultado: true,
            tramitesexternos: {},
            errordatos: [],

        };
    },
    components: {
        // FormDocumento
    },

    mounted() {

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
        validar() {

            this.errordatos = [];
            if (this.formdatos.correo == '') {
                this.errordatos.push('El campo de correo noestá vacío');
            }
            if (this.formdatos.numero == '') {
                this.errordatos.push('El campo número de documento está vacio');
            }
            if (this.formdatos.codigo == '') {
                this.errordatos.push('El campo de código está vacio');
            }

        },

        cunsultatramite() {
            var url = '/consulta/tramiteexterno'

            this.validar();

            if (this.errordatos.length > 0) {
                this.toast('Falta rellenar algunos datos', 'error');
                $("#mensajeeeror").modal('show')

            } else {
                axios.post(url, this.formdatos)
                    .then(res => {
                        // console.log(res.data)
                        this.tramitesexternos = res.data
                    })
            }

        }

    },
};
</script>

<style lang="scss" scoped>

    </style>
