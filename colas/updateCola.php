<?php include('../logeo.php'); 
include('../extras/conexion.php');
$link=Conectarse();

//CONTROL DE PERMISOS
if (!control_access("ROUTING_TABLE", 'EDITAR')) { $aErrores[] = "USTED NO TIENE PERSIMO PARA REALIZAR ESTA ACCION";  }


$aErrores=array();
$jsondata = array();

if((isset($_POST["nameCola"]))&&($_POST["nameCola"]!="")){ trim($nameCola=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["nameCola"])))); } else {$aErrores[] = "Debe especificar el identificador de la cola";}
if((isset($_POST["paisCola"]))&&($_POST["paisCola"]!="")){ trim($paisCola=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["paisCola"])))); } else {$aErrores[] = "Debe especificar a que país corresponde la cola";}
if((isset($_POST["descripcion"]))&&($_POST["descripcion"]!="")){ trim($descripcion=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["descripcion"])))); } else {$aErrores[] = "Debe colocar una descripción de la cola que está agregando";}
if((isset($_POST["idQueue"]))&&($_POST["idQueue"]!="")){ trim($idQueue=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["idQueue"])))); } else {$aErrores[] = "ERROR - NO SE HA INDICADO LA COLA QUE DESEA ACTUALIZAR";}
if((isset($_POST["updatePassPermitidos"]))&&($_POST["updatePassPermitidos"]!="")){ trim($updatePassPermitidos=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["updatePassPermitidos"])))); } else {$updatePassPermitidos=0;}
if((isset($_POST["estatus"]))&&($_POST["estatus"]!="")){ trim($estatus=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["estatus"])))); } else { $estatus=0; }

//GET OPERATOR REQUIRED
if((isset($_POST["estatusOperadora"]))&&($_POST["estatusOperadora"]!="")){ $estatusOperadora=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["estatusOperadora"]))); } else { $estatusOperadora=0;}

if((isset($_POST["operadora"]))&&($_POST["operadora"]!="")){ $operadora=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["operadora"]))); } else { $operadora=Null;}

//GETREPLYTO REQUIERES
if((isset($_POST["estatusReplyTo"]))&&($_POST["estatusReplyTo"]!="")){ trim($estatusReplyTo=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["estatusReplyTo"])))); } else { $estatusReplyTo=0;}


//GET COMMENTS REQUIERED
if((isset($_POST["estatusComment"]))&&($_POST["estatusComment"]!="")){ $estatusComment=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["estatusComment"]))); } else { $estatusComment=0;}
if((isset($_POST["keyComments"]))&&($_POST["keyComments"]!="")){ $keyComments=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["keyComments"]))); } else { $keyComments=Null;}


//GET RANGO REQUIRED
if((isset($_POST["estatusRango"]))&&($_POST["estatusRango"]!="")){ $estatusRango=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["estatusRango"]))); } else { $estatusRango=0;}


//GET CANTIDAD DE RANGOS AGREGADOS
if((isset($_POST["class_count"]))&&($_POST["class_count"]!="")){ $class_count=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["class_count"]))); } else { $class_count=0;}



//GET PORTABILITY CHECK
if((isset($_POST["estatusPortabilidad"]))&&($_POST["estatusPortabilidad"]!="")){ $estatusPortabilidad=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["estatusPortabilidad"]))); } else { $estatusPortabilidad=0;}

	//GET NUMEROS PORTADOS

if((isset($_POST["numerosPortados"]))&&($_POST["numerosPortados"]!="")){ $numerosPortados=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["numerosPortados"]))); } else { $numerosPortados=0;}

	//GET NUMEROS FILTRADOS CHECK
if((isset($_POST["estatusFiltrado"]))&&($_POST["estatusFiltrado"]!="")){ $estatusFiltrado=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["estatusFiltrado"]))); } else { $estatusFiltrado=0;}
//GET NUMEROS FILTRADOS
if((isset($_POST["numerosFiltrados"]))&&($_POST["numerosFiltrados"]!="")){ $numerosFiltrados=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["numerosFiltrados"]))); } else { $numerosFiltrados=0;}

//GET INICIO FILTRADO

if((isset($_POST["iniciosFiltrados"]))&&($_POST["iniciosFiltrados"]!="")){ $iniciosFiltrados=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["iniciosFiltrados"]))); } else { $iniciosFiltrados=0;}

