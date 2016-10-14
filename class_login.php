<?php
session_start();
header('Content-type: application/json; charset=utf-8');
include("extras/conexion.php");
$link=Conectarse();
$aErrores=array();
$jsondata = array();

if((isset($_POST["userLogin"]))&&($_POST["userLogin"]!="")){ $login=strip_tags(htmlentities($_POST["userLogin"])); } else {$aErrores[] = "Debe introducir el login";}
if((isset($_POST["passLogin"]))&&($_POST["passLogin"]!="")){ $password=md5(strip_tags(htmlentities($_POST["passLogin"]))); } else {$aErrores[] = "El password no puede estar vacío";}
$ipcliente=getRealIP($_SERVER['REMOTE_ADDR']);
$fechacompleta=date('Y-m-d H:i:s');

if(count($aErrores)==0) { 

	//PARA VALIDAR SI EL USUARIO EXISTE EN LA BD
	$query = "SELECT * FROM  m_usuario WHERE m_usuario_login='".mysqli_real_escape_string($link, $login)."' AND m_usuario_password='".mysqli_real_escape_string($link, $password)."'";
	$resultado = mysqli_query($link, $query);
	$existe=mysqli_num_rows($resultado);

	if ($existe >0) {
		

		//SI EXISTE SACOS SUS DATOS Y CREO LAS VARIABLES DE SESION 
		$row=mysqli_fetch_array($resultado);
		$m_grupo_id=$row["m_grupo_id"];
		$nombre_usuario=$row["m_usuario_nombre"];
		$apellido_usuario=$row["m_usuario_apellido"];
		$usuario_id=$row["m_usuario_id"];
		$nombre_completo=utf8_encode($nombre_usuario." ".$apellido_usuario);

		ini_set('session.gc_maxlifetime',7200);   
		$_SESSION["tDxEd1cionRT"]= 'tDXOp3racionesRY';
		$_SESSION['usuarioL0g3ad0']=$login;
		$_SESSION['nombreUSUcmpleto']=$nombre_completo;
		$_SESSION["1dusuar10"]=$usuario_id;

		//GUARDA LA INFO DEL ACCESO EN LA BITACORA DE ACCESOS
		$SQLBitacora="INSERT INTO bitacora_acceso VALUES (Null, '$login', 'ACCESO PERMITIDO', '$ipcliente', '$fechacompleta')";
		$queryBitacora=mysqli_query($link, $SQLBitacora);

		//CONSULTO LOS PERMISOS DEL USUARIO Y CREO LA VARIABLE DE SESION CON LOS PERMISOS QUE POSEE
		$SQL_Permisos="SELECT m_seccion.m_seccion_id, m_seccion.m_seccion_nombre, m_acciones.m_acciones_nombre, m_acciones.m_acciones_id, m_permiso_status
		FROM m_seccion, m_acciones, m_permiso
		WHERE m_permiso.m_grupo_id = '$m_grupo_id'
		AND m_seccion.m_seccion_id = m_permiso.m_seccion_id
		AND m_permiso.m_accion_id = m_acciones.m_acciones_id
		ORDER BY m_seccion_id ASC";

		$query_permisos=mysqli_query($link, $SQL_Permisos);

		while($row_permisos=mysqli_fetch_array($query_permisos)){
			$m_seccion_id=$row_permisos["m_seccion_id"];
			$m_seccion_nombre=strtoupper($row_permisos["m_seccion_nombre"]);
			$m_acciones_nombre=strtoupper($row_permisos["m_acciones_nombre"]);
			$m_acciones_id=$row_permisos["m_acciones_id"];
			$m_permiso_status=strtoupper($row_permisos["m_permiso_status"]);

			$permisos[$m_seccion_nombre][$m_acciones_nombre]=$m_permiso_status;

		}
		$_SESSION["R0l3sp3rM1s0sTra"]=$permisos;
		//Envío la respuesta al Front para redirigir
		$jsondata["success"] = true;
		$jsondata["data"] = array(
			'message' => "Ingresando... "
			);


	} else {
		$jsondata["success"] = false;
		$jsondata["data"] = array(
			'message' => "Combinación Usuario/Password incorrecta"
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

function getRealIP()
{
	if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){$obtener=$_SERVER["HTTP_X_FORWARDED_FOR"];}else{$obtener="";}
	if($obtener != '')
	{
		$client_ip = 
		( !empty($_SERVER['REMOTE_ADDR']) ) ? 
		$_SERVER['REMOTE_ADDR'] 
		: 
		( ( !empty($_ENV['REMOTE_ADDR']) ) ? 
			$_ENV['REMOTE_ADDR'] 
			: 
			"unknown" );

		$entries = preg_split('/[, ]/', $_SERVER['HTTP_X_FORWARDED_FOR']);

		reset($entries);
		while (list(, $entry) = each($entries)) 
		{
			$entry = trim($entry);
			if ( preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list) )
			{
				$private_ip = array(
					'/^0\./', 
					'/^127\.0\.0\.1/', 
					'/^192\.168\..*/', 
					'/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/', 
					'/^10\..*/');

				$found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);

				if ($client_ip != $found_ip)
				{
					$client_ip = $found_ip;
					break;
				}
			}
		}
	}
	else
	{
		$client_ip = 
		( !empty($_SERVER['REMOTE_ADDR']) ) ? 
		$_SERVER['REMOTE_ADDR'] 
		: 
		( ( !empty($_ENV['REMOTE_ADDR']) ) ? 
			$_ENV['REMOTE_ADDR'] 
			: 
			"unknown" );
	}

	return $client_ip;

}
?>