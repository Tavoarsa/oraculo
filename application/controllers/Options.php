<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Options extends MY_Controller  { 
 
		
	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->library('Pdf_Library');
		$this->load->library('Excel_Library');
		$this->load->database();
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
        $this->load->model('options_model');
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
		$data['recored'] = $this->options_model->findAll();
		$this->load->view('admin/options/options-list',$data);
	}
 	
	// GET PARENT OPTION NAME
	public function get_onpation_name($id)
	{
		$this->db->where('option_id ',$id);
		$data['name'] = $this->db->get('options')->row_array();

		return $data['name']['option_name'];
	}

	// GET All PARENT OPTION
	public function get_all_parent()
	{
		$this->db->where('parent_id','0');
		$data['name'] = $this->db->get('options')->result();

		return $data['name'];
	}

		
	// Create method
	public function create()
	{
		$this->load->library('form_validation');


		$this->form_validation->set_rules('txt_option_name', 'Option name', 'required');
		$this->form_validation->set_rules('txt_option_is_active', 'Option is active', 'required');
		
        
        if ($this->form_validation->run() === FALSE)
        {
			$this->load->view('admin/options/options-add');
		}
		else
		{
			$this->options_model->insert();
			$this->session->set_flashdata('msg','Successfully Insert Data !');
			$this->index();
		}
	}
		
	// update method
	public function update($id)
	{
		$this->options_model->update($id);
		$this->session->set_flashdata('msg','Successfully Update Data !');
		$this->index();
	}
		
	// edit method
	public function edit($id)
	{
		$data['recored'] = $this->options_model->findOne($id);
		$this->load->view('admin/options/options-edit',$data);
	}
		
	// delete method
	public function delete($id)
	{
		if($this->session->userdata('userid') != 1)
	    {

			$rights = $this->check_rights();
			if(!in_array('options/delete', $rights))
	    	{
	    		return redirect('access');
	    	}
	    	else
	    	{
	    		$this->options_model->remove($id);
				$this->session->set_flashdata('msg','Successfully Delete Data !');
				return redirect('options');
			}
		}
		else
		{
				$this->options_model->remove($id);
				$this->session->set_flashdata('msg','Successfully Delete Data !');
				return redirect('options');
		}
		
	}
		
	public function active_inactive($id,$mode)
	{
		$this->options_model->change_status($id,$mode);
		return redirect('options');
	}
 } 
 

?>