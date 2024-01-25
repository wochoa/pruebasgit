<template>
<div class="login-box">
    <div class="login-logo">
        <a href="#"><b>Iniciar </b>session</a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
        <div class="card-body login-card-body">
            <p class="login-box-msg">Ingresa tus credencias para iniciar session</p>

            <form action="#" method="post">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" @keyup.enter="login" placeholder="Email" v-model="fillLogin.cEmail">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-envelope"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" @keyup.enter="login"  placeholder="Password" v-model="fillLogin.cContrasena">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                
            </form>
            <div class="row">
                <div class="col-md-12">
                    <span v-if="error">
                        <div v-for="(e,index) in mensageError" :key="index" v-text="e" class="callout callout-danger"></div>
                    </span>
                </div>
            </div>

            <div class="social-auth-links text-center mb-3">
                
                <button class="btn btn-flat btn-block btn-primary" @click.prevent="login" v-loading.fullscreen.lock="fullscreenloading">
                    <i class="fab fa-facebook mr-2"></i> Iniciar session
                </button>
                
            </div>
            <!-- /.social-auth-links -->

           
        </div>
        <!-- /.login-card-body -->
    </div>
</div>
<!-- /.login-box -->
</template>

<script>
import Axios from 'axios';

export default {
    name: 'StdLogin',

    data() {
        return {
            fillLogin:{
                cEmail:'',
                cContrasena:''
            },
            fullscreenloading:false,
            error:0,
            mensageError:[],
        };
    },

    mounted() {

    },

    methods: {
        login()
        {
            if(this.validarlogin())
            {
                return;
            }
            this.fullscreenloading=true;

            var url='/authenticate/login';
            axios.post(url,{
                    'email':this.fillLogin.cEmail,
                    'pass':this.fillLogin.cContrasena                
            }).then(Response=>{
                // console.log(Response.data);
                this.fullscreenloading=false;
                if(Response.data.code==401){
                    this.errorlogin();
                }
                if(Response.data.code==200){
                    this.logincorrecto();
                }
            })

        },
        validarlogin()
        {
            this.error=0;
            this.mensageError=[];

            // campo email y contrasena no esten vacios
            if(!this.fillLogin.cEmail)
            {
                this.mensageError.push('El campo de correo electronico es obligatorio')
            }
            if(!this.fillLogin.cContrasena)
            {
                this.mensageError.push('El campo de contrasena es obligatorio')
            }
            // si existe algun elemento
            if(this.mensageError.length)
            {
                this.error=1;
            }
            return this.error;
        },
        errorlogin()
        {
            this.error=0;
            this.mensageError=[];

            // campo email y contrasena no esten vacios
           
                this.mensageError.push('Estas credenciales no coinciden con nuestros registros');
                this.fillLogin.cContrasena='';
            // si existe algun elemento
            if(this.mensageError.length)
            {
                this.error=1;
            }
            return this.error;
        },
        logincorrecto()
        {
            this.$router.push({name:'dashboard'});
            location.reload();
        }

    },
};
</script>

<style lang="scss" scoped>

</style>
