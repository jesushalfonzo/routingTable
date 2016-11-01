<?php include('../logeo.php'); 
include('../extras/conexion.php');
$link=Conectarse();

$aErrores=array();
$jsondata = array();

if((isset($_GET["idRango"]))&&($_GET["idRango"]!="")){ $idRango=strip_tags(htmlentities(mysqli_real_escape_string($link, $_GET["idRango"]))); } else {$idRango=0;}

if (!control_access("COLAS", 'ELIMINAR')) { 
	$aErrores[]="USTED NO TIENE PERMISOS PARA REALIZAR ESTA ACCIÓN"; 
}


if(count($aErrores)==0) { 

	$query = "DELETE FROM r_rangos_colas WHERE r_rangos_cola_id='$idRango'";
	$resultado = mysqli_query($link, $query);
	if ($resultado) {

		$jsondata["success"] = true;
		$jsondata["data"] = array(
			'message' => "El rango ha sido eliminada"
			);


	} else {
		$jsondata["success"] = false;
		$jsondata["data"] = array(
			'message' => "ERROR - Ocurrió un error al intentar borrar el rango"
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