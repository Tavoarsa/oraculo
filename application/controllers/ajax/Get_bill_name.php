<?php
defined('BASEPATH') OR exit('No direct script access allowed');
// user login check and bill number add		
class get_bill_name extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->database();
	     
    }

	// Show view Page
	public function index(){

		$inp = '|';
		if(isset($_GET['selectedno'])){
			$selected = $_GET['selectedno']+1;
		}
		else
		{
			$selected = 1;
		}
		
		$ad_id = $this->session->userdata('userid');

		$b_res = $this->db->query("SELECT bill_id,bill_number,bill_perant_id FROM bill_number WHERE admin_id =".$ad_id);
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

?>