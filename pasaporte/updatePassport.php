<?php include('../logeo.php'); 
include('../extras/conexion.php');
$link=Conectarse();

if (!control_access("PASAPORTES", 'EDITAR')) { $aErrores[] = "USTED NO TIENE PERSIMO PARA REALIZAR ESTA ACCION"; }

$aErrores=array();
$jsondata = array();

if((isset($_POST["namePassport"]))&&($_POST["namePassport"]!="")){ $namePassport=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["namePassport"]))); } else {$aErrores[] = "Debe especificar el nombre que identificará al pasaporte";}
if((isset($_POST["descripcion"]))&&($_POST["descripcion"]!="")){ $descripcion=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["descripcion"]))); } else { $descripcion="";}
if((isset($_POST["estatus"]))&&($_POST["estatus"]!="")){ $activo=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["estatus"]))); }  else {$activo=0;}
if((isset($_POST["idPassport"]))&&($_POST["idPassport"]!="")){ $idPassport=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["idPassport"]))); } else {$aErrores[] = "NO SE HA ESPECIFICADO UN ID";}



$fechacompleta=date('Y-m-d H:i:s');


if(count($aErrores)==0) { 

	$query = "UPDATE m_pasaportes  SET m_pasaporte_name='$namePassport', m_pasaporte_description='$descripcion' , m_pasaporte_estatus='$activo', m_pasaporte_updatedAt ='now()' WHERE m_pasaporte_id='$idPassport'";
	$resultado = mysqli_query($link, $query);

	if ($resultado) {

		//Envío la respuesta al Front para redirigir
		$jsondata["success"] = true;
		$jsondata["data"] = array(
			'message' => "Pasaporte actualizado exitosamente..."
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

