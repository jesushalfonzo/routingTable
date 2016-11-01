<?php include('../logeo.php'); 
include('../extras/conexion.php');
$link=Conectarse();
if((isset($_GET["idBlock"]))&&($_GET["idBlock"]!="")){ $idBlock=strip_tags(mysqli_real_escape_string($link, $_GET["idBlock"])); } else {$idBlock=0;}

$SQl_bloques="SELECT m_bloque_nombre FROM m_bloques WHERE m_bloque_id='$idBlock'";         
$queryBloques=mysqli_query($link, $SQl_bloques);
$rowBloques=mysqli_fetch_array($queryBloques);
$m_bloque_nombre=$rowBloques["m_bloque_nombre"];

//PARA UTILIZAR LA LISTA DE PASAPORTES VARIAS VECES, CREO UN ARRAY BIDIMENSIONAL CON LOS MISMOS
$pasaportes=array();
$SQL_pasaportes="SELECT * FROM m_pasaportes WHERE m_pasaporte_estatus='1' ORDER BY m_pasaporte_name ASC";
$query_pasaportes=mysqli_query($link, $SQL_pasaportes);
while ($row_pasaportes=mysqli_fetch_array($query_pasaportes)) {
  $m_pasaporte_id=$row_pasaportes["m_pasaporte_id"];
  $m_pasaporte_name=$row_pasaportes["m_pasaporte_name"];
  $pasaportes[$m_pasaporte_name]=$m_pasaporte_id;

}



?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php include("../common_head.php"); ?>

  <!-- Switchery -->
  <link href="../vendors/switchery/dist/switchery.min.css" rel="stylesheet">
  <!-- iCheck -->
  <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
  <link href="../css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src="../js/fileinput.js" type="text/javascript"></script>
  <!-- Select2 -->
  <link href="../vendors/select2/dist/css/select2.min.css" rel="stylesheet">
  <style type="text/css">
    #pasaportesPortadosDiv >span{
      width: 100% !important;
      margin-bottom: 20px !important;
    }
  </style>
