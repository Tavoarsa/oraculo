<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class getproduct extends CI_Controller {

	public function __construct() 
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->database();
	    
    }

	// Show view Page
	public function index(){

		$cid = $this->input->get('cid');
		$subid = $this->input->get('subid');

		if($cid != '' && $subid != '')
		{
			$query = $this->db->query('select product_serial_no,product_id,product_name,product_image_1  from product where product_is_active = "yes" AND sub_category_id ='.$subid.' AND category_id = '.$cid);

			foreach ($query->result() as $row)
			{
				$product_photo = base_url().'file/product/'.$row->product_image_1;
				echo '<a  
			 			id="subcatname" class="btn btn-app table_cat" onclick="productadd(\''.trim($row->product_serial_no).'\')">
						<div style="background-image:url('. $product_photo.'); background-size: 80px 80px;  height: 80px;width: 80px;" ></div>
			 			<br />
            			 '.$row->product_name.'            
          			 </a>';
			}

		}
	}


}

?>