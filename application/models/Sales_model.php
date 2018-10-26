<?php
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Sales_model extends CI_Model  { 
 
		
	public function __construct()
    {
        $this->load->database();
    }
 		
	public function findAll()
	{
		$this->db->where('return_p !=','yes');
		$this->db->group_by('purchase_no');
		$this->db->join('sales_grandtotal', 'sales_grandtotal.grand_order_no = sales.purchase_no');
		$this->db->order_by("purchase_id", "desc");
		return $this->db->get('sales')->result();

	}


	public function findAll_temp_table()
	{
		
		return $this->db->get('sales_tmp')->result();

	}



		
	public function findOne($id)
	{
		$this->db->where('purchase_no',$id);
		return $this->db->get('sales')->result();
	}
		
	public function change_status($id,$mode)
	{
		$data=array('sales_is_active'=>$mode);
		$this->db->where('purchase_id',$id);
		$this->db->update('sales',$data);
	}
	public function delete_tmp_data($table_id)
	{
		$this->db->query("delete from sales_tmp WHERE table_id =". $table_id." AND admin_id =".$this->session->userdata('userid'));
	}
		
	public function insert($id = 0)
	{
		$partynm = $_POST['typeahead'];
		$cd = $_POST['selcd_for'];
		$billno = $_POST['txtbillno'];
		$billdt = date('Y-m-d');
		$voucher_no = $_POST['txtvoucher_no'];
		$voucher_dt = $_POST['txtvoucher_dt'];
		$vehicle_no = $_POST['txtvehicle_no'];
		$other_value = $_POST['txtother_value1'];
		$billid = $_POST['billname_'.$billno];

		// delete tmp table data
		$table_id = $_POST['pass_table_id'];
		$this->delete_tmp_data($table_id);

		$_byt_order = 0;
		$_order_no = date('HisdmY');
		$stock = 0;
		$product_name = '';

		$products = explode(',',trim($_POST['select_order_products'],','));
		$total_pay = 0;
		$qty = 0;
		foreach ($products as $product_id )
		{
			if(trim($product_id) != '')
			{
				
				if($product_name = $_POST['select_order_products_name'][$_byt_order] == 'Discount')
				{
					//echo 'Hi';exit;
					$m_name = NULL;
					$product_name = $_POST['select_order_products_name'][$_byt_order];
					$product_batchno = '0';
					$product_quantity = 0;
					$option_name = '-';
					$product_price = 0;
					$product_amount = $_POST['select_products_amount'][$_byt_order];
					$product_serialno = 0;
					$product_margin = 0 ;
				}
				else
				{
					$p_option = $_POST['select_products_option'][$_byt_order];

					$oq = "SELECT po.product_option_stock,po.option_parent_id,po.option_id,o.option_name,po.product_option_id FROM product_option po 
										INNER JOIN options o ON po.option_id=o.option_id
										WHERE product_option_id =".$p_option." "; 
					$product_option_r = $this->db->query($oq);
					$oprow = $product_option_r->row_array();
					$option_name = $oprow['option_name']; 

					//$m_name = $_POST['select_order_m_name'][$_byt_order];
					$product_name = $_POST['select_order_products_name'][$_byt_order];
					$product_batchno = '1';
					$product_quantity = $_POST['select_products_qty'][$_byt_order];
					$product_kg = $_POST['select_products_option'][$_byt_order];
					$product_price = $_POST['select_order_products_rate'][$_byt_order];
					$product_amount = $_POST['select_products_amount'][$_byt_order];
					$product_serialno = $_POST['select_order_serialno'][$_byt_order];

					$product_margin = 0;
				}
				

				$data = array(

					'admin_id' => $this->session->userdata('userid'),
					'table_id' => $table_id,
					'purchase_no' => $_order_no,
					'purchase_party_name' => $partynm,
					'purchase_cd' => $cd,
					'purchase_billno' => $billno,
					'purchase_dt' => $billdt,
					'purchase_item_name' => $product_name,
					'purchase_serial_no' => $product_serialno,
					'purchase_batch_no' => $product_batchno,
					'product_option_id' => $p_option,
					'purchase_item_qty' => (int) $product_quantity,
					'purchase_item_kg' => $option_name,
					'purchase_item_rate' => $product_price,
					'product_margin' => $product_margin,
					'purchase_total' => $product_amount,
					'voucher_no' => $voucher_no,
					'voucher_date' => $voucher_dt,
					'vehicle_no' => $vehicle_no,
					'purchase_status' => 'active',
					'entry_date' => date('Y-m-d'),
					'active' => 'yes',

			        );

				$this->db->insert('sales', $data);

				$_byt_order++;
				
				$qty +=(int) $product_quantity;
				$total_pay +=$product_amount;

			}
		}

		$search="select * from customer where customer_first_name='".$_POST['typeahead']."'";
			$row = $this->db->query($search)->row_array();
			$mobile =null;
			if(is_array($row))
			{
				$party_id=$row['customer_id'];
				$address=$row['customer_address'];
				$city=$row['customer_city'];
				$zipcode=$row['customer_zipcode'];
				$mobile=$row['customer_phone'];
				$email=$row['customer_email'];
				$gender=$row['customer_gender'];
				
			}
			$query = $this->db->query("select sms,sms_api from company where company_id = 1 ");
			$objcompany = $query->row_array();

			if($objcompany['sms'] == 'yes' && $objcompany['sms_api'] != '' ){
				//echo 'hi';exit;
				$mo = $mobile;
				$mo=!empty($mo)?$mo:9979105467;
				$message = 'Dear '.$_POST['typeahead'].' Thanks For Purchase ! Total Item '.$qty.' Total Amount Is : '.number_format($total_pay,0).' ';
				$message = urlencode($message);
				$api =  $objcompany['sms_api'];
				$api = str_replace('xxxx',$mo,$api);
				$api = str_replace('yyyy',$message,$api);
				//echo $api;exit;
				
				$ch = curl_init($api);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				$output = curl_exec($ch);      
				curl_close($ch); 
			}

		$q = 'UPDATE bill_number SET bill_perant_id= bill_perant_id + 1 WHERE bill_id = '.$billid.'';
		$this->db->query($q);

		$_order_no;
		$partynm;
		$sales_tax = $_POST['txtsales_tax'];
		$sales_tax_value = $_POST['txtsales_tax_value'];
		$other_tax = $_POST['txtother_tax'];
		$other_tax_value = $_POST['txtother_tax_value'];
		$other = $_POST['txtother'];
		$other_value = $_POST['txtother_value1'];
		$grand_total = $_POST['txtgrand_total1'];
		$entry_date = date("Y-m-d");
		
		$data_g = array(

				'table_id' => $table_id,
				'grand_order_no' => $_order_no,
				'grand_partynm' => $partynm,
				'grand_sales_tax' => $sales_tax ,
				'grand_sales_tax_value' => $sales_tax_value,
				'grand_other_tax' => $other_tax,
				'grand_other_tax_value' => $other_tax_value,
				'grand_other' => $other,
				'grand_other_value' => $other_value,
				'grand_total' => $grand_total,
				'grand_status' => 'yes'
					
		);

		$this->db->insert('sales_grandtotal', $data_g);

		return $_order_no;
	}
		//No esta disponible en el cliente...Actulaizar las uma de purchyase_total
	public function update($id)
	{
		$data = array(

		'admin_id' => $this->input->post('txt_admin_id'),
		'table_id' => $this->input->post('txt_table_id'),
		'purchase_no' => $this->input->post('txt_purchase_no'),
		'purchase_party_name' => $this->input->post('txt_purchase_party_name'),
		'purchase_cd' => $this->input->post('txt_purchase_cd'),
		'purchase_billno' => $this->input->post('txt_purchase_billno'),
		'return_p' => $this->input->post('txt_return_p'),
		'purchase_dt' => $this->input->post('txt_purchase_dt'),
		'purchase_item_name' => $this->input->post('txt_purchase_item_name'),
		'purchase_serial_no' => $this->input->post('txt_purchase_serial_no'),
		'purchase_batch_no' => $this->input->post('txt_purchase_batch_no'),
		'product_option_id' => $this->input->post('txt_product_option_id'),
		'purchase_item_qty' => $this->input->post('txt_purchase_item_qty'),
		'purchase_item_kg' => $this->input->post('txt_purchase_item_kg'),
		'purchase_item_rate' => $this->input->post('txt_purchase_item_rate'),
		'product_margin' => $this->input->post('txt_product_margin'),
		'purchase_total' => $this->input->post('txt_purchase_total'),
		'voucher_no' => $this->input->post('txt_voucher_no'),
		'voucher_date' => $this->input->post('txt_voucher_date'),
		'vehicle_no' => $this->input->post('txt_vehicle_no'),
		'purchase_status' => $this->input->post('txt_purchase_status'),
		'entry_date' => $this->input->post('txt_entry_date'),
		'create_date' => $this->input->post('txt_create_date'),
		'active' => $this->input->post('txt_active'),

        );
        
        if ($id == 0) {
            return $this->db->insert('sales', $data);
        } else {
            $this->db->where('purchase_id', $id);
            return $this->db->update('sales', $data);
        }
	}
		
	public function remove($ids)
	{

		$this->db->where('purchase_no',$ids);
		$this->db->delete('sales');


		$this->db->where('grand_order_no',$ids);
		$this->db->delete('sales_grandtotal');

	}
//delete temp_sale=> reset table
	public function remove_temp_sale($ids)
	{

		$this->db->where('purchase_id',$ids);
		$this->db->delete('sales_tmp');


		

	}
 } 
 

?>