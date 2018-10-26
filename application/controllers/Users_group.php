<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Users_group extends MY_Controller  { 
 
		
	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
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
        $this->load->model('users_group_model');
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
		$data['recored'] = $this->users_group_model->findAll();
		$this->load->view('admin/users_group/users_group-list',$data);
	}
 		
		
	// Create method
	public function create()
	{
		$this->load->library('form_validation');


		$this->form_validation->set_rules('txt_user_group_name', 'User group name', 'required');
		$this->form_validation->set_rules('txt_user_group_active', 'User group active', 'required');
		
        
        if ($this->form_validation->run() === FALSE)
        {
			$this->load->view('admin/users_group/users_group-add');
		}
		else
		{
			$this->users_group_model->insert();
			$this->session->set_flashdata('msg','Successfully Insert Data !');
			$this->index();
		}
	}
		
	// update method
	public function update($id)
	{
		$this->users_group_model->update($id);
		$this->session->set_flashdata('msg','Successfully Update Data !');
		$this->index();
	}
		
	// edit method
	public function edit($id)
	{
		$data['recored'] = $this->users_group_model->findOne($id);
		$this->load->view('admin/users_group/users_group-edit',$data);
	}
		
	// delete method
	public function delete($id)
	{
		if($this->session->userdata('userid') != 1)
	    {

			$rights = $this->check_rights();
			if(!in_array('users_group/delete', $rights))
	    	{
	    		return redirect('access');
	    	}
	    	else
	    	{
	    		$this->users_group_model->remove($id);
				$this->session->set_flashdata('msg','Successfully Delete Data !');
				
				return redirect('users_group');
			}
		}
		else
		{
				$this->users_group_model->remove($id);
				$this->session->set_flashdata('msg','Successfully Delete Data !');
				
				return redirect('users_group');
		}
	}
		
	public function active_inactive($id,$mode)
	{
		$this->users_group_model->change_status($id,$mode);
		return redirect('users_group');
	}
 } 
 

?>