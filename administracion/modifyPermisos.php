<?php include('../logeo.php'); 
include('../extras/conexion.php');
$link=Conectarse();


if (!control_access("ADMINISTRACION", 'EDITAR')) { $aErrores[] = "USTED NO TIENE PERSIMO PARA REALIZAR ESTA ACCION";  }
$id_grupo=$_POST["idGrupo"];

header('Content-type: application/json; charset=utf-8');
$aErrores=array();
$jsondata = array();


if(count($aErrores)==0) { 


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
				if ($Permiso_accion!="SI"){$Permiso_accion="NO";}
				$update="UPDATE m_permiso set m_permiso_status='$Permiso_accion'
				where m_grupo_id='$id_grupo'and m_seccion_id='$m_seccion_id' and m_accion_id='$m_accion_id'";  
				$resultado=mysqli_query($link, $update);
			}

		}
	}



	if ($resultado) {

		$jsondata["success"] = true;
		$jsondata["data"] = array(
			'message' => "Los permisos del grupo ha sido actualizados "
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