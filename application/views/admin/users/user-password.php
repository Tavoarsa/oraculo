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
        Password
        <small>Control panel</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Change Password</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header">
                <h3 class="box-title">Change Password</h3>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <?php if($this->session->flashdata('msg') != false){ 
                    $len = strlen($this->session->flashdata('msg'));
                  ?>
                 <div class="alert alert-<?php if($len >= 30) echo "danger"; else "success"; ?> alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4>  <i class="icon fa fa-<?php if($len >= 30) echo "ban"; else "check"; ?>"></i> Alert!</h4>
                    <?php echo $this->session->flashdata('msg'); ?>
                </div>
                <?php } ?>
                <?php if(validation_errors() != false){ ?>
                <div class="alert alert-danger alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h4><i class="icon fa fa-ban"></i> Error!</h4>
                    <?php echo validation_errors(); ?>
                </div>
                <?php } ?>
              <?php 
                $attributes = array('id' => 'frm','name'=>'frm');
                  echo form_open('users/c_password',$attributes); ?>


					          <div class="form-group">
                        <label>Old Password :</label>
                        <input type="password" name="old_password" class="form-control " placeholder="Old Password Here..." value="" />
                    </div>
					
					          <div class="form-group">
                        <label>New Password :</label>
                        <input type="password" name="txt_password" class="form-control " placeholder="Password Here..." value="" />
                    </div>

                    <div class="form-group">
                        <label>New Confirm Password :</label>
                        <input type="password" name="confirm_password" class="form-control " placeholder="Confirm Password Here..." value="" />
                    </div>
					         
                   
                    <div class="form-group">
                      <input type="submit" name="btnsubmit" class="btn btn-primary" value="Save"/>
                      
                    </div>

              <?php echo form_close(); ?>
              </div>
            </div>
          </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

 <?php 
	// include footer file
 
 $this->load->view('admin/include/footer.php'); ?>