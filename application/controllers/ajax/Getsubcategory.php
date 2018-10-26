<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class getsubcategory extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->database();
	     
    }

	// Show view Page
	public function index(){

		$id = $this->input->get('id');
		
			$query = $this->db->query('select * from category where category_is_active = "yes" AND parent_id ='.$id);

			foreach ($query->result() as $row)
			{
				$photo = base_url().'file/subcategory/'.$row->category_image;
				echo '<a id="subcatname_'.$row->category_id.'" class="btn btn-app table_cat" onclick="getproduct('.$id.','.$row->category_id.')">
							<div style="background-image:url('. $photo.'); background-size: 80px 80px;  height: 80px;width: 80px;" ></div>
							<br />
		            		 '.$row->category_name.'            
		          	</a>';
			}

		
	}


}

?>