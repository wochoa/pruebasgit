<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Firma peru web</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <link rel="stylesheet" href="https://getbootstrap.com/docs/4.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://getbootstrap.com/docs/4.6/dist/js/bootstrap.bundle.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/vue@2.7.14"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <!-- <script type="text/javascript">
        console.log("JQuery de la web demo" + $.fn.jquery);
    </script> -->

    
</head>
<body>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script type="text/javascript">

        var jqFirmaPeru=jQuery.noConflict(true);

        function signatureInit()
                {
                    alert('PROCESO INICIADO');
                }
        function signatureOk()
                {
                    alert('DOCUMENTO FIRMADO')
                }
        function signatureCancel()
                {
                    alert('OPERACIÓN CANCELADA')
                }

    </script>
    <script src="https://apps.firmaperu.gob.pe/web/clienteweb/firmaperu.min.js"></script>

<div id="app">
    <div id="addComponent" style="display:none;"></div>
    <button type="button" class="btn btn-lg btn-primary" @click="sendParam();">INICIAR FIRMA</button>
    <!-- <p>@{{message}}</p> -->
</div>

    <script>
        var app = new Vue({
            el: '#app',
            data: {
                parametros:'',
                port:48596
            },
            mounted() {
                // this.sendParam();
            },
            methods:
            {
               
                // signatureInit()
                // {
                //     alert('PROCESO INICIADO');
                // },
                // signatureOk()
                // {
                //     alert('DOCUMENTO FIRMADO')
                // },
                // signatureCancel()
                // {
                //     alert('OPERACIÓN CANCELADA')
                // },
                sendParam()
                {   
                    var urlparametros_gral='/parametros-principal.php'
                    axios.post(urlparametros_gral)
                    .then(res=>{
                        // console.log(res.data)
                        this.parametros=res.data
                        startSignature(this.port,this.parametros);
                    })
                    
                    
                    
                },

            }
            })
    </script>
</body>
</html>