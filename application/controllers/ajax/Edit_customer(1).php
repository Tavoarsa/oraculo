<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// add customer
class edit_customer extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->database();
	     
    }

	// Show view Page
	public function index(){

		$id = $_GET['id'];
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
			$q = "UPDATE customer SET customer_first_name = '".$name."',customer_email = '".$email."',customer_address = '".$addr."',customer_city='".$city."',customer_zipcode='".$zip."',customer_phone='".$phno."',contact_person='".$cp."',contact_person_phone='".$cppn."' WHERE customer_id = ".$id;

			$this->db->query($q);
			if($this->db->affected_rows())
			{
				echo 'Customer Detail Successfully Update';
			}

		}
	}

}
?>