<?php include('../logeo.php'); 
include('../extras/conexion.php');
$link=Conectarse();


if (!control_access("ADMINISTRACION", 'EDITAR')) { $aErrores[] = "USTED NO TIENE PERSIMO PARA REALIZAR ESTA ACCION";  }


header('Content-type: application/json; charset=utf-8');
$aErrores=array();
$jsondata = array();

if((isset($_POST["usuarioNombre"]))&&($_POST["usuarioNombre"]!="")){ $usuarioNombre=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["usuarioNombre"]))); } else {$aErrores[] = "Debe especificar le nombre del usuario";}
if((isset($_POST["apellido"]))&&($_POST["apellido"]!="")){ $apellido=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["apellido"]))); } else {$aErrores[] = "Debe especificar el apellido del usuario";}
if((isset($_POST["login"]))&&($_POST["login"]!="")){ $login=strip_tags(mysqli_real_escape_string($link, $_POST["login"])); } else {$aErrores[] = "Debe especificar el login del usuario";}
if((isset($_POST["mail"]))&&($_POST["mail"]!="")){ $mail=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["mail"]))); } else {$aErrores[] = "El usuario debe tener una dirección de correo válida";}
if((isset($_POST["password"]))&&($_POST["password"]!="")){ $password=md5(htmlentities(mysqli_real_escape_string($link, $_POST["password"]))); $changepass=true; } else {$password=""; $changepass=false;}
if((isset($_POST["repitepassword"]))&&($_POST["repitepassword"]!="")){ $repitepassword=md5(htmlentities(mysqli_real_escape_string($link, $_POST["repitepassword"]))); } else {$repitepassword="";}
if((isset($_POST["grupouser"]))&&($_POST["grupouser"]!="")){ $grupouser=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["grupouser"]))); } else {$aErrores[] = "Dede indicar a que grupo pertenece el usuario";}
if((isset($_POST["idUser"]))&&($_POST["idUser"]!="")){ $idUser=mysqli_real_escape_string($link, $_POST["idUser"]); } else {$idUser="0";}




if ($password!=$repitepassword) {
	$aErrores[] = "Las claves nuevas no coinciden";
}


if(count($aErrores)==0) { 


if ($changepass) {
	$query = "UPDATE m_usuario SET  m_usuario_password='$password', m_usuario_nombre='$usuarioNombre', m_usuario_apellido='$apellido', m_grupo_id='$grupouser', m_usuario_correo='$mail' WHERE m_usuario_id='$idUser'";
} else {
	$query = "UPDATE m_usuario SET  m_usuario_nombre='$usuarioNombre', m_usuario_apellido='$apellido', m_grupo_id='$grupouser', m_usuario_correo='$mail' WHERE m_usuario_id='$idUser'";
}

	$resultado = mysqli_query($link, $query);
	if ($resultado) {

		$jsondata["success"] = true;
		$jsondata["data"] = array(
			'message' => "La información del usuario ha sido actualizada "
			);


	} else {
		$jsondata["success"] = false;
		$jsondata["data"] = array(
			'message' => "ERROR - Ocurrió un error al intentar actualizar"
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