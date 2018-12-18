<?php
// Create Excel FIle				
	foreach($recored as $_recored)
	{
		
		$customer_first_name = $_recored->customer_first_name;
		$customer_email = $_recored->customer_email;
		$customer_address = $_recored->customer_address;
		$customer_city = $_recored->customer_city;
		$customer_zipcode = $_recored->customer_zipcode;
		$customer_phone = $_recored->customer_phone;
		$customer_balance = $_recored->customer_balance;
		$create_date = $_recored->create_date;
		
		$data[][] = "$customer_first_name,$customer_email,$customer_address,$customer_city,$customer_zipcode,$customer_phone,$customer_balance,$create_date";
	}
				
			
				$filename = "customer";
				$excel = new PHPExcel();
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
				header('Cache-Control: max-age=0');
				
				$excel->setActiveSheetIndex(0);
				
				$rowCount = 1;
						
					$excel->getActiveSheet()->SetCellValue('A'.$rowCount, ' CUSTOMER NAME ');
					$excel->getActiveSheet()->SetCellValue('B'.$rowCount, ' EMAIL ');
					$excel->getActiveSheet()->SetCellValue('C'.$rowCount, ' ADDRESS ');
					$excel->getActiveSheet()->SetCellValue('D'.$rowCount, ' CITY ');
					$excel->getActiveSheet()->SetCellValue('E'.$rowCount, ' ZIPCODE ');
					$excel->getActiveSheet()->SetCellValue('F'.$rowCount, ' PHONE ');
					$excel->getActiveSheet()->SetCellValue('G'.$rowCount, ' BALANCE ');
					$excel->getActiveSheet()->SetCellValue('H'.$rowCount, ' CREATE_DATE ');
					
						$excel->getActiveSheet()
							->getStyle('A1:H1')
							->applyFromArray(
								array(
									'fill' => array(
										'type' => PHPExcel_Style_Fill::FILL_SOLID,
										'color' => array('rgb' => '4682B4')
									)
								)
							);
						
						$excel->getActiveSheet()
							->getStyle('A1:H1')
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
						foreach(range('A','H') as $columnID)
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
						$excel->getActiveSheet()->SetCellValue('F'.$rowCount, $da[5]);
						$excel->getActiveSheet()->SetCellValue('G'.$rowCount, $da[6]);
						$excel->getActiveSheet()->SetCellValue('H'.$rowCount, $da[7]);
							
					}
					$rowCount++;
				}
				$writer = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
				$writer->save('php://output');
				ob_flush();
		
?>