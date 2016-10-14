<?php include('../logeo.php'); 
include('../extras/conexion.php');
$link=Conectarse();

if (!control_access("PASAPORTES", 'AGREGAR')) { $aErrores[] = "USTED NO TIENE PERSIMO PARA REALIZAR ESTA ACCION";  }


$aErrores=array();
$jsondata = array();

if((isset($_POST["idBloque"]))&&($_POST["idBloque"]!="")){ trim($idBloque=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["idBloque"])))); } else {$aErrores[] = "ERROR - No se ha indicado el identificador del bloque";}
if((isset($_POST["nameCola"]))&&($_POST["nameCola"]!="")){ trim($nameCola=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["nameCola"])))); } else {$aErrores[] = "Debe especificar el identificador de la cola";}
if((isset($_POST["paisCola"]))&&($_POST["paisCola"]!="")){ trim($paisCola=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["paisCola"])))); } else {$aErrores[] = "Debe especificar a que país corresponde la cola";}
if((isset($_POST["descripcion"]))&&($_POST["descripcion"]!="")){ trim($descripcion=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["descripcion"])))); } else {$aErrores[] = "Debe colocar una descripción de la cola que está agregando";}

if((isset($_POST["estatus"]))&&($_POST["estatus"]!="")){ trim($estatus=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["estatus"])))); } else { $estatus=0; }
if((isset($_POST["estatusOperadora"]))&&($_POST["estatusOperadora"]!="")){ trim($estatusOperadora=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["estatusOperadora"])))); } else { $estatusOperadora=0;}

if((isset($_POST["operadora"]))&&($_POST["operadora"]!="")){ $operadora=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["operadora"]))); } else { $operadora=Null;}

//GET COMMENTS REQUIERED
if((isset($_POST["estatusComment"]))&&($_POST["estatusComment"]!="")){ $estatusComment=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["estatusComment"]))); } else { $estatusComment=0;}
if((isset($_POST["keyComments"]))&&($_POST["keyComments"]!="")){ $keyComments=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["keyComments"]))); } else { $keyComments=Null;}


//GET RANGO REQUIRED
if((isset($_POST["estatusRango"]))&&($_POST["estatusRango"]!="")){ $estatusRango=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["estatusRango"]))); } else { $estatusRango=0;}


//GET CANTIDAD DE RANGOS AGREGADOS
if((isset($_POST["class_count"]))&&($_POST["class_count"]!="")){ $class_count=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["class_count"]))); } else { $class_count=0;}







$fechacompleta=date('Y-m-d H:i:s');
/*
//VALIDANDO QUE NO EXISTA EN LA BD
$SQL_val="SELECT m_pasaporte_id FROM m_pasaportes WHERE m_pasaporte_name='$namePassport'";
$queryVal=mysqli_query($link, $SQL_val);
$validado=mysqli_num_rows($queryVal);
if ($validado>0) {
	$aErrores="ESTE PASAPORTE YA SE ENCUENTRA REGISTRADO";
}
*/
if(count($aErrores)==0) { 

	/*$query = "INSERT INTO m_pasaportes (m_pasaporte_id, m_pasaporte_name, m_pasaporte_description, m_pasaporte_estatus, m_pasaporte_createdAt, m_pasaporte_updatedAt) VALUES (Null, '$namePassport', '$descripcion', '1', Now(), Now())";
	$resultado = mysqli_query($link, $query);
	$lastshit=mysqli_insert_id($link);
*/

	foreach ($_POST['pasaportesPermitidos'] as $names)
{
        $permitudos.=$names." / ";
}


	$resultado=true;
	if ($resultado) {

		//Envío la respuesta al Front para redirigir
		$jsondata["success"] = true;
		$jsondata["data"] = array(
			'message' => "$idBloque + $nameCola + $paisCola + $descripcion + $permitudos + $estatus + Requiere Operadora: $estatusOperadora + $operadora + Req comentario: $estatusComment > $keyComments + Tiene Rango: $estatusRango + Cantidad Rango: $class_count"
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

