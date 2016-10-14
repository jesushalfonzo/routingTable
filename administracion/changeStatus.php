<?php include('../logeo.php'); 
include('../extras/conexion.php');
$link=Conectarse();

header('Content-type: application/json; charset=utf-8');

$aErrores=array();
$jsondata = array();

if((isset($_GET["idUser"]))&&($_GET["idUser"]!="")){ $idUser=strip_tags(htmlentities(mysqli_real_escape_string($link, $_GET["idUser"]))); } else {$idUser=0;}
if((isset($_GET["nextStatus"]))&&($_GET["nextStatus"]!="")){ $nextStatus=strip_tags(htmlentities(mysqli_real_escape_string($link, $_GET["nextStatus"]))); } else {$nextStatus=0;}




if (!control_access("ADMINISTRACION", 'ELIMINAR')) { 
	$aErrores[]="USTED NO TIENE PERMISOS PARA REALIZAR ESTA ACCIÓN"; 
}


if(count($aErrores)==0) { 

	$query = "UPDATE m_usuario SET m_usuario_status='$nextStatus' WHERE m_usuario_id='$idUser' ";
	$resultado = mysqli_query($link, $query);
	if ($resultado) {

		$jsondata["success"] = true;
		$jsondata["data"] = array(
			'message' => "La categoría ha sido cambiada de estatus"
			);


	} else {
		$jsondata["success"] = false;
		$jsondata["data"] = array(
			'message' => "ERROR - Ocurrió un error al intentar cambiar el estatus del Usuario"
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