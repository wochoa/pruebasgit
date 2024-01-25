<?php


$url=$_REQUEST['url'];
$archivo=$_REQUEST['archivo'];

unlink('parametrosfirma/'.$archivo);

   if (isset($_FILES['signed_file']))
   {
   			$separa=DIRECTORY_SEPARATOR;

   			$tmp = dirname(tempnam (null,'')); 

			mkdir( $tmp.$separa."upload");

		    $file_name = $_FILES['signed_file']['name'];
		    $file_tmp =$_FILES['signed_file']['tmp_name'];
			$tamanio = $_FILES["signed_file"]["size"];
			$tipo = $_FILES["signed_file"]["type"];
			$directorio='../storage/app/'.$url;//$file_name;
			// $directorio='upload/'.$file_name;

			move_uploaded_file($file_tmp,$directorio);
			

	    	
   }




?>



