<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');

class Customer extends MY_Controller  { 
 
		 
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
        $this->load->model('customer_model');
    }
 		
	// index method
	public function index()
	{
		$data['recored'] = $this->customer_model->findAll();
		$this->load->view('admin/customer/customer-list',$data);
	}
 	
	public function get_company_data()
	{
		return $this->db->get('company')->result();
	}
 		
	// pdf method
	public function pdf()
	{
		$data['recored'] = $this->customer_model->findAll();
		$this->load->view('admin/customer/customer-pdf',$data);
	}
 		
	// excel method
	public function excel()
	{
		$data['recored'] = $this->customer_model->findAll();
		$this->load->view('admin/customer/customer-excel',$data);
	}
		
	// Create method
	public function create()
	{
		$this->load->library('form_validation');


		$this->form_validation->set_rules('txt_customer_first_name', 'Customer first name', 'required');
		$this->form_validation->set_rules('txt_customer_email', 'Customer email', 'required');
		$this->form_validation->set_rules('txt_customer_email', 'Valid email', 'valid_email');
		$this->form_validation->set_rules('txt_customer_address', 'Customer address', 'required');
		$this->form_validation->set_rules('txt_customer_city', 'Customer city', 'required');
		$this->form_validation->set_rules('txt_customer_zipcode', 'Customer zipcode', 'required');
		$this->form_validation->set_rules('txt_customer_phone', 'Customer phone', 'required');
		$this->form_validation->set_rules('txt_contact_person', 'Contact person', 'required');
		$this->form_validation->set_rules('txt_contact_person_phone', 'Contact person phone', 'required');

		$this->form_validation->set_rules('txt_customer_is_active', 'Active', 'required');
		
        
        if ($this->form_validation->run() === FALSE)
        {
			$this->load->view('admin/customer/customer-add');
		}
		else
		{
			$this->customer_model->insert();
			$this->session->set_flashdata('msg','Successfully Insert Data !');
			$this->index();
		}
	}
		
	// update method
	public function update($id)
	{
		$this->customer_model->update($id);
		$this->session->set_flashdata('msg','Successfully Update Data !');
		$this->index();
	}
		
	// edit method
	public function edit($id)
	{
		$data['recored'] = $this->customer_model->findOne($id);
		$this->load->view('admin/customer/customer-edit',$data);
	}
		
	// delete method
	public function delete($id)
	{
		
		if($this->session->userdata('userid') != 1)
	    {

			$rights = $this->check_rights();
			if(!in_array('cutomer/delete', $rights))
	    	{
	    		return redirect('access');
	    	}
	    	else
	    	{
	    		$this->customer_model->remove($id);
				$this->session->set_flashdata('msg','Successfully Delete Data !');
				return redirect('customer');
			}
		}
		else
		{
				$this->customer_model->remove($id);
				$this->session->set_flashdata('msg','Successfully Delete Data !');
				return redirect('customer');
		}
		
	}

	public function active_inactive($id,$mode)
	{
		$this->customer_model->change_status($id,$mode);
		return redirect('customer');
	}

 } 
 

?>