$fechacompleta=date('Y-m-d H:i:s');
$resultado=true;
if(count($aErrores)==0) { 


//UPDATE A LA CLAVE MASTER

	$SQLUpdate="UPDATE m_cola SET m_cola_name='$nameCola', m_cola_description='$descripcion', m_cola_idPais='$paisCola', m_cola_requiredOperadora='$estatusOperadora', m_cola_operadoraID='$operadora', m_cola_comentRequiere='$estatusComment', m_cola_claveComentario='$keyComments', m_cola_getreplaytoRequire='$estatusReplyTo', m_cola_rangoRequired='$estatusRango', m_cola_portabilidadRequired='$estatusPortabilidad', m_cola_jaulaRequired='$estatusFiltrado', m_cola_estatus='$estatus', m_cola_updatedat=Now() WHERE m_cola_id='$idQueue'";
	$updateCola=mysqli_query($link, $SQLUpdate);


	//SI SE DES-SELECCIONA LA OPCIÓN DE FILTRADO (JAULA), BORRO DE LA TABLA r_colas_filtados TODOS LOS REGISTROS PARA QUE NO QUEDE BASURA
	$sqlDeleteRangos="DELETE FROM r_rangos_colas WHERE r_rangos_cola_idCola='$idQueue'";
	$queryDeletePortados=mysqli_query($link, $sqlDeleteRangos);
	//FIN BORRAR JAULA

	//SI SE ELIMINA (DES-SELECCIONA) LA OPCIÓN DE PORTABILIDAD, BORRO DE LA TABLA r_colas_portados TODOS LOS REGISTROS PARA QUE NO QUEDE BASURA
	$sqlDeletePortados="DELETE FROM r_colas_portados WHERE r_cola_portado_idCola='$idQueue'";
	$queryDeletePortados=mysqli_query($link, $sqlDeletePortados);
	//FIN BORRAR PORTADOS

	//SI SE DES-SELECCIONA LA OPCIÓN DE FILTRADO (JAULA), BORRO DE LA TABLA r_colas_filtados TODOS LOS REGISTROS PARA QUE NO QUEDE BASURA
	$sqlDeleteJaula="DELETE FROM r_colas_filtados WHERE r_cola_filtrado_idCola='$idQueue'";
	$queryDeleteJaula=mysqli_query($link, $sqlDeleteJaula);
	//FIN BORRAR JAULA


	//PARA GUARDAR LOS PASAPORTES QUE PERMITE ESTA COLA
	if ($updatePassPermitidos) {
		$pasaportesCant=count($_POST["pasaportesPermitidos"]);

		if ($pasaportesCant>0) {
			foreach ($_POST['pasaportesPermitidos'] as $idPass)
			{
				$ids.=$idPass.",";
			}


			$ids=substr($ids, 0,-1);
			$SQLBorrarPass="DELETE FROM r_colas_pasaportes WHERE r_cola_pasaporte_idCola='$idQueue' AND r_cola_pasaporte_idPasaporte NOT IN ($ids)";
			$queryPassDel=mysqli_query($link, $SQLBorrarPass);

			foreach ($_POST['pasaportesPermitidos'] as $idPass)
			{
				$SQLPass="INSERT IGNORE INTO r_colas_pasaportes (r_cola_pasaporte_id, r_cola_pasaporte_idCola, r_cola_pasaporte_idPasaporte, r_cola_pasaporte_creartedAt) VALUES (Null, '$idQueue', '$idPass', Now())";
				$queryPass=mysqli_query($link, $SQLPass);
			}

		}
//FIN PASAPORTE COLA



//PARA GUARDAR LOS RANGOS EN CASO DE QUE LA COLA LOS REQUIERA

	if ($estatusRango) {
	//GET RANGOS
		if ((!empty($_POST["desdeRango"]) && is_array($_POST["desdeRango"]))AND !empty($_POST["hastaRango"]) && is_array($_POST["hastaRango"]) ) { 
			foreach (array_combine($_POST["desdeRango"], $_POST["hastaRango"]) as $desde => $hasta) {
		//SAVE RANGOS
				$SQLRangos="INSERT INTO r_rangos_colas (r_rangos_cola_id, r_rangos_cola_idCola, r_rangos_cola_rangoDesde, r_rangos_cola_rangoHasta) VALUES (Null, '$idQueue', '$desde', '$hasta')";
				$querRangos=mysqli_query($link, $SQLRangos);
			}
		}
	}

//FIN GUARDADO DE RANGOS

	}
	if ($resultado) {


		//Envío la respuesta al Front para redirigir

		$jsondata["success"] = true;
		$jsondata["data"] = array(
			'message' => "$class_count"
			);


	} else {
		$jsondata["success"] = false;
		$jsondata["data"] = array(
			'message' => "$updatePassPermitidos"
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

