import Vue from 'vue';
// import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import LaravelPermissionToVueJS from 'laravel-permission-to-vuejs'

import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';

import Router from 'vue-router';

Vue.use(ElementUI);
Vue.use(LaravelPermissionToVueJS)
Vue.use(Router);
// Import Bootstrap and BootstrapVue CSS files (order is important)
// import 'bootstrap/dist/css/bootstrap.css'
// import 'bootstrap-vue/dist/bootstrap-vue.css'

// Make BootstrapVue available throughout your project
// Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
// Vue.use(IconsPlugin)


import Inicio  from '../components/dashboard/index.vue';
// tramites
import Tramites  from '../components/modulos/tramites/index'// por defecto se va mostrar en proceso
import Nuevotramite  from '../components/modulos/tramites/Crear'// nuevo tramite
import Editartramite  from '../components/modulos/tramites/editar'// nuevo tramite

import Porrecibir  from '../components/modulos/tramites/porrecibir'// documentos por recepcionar
import Archivados  from '../components/modulos/tramites/DocuArchivado'// documentos por recepcionar
// tramite fisico
import Tramfisico from '../components/modulos/tramitefisico/index'
// Atención de mesa de partes virtual
import AtenciomMPV from '../components/modulos/atencionmesapartesvirtual/index'
import DerivadosMPV from '../components/modulos/atencionmesapartesvirtual/MpvDerivative'
import ReporteMPV from '../components/modulos/atencionmesapartesvirtual/MpvReport'

import Archivadores from '../components/modulos/administracion/catalogo/index';
import Nuevoarchivador from '../components/modulos/administracion/catalogo/nuevo';

// mesa de partes virtual
import MesaPartes from '../components/modulos/mesapartesvirtual/index'
import Documentodigital from '../components/modulos/mesapartesvirtual/Documentodigital'
import Foliosasunto from '../components/modulos/administracion/foliosasunto/index'

import seguimientoexterno from '../components/modulos/mesapartesvirtual/seguimientotramiteexterno'

// Administracion
//dependencias
import DependenciaExterna  from '../components/modulos/administracion/dependencia/entidadexterna'// listar
import Dependencia  from '../components/modulos/administracion/dependencia/index'// listar
import Creardependencia  from '../components/modulos/administracion/dependencia/crear'// crear
import Editardependencia  from '../components/modulos/administracion/dependencia/editar'// editar
import Veroficinas  from '../components/modulos/administracion/dependencia/oficinas'// Veroficinas  
import Unidadesxdepe  from '../components/modulos/administracion/dependencia/unidadxdepe'// Veroficinas  
import Unidadesorgnaicas  from '../components/modulos/administracion/dependencia/unidadesorganicas'// Veroficinas  


import Correlativos  from '../components/modulos/administracion/correlativos/index'// correlativos 
// tipo documentos
import Tipodocumentos from '../components/modulos/administracion/tipodocumento/index'
import CataTipoDocumentoNuevo from '../components/modulos/administracion/tipodocumento/nuevo'
// usuarios
import Usuarios  from '../components/modulos/administracion/usuarios/index'// documentos por recepcionar
import Editar  from '../components/modulos/administracion/usuarios/editar'// documentos por recepcionar

//Rolesypermisos
import Rolesypermisos  from '../components/modulos/administracion/rolesypermisos/index'

//REPORTES
import Reportes  from '../components/modulos/reportes/index'
//PUBLICACION
import Publicacion  from '../components/modulos/administracion/publicaciones/index'
import Newpublicacion  from '../components/modulos/administracion/publicaciones/nueva'

