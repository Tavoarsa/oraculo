<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Category extends MY_Controller  { 
 
		
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
        $this->load->model('category_model');
    }
 		
	// index method
	public function index()
	{
		$data['recored'] = $this->category_model->findAll();
		$this->load->view('admin/category/category-list',$data);
	}
 		
	// pdf method
	public function pdf()
	{
		$data['recored'] = $this->category_model->findAll();
		$this->load->view('admin/category/category-pdf',$data);
	}
 		
	// excel method
	public function excel()
	{
		$data['recored'] = $this->category_model->findAll();
		$this->load->view('admin/category/category-excel',$data);
	}
		
	// Create method
	public function create()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('txt_category_name', 'Sub Category name', 'required');
		$this->form_validation->set_rules('txt_category_description', 'Category description', 'required');
		$this->form_validation->set_rules('txt_category_is_active', 'Active', 'required');
		
        
        if ($this->form_validation->run() === FALSE)
        {
			$this->load->view('admin/category/category-add');
		}
		else
		{
			
			$this->category_model->insert();

			$file_info = $this->file_upload_m('txt_category_image',$this->db->insert_id());
			if(is_array($file_info))
			{
				$file_name = $file_info['file_name'];
				if($file_name != ''){
					$this->category_model->update_image_f($this->db->insert_id(),$file_name);
				}
				$this->session->set_flashdata('msg','Successfully Update Data !');
			    $this->index();
			}
			else
			{
				$error = $file_info;
				$data['error'] = $error;
				$this->load->view('admin/category/category-add',$data);
			}
		}
	}
		
	// update method
	public function update($id)
	{
		$this->category_model->update($id);
		$file_info =$this->file_upload_m('txt_category_image',$id);
		if(is_array($file_info))
		{
			$file_name = $file_info['file_name'];
			if($file_name != ''){
				$this->category_model->update_image_f($id,$file_name);
			}
			$this->session->set_flashdata('msg','Successfully Update Data !');
		    $this->index();
		}
		else
		{
			$error = $file_info;
			$data['recored'] = $this->category_model->findOne($id);
			$data['error'] = $error;
			$this->load->view('admin/category/category-edit',$data);
		}

		
	}
	
	//get_name_sub
	public function get_name_sub($id)
	{
		$data['sin']=$this->category_model->findOne($id);
		return $data['sin']['category_name'];
	}

	// edit method
	public function edit($id)
	{
		$data['recored'] = $this->category_model->findOne($id);
		$this->load->view('admin/category/category-edit',$data);
	}
		
	// delete method
	public function delete($id)
	{
		
		if($this->session->userdata('userid') != 1)
	    {

			$rights = $this->check_rights();
			if(!in_array('category/delete', $rights))
	    	{
	    		return redirect('access');
	    	}
	    	else
	    	{
	    		$this->category_model->remove($id);
				$this->session->set_flashdata('msg','Successfully Delete Data !');
				
				return redirect('category');
			}
		}
		else
		{
				$this->category_model->remove($id);
				$this->session->set_flashdata('msg','Successfully Delete Data !');
				
				return redirect('category');
		}
		
	}


	public function active_inactive($id,$mode)
	{
		$this->category_model->change_status($id,$mode);
		return redirect('category');
	}

	public function file_upload_m($file_name,$new_name)
    {
        $config['upload_path']          = './file/subcategory/';
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

 } 
 

?>