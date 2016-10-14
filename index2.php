<?php include('logeo.php'); 
include('extras/conexion.php');
$link=Conectarse();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <?php include("common_head.php"); ?>
</head>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <div class="col-md-3 left_col">
        <?php include("common_menu.php");?>
      </div>

      <!-- top navigation -->
      <?php include("common_topNavigation.php"); ?>
      <!-- /top navigation -->


      <!-- page content -->
      <div class="right_col" role="main">

        <br />
        <div class="">

<!-- <div class="row top_tiles">
<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
<div class="tile-stats">
<div class="icon"><i class="fa fa-users"></i>
</div>

<?php
$SQLClientes="SELECT COUNT(*) AS clientes FROM m_clientes WHERE m_cliente_estatus='1'  ORDER BY  m_cliente_id ASC ";
$queryCluentes=mysqli_query($link, $SQLClientes);
$rowClientes=mysqli_fetch_array($queryCluentes);
$clientesRegistrados=$rowClientes["clientes"];
?>
<div class="count"><?=$clientesRegistrados?></div>

<h3>Clientes Registrados</h3>
<p>Clientes Activos</p>
</div>
</div>


<?php
$SQL="SELECT m_producto_id FROM m_productos WHERE m_producto_estatus='1'";
$queryS=mysqli_query($link, $SQL);
$productosCantidad=mysqli_num_rows($queryS);
?>
<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
<div class="tile-stats">
<div class="icon"><i class="fa fa-tag"></i>
</div>
<div class="count"><?=$productosCantidad?></div>

<h3>Productos en Venta </h3>
<p>Usuarios compradores </p>
</div>
</div>


<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
<div class="tile-stats">
<div class="icon"><i class="fa fa-tag"></i>
</div>
<div class="count">0</div>

<h3>Ventas por Aprobar</h3>
<p>Ofertas en periodo de validéz</p>
</div>
</div>
<div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">
<div class="tile-stats">
<div class="icon"><i class="fa fa-shopping-cart"></i>
</div>

<?php
$SQL24="SELECT COUNT(*) AS solicitudesDay FROM m_solicitudes WHERE m_solicitud_fechaCreacion >= SYSDATE() - INTERVAL 1 DAY ";
$query24=mysqli_query($link, $SQL24);
$row24=mysqli_fetch_array($query24);
$solicitudesDay=$row24["solicitudesDay"];
?>
<div class="count"><?=$solicitudesDay?></div>

<h3>Solicitudes del día</h3>
<p>Solicitudes de las últimas 24 horas</p>
</div>
</div>
</div>-->

<div class="row">
  <div class="col-md-12">
    <div class="x_panel">
      <div class="x_title">
        <h2>Panel de control <i class="fa fa-dashboard"></i></h2>
        <div class="filter">

        </div>
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="col-md-9 col-sm-12 col-xs-12">
          <div class="demo-container" style="height:250px">
            <div id="placeholder3xx3" class="demo-placeholder" style="width: 100%; height:250px;">

              <h1>Operaciones Tedexis <i class="fa fa-dashboard"></i></h1>
              <h3>Soluciones Moviles... </h3>
            </div>
          </div>


        </div>

        <div class="col-md-3 col-sm-12 col-xs-12">
          <div>
            <div class="x_title">


              <div class="clearfix"></div>
            </div>

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
<?php include("common_footer.php"); ?>
<!-- /footer content -->
</div>
</div>

<?php include("common_libraries.php"); ?>



</body>
</html>