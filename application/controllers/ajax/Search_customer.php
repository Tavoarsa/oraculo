<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class search_customer extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->database();
	     
    }

	// Show view Page
	public function index(){
		$data = array();
		//get search term
		$searchTerm = $_GET['term'];
		//get matched data from skills table

		$m_query = $this->db->query("SELECT * FROM customer WHERE customer_first_name LIKE '%".$searchTerm."%' ORDER BY customer_first_name ASC");

		foreach ($m_query->result() as $row)
		{
			$data[] = $row->customer_first_name;
		}

		echo json_encode($data);
	}
}

?>