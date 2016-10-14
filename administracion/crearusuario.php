<?php include('../logeo.php'); 
include('../extras/conexion.php');
$link=Conectarse();


if (!control_access("ADMINISTRACION", 'AGREGAR')) {  echo "<script language='JavaScript'>document.location.href='../index.php';</script>"; }


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
                <h2>Creación de Usuarios de CMS</h2>
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
                <br />
                <form  data-parsley-validate class="form-horizontal form-label-left"  name="createUser" id="createUser">

                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="usuarioNombre">Nombre <span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="usuarioNombre" name="usuarioNombre" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="apellido">Apellido<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="apellido" name="apellido" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="loginUser">Login<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="loginUser" name="login" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="mail">Correo<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="text" id="mail" name="mail" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Password<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="password" id="password" name="password" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="repitepassword">Repite Password<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                      <input type="password" id="repitepassword" name="repitepassword" required="required" class="form-control col-md-7 col-xs-12">
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="grupouser">Grupo<span class="required">*</span>
                    </label>
                    <div class="col-md-6 col-sm-6 col-xs-12">
                     <select name="grupouser" class="select2_single cliente form-control has-feedback-right" tabindex="-1">
                      <option></option>
                      <?php
                      $SQLGrupos="SELECT * FROM m_grupo WHERE m_grupo_status  ='A'  ORDER BY m_grupo_nombre ASC";
                      $queryGrupos=mysqli_query($link, $SQLGrupos);
                      while ($rowGrupos=mysqli_fetch_array($queryGrupos)) {
                        $m_grupo_id=$rowGrupos["m_grupo_id"];
                        $m_grupo_nombre=$rowGrupos["m_grupo_nombre"];

                        ?>
                        <option value="<?=$m_grupo_id?>"><?=$m_grupo_nombre?></option>

                        <?php } ?>


                      </select>
                    </div>
                  </div>

                  <div class="ln_solid"></div>
                  <div class="form-group">
                    <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                      <button type="button" onClick="document.location.href='../index2.php'" class="btn btn-primary">Cancelar</button>  
                      <button type="submit" class="btn btn-success">Guardar</button>
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


    <script src="../js/validate/jquery.validate.js"></script>
    

    <script>
    $(function() {

      $("#createUser").validate({

        rules: {
          usuarioNombre: "required",
          apellido: "required",
          login: "required",
          mail: {
            required: true,
            email: true
          },
          password: "required",
          repitepassword: "required",
          grupouser: "required",
        },

        messages: {
          usuarioNombre: "Debe indicar el nombre del usuario",
          apellido: "Debe especificar el apellido del usuario",
          login: "Debe especificar el login del usuario",
          password: "Debe asignar una clave",
          password: "Debe asignar una clave",
          mail: "Debe asignar un correo",
          repitepassword: "Debe repetir la clave",
          grupouser: "Debe Seleccionar un grupo para el usuario",
        },

        submitHandler: function(form) {

         var formData = new FormData($("#createUser")[0]);


         $.ajax({
          url: "addUser.php",
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
            setTimeout(function() { window.location.href = 'index.php';}, 1000);
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