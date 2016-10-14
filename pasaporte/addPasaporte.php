<?php include('../logeo.php'); 
include('../extras/conexion.php');
$link=Conectarse();

if (!control_access("PASAPORTES", 'AGREGAR')) { $aErrores[] = "USTED NO TIENE PERSIMO PARA REALIZAR ESTA ACCION";  }


$aErrores=array();
$jsondata = array();


if((isset($_POST["namePassport"]))&&($_POST["namePassport"]!="")){ trim($namePassport=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["namePassport"])))); } else {$aErrores[] = "Debe especificar el identificador del pasaporte";}
if((isset($_POST["descripcion"]))&&($_POST["descripcion"]!="")){ $descripcion=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["descripcion"]))); } else { $descripcion="";}

$fechacompleta=date('Y-m-d H:i:s');

//VALIDANDO QUE NO EXISTA EN LA BD
$SQL_val="SELECT m_pasaporte_id FROM m_pasaportes WHERE m_pasaporte_name='$namePassport'";
$queryVal=mysqli_query($link, $SQL_val);
$validado=mysqli_num_rows($queryVal);
if ($validado>0) {
	$aErrores="ESTE PASAPORTE YA SE ENCUENTRA REGISTRADO";
}

if(count($aErrores)==0) { 

	$query = "INSERT INTO m_pasaportes (m_pasaporte_id, m_pasaporte_name, m_pasaporte_description, m_pasaporte_estatus, m_pasaporte_createdAt, m_pasaporte_updatedAt) VALUES (Null, '$namePassport', '$descripcion', '1', Now(), Now())";
	$resultado = mysqli_query($link, $query);
	$lastshit=mysqli_insert_id($link);

	if ($resultado) {

		//Envío la respuesta al Front para redirigir
		$jsondata["success"] = true;
		$jsondata["data"] = array(
			'message' => "Pasaporte registrado exitosamente... "
			);


	} else {
		$jsondata["success"] = false;
		$jsondata["data"] = array(
			'message' => "Error al intentar registrar el pasaporte $query"
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

