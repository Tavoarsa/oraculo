<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database(); 


        if (!$this->session->userdata('logged_in'))
	    { 
	        redirect('login');
	    }

        
		$this->load->helper('form');
        $this->load->model('login_model');
        

    }

	public function index()
	{
		$this->load->view('admin/index');
	}

	public function total_user()
	{
		$query = $this->db->query("SELECT count(*) as total FROM users WHERE user_id != 1");
		$data = $query->row_array();

		return $data['total'];
	}

	public function total_customer()
	{
		$query = $this->db->query("SELECT count(*) as total FROM customer");
		$data = $query->row_array();

		return $data['total'];	
	}

	public function total_party()
	{
			
	}
	
	public function total_product()
	{
		$query = $this->db->query("SELECT count(*) as total FROM product");
		$data = $query->row_array();

		return $data['total'];	
	}	

	public function sales()
	{
		$year = date('Y');
		$query = $this->db->query('SELECT entry_date,purchase_item_qty,purchase_serial_no,purchase_item_name  FROM sales where return_p !="yes" AND entry_date LIKE \''.$year.'%\' ');
		return $query->row_array(); 
	}

	public function order() 
	{
		$query = $this->db->query("SELECT  s.purchase_no ,s.purchase_item_name,s.purchase_billno,sg.grand_total FROM sales s INNER JOIN sales_grandtotal sg ON s.purchase_no=sg.grand_order_no WHERE 1  GROUP BY s.purchase_no ORDER BY  s.purchase_id DESC LIMIT 7 ");
		$data = $query->result();

		return $data;	
	}

	public function get_product()
	{
		$query = $this->db->query("SELECT product_name,product_image_1,product_actual_price,product_serial_no,product_discount FROM product WHERE 1 = 1  ORDER BY product_id DESC LIMIT 4");
		$data = $query->result();

		return $data;	
	}

	public function get_sales_chart()
	{
		$query = $this->db->query("SELECT DISTINCT (purchase_item_name)  FROM sales WHERE return_p != 'yes' AND active='yes'");
		$data = $query->result();

		return $data;
	}

	public function get_sales_qty($p)
	{
		$query = $this->db->query('SELECT sum(purchase_item_qty) as total FROM sales WHERE return_p != "yes" AND purchase_item_name = "'.$p.'" AND active="yes" ');
		$data = $query->row_array();

		return $data;
	}

	public function sale_month_r($v)
	{
		$query = $this->db->query('SELECT count(*) as total FROM sales where return_p != "yes" AND MONTH(entry_date) ='.$v);
		$data = $query->row_array();

			if($data['total'] == '')
			{
				$data['total'] = 0;
			}
		return $data['total'];
	}

	public function total_bill()
	{
			$query = $this->db->query("SELECT count(distinct purchase_no) as total FROM sales");
			$data = $query->row_array();
			return $data['total'];	
	}
}
