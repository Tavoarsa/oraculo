<?php

$CI =& get_instance();
$company = $CI->get_company_data(); 
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Tavoarsa');
$pdf->SetTitle('Reporte Ventas');
$pdf->SetSubject('Reporte');

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
				
				<table width="100%" style="">
						<tr style="color:#000;font-weight:900;">
								<td width="20%" style="">
								<img src="'.base_url().'file/company/'.$company[0]->company_image.'" height="100" width="140" />
								</td>
								<td width="80%" style="" colspan="6">
									<h2 style="background-color:#FFF;">'.$company[0]->company_name.'</h2>
    								<p style="background-color:#DEDEDE;">'.$company[0]->company_address.$company[0]->company_city.'<br />&nbsp;Mobile :'.$company[0]->company_phone.'</p>
								</td>
								
							</tr><tr><td colspan="7"><hr /><br /></td></tr>
						<tr align="center" style=" background-color:#DEDEDE;color:#000;font-size:12px;font-weight:900;">
							<td width="7%">No</td>
							<td width="23%">Order Date</td>
							<td width="20%">No of Order</td>
							<td width="15%">Cash</td>
							<td width="15%">Debit</td>
							<td width="20%">Total</td>
							
						</tr>';
							$total_o =0;
							$total_c =0;
							$total_d =0;
							$total_s =0;
							$i = 0;
						foreach ($recored as $_date) {
						$i++;
                           $output .='<tr>
                           	 <td align="center">'.$i.'</td>
                              <td align="center">'. date("d-m-Y", strtotime($_date->entry_date)).'</td>
                              <td align="center">
                               '. $total_order = $CI->get_total_order($_date->entry_date)
                                .'
                              </td>';
                                
                              $output .='
                              <td align="center">
                                '. $all_cash = number_format($CI->get_all_cash($_date->entry_date),2)
                                .'
                              </td>
                              <td align="center">
                                '.
                                  $all_debit = number_format($CI->get_all_debit($_date->entry_date),2)
                                .'
                              </td>
                              <td align="center">
                                '. $all_total = number_format($CI->get_all_total($_date->entry_date),2)
                                .'
                              </td>

                            </tr>';

                            $total_o +=	$total_order;
							$total_c += $all_cash;
							$total_d += $all_debit;
							$total_s += $all_total;
							
                            
					}	
						
					
				$output .='<tr align="center" style=" background-color:#DEDEDE;color:#000;font-size:12px;font-weight:900;">
								<td></td>
								<td>Total</td>
								<td>'.$total_o.'</td>
								<td>'.number_format($total_c,2).'</td>
								<td>'.number_format($total_d,2).'</td>
								<td>'.number_format($total_s,2).'</td>
								
							</tr>';
				$output .='</table>';
				
			

// output the HTML content
$pdf->writeHTML($output, true, false, true, false, '');

//Close and output PDF document
$pdf->Output('Invoice.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>