<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Report extends MY_Controller  { 
 
		
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
        $this->load->model('report_model');

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
	
	
	// index method
	public function index()
	{
		$data['recored'] = $this->report_model->findAll();
		$this->load->view('admin/report/report',$data);
	}

	public function today()
	{
		$this->db->select('entry_date'); 
		$this->db->where('entry_date',date('Y-m-d'));
		$this->db->group_by('entry_date');
		$this->db->join('sales_grandtotal', 'sales_grandtotal.grand_order_no = sales.purchase_no');
		$data['recored'] = $this->db->get('sales')->result();
		$this->load->view('admin/report/report',$data);	
	}

	public function weekly()
	{
		$date1=date('Y-m-d',strtotime(date("Y-m-d")."-6 day"));
		$date2=date('Y-m-d');

		$this->db->select('entry_date'); 
		$this->db->where('entry_date >=', $date1);
		$this->db->where('entry_date <=', $date2);
   		$this->db->group_by('entry_date');
		$this->db->join('sales_grandtotal', 'sales_grandtotal.grand_order_no = sales.purchase_no');
		$data['recored'] = $this->db->get('sales')->result();
		$this->load->view('admin/report/report',$data);	
	}

	public function monthly()
	{
		$start_date=date('Y-m-01'); // Month Starting Date
		$end_date=date('Y-m-t');  // Month Ending Date

		$this->db->select('entry_date'); 
		$this->db->where('entry_date >=', $start_date);
		$this->db->where('entry_date <=', $end_date);
   		$this->db->group_by('entry_date');
		$this->db->join('sales_grandtotal', 'sales_grandtotal.grand_order_no = sales.purchase_no');
		$data['recored'] = $this->db->get('sales')->result();
		$this->load->view('admin/report/report',$data);	
	}

	public function yearly()
	{
		$start_date=date('Y-01-d'); // year Starting Date
		$end_date=date('Y-12-d');  // year Ending Date

		$this->db->select('entry_date'); 
		$this->db->where('entry_date >=', $start_date);
		$this->db->where('entry_date <=', $end_date);
   		$this->db->group_by('entry_date');
		$this->db->join('sales_grandtotal', 'sales_grandtotal.grand_order_no = sales.purchase_no');
		$data['recored'] = $this->db->get('sales')->result();
		$this->load->view('admin/report/report',$data);	
	}

	public function search($datefrom = '',$dateto = '')
	{

		$date1 = date("Y-m-d", strtotime($datefrom));
		$date2 = date("Y-m-d", strtotime($dateto));

		$this->db->select('sales.entry_date'); 
		$this->db->where('sales.entry_date >=', $date1);
		$this->db->where('sales.entry_date <=', $date2);
   		$this->db->group_by('sales.entry_date');
		$this->db->join('sales_grandtotal', 'sales_grandtotal.grand_order_no = sales.purchase_no');
		$data['recored'] = $this->db->get('sales')->result();
		$this->load->view('admin/report/report',$data);	
	}
 	

 	public function table($date = "")
 	{
 		if($date == '')
 		{
 			$date = date("Y-m-d");
 		}
 		else
 		{
 			$date = date("Y-m-d", strtotime($date));	
 		}
 		

 		$this->db->select('sales.table_id,sales.entry_date'); 
		$this->db->where('sales.entry_date',$date);
		$this->db->group_by('sales.table_id');
		$this->db->join('sales_grandtotal', 'sales_grandtotal.grand_order_no = sales.purchase_no');
		$data['recored'] = $this->db->get('sales')->result();
		$this->load->view('admin/report/table_report',$data);	
 	}

	public function get_total_order($date,$table ='')
	{
		if($table == ''){
			$query = $this->db->query("SELECT count(DISTINCT(purchase_no)) as total_order FROM sales WHERE entry_date = '".$date."' ");
		}
		else
		{
			$query = $this->db->query("SELECT count(DISTINCT(purchase_no)) as total_order FROM sales WHERE entry_date = '".$date."' AND table_id = ".$table." ");
		}
		
		$data =  $query->row_array();
		return $data['total_order'];
	}

	public function get_all_order($date,$table='')
	{
		if($table == ''){
			$query = $this->db->query("SELECT DISTINCT(purchase_no) FROM sales WHERE entry_date = '".$date."' ");
		}
		else
		{
			$query = $this->db->query("SELECT DISTINCT(purchase_no) FROM sales WHERE entry_date = '".$date."' AND table_id = ".$table." ");
		}
		$data =  $query->result();
		return $data;
	}

	public function get_all_cash($date,$table = '')
	{
		if($table == ''){

			$query = $this->db->query("SELECT SUM(purchase_total) as total_cash FROM sales WHERE entry_date = '".$date."' AND purchase_cd = 'Cash' ");
		}
		else
		{
			$query = $this->db->query("SELECT SUM(purchase_total) as total_cash FROM sales WHERE entry_date = '".$date."' AND purchase_cd = 'Cash' AND table_id  = ".$table." ");
		}
		
		$data =  $query->row_array();
		return $data['total_cash'];
	}

	public function get_all_debit($date,$table = '')
	{
		if($table == ''){
			$query = $this->db->query("SELECT SUM(purchase_total) as total_debit FROM sales WHERE entry_date = '".$date."' AND purchase_cd = 'Debit' ");
		}
		else
		{
			$query = $this->db->query("SELECT SUM(purchase_total) as total_debit FROM sales WHERE entry_date = '".$date."' AND purchase_cd = 'Debit' AND table_id = ".$table." ");
		}
		
		$data =  $query->row_array();
		return $data['total_debit'];
	}



	public function get_total_ser_res($date){

		//purchase_no for equivalet grand_order_no 
		$purchase=$this->db->query("SELECT purchase_no FROM sales WHERE entry_date = '".$date."' ");		

			foreach($purchase->result_array() AS $row) {

   				$purchase = $row['purchase_no'];
   			}	

   		$ser_res = $this->db->query("SELECT SUM(grand_other_value) as gran_o_v FROM sales_grandtotal WHERE grand_order_no='".$purchase."'");
		$data1 = $ser_res->row_array();	

		return $data1['gran_o_v'];


	}

	public function get_all_total($date,$table='')
	{
		if($table == ''){

			$query = $this->db->query("SELECT SUM(purchase_total) as total_total FROM sales WHERE entry_date = '".$date."' ");

			
			
		}	
		else
		{
			$query = $this->db->query("SELECT SUM(purchase_total) as total_total FROM sales WHERE entry_date = '".$date."' AND table_id = ".$table." ");

			
		}
		
		$data =  $query->row_array();
		return $data['total_total'];
	}

	public function order_info($order_no)
	{
		$data['order'] = $this->report_model->findOne($order_no);
		$this->load->view('admin/report/order_info',$data);
	}

	public function get_customer($name)
	{
		$query = $this->db->query('SELECT * FROM customer WHERE customer_first_name = "'.$name.'"');
		return $query->row_array();
	}
	// pdf method
	public function pdf()
	{
		$data['recored'] = $this->report_model->findAll();
		$this->load->view('admin/report/report_pdf',$data);
	}
 		
	// excel method
	public function excel()
	{
		$data['recored'] = $this->report_model->findAll();
		$this->load->view('admin/report/report_excel',$data);
	}
	
	public function get_grand_value($order_no)
	{
		$res = $this->db->query("select * from sales_grandtotal where grand_order_no='".$order_no."'");
		return $totrel = $res->row_array();
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
			
			$this->session->set_flashdata('msg','Successfully Insert Sales Bill !');
			return redirect('sales');
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
		$this->db->where('purchase_no',$no);
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
		$this->sales_model->remove($id);
		$this->session->set_flashdata('msg','Successfully Delete Data !');
		
		return redirect('sales');
	}
		
	public function active_inactive($id,$mode)
	{
		$this->sales_model->change_status($id,$mode);
		return redirect('sales');
	}
 } 
 

?>