export default new Router({
    mode: 'history',
    routes:[
        // {    
        //     path:'/login',
        //     name:'login',
        //     component:Login 
        // },
        {   path:'/',
            name:'Dashboard',
            component:Inicio 
        },
        ,
        {    
            path:'/Tramites/Enproceso',
            name:'Trámites en proceso',
            component:Tramites 
        },
        {   
            path:'/Tramites/Nuevotramite',
            name:'Nuevo trámite',
            component:Nuevotramite 
        },
        {   
            path:'/Tramites/:doc/Editar',
            name:'Editar trámite',
            component:Editartramite 
        },
        {
            path:'/tramite/enproceso/response',
            name:'Responder documento',
            component:Nuevotramite
        },
        {   
            path:'/Tramites/Porrecibir',
            name:'Trámites por recibir',
            component:Porrecibir 
        },
        {   
            path:'/Tramites/Archivados',
            name:'Trámites archivados',
            component:Archivados 
        },
        {   
            path:'/catalogos',
            name:'Archivadores',
            component:Archivadores 
        },
        {   
            path:'/catalogos-nuevo',
            name:'Nuevo Archivador',
            component:Nuevoarchivador 
        },
        {
            path:'/catalogo/archivador/:id/edit',
            name:'CataArchivadorEdit',
            component:Nuevoarchivador
        },
        {   
            path:'/Tramites/Fisico',
            name:'Recepción de trámites físico',
            component:Tramfisico 
        },
        {   
            path:'/Tramites/virtual',
            name:'Recepción de trámites Virtual',
            component:AtenciomMPV 
        },
        {   
            path:'/Tramites/virtual-derivados',
            name:'Derivación de trámites Virtual',
            component:DerivadosMPV 
        },
        {   
            path:'/Tramites/virtual-reporte',
            name:'Reporte de trámites Virtual',
            component:ReporteMPV 
        },

        // MESA DE PARTES VIRTUAL
        {
            path:'/mesapartes',
            name:'Mesa de  Partes Virtual',
            component:MesaPartes
        },
        {
            path:'/mesapartes/:id/:token',
            name:'ExterMesaPartesVirtualEdit',
            component:MesaPartes,
        },
        
        {
            path:'/documentosdigitales',
            name:'Documento digital',
            component:Documentodigital
        },
        {
            path:'/registro/seguimiento',
            name:'Seguimiento de trámites externos',
            component:seguimientoexterno
        },
        // administracion
         // Dependencia->listar entidad externa
         {   
            path:'/Administracion/dependenciaExterna',
            name:'Gestión de entindades externas',
            component:DependenciaExterna 
        },
        // Dependencia->listar
         {   
            path:'/Administracion/dependencia',
            name:'Gestión de dependencias',
            component:Dependencia 
        },
        // Dependencia->crear
        {   
            path:'/Administracion/dependencia/crear',
            name:'Creación de dependencias',
            component:Creardependencia 
        },
        // Dependencia->editar
        {   
            path:'/Administracion/dependencia/edit/:iddepe',
            name:'Editar dependencias',
            component:Editardependencia,
            props:true 
        },
         // Dependencia->ver oficina
        {   
            path:'/Administracion/dependencia/oficinas/:iddep',
            name:'Listado oficinas',
            component:Veroficinas,
            props:true 
        },        
        {   
            path:'/Administracion/unidaddependencia',
            name:'Unidades x depedencia',
            component:Unidadesxdepe,
        }, 
        {   
            path:'/Administracion/unidadorganicas',
            name:'Unidades orgánicas',
            component:Unidadesorgnaicas,
        },         // Dependencia->ver oficina
         {   
            path:'/Administracion/tipodocumentos',
            name:'Gestión de tipo documentos',
            component:Tipodocumentos,
        },
        {
            path:'/tipoDocumento-create',
            name:'Nuevo tipo documento',
            component:CataTipoDocumentoNuevo
        },
        {
            path:'/tipoDocumento-create/:id/edit',
            name:'Editar tipo documento',
            component:CataTipoDocumentoNuevo
        },
        {   
            path:'/Administracion/correlativos',
            name:'Gestión de correlativos de los documentos',
            component:Correlativos,
        },

        // usuarios
        {   
            path:'/Administracion/usuarios',
            name:'Gestión de usuarios',
            component:Usuarios 
        },
        {   
            path:'/Administracion/usuarios/edit/:id',
            name:'Editar usuario',
            component:Editar,
            props:true
        },
        {   
            path:'/Administracion/rolesypermisos',
            name:'Gestión de roles y permisos',
            component:Rolesypermisos 
        },
        {   
            path:'/Reportes',
            name:'Gestión de reportes',
            component:Reportes 
        },
        {   path:'/Administracion/Publicaciones',
            name:'Gestión de publicaciones',
            component:Publicacion,
        },
        {   path:'/Editpublicaciones/:id/edit',
            name:'Editar publicación',
            component:Newpublicacion
        },
        {   
            path:'/Publicaciones-create',
            name:'Creación de publicaciones',
            component:Newpublicacion 
        },
        {   
            path:'/Administracion/foliosasunto',
            name:'Ayuda en folios y asunto',
            component:Foliosasunto 
        },


    ],
    linkActiveClass:'active'
})