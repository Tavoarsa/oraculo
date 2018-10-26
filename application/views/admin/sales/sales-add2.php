<?php
  if(!isset($_SESSION['old_id']))
  {
    $_SESSION['old_id'] = 1;
  }

   $CI =& get_instance();
   $company = $CI->get_company_data(); 
   $tabids = $CI->get_tmp_sales();
   $_cat = $CI->get_all_cat();
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
        <small>Panel de control</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Ventas</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
         <?php if(validation_errors() != false){ ?>
          <div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <h4><i class="icon fa fa-ban"></i> Error!</h4>
              <?php echo validation_errors(); ?>
          </div>
          <?php } ?>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12" id="table_all" >
          <div class='box box-danger'>
            <div class="box-header">
              <h4>Mesas</h4>
            </div>
            <div class='box-body pad' id="" style="background-image:url(tabl1e/back.png); text-align:center;" >
                          
              <?php
                
                for($i = 1; $i<=$company[0]->total_table; $i++ )
                {
                  ?>
                  <a class="btn btn-app" onclick="selectBill(<?php echo $i; ?>)" style="height:140px;width:104px;white-space:normal;font-weight:700; text-align:center; <?php if($_SESSION['old_id'] == $i) echo 'background-color:red;color:#FFF;'; else if(in_array($i,$tabids)) echo 'background-color:#0073B7;color:#FFF;'; ?> " >
                    <div style="background-image:url('<?php echo base_url(); ?>file/table/<?php echo $i; ?>.png'); height: 100px;width: 90px;" ></div>
                    <label>Mesas <?php echo $i; ?></label>
                  </a>
                  
                  <?php
                  
                  if($company[0]->total_table == $i)
                  {
                    $my_table_id = $i;
                    for($j = 1; $j <= $company[0]->total_parcel; $j++ ){
                      $my_table_id++;
                      ?>
                      <a class="btn btn-app" onclick="selectBill(<?php echo $my_table_id; ?>)" style="height:140px;width:104px;white-space:normal;font-weight:700; text-align:center; <?php if($_SESSION['old_id'] == $my_table_id) echo 'background-color:red;color:#FFF;'; else if(in_array($my_table_id,$tabids)) echo 'background-color:#0073B7;color:#FFF;'; ?>  ">
                        <div style="background-image:url('<?php echo base_url(); ?>file/table/mp.png'); height: 100px;width: 90px;" ></div>
                        Parcela &nbsp;<?php echo $j; ?>
                      </a>
                    <?php
                    }
                  }
                  
                }
              ?>
            </div>
          </div>
        </div> 
      </div>
      <!-- Small boxes (Stat box) -->
      <div class="row">
               

              <?php echo form_open('sales/create', array('onsubmit' => 'return stopform();','id' => 'frm','name'=>'frm'));?>

                  <!-- category -->
                  <div class="col-md-5" style="padding-right:0px;" >
                    <div class="col-md-12">
                      <div class='box box-primary'  >
                        <div class='box-header'>
                          <h5 style="font-size:16px;" class="box-title" id='rhead'><a onclick="getsubcategory('28');"><?php echo $company[0]->company_name ?></a></h5>
                        </div>
                        <div class='box-body pad' id="gridbox">
                          <?php
                          foreach($_cat as $cat)
                          {
                              $photo = base_url().'file/subcategory/'.$cat->category_image; 
                              ?>
                              <a id="subcatname_<?php echo $cat->category_id;  ?>" class="btn btn-app table_cat" onclick="getproduct('28','<?php echo $cat->category_id; ?>')">
                                <div style="background-image:url('<?php echo $photo; ?>'); background-size: 80px 80px; height: 80px;width: 80px;" ></div><br />
                                <?php echo $cat->category_name; ?>
                              </a>
                          <?php
                            }
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- Sales Table  -->
                  <div class='col-md-5 pad-0' >
                    <div class='box box-primary' >
                      <div class='box-header'>
                      </div><!-- /.box-header -->
                      <div class='box-body pad'>
                        <div class="input-group input-group-lg">    
                          <div class="input-group-btn">
                            <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"><i class="fa fa-pencil-square-o pad-10"  aria-hidden="true"></i></button>
                            <ul class="dropdown-menu">
                            </ul>
                          </div>
          
                          <input type="text" name="txtproduct_serialno" id="p_nm" class="form-control " value="" onblur="checkoption();" placeholder="Escriba el código"  />
                          <span class="input-group-btn">
                            <button class="btn btn-primary btn-flat" type="button" id="butcaption" onclick="toggleDiv('table_all');" >Ocultar Mesas!</button>
                          </span>
                        </div>    
                      </div>
                    </div>
          
                    <div class='box box-primary' >
                      <div class='box-body pad'>
                        <div class="form-group" id="addbutton">
                          <table id="order_products"  class="table table-bordered table-hover" border='0'>
                            <thead class="bg-blue">
                                <tr id="rowheader">
                                  <th align="center" width="25%">Nombre del Producto</th>
                                  <th align="center" width="20%">Serial No</th>
                                  <th align="center" width="15%">Rate(MRP)</th> 
                                  <th align="center" width="20%">Cantidad</th>
                                  <th align="center" width="20%">Total</th>
                                </tr>
                            </thead>
                            <tbody id="sadata">
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>

                    <div class='box box-primary' >
                      <div class="col-md-4 back-wight">
                        <div class='box-body pad'>
                            <a id="modal_editdisc" href="#changediscount" class="non" >Editar</a>
                            <div class="form-group">
                               <label>Voucher No.</label>
                                <input type="text" name="txtvoucher_no" id="voucher_no" class="form-control "  value="" />
                            </div>
                            <div class="form-group">
                                <label>Fecha del Voucher </label>
                                <input type="text" name="txtvoucher_dt" id="voucher_dt" class="form-control " value="" />
                            </div>

                              <div hidden="true" class="form-group">
                                <label>Vehiculo No.</label>
                                <input type="text" name="txtvehicle_no" id="vehicle_no" class="form-control " value="0" />
                            </div>                      
                            
                        </div>
                      </div>

                      <div class="col-md-8 back-wight">
                        <div class='box-body pad'>
                          <div class="col-md-4 back-wight">

                            <div class="form-group">
                               <label class="right-baju">Promociones</label>
                               <label class="right-baju">(0%)</label>
                               <br /><br />
                            </div>
                           
                          
                            <div class="form-group">
                                <label class="right-baju">Servicio Restaurante (%)</label><br /><br />
                            </div>
                           
                           
                           
                           
                          </div>
                          <div class="col-md-8 back-wight">
                            <div class="col-md-6 back-wight">
                              <input type="text"   name="txtsales_tax" id="sales_tax" class="form-control tax-sales-d " value="<?php echo $company[0]->sales_tax1+$company[0]->sales_tax2+$company[0]->sales_tax3; ?>" /><br />
                              
                              <input type="text" name="txtother" id="other" class="form-control "  value="" onkeyup="javascript:ser_rest();"/><br />
                            </div>
                            <div class="col-md-6 back-wight">
                              <input  hidden="true" type="text" readonly="readonly" name="txtsales_tax_value" id="grand_other_tax" class="form-control tax-sales-d " value="0" /><br />
                               <!--<input type="text" readonly="readonly" name="txtsales_tax_value" id="sales_tax_value" class="form-control tax-sales-d " value="0" /><br />-->
                             
                              <input type="text" readonly="readonly" name="txtother_value" id="other_value" class="form-control tax-sales-d" value="" /><br />
                            </div>
                           
                         
                          </div>
                        </div>
                      </div>
                       <div class="form-group">
                                <label class="left-baju">Total</label>
                                 <input type="text" readonly="readonly" name="txtgrand_total" id="grand_total" class="form-control tax-sales-d" value="0" />
                               
                            </div>

                      
                    </div>
                </div><!-- /.col-->
                
                <div class="col-md-2 info-for-bill">
                  <div class='box box-primary' >
                    <div class='box-body pad'>
                      <input type="hidden" name="pass_table_id" id="pass_table_id" value="1" />
                      <div class="input-group">    
                        <input type="text" name="typeahead"  id="skills" class="form-control" value="<?php echo $this->session->userdata('username'); ?>"  placeholder="Customer Name" >
                        <input type="hidden" id="partyidstore" value="" />
                        <span class="input-group-btn">
                          <a id="modal_addcust" href="#addcust" class="btn btn-info btn-sm own-de"><i class="fa fa-user-plus own-de-i"></i></a>
                        
                          <a onclick="editcust();" class="btn btn-info btn-sm own-de"><i class="fa fa-pencil-square own-de-i" aria-hidden="true"></i></a>
                          <a id="modal_editcust" href="#editcust" class="btn btn-info btn-sm non">Editar</a>
                        </span>
                      </div>
                      <br />
                      <div class="form-group">
                        <label>Efectivo / Tarjeta</label><br />
                          <select name="selcd_for" id="selcd_for"  class="form-control" required="required">
                            <option value="">-- Efectivo / Tarjeta --</option>
                            <option value="Cash" selected >Efectivo</option>
                            <option value="Debit">Tarjeta</option>
                          </select>
                      </div>
                    </div>
                            
                    <div class='box-body pad'>
                      <label>Consecutivo</label><br />
                      <div class="input-group"> 
                        <select name="txtbillno" id="bill_no"  class="form-control" >
                          <option value="">Selecionar consecutivor</option>
                        </select>
                        <div id="ids" class="non"></div> 
                        <span class="input-group-btn">
                          <a id="modal_addbill" href="#addbill"  class="btn btn-info btn-sm own-de"><i  class="fa fa-download own-de-i" aria-hidden="true"></i></a>
                          <a id="modal_editbill" href="#editbill" onfocus="getbillno();"  class="btn btn-info btn-sm own-de"><i class="fa fa-pencil-square own-de-i" aria-hidden="true"></i></a>
                        </span>
                      </div>
                      <br />
                      <div class="form-group">
                        <label>Fecha</label>
                        <input type="text" name="txtbilldt" id="bill_dt" class="form-control " value="<?php echo date('d/m/Y'); ?>" required readOnly />
                      </div>
                     <!-- <div class="form-group">
                        <table width="100%">
                          <tr>
                            <td><label>Descuento:</label></td>
                            <td align="right" ><a id="modal_entire_disc"  href="#entire_disc" class="btn btn-info" style="color:#FFF;">Descuento</a></td>
                          </tr>
                        </table>
                      </div>
                      -->
                                
                      <input  type="text" name="txtqty" id="qty" class="form-control non" value=""/>
                      <input  type="text" name="txtoption" id="product_option" class="form-control non " value=""/>
                      <a id="modal_qty" href="#addqty" class="btn btn-info btn-sm non">Agregar Cantidad</a>
                      <a id="modal_changeqty" href="#changeqty" class="btn btn-info btn-sm non">Cambiar Cantidad</a>
                              
                      <br />                       
                     
                       <div  class="form-group">
                                <label>Paga con:</label>
                                                             
                               <input type="text" name="txtopay" id="other_pay" class="form-control "  value="" onkeyup="javascript:change_();"/><br />
                        </div>                         
                          

                      <?php echo form_close(); ?>

                       <div class="input-group">                        
                          <span >                            
                            <input   id="modal_addpay" href="#addpay" class="btn btn-info btn-sm own-de" value="Confirmar pago"/>          
                         </span>
                      </div>           
                      <input type="hidden" name="select_order_products" id="select_order_products" />
                    </div>
                            
                    <div class="form-group">&nbsp;&nbsp;</div>
                  </div>
                </div> 
             
          </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->

