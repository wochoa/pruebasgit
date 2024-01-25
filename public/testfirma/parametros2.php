<?php


header('Access-Control-Allow-Origin: *');


        $curl = curl_init();
        $fields = array('client_id' => 'Mm1S8TJSwTIwNTI3MTQ3NjEyAJeNy7hJMw', 'client_secret' => 'GWtXjSdO_lbP_vyolY0IZNxYfX1vKSwcNIQ');
        $fields_string = http_build_query($fields);

        curl_setopt_array($curl, 
        array(
          CURLOPT_URL => 'https://apps.firmaperu.gob.pe/admin/api/security/generate-token',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 0,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_POSTFIELDS => $fields_string,
          CURLOPT_POST => 1
        ));
        
        $response = curl_exec($curl);

        // echo $response;



    $param ='{
                "signatureFormat": "PAdES",
                "signatureLevel": "B",
                "signaturePackaging": "enveloped",
                "documentToSign":"http://firmaperu.test/demo/demo.pdf",
                "certificateFilter": ".*",
                "webTsa": "",
                "userTsa": "",
                "passwordTsa": "",
                "theme": "oscuro",
                "visiblePosition": true,
                "contactInfo": "",
                "signatureReason": "Soy el autor de este documento",
                "bachtOperation": false,
                "oneByOne": true,
                "signatureStyle": 1,
                "imageToStamp":"http://firmaperu.test/img/stamp3_1.png",
                "stampTextSize": 14,
                "stampWordWrap": 37,
                "role": "Analista de servicios",
                "stampPage": 1,
                "positionx": 20,
                "positiony": 20,
                "uploadDocumentSigned":"http://firmaperu.test/Uploadx.php",
                "certificationSignature": false,
                "token":"'.$response.'"
        }';
        //echo $param;
        echo base64_encode($param);
 


?>