<?php 

$CI =& get_instance();
$company = $CI->get_company_data(); 
$cust = $CI->get_customer($order[0]->purchase_party_name);
$order_billdt = $order[0]->entry_date;

    $party_id=$cust['customer_id'];
    $party_name = $cust['customer_first_name'];
	$address=$cust['customer_address'];
	$city=$cust['customer_city'];
	$zipcode=$cust['customer_zipcode'];
	$mobile=$cust['customer_phone'];
	$email=$cust['customer_email'];
	


$order_cd = $order[0]->purchase_cd;

$grand = $CI->get_grand_value($order[0]->purchase_no);

    $s_t=$grand['grand_sales_tax'];
	$s_t_v=$grand['grand_sales_tax_value'];
	$o_t=$grand['grand_other_tax'];
	$o_t_v=$grand['grand_other_tax_value'];
	$o=$grand['grand_other'];
	$o_v=$grand['grand_other_value'];
	$grand_tot=$grand['grand_total'];
	$sub_tot=$grand_tot-$s_t_v-$o_t_v-$o_v;
	


//exit;


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>


<title>Sales Order Information</title>

<!-- Bootstrap 3.3.5 -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/bootstrap/css/bootstrap.min.css">
<!-- font Awesome -->
<link href="<?php echo base_url(); ?>_template/bootstrap/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
<!-- Ionicons -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/bootstrap/css/ionicons.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/dist/css/AdminLTE.min.css">


</head>

<body>

