
<?php include('../logeo.php'); 
include('../extras/conexion.php');
$link=Conectarse();

if (!control_access("ADMINISTRACION", 'EDITAR')) {  echo "<script language='JavaScript'>document.location.href='../index.php';</script>"; }


$idGrupo=$_GET["idGrupo"];
$SQL="SELECT * FROM m_grupo WHERE m_grupo_id='$idGrupo'";
$query=mysqli_query($link, $SQL);
$row=mysqli_fetch_array($query);
$m_grupo_nombre=$row["m_grupo_nombre"];
$m_grupo_descripcion=$row["m_grupo_descripcion"];


?>
<!DOCTYPE html>
<html lang="en">
<head>
 <?php include("../common_head.php"); ?>
</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <?php include("../common_menu.php");?>
      </div>

      <!-- top navigation -->
      <?php include("../common_topNavigation.php"); ?>
      <!-- /top navigation -->

      <!-- page content -->
      <div class="right_col" role="main">
        <div class="">

          <div class="clearfix"></div>

          <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div id="mensajes"></div>
                <div class="x_title">
                  <h2>Editando Permisos para el grupo <?=$m_grupo_nombre?></h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li class="dropdown">
                      <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                      <ul class="dropdown-menu" role="menu">
                        <li><a href="#">Settings 1</a>
                        </li>
                        <li><a href="#">Settings 2</a>
                        </li>
                      </ul>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                  </ul>
                  <div class="clearfix"></div>
                </div>
                <div class="x_content">



                  <form  data-parsley-validate class="form-horizontal form-label-left"  name="forPermisos" id="forPermisos">
                    <input name="idGrupo" type="hidden" id="idGrupo"  value="<?=$idGrupo;?>"/>
                   <table id="datatable" class="table table-striped table-bordered">


                     <?php
                     $sqlaccion="SELECT * FROM m_acciones order by m_acciones_id asc";     
                     $resultaccion = mysqli_query($link, $sqlaccion);
                     $num_acciones= mysqli_num_rows($resultaccion);
                     ?>
                     <tr>
                      <td width="79" rowspan="2" bgcolor="" ><div align="center"><strong>Secciones</strong></div></td>
                      <td colspan="<?php echo $num_acciones; ?>" bgcolor="" ><div align="center"><strong>Permisos</strong></div></td>
                    </tr>
                    <tr >
                      <?php

                      while ($rowaccion = mysqli_fetch_array($resultaccion)){      
                        $m_accion_id= $rowaccion['m_acciones_id'];  
                        $m_accion_nombre= $rowaccion['m_acciones_nombre']; ?>
                        <td width="52" ><div align="center"><strong><?php echo $m_accion_nombre;?></strong></div></td>
                        <?php } ?>

                      </tr>

                      <?php $sqlseccion="SELECT * FROM m_seccion order by m_seccion_id asc";    
                      $resultseccion = mysqli_query($link, $sqlseccion);    
                      while ($rowsecc = mysqli_fetch_array($resultseccion)){     
                        $m_seccion_id= $rowsecc['m_seccion_id'];  
                        $m_seccion_nombre= $rowsecc['m_seccion_nombre']; 
                        $nom_secc_aux= explode(" ",$m_seccion_nombre); 
                        $nom_secc = $nom_secc_aux[0];
                        $nom_secc = $nom_secc;
                        ?>
                        <tr>
                          <td  ><div align="center"><?php echo $m_seccion_nombre;?></div></td>
                          <?php $sqlaccion="SELECT * FROM m_acciones order by m_acciones_id asc";     
                          $resultaccion = mysqli_query($link, $sqlaccion);
                          $num_acciones= mysqli_num_rows($resultaccion);        
                          while ($rowaccion = mysqli_fetch_array($resultaccion)){      
                            $m_accion_id= $rowaccion['m_acciones_id'];  
                            $m_accion_nombre= $rowaccion['m_acciones_nombre'];

                            $sqlSecAcc="SELECT * FROM r_seccion_accion where m_seccion_id='$m_seccion_id' and m_accion_id='$m_accion_id'"; 
                            $resultSecAcc = mysqli_query($link, $sqlSecAcc);
                            $num_accionesS= mysqli_num_rows($resultSecAcc);
                            $nom_check= $nom_secc.$m_accion_id;
                            ?>
                            <?php  //for($i=0 ; $i<=$num_acciones ; $i++){ ?>
                            <td ><div align="center">

                              <?php if($num_accionesS!=0){
                               $sqlPer="SELECT m_permiso_id, m_permiso_status FROM m_permiso 
                               where m_grupo_id='$idGrupo' and m_seccion_id='$m_seccion_id' and m_accion_id='$m_accion_id' ";      
                               $resultPer = mysqli_query($link,$sqlPer);
                               $rowPer = mysqli_fetch_array($resultPer);
                               $m_permiso_id= $rowPer['m_permiso_id'];   
                               $m_permiso_status= $rowPer['m_permiso_status'];

                               ?>

                               <input name="<?php echo $nom_check;?>" type="checkbox" id="lectura_noti" value="SI" <?php if ($m_permiso_status=="SI"){echo "checked";}?>/>
                               <?php } ?> 
                             </div></td>
                             <?php } ?>

                           </tr>
                           <tr>
                            <?php } ?>
                          </table>
                        </div>
                        <div class="ln_solid"></div>
                        <div class="form-group">
                          <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                             <button type="submit" class="btn btn-success">Guardar</button>
                            <button type="button" onClick="document.location.href='indexGrupos.php'" class="btn btn-primary">Cancelar</button>  
                           
                          </div>
                        </div>
                      </form>
                    </div>
                  </div>


                </div>
              </div>
              <!-- /page content -->

              <!-- footer content -->
              <?php include("../common_footer.php"); ?>
              <!-- /footer content -->
            </div>
          </div>
          <!--LIBRERIAS COMUNES-->
          <?php include("../common_libraries.php"); ?>

          <!-- Custom Theme Scripts -->
          <script src="js/custom.js"></script>
          <script src="../js/validate/jquery.validate.js"></script>
         <script>
    $(function() {

      $("#forPermisos").validate({

        rules: {
          idGrupo: "required",
        },

        messages: {
          idGrupo: "Debe indicar el nombre del grupo",
        },

        submitHandler: function(form) {

         var formData = new FormData($("#forPermisos")[0]);
         $.ajax({
          url: "modifyPermisos.php",
          type: 'POST',
          enctype: 'multipart/form-data',
          data: formData,
          async: false,
          contentType: "application/json",
          dataType: "json",
          success: function (data) {
           if (data['success']) {
            $("#mensajes").css("z-index", "999");
            $($("#mensajes").html("<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' id='cerrar'>&times;</a><div id='dataMessage'></div></div>").fadeIn("slow"));
            $('#dataMessage').append(data['data']['message']);
            setTimeout(function() { window.location.href = 'indexGrupos.php';}, 1000);
          } else{
            $("#mensajes").css("z-index", "999");
            $($("#mensajes").html("<div class='alert alert-error'><a href='#' class='close' data-dismiss='alert' id='cerrar'>&times;</a><div id='dataMessage'></div></div>").fadeIn("slow"));
            $.each(data['data']['message'], function(index, val) {
              $('#dataMessage').append(val+ '<br>');
            });
            setTimeout(function() { $(".alert").alert('close'); $("#mensajes").css("z-index", "-1");}, 2000);


          };

        },
        error: function(XMLHttpRequest, textStatus, errorThrown) { 
          alert("Status: " + textStatus); alert("Error: " + errorThrown); 
        } ,
        cache: false,
        contentType: false,
        processData: false
      });

}
});

});


</script>
</body>
</html>