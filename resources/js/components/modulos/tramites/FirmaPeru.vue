<template>
<div>

    <!-- Modal -->
    <div class="row">
        <div class="col-sm-12">
            <div id="mdlInvoker" aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" class="modal fade" style="overflow-y: scroll;">

                <!-- <div id="configFirma" class="modal-dialog modal-lg"> -->
                <div id="configFirma" class="modal-dialog modal-sm">

                    <div class="modal-content">
                        <div class="modal-header">
                            <div class="modal-title"><i class="glyphicon glyphicon-menu-right"></i>&#160;&#160; Configuraciones para firma digital</div>
                        </div>
                        <div class="modal-body ">
                            <div class="row">
                                <div class="col-sm-12" style="background-color: #3c3c3c;">

                                    <!-- <h4>Configuraciones</h4>
                                    <div class="form-group mt-4">
                                        <label>Páginas:</label>
                                        {{ numPages }}

                                        <br>
                                        <button class="btn btn-sm btn-warning" @click="previousPage"><i class="fa-solid fa-chevron-left"></i></button>
                                        {{ pageNumber }} de {{ numPages }}
                                        <button class="btn btn-sm btn-warning" @click="nextPage"><i class="fa-solid fa-angle-right"></i></button>

                                    </div>
                                    <div class="form-group ">
                                        <label>Ampliación de página:</label>
                                        <small>{{ zommpdf.scale }}</small>
                                        <br>
                                        <button class="btn btn-sm btn-info" @click.prevent="zoommenos"><i class="fa-solid fa-magnifying-glass-minus"></i></button>

                                        <button class="btn btn-sm btn-info" @click.prevent="zoommas"><i class="fa-solid fa-magnifying-glass-plus"></i></button>

                                    </div> -->
                                    <div class="form-group mt-4 mb-5">
                                        <label>Motivo de la firma</label>
                                        <select v-model="motivo" class="form-control form-control-sm">
                                            <option value="0">Soy el autor del documento</option>
                                            <option value="1">En señal de conformidad</option>
                                            <option value="2">Doy V° B°</option>
                                            <option value="3">Por encargo</option>
                                            <option value="4">Doy fé</option>
                                        </select>
                                    </div>
                                    <canvas id="pdf-container" style="display: none;"></canvas>
                                    <div class="form-group mt-4 mb-5">
                                        <label>Estilo de la firma</label>
                                        <select v-model="estilofirma" class="form-control form-control-sm">
                                            <option value="0">Firma invisible</option>
                                            <option value="1">Firma con estampado y descripción horizontal.</option>
                                            <option value="2">Firma con estampado y descripción vertical.</option>
                                            <option value="3">Solo firma con estampado.</option>
                                            <option value="4">Solo firma con descripción.</option>
                                        </select>
                                    </div>

                                    <!-- <div class="form-group footer_div ">
                                        <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                                        <button type="button" class="btn btn-success float-right" @click="continuar">Continuar</button>
                                    </div> -->

                                </div>
                                <!-- <div class="col-sm-8 text-center d-flex">
                                    <div class="row" style="margin:0px auto;text-align: center;">
                                        <div class="doc_preview" @drop="drop($event)">
                                            <div class="cabecera">Cabecera</div>
                                            <div class="pie-de-pagina">Pie de pagina</div>

                                            <div v-if="motivo==2" v-dragged="onDragged" class="firma_preview_vertical dragzones" style="margin: 50px 0px 0px 50px;" onselectstart="return false;">
                                                <br />Firma
                                            </div>
                                            <div v-else v-dragged="onDragged" class="firma_preview dragzones" style="margin: 50px 0px 0px 50px;" onselectstart="return false;">
                                                <br />Firma
                                            </div>

                                            <div id="pageContainer">
                                                <canvas id="pdf-container"></canvas>

                                            </div>

                                        </div>
                                    </div>
                                </div> -->
                               
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-success float-right" @click="continuar">Continuar</button>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import * as jQuery from 'jquery';
import "pdfjs-dist/web/pdf_viewer.css";
import {
    GlobalWorkerOptions,
    getDocument
} from "pdfjs-dist/legacy/build/pdf";

import PDFJSWorker from "pdfjs-dist/legacy/build/pdf.worker.entry";
GlobalWorkerOptions.workerSrc = PDFJSWorker;
window['jQuery'] = jQuery;
let grap = require('../../../firmaperu.js');
window.fn = grap;

