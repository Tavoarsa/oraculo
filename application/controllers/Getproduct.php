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

		$cid = $this->input->post('cid');
		$subid = $this->input->post('subid');

		if($cid != '' && $subid != '')
		{
			$query = $this->db->query('select product_serial_no,product_id,product_name,product_image_1  from product where product_is_active = "yes" AND sub_category_id ='.$subid.' AND category_id = '.$cid);

			$r_data = 'mmm';
			foreach ($query->result() as $row)
			{
				$product_photo = base_url().'file/product/'.$row['product_image_1'];
				$r_data .='<a  style="height:130px;width:100px;white-space:normal; overflow:hidden;font-weight: 700;"
			 			id="subcatname" class="btn btn-app" onclick="productadd(\''.trim($row['product_serial_no']).'\')">
						<div style="background-image:url('. $product_photo.'); background-size: 80px 80px;  height: 80px;width: 80px;" ></div>
			 			<br />
             '.$row['product_name'].'            
           </a>';
			}

			return $r_data;
		}
	}


}



	/*require_once("include/general-includes.php");
	// get product
	require_once COMPONENTS_DIR . 'product/class/clsproduct.php';	
	$objproduct = new product();
	
	$cid = $_POST['cid'];
	$subid = $_POST['subid'];
	if($cid != '' && $subid != '')
	{
		
		$field = 'product_serial_no,product_id,product_name,product_image_1';
		$condition = ' AND product_is_active = "yes" AND sub_category_id ='.$subid.' AND category_id = '.$cid.'';
		$product = $objproduct->get_record_fields($field,$condition);
		
		foreach($product as $_p)
		{
			$product_photo = common::get_relative_path(PRODUCT_IMAGE_THUMB_UPLOAD_DIR) . common::get_value($_p['product_image_1']);
			echo '<a  style="height:130px;width:100px;white-space:normal; overflow:hidden;font-weight: 700;"
			 			id="subcatname" class="btn btn-app" onclick="productadd(\''.trim($_p['product_serial_no']).'\')">
						<div style="background-image:url('. $product_photo.'); background-size: 80px 80px;  height: 80px;width: 80px;" ></div>
			 			<br />
             '.$_p['product_name'].'            
           </a>';
		}
		
	}*/

?>