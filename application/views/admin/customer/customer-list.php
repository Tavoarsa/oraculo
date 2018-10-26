<?php
// Add FIle
// include common file
 $this->load->view('admin/include/common.php'); 
// include header file
  $this->load->view('admin/include/header.php'); 
// include sidebar file  
   $this->load->view('admin/include/sidebar.php');
?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Cliente 
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Cliente</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">Lista</h3>
                <a href="<?php echo base_url().'index.php/customer/create'; ?>" class="btn btn-primary btn-sm pull-right">Crear Nuevo</a>
				<a target="_blank" href="<?php echo base_url().'index.php/customer/pdf'; ?>" class="btn btn-primary btn-sm pull-right" style="margin-right: 5px;">Crear PDF</a>
				<a target="_blank" href="<?php echo base_url().'index.php/customer/excel'; ?>" class="btn btn-primary btn-sm pull-right" style="margin-right: 5px;">Crear Excel</a>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
              <?php if($this->session->flashdata('msg') != false){ ?>
                 <div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4>  <i class="icon fa fa-check"></i> Alert!</h4>
                    <?php echo $this->session->flashdata('msg'); ?>
                </div>
                <?php } ?>
              <?php 
                $attributes = array('id' => 'frm','name'=>'frm');
                echo form_open('customer/delete',$attributes) ?>
                <table id="example1" class="table table-bordered table-hover">
                  <thead>
                    <tr>

   										<th align="left" >Nombre Cliente</th>
   										<th align="left" >Email</th>
   										<th align="left" >Telefono</th>
   										<th align="left" >Cuidad</th>
                      <th align="left" >Activo</th>
   										<th>Acción</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
					  $arids = array();
                      foreach ( $recored as $_recored ) {
                      
                  ?>
                            <tr>

       												<td><?php echo $_recored->customer_first_name; ?></td>
       												<td><?php echo $_recored->customer_email; ?></td>
       												<td><?php echo $_recored->customer_phone; ?></td>
                              <td><?php echo $_recored->customer_city; ?></td>
                              <td>
                                <label class="switch">
                                  <input type="checkbox" <?php $is_act = 'yes'; if($_recored->customer_is_active == 'yes') { echo 'checked'; $is_act = 'no'; }?> onchange="javascript:window.location.href='<?php echo base_url().'index.php/customer/change_action/'.$_recored->customer_id.'/'.$is_act; ?>'">
                                  <span class="slider round"></span>
                                </label>
                              </td>
       												<td><a class="action-edit btn btn-info btn-sm" href="<?php echo base_url().'index.php/customer/edit/'.$_recored->customer_id; ?>" class="action-edit" title="Edit"><i class="fa fa-edit"></i></a>
                              <a class="action-edit btn btn-danger btn-sm" href="<?php echo base_url().'index.php/customer/delete/'.$_recored->customer_id; ?>" class="action-edit" title="Delete"><i class="fa fa-close"></i></a>
                              </td>
                            </tr>
                  <?php 
                     }
                  ?>
                    </tbody>
                  <tfoot>
                   
                  </tfoot>
                </table>
                
              <?php echo form_close() ?>
              </div>
            </div>
          </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->


 <?php // include footer FIle
 $this->load->view('admin/include/footer.php'); ?>			

