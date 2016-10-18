<?php include('../logeo.php'); 
include('../extras/conexion.php');
$link=Conectarse();
?>
<?php
 //PARA EXTRAER LOS DATOS DEL BLOQUE
if((isset($_GET["idBlock"]))&&($_GET["idBlock"]!="")){ $idBlock=strip_tags(htmlentities(mysqli_real_escape_string($link, $_GET["idBlock"]))); } else {$idBlock=0;}

$SQl_bloques="SELECT m_bloque_nombre FROM m_bloques WHERE m_bloque_id='$idBlock'";         
$queryBloques=mysqli_query($link, $SQl_bloques);
$rowBloques=mysqli_fetch_array($queryBloques);
$m_bloque_nombre=$rowBloques["m_bloque_nombre"];
  ?>
  <!DOCTYPE html>
  <html lang="en">
  <head>
    <?php include("../common_head.php"); ?>

    <!-- Switchery -->
    <link href="../vendors/switchery/dist/switchery.min.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
    <!-- Select2 -->
    <link href="../vendors/select2/dist/css/select2.min.css" rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="../css/custom.css" rel="stylesheet">
    <!-- bootstrap-wysiwyg -->
    <link href="../css/bootstrap-select.min.css" rel="stylesheet">
    <link href="../css/fileinput.css" rel="stylesheet">
    <link rel="stylesheet" href="../fonts/gi/genericons.css">
    <link rel="stylesheet" href="../css/icon-picker.min.css">


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

            <div class="page-title">
              <div class="title_left">
                <h3>Colas del Bloque <?=utf8_encode($m_bloque_nombre)?></h3>
              </div>

            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Listado de colas <i class="fa fa-stack-overflow "></i></h2>
                    <ul class="nav navbar-right panel_toolbox">


                    <li><a  class="btn btn-primary btn-xs" href="../routing/index.php"><i class="fa fa-arrow-circle-left" aria-hidden="true"></i> Volver</a></li>

                      <li><a href="../colas/index.php?idBlock=<?=$idBlock?>" class="btn btn-success btn-xs"><i class="fa fa-plus-circle" aria-hidden="true"></i> Agregar Cola</i></a>
                      </li>

                    </ul>
                    <div class="clearfix"></div>
                  </div>

                  <div id="mensajes">

                  </div>
                  <div class="x_content">
                    <!-- start project list -->
                    <table class="table table-striped projects">
                     <thead>
                      <tr>
                        <th style="width: 1%">#</th>
                        <th style="width: 20%">Nombre de la cola</th>
                        <th style="width: 45%">Descripción</th>
                        <th style="width: 20%">#Acciones</th>

                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      //PARA EXTRAER LOS BLOQUES
                      $SQl_queues="SELECT * FROM m_cola WHERE m_cola_idBloque = '$idBlock' ORDER BY m_cola_date ASC";         
                      $queryQueues=mysqli_query($link, $SQl_queues);
                      while ($rowQueues=mysqli_fetch_array($queryQueues)) {
                        $m_cola_id=$rowQueues["m_cola_id"];
                        $m_cola_name=$rowQueues["m_cola_name"];
                        $m_cola_descrption=$rowQueues["m_cola_descrption"];
                        ?>
                        <tr id="Queue<?=$m_cola_id?>">
                          <td>#</td>
                          <td>
                            <a><?=utf8_encode($m_cola_name)?></a>
                          </td>
                          <td>
                            <p><?=utf8_encode($m_cola_descrption)?></p>
                          </td>
                          <td>
                            <?php if (control_access("COLAS", 'EDITAR')) { ?>
                            <a href="../bloques/editBlock.php?idBlock=<?=$m_bloque_id?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Editar </a>
                            <?php } ?>

                            <?php if (control_access("COLAS", 'ELIMINAR')) { ?>
                            <button type="button" class="btn btn-danger btn-xs" data-id="<?=$m_cola_id?>" data-accion="Eliminar" data-title="Eliminar Cola <?=utf8_encode($m_cola_name)?>?" data-trigger="focus" data-on-confirm="deleteCola" data-toggle="confirmation" data-btn-ok-label="Sí" data-btn-cancel-label="Cancelar!" data-placement="top" title="Eliminar Cola <?=utf8_encode($m_cola_name)?>?">  <i class="fa fa-trash-o"> </i> Eliminar</button>
                            <?php } ?>
                   

                          </td>
                        </tr>

                        <?php } ?>
                      </tbody>
                    </table>
                    <!-- end project list -->

                  </div>
                </div>
              </div>
            </div>
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

<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap -->

<script type="text/javascript" src="../js/icon-picker.min.js"></script>

<!--UPLOAD FILES Lib-->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- iCheck -->
<script src="../vendors/iCheck/icheck.min.js"></script>


<!-- Switchery -->
<script src="../vendors/switchery/dist/switchery.min.js"></script>



<!-- starrr -->
<script src="../js/validate/jquery.validate.js"></script>
<!-- Custom Theme Scripts -->
<script src="../js/custom.js"></script>



<script src="../js/bootstrap-select.min.js"></script>
<script src="../js/bootstrap-confirmation.min.js"></script>

<script>

  $('[data-toggle=confirmation]').confirmation();

  function deleteCola(){

    var id = $(this).data('id');
    $.ajax({
      url: "deleteCola.php",
      type: 'GET',
      enctype: 'multipart/form-data',
      data: "idCola="+id,
      async: false,
      contentType: "application/json",
      dataType: "json",
      success: function (data) {
        if (data['success']) {
          $("#mensajes").css("z-index", "999");
          $( "#Bloque"+id  ).slideUp();
          $($("#mensajes").html("<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' id='cerrar'>&times;</a><div id='dataMessage'></div></div>").fadeIn("slow"));
          $('#dataMessage').append(data['data']['message']);
          setTimeout(function() { $(".alert").alert('close'); $("#mensajes").css("z-index", "-1");}, 2000);

        }
        else{
          $("#mensajes").css("z-index", "999");
          $($("#mensajes").html("<div class='alert alert-error'><a href='#' class='close' data-dismiss='alert' id='cerrar'>&times;</a><div id='dataMessage'></div></div>").fadeIn("slow"));

          $("#dataMessage").append(data["data"]["message"]);
          $.each(data['data']['message'], function(index, val) {
            $('#dataMessage').append(val+ '<br>');
          });
          setTimeout(function() { $(".alert").alert('close'); $("#mensajes").css("z-index", "-1");}, 4000);
        }
      },
      error: function(XMLHttpRequest, textStatus, errorThrown) { 
        alert("Status: " + textStatus); alert("Error: " + errorThrown); 
      } ,
      cache: false,
      contentType: false,
      processData: false

    });


  };


</script>


</body>
</html>

