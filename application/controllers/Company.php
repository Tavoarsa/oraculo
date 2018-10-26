<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Company extends MY_Controller  { 
 
		
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
        $this->load->model('company_model');
        $data['objcompany'] = $this->company_model->findOne(1);
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
	
		
	// update method
	public function update($id)
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('txtfirst_name', 'Company Name', 'required');

		if ($this->form_validation->run() === FALSE)
        {
        	redirect('company/edit');
        }
        else
        {
        	$this->company_model->update($id);
			$this->session->set_flashdata('msg','Successfully Update Data !');

			if(!empty($_FILES['fl_clogo']['name']))
			{
				$file_info =$this->file_upload_m('fl_clogo',$id);
				if(is_array($file_info))
				{
					$file_name = $file_info['file_name'];
					if($file_name != ''){
						$this->company_model->update_image_f($id,$file_name);
					}
				}
			}

			
			redirect('company/edit');
        }


		
		
	}
		
	// edit method
	public function edit()
	{
		$data['objcompany'] = $this->company_model->findOne(1);
		$this->load->view('admin/company/company-edit',$data);
	}
	
	public function file_upload_m($file_name,$new_name)
    {
        $config['upload_path']          = './file/company/';
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