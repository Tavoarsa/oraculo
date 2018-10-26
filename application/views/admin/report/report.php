<?php
  $dateform = '';
  $dateto = '';

  if(isset($_POST['date']) && $_POST['date'] != '' )
  {
    if($_POST['date'] == 'search' )
    {
      $sendserver = $_POST['date'];
      $dateform = $_POST['txtfrom_date'];
      $dateto = $_POST['txtto_date'];
    }
    else
    {
      $sendserver = $_POST['date'];  
    }
  }
  else
  {
    $sendserver = $this->uri->segment(2);
      
  }

?>
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
        Ventas
        <small>Panel de Control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Reporte de Ventas <?php echo $this->uri->segment(2); ?></li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) --> 
      <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
              <div class="box-header">
                <i class="fa fa-bar-chart-o"></i>
                <h3 class="box-title">Información de las ventas</h3>
                <a target="_blank" href="<?php echo base_url().'index.php/report/pdf'; ?>" class="btn btn-primary btn-sm pull-right" style="margin-right: 5px;">Crear PDF</a>
                <a target="_blank" href="<?php echo base_url().'index.php/report/excel'; ?>" class="btn btn-primary btn-sm pull-right" style="margin-right: 5px;">Crear Excel</a>
				      </div>
              <!-- /.box-header -->
              <?php 
              $attributes = array('id' => 'frm','name'=>'frm');
              echo form_open('customer/delete',$attributes) ?>
                <div class="box-body">
                      <div class="col-xs-4">
                         <div class='box-body pad'>
                            <div class="form-group">
                              <label>De:</label>
                               <div class="input-group">
                                <input type="text" name="txtfrom_date" id="txtfrom_date" readonly="readonly" value="<?php echo $this->uri->segment(3); ?>" class="form-control" />
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                              </div>
                              <br />
                              <input type="button" value="Reporte Diario" title="Today Report" class="btn btn-<?php if($sendserver == 'today') echo 'danger'; else echo 'primary'; ?>" onclick="javascript:window.location.href='<?php echo base_url().'index.php/report/today' ?>';" />
                              <input type="button" style="float:right" value="Reporte Semanal" title="Weekly Report" class="btn btn-<?php if($sendserver == 'weekly') echo 'danger'; else echo 'primary'; ?>" onclick="javascript:window.location.href='<?php echo base_url().'index.php/report/weekly' ?>';" />
                            </div>
                         </div>
                      </div>
                      <div class="col-xs-4">
                         <div class='box-body pad'>
                            <div class="form-group">
                              <label>A:</label>
                               <div class="input-group">
                                <input type="text" name="txtto_date" id="txtto_date" readonly="readonly" value="<?php echo $this->uri->segment(4); ?>" class="form-control" />
                                <div class="input-group-addon" ><i class="fa fa-calendar"></i></div>
                              </div>
                              <br />
                              <input type="button" value="Reporte Mensual" title="Monthly Report" class="btn btn-<?php if($sendserver == 'monthly') echo 'danger'; else echo 'primary'; ?>" onclick="javascript:window.location.href='<?php echo base_url().'index.php/report/monthly' ?>';" />
                              <input type="button" style="float:right" value="Reporte Anual" title="Yearly Report" class="btn btn-<?php if($sendserver == 'yearly') echo 'danger'; else echo 'primary'; ?>" onclick="javascript:window.location.href='<?php echo base_url().'index.php/report/yearly' ?>';" />
                            </div>
                         </div>
                      </div>
                      <div class="col-xs-4">
                         <div class='box-body pad'>
                            <div class="form-group">
                              <br />
                              <input type="button" value="Buscar" title="Search" class="btn btn-primary" onclick="javascript:search_record();" />
                              <input type="button" value="Reset" title="Reset" class="btn btn-danger" onclick="javascript:window.location.href='<?php echo base_url() ?>index.php/report'" />
                            </div>
                         </div>
                      </div>
                </div>

                <div class="box-body table-responsive">
                    <table id="example1" class="table table-bordered table-hover">
                      <thead>
                        <tr class="bg-blue">
                          <th width="15%">Fecha</th>
                          <th width="15%">Total Ordenes</th>
                          <th width="40%">Orden No.</th>
                          <th width="10%">Efectivo</th>
                          <th width="10%">Debito</th>
                          <th width="10%">Total</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                          $CI =& get_instance();
                          foreach ($recored as $_date) {
                            ?>
                            <tr>
                              <td><?php echo  date("d-m-Y", strtotime($_date->entry_date)); ?></td>
                              <td>
                                <?php 
                                   echo $total_order = $CI->get_total_order($_date->entry_date);
                                ?>
                              </td>
                              <td>
                                <?php
                                  $all_order = $CI->get_all_order($_date->entry_date);
                                  foreach ($all_order as $_order) {
                                    ?>
                                    <a href="javascript:void(0);" onclick="javascript:order_info('<?php echo $_order->purchase_no ?>');"><?php echo $_order->purchase_no ?>,</a>
                                    <?php
                                  }
                                ?>
                              </td>
                              <td>
                                <?php
                                  echo $all_cash = number_format($CI->get_all_cash($_date->entry_date)+$CI->get_total_ser_res($_date->entry_date),2);
                                ?>
                              </td>
                              <td>
                                <?php
                                  echo $all_debit = number_format($CI->get_all_debit($_date->entry_date)+$CI->get_total_ser_res($_date->entry_date),2);
                                ?>
                              </td>
                              <td>
                                <?php
                                  echo $all_total = number_format($CI->get_all_total($_date->entry_date)+$CI->get_total_ser_res($_date->entry_date),2);
                                ?>
                              </td>

                            </tr>
                            <?php
                          }
                        ?>      
                      </tbody>
                      
                    </table>
                </div>

              <?php echo form_close() ?>
            </div>
        </div>
      </div>
    </section>
  </div>

  <?php // include footer FIle

 $this->load->view('admin/include/footer.php'); ?>   
 
 <script type="text/javascript">
   
  $('#txtfrom_date').datepicker({
    format: 'dd-mm-yyyy'
    });
  $('#txtto_date').datepicker({
    format: 'dd-mm-yyyy'
    });

  function order_info(_orderno)
  { 
    var w = 900;
    var h = 600;
    var left = (screen.width/2)-(w/2);
    var top = (screen.height/2)-(h/2);
    window.open("<?php echo base_url() ?>index.php/report/order_info/"+_orderno,"_blank","resizable=yes,location=no,menubar=no,scrollbars=yes,status=no,toolbar=no,fullscreen=no,dependent=no,copyhistory=no,width="+w+",height="+h+",left="+left+",top="+top);
  }

  function search_record()
  {
    var dateform = document.getElementById('txtfrom_date').value;
    var dateto = document.getElementById('txtto_date').value;
    if(!String(dateform)==false && !String(dateto)==false){
      window.location.href = "<?php echo base_url() ?>index.php/report/search/"+dateform+"/"+dateto;
    }
    else
    {
      window.location.href = window.location.href;  
    }
    
  }
 </script>