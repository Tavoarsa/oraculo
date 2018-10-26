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

$CI =& get_instance();
$company = $CI->get_company_data(); 

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
				<img src="'.base_url().'file/company/'.$company[0]->company_image.'" height="100" width="140" />
				</td>
				<td width="80%" style="" colspan="2">
					<h2 style="background-color:#FFF;">'.$company[0]->company_name.'</h2>
					<p style="background-color:#DEDEDE;">'.strip_tags($company[0]->company_address).$company[0]->company_city.' <br /> Phone : '.$company[0]->company_phone.'</p>
				</td>
				
			</tr><tr><td colspan="3"><hr /><br /></td></tr>
							
			<tr>
				<td colspan="3">
					<table>
						<tr align="center" style="background-color:#DEDEDE;color:#000;font-weight:900;font-size:12px;">

 									<td>Customer Name</td>
 									<td>Email</td>
 									<td>Address</td>
 									<td>City</td>
 									<td>Zipcode</td>
 									<td>Phone</td>
 						</tr>';
						foreach ( $recored as $_recored ) 
						{
							$html .= '<tr align="center">';
							
 									$html .= "<td>".$_recored->customer_first_name."</td>";
 									$html .= "<td>".$_recored->customer_email."</td>";
 									$html .= "<td>".$_recored->customer_address."</td>";
 									$html .= "<td>".$_recored->customer_city."</td>";
 									$html .= "<td>".$_recored->customer_zipcode."</td>";
 									$html .= "<td>".$_recored->customer_phone."</td>";
 							$html .= '</tr>';
						}
					$html .='</table>
				</td>
			</tr>';
		$html .='</table>';


// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

//Close and output PDF document
$pdf->Output('customer.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>