<!-- POS Bill Print -->
<link rel="stylesheet" href="<?php echo base_url(); ?>_template/css/invoice-bill.css" />
<style>
@media print
{
	#non-printable { display: none; }
	div.page-break { display: block; page-break-before: always; 
}
</style>

<style media="print">
 @page {
  size: auto;
  margin: 0;
       }
</style>
<?php
	$order_no = $this->uri->segment(3);

$CI =& get_instance();
$company = $CI->get_company_data(); 
$bill_number = $CI->get_bill_number($order_no);
$bill_date = $CI->get_bill_date($order_no);
$bill_date = date("d-m-Y", strtotime($bill_date));

	$CI =& get_instance();
	$grand = $CI->get_grand_value($order_no);
	 
	if(!empty($grand))
	{
		$s_t=$grand['grand_sales_tax'];
		$s_t_v=$grand['grand_sales_tax_value'];
		$o_t=$grand['grand_other_tax'];
		$o_t_v=$grand['grand_other_tax_value'];
		$o=$grand['grand_other'];
		$o_v=$grand['grand_other_value'];
		$grand_tot=$grand['grand_total'];
		$sub_tot=$grand_tot-$s_t_v-$o_t_v-$o_v;
		
	}

?>

<div id="ctl00_divContainer" class="print_container">
            

<div class="invoice_container">
    
    <?php if($company[0]->company_image != '' && $company[0]->recipe_print == 'yes'){ 
				$logo = 'file/company/'.$company[0]->company_image;
				
				if (file_exists($logo) ) {
				?>
                <div class="logo" style="width:50%;float:left;">
                	<img id="ctl00_content_InvoiceMini1_imgLogo" src="<?php echo base_url().$logo; ?>" style="border-width:0px; height:82px;width:84px;" />
                </div>
                <div style="width:50%;float:right;">
                    <h1 class="invoiceHeader"><?php echo $company[0]->company_name; ?></h1>
                </div>
                
                <?php
				}
	      }		
	?>
       
    <?php if($company[0]->recipe_print != 'yes'){ ?>
    <h1 class="invoiceHeader">
        <?php echo $company[0]->company_name; ?></h1>

	<?php } ?>
    <p id="ctl00_content_InvoiceMini1_pAddress" class="address">
        <?php echo strip_tags($company[0]->company_address); ?>, <?php echo htmlspecialchars($company[0]->company_city); ?>.<br />PH. <?php echo htmlspecialchars($company[0]->company_phone); ?>
    </p>
    

    <div class="dotseparator"></div>

    <h2 id="ctl00_content_InvoiceMini1_lblInvoiceNumber">Invoice #<?php echo $order_no; ?></h2>
    <p id="ctl00_content_InvoiceMini1_pOrderDateTime" class="orderDateTime">
        
    </p>

    <p id="ctl00_content_InvoiceMini1_pInvDate" class="invDate">
       <?php echo $bill_date; ?>
    </p>
	<div class="dotseparator"></div>
	
	<p class="invDate" style="padding-left:18px;">TOTAL</p>
	<p class="invDate" style="padding-left:10px;">UNIT</p>
	<p class="invDate">QTY &nbsp; X &nbsp; Rate</p>
	<p class="invDate" style="padding-right:55px;">Name</p>
    
        <section class="cart-mini-items">
    		<?php 
					$totalQTY = 0;
					$save = 0;
					 foreach( $order as $_order ) {
						 
						$oprow = $CI->get_product_option_bill($_order->product_option_id);
							 
							$option_name = $oprow['option_name']; 
							
							if($option_name == '250 GM' OR $option_name == '500 GM')
							{
								$option_name = substr($option_name,0,3)/1000 .'K';
							}
						 
						if($_order->purchase_item_name != 'Discount') {
						 ?>
             
             <div>
             	<p style="width:100px;font-size:13px;"><?php echo substr($_order->purchase_item_name,0,12); ?></p>
              <mark></mark>
               <div style="margin-top: -30px;padding-bottom:0px;font-size:15px;" >
                <small style="font-size:13px;"><?php echo $_order->purchase_item_qty; ?>&nbsp;X&nbsp; <?php echo $_order->purchase_item_rate; ?></small>
                <?php $disc = $_order->purchase_item_qty * $_order->purchase_item_rate;  $totalQTY += $_order->purchase_item_qty; ?>
                <i><?php echo $option_name; $savep = floatval($disc - $_order->purchase_total); ?></i>
                <?php $save += $savep; ?>
                <span style="font-size:13px;"><?php echo $_order->purchase_total; ?></span>
               </div>
             </div>
             
             <?php
						}
						else
						{
							?>
							<div>
								<p style="width:100px;font-size:13px;"><?php echo substr($_order->purchase_item_name,0,10); ?></p>
							  <mark></mark>
							   <div style="margin-top: -30px;padding-bottom:0px;font-size:15px;" >
								<small style="font-size:13px;"></small>
								
								<i></i>
								<?php $save -= $_order->purchase_total; ?>
								<span style="font-size:13px;"><?php echo $_order->purchase_total; ?></span>
							   </div>
							 </div>
							<?php
						}
					 }
				
				?>
        
    </section>
        
    

    <div class="cartAmount">
        
<table class="rightAuto" cellpadding="0" cellspacing="0">

    <tr><th><?php echo $totalQTY; ?>&nbsp;&nbsp;Amount</th><td class='sep'>:</td><td class='currency'></td><td style=''><?php echo $grand_tot; ?></td></tr>

</table>


    </div>
    <div id="ctl00_content_InvoiceMini1_cartAmountSeparator" class="dotseparator"></div>
    <div class="section">

        
        <div id="ctl00_content_InvoiceMini1_sectionPayment" class="section_content_right">
            Payment<div style="font-weight: normal;">
               
            </div>
        </div>
    </div>
    <div class="extra">
        
        
        
    </div>
    <div id="ctl00_content_InvoiceMini1_divNote" class="note"><p style="text-align:center;font-weight:700;font-size:15px;"><strong>You Save  <?php echo abs($save); ?></strong></p>

<footer>We Thank You For Your Purchase</footer></div>
    <small id="ctl00_content_InvoiceMini1_lblCreated" class="timestamp"><?php echo date('d M Y H:i'); ?></small>
</div>


        </div>


<br /><br />
<div class="page-break" ></div>
<div id="non-printable">
	<center>
  	<a href="" onclick="printDiv()">Print</a>
    <a href="<?php echo base_url(); ?>index.php/sales" class="">Sales</a>
  </center>
</div>
<script>

window.onload = printDiv();

function printDiv() {
    
	window.print();
}
</script>
