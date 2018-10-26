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
        Categoria
        <small>Panel de Control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Categoria</li>
      </ol>
    </section>

     <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header">
                <h3 class="box-title">Editar</h3>
                <a href="<?php echo base_url().'index.php/category'; ?>" class="btn btn-primary btn-small pull-right">Regresar a lista</a>
              </div>
              <!-- /.box-header -->
              <div class="box-body">

                <?php 
                  if (isset($error)) {
                    ?>
                    <div class="alert alert-danger alert-dismissable">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                      <h4>  <i class="icon fa fa-ban"></i> Error!</h4>
                      <?php echo $error; ?>
                    </div>
                    <?php
                  }
                ?>

                <?php if(validation_errors() != false){ ?>
                  <div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-ban"></i> Error!</h4>
                      <?php echo validation_errors(); ?>
                  </div>
                <?php } ?>
              <?php 
                $attributes = array('id' => 'frm','name'=>'frm');
                  echo form_open_multipart('category/update/'.$this->uri->segment(3),$attributes); ?>


					
					         <div class="form-group">
                        <label>Nombre Categoría:</label>
                        <input type="text" name="txt_category_name" class="form-control " placeholder="" value="<?php echo $recored['category_name']; ?>" />
                    </div>
					         <div class="form-group">
                        <label>Descripción  Categoría:</label>
                        <textarea name="txt_category_description"  ><?php echo $recored['category_description']; ?></textarea>
                    </div>
					         <div class="form-group">
                        <label>Imagen de Categoría :</label>
                        <input type="file" name="txt_category_image"  />
                    </div>
								    <?php 
                      $path ='file/subcategory/'.$recored['category_image'];
                      if(file_exists($path))
                      {
                        echo '<div class="form-group">';
                        echo '<img src="'.base_url().$path.'"height="250" width="250" />';
                        echo '</div>';
                      }
                    ?>       
                     <div class="form-group">
                        <label>Activo:</label>
                        <input type="radio" name="txt_category_is_active" <?php if($recored['category_is_active'] == 'yes') echo 'checked'; ?> placeholder="Category is active Here..." value="yes" /> Si
                        <input type="radio" name="txt_category_is_active" <?php if($recored['category_is_active'] == 'no') echo 'checked'; ?> placeholder="Category is active Here..." value="no" /> No
                    </div>
                     
                    <div class="form-group">
                      <input type="submit" name="btnsubmit" class="btn btn-primary" value="Save"/>
                      <input type="button" title="Cancel" value="Cancel" class="btn btn-danger" onclick="javascript:window.location.href='<?php echo base_url().'index.php/category' ?>'" />
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

 <?php // include footer FIle 
 
 $this->load->view('admin/include/footer.php'); ?>			