var hash = window.location.hash
export default {

    name: 'DocuInvoker',

    props: ['ruta', 'usuario', 'routeInvokerGet', 'routeInvokerPost'],

    data() {
        return {
            app: null,

            frameInvoker: null,

            idDocumento: null,
            idFile: null,
            configDiv: {
                maxL: 295,
                minL: 3,
                maxT: 506, //489,
                minT: 50
            },
            maxX: 420,
            maxY: 760,
            relacion: 1.4237,
            X: 75,
            Y: 70,
            motivo: 0,
            estilofirma: 1,
            rutaarchivo: null,
            urlrealarchivo: null,
            existearchivo: null,

            // para previsualizar pdf con canvas
            url: null, //"http://stdv.test/firmados/56-203-4295-INFORME-119-2022.pdf",

            numPages: 1,
            pageNumber: 1,
            pdfDocument: null,
            zommpdf: {
                scale: 0.70
            },
            parametros: '',
            puerto: 48596
            /////////  FIN CONFIG DE PREVISUALIZAR PDF/////////////////////////////////
        }
    },
    components: {
        // PDFVIEW
    },

    created() {

    },
    mounted() {
        // this.img = this.imgs.s_load

        //this.getPdfDocument();

    },

    methods: {
        onDragged({
            el,
            deltaX,
            deltaY,
            offsetX,
            offsetY,
            clientX,
            clientY,
            first,
            last
        }) {
            if (first) {
                this.isDragging = true
                return
            }
            if (last) {
                this.isDragging = false
                return
            }
            var l = +window.getComputedStyle(el)['margin-left'].slice(0, -2) || 0
            var t = +window.getComputedStyle(el)['margin-top'].slice(0, -2) || 0
            var newL = l + deltaX
            var newT = t + deltaY
            newL = newL > this.configDiv.minL ? (newL > this.configDiv.maxL ? this.configDiv.maxL : newL) : this.configDiv.minL
            newT = newT > this.configDiv.minT ? (newT > this.configDiv.maxT ? this.configDiv.maxT : newT) : this.configDiv.minT
            this.X = Math.round(newL * this.relacion)
            this.Y = Math.round(newT * this.relacion)
            el.style.marginLeft = newL + 'px'
            el.style.marginTop = newT + 'px'
        },
        drop(e) {
            console.log(e)
        },
        initInvoker: async function (opt, documento = null) {
            // var status = document.querySelector('#estadoFirma')
            var config = document.querySelector('#configFirma')
            // status.style.display = 'none'
            config.style.display = ''
            // this.img = this.imgs.s_load
            $('#mdlInvoker').modal({
                backdrop: 'static',
                keyboard: false
            })
            this.idDocumento = documento.id_documento
            this.idFile = documento.idfile
            this.rutaarchivo = documento.ruta_archivo
            this.existearchivo = documento.existearchivo

            // this.type = opt

            this.valorruta(documento.ruta_archivo)

        },
        continuar() {
            // var status = document.querySelector('#estadoFirma')
            var config = document.querySelector('#configFirma')
            // status.style.display = ''
            config.style.display = 'none'
            this.sendParam()
        },

        sendParam() {
            const parameter = {
                // type: this.type,
                iddocumento: this.idDocumento,
                idFile: this.idFile,
                posx: this.X,
                posy: this.Y,
                motivo: this.motivo,
                pagina: this.pageNumber,
                cargo: this.usuario.adm_cargo,
                estilofirma: this.estilofirma,
                rutaarchivo: this.rutaarchivo,
                urlprincipal: this.ruta,
                ruta: this.ruta,
                urlpdf: this.url
            }

            var urlparametros_gral = '/firmaperu/parametrogral'
            // var urlparametros_gral = '/parametros-principal.php?rutaarchivo='+this.rutaarchivo+'&posx='+this.X+'&posy='+this.Y+'&motivo='+this.motivo+'&pagina='+this.pageNumber+'&cargo='+this.usuario.adm_cargo+'&estilofirma='+this.estilofirma+'&ruta='+this.ruta+'&urlpdf='+ this.url
            axios.post(urlparametros_gral, parameter)
                .then(res => {
                    console.log(res.data)
                    this.parametros = res.data
                    startSignature(this.puerto, this.parametros);
                })
        },
        //  funciones de firma peru  
        // mensajes de eventos firma peru
        // signatureInit() {
        //     alert('PROCESO INICIADO');
        //     $('#mdlInvoker').modal('hide')
        // },
        // signatureOk() {
        //     alert('DOCUMENTO FIRMADO')
        //     $('#mdlInvoker').modal('hide')
        // },
        // signatureCancel() {
        //     alert('OPERACIÓN CANCELADA')
        //     $('#mdlInvoker').modal('hide')
        // },

        //  fin de funciones de firma peru

        // FUNCIONES ADICIONALES PARA PREVISUaLiZAR PDF
        zoommas() {
            this.zommpdf.scale = 0.01 + this.zommpdf.scale
            this.getPage(this.pageNumber);
        },
        zoommenos() {
            this.zommpdf.scale = this.zommpdf.scale - 0.01
            this.getPage(this.pageNumber);
        },

        async valorruta(archivo) {
            this.urlrealarchivo = this.ruta + '/' + archivo
            this.url = this.ruta + '/mostrararchivo/' + this.idFile
            this.getPdfDocument();
        },
        async getPdfDocument() {
            getDocument(this.url).promise.then(
                (pdf) => {
                    this.numPages = pdf.numPages;
                    this.pdfDocument = pdf;
                    this.getPage(this.pageNumber);
                },
                (reason) => {
                    console.error(reason);
                }
            );
        },

        getPage(pageNumer) {
            this.pdfDocument.getPage(pageNumer).then((page) => {
                //   var viewport = page.getViewport({ scale: 1.5 });
                var viewport = page.getViewport(this.zommpdf);

                var canvas = document.getElementById("pdf-container");
                var context = canvas.getContext("2d");
                canvas.height = viewport.height;
                canvas.width = viewport.width;

                var renderContext = {
                    canvasContext: context,
                    viewport: viewport,
                };

                var renderTask = page.render(renderContext);

                renderTask.promise.then(function () {
                    console.log("Page rendered");
                });
            });
        },

        previousPage() {
            this.pageNumber =
                this.pageNumber > 1 ? this.pageNumber - 1 : this.pageNumber;
            this.getPage(this.pageNumber);
        },

        nextPage() {
            this.pageNumber =
                this.pageNumber < this.numPages ? this.pageNumber + 1 : this.pageNumber;
            this.getPage(this.pageNumber);
        },
    }
}
</script>

