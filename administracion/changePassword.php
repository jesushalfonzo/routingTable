<?php include('../logeo.php'); 
include('../extras/conexion.php');
$link=Conectarse();

header('Content-type: application/json; charset=utf-8');
$aErrores=array();
$jsondata = array();

if((isset($_POST["iduser"]))&&($_POST["iduser"]!="")){ $iduser=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["iduser"]))); } else {$aErrores[] = "No hay información del usuario";}
if((isset($_POST["login"]))&&($_POST["login"]!="")){ $login=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["login"]))); } else {$aErrores[] = "No hay información del usuario, session vencida";}
if((isset($_POST["claveactual"]))&&($_POST["claveactual"]!="")){ $claveactual=md5(mysqli_real_escape_string($link, $_POST["claveactual"])); } else {$aErrores[] = "Debe especificar su clave actual";}
if((isset($_POST["clavenueva"]))&&($_POST["clavenueva"]!="")){ $clavenueva=md5(htmlentities(mysqli_real_escape_string($link, $_POST["clavenueva"]))); } else {$aErrores[] = "Su clave no puede estar vacía";}
if((isset($_POST["repiteclave"]))&&($_POST["repiteclave"]!="")){ $repiteclave=md5(htmlentities(mysqli_real_escape_string($link, $_POST["repiteclave"]))); } else {$aErrores[] = "Debe repetir su clave nueva";}



if ($clavenueva!=$repiteclave) {
	$aErrores[] = "Su clave nueva no coincide";
}

$SQLActual="SELECT m_usuario_password FROM m_usuario WHERE m_usuario_id='$iduser'";
$queryActual=mysqli_query($link, $SQLActual);
$rowActual=mysqli_fetch_array($queryActual);
$m_usuario_password=$rowActual["m_usuario_password"];


if ($m_usuario_password!=$claveactual) {
	$aErrores[] = "Su clave Actual es incorrecta";
}


if(count($aErrores)==0) { 

	$query = "UPDATE m_usuario SET m_usuario_password='$clavenueva' WHERE m_usuario_id='$iduser' ";
	$resultado = mysqli_query($link, $query);
	if ($resultado) {

		$jsondata["success"] = true;
		$jsondata["data"] = array(
			'message' => "Su clave ha sido cambiada"
			);


	} else {
		$jsondata["success"] = false;
		$jsondata["data"] = array(
			'message' => "ERROR - Ocurrió un error al intentar actualizar su clave"
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