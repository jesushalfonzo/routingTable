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
                <div class="x_title">
                  <h2>Usuarios del Sistema</h2>
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
                        <th style="width: 20%">Nombre</th>
                        <th>Grupo</th>
                        <th>Login</th>
                        <th>Correo</th>
                        <th>Status</th>
                        <th style="width: 30%">#Acciones</th>
                      </tr>
                    </thead>
                    <tbody>

                     <?php
                    $SQL="SELECT * FROM m_usuario, m_grupo WHERE m_usuario.m_grupo_id=m_grupo.m_grupo_id ORDER BY m_usuario_login ASC";
                    $query=mysqli_query($link, $SQL);
                    while ($row=mysqli_fetch_array($query)) {
                      $m_usuario_id=$row["m_usuario_id"];
                      $m_usuario_login=$row["m_usuario_login"];
                      $m_usuario_nombre=$row["m_usuario_nombre"];
                      $m_usuario_apellido=$row["m_usuario_apellido"];
                      $m_grupo_id=$row["m_grupo_id"];
                      $m_grupo_nombre=$row["m_grupo_nombre"];
                      $m_usuario_status=$row["m_usuario_status"];
                      $m_usuario_correo=$row["m_usuario_correo"];
                    if ($m_usuario_status=="A") {
                      $estatus="Activo";
                      $class="default";
                      $clase="success";
                      $text="Desactivar";
                      $nextStatus="D";
                    }
                    else{
                      $estatus="Desactivado";
                      $class="success";
                      $text="Activar";
                      $nextStatus="A";
                      $clase="default";
                    }

                     ?>
                      <tr id="User<?=$m_usuario_id?>">
                        <td>#</td>
                        <td>
                          <a><?=$m_usuario_nombre?> <?=$m_usuario_apellido?> </a>
                          <br />
                        </td>
                        <td>
                          <ul class="list-inline">
                            <li>
                            <?=$m_grupo_nombre?>
                            </li>
                           
                          </ul>
                        </td>
                        <td >
                          <?=$m_usuario_login?>
                        </td>
                         <td >
                          <?=$m_usuario_correo?>
                        </td>
                        <td>
                          <button type="button" class="btn btn-<?=$clase?> btn-xs"><?=$estatus?></button>
                        </td>
                        <td>
                          <a href="#" class="btn btn-info btn-xs editando" data-id="<?=$m_usuario_id?>"><i class="fa fa-pencil"></i> Editar </a>
                           <?php if (control_access("ADMINISTRACION", 'ELIMINAR')) { ?>
                      <button type="button" class="btn btn-danger btn-xs" data-id="<?=$m_usuario_id?>" data-accion="Eliminar" data-title="Seguro que desea Eliminar?" data-trigger="focus" data-on-confirm="deleteUser" data-toggle="confirmation" data-btn-ok-label="Sí" data-btn-cancel-label="Cancelar!" data-placement="top" title="Seguro que desea Eliminar?">  <i class="fa fa-trash-o"> </i> Eliminar</button>
                      <?php } ?>
                      <button type="button" class="btn btn-<?=$class?> btn-xs" data-id="<?=$m_usuario_id?>" data-accion="<?=$nextStatus?>" data-title="Seguro que desea <?=$text?>?" data-trigger="focus" data-on-confirm="changeStatus" data-toggle="confirmation" data-btn-ok-label="Sí" data-btn-cancel-label="Cancelar!" data-placement="top"><?=$text?></button>
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

function deleteUser(){

  var id = $(this).data('id');

  $.ajax({
    url: "deleteUser.php",
    type: 'GET',
    enctype: 'multipart/form-data',
    data: "idUser="+id,
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

  window.location.href = 'editUser.php?idUser='+idEditar;
});

//ACTIVAR/DESACTIVAR CATEGORÏAS
function changeStatus(){

  var id = $(this).data('id');
  var nextStatus= $(this).data('accion');
  $.ajax({
    url: "changeStatus.php",
    type: 'GET',
    enctype: 'multipart/form-data',
    data: "idUser="+id+"&nextStatus="+nextStatus,
    async: false,
    contentType: "application/json",
    dataType: "json",
    success: function (data) {
      if (data['success']) {
        $("#mensajes").css("z-index", "999");
        $($("#mensajes").html("<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' id='cerrar'>&times;</a><div id='dataMessage'></div></div>").fadeIn("slow"));
        $('#dataMessage').append(data['data']['message']);
        setTimeout(function() { $(".alert").alert('close'); $("#mensajes").css("z-index", "-1");}, 2000);
        setTimeout(function() { document.location.href="index.php";}, 1000);

      }
      else{
        $("#mensajes").css("z-index", "999");
        $($("#mensajes").html("<div class='alert alert-error'><a href='#' class='close' data-dismiss='alert' id='cerrar'>&times;</a><div id='dataMessage'></div></div>").fadeIn("slow"));
        $('#dataMessage').append(data['data']['message']);
        setTimeout(function() { $(".alert").alert('close'); $("#mensajes").css("z-index", "-1");}, 2000);
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
//FIN ACTIVAR/DESACTIVAR

</script>