</head>


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
              <h3>Agregar Cola </h3>
            </div>
            
          </div>
          <div class="clearfix"></div>

          <form class="form-horizontal form-label-left" id="formCola" name="formCola" enctype="multipart/form-data" >
            <div class="row">
              <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Cola correspondiente al bloque <?=utf8_encode($m_bloque_nombre)?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>

                    </ul>
                    <div class="clearfix"></div>
                  </div>

                  <div id="mensajes">

                  </div>
                  <div class="x_content">

                    <input type="hidden" name="idBloque" value="<?=$idBlock?>">
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                      <label>Identificador de la cola</label>
                      <span class="fa fa-tasks form-control-feedback left" aria-hidden="true"></span>
                      <input type="text" name="nameCola" class="form-control has-feedback-left" id="nameCola" placeholder="Nombre de la cola">
                      
                    </div>


                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                      <label>País</label>
                      <select name="paisCola" class="form-control">
                        <option>Seleccione</option>
                        <?php 
                        $SqlCountry="SELECT short_name, country_id FROM country_t ORDER BY short_name ASC";
                        $queryCountry=mysqli_query($link, $SqlCountry);
                        while ($rowCountry=mysqli_fetch_array($queryCountry)) {
                         $short_name=$rowCountry["short_name"];
                         $country_id=$rowCountry["country_id"];

                         ?>
                         <option value="<?=$country_id?>"><?=$short_name?></option>
                         <?php } ?>
                       </select>

                     </div>

                     <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                       <span class="fa fa-file-text-o form-control-feedback right" aria-hidden="true"></span>
                       <textarea class="resizable_textarea form-control" name="descripcion" id="descripcion" placeholder="Descripción de la cola (Si aplíca)" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 74px;"></textarea>                
                     </div>


                     <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" style="text-align: left;">Seleccione los pasaportes permitidos</label>
                      <div class="col-md-12 col-sm-12 col-xs-12">
                        <select name="pasaportesPermitidos[]" class="select2_multiple form-control" multiple="multiple" id="pasaportesPermitidos">

                          <?php 
                          foreach ($pasaportes as $nombrePasaporte => $idPasaporte) {


                            ?>
                            <option value="<?=$idPasaporte?>"><?=$nombrePasaporte?></option>
                            <?php } ?>
                          </select>
                        </div>
                      </div>
                    </div>


                    <div class="form-group">
                      <div class="col-md-3 col-sm-3 col-xs-12">
                        <label for="message">Estatus de la cola :</label>
                        <div class="radio" id="EstatusRadio">

                         <input type="checkbox" class="js-switch" id="estatus" name="estatus" value="1"/>  
                         <label id="estatusText" for="estatus">Inactiva</label>
                       </div>
                     </div>

                     <div class="col-md-3 col-sm-3 col-xs-12">
                      <label for="message"> ¿Requiere Respuesta Nula?</label>
                      <div class="radio" id="ReplyToRadio">

                       <input type="checkbox" class="js-switch" id="estatusReplyTo" name="estatusReplyTo" value="1"/>  
                       <label id="ReplyToText" for="EstatusReplyTo">NO</label>
                     </div>
                   </div>
                   <div class="col-md-3 col-sm-3 col-xs-12">
                    <label for="message">¿Requiere Operadora? :</label>
                    <div class="radio" id="OperadoraRadio">

                     <input type="checkbox" class="js-switch" id="estatusOperadora" name="estatusOperadora" value="1"/>  
                     <label id="estatusTextO" for="estatusOperadora">NO</label>
                   </div>
                   <div class="radio" id="operadorasNum" style="display: none;">
                    <label>Seleccione Operadora</label>
                    <select class="select2_single form-control" name="operadora" id="operadora" tabindex="-1">
                      <option></option>
                      <?php 

                      $SQLOperadoras="SELECT m_operadora_id, m_operadora_nombre FROM m_operadoras ORDER BY m_operadora_nombre ASC";
                      $queryOperadora=mysqli_query($link, $SQLOperadoras);
                      while ($rowOperadoras=mysqli_fetch_array($queryOperadora)) {
                        $m_operadora_id=$rowOperadoras["m_operadora_id"];
                        $m_operadora_nombre=$rowOperadoras["m_operadora_nombre"];

                        ?>
                        <option value="<?=$m_operadora_id?>"><?=$m_operadora_nombre?></option>
                        <?php } ?>
                      </select> 
                    </div>
                  </div>

                  <div class="col-md-3 col-sm-3 col-xs-12">
                    <label for="message">¿Es Interactivo? :</label>
                    <div class="radio" id="commentRadio">

                     <input type="checkbox" class="js-switch" id="estatusComment" name="estatusComment" value="1"/>  
                     <label id="commentText" for="estatusComment">NO</label>
                   </div>
                   <div class="radio" id="commentariosKey" style="display: none;">
                    <label>Palabra Clave</label>
                    <input type="text" name="keyComments" class="form-control has-feedback-left" id="keyComments" placeholder="Palabra clave">  
                  </div>



                </div>
              </div>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <label for="message">¿Requiere Definir Rangos? :</label>
                <div class="radio" id="radioRango">

                 <input type="checkbox" class="js-switch" id="estatusRango" name="estatusRango" value="1"/>  
                 <label id="rangoText" for="estatusRango">NO</label>
               </div>
               <div id="masterRango" class="col-md-12 col-sm-12 col-xs-12" style="display: none;">
                 <div class="row rangoForm" id="rangoForm"  >

                   <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                     <label>Inicio</label>
                     <input type="text" placeholder="Desde" name="desdeRango[]" id="desdeRango" class="form-control numeric input-sm">
                   </div>
                   <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                    <label>Fin</label>
                    <input type="text" placeholder="Hasta" name="hastaRango[]" id="hastaRango" class="form-control numeric input-sm">
                  </div>


                  <div id="actions" class="col-md-4 col-sm-12 col-xs-12 form-group">
                    <label><a href="#." id="addRango" title="Agregar nuevo rango"><i class="fa fa-plus-circle"></i>Agregar</a></label>
                    | <label><a href="#." id="hide_company" title="Eliminar rango"><i class="fa fa-plus-circle"></i>Eliminar</a></label>

                    <input type="text" readonly="yes"  placeholder="" class="form-control" style="background-color: #FFFFFF; border: none;">


                  </div>

                </div>

              </div>
              <input type="hidden" id="start_count_value"  name="start_count_value" value="1" />
              <input type="hidden" id="class_count" name="class_count" class="class_count" value="1" />



              <div class="col-md-12 col-sm-12 col-xs-12" style="padding-left: 0px;">
                <label for="message">¿Requiere definir Portabilidad? :</label>
                <div class="radio" id="PortabilidadRadio">

                 <input type="checkbox" class="js-switch" id="estatusPortabilidad" name="estatusPortabilidad" value="1"/>  
                 <label id="portabilidadText" for="estatusPortabilidad">NO</label>
               </div>
               <div class="radio" id="portabilidadNums" style="display: none;">

                <div class="col-md-9 col-sm-9 col-xs-12">
                  <label>Indique los números que desea portar (presionar enter por cada número)</label>
                  <input id="tags_1" type="text" name="numerosPortados" class="tags form-control" value="" />
                  <div id="suggestions-container" style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                </div>
                <div id="pasaportesPortadosDiv" class="col-md-9 col-sm-9  col-xs-12">
                  <label>Seleccione los pasaportes a portar</label>
                  <select name="pasaportesPortados[]" class="select2_multiple form-control" multiple="multiple" id="pasaportesPortados">

                   <?php 
                   foreach ($pasaportes as $nombrePasaporte => $idPasaporte) {
                    ?>
                    <option value="<?=$idPasaporte?>"><?=$nombrePasaporte?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12" style="padding-left: 0px;">
              <label for="message">¿Requiere filtrado? (Jaula):</label>
              <div class="radio" id="radioFiltrado">

               <input type="checkbox" class="js-switch" id="estatusFiltrado" name="estatusFiltrado" value="1"/>  
               <label id="filtradoText" for="estatusFiltrado">NO</label>
             </div>
             <div id="masterFiltrado" class="col-md-12 col-sm-12 col-xs-12" style="display: none;">
               <div class="row filtradoForm" id="filtradoForm"  >
                 <div class="col-md-6 col-sm-9 col-xs-12">
                   <label>Indique los números que desea Filtrar (Si desea filtrar números completos)</label>
                    <input id="tags_jaula" type="text" name="numerosFiltrados" class="tags form-control" value="" />
                    <div id="suggestions-container" style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                </div>
                <div class="col-md-6 col-sm-9 col-xs-12">
                   <label>Indique inicios de los números a Filtrar (Si desea filtrar por inicio de número)</label>
                    <input id="tags_jaulaIni" type="text" name="iniciosFiltrados" class="tags form-control" value="" />
                    <div id="suggestions-container" style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                </div>

                 <div id="pasaportesPortadosDiv" class="col-md-9 col-sm-9  col-xs-12">
                  <label>Seleccione los pasaportes a portar</label>
                  <select name="pasaportesFiltrados[]" class="select2_multiple form-control" multiple="multiple" id="pasaportesFiltrados">

                   <?php 
                   foreach ($pasaportes as $nombrePasaporte => $idPasaporte) {
                    ?>
                    <option value="<?=$idPasaporte?>"><?=$nombrePasaporte?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>

            </div>

          </div>


          <div class="form-group">
            <div class="col-md-9 col-sm-9 col-xs-12 col-md-offset-3">
              <button type="submit" class="btn btn-success" id="btn_enviar">Guardar</button>
              <button type="button" class="btn btn-primary" onClick="document.location.href='listar.php?idBlock=<?=$idBlock?>'">Cancelar</button>

            </div>
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

<!--LIBRERIAS INDIVIDUALES NO COMUNES-->

<!-- Switchery -->
<script src="../vendors/switchery/dist/switchery.min.js"></script>

<script src="../js/validate/jquery.validate.js"></script>
<!-- Select2 -->
<script src="../vendors/select2/dist/js/select2.full.min.js"></script>
<script type="text/javascript" src="../js/jquery.numeric.min.js"></script>
<!-- jQuery Tags Input -->
<script src="../vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>

<script type="text/javascript">

  function showBox(blockName){
   $("#"+blockName).show(1000);
 }
 function hideBox(blockName){
   $("#"+blockName).hide(1000);
 }
</script>



<script type="text/javascript">


  $("#EstatusRadio").click(function() {
    if ($('#estatus').prop('checked')) {
     $("#estatusText").html("<b>Activa</b>");
   }
   else{
    $("#estatusText").html("<b>Inactiva</b>");
  }
});


//MANEJO DEL CHECK DE OPERADORAS
$("#OperadoraRadio").click(function() {
  if ($('#estatusOperadora').prop('checked')) {
   $("#estatusTextO").html("<b>SÍ</b>");
   showBox("operadorasNum");
 }
 else{
  $("#estatusTextO").html("<b>NO</b>");
  hideBox("operadorasNum");
  $("select#operadora").val('').prop('selected', false);
  $("#operadora").change();
}
});
//FIN OPERADORAS

//MANEJO DEL CHECK DE GETREPLYTO
$("#ReplyToRadio").click(function() {
  if ($('#estatusReplyTo').prop('checked')) {
   $("#ReplyToText").html("<b>SÍ</b>");
 }
 else{
  $("#ReplyToText").html("<b>NO</b>");
  hideBox("operadorasNum");
}
});
//FIN OPERADORAS

//PARA MANEJO DEL CHECK DE COMENTARIOS
$("#commentRadio").click(function() {
  if ($('#estatusComment').prop('checked')) {
   $("#commentText").html('<b>SÍ</b>');
   showBox("commentariosKey");
 }
 else{
  $("#commentText").html("<b>NO</b>");
  hideBox("commentariosKey");
  $("#keyComments").val("");
}
});
//FIN COMENTARIOS

//PARA MANEJO DEL CHECK DE RANGOS
$("#radioRango").click(function() {
  if ($('#estatusRango').prop('checked')) {
   $("#rangoText").html('<b>SÍ</b>');
   showBox("masterRango");
 }
 else{
  $("#rangoText").html("<b>NO</b>");
  hideBox("masterRango");
}
});

//FIN CHECK RANGOS

//PARA EL MANEJO DE LOS RANGOS (INGRESE SU MALA PALABRA AQUÍ)
if($('#start_count_value').val())
{
  var i= $('#start_count_value').val();
}
else 
{
  var i=0;
}
$("#addRango").click(function(){
  i =$("#class_count").val();
  $('#rangoForm').before($("#rangoForm").clone().attr("id","rangoForm" + i));
  $("#rangoForm" + i).css("display","block");
  $("#rangoForm" + i +"> div >label>a#addRango").css("display", "none");
  $("#rangoForm> div >:input").val("");
  $("#rangoForm" + i + " :input").each(function(){
    //$(this).attr("name",$(this).attr("name") + i);
    $(this).attr("id",$(this).attr("id") + i);
    $(this).attr("count",i); 

  });
  $("#class_count").val(parseInt($("#class_count").val())+1);


  $("#rangoForm" + i+" > div > :input.input-sm").each(function(){
    $(this).rules("add", {
      required: true
    });
  });
  i++;
});

$(document).on("click","#hide_company",function() {
 $(this).hide( "slow", function() {
  $(this).closest(".rangoForm").remove();
});
});
//FIN RANGOS

//PARA MANEJO DEL CHECK DE PORTABILIDAD
$("#PortabilidadRadio").click(function() {
  if ($('#estatusPortabilidad').prop('checked')) {
   $("#portabilidadText").html('<b>SÍ</b>');
   showBox("portabilidadNums");
   $("#pasaportesPortadosDiv>span>span>span >ul>li>input").attr("placeholder", "Elegir pasaportes");
   $("#pasaportesPortadosDiv>span>span>span >ul>li>input").css("width", "100%");
 }
 else{
  $("#portabilidadText").html("<b>NO</b>");
  hideBox("portabilidadNums");
}
});



//PARA MANEJO DEL CHECK DE FILTRADOS
$("#radioFiltrado").click(function() {
  if ($('#estatusFiltrado').prop('checked')) {
   $("#filtradoText").html('<b>SÍ</b>');
   showBox("masterFiltrado");
 }
 else{
  $("#filtradoText").html("<b>NO</b>");
  hideBox("masterFiltrado");
}
});

//FIN CHECK RANGOS
</script>
<!-- Select2 -->
<script>
  $(document).ready(function() {
    $(".select2_single").select2({
      placeholder: "Select a state",
      allowClear: true
    });
    $(".select2_group").select2({});
    $(".select2_multiple").select2({
      placeholder: "Pasaportes permitidos",
      allowClear: true
    });
  });
</script>
<!-- /Select2 -->


<!-- jQuery Tags Input -->
<script>
  function onAddTag(tag) {
    alert("Added a tag: " + tag);
  }

  function onRemoveTag(tag) {
    alert("Removed a tag: " + tag);
  }

  function onChangeTag(input, tag) {
    alert("Changed a tag: " + tag);
  }

  $(document).ready(function() {
    $('#tags_1').tagsInput({
      width: 'auto'
    });
  $('#tags_jaula').tagsInput({
      width: 'auto'
    });

  $("#tags_jaulaIni").tagsInput({
    width: 'auto'
  });
    
  });
</script>
<!-- /jQuery Tags Input -->


<script type="text/javascript">
  $(".numeric").numeric();
  $("#remove").click(
    function(e)
    {
      e.preventDefault();
      $(".numeric").removeNumeric();
    }
    );

  $(function() {

    $("#formCola").validate({

     rules: {
      nameCola: "required",
      descripcion: "required",
    },

    messages: {
      nameCola: "Debe especificar un nombre para la cola",
      descripcion: "Debe especificar una descripción para diferenciar los registros",

    },

    submitHandler: function(form) {
      $(document).find("#formCola").trigger("create");
      var formData = new FormData($("#formCola")[0]);

      $.ajax({
        url: "addCola.php",
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
          setTimeout(function() { window.location.href = 'listar.php?idBlock=<?=$idBlock?>';}, 1000);
        } else{
          $("#mensajes").css("z-index", "999");
          $($("#mensajes").html("<div class='alert alert-error'><a href='#' class='close' data-dismiss='alert' id='cerrar'>&times;</a><div id='dataMessage'></div></div>").fadeIn("slow"));
          $('#dataMessage').append(data['data']['message']);
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