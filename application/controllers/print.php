$query = $this->db->query("Select purchase_no from sales order by purchase_no desc limit 1 ");
        	$conse=$query->row_array();
        	
        	//$order_no = $this->uri->segment(3);
			$CI =& get_instance();		
			$bill_number = $CI->get_bill_number($conse['purchase_no']);
			//print_r($bill_number);

			$bill_date = $CI->get_bill_date($conse['purchase_no']);
	        $bill_date = date("d-m-Y", strtotime($bill_date));        
	        $CI =& get_instance();
			$grand = $CI->get_grand_value($conse['purchase_no']);		

			$product_name= $CI->get_product_name($conse['purchase_no']);

			foreach ($product_name as  $val) 
			{
				
				$purchase_billno= $val['purchase_billno'];

			}

			foreach ($grand as  $party_name){

				$customer_name=$party_name['grand_partynm'];

			}
			


			//print_r($product_name);	
					/*
				Este ejemplo imprime un
				ticket de venta desde una impresora térmica
			*/


			/*
			    Aquí, en lugar de "POS" (que es el nombre de mi impresora)
				escribe el nombre de la tuya. Recuerda que debes compartirla
				desde el panel de control
			*/

			$nombre_impresora = "LR2000"; 


			$connector = new WindowsPrintConnector($nombre_impresora);
			
			$printer = new Printer($connector);
			#Mando un numero de respuesta para saber que se conecto correctamente.
			
			/*
				Vamos a imprimir un logotipo
				opcional. Recuerda que esto
				no funcionará en todas las
				impresoras

				Pequeña nota: Es recomendable que la imagen no sea
				transparente (aunque sea png hay que quitar el canal alfa)
				y que tenga una resolución baja. En mi caso
				la imagen que uso es de 250 x 250
			*/

			# Vamos a alinear al centro lo próximo que imprimamos
			$printer->setJustification(Printer::JUSTIFY_CENTER);

			/*
				Intentaremos cargar e imprimir
				el logo
			*/
			
			/*
				Ahora vamos a imprimir un encabezado
			*/

			$printer->text("\n". "Bistró 77" . "\n");
			$printer->text("   Bar Restaurante" . "\n");
			$printer->text("150 mts Sur Minesterio de" . "\n");
			$printer->text("     Hacienda" . "\n");
			$printer->text("Tel: 83395550" . "\n");
			#La fecha también
			date_default_timezone_set("America/Costa_Rica");
			$printer->text(date("Y-m-d H:i:s") . "\n");
			$printer->setJustification(Printer::JUSTIFY_LEFT);
			$printer->text(" -----------------------------------------" . "\n");
			
			$printer->text(" Factura:#  ".$purchase_billno . "\n");
			$printer->text(" Cliente:  " .$customer_name ."\n");
			//$printer->text(" Cajero:  " .$customer_name ."\n");	

			$printer->text(" -----------------------------------------" . "\n");
			$printer->setJustification(Printer::JUSTIFY_LEFT);
			$printer->text("  DESC      CANT       P.U           IMP.\n");
			$printer->text(" -----------------------------------------"."\n");		
				

			foreach ($product_name as  $value) {

			/*Ahora vamos a imprimir los
				productos*/
			
			/*Alinear a la izquierda para la cantidad y el nombre*/

				$printer->setJustification(Printer::JUSTIFY_LEFT);	

				$name= $value['purchase_item_name'];
				//$printer->textRow(" ".$name."         ");
				$qty = $value['purchase_item_qty'];
				//$printer->text($qty."           ");
				$priceU=$value['purchase_item_rate'];
				//$printer->text($priceU);
				$subT=$value['purchase_total'];	
				//$printer->text($subT."\n");

				$line = sprintf('%-45.45s   %5.0f %13.2f %13.2f ', $name, $qty, $priceU, $subT);
				$printer->text("   ");
				$printer->text($line."\n");
				//$Test= $name. "\n". "\n" . $priceU."\n" ."\n".$subT  ."<br>";

				//print_r($Test);
				
				$subTotal+=$value['purchase_total'];									
					
				}
				   
			/*
				Terminamos de imprimir
				los productos, ahora va el total
			*/
			foreach ($grand as  $v_grand)
			{
				$IVA= $v_grand['grand_sales_tax_value'];
				$total = $v_grand['grand_total'];
				$restaurant_service = $v_grand['grand_other_value'];
				

							
					
				$printer->text(" ----------------------------------------"."\n");
				$printer->setJustification(Printer::JUSTIFY_RIGHT);
				$printer->text("SUBTOTAL:  "  .$subTotal ."\n");
				$printer->text("10 % serv:  "  .$restaurant_service ."\n");
				$printer->text("TOTAL:  "   .$total . "\n");
			}

			/*
				Podemos poner también un pie de página
			*/
			$printer->setJustification(Printer::JUSTIFY_CENTER);
			$printer->text("Muchas gracias por su compra\n\n\n");

			$printer->text("   Autorizado mediante la resolución 1197 DGTD según Gaseta 171 del 05/09/1997");

			/*Alimentamos el papel 3 veces*/
			$printer->feed(3);

			/*
				Cortamos el papel. Si nuestra impresora
				no tiene soporte para ello, no generará
				ningún error
			*/
			$printer->cut();

			/*
				Por medio de la impresora mandamos un pulso.
				Esto es útil cuando la tenemos conectada
				por ejemplo a un cajón
			*/
			$printer->pulse();

			/*
				Para imprimir realmente, tenemos que "cerrar"
				la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
			*/
			$printer->close();

			//$data['recored'] = $this->sales_model->findAll();
			//$this->load->view('admin/sales/sales-list',$data);