<?php include('../logeo.php'); 
include('../extras/conexion.php');
$link=Conectarse();
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
              <h3>Routing Table</h3>
            </div>

          </div>
          <div class="clearfix"></div>
          <div class="row">
            <div class="col-md-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>Seleccione el bloque a Editar</h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a href="../bloques/index.php" class="btn btn-success btn-xs"><i class="fa fa-plus-circle" aria-hidden="true"></i> Agregar Bloque</i></a>
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
                      <th style="width: 20%">Nombre del Bloque</th>
                      <th style="width: 45%">Descripción</th>
                      <th style="width: 20%">#Acciones</th>

                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      //PARA EXTRAER LOS BLOQUES
                    $SQl_bloques="SELECT * FROM m_bloques, country_t WHERE country_id = m_bloque_paisId ORDER BY m_bloque_id ASC";         
                    $queryBloques=mysqli_query($link, $SQl_bloques);
                    while ($rowBloques=mysqli_fetch_array($queryBloques)) {
                      $m_bloque_id=$rowBloques["m_bloque_id"];
                      $m_bloque_nombre=$rowBloques["m_bloque_nombre"];
                      $m_bloque_paisId=$rowBloques["m_bloque_paisId"];
                      $m_bloque_descripcion=$rowBloques["m_bloque_descripcion"];

                      ?>
                      <tr id="Bloque<?=$m_bloque_id?>">
                        <td>#</td>
                        <td>
                          <a><?=utf8_encode($m_bloque_nombre)?></a>
                        </td>
                       <td>
                        <p><?=utf8_encode($m_bloque_descripcion)?></p>
                      </td>
                      <td>
                      <?php if (control_access("BLOQUES", 'ELIMINAR')) { ?>
                       <a href="../bloques/editBlock.php?idBlock=<?=$m_bloque_id?>" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Editar </a>
                       <?php } ?>

                       <?php if (control_access("BLOQUES", 'ELIMINAR')) { ?>
                       <button type="button" class="btn btn-danger btn-xs" data-id="<?=$m_bloque_id?>" data-accion="Eliminar" data-title="Eliminar Bloque <?=utf8_encode($m_bloque_nombre)?>?" data-trigger="focus" data-on-confirm="deleteBloque" data-toggle="confirmation" data-btn-ok-label="Sí" data-btn-cancel-label="Cancelar!" data-placement="top" title="Eliminar Bloque <?=utf8_encode($m_bloque_nombre)?>?">  <i class="fa fa-trash-o"> </i> Eliminar</button>
                       <?php } ?>
                        <?php if (control_access("COLAS", 'VER')) { ?>
                       <a href="../colas/listar.php?idBlock=<?=$m_bloque_id?>" class="btn btn-primary btn-xs"><i class="fa fa-stack-overflow "></i> Colas </a>
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

function deleteBloque(){

  var id = $(this).data('id');
  $.ajax({
    url: "../bloques/deleteBlock.php",
    type: 'GET',
    enctype: 'multipart/form-data',
    data: "idBloque="+id,
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

