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
                        <input type="text" name="txtreceptor_nombre" id="receptor_nombre" class="form-control " placeholder="Ingrese el nombre del cliente" value="" />
                    </div>

                    <div class="form-group">
                        <label>Tipo de Identificación :</label>
                        <select name="receptor_tipo_indetif">
                          <option value="01">Fisico</option>
                          <option value="02">Juridico</option>                                          
                         </select>
                    </div>
                    <div class="form-group">
                      <label>Número de Identificación:</label>
                       <input type="number" name="txtreceptor_num_identif" class="form-control " placeholder="Ingrese el número de idetificación"  />
                    </div>  
                      <div class="form-group">
                                        <label>Codigo País tel:</label>
                                        <input type="number" name="txtreceptor_cod_pais_tel" class="form-control " placeholder="Ingrese Codigo de pais..." />
                                    </div>
                                    
                                    <div class="form-group">
                                      <label>Número de telefono. :</label><br />
                                      <input type="text" id="phone" class="form-control" name="txtreceptor_tel" placeholder="Ingrese numero de telefono" />
                                    </div>
                                     <div class="form-group">
                                        <label>Codigo País fax:</label>
                                        <input type="number" name="txtreceptor_cod_pais_fax" class="form-control " placeholder="Ingrese Codigo de Fax..."  />
                                    </div>
                                    
                                    <div class="form-group">
                                      <label>Número de fax. :</label><br />
                                      <input type="text" class="form-control" name="txtreceptor_fax" placeholder="Ingrese número de fax" />
                                    </div>
                    <div class="form-group">

                    <div class="form-group">
                    <label>Email :</label>
                    <input type="email" class="form-control" name="txtreceptor_email" placeholder="Ingrese el Email"  />
                  </div>

                
                    <label>Provincia:</label>
                        <select id="cbx_provincia" name="cbx_provincia" >
                            <?php 

                            $CI =& get_instance();

                            $provincia = $CI->get_all_provincia();
                            foreach ($provincia as $value) {
                                ?>
                                <option value="<?php echo $value->idProvincia; ?>"><?php echo $value->nombreProvincia; ?></option>
                                <?php
                            }
                         ?>                            
                                             
                        </select>
                  
                                   
                      <label>Cantón :</label>
                        <select id="cbx_canton" name="cbx_canton" >
                              <?php 

                            $CI =& get_instance();

                            $canton = $CI->get_all_canton();
                            foreach ($canton as $value) {
                                ?>
                                <option value="<?php echo $value->idCanton; ?>"><?php echo $value->nombreCanton; ?></option>
                                <?php
                            }
                         ?>   

                        </select>
                    
                      <label>Distrito :</label>
                       <select id="cbx_distrito" name="cbx_distrito" >
                         <?php 

                            $CI =& get_instance();

                            $distrito = $CI->get_all_distrito();
                            foreach ($distrito as $value) {
                                ?>
                                <option value="<?php echo $value->idDistrito; ?>"><?php echo $value->nombreDistrito; ?></option>
                                <?php
                            }
                         ?> 
                       

                      </select>

                      <label>Barrio :</label>
                       <select id="cbx_barrio" name="cbx_barrio" >
                             <?php 

                            $CI =& get_instance();

                            $barrio = $CI->get_all_barrio();
                            foreach ($barrio as $value) {
                                ?>
                                <option value="<?php echo $value->idBarrio; ?>"><?php echo $value->nombreBarrio; ?></option>
                                <?php
                            }
                         ?> 
                       

                      </select>


                   
                   
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