<style scoped>
.invokerMain {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 20000;
    overflow: hidden;
    background: transparent;
    display: none;
}

.invokerScreen {
    position: absolute;
    width: 100% !important;
    height: 100%;
    z-index: 10000;
}

iframe {
    height: 100%;
    width: 100%;
    border: none;
}

.modal-content {
    background-color: #222222;
    color: #999;
}

.modal-header {
    background-color: #1c1c1c;
    color: #888;
    border-bottom: 0px !important;
}

.modal-footer {
    background-color: #1c1c1c;
    color: #888;
    border-top: 0px !important;
}

.footer_div {
    position: absolute;
    bottom: 10px;
    width: 90%;
    /* border: 3px solid #8AC007; */
}

.doc_preview {
    width: 420px;
    height: 594px;
    background: rgb(222, 238, 222);
    display: inline-block;
}

.pie-de-pagina {
    border: solid 1px black;
    width: 420px;
    height: 50px;
    position: absolute;
    /* top: 559px; */
    top: 550px;
}

.cabecera {
    border: solid 1px black;
    width: 420px;
    height: 50px;
    position: absolute;
}

/* .firma_preview {
    border: solid 1px black;
    width: 121px;
    height: 56px;
    background-color: #ffd6d6;
} */

/* firma horizontal: autor del doc, por encargo,etc*/
.firma_preview {
    border: solid 1px black;
    width: 121px;
    height: 45px;
    color: #1c1c1c;
    background-color: #ffd6d6;
    opacity: 0.6;
    z-index: 90000;
    position: absolute;
}

/* firma vertical para visto bueno */
.firma_preview_vertical {
    border: solid 1px black;
    width: 76px;
    height: 70px;
    color: #1c1c1c;
    background-color: #ffd6d6;
    opacity: 0.6;
    z-index: 90000;
    position: absolute;
}

/* CSS ADIOCNALES */
#pageContainer {
    margin: auto;
}

.stepper {
    display: flex;
    align-items: center;
    justify-content: center;
    position: fixed;
    top: 10px;
    /* right: 30px; */
    left: 50%;
}

.stepper .info {
    padding-left: 10px;
    padding-right: 10px;
}
</style>
