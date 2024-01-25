<?php

    $param= '{
                "param_url": "http://firmaperu.test/parametros2.php",
                "param_token": "1626476967",
                "document_extension": "pdf"
            }';
    echo  base64_encode($param);
    //echo  $param;
?>