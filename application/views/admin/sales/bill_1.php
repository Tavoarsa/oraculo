<?php

$order_no = $this->uri->segment(4);

$CI =& get_instance();
$grand = $CI->get_grand_value($order_no);
$company = $CI->get_company_data(); 
$bill_number = $CI->get_bill_number($order_no);
$bill_date = $CI->get_bill_date($order_no);

$bill_date = date("d-m-Y", strtotime($bill_date));

$company_terms = array();
$company_terms =explode(',',$company[0]->company_terms);
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

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Bistró 77');
$pdf->SetTitle('Bistró 77 PDF');
$pdf->SetSubject('Factura');

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set font
$pdf->SetFont("Arial", "B",8);

// add a page
$pdf->AddPage();
$output = '';
// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content

	$output .= '
	
	<table width="100%">
			<tr align="right">
				<td height="20">[ x ] Original / [ ] Copia</td>
			</tr>
  </table>
   
	<table width="100%" border="1"> 
			<tr align="left">
      	<td width="75%"><h1>'. $company[0]->company_name.'</h1>&nbsp;'.$company[0]->company_address.$company[0]->company_city.'<br />&nbsp;Teléfono  :'.$company[0]->company_phone.'</td>
				<td rowspan="2" width="25%">
					
					<table width="100%">
						
						<tr bgcolor="#CCC" align="center">
            	<td colspan="3"><h3>DEBITO</h3></td>
            </tr>
						<tr><td colspan="3"></td></tr>
						<tr>
							<td width="55%"><h3> FACTURA No</h3></td>
							<td width="5%">:</td>
							<td width="40%">'.$bill_number.'</td>
						</tr>
						<tr>
							<td width="55%"><h3>FECHA</h3></td>
							<td width="5%">:</td>
							<td width="40%">'.$bill_date.'</td>
						</tr>
						<tr>
							<td width="55%"><h3>EXPRESS</h3></td>
							<td width="5%">:</td>
							<td width="40%"></td>
						</tr>
						<tr><td colspan="3"></td></tr>
					</table>
				
				</td>
      </tr>
      <tr align="left">
      	<td height="25"></td>
      </tr>
	</table> 
    <table style="border:1px solid black;" width="100%">
    	<tr>
      	<td height="20" align="center"><h3>Detalle </h3> </td>
			</tr>	
    </table>
    
    <table style="border:1px solid black;" width="100%" >
      <tr>
        <th style="width:7%;border:1px solid black;" align="right"><h3>.</h3></th>
        <th style="width:48%;border:1px solid black;" align="left"><h3>Descripción</h3></th>
        
        <th style="width:11%;border:1px solid black;" align="right"><h3>Qty</h3></th>
        <th style="width:12%;border:1px solid black;" align="left"><h3>Unidad</h3></th>
        <th style="width:11%;border:1px solid black;" align="right"><h3>PrecioUni</h3></th>
        <th style="width:11%;border:1px solid black;" align="right"><h3>Importe</h3></th>
     </tr>
		 ';
		 
		$c = 0;
		$qty = 0; 
		$tax_total_price1 = 0;
		$tax_total_price2 = 0;
		$tax_total_price3 = 0;
		$subtotal = 0;
		$total_desc = 0;
	    foreach( $order as $_order ) 
	    {
			$c++;
			$output .= '<tr>
				<td style="border-right:1px solid black;" align="right">'.$c.'</td>
				<td style="border-right:1px solid black;">'.$_order->purchase_item_name.'</td>';
				$qty += $_order->purchase_item_qty;
			if($_order->purchase_item_name != "Discount"){
				$discount=0;
				$item_total = $_order->purchase_item_rate;
				$item_total_price = ($item_total * $_order->purchase_item_qty + $discount); 
				
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
				$i_p = 	$item_total - $i_t;
				$i_p += $discount ;		
				
				$i_p -=$discount;
				$i_sp -=$discount;
				
				
			$output .=	'<td style="border-right:1px solid black;" align="right">'.$_order->purchase_item_qty.'</td>
				<td style="border-right:1px solid black;">'.$_order->purchase_item_kg.'</td>
				<td style="border-right:1px solid black;" align="right">'.$i_p.'</td>
				<td style="border-right:1px solid black;" align="right">'.$i_sp .'</td>
			</tr> ';
			}
			else{
				 $total_desc+=$_order->purchase_item_kg;
				$output .=	'<td style="border-right:1px solid black;" align="right">'.$_order->purchase_item_qty.'</td>
				<td style="border-right:1px solid black;">'.$_order->purchase_item_kg.'</td>
				<td style="border-right:1px solid black;" align="right">'.$_order->purchase_item_rate.'</td>
				<td style="border-right:1px solid black;" align="right">'.$_order->purchase_total.'</td>
			</tr> ';
			}
	    }
		
		 for($i = $c; $i <=12 ; $i++ ){
			 
   		$output .= '<tr>
      	<td style="border-right:1px solid black;"></td>
        
        <td style="border-right:1px solid black;"></td>
        <td style="border-right:1px solid black;"></td>
        <td style="border-right:1px solid black;"></td>
        <td style="border-right:1px solid black;"></td>
        <td style="border-right:1px solid black;"></td>
      </tr> ';
		 }
    	$output .='<tr>
      	<td colspan="2"  height="20" align="right" style="border:1px solid black;">
			<table width="100%">
				<tr>
					<td align="left" width="75%"> : '.$company[0]->company_vat_no.'</td>
								<td width="5%">:</td>
				  <td align="right" width="20%">'.$company[0]->sales_tax1.'%</td>
				</tr>
				<tr>
					<td align="left"> :'. $company[0]->company_cst_no.'</td>
								<td>:</td>
				  <td align="right">'.$company[0]->sales_tax2.'%</td>
				</tr>
				<tr>
					<td align="left">: '.$company[0]->company_gst_no.'</td>
								<td>:</td>
				  <td align="right">'.$company[0]->sales_tax3.'%</td>
				</tr>
			</table>
		</td>
		
		<td colspan="2"  height="20" align="right" style="border:1px solid black;">
			<table width="100%">
				<tr>
					<td align="left" width="75%">Impuesto ('.$company[0]->sales_tax1.'%)</td>
								<td width="5%">:</td>
					<td align="right" width="20%">'.$tax_total_price1.'</td>
				</tr>
				<tr>
					<td align="left"> ('.$company[0]->sales_tax2.'%)</td>
								<td>:</td>
					<td align="right">'.$tax_total_price2.'</td>
				</tr>
				<tr>
					<td align="left"> ('.$company[0]->sales_tax3.'%)</td>
								<td>:</td>
					<td align="right">'.$tax_total_price3.'</td>
				</tr>
			
			</table>
		</td>
        <td colspan="2"  height="20" align="right" style="border:1px solid black;">
			<table width="100%">
				<tr>
					<td style="border-top:1px solid black;"><h3>SubTotal</h3></td>
					<td style="border-top:1px solid black" align="right">'.$subtotal.'</td>
				</tr>
				<tr>
					<td style=""><h3>Total</h3></td>';
					$total_gst_tax = $tax_total_price1 + $tax_total_price2 + $tax_total_price3;
					$output .='<td style="" align="right">'.$total_gst_tax.'</td>
				</tr>
			</table>
		</td>
        
      </tr>
    	
    </table>
    
    <table border="1" width="100%">
    	<tr>
      	<td colspan="2"></td>
        <td>
        	<table width="100%">
        	<tr>
          	<td align="left" height="20" width="65%"><h2>Total</h2></td>
						<td style="width:5%;">:</td>
            <td align="right" width="30%"><h2>'.$grand_tot.'</h2></td>
          </tr>
          </table>
        </td>
      </tr>
			
      <tr>
     
      </tr>
      <tr>
      	<td colspan="2" align="left">
        	<span style="font-size:15px; font-wight:bold; " >Terminos y Condiciones :</span>
          	<ul>';
				foreach($company_terms as $_terms){
					$output .= '<li>'.$_terms.'</li>';
				}
				
            $output .='</ul>
        </td>
        <td colspan="2">
        	<span style="font-size:15px; font-wight:bold;">
						 '.$company[0]->company_name.'
					</span>
					<br /><br />
					<div  style="text-align:right; width:100%;" >	
            Autorizado:.
					</div>
        </td>
      </tr>
    </table>
		
	';

// output the HTML content
$pdf->writeHTML($output, true, false, true, false, '');

//Close and output PDF document
$pdf->Output('Invoice.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>