<div class="alert" role="alert" id="result"></div>

    <!--  Model Start -->
        
          <div id="addqty" class="popupContainer" style="display:none;">
                <header class="popupHeader">
                  <span class="header_title">Cant Producto</span>
                  <span id="close" class="modal_close"><i class="fa fa-times"></i></span>
                </header>
                
                <section class="popupBody">
                  <!-- Social Login -->
                  <div class="social_login">
                    <div id="con">
                          Cant
                        <input type="number" name="txtqty" id="qtymodel" class="form-control " value="" min="1" max="10" onkeypress="return tabE(this,event)" placeholder="Ingrese la Cantidad..." />
            <br />
            <div id="option_print">
            </div>
            <br />
                        <input type="button" id="modelqtyidenter" name="btnsubmit" onclick="addqty();" style="margin-left:50px;" class="btn btn-primary" value="Enviar" />
                      
                    </div>
                 </div>
               </section>
             </div>
       <!-- Discount -->
       <div id="changediscount" class="popupContainer" style="display:none;">
                <header class="popupHeader">
                  <span class="header_title">Descuento</span>
                  <span id="close" class="modal_close"><i class="fa fa-times"></i></span>
                </header>
                
                <section class="popupBody">
                  <!-- Social Login -->
                  <div class="social_login">
                    <div class="">
                        Descuento en  %
                          <input type="text" name="txtdisc" id="discmodel" class="form-control " value="" onkeyup="datachange(this.value)" placeholder="Ingrese el descuento del producto..." />
                          Descuento en : """
                          <input type="text" class="form-control" name="txtdiscr" id="discrupee" value= "" onkeyup="datachangerupee(this.value)" placeholder="Ingrese el descuento del producto..."/>
                          <br />
                          <input type="button" name="btnsubmit" onclick="editpurchasedisc();" style="margin-left:50px;" class="btn btn-primary" value="Enviar" />
                      
                    </div>
                 </div>
               </section>
             </div>
             
             <div id="entire_disc" class="popupContainer" style="display:none;">
                <header class="popupHeader">
                  <span class="header_title">Descuento completo de facturas</span>
                  <span id="close" class="modal_close"><i class="fa fa-times"></i></span>
                </header>
                
                <section class="popupBody">
                  <!-- Social Login -->
                  <div class="social_login">
                    <div class="">
                        Descuento
                          <input  type="text" class="form-control" name="txtentiredisc" id="txtentiredisc" value= "" onkeypress='return isNumberKey(event)' placeholder="Ingrese el descuento..."/>
                          <br />
                          <input type="button" name="btnsubmit" id="btnentiresale" onclick="setentriedisc();" style="margin-left:50px;" class="btn btn-primary" value="Enviar" />
                    </div>
                </div>
               </section>
             </div>
           <!-- Discount -->  
             <div id="changeqty" class="popupContainer" style="display:none;">
                <header class="popupHeader">
                  <span class="header_title">Cambiar cantidad de producto</span>
                  <span id="closepq" class="modal_close"><i class="fa fa-times"></i></span>
                </header>
                
                <section class="popupBody">
                  <!-- Social Login -->
                  <div class="social_login">
                    <div class="">
                          Cant
                        <input type="number" name="txtqty" id="qtymodelchange" class="form-control " onkeypress="return tabEa(this,event)" value="" min="1" max=""  onkeyup="this.value = minmax(this.value, 1)" placeholder="INgrese cantidad del producto..." />
                        <input type="hidden" class="form-control" id="deleterowid" value= "" />
                        <br />
                        <input type="button" id="mmmmm" name="btnsubmit" onclick="changeqty();" style="margin-left:50px;" class="btn btn-primary" value="Enviar" />
                      
                    </div>
                 </div>
               </section>
             </div>
             
             
             <div id="addbill" class="popupContainer" style="display:none;">
                <header class="popupHeader">
                  <span class="header_title">Agregar número de factura</span>
                  <span id="close" class="modal_close"><i class="fa fa-times"></i></span>
                </header>
                
                <section class="popupBody">
                  <!-- Social Login -->
                  <div class="social_login">
                    <div class="">
                          Agregar número de factura
                          <input type="text" name="txtbllnm" id="billaddmodel" class="form-control " value=""   placeholder="Ingrese el número de factura ..." />
                          <br />
                          <input type="button" name="btnsubmit" onclick="addbillnumber();" style="margin-left:25px;" class="btn btn-primary" value="Enviar" />
                    </div>
                 </div>
               </section>
             </div>
             
             <div id="editbill" class="popupContainer" style="display:none;">
                <header class="popupHeader">
                  <span class="header_title">Editar número de factura</span>
                  <span id="close" class="modal_close"><i class="fa fa-times"></i></span>
                </header>
                
                <section class="popupBody">
                  <!-- Social Login -->
                  <div class="social_login">
                    <div class="">
                          Cambiar el número de Factura
                          <input type="text" name="txtbillnm" id="billeditmodel" class="form-control " value=""   placeholder="Ingrese el número de factura..." />
                          <br />
                          <input type="button" name="btnsubmit" onclick="editbillnumber();" style="margin-left:25px;" class="btn btn-primary" value="Enviar" />
                    </div>
                 </div>
               </section>
             </div>



               <div id="addpay" class="popupContainer" style="display:none;">
                <header class="popupHeader">
                  <span class="header_title">Confirmar Pago</span>
                  <span id="close" class="modal_close"><i class="fa fa-times"></i></span>
                </header>
                
                <section class="popupBody">
                  <!-- Social Login -->
                  <div class="social_login">
                    <div class="">
                      <div  class="form-group">
                                <label>El Vuelto es:</label>
                                
                                <input type="text" readonly="readonly" name="txtchange_" id="cha_" class="form-control tax-sales-d" value="0" /><br />
                      </div>

                        
                     
                          <input type="button" name="btnsubmit" onclick="addpay();"  style="float:right;" class="btn btn-primary" value="Enviar" />
                          <input type="button" title="Cancel" value="Cancelar" class="btn btn-danger" onclick="javascript:window.location.href='<?php echo base_url().'index.php/sales/create' ?>'" />
                        
                    </div>
                 </div>
               </section>
             </div>
             
             <!-- Party Add -->

            
             
             <div id="addcust" class="popupContainer" style="display:none;">
                <header class="popupHeader">
                  <span class="header_title">Agregar Cliente</span>
                  <span id="close" class="modal_close"><i class="fa fa-times"></i></span>
                </header>
                
                <section class="popupBody">
                  <!-- Social Login -->
                  <div class="social_login">
                    <div class="">
                        
                          Nombre :
                          <input type="text" name="txtfname" id="txtfname" class="form-control validate[required]" value=""  placeholder="Nombre Completo..." required />
                           E-Mai :
                          <input type="email" name="txtemail" id="txtemail" class="form-control validate[required,custom[email]]" value=""  placeholder=" E-MAil ..." required />
                          Dirección :
                          <input type="text" name="txtadd" id="txtadd" class="form-control validate[required]" value=""  placeholder="Dirección..." required />
                          <br />
                          Cuidad:
                          <input type="text" name="txtcity" id="txtcity" class="form-control validate[required]" value=""  placeholder="Cuidad.." required />
                          <br />
                          Zipcode :
                          <input type="number" name="txtzip" id="txtzip" class="form-control validate[required]" value="0"   placeholder="Enter Zipcode..." required />
                          <br />
                          Telefono :
                          <input type="text" name="txtphno" pattern="[0-9]{10}" id="txtphno" class="form-control validate[required]" value=""  placeholder="Telefono..." required />
                          <br />
                          Otro contacto :
                          <input type="text" name="txtpname" id="txtpname" class="form-control validate[required]" value=""  placeholder="Otro contacto " required />
                          <br />
                          Telefono Contacto :
                          <input type="text" name="txtcphone" id="txtcphone" class="form-control validate[required]" value=""  placeholder=" Telefono Contacto " required />
                          <br />
                          Activo ?
                          <input type="radio" class="radio-button" name="rdois_active" id="rdois_active" value="yes" />Si
                          <input type="radio" class="radio-button" name="rdois_active" id="rdois_active" value="no" />No
                          <input type="button" name="btnsubmit" onclick="addcust();"  style="float:right;" class="btn btn-primary" value="Submit" />
                        
                    </div>
                 </div>
               </section>
             </div>
             
             <!-- Customer ADD -->
             <!-- Customer Edit -->
             
              <div id="editcust" class="popupContainer" style="display:none;">
                <header class="popupHeader">
                  <span class="header_title" >Editar Cliente</span>
                  <span id="closeparty" class="modal_close" ><i class="fa fa-times"></i></span>
                </header>
                
                <section class="popupBody">
                  <!-- Social Login -->
                  <div class="social_login">
                    <div class="">
                          
                          <input type="hidden" name="custid" id="custid" value="" />
                          Nombre :
                          <input type="text" name="txtfname" id="etxtfname" class="form-control validate[required]" value="" placeholder="Nombre Completo..." required />
                           E-Mail  :
                          <input type="email" name="txtemail" id="etxtemail" class="form-control validate[required,custom[email]]" value=""  placeholder="Enter E-MAil Address..." required />
                          Dirección :
                          <input type="text" name="txtadd" id="etxtadd" class="form-control validate[required]" value=""  placeholder="Dirección..." required />
                          <br />
                          Cuidad:
                          <input type="text" name="txtcity" id="etxtcity" class="form-control validate[required]" value=""   placeholder="Cuidad.." required />
                          <br />
                          Codigo Postal :
                          <input type="text" name="txtzip" id="etxtzip" class="form-control validate[required]" value=""   placeholder="Zipcode..." required />
                          <br />
                          Telefono :
                          <input type="text" name="txtphno"  id="etxtphno" class="form-control validate[required]" value=""  placeholder="Telefono..."  required />
                          <br />
                          Otro Contacto :
                          <input type="text" name="txtpname" id="etxtpname" class="form-control validate[required]" value=""  placeholder="Otro contacto " required />
                          <br />
                          Telefono Contacto:
                          <input type="text" name="txtcphone" id="etxtcphone" class="form-control validate[required]" value=""   placeholder=" Telefono Contacto "required />
                          <br />
                         
                         <input type="button" name="btnsubmit" onclick="editcustsubmit();"  style="float:right;" class="btn btn-primary" value="Submit" />
                        
                    </div>
                 </div>
               </section>
             </div>
             
             <!-- PCustomer Edit -->
        
        <!--  Model End -->
        
        

  </div>
  <!-- /.content-wrapper -->

  <?php // include footer FIle

 $this->load->view('admin/include/footer.php'); ?>

  <script src="<?php echo base_url(); ?>_template/js/jquery.leanModal.min.js"></script>  
  <link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>_template/css/style_model.css" />
  <script src="<?php echo base_url(); ?>_template/js/jquery.maskedinput.js"></script>  

  <link rel="stylesheet" href="<?php echo base_url(); ?>_template/css/jquery-ui.css">
  <script src="<?php echo base_url(); ?>_template/js/jquery-ui.js"></script>

  <!-- Hide Sidebar -->

<script type="text/javascript">
  $("#modal_qty").leanModal({top : 100, overlay : 0.6, closeButton: ".modal_close" });
  $("#modal_changeqty").leanModal({top : 100, overlay : 0.8, closeButton: ".modal_close" });
  //party
  $("#modal_addpay").leanModal({top : 0, overlay : 0.6, closeButton: ".modal_close" });
  $("#modal_addcust").leanModal({top : 0, overlay : 0.6, closeButton: ".modal_close" });
  $("#modal_editcust").leanModal({top : 0, overlay : 0.6, closeButton: ".modal_close" });
  
  // Bill Number //
  $("#modal_addbill").leanModal({top : 100, overlay : 0.6, closeButton: ".modal_close" });
  $("#modal_editbill").leanModal({top : 100, overlay : 0.6, closeButton: ".modal_close" });
  
  //discount
  $("#modal_editdisc").leanModal({top : 100, overlay : 0.6, closeButton: ".modal_close" });
  $("#modal_entire_disc").leanModal({top : 100, overlay : 0.6, closeButton: ".modal_close" }).click(function () {$('#txtentiredisc').focus()});
</script>

<script type="text/javascript">



$(document).ready(function(){
      $('#p_nm').focus();
      selected_bill_no(); 
  });
$(function() {

    $("#skills").autocomplete({
      source: '<?php echo base_url() ?>index.php/ajax/search_customer/index'
    });
    
    $("#m_nm").autocomplete({
      source: 'search_stock.php',
      limit : 10
    });


    $("#bandh").click();  

    var gtot =  $('#grand_total').val();
    var gtotal;
    var billnumber;
    var checkrun;
    var productamount;
    var discount;
    var product_id;
    var uniq_id;
    var product_qty;

  $("#bill_dt").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
  $("#voucher_dt").mask("99/99/9999",{placeholder:"dd/mm/yyyy"});
});


  var modalConfirm = function(callback){
  
  $("#btn-confirm").on("click", function(){
    $("#mi-modal").modal('show');
  });

  $("#modal-btn-si").on("click", function(){
    callback(true);
    $("#mi-modal").modal('hide');
  });
  
  $("#modal-btn-no").on("click", function(){
    callback(false);
    $("#mi-modal").modal('hide');
  });
};

modalConfirm(function(confirm){
  if(confirm){
    //Acciones si el usuario confirma
    $("#result").html("CONFIRMADO");
  }else{
    //Acciones si el usuario no confirma
    $("#result").html("NO CONFIRMADO");
  }
});


function toggleDiv(divId) {
    var htt = $('#butcaption').html();
    
    if(htt == 'Show Tables!')
    {
      $('#butcaption').html('Ocultar Tables!');
    }
    else
    {
      $('#butcaption').html('Ver Mesas!');
    }
  
   $("#"+divId).toggle();

}

  function productadd(serno)
  {
      $('#p_nm').val(serno);
      //$('#butcaption').click();
      checkoption();
      addproduct();
  }
  
  function selected_bill_no()
  {
   
    $.ajax({
        type: "POST",
        url: "<?php echo base_url() ?>index.php/ajax/get_sales_order_id/index",
        data: {"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>","name":"abc"}
        }).done(function( msgno ) { 
          
         if(!(msgno)== false){
            $.ajax({
                type: "GET",
                url: "<?php echo base_url() ?>index.php/ajax/get_bill_name/index",
                data: {"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>","selectedno":msgno}
              }).done(function( msg ) { 
                var msg = msg.split('|');
                $('#bill_no').html(msg[0]);
                $('#ids').append(msg[1]);
              })
          
          
            $("#btnaddprd").click(function(){
            });
          }
          else {
            $.ajax({
                url: "<?php echo base_url() ?>index.php/ajax/get_bill_name/index",
                data : {"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}
              }).done(function( msg ) { 
                  var msg = msg.split('|');
                  $('#bill_no').html(msg[0]);
                  $('#ids').append(msg[1]);
              })
          
          
            $("#btnaddprd").click(function(){
            });
          }
           
        });
        
  }
      function isNumberKey(evt)
      {
         var charCode = (evt.which) ? evt.which : event.keyCode
         if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
     if(charCode == 13)
      $('#btnentiresale').click();
     
         return true;
      }

  function changedisc(id)
  {
    uniq_id = id;
    //alert(id);
    product_id = $('#pro_'+id).val();
    discount = $('#disc_'+id).val();
    productamount = $('#aprice_'+id).val();
    //alert($('#aprice_'+id).val());
    product_qty = $('#qty_'+id).val();
    var discr = productamount * discount /100;
    if(isNaN(discr)){
      discr = 0;
    }
    $('#discmodel').val(discount);
    $('#discrupee').val(discr);
    $("#modal_editdisc").click();
  }


  function setentriedisc()
  {
    var setdisc = $("#txtentiredisc").val();
    var _orders = $('#select_order_products').val();
    //alert(setdisc);
    $('#close').click();
    if(!isNaN(setdisc)){
      //alert('hello');
      
      $.ajax({
          type: "GET",
          url: "<?php echo base_url() ?>index.php/ajax/set_data_sale_discount/index",
          data: {"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>","amt":setdisc}
          
      }).done(function( msg ) { 
          //alert(msg);
          $("#order_products").append(msg);
          $('#select_order_products').val(_orders+'-'+setdisc+',');
          var a=0;
                  
          
          if($('#grand_total').val() != ''){
            var a=parseFloat($('#grand_total').val()).toFixed(2);
          }
            var b=parseFloat(document.getElementById("p_amount_-"+setdisc).value).toFixed(2); 
            //alert(parseFloat(a) + parseFloat(b));
            gtot= parseFloat(a) + parseFloat(b); 
          document.getElementById('grand_total').value = gtot;
          
          //$('#fsubmit').click();
          
      });
    }
    
  }

  function datachange(valued){
    //alert(productamount);
    if(!(valued)==false)
    {
      valued = parseFloat(valued).toFixed(2);
      var discr = parseFloat(productamount * valued / 100).toFixed(2);
      //alert(productamount);
      $('#discrupee').val(discr);
    }
    
  }

  function datachangerupee(valuer){
    if(!(valuer)==false){
      //alert(valuer);
      var disc = parseFloat(valuer / productamount * 100).toFixed(2);
      //alert(disc);
      $('#discmodel').val(disc);
    }
  }
  function editpurchasedisc()
  {
    var dis = $('#discmodel').val();
    
    $.ajax({
        type: "POST",
        url: "change-disc.php",
        data: {"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",disc:dis,olddisc:product_id}
    }).done(function( msg ) { 
      $('#close').click();
      
      $('#disc_'+uniq_id).val(dis);
      $('#discd_'+uniq_id).html(dis);
      var ser = $('#serno'+uniq_id).val();
      var totp = product_qty * productamount
      var amount = parseFloat(totp * dis /100).toFixed(2); 
      //alert(amount);
      $('#p_amount_'+ser).val(totp - amount);
      $('#amt_'+uniq_id).html(totp - amount);
      
      
      var arramtvalue = $('input[name="select_products_amount[]"]');
      //alert(arramtvalue);
      var arrlength = arramtvalue.length;
      //alert(arrlength);
      var grandtotdisc = 0;    
      for(k=0;k< arrlength;k++)
      {
          var _sr = parseFloat(arramtvalue[k].value).toFixed(2);
          //alert(_sr);
          var grandtotdisc = parseFloat(parseFloat(grandtotdisc) + parseFloat(_sr)).toFixed(2);
          //alert(grandtotdisc);
      }
      
      $('#grand_total').val(grandtotdisc);
      
      
    })
  }
  
  function checkoption()
  { 
    
    var name = $('#p_nm').val();

    if(!(String(name)==false))
    {
        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>index.php/ajax/get_product_option_sales/index",
            data: {"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",'name':name}
        }).done(function( msg ) { 
          if(!(String(msg)== false))
          {
            //$('#qtymodel').attr('max', parseInt(msg));
            // $('#qtymodelchange').attr('max',parseInt(msg));
            $('#option_print').html(msg); 
             
              addproduct();
              
            
          }
          else
          {
            $('#p_nm').val('');
            $('#qtymodel').attr('max',0);
            $('#qtymodelchange').attr('max',0);
            $('#close').click();
            alert('Stock No disponible'); 
            
          }
        
        })
    } 
    
  }
  
  
  
  
  function minmax(value, minv) 
  {
      var maxv = document.getElementById('qtymodel').getAttribute('max');
      
      if(parseInt(value) < minv || isNaN(value)) 
          return 1; 
      else if(parseInt(value) > maxv){ 
          alert('Stock '+value+' No disponible !!');
          return maxv; 
      }
      else return value;
  }
  
  function editcustsubmit()
  {
    var reg =  /\S+@\S+\.\S+/;
    
    var id = document.getElementById('custid').value;
    var name = document.getElementById('etxtfname').value;
    var email = document.getElementById('etxtemail').value;
    var addr = document.getElementById('etxtadd').value;
    var city = document.getElementById('etxtcity').value;
    var zip = document.getElementById('etxtzip').value;
    var phno = document.getElementById('etxtphno').value;
    var conper = document.getElementById('etxtpname').value;
    var cphno = document.getElementById('etxtcphone').value;
    //var acti = document.getElementById('erdois_active').value;
    
    
    if(!(String(id)==false)){
    if(!(String(name)==false)){
      if(reg.test(email)){
        if(!(String(addr)==false)){
          if(!(String(city)==false)){
            if(!(String(zip)==false) && /^\d{1}$/.test(zip)){
              if(!(String(phno)==false) && /^\d{10}$/.test(phno)){
                if(!(String(conper)==false)){
                  if(!(String(cphno)==false) &&  /^\d{10}$/.test(cphno)){
                    
                    $.ajax({
                        type: "GET",
                        url: "<?php echo base_url() ?>index.php/ajax/edit_customer/index",
                        data: {id:id,name:name, email:email,addr:addr,city:city,zip:zip,phno:phno,conper:conper,cphno:cphno }
                    }).done(function( msg ) {
                      $("#close").click();
                      $('#skills').val('');
                      $("#skills").focus();
                      alert(msg);
                      
                      
                      
                    })
                    
                  }
                  else{
                    alert('Ingrese un telefono valido para el otro Contacto !!');
                  }
                }
                else{
                  alert('Ingrese otro contacto!!');
                }
              }
              else{
                alert('Ingrese un número de telefono Valido!!');
              }
            }
            else{
              alert('Ingrese codigo Postal !!');
            }
          }
          else {
            alert('Ingrese su Cuidad !!');
          }
        }
        else {
          alert('Ingrese su Dirección');
        }
      }
      else{
        alert('Ingrese una Dirección de corredo Valida!!');
      }
    }
    else{
      alert('Ingrese su nombre Completo !!');
    }
  }
  else
  {
    alert('Su Cambio no se efectuo !!'); 
  }
    
  }
  
  function editcust()
  {
    var cust = document.getElementById('skills').value;
    
    if(!(String(cust)==false)){
      
      $.ajax({
          type: "GET",
          url: "<?php echo base_url() ?>index.php/ajax/get_customer_id/index",
          data: {"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",'name':cust}
      }).done(function( msg ) { 
         if(!(String(msg)==false)){
            var dom = msg.split('|');
            document.getElementById('etxtfname').value = dom[0];
            document.getElementById('etxtemail').value = dom[1];
            document.getElementById('etxtadd').value = dom[2];
            document.getElementById('etxtcity').value = dom[3];
            document.getElementById('etxtzip').value = dom[4];
            document.getElementById('etxtphno').value = dom[5];
            document.getElementById('etxtpname').value = dom[6];
            document.getElementById('etxtcphone').value = dom[7];
            document.getElementById('custid').value = dom[8];
            
            document.getElementById('modal_editcust').click();
         }
         else {
           alert('Por favor ingrese o seleccione en el nombre correcto del cliente !!');
           document.getElementById('closeparty').click();
           document.getElementById('skills').value = '';
           document.getElementById('skills').focus();
           
         }
          
      })
      
    }
    else{
      alert('Por favor ingrese el nombre del Cliente');
      document.getElementById('closeparty').click();
      document.getElementById('skills').focus();
    }
    
  }

  
  function addcust()
  {
    var reg =  /\S+@\S+\.\S+/;
    
    var name = document.getElementById('txtfname').value;
    var email = document.getElementById('txtemail').value;
    var addr = document.getElementById('txtadd').value;
    var city = document.getElementById('txtcity').value;
    var zip = document.getElementById('txtzip').value;
    var phno = document.getElementById('txtphno').value;
    var conper = document.getElementById('txtpname').value;
    var cphno = document.getElementById('txtcphone').value;
    var acti = document.getElementById('rdois_active').value;
    
    if(!(String(name)==false)){
      if(reg.test(email)){
        if(!(String(addr)==false)){
          if(!(String(city)==false)){
            if(!(String(zip)==false)){
              if(!(String(phno)==false)){
                if(!(String(conper)==false)){
                  if(!(String(cphno)==false) ){
                    
                    
                    $.ajax({
                        type: "GET",
                        url: "<?php echo base_url() ?>index.php/ajax/add_customer/index",
                        data: { name:name, email:email,addr:addr,city:city,zip:zip,phno:phno,conper:conper,cphno:cphno,"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>" }
                    }).done(function( msg ) {
                      alert(msg);
                      $("#close").click();
                      $("#skills").focus();
                      
                    })
                    
                  }
                   else{
                    alert('Ingrese un telefono valido para el otro Contacto !!');
                  }
                }
                else{
                  alert('Ingrese otro contacto!!');
                }
              }
              else{
                alert('Ingrese un número de telefono Valido!!');
              }
            }
            else{
              alert('Ingrese codigo Postal !!');
            }
          }
          else {
            alert('Ingrese su Cuidad !!');
          }
        }
        else {
          alert('Ingrese su Dirección');
        }
      }
      else{
        alert('Ingrese una Dirección de corredo Valida!!');
      }
    }
    else{
      alert('Ingrese su nombre Completo !!');
    }
    
  }

   
  function addbillnumber()
  {
    
    var billname = document.getElementById('billaddmodel').value; 
    
    if( String(billname) != '')
    {
              $.ajax({
                  type: "GET",
                  url: "<?php echo base_url() ?>index.php/ajax/add_bill_name/index",
                  data: {"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",'name':billname}
              }).done(function( msg ) {
                  //$("#bill_no").append(msg);
                  $('#bill_no')
                    .find('option')
                    .remove()
                    .end()
                    .append(msg);
                  
                  var ids = msg.split('|');
                  $('#ids').html(ids);
                  
                  $("#close").click();
                  $("#bill_no").focus();
              })
    }
    else
    {
      alert('Por favor ingrese el número de factura');
      
    }
    
  }
  
  
  function getbillno()
  {
    var billname = document.getElementById('bill_no').value;  
    if(billname == '')
    {
      alert('Por favor, seleccione el número de factura !');
    }
    else
    {
      document.getElementById('billeditmodel').value = billname;  
    }
    
  }
  
  function editbillnumber()
  {
    
    var oldname = document.getElementById('bill_no').value;
    var billname = document.getElementById('billeditmodel').value;  
    var billpid = document.getElementById('billid_'+ oldname).value;
    
    if( String(billname) != '' && String(oldname) != '')
    {
              
              $.ajax({
                  type: "GET",
                  url: "<?php echo base_url() ?>index.php/ajax/edit_bill_name/index",
                  data: { name:billname, oldname:oldname,billpid:billpid ,"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>"}
              }).done(function( msg ) {
                  
                  $("#close").click();
                  $('#bill_no')
                    .find('option')
                    .remove()
                    .end()
                    .append(msg);
                  var ids = msg.split('|');;
                  $('#ids').html(ids);
                    
              })
    }
    else
    {
      alert('Por favor, seleccione el número de factura');
      
    }
    
  }


  function addqty(){
    $('#close').click();
    var q = parseInt(document.getElementById('qty').value = document.getElementById('qtymodel').value);
    var check_option = $("input:radio:checked").val();
    //var check_option = $("#myform input[type='radio']:checked").val();document.getElementByName('option').value;
    
    var po = parseInt(document.getElementById('product_option').value = check_option);
    if(!(String(q)==false) && q > 0)
    {
      addproduct();
    }
    else
    {
      alert('Ingrese la Cantidad !.');
      $('#modal_qty').click();  
      $('#qtymodel').focus();
    }
  }
  
  function changeqty(){
    $('#closepq').click();
    var q = parseInt(document.getElementById('qty').value = document.getElementById('qtymodelchange').value);
    if(!(String(q)==false) && q > 0)
    {
          var id = document.getElementById('deleterowid').value;
          
          var tot = parseInt($('#grand_total').val());
          var totl = parseInt(id);
          var text = parseInt(document.getElementById('sales_tax_value').value);
          var x=parseInt($('#sales_tax').val());
          var y = totl;
          var s_tax=parseInt(x * y/100);
          var tax = parseInt(text - s_tax);
      //alert( "text="+text+'tot='+tot+'totl='+totl +'text='+s_tax+'tax='+tax);
      document.getElementById('sales_tax_value').value = tax;
      var total = tot-totl- s_tax;
      document.getElementById('grand_total').value = total;
          
          var valueproduct = $('#select_order_products').val();
          var deleteser = $('#serno'+id).val();
          
          deleteser = deleteser+',';
           
          var newproduct =  valueproduct.replace(deleteser,'');
          $('#select_order_products').val(newproduct);
          
          $('#row_'+id).remove();
          
      addproduct();
    }
    else
    {
      $('#closepq').click();
      alert('Ingrese la cantidad!.');
      $('#modal_changeqty').click();  
      $('#qtymodel').focus();
    }
  }


  function multi_qr()
  {
    var q=$('#qty').val();
    var r=$('#rate').val(); 
    var tot=q*r;
    document.getElementById('p_amount').value = tot;
  }



  //redirecciona el form
function addpay(frm)
  {
    //recibe el id del form
       document.forms['frm'].submit();
    
  }
  //Calculo el vuelto 
  function change_()
  {
    var p_value=parseFloat($('#other_pay').val()); 
    var grand_total= parseFloat($('#grand_total').val());  
    var gt=gtot;    
    var total_otax=p_value-grand_total;
     //alert (total_otax);
    document.getElementById('cha_').value = total_otax;    
   }

  //Calculo el % del servicio de Restaurante y el grantotal
  function ser_rest()
  {
    var o = parseFloat($('#other').val()); 
    var gt=gtot;
    
    var total_o=o*gt/100;
    document.getElementById('other_value').value = total_o;    

    var other=parseFloat($('#other_value').val());
    //var total_value=parseFloat($('#grand_total').val());  
    var total_value=gtot;
    //alert(sales_tax+'||'+other_tax+'||'+other+'||'+total_value);
    var grand_total = (parseFloat(other)+parseFloat(total_value));
    document.getElementById('grand_total').value = grand_total;
  
  }
  
  function addproduct(){  
    
    var _qty =  parseInt($("#qty").val());
    var _option_p =  parseInt($("#product_option").val());

    if(!(String(_qty)==false) && _qty > 0)
    {
    
    var _orders = $('#select_order_products').val();
    var _btno = $('#b_no').val();
    var _qty = parseInt($("#qty").val());
    var _rt = parseInt($('#rate').val());
    var _pid = $("#p_nm").val();
    var _kg = $("#selkg_for").val();
    
    
    
    //alert (_kg);
    //var _amt = parseInt($("#p_amount").val());
    
    
      if(!(String(_pid)==false)){
          if (!(String(_qty)==false) && _qty > 0){  
              document.getElementById('p_nm').value = ''; 
              document.getElementById('qty').value = '';
              document.getElementById('qtymodel').value = '';
              $("#modal_qty").leanModal({top : 100, overlay : 0.6, closeButton: ".modal_close" });
              
              
              $.ajax({
                  type: "GET",
                  url: "<?php echo base_url() ?>index.php/ajax/get_product_data_sale/index",
                  data: 'btno='+_btno+'&qty='+_qty+'&pid='+_pid+'&option_p='+_option_p+"&<?php echo $this->security->get_csrf_token_name(); ?>=<?php echo $this->security->get_csrf_hash(); ?>"
              }).done(function( msg ) { 
                  $("#sadata").append(msg);
                  $('#select_order_products').val(_orders+_pid+',');
                  
                  // Grand Total
                  var a=0;
                  
                  
                  if($('#grand_total').val() != ''){
                    var a=parseFloat($('#grand_total').val()).toFixed(2);
                  }
                  var b=parseFloat(document.getElementById("p_amount_"+_pid+'_'+_option_p+'_'+_qty).value).toFixed(2); 
                  //alert(a+'||'+b);
                  gtot= parseFloat(a) + parseFloat(b); 
                  
                  document.getElementById('grand_total').value = gtot;
                  
                  //sales tax
                  var x=0;
                  if($('#sales_tax').val() != ''){
                    var x=parseInt($('#sales_tax').val());
                  }
                  
                  var y=gtot; 
                  var s_tax=parseFloat(x * b/100);
                  //alert(s_tax);
                  var oldsel = parseFloat(document.getElementById('sales_tax_value').value);
                  var mehul = parseFloat(oldsel+s_tax).toFixed(2);
                  //alert(oldsel + "|"+ s_tax+"|"+mehul);
                  if(isNaN(mehul))
                  {
                    //alert('ya');
                    mehul = 0;

                  }
                  //alert(mehul);
                  document.getElementById('sales_tax_value').value = mehul;
                  
                  var gtotal = gtot + s_tax;
                  gtotal = document.getElementById('grand_total').value = parseFloat(gtotal).toFixed(2);
                  
                  $('#modal_entire_disc').css('pointer-events', 'auto');
                  
                  $('#ajaxloader').html('');
                  document.getElementById('bill_no').readOnly = true;
                  
                  
                  document.getElementById('p_nm').focus();
                  
              })
              
            
          }
          else{
            alert('Por favor, inserte la cantidad !'); 
          }
        
      }
      else{
        alert('POr favor, seleccione el Producto !'); 
        
      }
      
    
    
    
    }
    else
    {
      $('#modal_qty').click();
      $('#qtymodel').focus();
    }
    
    //$('#b_no').value = ('');


  }
  
  function deleteprd(id){  
    if(confirm('Esta seguro que desea eliminar este producto?')){
      //var _orders = $('#select_order_products').val();
      //_orders = _orders.replace(id+',','');
      //$('#select_order_products').val(_orders);
      
      var tot = parseFloat($('#grand_total').val()).toFixed(2);
      var totl = parseFloat(id).toFixed(2);
      var text = parseFloat(document.getElementById('sales_tax_value').value).toFixed(2);
      var x=parseFloat($('#sales_tax').val()).toFixed(2);
      var y = totl;
      var s_tax=parseFloat(x * y/100).toFixed(2);
      var tax = parseFloat(text - s_tax).toFixed(2);
      //alert( "text="+text+'tot='+tot+'totl='+totl +'text='+s_tax+'tax='+tax);
      document.getElementById('sales_tax_value').value = tax;
      var total = parseFloat(tot)-parseFloat(totl)- parseFloat(s_tax);
      document.getElementById('grand_total').value = total;
      
      var valueproduct = $('#select_order_products').val();
      var deleteser = $('#serno'+id.replace('.','_')).val();
      
      deleteser = deleteser+',';
      
      var newproduct =  valueproduct.replace(deleteser,'');
      $('#select_order_products').val(newproduct);
      
      
      //var x=parseInt($('#sales_tax').val());
//      var y=total; 
//      var s_tax=x * y/100;
//      document.getElementById('sales_tax_value').value = s_tax;
      //alert('row_'+id.replace('.','_'));
      $('#row_'+id.replace('.','_')).remove();
      $('#p_nm').focus();
      return false;

    }
    else{
      return false;
    }
  }
  function changetotal(id){
    var _qty = parseInt($('#select_order_products_qty_'+id).val());
    var _price = parseInt($('#rs_'+id).html());
    var _total = 0;
    if(_qty > 0){
      _total = (_qty * _price);
      $('#total_rs_'+id).html(parseInt(_total));
    }
  }

  function selectBill(table)
  {
    var old_table = table;
    $("#pass_table_id").val(table);
    
    var s_no = document.getElementsByName("select_order_serialno[]");
    var s_rate = document.getElementsByName("select_order_products_rate[]");
    var s_qty = document.getElementsByName("select_products_qty[]");
    var s_p_option = document.getElementsByName("select_products_option[]");
    var s_amount = document.getElementsByName("select_products_amount[]");
    var s_n = [];
    for (i = 0; i < s_no.length; i++) {
      var s = s_no[i].value;
      s_n.push(s);
    }
    
    var s_r = [];
    for (i = 0; i < s_rate.length; i++) {
      var r = s_rate[i].value;
      s_r.push(r);
    }
    
    var s_q = [];
    for (i = 0; i < s_qty.length; i++) {
      var q = s_qty[i].value;
      s_q.push(q);
    }
    
    var s_o = [];
    for (i = 0; i < s_p_option.length; i++) {
      var s = s_p_option[i].value;
      s_o.push(s);
    }
    
    var s_a = [];
    for (i = 0; i < s_amount.length; i++) {
      var s = s_amount[i].value;
      s_a.push(s);
    }
    
    //alert(s_n.toString());
    $.ajax({
      
         type: "GET",
         data: {"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",'table_no':table,'s_no':JSON.stringify(s_n),'s_rate':JSON.stringify(s_r),'s_qty':JSON.stringify(s_q),'s_p_option':JSON.stringify(s_o),'s_amount':JSON.stringify(s_a)},
         url: "<?php echo base_url() ?>index.php/ajax/Store_tmp_data/index",
         success: function(msg){
          //alert(msg);  
          var output = msg.split('||');
          $("#sadata").html(output[0]);
          //document.getElementById("sadata").innerHTML = output[0];
          $('#select_order_products').val(output[2]);
          $('#grand_total').val(output[1]);
          
          $("#table_all").load(location.href+" #table_all");
          selected_bill_no(); 
       }
    });
    
  }

   function tabE(obj, e) { 
        var e = (typeof event != 'undefined') ? window.event : e; // IE : Moz 
        
        
        if (e.keyCode == 13) { 
            
            document.getElementById('modelqtyidenter').focus();
            document.getElementById('modelqtyidenter').click();
            return false;
        }
    }
    
    function tabEa(obj, e) { 
        var e = (typeof event != 'undefined') ? window.event : e; // IE : Moz 
        
        
        if (e.keyCode == 13) { 
            
            document.getElementById('mmmmm').focus();
            return false;
        }
    }

  function stopform(){
      // Retrieve the code
      var t = String(document.getElementById('p_nm').value);  
      if(String(t) != '')
      {
        //alert('wrong');
        checkrun = 'yes';
        addproduct();
        //document.getElementById('bill_no').readOnly = true;
        return false;
      }
      else 
      {
        return true;
      }
}

// get sub category
  function getsubcategory(id)
  {
        $('#rhead').html("<a onclick='getsubcategory(28)'> <?php echo $company[0]->company_name ?></a>");
        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>index.php/ajax/getsubcategory/index",
            data: {"<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",'id':id}
        }).done(function( msg ) { 
            $('#gridbox').html(msg);
        })
  }

//get product
  function getproduct(cid,subid)
  {     
        var catname = $('#subcatname_'+subid).text();
        $('#rhead').append("  <i class='fa fa-hand-o-right' style='color:#00C0EF'></i>"+ catname +"");
        $.ajax({
            type: "GET",
            url: "<?php echo base_url() ?>index.php/ajax/getproduct/index",
            data: { "<?php echo $this->security->get_csrf_token_name(); ?>":"<?php echo $this->security->get_csrf_hash(); ?>",cid : cid,subid:subid}
        }).done(function( msg ) {
          
            $('#gridbox').html(msg);
        })
  }

  function showcategory()
  { 
      $('#rhead').html("<a onclick='showcategory()'><?php echo $company[0]->company_name ?></a>");
      $.ajax({
            type: "POST",
            url: "show-category.php"
        }).done(function( msg ) {
          
            $('#gridbox').html(msg);
        })
  }
</script>
