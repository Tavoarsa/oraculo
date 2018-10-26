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
        Producto
        <small>Panel Control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Producto</li>
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
                <a href="<?php echo base_url().'index.php/product'; ?>" class="btn btn-primary btn-small pull-right">Regresar a la lista</a>
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
                  echo form_open_multipart('product/update/'.$this->uri->segment(3),$attributes); ?>
                  <div class="col-md-6">  
                    <div class="form-group">
                        <label>Categoría :</label>
                        <select name="txt_sub_category_id" class="form-control ">
                            
                         <?php 
                            $CI =& get_instance();
                            $category = $CI->get_All_category();
                            foreach ($category as $value) {
                                ?>
                                <option value="<?php echo $value->category_id; ?>" <?php if($recored['sub_category_id'] ==  $value->category_id ) echo 'selected'; ?>><?php echo $value->category_name; ?></option>
                                <?php
                            }
                          ?>
                        </select>
                    </div>
					
					         <div class="form-group">
                        <label>Nombre Producto:</label>
                        <input type="text" name="txt_product_name" class="form-control " placeholder="Product name Here..." value="<?php echo $recored['product_name']; ?>" />
                    </div>
					          <div class="form-group">
                        <label>Serie Producto :</label>
                        <input type="text" name="txt_product_serial_no" class="form-control " placeholder="Product serial no Here..." value="<?php echo $recored['product_serial_no']; ?>" />
                    </div>

                    <div class="form-group">
                      <label>Opciones</label>
                      <br />
                          <?php 
                            $CI =& get_instance();
                            $main_option = $CI->get_main_option();
                            $av_option =  $CI->get_product_option($recored['product_id']);
                            
                            foreach ($main_option as $value) {
                                echo '<label><strong>'.$value->option_name.'</strong></label>';
                                echo '<table width="100%">';
                                $c_option = $CI->get_c_option($value->option_id); 
                                $stock_byt = 0;
                                foreach ($c_option as $_option) { 
                                      $stock = NULL;
                                      ?>
                                      
                                          <tr>
                                            <td align="left" width="5%" >
                                                <input type="checkbox" name="txtoption[]" id="<?php echo $_option->option_id; ?>" <?php if(array_key_exists($_option->option_id, $av_option)) { echo 'checked'; $stock = $av_option[$_option->option_id]; } ?> value="<?php echo $_option->option_id; ?>"  />
                                            </td> 
                                            <td align="left" width="15%"  >
                                                <?php echo $_option->option_name; ?>
                                            </td>
                                            <td align="left" >
                                                <label>Precio : </label>
                                                <input type="text" name="txtstock[<?php echo $_option->option_id; ?>]"  value="<?php echo $stock; ?>" style="border:solid 1px #CCC; width:50px; height:20px; text-align:center; color:#666;" />
                                            </td>
                                          </tr>
                                      
                                      <?php
                                    $stock_byt++;
                                  }  
                                  echo '</table>';
                            }
                          ?>
                    </div>

                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                        <label>Descripción Producto :</label>
                        <textarea name="txt_product_description"><?php echo $recored['product_description']; ?></textarea>
                    </div>
					          <div class="form-group">
                   
					          <div class="form-group">
                        <label>Imagen Producto:</label>
                        <input type="file" name="txt_product_image_1" />
                    </div>

                    <?php 
                      $path ='file/product/'.$recored['product_image_1'];
                      if(file_exists($path))
                      {
                        echo '<div class="form-group">';
                        echo '<img src="'.base_url().$path.'"height="250" width="250" />';
                        echo '</div>';
                      }
                    ?> 
					          <div class="form-group">
                        <label>Activo :</label>
                        <input type="radio" name="txt_product_is_active" <?php if($recored['product_is_active'] == 'yes') echo 'checked'; ?> value="yes" /> Si
                        <input type="radio" name="txt_product_is_active" <?php if($recored['product_is_active'] == 'no') echo 'checked'; ?>  value="no" /> No
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class="form-group">
                      <input type="submit" name="btnsubmit" class="btn btn-primary" value="Save"/>
                      <input type="button" title="Cancel" value="Cancel" class="btn btn-danger" onclick="javascript:window.location.href='<?php echo base_url().'index.php/product' ?>'" />
                    </div>
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

