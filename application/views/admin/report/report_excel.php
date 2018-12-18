<?php
// Create Excel FIle
	$CI =& get_instance();
	$total_o =0;
	$total_c =0;
	$total_d =0;
	$total_s =0;
	foreach ($recored as $_date) {
		$date = date("d-m-Y", strtotime($_date->entry_date));
		$total_order = $CI->get_total_order($_date->entry_date);
		$all_cash = number_format($CI->get_all_cash($_date->entry_date),2);
		$all_debit = number_format($CI->get_all_debit($_date->entry_date),2);
		$all_total = number_format($CI->get_all_total($_date->entry_date),2);

		$data[][] = "$date,$total_order,$all_cash,$all_debit,$all_total";

		$total_o +=	$total_order;
		$total_c += $all_cash;
		$total_d += $all_debit;
		$total_s += $all_total;
	}
	
	$data[][] = " TOTAL,$total_o,".number_format($total_c,2).",".number_format($total_d,2).",".number_format($total_s,2);

			
				$filename = "Report";
				$excel = new PHPExcel();
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
				header('Cache-Control: max-age=0');
				
				$excel->setActiveSheetIndex(0);
				
				$rowCount = 1;
						
					$excel->getActiveSheet()->SetCellValue('A'.$rowCount, ' FECHA ');
					$excel->getActiveSheet()->SetCellValue('B'.$rowCount, ' TOTAL ');
					$excel->getActiveSheet()->SetCellValue('C'.$rowCount, ' EFECTIVO ');
					$excel->getActiveSheet()->SetCellValue('D'.$rowCount, ' TARJETA');
					$excel->getActiveSheet()->SetCellValue('E'.$rowCount, ' TOTAL ');
						
						$excel->getActiveSheet()
							->getStyle('A1:E1')
							->applyFromArray(
								array(
									'fill' => array(
										'type' => PHPExcel_Style_Fill::FILL_SOLID,
										'color' => array('rgb' => '4682B4')
									)
								)
							);
						
						$excel->getActiveSheet()
							->getStyle('A1:E1')
							->applyFromArray(
								array(
									'font'  => array(
										'bold'  => true,
										'color' => array('rgb' => 'FFFFFF'),
										'size'  => 10,
										'name'  => 'Times New Roman'
										)
								)
							);
						foreach(range('A','E') as $columnID)
						{
							
							$excel->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
						}
						
						
						
						
					$rowCount++;
				foreach($data as $val){
					foreach($val as $d)
					{
						$da = explode(',',$d);
						
						$excel->getActiveSheet()->SetCellValue('A'.$rowCount, $da[0]);
						$excel->getActiveSheet()->SetCellValue('B'.$rowCount, $da[1]);
						$excel->getActiveSheet()->SetCellValue('C'.$rowCount, $da[2]);
						$excel->getActiveSheet()->SetCellValue('D'.$rowCount, $da[3]);
						$excel->getActiveSheet()->SetCellValue('E'.$rowCount, $da[4]);
							
					}
					$rowCount++;
				}
				$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
				$writer->save('php://output');
				ob_flush();
		
?>