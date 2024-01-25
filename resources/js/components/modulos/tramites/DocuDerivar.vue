<template>
<div :class="'card ' + (viewer ? 'card-info' : 'card-primary')">
    <div class="card-header">
        DESTINO(S)-DERIVACIÓN DEL DOCUMENTO
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">x</span>
        </button>
    </div>
    <div class="card-body">
        <form action="" @submit.prevent="derivar()">

            <div class="form-group row">
                <label class="col-sm-2 control-label">Forma</label>
                <div v-if="getDerivarSoloCopia" class="col-sm-4">Solo Copia</div>
                <div v-else class="col-sm-4">
                    <label class="checkbox-inline">
                        <input v-model="formData.oper_forma" type="checkbox" name="oper_forma" />Copia
                    </label>
                </div>
                <div class="col-sm-4" v-if="generado">
                    <label class="checkbox-inline">
                        <input v-model="formData.oper_manual" type="checkbox" name="docu_tipo" />Registro manual
                    </label>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label">Unidad Orgánica</label>
                <div class="col-sm-2">
                    <!--id-->
                    <input v-model="formData.oper_depeid_d" type="text" class="form-control form-control-sm" @keyup="verificarUsuariosforDerivar()" />
                </div>
                <div class="col-sm-7">
                    <!-- <select v-model="formData.oper_depeid_d" class="form-control form-control-sm" required @change="verificarUsuariosforDerivar()">
                        <option v-for="(unidad, indexUnidad) in unidadesOrganicas" :key="indexUnidad" :value="unidad.iddependencia">
                            {{ recortacadena(unidad.depe_nombre) }}
                        </option>
                    </select> -->
                    <el-select filterable placeholder="Seleccione la dependencia" style="width: 100%;" size="small" v-model="formData.textdepe" @change="buscaid()">
                        <el-option v-for="(unidad, indexUnidad) in unidadesOrganicas" :key="indexUnidad" :label="recortacadena(unidad.depe_nombre)" :value="unidad.iddependencia">
                        </el-option>
                        <!-- <el-option v-for="(unidad, indexUnidad) in unidadesOrganicas" :key="indexUnidad" :label="unidad.depe_sigla+'-'+recortacadena(unidad.depe_nombre)" :value="unidad.iddependencia">
                        </el-option> -->
                    </el-select>

                </div>
            </div>
            <div v-show="formData.oper_manual" :class="'form-group row'">
                <label class="col-sm-2 control-label">Destinatario</label>
                <div class="col-sm-9">
                    <input ref="detalle de proveido" v-model="formData.oper_persona" name="Destinatario" type="text" class="form-control form-control-sm" @change="formData.oper_persona = formData.oper_persona.toUpperCase()" />

                </div>
            </div>
            <div v-show="formData.oper_manual" :class="'form-group row'">
                <label class="col-sm-2 control-label">Cargo</label>
                <div class="col-sm-9">
                    <input ref="detalle de proveido" v-model="formData.oper_cargo" name="Cargo" type="text" class="form-control form-control-sm" @change="formData.oper_cargo = formData.oper_cargo.toUpperCase()" />

                </div>
            </div>
            <div :class="'form-group row'">
                <label class="col-sm-2 control-label">Detalle</label>
                <div class="col-sm-9">
                    <input ref="detalle de proveido" v-model="formData.oper_detalledestino" name="detalle de proveido" type="text" class="form-control form-control-sm" @change="formData.oper_detalledestino = formData.oper_detalledestino.toUpperCase()" />

                </div>
            </div>
            <div v-if="getDependenciaUser.idoficina == formData.oper_depeid_d" id="iducuario" class="form-group row">
                <label class="col-sm-2 control-label">Usuario</label>
                <div class="col-sm-9">
                    <select v-model="formData.oper_usuid_d" class="form-control form-control-sm" required>
                        <!-- <option v-for="(usuario, indexUser) in getUsuariosActivo" :key="indexUser" :value="usuario.id">
                                {{ usuario.adm_name }} {{ usuario.adm_lastname }}
                            </option> -->
                        <option v-for="(usuario, indexUser) in getUsuariosActivo" v-if="usuario.adm_email!='SUPERADMIN'" :key="indexUser" :value="usuario.id">
                            {{ usuario.adm_name }} {{ usuario.adm_lastname }}
                        </option>
                    </select>
                </div>
            </div>
            <div :class="'form-group row'">
                <label class="col-sm-2 control-label">Proveido de atención</label>
                <div class="col-sm-9">
                    <textarea ref="proveido" v-model="formData.oper_acciones" name="proveido" required class="form-control form-control-sm" rows="2" @change="formData.oper_acciones = formData.oper_acciones.toUpperCase()"></textarea>

                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label"></label>
                <div class="col-sm-9">
                    <button type="submit" class="btn btn-primary" value="Añadir">
                        <span class="glyphicon glyphicon-ok"> Añadir</span>
                    </button>
                    <button class="btn btn-warning" @click="limpiar()">
                        <span class="glyphicon glyphicon-ban-circle"> Limpiar</span>
                    </button>
                </div>
            </div>

            <!--tabla-->
            <div class="box">
                <div class="box-body">
                    <table id="tabla" class="table table-striped table-bordered table-condensed table-hover" style="overflow-x:scroll;">
                        <!-- Cabecera de la tabla -->
                        <thead>
                            <tr class="info">
                                <th>FORMA</th>
                                <th>UNIDAD ORGANICA</th>
                                <th>DETALLE</th>
                                <th>USUARIO</th>
                                <th>PROVEIDO DE ATENCIÓN</th>
                                <th style="width: 10px"></th>
                            </tr>
                        </thead>
                        <!-- Cuerpo de la tabla con los campos -->
                        <tbody>
                            <!-- fila base para clonar y agregar al final -->
                            <tr v-for="(derivacion, index2) in derivaciones2" :key="'show_'+index2" class="success">
                                <td>
                                    <p v-if="derivacion.oper_forma">Copia</p>
                                    <p v-else>Original</p>
                                </td>
                                <td>
                                    <p>{{ getDependenciaNombre(derivacion.oper_depeid_d) }}</p>
                                </td>
                                <td>
                                    <p>{{ derivacion.oper_detalledestino }}</p>
                                </td>
                                <td>
                                    <p v-if="derivacion.oper_usuid_d != null">{{ getUsuariosActivoNombre(derivacion.oper_usuid_d) }}</p>
                                    <p v-if="derivacion.oper_manual">{{ derivacion.oper_persona }}<br />{{ derivacion.oper_cargo }}</p>
                                </td>
                                <td>
                                    <p>{{ derivacion.oper_acciones }}</p>
                                </td>
                                <td>
                                    <label v-if="generado" class="control-label" style="font-weight:500; width: 90px;">
                                        <input v-if="!derivacion.oper_manual" v-model="derivacion.oper_es_destino" type="checkbox" /> Es destino.</label>
                                </td>
                            </tr>
                            <tr v-for="(derivacion, index1) in derivaciones" :key="index1">
                                <td>
                                    <p v-if="derivacion.oper_forma">Copia</p>
                                    <p v-else>Original</p>
                                </td>
                                <td>
                                    <p>{{ getDependenciaNombre(derivacion.oper_depeid_d) }}</p>
                                </td>
                                <td>
                                    <p>{{ derivacion.oper_detalledestino }}</p>
                                </td>
                                <td>
                                    <p v-if="derivacion.oper_usuid_d != null">{{ getUsuariosActivoNombre(derivacion.oper_usuid_d) }}</p>
                                    <p v-if="derivacion.oper_manual">{{ derivacion.oper_persona }}<br />{{ derivacion.oper_cargo }}</p>
                                </td>
                                <td>
                                    <p>{{ derivacion.oper_acciones }}</p>
                                </td>
                                <td>
                                    <a class="btn btn-danger" @click="eliminarDerivacion(index1)"><span class="fa fa-trash"></span></a>
                                    <br />
                                    <label v-if="generado" class="control-label" style="font-weight:500; width: 90px;">
                                        <input v-if="!derivacion.oper_manual" v-model="derivacion.oper_es_destino" type="checkbox" /> Es destino.</label>
                                </td>
                            </tr>
                            <tr v-if="derivaciones.length === 0">
                                <td colspan="6" class="text-center">
                                    No se realizo ninguna derivacion.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </form>
    </div>