<!-- Main content -->
<section class="content invoice">                    
    <!-- title row -->
    <div class="row">
        <div class="col-xs-12" style="background-color:#DEDEDE;">
            <h2 class="page-header">
                <i class="fa fa-globe"></i> <?php echo htmlspecialchars($company[0]->company_name); ?> - Factura de Venta
                <small class="pull-right">Fecha: <?php echo  date("d-m-Y", strtotime($order_billdt)); ?></small>
            </h2>                            
        </div><!-- /.col -->
    </div>
    <!-- info row -->
    <div class="row invoice-info">
        <div class="col-sm-4 invoice-col">
            De:
            <address>
                <strong><?php echo htmlspecialchars($company[0]->company_name); ?></strong><br>
                 <?php echo strip_tags($company[0]->company_address); ?>,<br>
                <?php echo htmlspecialchars($company[0]->company_city); ?><br><br>
                <strong>Contact No.<?php echo htmlspecialchars($company[0]->company_phone); ?><br/>
                </strong>
            </address>
            
        </div><!-- /.col -->
        <div class="col-sm-4 invoice-col">
            Para:
            <address>
                <strong><?php echo $party_name; ?></strong><br>
                <?php echo nl2br(htmlspecialchars($address)); ?><br>
                <?php echo htmlspecialchars($city); ?><br>
                <?php echo htmlspecialchars($zipcode); ?>
                
            </address>
            
        </div><!-- /.col -->
        <?php 
					$order_status = '';
					if ( $order[0]->purchase_status == 'active' ) {
						
						$order_status = 'Aceptada';	
					}
					if ( $order[0]->purchase_status == 'diactive' ) {
						
						$order_status = 'Pendiente';	
					}
					
				?>
        <div class="col-sm-4 invoice-col">
            <!--<b>Invoice #0<?php echo substr(str_shuffle("0123456789"), 0, 5); ?></b><br/>-->
            <br/>
            <b>Orden ID:</b> <?php echo $order[0]->purchase_no; ?><br/>
            <b>Voucher No:</b> <?php echo $order[0]->voucher_no; ?><br/>
            <b>Fecha Voucher :</b> <?php echo $order[0]->voucher_date; ?><br/>
            <b>Vehiculo No:</b> <?php echo $order[0]->vehicle_no; ?><br/>
            <b>Status :</b> <?php echo $order_status; ?>
        </div><!-- /.col -->
    </div><!-- /.row -->

    <!-- Table row -->
    <div class="row">
        <div class="col-xs-12 table-responsive">
        <strong class="lead">Descripción de Producto&nbsp;&nbsp;:&nbsp;&nbsp;</strong>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th width="25%">Nombre Producto</th>
                        <th width="15%">Batch No.</th>
                        <th width="14%">Precio)</th>
                        <th width="10%">Cant</th>
                        
                        <th width="14%">Subtotal</th>
                    </tr>                                    
                </thead>
                <tbody>
				<?php 
                $discount = 0;
                $c = 0;
                $total_desc = 0;
                $tax_total_price1 = 0;
                $tax_total_price2 = 0;
                $tax_total_price3 = 0;
                $subtotal = 0;
                foreach( $order as $_order ) 
				{                        
                       
                    $item_total = $_order->purchase_item_rate ;
                
                    if($_order->purchase_item_name != "Discount")
                    {
                        $item_total_price = ($item_total * $_order->purchase_item_qty+ $discount); 
                        
                        $item_tax_price1 = ($item_total_price * $company[0]->sales_tax1 / 100);
                        $item_tax_price2 = ($item_total_price * $company[0]->sales_tax2 / 100);
                        $item_tax_price3 = ($item_total_price * $company[0]->sales_tax3 / 100);
                        
                        $total_tax = $item_tax_price1 +$item_tax_price2 + $item_tax_price3;
                        
                        $tax_total_price1 += $item_tax_price1;
                        $tax_total_price2 += $item_tax_price2;
                        $tax_total_price3 += $item_tax_price3;
                        
                        $tax = $company[0]->sales_tax1+$company[0]->sales_tax2+$company[0]->sales_tax3;
                        $i_t = (($item_total+ $discount) * $tax /100);
                        $i_sp = $item_total_price - $total_tax;
                        $subtotal +=$i_sp; 
                        $i_p =  $item_total - $i_t;
                        $i_p += $discount ;     
                        
                        $i_p -=$discount;
                        $i_sp -=$discount;   
                     
                    ?>
                        <tr>
                          <td><?php echo $_order->purchase_item_name; ?></td>
                          <td><?php echo $_order->purchase_batch_no; ?></td>
                          <td><?php echo number_format($i_p,2); ?></td>
                          <td><?php echo $_order->purchase_item_qty; ?> &nbsp;&nbsp;(&nbsp;<?php echo $_order->purchase_item_kg; ?>&nbsp;)</td>
                          <td><?php echo number_format($i_sp,2); ?></td>
                       </tr>
                    <?php 
                    }
                    else
                    {
                        $total_desc+=$_order->purchase_item_kg;
                        ?>
                        <tr>
                          <td><?php echo $_order->purchase_item_name; ?></td>
                          <td><?php echo $_order->purchase_batch_no; ?></td>
                          <td><?php echo number_format($_order->purchase_item_rate,2); ?></td>
                          <td><?php echo $_order->purchase_item_qty; ?> &nbsp;&nbsp;(&nbsp;<?php echo $_order->purchase_item_kg; ?>&nbsp;)</td>
                          <td><?php echo number_format($_order->purchase_total,2); ?></td>
                        </tr>
                        <?php
                    }
                    ?>      
				<?php
      			}
                ?> 
                    
                    
                </tbody>
            </table>                            
        </div><!-- /.col -->
    </div><!-- /.row -->

    <div class="row">
        <!-- accepted payments column -->
        <div class="col-xs-6">
            
            <strong class="lead">Payment Methods&nbsp;&nbsp;:&nbsp;&nbsp;<?php echo $order_cd; ?></strong>
            <p></p>
            
                <table border="0" width="100%">
                  <tr>
                	<th colspan="2" style="background-color:#DEDEDE;"><h4>Party Information</h4></th>
                  </tr>
                  <tr>
                  	<td><strong>Party Name</strong></td>
                    <td>:&nbsp;&nbsp;<?php echo htmlspecialchars($party_name); ?></td>
                  </tr>
                  <tr>
                  	<td><strong>Phone No</strong></td>
                    <td>:&nbsp;&nbsp;<?php echo htmlspecialchars($mobile); ?></td>
                  </tr>
                  <tr>
                  	<td><strong>Email</strong></td>
                    <td>:&nbsp;&nbsp;<?php echo htmlspecialchars($email); ?></td>
                  </tr>
                  <tr>
                  	<td><strong>City</strong></td>
                    <td>:&nbsp;&nbsp;<?php echo htmlspecialchars($city); ?></td>
                  </tr>
                  
                  
                  <tr>
                  	<td><strong>Zipcode</strong></td>
                    <td>:&nbsp;&nbsp;<?php echo htmlspecialchars($zipcode); ?></td>
                  </tr>
                </table>
                
            
        </div><!-- /.col -->
        <div class="col-xs-6">
            <p class="lead">Bill Date : </p>
            <div class="table-responsive">
                <table class="table">
                    <tr>
                        <th>Sub Total :</th>
                        <td>Rs.<?php echo number_format($subtotal,2); ?></td>
                    </tr>
                    <tr>
                        <th>Sales Tax (<?php echo number_format($company[0]->sales_tax1,2); ?> %):</th>
                        <td>Rs.<?php echo number_format($tax_total_price1,2); ?></td>
                    </tr>
                    <tr>
                        <th>Other Tax (<?php echo number_format($company[0]->sales_tax2,2); ?> %):</th>
                        <td>Rs.<?php echo number_format($tax_total_price2,2); ?></td>
                    </tr>
                    <tr>
                        <th>Other (<?php echo number_format($company[0]->sales_tax3,2); ?> %):</th>
                        <td>Rs.<?php echo number_format($tax_total_price3,2); ?></td>
                    </tr>
                    <tr style="background-color:#F4F4F4;">
                        <th>Grand Total:</th>
                        <td>Rs.<?php echo number_format($grand_tot,2); ?></td>
                    </tr>
                </table>
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
		<br /><br />
    <!-- this row will not appear when printing -->
    <div class="row no-print">
        <div class="col-xs-12">
        		<p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                <strong style="color:#C00;">Terms And Conditions :</strong><br />
                Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
            </p>
            <button class="btn btn-default pull-right" onclick="window.print();"><i class="fa fa-print"></i> Print</button>
            
        </div>
    </div>
</section><!-- /.content -->



</body>

</html>
