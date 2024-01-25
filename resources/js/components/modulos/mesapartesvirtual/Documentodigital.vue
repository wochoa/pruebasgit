<template>
<div>
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <!-- <h1 class="m-0"> MESA DE PARTES <small>DIGITAL</small></h1> -->
                    <h1 class="m-0">{{ $route.name }}</h1>
                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->

    <div class="content">
        <div class="container">

            <div class="row">
                <div class="col-12">
                    <div class="card card-primary">
                        <div class="card-header pt-1 pb-1">
                            <p>Verificar el documento digital</p>
                        </div>
                        <div class="card-body">
                            <div class="form-group row">

                                <div class="col-sm-4">
                                    <input type="numbre" v-model="busdoc.iddocumento" class="form-control form-control-sm" placeholder="Nro registro del documento">
                                </div>
                                <div class="col-sm-4">
                                    <input type="text" v-model="busdoc.clave" class="form-control form-control-sm" placeholder="Clave de documento">
                                </div>
                                <button class="btn btn-sm btn-primary" @click="buscarfile"><i class="fa fa-search"></i> Buscar</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content -->
    </div>

<!-- muesraelarchivo -->
    <div class="modal fade" id="modalarchivo">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- <div class="modal-header">
                    <h4 class="modal-title">Archivo cargado</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div> -->
                <div class="modal-body p-0" id="archivo">

                </div>
                <!-- <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">cerras</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div> -->
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


</div>
</template>

<script>
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

// import FormDocumento from '../mesapartesvirtual/FormDocumento.vue'
export default {
    name: 'mesapartesvirtual',

    data() {
        return {
            busdoc: {
                iddocumento: '',
                clave: ''
            }

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

        },
        buscarfile() {
            var url = '/documento/buscardocumentofile'
            axios.post(url, this.busdoc)
                .then(res => {
                    // console.log(res.data)
                    if (res.data.status == 0) {
                        this.toast(res.data.msg, res.data.tipo);
                    }
                    else{
                        this.mostrar_archivo(res.data)
                        this.toast('El documento si existe en nuestro registros', 'success');
                    }
                })
        },
        mostrar_archivo(url) {
            $('#modalarchivo').modal('show');
            //cadena='<embed src="'+archivo+'" type="application/pdf" frameborder="0" width="100%" height="930" style="overflow-x: hidden;"/>';
            var cadena = '<object id="pdfdoc" data="' + url + '" type="application/pdf" width="100%" height="700px">';
            $("#archivo").html(cadena);
        }

    },
};
</script>

<style lang="scss" scoped>

    </style>
