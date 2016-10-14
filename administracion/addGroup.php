<?php include('../logeo.php'); 
include('../extras/conexion.php');
$link=Conectarse();


if (!control_access("ADMINISTRACION", 'AGREGAR')) { $aErrores[] = "USTED NO TIENE PERSIMO PARA REALIZAR ESTA ACCION";  }


header('Content-type: application/json; charset=utf-8');
$aErrores=array();
$jsondata = array();

if((isset($_POST["grupoNombre"]))&&($_POST["grupoNombre"]!="")){ $grupoNombre=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["grupoNombre"]))); } else {$aErrores[] = "Debe especificar le nombre del grupo";}
if((isset($_POST["descripconGrupo"]))&&($_POST["descripconGrupo"]!="")){ $descripconGrupo=strip_tags(htmlentities(mysqli_real_escape_string($link, $_POST["descripconGrupo"]))); } else {$aErrores[] = "Debe agregar una descripción del grupo";}


if(count($aErrores)==0) { 

	$query = "INSERT INTO m_grupo (m_grupo_id, m_grupo_nombre, m_grupo_descripcion, m_grupo_status) VALUES (Null, '$grupoNombre', '$descripconGrupo', 'A')";
	$resultado = mysqli_query($link, $query);
	$lastId=mysqli_insert_id($link);


	$sqlseccion="SELECT * FROM m_seccion order by m_seccion_nombre asc";		 
	$resultseccion = mysqli_query($link, $sqlseccion);	  
	while ($rowsecc = mysqli_fetch_array($resultseccion)){	  	
		$m_seccion_id= $rowsecc['m_seccion_id']; 	
		$m_seccion_nombre= $rowsecc['m_seccion_nombre']; 
		$nom_secc_aux= explode(" ",$m_seccion_nombre); 
		$nom_secc = $nom_secc_aux[0];


		$sqlaccion="SELECT * FROM m_acciones order by m_acciones_id asc";		 
		$resultaccion = mysqli_query($link, $sqlaccion);
		$num_acciones= mysqli_num_rows($resultaccion);				 
		while ($rowaccion = mysqli_fetch_array($resultaccion)){	  	
			$m_accion_id= $rowaccion['m_acciones_id']; 	
			$m_accion_nombre= $rowaccion['m_acciones_nombre'];

			$sqlSecAcc="SELECT * FROM r_seccion_accion where m_seccion_id='$m_seccion_id' and m_accion_id='$m_accion_id'";

			$resultSecAcc = mysqli_query($link, $sqlSecAcc);
			$num_accionesS= mysqli_num_rows($resultSecAcc);
			if($num_accionesS!=0){
				$nom_check= $nom_secc.$m_accion_id;
					  //echo $nom_check;
				$Permiso_accion=$_POST["$nom_check"];
				$update="INSERT INTO m_permiso (m_permiso_id, m_grupo_id, m_seccion_id, m_accion_id, m_permiso_status) VALUES (Null, '$lastId', '$m_seccion_id', '$m_accion_id', 'NO')";
				$resultado=mysqli_query($link, $update);
			}

		}
	}






	if ($resultado) {

		$jsondata["success"] = true;
		$jsondata["data"] = array(
			'message' => "El grupo ha sido creado correctamente"
			);


	} else {
		$jsondata["success"] = false;
		$jsondata["data"] = array(
			'message' => "ERROR - Ocurrió un error al intentar crear el grupo"
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