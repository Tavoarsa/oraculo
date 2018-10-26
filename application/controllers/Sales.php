<?php
require_once('vendor/mike42/escpos-php/autoload.php');

use Mike42\Escpos\PrintConnectors\FilePrintConnector;
use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');


				
class Sales extends MY_Controller  { 
 
	
	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->library('Pdf_Library');
		$this->load->library('Excel_Library');
		$this->load->database();
        if (!$this->session->userdata('logged_in'))
	    { 
	        redirect('login');
	    }
	    else
	    {
	    	if($this->session->userdata('userid') != 1)
	    	{
		    	$rights = $this->check_rights();
		    	$url = $this->uri->segment(1).'/'.$this->uri->segment(2);
		    	if(!in_array($url, $rights))
		    	{
		    		$this->load->view('admin/not_access');
		    	}
		    }
	    }
	    
        $this->load->helper('form');
        $this->load->model('sales_model');

    }
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/home
	 *	- or -
	 * 		http://example.com/index.php/home/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/home/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	
 
	
 		public function convertNum($number) {
			
			   $no = (int)$number;
			   $point = round($number - $no, 2) * 100;
			   $hundred = null;
			   $digits_1 = strlen($no);
			   $i = 0;
			   $str = array();
			   $words = array('0' => '', '1' => 'uno', '2' => 'dos',
			    '3' => 'three', '4' => 'four', '5' => 'five', '6' => 'six',
			    '7' => 'seven', '8' => 'eight', '9' => 'nine',
			    '10' => 'ten', '11' => 'eleven', '12' => 'twelve',
			    '13' => 'thirteen', '14' => 'fourteen',
			    '15' => 'fifteen', '16' => 'sixteen', '17' => 'seventeen',
			    '18' => 'eighteen', '19' =>'nineteen', '20' => 'twenty',
			    '30' => 'thirty', '40' => 'forty', '50' => 'fifty',
			    '60' => 'sixty', '70' => 'seventy',
			    '80' => 'eighty', '90' => 'ninety');
			   $digits = array('', 'hundred', 'thousand', 'lakh', 'crore');
			   while ($i < $digits_1) {
			     $divider = ($i == 2) ? 10 : 100;
			     $number = floor($no % $divider);
			     $no = floor($no / $divider);
			     $i += ($divider == 10) ? 1 : 2;
			     if ($number) {
			        $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
			        $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
			        $str [] = ($number < 21) ? $words[$number] .
			            " " . $digits[$counter] . $plural . " " . $hundred
			            :
			            $words[floor($number / 10) * 10]
			            . " " . $words[$number % 10] . " "
			            . $digits[$counter] . $plural . " " . $hundred;
			     } else $str[] = null;
			  }
			  $str = array_reverse($str);
			  $result = implode('', $str);
			  $points = ($point) ?
			    "Points " . $words[$point / 10] . " " . 
			          $words[$point = $point % 10] : '';
			  return $result . " " . $points . " ";
		}
	// index method
	public function index()
	{
		$data['recored'] = $this->sales_model->findAll();
		$this->load->view('admin/sales/sales-list',$data);
	}

	// index method
	public function fe()
	{
		//$data['recored'] = $this->sales_model->findAll();
		$this->load->view('admin/sales/fe');
	}

	// index method
	public function table_reset()
	{
		$data['recored'] = $this->sales_model->findAll_temp_table();
		$this->load->view('admin/sales/temp_sale',$data);
		
	}


	public function delete_tmp_sale($id)
	{

		if($this->session->userdata('userid') != 1)
	    {

			$rights = $this->check_rights();
			if(!in_array('sales/delete', $rights))
	    	{
	    		return redirect('access');
	    	}
	    	else
	    	{
	    		$this->sales_model->remove_temp_sale($id);
				$this->session->set_flashdata('msg','Eliminado Correctamente !');
				
				return redirect('sales');
			}
		}
		else
		{
				$this->sales_model->remove_temp_sale($id);
				$this->session->set_flashdata('msg','Eliminado Correctamente !');
				
				return redirect('sales/create');
		}
	}
 	
 	
	public function return_sales()
	{
		$this->db->where('return_p','yes');
		$this->db->group_by('purchase_no');
		$this->db->join('sales_grandtotal', 'sales_grandtotal.grand_order_no = sales.purchase_no');
		$data['recored'] = $this->db->get('sales')->result();
		$this->load->view('admin/sales/sales-return-list',$data);
	}

	// order view

	public function order_view()
	{
		$this->load->view('admin/sales/order-view');
	}

	// pdf method
	public function pdf($page,$order_no)
	{
		$this->db->where('purchase_no',$order_no);
		$data['order'] = $this->db->get('sales')->result();
		$this->load->view('admin/sales/'.$page,$data);
	}
 		
	// excel method
	public function excel()
	{
		$data['recored'] = $this->sales_model->findAll();
		$this->load->view('admin/sales/sales-excel',$data);
	}
	
	public function get_grand_value($order_no)
	{
		$res = $this->db->query("select * from sales_grandtotal where grand_order_no='".$order_no."'");
		return $totrel = $res->result_array();
	}

	public function get_tmp_sales()
	{
		$query = $this->db->query('select DISTINCT(table_id) from sales_tmp where admin_id ='.$this->session->userdata('userid'));

		$table = array();
		foreach ($query->result() as $row)
		{
		        $table[] = $row->table_id ;
		}
		
		return $table;
	}

	public function edit_data_get_product($s_no)
	{
		$query = $this->db->query("select product_serial_no,product_margin,product_actual_price,product_id,product_discount from product where product_serial_no = '".$s_no."'");
		return $query->row_array();
	}

	public function edit_data_get_option($con)
	{
		$query = $this->db->query("SELECT po.product_option_stock,po.option_parent_id,po.option_id,o.option_name,po.product_option_id FROM product_option po 
                                          INNER JOIN options o ON po.option_id=o.option_id
                                          WHERE product_option_id =".$con." ");
		return $query->row_array();
	}

	public function get_company_data()
	{
		return $this->db->get('company')->result();
	}

	public function get_bill_number($no)
	{
		$this->db->where('purchase_no',$no);
		$data = $this->db->get('sales')->row_array();
		return  $data['purchase_billno'];
	}

	public function get_bill_date($no)
	{
		$this->db->where('purchase_no',$no);
		$data = $this->db->get('sales')->row_array();
		return  $data['purchase_dt'];
	}
	//Get All category 
	public function get_all_cat()
	{
		$this->db->where('parent_id !=','0');
		return $data['_cate'] = $this->db->get('category')->result();
	}


	// Create method
	public function create()
	{
		$this->load->library('form_validation');


		$this->form_validation->set_rules('typeahead', 'Customer name', 'required');
		$this->form_validation->set_rules('selcd_for', 'Cash / Debit', 'required');
		$this->form_validation->set_rules('txtbillno', 'Sales Billno', 'required');
		$this->form_validation->set_rules('select_order_products','Products','required');
		
        if ($this->form_validation->run() === FALSE)
        {
			$this->load->view('admin/sales/sales-add');
		}
		else
		{
			$this->sales_model->insert();
			
			$this->session->set_flashdata('msg','Agregado Correctamente !');
			return redirect('sales/create');
		}
	}
	
	public function get_product_option_bill($id)
	{
		$query = $this->db->query("SELECT po.product_option_stock,po.option_parent_id,po.option_id,o.option_name,po.product_option_id FROM product_option po 
								INNER JOIN options o ON po.option_id=o.option_id
								WHERE product_option_id =".$id);
		return $query->row_array();
	}

	//public pos function
	public function bill_print($no)
	{	

		$query=$this->db->where('purchase_no',$no);		
		$data['order'] = $this->db->get('sales')->result();
		$this->load->view('admin/sales/bill-print-confrim',$data);
	}

	// update method
	public function update($id)
	{
			$product_re = array();
			$product_re = $_POST['product_serial_no'];
			$priduct_re_qty = $_POST['product_qty'];
			$re_c = 0;
			if(isset($_POST['return']))
			{
				if($_POST['return'] == 'yes')
				{
					$data=array('return_p'=>'yes');
					$this->db->where('purchase_no',$id);
					$this->db->update('sales',$data);
					
					return redirect('sales');
				}
			}
			else
			{
				$this->db->where('purchase_no',$id);
				$this->db->delete('sales');

				$this->db->where('grand_order_no',$id);
				$this->db->delete('sales_grandtotal');

				$data_ar = $this->sales_model->insert();
				//echo $data_ar;	
				return redirect('sales/bill_print/'.$data_ar);
			}

		
	}
		
	// edit method
	public function edit($id)
	{
		$data['recored'] = $this->sales_model->findOne($id);
		$this->load->view('admin/sales/sales-edit',$data);
	}
		
	// delete method
	public function delete($id)
	{

		if($this->session->userdata('userid') != 1)
	    {

			$rights = $this->check_rights();
			if(!in_array('sales/delete', $rights))
	    	{
	    		return redirect('access');
	    	}
	    	else
	    	{
	    		$this->sales_model->remove($id);
				$this->session->set_flashdata('msg','Eliminado Correctamente !');
				
				return redirect('sales');
			}
		}
		else
		{
				$this->sales_model->remove($id);
				$this->session->set_flashdata('msg','Eliminado Correctamente !');
				
				return redirect('sales');
		}
	}
		
	public function active_inactive($id,$mode)
	{
		$this->sales_model->change_status($id,$mode);
		return redirect('sales');
	}
//modificar
	public function get_product_name($no)
	{

		$query = $this->db->query("SELECT purchase_item_name, purchase_item_qty,purchase_item_rate,purchase_total,purchase_party_name,purchase_billno   FROM sales 								
								WHERE purchase_no =".$no);
		return $query->result_array();

		
	}






	public function print_sale($no)
	{	
			   

		$order_no = $this->uri->segment(3);
		$CI =& get_instance();
		$bill_number = $CI->get_bill_number($order_no);

		$bill_date = $CI->get_bill_date($order_no);
        $bill_date = date("d-m-Y", strtotime($bill_date));        
        $CI =& get_instance();
		$grand = $CI->get_grand_value($order_no);		

		$product_name= $CI->get_product_name($order_no);

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

		$printer->text("\n"."Bistró 77" . "\n");
		$printer->text("25 Sur Banco Popular" . "\n");
		$printer->text("Tel: 2460 0810" . "\n");
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

		$data['recored'] = $this->sales_model->findAll();
		$this->load->view('admin/sales/sales-list',$data);





	}
 } 
 

?>