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
       Reset Mesas
        <small>Panel del Control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Mesas</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header">
                <h3 class="box-title">Lista</h3>
                <a href="<?php echo base_url().'index.php/sales/create'; ?>" class="btn btn-primary btn-sm pull-right">Crear Venta</a>
				
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
                echo form_open('sales/delete',$attributes) ?>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                    <tr>
   										<th align="left" >Id</th>
   										<th align="left" >Mesa # </th>
                      <th align="left" >Fecha </th>
   										<th align="left" >Producto</th>
                      <th align="left" >Cantidad</th>    										
   										<th align="left" >Total</th>
   										
   										<th>Acción</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php 
					  $arids = array();
                      foreach ( $recored as $_recored ) {
                       
                  ?>
                            <tr>
       												<td><?php echo $_recored->purchase_id; ?></td>
       												<td><?php echo $_recored->table_id; ?></td>  
                              <td><?php echo $_recored->create_date; ?></td>      												
       												<td><?php echo $_recored->product_option_id; ?></td>                              
                              <td><?php echo $_recored->purchase_item_qty; ?></td>                             
       												<td><?php echo $_recored->purchase_total; ?></td>
       												
                             
							                <td>
                                
                                <a class="action-edit btn btn-danger btn-sm" href="<?php echo base_url().'index.php/sales/delete_tmp_sale/'.$_recored->purchase_id; ?>" class="action-edit" title="Delete"><i class="fa fa-close"></i></a>
                              </td>
							 
                            </tr>
                  <?php 
                     }
                  ?>
                    </tbody>
                 
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
<script type="text/javascript">
  
  function print_invoice(url , _orderno)
  {
    url = '<?php echo base_url() ?>index.php/sales/pdf/'+url+'/'+_orderno;
    
    var w = 900;
    var h = 600;
    var left = (screen.width/2)-(w/2);
    var top = (screen.height/2)-(h/2);
    window.open(url,"_blank","resizable=yes,location=no,menubar=no,scrollbars=yes,status=no,toolbar=no,fullscreen=no,dependent=no,copyhistory=no,width="+w+",height="+h+",left="+left+",top="+top);
  }

  

</script>
