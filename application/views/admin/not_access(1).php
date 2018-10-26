<?php include('include/common.php'); ?>

  <?php include('include/header.php'); ?>
  
  <?php include('include/sidebar.php'); ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        No permitido
        <small>Panel de Control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href=""><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Permisos</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Permission (box) -->
      <div class="row">
        <div class="col-md-12">
            <div class="alert alert-danger alert-dismissable">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <h4><i class="icon fa fa-ban"></i> Alerta!</h4>
              No tienes permiso para accdeder a este modúlo.
            </div>
        </div>
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 <?php include('include/footer.php'); ?>
