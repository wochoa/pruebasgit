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
    <div class="content">
        <div class="container-fluid">
          <div class="row">
                <div class="col-sm-6">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <router-link :to="'/Administracion/tipodocumentos'" class="nav-link" id="index" data-toggle="pill" aria-controls="custom-content-above-home" aria-selected="false">
                              EXPLORAR TIPO DE DOCUMENTOS
                            </router-link>
                        </li>
                        <li class="nav-item" v-if="$route.params.id == null">
                            <router-link :to="'/tipoDocumento-create'" class="nav-link active" id="nuevo" data-toggle="pill" aria-controls="custom-content-above-profile" aria-selected="true">
                              NUEVO TIPO DOCUMENTO
                            </router-link>
                        </li>
                        <li class="nav-item" v-else>
                            <router-link :to="'/tipoDocumento-create'" class="nav-link active" id="nuevo" data-toggle="pill" aria-controls="custom-content-above-profile" aria-selected="true">
                              EDITAR TIPO DOCUMENTO
                            </router-link>
                        </li>

                    </ul>
                </div>
            </div>
            <form action="" @submit.prevent="guardarTipoDocumento()">
                <div class="card card-primary">
                    <div v-if="$route.params.id == null" class="card-header">TIPO DE DOCUMENTO</div>
                    <div v-else class="card-header">EDITAR TIPO DE DOCUMENTO</div>
                    <div class="card-body">
                        <div class="form-group row" style="width: 100%;margin-left: -0px;">
                            <div :class="'col-sm-4'">
                                <label class="control-label">Descripción</label>
                                <input ref="nombre" v-model="tipoDocumento.tdoc_descripcion" type="text" class="form-control form-control-sm" name="nombre" @change="tipoDocumento.tdoc_descripcion = tipoDocumento.tdoc_descripcion.toUpperCase()" />
                            </div>
                            <div :class="'col-sm-3'">
                                <label class="control-label">Descripción Abreviado:</label>
                                <input ref="abreviado" v-model="tipoDocumento.tdoc_abreviado" type="text" class="form-control form-control-sm" name="abreviado" @change="tipoDocumento.tdoc_abreviado = tipoDocumento.tdoc_abreviado.toUpperCase()" />
                            </div>
                            <div class="col-sm-3">
                              <label for="">Formato</label>
                              <input type="file" class="form-control form-control-sm"  accept=".docx" @change="onFileSelected" name="myfile">
                            </div>
                            <div :class="'col-sm-2'">
                                <label class="control-label">Usado MPV</label>
                                <select ref="mpv" v-model="tipoDocumento.tdoc_mpv" class="form-control form-control-sm" name="mpv">
                                    <option :value="1">Si</option>
                                    <option :value="0">No</option>
                                </select>
                                <!-- <span v-show="errors.has('mpv')" class="help-block">{{ errors.first('mpv') }}</span> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card card-primary">
                    <div v-if="$route.params.id == null" class="card-body text-right">
                        <button class="btn btn-primary" type="submit">Registrar</button>
                    </div>
                    <div v-else class="card-body text-right">
                        <button class="btn btn-primary" type="submit">Actualizar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</template>

<script>
export default {

    props: {
        routeGuardar: {
            type: String,
            default: ''
        },
        routeGetTipo: {
            type: String,
            default: ''
        }
    },

    data() {
        return {
            tipoDocumento: {
                tdoc_descripcion: null,
                tdoc_abreviado: null,
                tdoc_correlativo: 0,
                tdoc_mpv: 0,
                idtdoc:'',
                archivo:''
            },
            modoEdicion: true
        }
    },

    mounted() {
        if (this.$route.params.id > 0 || this.$route.params.id != null) {
            this.obtenerTipoDocumento()
        }
    },

    methods: {
        guardarTipoDocumento() {
          const formData = new FormData();
          formData.append("tdoc_descripcion", this.tipoDocumento.tdoc_descripcion);
          formData.append("tdoc_abreviado", this.tipoDocumento.tdoc_abreviado);
          formData.append("tdoc_correlativo", this.tipoDocumento.tdoc_correlativo);
          formData.append("tdoc_mpv", this.tipoDocumento.tdoc_mpv);
          formData.append("idtdoc", this.tipoDocumento.idtdoc);
          formData.append("archivo", this.tipoDocumento.archivo);

            axios.post('/tipoDocumento', formData, {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(reponse => {
                // console.log(reponse.data)
                this.$router.push('/Administracion/tipodocumentos')
            })
            // } else {
            //   console.log('incompleto')
            // }
            // })
        },

        obtenerTipoDocumento() {
          var url='/tipoDocumento/%s'
            axios
                .get(url.replace(/%s/g, this.$route.params.id))
                .then(response => (this.tipoDocumento = response.data))
        },
        onFileSelected (event)
        {
          const file = event.target.files[0];
          this.tipoDocumento.archivo=file;
        }
    }
}
</script>

<style scoped>
input,
textarea {
    text-transform: uppercase;
}
</style>
