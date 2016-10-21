<?php include('../logeo.php'); 
include('../extras/conexion.php');
$link=Conectarse();

//CONTROL DE PERMISOS
if (!control_access("ROUTING_TABLE", 'EDITAR')) { $aErrores[] = "USTED NO TIENE PERSIMO PARA REALIZAR ESTA ACCION";  }


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
if(count($aErrores)==0) { 


//SAVE THE PRINCIPAL VALUES FOR THE CURRENT QUEUE

	$SQL="INSERT INTO  routingDB.m_cola (m_cola_id ,m_cola_name ,m_cola_description ,m_cola_idBloque, m_cola_idPais, m_cola_requiredOperadora, m_cola_operadoraID ,m_cola_comentRequiere ,m_cola_claveComentario ,m_cola_getreplaytoRequire, m_cola_rangoRequired, m_cola_portabilidadRequired, m_cola_jaulaRequired, m_cola_estatus ,m_cola_date ,
	m_cola_updatedat)VALUES (NULL ,  '$nameCola',  '$descripcion',  '$idBloque', '$paisCola', '$estatusOperadora',  '$operadora',  '$estatusComment',  '$keyComments',  '$estatusReplyTo', '$estatusRango', '$estatusPortabilidad', '$estatusFiltrado',  '$estatus',  Now(),  Now())";
	$resultado=mysqli_query($link, $SQL);
	$lastId=mysqli_insert_id($link);



//PARA GUARDAR LOS PASAPORTES QUE PERMITE ESTA COLA
	$pasaportesCant=count($_POST["pasaportesPermitidos"]);

	if ($pasaportesCant>0) {
		foreach ($_POST['pasaportesPermitidos'] as $idPass)
		{
			$SQLPass="INSERT INTO r_colas_pasaportes (r_cola_pasaporte_id, r_cola_pasaporte_idCola, r_cola_pasaporte_idPasaporte, r_cola_pasaporte_creartedAt) VALUES (Null, '$lastId', '$idPass', Now())";
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
				$SQLRangos="INSERT INTO r_rangos_colas (r_rangos_cola_id, r_rangos_cola_idCola, r_rangos_cola_rangoDesde, r_rangos_cola_rangoHasta) VALUES (Null, '$lastId', '$desde', '$hasta')";
				$querRangos=mysqli_query($link, $SQLRangos);
			}
		}
	}

//FIN GUARDADO DE RANGOS


//PARA GUARDAR PORTABILIDAD

	if ($estatusPortabilidad) {
		if (($numerosPortados!="") || (count($_POST["pasaportesPortados"])>0)) {
			
			if ($numerosPortados!="") {
				$pieces = explode(",", $numerosPortados);

				foreach($pieces as $element)
				{
					$SQLNumerosPortados="INSERT INTO r_colas_portados (r_cola_portado_id, r_cola_portado_idCola, r_cola_portado_numOrPass, r_colas_portados_type, r_cola_portado_createdat) VALUES (Null, '$lastId', '$element', 'NUM', Now())";
					$querNumPort=mysqli_query($link, $SQLNumerosPortados);
				}
			} 
			if(count($_POST["pasaportesPortados"])>0) {
				foreach ($_POST['pasaportesPortados'] as $idPass)
				{
					$SQLPassPortado="INSERT INTO r_colas_portados (r_cola_portado_id, r_cola_portado_idCola, r_cola_portado_numOrPass, r_colas_portados_type, r_cola_portado_createdat) VALUES (Null, '$lastId', '$idPass', 'PASS', Now())";
					$queryPassPortado=mysqli_query($link, $SQLPassPortado);
				}
			}

		}
	}

//FIN DE LA PORTABILIDAD




//PARA PROCESAR LOS NUMEROS FILTRADOS
	if ($estatusFiltrado) {
		if (($numerosFiltrados!="") || (count($_POST["pasaportesFiltrados"])>0) || ($iniciosFiltrados!=""))  {
			
			if ($numerosFiltrados!="") {
				$pieces = explode(",", $numerosFiltrados);

				foreach($pieces as $element)
				{
					$SQLNumerosFiltrados="INSERT INTO r_colas_filtados (r_cola_filtrado_id, r_cola_filtrado_idCola, r_cola_filtrado_valor, r_cola_filtrado_tipo, r_cola_filtrado_createdAt) VALUES (Null, '$lastId', '$element', 'COM', Now())";
					$querNumFilt=mysqli_query($link, $SQLNumerosFiltrados);
				}
			} 
			if ($iniciosFiltrados!="") {
				$pieces = explode(",", $iniciosFiltrados);

				foreach($pieces as $element)
				{
					$SQLIniciosFiltrados="INSERT INTO r_colas_filtados (r_cola_filtrado_id, r_cola_filtrado_idCola, r_cola_filtrado_valor, r_cola_filtrado_tipo, r_cola_filtrado_createdAt) VALUES (Null, '$lastId', '$element', 'INI', Now())";
					$querIniFilt=mysqli_query($link, $SQLIniciosFiltrados);
				}
			} 
			if(count($_POST["pasaportesFiltrados"])>0) {
				foreach ($_POST['pasaportesFiltrados'] as $idPass)
				{
					$SQLPassFiltrados="INSERT INTO r_colas_filtados (r_cola_filtrado_id, r_cola_filtrado_idCola, r_cola_filtrado_valor, r_cola_filtrado_tipo, r_cola_filtrado_createdAt) VALUES (Null, '$lastId', '$idPass', 'PAS', Now())";
					$queryPassFiltrado=mysqli_query($link, $SQLPassFiltrados);
				}
			}

		}
	}
//FIN NUMEROS FILTRADOS




	if ($resultado) {


		//Envío la respuesta al Front para redirigir

		$jsondata["success"] = true;
		$jsondata["data"] = array(
			'message' => "La cola ha sido registrada satisfactoriamente"
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

