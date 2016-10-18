<?php include('../logeo.php'); 
include('../extras/conexion.php');
$link=Conectarse();

$aErrores=array();
$jsondata = array();

if((isset($_GET["idCola"]))&&($_GET["idCola"]!="")){ $idCola=strip_tags(htmlentities(mysqli_real_escape_string($link, $_GET["idCola"]))); } else {$idCola=0;}

if (!control_access("COLAS", 'ELIMINAR')) { 
	$aErrores[]="USTED NO TIENE PERMISOS PARA REALIZAR ESTA ACCIÓN"; 
}


if(count($aErrores)==0) { 

	$query = "DELETE FROM m_cola WHERE m_cola_id='$idCola'";
	$resultado = mysqli_query($link, $query);
	if ($resultado) {

		$jsondata["success"] = true;
		$jsondata["data"] = array(
			'message' => "La cola ha sido eliminada"
			);


	} else {
		$jsondata["success"] = false;
		$jsondata["data"] = array(
			'message' => "ERROR - Ocurrió un error al intentar borrar la cola $query"
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