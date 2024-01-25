import Vue from 'vue';
import Vuex from 'vuex'

Vue.use(Vuex);
const debug = process.env.NODE_ENV !== 'production'

const store = new Vuex.Store({
  state: {
    listaoficinadeluser: [],// listado de oficinas asigandos al usuario logeado 
    ofiseleccionado: {// pode fecto carga estos datos para la creacion del documento
      nombreofi: '',
      idoficina: '',
      firma:'',
      cargo:'',
      siglasdocumento:'',
      correlativo:'',
      idcreador:'',
      ciudad:'',
      direccion:'',
      clavedoc:'',
      iddependencia:'',
      listaoficinasdepedencia:[]// listado de oficinas de la dependencia del usuario
    },
    listauseroficina: [],//
    usuariologeado: {
      adm_cargo: null,
      adm_caseta: 0,
      adm_con_especialidad: null,
      adm_correo: null,
      adm_correo_personal: null,
      adm_direccion: null,
      adm_dni: null,
      adm_email: null,
      adm_esjefe: null,
      adm_estado: null,
      adm_inicial: null,
      adm_lastname: null,
      adm_name: null,
      adm_observacion: null,
      adm_primer_logeo: 1,
      adm_telefono: null,
      adm_tipo: 1,
      adm_vigencia: null,
      avatar: "avatar/logo.png",
      created_at: null,
      darkmode: null,
      depe_id: null,
      email_verified_at: null,
      fullname: null,
      id: null,
      push_id: null,
      tipousuario: null,
      updated_at: null

    },
    alldependencias: [
      {
        created_at: null,
        depe_abreviado: null,
        depe_agente: null,
        depe_cargo: null,
        depe_ciudad: null,
        depe_depende: null,
        depe_diasmaxenproceso: null,
        depe_dni: null,
        depe_estado: null,
        depe_idusuario: null,
        depe_idusuarioreclamo: null,
        depe_idusuariotransp: null,
        depe_imagen_footer: null,
        depe_imagen_header: null,
        depe_mesa_virtual: null,
        depe_minuto_tolerancia: null,
        depe_nombre: null,
        depe_observaciones: null,
        depe_proyectado: null,
        depe_recibetramite: null,
        depe_representante: null,
        depe_rrhh: null,
        depe_sigla: null,
        depe_superior: null,
        depe_tipo: null,
        iddependencia: null,
        updated_at: null

      }
    ],
    archivadores: [],
    usuarios: [],
    tiposDocumento: [],
    dependenciaUser: [],
    datseldepe: null,
    periodosCorrelativo: [],
    derivar            : {
      soloCopia: false
    },
  },
  mutations: {
    USER_LOGEADO(state, datosuser) {
      state.usuariologeado = datosuser
    },
    DATOS_OFICINA(state, iddepe) {
      state.ofiseleccionado = iddepe
    },
    OFICINAS_DELUSER(state, datosuserof) {
      state.listaoficinadeluser = datosuserof
    },
    USERS_OFICINA(state, datosuser) {
      state.listauseroficina = datosuser
    },
    ALL_DEPENDENCIA(state, datosdepe) {
      state.alldependencias = datosdepe
    },
    DEPE_CODIGO(state, codedepe) {
      //if(!codedepe) return state.alldependencias   
      state.datseldepe = state.alldependencias.filter(todo => todo.iddependencia === codedepe)
    },
    llenarPeriodos(state, periodos) {
      state.periodosCorrelativo = periodos
    },
    llenarArchivadores(state, archivadores) {
      for (var i = 0; i < archivadores.length; i++) {
        state.archivadores.push({
          idarch: archivadores[i][0],
          arch_periodo: archivadores[i][1],
          arch_nombre: archivadores[i][2]
        })
      }
    },
    llenarDependenciaUser(state, dependencia) {
      state.dependenciaUser = dependencia
    },
    llenarTiposDocumento(state, tiposDocumento) {
      state.tiposDocumento=tiposDocumento
    },
    llenarUsuarios(state, usuarios) {
      for (var i = 0; i < usuarios.length; i++) {
        state.usuarios.push({
                              id         : usuarios[i][0],
                              adm_name   : usuarios[i][1],
                              adm_cargo  : usuarios[i][2],
                              adm_inicial: usuarios[i][3],
                              adm_estado : usuarios[i][4]
                            })
      }
    },
  },
  actions: {

    async Userlogeado({ commit }) {
      var url = '/datouserlogeado'
      await axios.get(url)
        .then(resp => {
          commit('USER_LOGEADO', resp.data)
          // commit('ID_OFICINA', resp.data.depe_id)
        })

    },
    async listadeoficinadelusuario({ commit }) {
      var url = '/oficinasdelusuario';
      await axios.get(url)
        .then(resp => {
          commit('OFICINAS_DELUSER', resp.data)
        })
    },
    async getuseroficina({commit},depe)
    {   var url = '/usuariosunidad/'+depe;
        await axios.get(url)
        .then(resp=>{
            commit('USERS_OFICINA',resp.data)
        })
    },
    async Getdependencias({ commit }) {
      var url = '/alldependencia';
      await axios.get(url)
        .then(response => {
          // state.listadependencias = response.data.datos;
          commit('ALL_DEPENDENCIA', response.data)
        })
    },
    obtenerDependenciaUser    : async function ({commit, getters, state}) {
      if (state.dependenciaUser.length === 0) {
        await axios.get('/unidades/obtenerUnidadOrganica' + '?tipo=5').then(response => {
          commit('llenarDependenciaUser', response.data)
        })
      }
    },
    GetdepeporID({ commit }, iddepe) {
      commit('DEPE_CODIGO', iddepe)

    },
    obtenerArchivadores: async function ({ getters, commit, state }) {
      if (state.archivadores.length === 0) {
        await axios.get('/archivador/obtenerArchivadores').then(response => {
          commit('llenarArchivadores', response.data)
        })
      }
    },
    obtenerPeriodosCorrelativo: async function ({commit}) {
      var a = []
      for (var i = 2015; i <= new Date().getFullYear(); i++) {
        a.push({tdco_periodo: i})
      }
      commit('llenarPeriodos', a)
    },

  },
  getters: {
    usuariologeado(state) {
      return state.usuariologeado;
    },

    oficinasdeluser(state) {
      return state.listaoficinadeluser;
    },
    usersoficinas(state) {
      return state.listauseroficina;
    },
    alldependencias(state) {
      return state.alldependencias;
    },
    // para acceder a en componente>  $store.getters.Getnombredepe(documento.depe_origen)
    // definimos la funcion
    Getnombredepe: (state) => (depe) => {
      const getdepe = state.alldependencias.find(todo => todo.iddependencia === depe)
      return (getdepe.depe_nombre !== undefined) ? getdepe.depe_nombre : null
    },
    getMiDependencia: state => {
      var d = state.alldependencias.filter(d => d.iddependencia === state.alldependencias.iddependencia)
      if (d[0] !== undefined) {
        return d[0]
      } else {
        return null
      }
    },
    getArchivadores: state => {
      return (state.archivadores !== undefined) ? state.archivadores : null
    },
    getPeriodosCorrelativo              : state => {
      return (state.periodosCorrelativo !== undefined) ? state.periodosCorrelativo : null
    },   
    getDependenciaNombre                : state => (id) => {
      var d = state.alldependencias.filter(d => d.iddependencia === parseInt(id))
      if (d[0] !== undefined) {
        return d[0].depe_nombre
      } else {
        return null
      }
    }, 
    getUnidadesForDerivacion            : state => {
      return (state.dependenciaUser === undefined) ? null : (state.alldependencias !== undefined) ? state.alldependencias.filter(d => d.depe_depende === state.dependenciaUser.depe_depende || d.depe_recibetramite) : null
    },
    getEntidadesExternas                : state => {
      return (state.alldependencias !== undefined) ? state.alldependencias.filter(d => d.depe_tipo === 2 && d.depe_depende === null) : null
    },
    getDependenciaUser              : state => {
      return (state.ofiseleccionado !== undefined) ? state.ofiseleccionado : null
    },
    getUsuario : state => {
      return (state.usuariologeado !== undefined) ? state.usuariologeado : null
    },
    getSedes                            : state => {
      return (state.alldependencias !== undefined) ? state.alldependencias.filter(d => d.depe_tipo === 0 && d.depe_depende === null) : null
    },
    getDerivarSoloCopia                 : state => {
      return state.derivar.soloCopia
    },
    getUsuariosActivo                   : state => {
      return (state.listauseroficina !== undefined) ? state.listauseroficina.filter(d => d.adm_estado === 1) : null
    },
    getUsuariosActivoNombre             : state => (id) => {
      var u = state.listaoficinadeluser.filter(d => d.id === parseInt(id))
      if (u[0] !== undefined) {
        return u[0].adm_name
      } else {
        return null
      }
    },
    getFormatBytes: state => (bytes) => {
      if (bytes != null) {
        if (bytes === 0) return '0 Bytes';
        const decimals  =2
        const k = 1024;
        const dm = decimals < 0 ? 0 : decimals;
        const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
  
        const i = Math.floor(Math.log(bytes) / Math.log(k));
  
        return parseFloat((bytes / Math.pow(k, i)).toFixed(dm)) + ' ' + sizes[i];
      } else {
        return ''
      }
      
    },
    getUnidadesDependenciaForCorrelativo: state => (tipo) => {
      return (parseInt(tipo) === 1) ? state.alldependencias.filter(d => d.depe_tipo === 1) : state.alldependencias.filter(d => d.depe_depende === state.dependenciaUser.depe_depende)
    },
    getTiposDocumento                   : state => {
      return (state.tiposDocumento !== undefined) ? state.tiposDocumento : null
    },
    getUnidadesSede                     : state => (id) => {
      return (state.alldependencias !== undefined) ? state.alldependencias.filter(d => d.depe_depende === parseInt(id)) : null
    },
    getUnidadesForReporte               : state => (id) => {
      return (id === null) ? null : (state.alldependencias !== undefined) ? state.alldependencias.filter(d => d.depe_depende === id || d.depe_recibetramite) : null
    },
    getUsuarios                         : state => {
      return (state.usuarios !== undefined) ? state.usuarios : null
    },
    getSedeDeUnidad                     : state => (id) => {
      var d = state.alldependencias.filter(d => d.iddependencia === parseInt(id))
      if (d[0] !== undefined) {
        return d[0].depe_depende
      } else {
        return null
      }
    },
    

  },
  modules: {

  }
})

export default store;