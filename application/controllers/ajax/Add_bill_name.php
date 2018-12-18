<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// user login check and bill number add		
class add_bill_name extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->database();
	     
    }

	// Show view Page
	public function index(){
		$inp = '|';
		$selected = +1;
		$name = $this->input->get('name');
		$id = $this->session->userdata('userid');

		$this->db->query("insert into bill_number (bill_number,admin_id) values ('".$name."',".$id.")");

		if($this->db->insert_id())
		{
			$b_res = $this->db->query("SELECT bill_id,bill_number,bill_perant_id FROM bill_number WHERE admin_id =".$id);
			foreach ($b_res->result() as $row)
			{
				$billname = $row->bill_number;
				$id = $row->bill_id;
				$pid = $row->bill_perant_id;
				$fno = intval($billname) + intval($pid);
				
				if($fno == $selected){ $r= "selected";}else $r ='';
				
				echo '<option value="'.$fno.'" '.$r.'>'.$fno.'</option>';
				$inp .= '<input type="hidden"  name="billname_'.$fno.'" value="'.$id.'" />';
				$inp .= '<input type="hidden"  id="billid_'.$fno.'" value="'.$pid.'" />';
			}
			echo $inp;	
		}
	}
}
?>