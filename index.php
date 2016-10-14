<?php
session_start();
ini_set('session.gc_maxlifetime',7200);
if (isset($_SESSION["tDxEd1cionRT"])){$variable=$_SESSION["tDxEd1cionRT"];}else{$variable="";}  
if ($variable == 'tDXOp3racionesRY'){
  echo "<script language='JavaScript'>document.location.href='index2.php';</script>";
  exit();
} 
if (isset($_GET["ckl"])){$error=$_GET["ckl"]; }
if ($error!=""){ $display="block"; } else { $display="none";}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tedexis - Operaciones </title>
  <script src="js/jquery.js"></script>
  <link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
  <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
  <script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
  <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  
  <script src="js/validate/jquery.validate.js"></script>
  <!-- Custom Theme Style -->
  <link href="css/style.css" rel="stylesheet">
  <script>
  $(function() {

    $("#formAcceso").validate({

      rules: {
        userLogin: "required",
        passLogin: "required",
      },

      messages: {
        userLogin: "Debe especificar su nombre de usuario",
        passLogin: "Debe especificar la contraseña",
      },

      submitHandler: function(form) {
        var formData = new FormData($("#formAcceso")[0]);

        $.ajax({
          url: "class_login.php",
          type: 'POST',
          enctype: 'multipart/form-data',
          data: formData,
          async: false,
          contentType: "application/json",
          dataType: "json",
          success: function (data) {
           if (data['success']) {
            $($("#mensajes").html("").fadeIn("slow"));
            $("#mensajes").addClass("success");
            $('#mensajes').append(data['data']['message']);
            setTimeout(" window.location.href = 'index2.php';", 500);
          } else{
            $($("#mensajes").html("").fadeIn("slow"));
            $('#mensajes').append(data['data']['message']);
          };




        },
        error: function(data) {
          $($("#mensajes").html(data).fadeIn( "slow" ));
          $.each(data['data']['message'], function(index, val) {
            $('#mensajes').append(val+ '<br>');
          });
        },
        cache: false,
        contentType: false,
        processData: false
      });

}
});

});

</script>
<script>var __links = document.querySelectorAll('a');function __linkClick(e) { parent.window.postMessage(this.href, '*');} ;for (var i = 0, l = __links.length; i < l; i++) {if ( __links[i].getAttribute('data-t') == '_blank' ) { __links[i].addEventListener('click', __linkClick, false);}}</script>
<script>$(document).ready(function(c) {
  $('.alert-close').on('click', function(c){
    $('.message').fadeOut('slow', function(c){
      $('.message').remove();
    });
  });   
});
</script>
</head>

<body>
  <div class="message warning">
    <div class="inset">
      <div class="login-head">
      <img src="images/Tedexis.jpg" width="500" height="150">
      </div>

      <form name="formAcceso"  id="formAcceso" role="form">
        <div id="mensajes"></div>
        <li>
          <input type="text" class="text" name="userLogin" placeholder="Usuario" id="userLogin" >
        </li>
        <div class="clear"> </div>
        <li>
          <input type="password" placeholder="Password" name="passLogin" id="passLogin"> 
        </li>


        <div class="clear"> </div>
        <div class="submit">
          <input type="submit"  value="Entrar" >
          <h4><a href="#">Olvidaste tú contraseña ?</a></h4>
          <div class="clear">  </div> 
        </div>
        
      </form>
    </div>          
  </div>
</div>
<div class="clear"> </div>
</body>
</html>