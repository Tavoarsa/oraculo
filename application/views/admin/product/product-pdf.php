<?php
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Rudleo Web Development');
$pdf->SetTitle('Rudleo PDF Report');
$pdf->SetSubject('TCPDF Tutorial');

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

// writeHTML($html, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')
// writeHTMLCell($w, $h, $x, $y, $html='', $border=0, $ln=0, $fill=0, $reseth=true, $align='', $autopadding=true)

// create some HTML content
$html = '<table>
			<tr style="color:#000;font-weight:900;">
				<td width="20%" style="">
				<img src="'.base_url().'_template/images/rudleo.jpg" height="100" width="140" />
				</td>
				<td width="80%" style="" colspan="2">
					<h2 style="background-color:#FFF;">company_name</h2>
					<p style="background-color:#DEDEDE;">Address <br /> Phone : </p>
				</td>
				
			</tr><tr><td colspan="3"><hr /><br /></td></tr>
							
			<tr>
				<td colspan="3">
					<table>
						<tr align="center" style="background-color:#DEDEDE;color:#000;font-weight:900;font-size:12px;">

 									<td>product_id</td>
 									<td>admin_id</td>
 									<td>category_id</td>
 									<td>sub_category_id</td>
 									<td>brand_id</td>
 									<td>product_for</td>
 									<td>article_no</td>
 									<td>size_no</td>
 									<td>total_stock</td>
 									<td>product_name</td>
 									<td>product_serial_no</td>
 									<td>product_description</td>
 									<td>product_actual_price</td>
 									<td>product_margin</td>
 									<td>product_discount</td>
 									<td>product_stock</td>
 									<td>product_image_1</td>
 									<td>product_image_2</td>
 									<td>product_image_3</td>
 									<td>product_image_4</td>
 									<td>product_image_5</td>
 									<td>product_time_visited</td>
 									<td>product_meta_title</td>
 									<td>product_meta_desc</td>
 									<td>product_meta_keywords</td>
 									<td>product_display_order</td>
 									<td>product_is_new_arrival</td>
 									<td>product_is_active</td>
 									<td>entry_date</td>
 									<td>create_date</td>
						</tr>';
						foreach ( $recored as $_recored ) 
						{
							$html .= '<tr align="center">';
							
 									$html .= "<td>".$_recored->product_id."</td>";
 									$html .= "<td>".$_recored->admin_id."</td>";
 									$html .= "<td>".$_recored->category_id."</td>";
 									$html .= "<td>".$_recored->sub_category_id."</td>";
 									$html .= "<td>".$_recored->brand_id."</td>";
 									$html .= "<td>".$_recored->product_for."</td>";
 									$html .= "<td>".$_recored->article_no."</td>";
 									$html .= "<td>".$_recored->size_no."</td>";
 									$html .= "<td>".$_recored->total_stock."</td>";
 									$html .= "<td>".$_recored->product_name."</td>";
 									$html .= "<td>".$_recored->product_serial_no."</td>";
 									$html .= "<td>".$_recored->product_description."</td>";
 									$html .= "<td>".$_recored->product_actual_price."</td>";
 									$html .= "<td>".$_recored->product_margin."</td>";
 									$html .= "<td>".$_recored->product_discount."</td>";
 									$html .= "<td>".$_recored->product_stock."</td>";
 									$html .= "<td>".$_recored->product_image_1."</td>";
 									$html .= "<td>".$_recored->product_image_2."</td>";
 									$html .= "<td>".$_recored->product_image_3."</td>";
 									$html .= "<td>".$_recored->product_image_4."</td>";
 									$html .= "<td>".$_recored->product_image_5."</td>";
 									$html .= "<td>".$_recored->product_time_visited."</td>";
 									$html .= "<td>".$_recored->product_meta_title."</td>";
 									$html .= "<td>".$_recored->product_meta_desc."</td>";
 									$html .= "<td>".$_recored->product_meta_keywords."</td>";
 									$html .= "<td>".$_recored->product_display_order."</td>";
 									$html .= "<td>".$_recored->product_is_new_arrival."</td>";
 									$html .= "<td>".$_recored->product_is_active."</td>";
 									$html .= "<td>".$_recored->entry_date."</td>";
 									$html .= "<td>".$_recored->create_date."</td>";
							$html .= '</tr>';
						}
					$html .='</table>
				</td>
			</tr>';
		$html .='</table>';


// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

//Close and output PDF document
$pdf->Output('product.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>