<template>
<div>
    <form action="" class="NavbarSearch" @submit.prevent="buscarExpedientePopup()">
      <div class="row justify-content-center">
                <div class="col-sm-9 col-6 pr-0">
                  <input v-model="getCodigoBusqueda" type="number" class="form-control form-control-sm" placeholder="Nro expediente" />
                </div>
                <div class="col-sm-3 col-2 pl-0 text-left">
                  <button type="submit" class="btn btn-sm btn-primary btn-sm"><span class="fa fa-search"></span></button>
                </div>
              </div>

        
        
    </form>
    <!-- Modal buscar expediente-->
    <!-- <div id="expediente" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <buscar-expediente ref="exp" :form-data="formData" :route-expediente="routeExpediente" />
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div> -->
</div>
</template>

<script>
import $ from 'jquery';
import swal from 'sweetalert2';

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

    props: {
        routeExpediente: {
            type: String,
            default: ''
        },
        routeDocumento: {
            type: String,
            default: ''
        }
    },

    data() {
        return {
            formData: {
                iddocumento: null
            },
            getCodigoBusqueda: null,
        }
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
                this.toast('Digite bien el Expediente', 'error');
            }
        },

        // imprimirExpediente() {
        //     this.$refs.exp.imprimirExpediente()
        // }
    }
}
</script>
