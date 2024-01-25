<template>
    <div>
        <Modal ref="Busdoc"  />
        <!-- {{ formData }} -->
    </div>
</template>


<script>
import Modal from '../components/modulos/tramites/Sinmodalresultado.vue'
export default {
    name: 'StdvBuscadocumentos',
    props:['formData'],

    data() {
        return {
            
        };
    },
    components:{
        Modal
    },

    mounted() {
        this.buscarByDocumento(this.formData);
        
    },

    methods: {
        buscarByDocumento(idocumentomodal) // abre modal
        {
            // this.datomodal=idocumentomodal
            this.$refs.Busdoc.buscardocumento(idocumentomodal)

        },
        
    },
};
</script>

<style lang="scss" scoped>

</style>