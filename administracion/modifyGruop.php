<?php include('../logeo.php'); 
include('../extras/conexion.php');
$link=Conectarse();


if (!control_access("ADMINISTRACION", 'EDITAR')) { $aErrores[] = "USTED NO TIENE PERSIMO PARA REALIZAR ESTA ACCION";  }


header('Content-type: application/json; charset=utf-8');
$aErrores=array();
$jsondata = array();

if((isset($_POST["grupoNombre"]))&&($_POST["grupoNombre"]!="")){ $grupoNombre=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["grupoNombre"]))); } else {$aErrores[] = "Debe especificar le nombre del Grupo";}
if((isset($_POST["descripconGrupo"]))&&($_POST["descripconGrupo"]!="")){ $descripconGrupo=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["descripconGrupo"]))); } else {$aErrores[] = "Debe Colocar una descripción al grupo";}
if((isset($_POST["idGroup"]))&&($_POST["idGroup"]!="")){ $idGroup=mysqli_real_escape_string($link, $_POST["idGroup"]); } else {$idGroup="0";}



if(count($aErrores)==0) { 


	$query = "UPDATE m_grupo SET  m_grupo_nombre='$grupoNombre', m_grupo_descripcion='$descripconGrupo' WHERE m_grupo_id='$idGroup'";


	$resultado = mysqli_query($link, $query);
	if ($resultado) {

		$jsondata["success"] = true;
		$jsondata["data"] = array(
			'message' => "La información del grupo ha sido actualizada "
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