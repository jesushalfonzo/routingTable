<?php include('../logeo.php'); 
include('../extras/conexion.php');
$link=Conectarse();

if (!control_access("BLOQUES", 'EDITAR')) { $aErrores[] = "USTED NO TIENE PERSIMO PARA REALIZAR ESTA ACCION";  }


$aErrores=array();
$jsondata = array();

if((isset($_POST["nameBlock"]))&&($_POST["nameBlock"]!="")){ $nameBlock=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["nameBlock"]))); } else {$aErrores[] = "Debe especificar el nombre del bloque";}
if((isset($_POST["countryBlock"]))&&($_POST["countryBlock"]!="")){ $countryBlock=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["countryBlock"]))); } else {$countryBlock=251;}
if((isset($_POST["descripcion"]))&&($_POST["descripcion"]!="")){ $descripcion=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["descripcion"]))); }  else {$descripcion="";}
if((isset($_POST["idBlock"]))&&($_POST["idBlock"]!="")){ $idBlock=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["idBlock"]))); } else {$aErrores[] = "NO SE HA ESPECIFICADO UN ID";}



$fechacompleta=date('Y-m-d H:i:s');


if(count($aErrores)==0) { 

	$query = "UPDATE m_bloques  SET m_bloque_nombre='$nameBlock', m_bloque_descripcion='$descripcion' , m_bloque_paisId='$countryBlock' WHERE m_bloque_id='$idBlock'";
	$resultado = mysqli_query($link, $query);

	if ($resultado) {

		//Envío la respuesta al Front para redirigir
		$jsondata["success"] = true;
		$jsondata["data"] = array(
			'message' => "Información del bloque actualizada exitosamente..."
			);


	} else {
		$jsondata["success"] = false;
		$jsondata["data"] = array(
			'message' => "Ocurrió un error, por favor revisar los campos " 
			);
	}

	echo json_encode($jsondata, JSON_FORCE_OBJECT);

}
else{ 
	$jsondata["success"] = false;
	$jsondata["data"] = array(
		'message' => $aErrores
		);

	echo json_encode($jsondata, JSON_FORCE_OBJECT);

}


?>

