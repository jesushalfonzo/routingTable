<?php include('../logeo.php'); 
include('../extras/conexion.php');
$link=Conectarse();


if (!control_access("ADMINISTRACION", 'AGREGAR')) { $aErrores[] = "USTED NO TIENE PERSIMO PARA REALIZAR ESTA ACCION";  }


header('Content-type: application/json; charset=utf-8');
$aErrores=array();
$jsondata = array();

if((isset($_POST["usuarioNombre"]))&&($_POST["usuarioNombre"]!="")){ $usuarioNombre=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["usuarioNombre"]))); } else {$aErrores[] = "Debe especificar le nombre del usuario";}
if((isset($_POST["apellido"]))&&($_POST["apellido"]!="")){ $apellido=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["apellido"]))); } else {$aErrores[] = "Debe especificar el apellido del usuario";}
if((isset($_POST["login"]))&&($_POST["login"]!="")){ $login=strip_tags(mysqli_real_escape_string($link, $_POST["login"])); } else {$aErrores[] = "Debe especificar el login del usuario";}
if((isset($_POST["mail"]))&&($_POST["mail"]!="")){ $mail=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["mail"]))); } else {$aErrores[] = "El usuario debe tener una dirección de correo válida";}
if((isset($_POST["password"]))&&($_POST["password"]!="")){ $password=md5(htmlentities(mysqli_real_escape_string($link, $_POST["password"]))); } else {$aErrores[] = "Debe asignar una clave";}
if((isset($_POST["repitepassword"]))&&($_POST["repitepassword"]!="")){ $repitepassword=md5(htmlentities(mysqli_real_escape_string($link, $_POST["repitepassword"]))); } else {$aErrores[] = "Debe volver a escribir la clave";}
if((isset($_POST["grupouser"]))&&($_POST["grupouser"]!="")){ $grupouser=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["grupouser"]))); } else {$aErrores[] = "Dede indicar a que grupo pertenece el usuario";}





if ($password!=$repitepassword) {
	$aErrores[] = "Las claves nuevas no coinciden";
}

$SQLActual="SELECT m_usuario_login FROM m_usuario WHERE m_usuario_login='$login'";
$queryActual=mysqli_query($link, $SQLActual);
$existe=mysqli_num_rows($queryActual);

if ($existe) {
	$aErrores[] = "Ya existe un usuario con este login";
}


$SQLMail="SELECT m_usuario_correo FROM m_usuario WHERE m_usuario_correo='$mail'";
$querymail=mysqli_query($link, $SQLMail);
$existeMail=mysqli_num_rows($querymail);

if ($existeMail) {
	$aErrores[] = "Ya existe un usuario con este e-mail registrado";
}




if(count($aErrores)==0) { 

	$query = "INSERT INTO m_usuario (m_usuario_id, m_usuario_login, m_usuario_password, m_usuario_nombre, m_usuario_apellido, m_grupo_id, m_usuario_status, m_usuario_correo) VALUES (Null, '$login', '$password', '$usuarioNombre', '$apellido', '$grupouser', 'A', '$mail')";
	$resultado = mysqli_query($link, $query);
	if ($resultado) {

		$jsondata["success"] = true;
		$jsondata["data"] = array(
			'message' => "El usuario ha sido creado correctamente"
			);


	} else {
		$jsondata["success"] = false;
		$jsondata["data"] = array(
			'message' => "ERROR - Ocurrió un error al intentar crear el usuario"
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