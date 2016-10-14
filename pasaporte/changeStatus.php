<?php include('../logeo.php'); 
include('../extras/conexion.php');
$link=Conectarse();

$aErrores=array();
$jsondata = array();

if((isset($_GET["idPasaporte"]))&&($_GET["idPasaporte"]!="")){ $idPasaporte=strip_tags(htmlentities(mysqli_real_escape_string($link, $_GET["idPasaporte"]))); } else {$idPasaporte=0;}
if((isset($_GET["nextStatus"]))&&($_GET["nextStatus"]!="")){ $nextStatus=strip_tags(mysqli_real_escape_string($link, $_GET["nextStatus"])); } else {$nextStatus=0;}




if (!control_access("PASAPORTES", 'ELIMINAR')) { 
	$aErrores[]="USTED NO TIENE PERMISOS PARA REALIZAR ESTA ACCIÓN"; 
}


if(count($aErrores)==0) { 

	$query = "UPDATE m_pasaportes SET m_pasaporte_estatus='$nextStatus' WHERE m_pasaporte_id='$idPasaporte' ";
	$resultado = mysqli_query($link, $query);
	if ($resultado) {

		$jsondata["success"] = true;
		$jsondata["data"] = array(
			'message' => "El Pasaporte ha sido cambiada de estatus"
			);


	} else {
		$jsondata["success"] = false;
		$jsondata["data"] = array(
			'message' => "ERROR - Ocurrió un error al intentar cambiar el estatus de la categoría"
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