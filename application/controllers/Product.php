<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Product extends MY_Controller  { 
 
		
	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->library('Pdf_Library');
		$this->load->library('Excel_Library');
        if (!$this->session->userdata('logged_in'))
	    { 
	        redirect('login');
	    }
	    else
	    {
	    	if($this->session->userdata('userid') != 1)
	    	{
		    	$rights = $this->check_rights();
		    	$url = $this->uri->segment(1).'/'.$this->uri->segment(2);
		    	if(!in_array($url, $rights))
		    	{
		    		$this->load->view('admin/not_access');
		    	}
		    }
	    }
	    
        $this->load->helper('form');
        $this->load->model('product_model');
    }
	
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/home
	 *	- or -
	 * 		http://example.com/index.php/home/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/home/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	
 		
	// index method
	public function index()
	{
		$data['recored'] = $this->product_model->findAll();
		$this->load->view('admin/product/product-list',$data);
	}
 		
	// pdf method
	public function pdf()
	{
		$data['recored'] = $this->product_model->findAll();
		$this->load->view('admin/product/product-pdf',$data);
	}
 	
	// GET  Category Name
	public function get_category_name($id)
	{
		$this->db->where('category_id',$id);
		$data['name'] = $this->db->get('category')->row_array();
		return $data['name']['category_name'];
	}

	// get main option 
	public function get_main_option()
	{
		$this->db->where('parent_id','0');
		$this->db->where('option_is_active', 'yes');
		return $data['name'] = $this->db->get('options')->result();

	}

	// get child option 
	public function get_c_option($id)
	{
		$this->db->where('parent_id',$id);
		$this->db->where('option_is_active', 'yes');
		return $data['name'] = $this->db->get('options')->result();
	}

	public function get_product_option($id)
	{
		$query = $this->db->query('select option_id,product_option_stock from product_option where product_id ='.$id);
		$option = array();
		foreach ($query->result() as $row)
		{
		        $option[$row->option_id] = $row->product_option_stock ;
		}
		
		return $option;
	}
	// GET All Category 
	public function get_All_category()
	{
		$this->db->where('parent_id !=','0');
		return $data['category'] = $this->db->get('category')->result();
	}

	// excel method
	public function excel()
	{
		$data['recored'] = $this->product_model->findAll();
		$this->load->view('admin/product/product-excel',$data);
	}
		
	// Create method
	public function create()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('txt_sub_category_id', 'Sub category id', 'required');
		$this->form_validation->set_rules('txt_product_name', 'Product name', 'required');
		$this->form_validation->set_rules('txt_product_serial_no', 'Product serial no', 'required');
		$this->form_validation->set_rules('txt_product_description', 'Product description', 'required');
		$this->form_validation->set_rules('txt_product_is_active', 'Product is active', 'required');
		if (empty($_FILES['txt_product_image_1']['name']))
		{
			$this->form_validation->set_rules('txt_product_image_1', 'Product Image', 'required');
		}
        
        if ($this->form_validation->run() === FALSE)
        {
			$this->load->view('admin/product/product-add');
		}
		else
		{
			$this->product_model->insert();
			$_pid = $this->db->insert_id();
			$this->product_model->insert_option($_pid);
			
			$file_info = $this->file_upload_m('txt_product_image_1',$_pid);
			if(is_array($file_info))
			{
				$file_name = $file_info['file_name'];
				if($file_name != ''){
					$this->product_model->update_image_f($_pid,$file_name);
				}
				$this->session->set_flashdata('msg','Successfully Update Data !');
			    $this->index();
			}
			else
			{
				$error = $file_info;
				$data['error'] = $error;
				$this->load->view('admin/product/product-add',$data);
			}

			
		}
	}
	
	
	// update method
	public function update($id)
	{
		$this->product_model->update($id);
		$this->product_model->delete_option($id);
		$this->product_model->insert_option($id);
		if(!empty($_FILES['txt_product_image_1']['name'])){
			$file_info =$this->file_upload_m('txt_product_image_1',$id);
			if(is_array($file_info))
			{
				$file_name = $file_info['file_name'];
				if($file_name != ''){
					$this->product_model->update_image_f($id,$file_name);
				}
				$this->session->set_flashdata('msg','Successfully Update Data !');
			    $this->index();
			}
			else
			{
				$error = $file_info;
				$data['recored'] = $this->product_model->findOne($id);
				$data['error'] = $error;
				$this->load->view('admin/product/product-edit',$data);
			}
		}
		else
		{
			$this->session->set_flashdata('msg','Successfully Update Data !');
			$this->index();
		}
		
			
		
	}
	
	public function file_upload_m($file_name,$new_name)
    {
        $config['upload_path']          = './file/product/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['file_name'] 			= $new_name;
        $config['overwrite'] 		= TRUE;
        
        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload($file_name))
        {
            return  $data = $this->upload->display_errors();
		}
		else
		{
			return  $data = $this->upload->data();
		}
        
	}

	// edit method
	public function edit($id)
	{
		$data['recored'] = $this->product_model->findOne($id);
		$this->load->view('admin/product/product-edit',$data);
	}
		 
	// delete method
	public function delete($id) 
	{
		if($this->session->userdata('userid') != 1)
	    {

			$rights = $this->check_rights();
			if(!in_array('product/delete', $rights))
	    	{
	    		return redirect('access');
	    	}
	    	else
	    	{
	    		$this->product_model->remove($id);
				$this->session->set_flashdata('msg','Successfully Delete Data !');
				return redirect('product');
			}
		}
		else
		{
				$this->product_model->remove($id);
				$this->session->set_flashdata('msg','Successfully Delete Data !');
				return redirect('product');
		}
	}
		
	public function active_inactive($id,$mode)
	{
		$this->product_model->change_status($id,$mode);
		return redirect('product');
	}
 } 
 

?>