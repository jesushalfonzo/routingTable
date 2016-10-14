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

//GET OPERATOR REQUIRED
if((isset($_POST["estatusOperadora"]))&&($_POST["estatusOperadora"]!="")){ $estatusOperadora=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["estatusOperadora"]))); } else { $estatusOperadora=0;}

//GETREPLYTO REQUIERES
if((isset($_POST["estatusReplyTo"]))&&($_POST["estatusReplyTo"]!="")){ trim($estatusReplyTo=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["estatusReplyTo"])))); } else { $estatusReplyTo=0;}

if((isset($_POST["operadora"]))&&($_POST["operadora"]!="")){ $operadora=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["operadora"]))); } else { $operadora=Null;}

//GET COMMENTS REQUIERED
if((isset($_POST["estatusComment"]))&&($_POST["estatusComment"]!="")){ $estatusComment=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["estatusComment"]))); } else { $estatusComment=0;}
if((isset($_POST["keyComments"]))&&($_POST["keyComments"]!="")){ $keyComments=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["keyComments"]))); } else { $keyComments=Null;}


//GET RANGO REQUIRED
if((isset($_POST["estatusRango"]))&&($_POST["estatusRango"]!="")){ $estatusRango=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["estatusRango"]))); } else { $estatusRango=0;}


//GET CANTIDAD DE RANGOS AGREGADOS
if((isset($_POST["class_count"]))&&($_POST["class_count"]!="")){ $class_count=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["class_count"]))); } else { $class_count=0;}



if ( !empty($_POST["desdeRango"]) && is_array($_POST["desdeRango"]) ) { 
	foreach ( $_POST["desdeRango"] as $como ) { 
		$var.=":".$como; 
	}
}

if ( !empty($_POST["hastaRango"]) && is_array($_POST["hastaRango"]) ) { 
	foreach ( $_POST["hastaRango"] as $comoH ) { 
		$varH.=":".$comoH; 
	}
}


//GET PORTABILITY CHECK
if((isset($_POST["estatusPortabilidad"]))&&($_POST["estatusPortabilidad"]!="")){ $estatusPortabilidad=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["estatusPortabilidad"]))); } else { $estatusPortabilidad=0;}



	//GET NUMEROS PORTADOS

if((isset($_POST["numerosPortados"]))&&($_POST["numerosPortados"]!="")){ $numerosPortados=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["numerosPortados"]))); } else { $numerosPortados=0;}


$fechacompleta=date('Y-m-d H:i:s');
if(count($aErrores)==0) { 




	$SQL="INSERT INTO  routingDB.m_cola (m_cola_id ,m_cola_name ,m_cola_description ,m_cola_idBloque, m_cola_requiredOperadora, m_cola_operadoraID ,m_cola_comentRequiere ,m_cola_claveComentario ,m_cola_getreplaytoRequire ,m_cola_estatus ,m_cola_date ,
	m_cola_updatedat)VALUES (NULL ,  '$nameCola',  '$descripcion',  '$idBloque',  '$estatusOperadora',  '$operadora',  '$estatusComment',  '$keyComments',  '$estatusReplyTo',  '$estatus',  Now(),  Now())";
	$resultado=mysqli_query($link, $SQL);
	$lastId=mysqli_insert_id($link);

	$pasaportesCant=count($_POST["pasaportesPermitidos"]);

	if ($pasaportesCant>0) {
		foreach ($_POST['pasaportesPermitidos'] as $idPass)
		{
			$SQLPass="INSERT INTO r_colas_pasaportes (r_cola_pasaporte_id, r_cola_pasaporte_idCola, r_cola_pasaporte_idPasaporte, r_cola_pasaporte_creartedAt) VALUES (Null, '$lastId', '$idPass', Now())";
			$queryPass=mysqli_query($link, $SQLPass);
		}
	}


	if ($resultado) {


		//Envío la respuesta al Front para redirigir
		$jsondata["success"] = true;
		$jsondata["data"] = array(
			'message' => "$SQLPass"
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

