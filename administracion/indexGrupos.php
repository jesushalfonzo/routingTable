<?php include('../logeo.php'); 
include('../extras/conexion.php');
$link=Conectarse();

if (!control_access("ADMINISTRACION", 'VER')) {  echo "<script language='JavaScript'>document.location.href='../index.php';</script>"; }

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
            <div class="col-md-12">
              <div class="x_panel">
                <div id="mensajes"></div>
                <div class="x_title">
                  <h2>Gruppos del Sistema</h2>
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


                  <!-- start project list -->
                  <table class="table table-striped projects">
                    <thead>
                      <tr>
                        <th style="width: 1%">#</th>
                        <th style="width: 20%">Nombre del Grupo</th>
                        <th>Descripción</th>
                        <th>Cantidad de usuarios</th>
                        <th style="width: 30%">#Acciones</th>
                      </tr>
                    </thead>
                    <tbody>

                     <?php
                    $SQL="SELECT * FROM m_grupo ORDER BY m_grupo_nombre ASC";
                    $query=mysqli_query($link, $SQL);
                    while ($row=mysqli_fetch_array($query)) {
                      $m_grupo_id=$row["m_grupo_id"];
                      $m_grupo_nombre=$row["m_grupo_nombre"];
                      $m_grupo_descripcion=$row["m_grupo_descripcion"];

                     ?>
                      <tr id="User<?=$m_grupo_id?>">
                        <td>#</td>
                        <td>
                          <a><?=$m_grupo_nombre?></a>
                          <br />
                        </td>
                        <td>
                          <ul class="list-inline">
                            <li>
                            <?=$m_grupo_descripcion?>
                            </li>
                           
                          </ul>
                        </td>
             
                        <td>
                          <?php
                          $SQLCantidad="SELECT m_usuario_id FROM m_usuario WHERE m_grupo_id='$m_grupo_id'";
                          $queryCantidad=mysqli_query($link, $SQLCantidad);
                          $cantidadUsuariosPorGrupo=mysqli_num_rows($queryCantidad);
                          ?>
                          <button type="button" class="btn btn-success btn-xs"><?=$cantidadUsuariosPorGrupo?></button>
                        </td>
                        <td>
                          <a href="#" class="btn btn-info btn-xs editando" data-id="<?=$m_grupo_id?>"><i class="fa fa-pencil"></i> Editar </a>
                           <?php if (control_access("ADMINISTRACION", 'ELIMINAR')) { ?>
                      <button type="button" class="btn btn-danger btn-xs" data-id="<?=$m_grupo_id?>" data-accion="Eliminar" data-title="Seguro que desea Eliminar?" data-trigger="focus" data-on-confirm="deleteGroup" data-toggle="confirmation" data-btn-ok-label="Sí" data-btn-cancel-label="Cancelar!" data-placement="top" title="Seguro que desea Eliminar?">  <i class="fa fa-trash-o"> </i> Eliminar</button>
                      <?php } ?>
                      <a href="#" class="btn btn-primary btn-xs cambiando" data-id="<?=$m_grupo_id?>"><i class="fa fa-pencil"></i> Editar Permisos </a>
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
      <!-- /page content -->

      <!-- footer content -->
      <?php include("../common_footer.php"); ?>
      <!-- /footer content -->
    </div>
  </div>

  <!--LIBRERIAS COMUNES-->
  <!-- jQuery -->
    <script src="../vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="../vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
     <!-- NProgress -->
    <script src="../vendors/nprogress/nprogress.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="../../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="../js/custom.js"></script>
    <script src="../js/bootstrap-confirmation.min.js"></script>
</body>
</html>
<script>

$('[data-toggle=confirmation]').confirmation();

function deleteGroup(){

  var id = $(this).data('id');

  $.ajax({
    url: "deleteGroup.php",
    type: 'GET',
    enctype: 'multipart/form-data',
    data: "idGrupo="+id,
    async: false,
    contentType: "application/json",
    dataType: "json",
    success: function (data) {
      if (data['success']) {
        $( "#User"+id  ).slideUp();
        $("#mensajes").css("z-index", "999");
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
    error: function(data) {
     $("#mensajes").css("z-index", "777");
     $($("#mensajes").html("<div class='alert alert-error'><a href='#' class='close' data-dismiss='alert' id='cerrar'>&times;</a><div id='dataMessage'></div></div>").fadeIn("slow"));
     $.each(data['data']['message'], function(index, val) {
      $('#dataMessage').append(val+ '<br>');
    });
     setTimeout(function() { $(".alert").alert('close'); $("#mensajes").css("z-index", "-1");}, 2000);
   },
   cache: false,
   contentType: false,
   processData: false

 });


};

$(".editando").click(function (e) {
  var idEditar=$(this).data('id');

  window.location.href = 'editGroup.php?idGrupo='+idEditar;
});

$(".cambiando").click(function (e) {
  var idEditar=$(this).data('id');

  window.location.href = 'permisos.php?idGrupo='+idEditar;
});


</script>