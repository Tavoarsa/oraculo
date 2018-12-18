<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// user login check and bill number add		
class edit_bill_name extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->database();
	     
    }

	// Show view Page
	public function index(){
		$oldname = $_GET['oldname'];
		$pid = $_GET['billpid'];
		$oldname = intval($oldname) - $pid;
		$name = $this->input->get('name');
		$id = $this->session->userdata('userid');

		$this->db->query("UPDATE bill_number SET bill_number = '".$name."' WHERE bill_number = '".$oldname."' AND admin_id = ".$id."");
		$inp = '|';
		if($this->db->affected_rows())
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


