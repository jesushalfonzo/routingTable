<?php include('../logeo.php'); 
include('../extras/conexion.php');
$link=Conectarse();

header('Content-type: application/json; charset=utf-8');
$aErrores=array();
$jsondata = array();

if((isset($_GET["idGrupo"]))&&($_GET["idGrupo"]!="")){ $idGrupo=strip_tags(htmlentities(mysqli_real_escape_string($link, $_GET["idGrupo"]))); } else {$idGrupo=0;}

if (!control_access("ADMINISTRACION", 'ELIMINAR')) { 
	$aErrores[]="USTED NO TIENE PERMISOS PARA REALIZAR ESTA ACCIÓN"; 
}


if(count($aErrores)==0) { 

	$query = "DELETE FROM  m_grupo WHERE m_grupo_id='$idGrupo' ";
	$resultado = mysqli_query($link, $query);
	if ($resultado) {

		$jsondata["success"] = true;
		$jsondata["data"] = array(
			'message' => "El Usuario ha sido borrado"
			);


	} else {
		$jsondata["success"] = false;
		$jsondata["data"] = array(
			'message' => "ERROR - Ocurrió un error al intentar borrar al usuario"
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