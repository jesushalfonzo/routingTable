<?php include('../logeo.php'); 
include('../extras/conexion.php');
$link=Conectarse();

$aErrores=array();
$jsondata = array();

if((isset($_GET["idBloque"]))&&($_GET["idBloque"]!="")){ $idBloque=strip_tags(htmlentities(mysqli_real_escape_string($link, $_GET["idBloque"]))); } else {$idBloque=0;}

if (!control_access("BLOQUES", 'ELIMINAR')) { 
	$aErrores[]="USTED NO TIENE PERMISOS PARA REALIZAR ESTA ACCIÓN"; 
}


if(count($aErrores)==0) { 

	$query = "DELETE FROM m_bloques WHERE m_bloque_id='$idBloque'";
	$resultado = mysqli_query($link, $query);
	if ($resultado) {

		$jsondata["success"] = true;
		$jsondata["data"] = array(
			'message' => "El bloque ha sido borrado"
			);


	} else {
		$jsondata["success"] = false;
		$jsondata["data"] = array(
			'message' => "ERROR - Ocurrió un error al intentar borrar el bloque"
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