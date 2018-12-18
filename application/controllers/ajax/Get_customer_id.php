<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// get customer id
class get_customer_id extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->database();
	     
    }

	// Show view Page
	public function index(){
		$name = $_GET['name'];	

		if($name != '')
		{
		  $q = "SELECT customer_id,customer_first_name,customer_email,customer_address,customer_city,customer_zipcode,customer_phone,contact_person,contact_person_phone FROM customer WHERE customer_first_name = '".$name."'";
			$res = $this->db->query($q);

			foreach ($res->result() as $row)
			{
				$id = $row->customer_id;
				$name = $row->customer_first_name;
				$email = $row->customer_email;
				$addre = $row->customer_address;
				$city = $row->customer_city;
				$zip = $row->customer_zipcode;
				$pho = $row->customer_phone;
				$cp = $row->contact_person;
				$cpp = $row->contact_person_phone;
				
				echo "$name|$email|$addre|$city|$zip|$pho|$cp|$cpp|$id";
			}
			
		}
	}
}

		
?>