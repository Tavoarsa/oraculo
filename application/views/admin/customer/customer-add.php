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
        <small>Panel de Control</small>
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
            <div class="box box-primary">
              <div class="box-header">
                <h3 class="box-title">Agregar</h3>
                <a href="<?php echo base_url().'index.php/customer'; ?>" class="btn btn-primary btn-small pull-right">Regresar a la lista</a>
              </div>
              <!-- /.box-header -->
              <div class="box-body">
                <?php if(validation_errors() != false){ ?>
                <div class="alert alert-danger alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <h4><i class="icon fa fa-ban"></i> Error!</h4>
                    <?php echo validation_errors(); ?>
                </div>
                <?php } ?>
              <?php 
                $attributes = array('id' => 'frm','name'=>'frm');
                  echo form_open('customer/create',$attributes); ?>


					           <div class="form-group">
                        <label>Nombre Cliente:</label>
                        <input type="text" name="txt_receptor_nombre" id="receptor_nombre" class="form-control " placeholder="..." value="" />
                    </div>

                    <div class="form-group">
                        <label>Tipo de Idetificación:</label>
                        <select name="sel_receptor_tipo_identif" id="receptor_tipo_identif">
                          <option value="FN">Cédula Persona Física</option>
                          <option value="JN">Cédula Persona jurídica </option>
                          <option value="EN">Número de Identificación Tributario Especial(NITE)</option>
                          <option value="ED">Documento de Identificación Migratorio para Extrajenros(DIMEX)</option>                          
                        </select  >
                        
                    </div>

                    <div>
    <label for="cc">Credit Card</label>
    <!-- Set via HTML -->
    <input id="cc" type="text" data-inputmask="'mask': '9999 9999 9999 9999'" />
  </div>
  
  <div>
    <label for="date">Date</label>
    <input id="date" data-inputmask="'alias': 'date'" />
  </div>
  
  <div>
    <label for="phone">Phone</label>
    <!-- or set via JS -->
    <input id="phone" type="text" />
  </div>

                 
                    <div class="form-group">
                        <label>N° Idetificación:</label>

                         <input type="text" name="txt_receptor_num_identif" id="receptor_num_identif" class="form-control " data-inputmask="'mask': '9 9999 9999'"  />
                        
                    </div>
					        
					           <div class="form-group">
                        <label>Email:</label>
                        <input type="text" name="txt_customer_email" class="form-control " placeholder="..." value="" />
                    </div>
					           <div class="form-group">
                        <label>Password :</label>
                        <input type="text" name="txt_customer_password" class="form-control " placeholder="..." value="" />
                    </div>
					
					          <div class="form-group">
                        <label>Dirección:</label>
                        <input type="text" name="txt_customer_address" class="form-control " placeholder="..." value="" />
                    </div>
					          <div hidden="true" class="form-group">
                        <label>Cuidad :</label>
                        <input type="text" name="txt_customer_city" class="form-control " placeholder="..." value="" />
                    </div>

					          <div hidden="true" class="form-group">
                        <label>Codigo Postal:</label>
                        <input type="text" name="txt_customer_zipcode" class="form-control " placeholder="..." value="0" />
                    </div>
					          <div class="form-group">
                        <label>Telefono:</label>
                        <input type="text" name="txt_customer_phone" class="form-control " placeholder="..." value="" />
                    </div>
					
					          <div class="form-group">
                        <label>Otro Contacto :</label>
                        <input type="text" name="txt_contact_person" class="form-control " placeholder="Contacto.." value="" />
                    </div>
					          <div class="form-group">
                        <label>Telefono del contacto :</label>
                        <input type="text" name="txt_contact_person_phone" class="form-control " placeholder="Contact person phone Here..." value="" />
                    </div>
				            <div class="form-group">
                        <label>Activo :</label>
                        <input type="radio" name="txt_customer_is_active" checked placeholder="Customer is active Here..." value="yes" /> Si
                        <input type="radio" name="txt_customer_is_active" placeholder="Customer is active Here..." value="no" /> No
                    </div>
                    <div class="form-group">
                      <input type="submit" name="btnsubmit" class="btn btn-primary" value="Save"/>
                      <input type="button" title="Cancel" value="Cancel" class="btn btn-danger" onclick="javascript:window.location.href='<?php echo base_url().'index.php/customer' ?>'" />
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

 <script type="text/javascript">
   
   $(":input").inputmask();

  $("#phone").inputmask({"mask": "(999) 999-9999"});
 </script>