</div>
</template>

<script>
import Vuex from 'vuex'
// import {Operacion} from "@/js/store/models/documento"

export default {

    name: 'DocuDerivar',

    props: {
        derivaciones: {
            type: Array,
            default: () => []
        },
        derivaciones2: {
            type: Array,
            default: () => []
        },
        viewer: {
            type: Boolean,
            default: false
        },
        generado: {
            type: Boolean,
            default: false
        }
    },

    data() {
        return {
            formData: {
                idoperacion: null,
                oper_iddocumento: null,
                oper_iddependencia: null,
                oper_idusuario: null,
                oper_idarchivador: null,
                oper_idtope: null,
                oper_es_destino: true,
                oper_manual: false,
                oper_forma: false,
                oper_depeid_d: null,
                oper_detalledestino: null,
                oper_persona: null,
                oper_cargo: null,
                oper_acciones: null,
                oper_usuid_d: null,
                textdepe: ''
            },
            representantedestino: ''
        }
    },

    computed: {
        ...Vuex.mapGetters([
            'getUnidadesForDerivacion',
            'getEntidadesExternas',
            'getDependenciaNombre',
            'getUsuariosActivo',
            'getUsuariosActivoNombre',
            'getDependenciaUser',
            'getDerivarSoloCopia'
        ]),
        unidadesOrganicas() {
            if (this.formData.oper_manual) {
                return this.getEntidadesExternas
            } else {
                return this.getUnidadesForDerivacion
            }

        },
    },

    mounted() {
        // this.formData = Operacion.getDefault()
    },
    methods: {
        verificarUsuariosforDerivar() {
            var url = '/listauserdepe/' + this.formData.oper_depeid_d;
            axios.get(url)
                .then(response => {
                    // this.listadouser = response.data.usuarios;
                    this.representantedestino = response.data.representantes;

                    // this.formdocumentos.firmadestino = this.representantedestino[0].depe_representante;
                    // this.formdocumentos.cargodestino = this.representantedestino[0].depe_cargo;
                    // this.formdocumentos.unidadorganica = this.representantedestino[0].depe_nombre;  unidad.depe_sigla
                    this.formData.textdepe = this.representantedestino[0].depe_nombre;
                    // this.formData.textdepe = this.representantedestino[0].depe_sigla+'-'+this.representantedestino[0].depe_nombre;

                });

            if (this.getDependenciaUser.iddependencia != this.formData.oper_depeid_d) {
                this.formData.oper_usuid_d = null
            }

        },
        buscaid() // busca id de la dependencia
        {
            this.formData.oper_depeid_d = this.formData.textdepe
            this.verificarUsuariosforDerivar()

        },
        derivar() {
            var este = this

            if (este.getDerivarSoloCopia) {
                este.formData.oper_forma = true
            }
            este.derivaciones.push(Object.assign({}, este.formData))
            // este.$forceUpdate()
            este.limpiar()
            este.$emit('derivar')

        },
        limpiar() {
            // this.formData = Operacion.getDefault()
            this.formData.idoperacion = null
            this.formData.oper_iddocumento = null
            this.formData.oper_iddependencia = null
            this.formData.oper_idusuario = null
            this.formData.oper_idarchivador = null
            this.formData.oper_idtope = null
            this.formData.oper_es_destino = true
            this.formData.oper_manual = false
            this.formData.oper_forma = false
            this.formData.oper_depeid_d = null
            this.formData.oper_detalledestino = null
            this.formData.oper_persona = null
            this.formData.oper_cargo = null
            this.formData.oper_acciones = null
            this.formData.oper_usuid_d = null

        },
        eliminarDerivacion(index) {
            this.derivaciones.splice(index, 1)
            // this.$forceUpdate()
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

<style scoped>
input,
textarea {
    text-transform: uppercase;
}
</style>
