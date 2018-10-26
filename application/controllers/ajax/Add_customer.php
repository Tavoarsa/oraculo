<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// add customer
class add_customer extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->database();
	     
    }

	// Show view Page
	public function index(){
		$name = $_GET['name'];
		$email = $_GET['email'];
		$addr = $_GET['addr'];
		$city = $_GET['city'];
		$zip = $_GET['zip'];
		$phno = $_GET['phno'];
		$cp = $_GET['conper'];
		$cppn = $_GET['cphno'];

		if($name != '' && $email != '' && $addr != '' && $city != '' && $zip != '' && $phno != '' && $cp != '' && $cppn != '')
		{
			$q = "INSERT INTO customer (customer_first_name,customer_email,customer_address,customer_city,customer_zipcode,customer_phone,contact_person,contact_person_phone,customer_is_active)
						VALUES ('".$name."','".$email."','".$addr."','".$city."','".$zip."','".$phno."','".$cp."','".$cppn."','yes')";

			$this->db->query($q);
			if($this->db->insert_id())
			{
				echo 'Customer Successfully Add';
			}

		}
	}

}
?>