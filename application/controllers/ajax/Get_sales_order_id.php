<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// user login check and bill number add		
class get_sales_order_id extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');

		$this->load->database();
	     
    }

	// Show view Page
	public function index(){


		$ad_id = $this->session->userdata('userid');
		$b_res = $this->db->query("SELECT purchase_id,purchase_billno FROM sales WHERE admin_id =".$ad_id." ORDER BY purchase_id DESC LIMIT 1");

		foreach ($b_res->result() as $row)
		{
			echo $row->purchase_billno;
		}

	}

}
	
?>