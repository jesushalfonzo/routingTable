<?php include('../logeo.php'); 
include('../extras/conexion.php');
$link=Conectarse();

$aErrores=array();
$jsondata = array();

if((isset($_POST["ordenNuevo"]))&&($_POST["ordenNuevo"]!="")){ $ordenNuevo=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["ordenNuevo"]))); } else {$ordenNuevo=0;}


if (!control_access("BLOQUES", 'EDITAR')) { 
	$aErrores[]="USTED NO TIENE PERMISOS PARA REALIZAR ESTA ACCIÓN"; 
}


if(count($aErrores)==0) { 

	$posiciones = explode(",", $ordenNuevo);

	foreach ($posiciones as $posicion => $value) {
		$posicionNueva=$posicion+1;
		$SQL="UPDATE m_bloques SET m_bloque_posicion =$posicionNueva WHERE m_bloque_id ='$value' ";
		$updateOrden=mysqli_query($link, $SQL);
	}

	
	if ($updateOrden) {

		$jsondata["success"] = true;
		$jsondata["data"] = array(
			'message' => "El orden los bloques ha sido cambiado satisfactoriamente"
			);


	} else {
		$jsondata["success"] = false;
		$jsondata["data"] = array(
			'message' => "ERROR - El nuevo orden no pudo ser cambiado"
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