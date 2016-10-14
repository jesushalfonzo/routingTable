<?php include('../logeo.php'); 
include('../extras/conexion.php');
$link=Conectarse();

if (!control_access("BLOQUES", 'AGREGAR')) { $aErrores[] = "USTED NO TIENE PERSIMO PARA REALIZAR ESTA ACCION";  }


$aErrores=array();
$jsondata = array();




if((isset($_POST["nameBlock"]))&&($_POST["nameBlock"]!="")){ $nameBlock=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["nameBlock"]))); } else {$aErrores[] = "Debe especificar el nombre del bloque";}
if((isset($_POST["description"]))&&($_POST["description"]!="")){ $description=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["descripcion"]))); } else {$description="";}
if((isset($_POST["countryBlock"]))&&($_POST["countryBlock"]!="")){ $countryBlock=mysqli_real_escape_string($link, $_POST["countryBlock"]); }  else {$countryBlock=251;}

$fechacompleta=date('Y-m-d H:i:s');


if(count($aErrores)==0) { 

	$query = "INSERT INTO m_bloques (m_bloque_id, m_bloque_nombre, m_bloque_descripcion, m_bloque_paisId, m_bloque_date) VALUES (Null, '$nameBlock', '$description', '$countryBlock', Now())";
	$resultado = mysqli_query($link, $query);
	$lastshit=mysqli_insert_id($link);

	if ($resultado) {

		//Envío la respuesta al Front para redirigir
		$jsondata["success"] = true;
		$jsondata["data"] = array(
			'message' => "Bloque rinsertado exitosamente... "
			);


	} else {
		$jsondata["success"] = false;
		$jsondata["data"] = array(
			'message' => "Error al intentar agregar bloque "
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

