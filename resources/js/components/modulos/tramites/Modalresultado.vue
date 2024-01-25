<template>
<div class="modal fade" id="modalImprimir" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header pt-0 pb-0">
                <!-- <button type="button" class="close" data-dismiss="true" style="color:red">&times;</button> -->
                <h4 class="modal-title">Datos del documento

                    <br>
                    <span class="text-sm">
                        <strong>Reg. Documento: </strong>{{ ('00000000' + getBuscarDocumento.iddocumento).slice(-8) }}
                        <strong>Expediente: </strong>{{ ('00000000' + getBuscarDocumento.expediente).slice(-8) }}
                    </span>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">X</span>
                </button>

            </div>
            <div class="modal-body">
                <div>
                    <table>
                        <thead></thead>
                        <tbody>
                            <tr>
                                <td style="width: 10%"><strong>Documento: </strong></td>
                                <td style="width: 40%; font-size: 11px">
                                    {{ getBuscarDocumento.tdoc_descripcion + ' '
                  }}{{ ('000000' + getBuscarDocumento.docu_numero_doc).slice(-6)
                  }}{{ getBuscarDocumento.docu_origen == 1 ? '-' + getBuscarDocumento.docu_fecha_doc.substr(0, 4) : ''
                  }}{{ getBuscarDocumento.docu_siglas_doc != null ? '-' + getBuscarDocumento.docu_siglas_doc : '' }}<br />
                                </td>
                                <td style="width: 10%"><strong>Fecha_doc: </strong></td>
                                <td style="width: 40%; font-size: 11px">{{ getBuscarDocumento.docu_fecha_doc }}</td>
                            </tr>
                            <tr>
                                <td><strong>Asunto: </strong></td>
                                <td style="font-size: 11px">{{ getBuscarDocumento.docu_asunto }}</td>
                                <td><strong>Folios: </strong></td>
                                <td style="font-size: 11px">{{ getBuscarDocumento.docu_folios }}</td>
                            </tr>
                            <tr>
                                <td><strong>Firma: </strong></td>
                                <td style="font-size: 11px">{{ getBuscarDocumento.docu_firma }}</td>
                                <td><strong>Cargo: </strong></td>
                                <td style="font-size: 11px">{{ getBuscarDocumento.docu_cargo }}</td>
                            </tr>
                            <tr>
                                <td><strong>Dependencia: </strong></td>
                                <td style="font-size: 11px">{{ getBuscarDocumento.dependencia?getBuscarDocumento.dependencia:getBuscarDocumento.unidad }}</td>
                                <td><strong>Unidad: </strong></td>
                                <td style="font-size: 11px">{{ getBuscarDocumento.unidad }}</td>
                            </tr>
                            <tr v-if=" (getBuscarDocumento.docu_emailorigen || getBuscarDocumento.docu_telef)">
                                <td><strong>correo: </strong></td>
                                <td style="font-size: 11px"><a :href="'mailto:'+getBuscarDocumento.docu_emailorigen">
                                        {{ getBuscarDocumento.docu_emailorigen?getBuscarDocumento.docu_emailorigen:'' }}
                                    </a></td>
                                <td><strong>celular: </strong></td>
                                <td style="font-size: 11px"><a :href="'tel:+51'+getBuscarDocumento.docu_telef">
                                        {{ getBuscarDocumento.docu_telef?getBuscarDocumento.docu_telef:'' }}
                                    </a></td>
                            </tr>
                            <tr>
                                <td v-if="getBuscarDigitales.length "><strong>Digitales: </strong></td>
                                <td v-else></td>
                                <td style="font-size: 11px" colspan="3">
                                    <div v-if="getBuscarDigitales.length ">
                                        <table>
                                            <tbody>
                                                <tr v-for="(archivo, index) in getBuscarDigitales.filter(d => d.file_mostrar)" :key="index">
                                                    <td>
                                                        <button type="button" class="btn btn-xs btn-link doc-link" @click.stop="imprimirDocumentoPdf({id:archivo.id, id_documento:archivo.id_documento, file_tipo: archivo.file_tipo, file_name: archivo.file_name, tipo:1})">
                                                            <span style="color:blue;font-size:80%">{{ getFormatBytes(archivo.file_size) }}</span>
                                                            <!-- <span v-if="archivo.file_principal != null" :class="archivo.file_principal? 'badge badge-danger': 'badge badge-warning'">
                                                                {{ archivo.file_principal?'P':'A' }}
                                                            </span> -->
                                                            <span v-if="archivo.file_principal==0" class="badge badge-danger">P</span>
                                                            <span v-else class="badge badge-warning">A</span>

                                                            <span :class="
                                                                            archivo.file_tipo.indexOf('image') === 0
                                                                                ? 'glyphicon glyphicon-picture'
                                                                                : 'glyphicon glyphicon-file'
                                                                            "></span>
                                                            {{ archivo.file_name }}
                                                        </button>
                                                    </td>
                                                    <td>
                                                        <span style="color:red">{{ 'Fecha Adjuntada: '+archivo.created_at.substr(0, 10) }}</span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </td>

                            </tr>
                            <tr v-if="getBuscarRelacionados.length > 0">
                                <td colspan="4"><strong>Documentos Relacionados: </strong></td>
                            </tr>
                            <tr v-for="(relacionado, indexRelacion) in getBuscarRelacionados" :key="indexRelacion">
                                <td colspan="4">
                                    <a href="#" @click.prevent="recargar(relacionado.iddocumento)">{{ ('00000000' +relacionado.iddocumento).slice(-8) }} - {{ relacionado.tdoc_descripcion + ' ' }}
                                        {{ ('000000' + relacionado.docu_numero_doc).slice(-6) }}{{ '-' + relacionado.docu_siglas_doc }}:
                                    </a>
                                    <a v-if="relacionado.docu_archivo != null " href="#" @click.prevent="imprimirDocumentoPdf(relacionado.iddocumento)">
                                        <span class="glyphicon glyphicon-print"></span> Ver Documento</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <br />
                    <!--TABLA-->
                    <div class="box">
                        <div class="box-body">
                            <table class="table table-bordered table-condensed">
                                <tbody>
                                    <tr>
                                        <td style="width: 1%">
                                            <div id="commits-graph2"></div>
                                        </td>
                                        <td>
                                            <div class="list-group float-end">
                                                <a v-for="(operacion, index) in getBuscarOperaciones" :key="index" 
                                                    :class="{
                                                            'list-group-item text-decoration-none text-dark': true,
                                                            'list-group-item-success text-decoration-none text-dark':parseInt(operacion.oper_idtope) === 3 || parseInt(operacion.oper_idtope === 4),
                                                            'list-group-item-danger active text-decoration-none text-white':
                                                                parseInt(operacion.oper_procesado) === 0 &&
                                                                parseInt(operacion.oper_idtope) !== 3 &&
                                                                parseInt(operacion.oper_idtope) !== 4
                                                            }" 
                                                    :set="
                                                            (demora = {
                                                            dias: (operacion.fecha_procesado !== null
                                                                ? moment(operacion.fecha_procesado)
                                                                : moment()
                                                            ).diff(moment(operacion.created_at), 'days'),
                                                            horas: (operacion.fecha_procesado !== null
                                                                ? moment(operacion.fecha_procesado)
                                                                : moment()
                                                            ).diff(moment(operacion.created_at), 'hours'),
                                                            minutos: (operacion.fecha_procesado !== null
                                                                ? moment(operacion.fecha_procesado)
                                                                : moment()
                                                            ).diff(moment(operacion.created_at), 'minutes')
                                                            })
                                                ">

                                                    <div class="row">
                                                        <div class="col-6">
                                                            <h5 class="list-group-item-heading">
                                                                {{
                                                            operacion.oper_idtope == 1
                                                                ? 'REGISTRADO': operacion.oper_idtope == 2
                                                                ? 'DERIVADO': operacion.oper_idtope == 3
                                                                    ? 'ARCHIVADO EN FILE: ' + operacion.arch_periodo + '/' + operacion.arch_nombre: 'ADJUNTADO AL '
                                                            }}
                                                                <a v-if="operacion.oper_idtope == 4" style="font-size:20px" href="#" @click.prevent="recargar(operacion.oper_iddocumento_adj)"> <b>{{ ('00000000' + operacion.oper_iddocumento_adj).slice(-8) }} </b></a>
                                                                en {{ operacion.oper_forma == 0 ? 'ORIGINAL' : 'COPIA' }}
                                                            </h5>

                                                        </div>
                                                        <div class="col-6">
                                                            <span class="ml-2 badge badge-info float-right">{{ moment(operacion.created_at).format('DD/MM/YYYY  h: mm: ss')}}</span>
                                                            <span v-if="operacion.oper_idtope !== 3 && operacion.oper_idtope !== 4" :class="{
                                                                badge: true,
                                                                'badge-light float-right': demora.dias > 20,
                                                                'badge-warning float-right': demora.dias > 10 && demora.dias <= 20,
                                                                'badge-success float-right': demora.dias <= 10 }">
                                                                {{ demora.dias > 0
                                                                ? demora.dias + ' días'
                                                                : demora.horas > 0
                                                                    ? demora.horas + ' horas'
                                                                    : demora.minutos > 0
                                                                    ? demora.minutos + ' minutos'
                                                                    : 'al instante'
                                                                }}
                                                            </span>

                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div :class="{
                                                                        'col-md-10 col-xs-10': operacion.depe_destino == null,
                                                                        'col-md-6 col-xs-6': operacion.depe_destino != null
                                                                    }">
                                                            <div :title="operacion.dependencia">{{ operacion.unidad }}</div>
                                                            <div>{{ operacion.nombre + ' ' + operacion.apellido }}</div>
                                                        </div>
                                                        <div :class="operacion.depe_destino == null ? 'col-md-2 col-xs-2' : 'col-md-6 col-xs-6'">
                                                            <div v-if="operacion.depe_destino != null">{{ operacion.depe_destino }}</div>
                                                            <div v-if="operacion.adm_name_destino != null">
                                                                {{ operacion.adm_name_destino + ' ' + operacion.adm_lastname_destino }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <p v-if="operacion.oper_acciones != null" class="list-group-item-text">
                                                        <span v-if="operacion.oper_detalledestino != null && operacion.oper_detalledestino.length > 0">
                                                            {{ operacion.oper_detalledestino + '/' }}</span>
                                                        <span v-else>&nbsp;</span>{{ operacion.oper_acciones }}
                                                    </p>

                                                    <p v-if="operacion.depe_destino == null && operacion.oper_detalledestino != null" class="list-group-item-text">
                                                        <strong>OBS: </strong>{{ operacion.oper_detalledestino }}
                                                    </p>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!--FIN TABLA -->
                </div>
            </div>
            <!-- <div class="modal-footer">
                <button v-if="!getBuscarFormModal" type="button" class="btn btn-sm btn-warning" @click="regresar">
                    Volver atrás
                </button>
                <button v-if="!getBuscarFormModal" type="button" class="btn btn-sm btn-primary" @click="imprimirDocumento()">
                    Imprimir
                </button>
                <button v-if="getBuscarFormModal" type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div> -->
        </div>
    </div>
</div>
</template>

<script>
import $ from "jquery";
import axios from 'axios';
import moment from 'moment'

import Vuex from 'vuex'

import * as jQuery from 'jquery';
window['jQuery'] = jQuery;
// window.$ = window.jQuery = require('jquery')

let grap = require('../../../jquery.commits-graph.js');
window.fn = grap;

export default {
    name: 'ModalResultados',
    // props: ['datomodal'],

    data() {
        return {
            getBuscarDocumento: [],
            getBuscarOperaciones: [],
            getBuscarRelacionados: [],
            getBuscarDigitales: [],
            datomodal: {
                iddocumento: null,
                modal: false
            },
            // variables para graficar
            buscar: {
                numeroBranchs: 0,
                grafico: [],
                imagenes: []
            }
        };
    },

    mounted() {
        // if (this.datomodal.modal == true) {
        //     this.buscardocumento()
        //     // $("modalImprimir").modal()
        //     // $('#modalImprimir').modal('hide');

        // }

    },

    methods: {
        // ...Vuex.mapActions(['imprimirDocumentoPdf']),

        buscardocumento: async function (documento = null) {

            // var status = document.querySelector('#estadoFirma')
            // var config = document.querySelector('#configFirma')
            // status.style.display = 'none'
            // config.style.display = ''
            // this.img = this.imgs.s_load
            $('#modalImprimir').modal({
                // backdrop: 'static',
                keyboard: false
            })
            this.datomodal.iddocumento = documento.iddocumento
            this.datomodal.modal = documento.modal

            var url = '/documento/buscarDocumento?iddocumento=' + this.datomodal.iddocumento + '&modal=' + this.datomodal.modal
            axios.get(url)
                .then(resp => {
                    this.getBuscarDocumento = resp.data.documento
                    this.getBuscarOperaciones = resp.data.operaciones
                    this.getBuscarRelacionados = resp.data.relacionados
                    this.getBuscarDigitales = resp.data.digitales

                    // aqui llamamos al grafico
                    this.graficar()
                })
            $('#modalImprimir').modal('show');
            this.datomodal.modal == false

        },
        recargar(iddocumento) {
            this.buscardocumento({
                iddocumento: iddocumento
            })
        },
        getFormatBytes(bytes) {
            if (bytes != null) {
                if (bytes === 0) return '0 Bytes';
                const decimals = 2
                const k = 1024;
                const dm = decimals < 0 ? 0 : decimals;
                const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

                const i = Math.floor(Math.log(bytes) / Math.log(k));

                return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
            } else {
                return ''
            }

        },
        moment(a) {
            return moment(a)
        },
        imprimirDocumentoPdf: async function (data) {
            let f = ''
            f += '&id=' + data.id
            f += '&tipo=' + data.tipo
            if (data.tipo === 1) {
                f += '&id_documento=' + data.id_documento
            } else {
                f += '&id_documento_externo=' + data.id_documento_externo
            }
            let route = `/documento/print/${data.file_name}?` + f
            if (data.file_tipo === 'application/pdf') {
                window.open(route, "Visor", "width=1000,height=750")
            } else {
                const link = document.createElement('a')
                link.href = route
                link.setAttribute('download', data.file_name) //or any other extension
                document.body.appendChild(link)
                link.click()
            }

        },
        // para graficar hacia abajo
        async graficar() {
            // commit('setBuscarNumeroBranchs', 0)
            this.setBuscarNumeroBranchs(0)
            var o = []
            var ids = []
            var r = []
            var currBranch = 0
            var branchs = [0]
            for (var i = 0; i < this.getBusquedaCantidadOperaciones(); i++) {
                ids[i] = this.getBuscarOperacion(i).idoperacion
                o[i] = {
                    count: 0,
                    indx: [],
                    branch: null,
                    used: false,
                    childBranchs: []
                }
                if (this.getBuscarOperacion(i).oper_idprocesado != null) {
                    o[ids.indexOf(parseInt(this.getBuscarOperacion(i).oper_idprocesado))].count++
                    o[ids.indexOf(parseInt(this.getBuscarOperacion(i).oper_idprocesado))].indx.push(i)
                }
            }
            //var changBranch = false;
            for (i = 0; i < this.getBusquedaCantidadOperaciones(); i++) {
                if (this.getBuscarOperacion(i).oper_idprocesado != null) {
                    if (o[ids.indexOf(parseInt(this.getBuscarOperacion(i).oper_idprocesado))].used) {
                        currBranch = o[ids.indexOf(parseInt(this.getBuscarOperacion(i).oper_idprocesado))].childBranchs[0]
                        o[ids.indexOf(parseInt(this.getBuscarOperacion(i).oper_idprocesado))].childBranchs.splice(0, 1)
                    } else {
                        currBranch = o[ids.indexOf(parseInt(this.getBuscarOperacion(i).oper_idprocesado))].branch
                        o[ids.indexOf(parseInt(this.getBuscarOperacion(i).oper_idprocesado))].used = true
                    }
                } else {
                    currBranch = 0
                }
                o[i].branch = currBranch
                r[i] = ["hola", [currBranch, currBranch],
                    []
                ]
                if (o[i].count === 0) {
                    branchs.splice(branchs.indexOf(parseInt(currBranch)), 1)
                }
                for (var j = 0; j < branchs.length; j++) {
                    r[i][2].push([branchs[j], branchs[j], branchs[j]])
                }
                for (j = 1; j < o[i].count; j++) {
                    // commit('incrementBuscarNumeroBranchs')
                    this.incrementBuscarNumeroBranchs()
                    var newBranch = branchs[branchs.length - 1] + 1
                    o[i].childBranchs.push(newBranch)
                    branchs.push(newBranch)
                    r[i][2].push([currBranch, newBranch, newBranch])
                }
            }
            // commit('setBuscarGrafico', r)
            this.setBuscarGrafico(r)
            // this.acarreoOperaciones = o
            var canvas = $("<div></div>")
            canvas.css('text-align', 'center')
            $("#commits-graph2").html("")
            $("#commits-graph2").append(canvas)
            var options = {
                width: null,
                height: this.getBusquedaCantidadOperaciones() * 80,
                y_step: 80,
                data: this.getBuscarGrafico(), //getters.getBuscarGrafico,
                x_step: 4,
                dotRadius: 2,
                lineWidth: 2,
            }
            if (this.getBuscarNroBranchs() <= 10) {
                options.x_step = 9
                options.dotRadius = 5
                options.lineWidth = 3
            } else {
                if (this.getBuscarNroBranchs() <= 20) {
                    options.x_step = 6
                    options.dotRadius = 4
                    options.lineWidth = 2
                } else {
                    options.x_step = 4
                    options.dotRadius = 3
                    options.lineWidth = 1
                }
            }
            options.width = this.getBuscarNroBranchs() * options.x_step + ((options.dotRadius) * 3)
            canvas.commits(options)
            // console.log(options)
            // alert(options)
        },
        setBuscarNumeroBranchs(nro) {
            this.buscar.numeroBranchs = nro
        },
        incrementBuscarNumeroBranchs() {
            this.buscar.numeroBranchs++
        },
        setBuscarGrafico(grafico) {
            this.buscar.grafico = grafico
        },
        getBuscarGrafico() {
            return this.buscar.grafico
        },
        getBuscarNroBranchs() {
            return this.buscar.numeroBranchs
        },
        getBusquedaCantidadOperaciones() {
            return this.getBuscarOperaciones.length
        },
        getBuscarOperacion(i) {
            return this.getBuscarOperaciones[i]
        }
        

    },
};
</script>

<style lang="scss" scoped>
// hr {
//     margin: 5px 5px;
// }

.registro strong {
    width: 60px;
    display: inline-block;
}

.list-group-item {
    // height: 90px;
    margin-bottom: 0px;
    padding-top: 0.2rem;
    padding-right: 1rem;
    padding-bottom: 0;
    padding-left: 0.5rem;
    line-height: 1.5rem;
    // background-color: #ffffffcc;
}

.modal-content .list-group-item-heading {
    max-width: 500px;
}

.table tbody tr td,
.table thead tr th {
    font-size: 10px;
    font-family: Tahoma;
    vertical-align: middle;
}

.list-group {
    margin: 0;
}

h5 {
    text-overflow: ellipsis;
    white-space: nowrap;
    overflow: hidden;
    margin-bottom: 0;
}

.badge {
    font-size: 10px;
}

.doc-link {
    width: 320px;
    text-overflow: ellipsis;
    text-align: left;
    white-space: nowrap;
    overflow: hidden;
    margin-bottom: 0;
}

.tipospan {
    font-size: 10px !important;
    border-radius: 5px;
    padding-left: 1px;
    padding-right: 1px;
}

.badge {
    font-size: 12px !important;
    font-weight: 300 !important;
}
</style>
