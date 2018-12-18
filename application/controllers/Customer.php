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

		public function get_all_provincia(){

		$query = $this->db->query("SELECT idProvincia,nombreProvincia FROM `codificacion_mh` WHERE idProvincia <=7 GROUP by nombreProvincia; ")->result();		
		return $data['provincia']=$query;
	}
	
	public function get_all_canton(){			

		$query = $this->db->query("SELECT idCanton,nombreCanton FROM `codificacion_mh`   GROUP by nombreCanton; ")->result();		
		return $data['canton']=$query;

	}
		public function get_all_distrito(){

			

		$query = $this->db->query("SELECT idDistrito,nombreDistrito FROM `codificacion_mh`  GROUP by nombreDistrito; ")->result();		
		return $data['distrito']=$query;


 }	

 	public function get_all_barrio(){

			

		$query = $this->db->query("SELECT idBarrio,nombreBarrio FROM `codificacion_mh`  GROUP by nombreBarrio; ")->result();		
		return $data['barrio']=$query;


 }	
		
	// Create method
	public function create()
	{
		$this->load->library('form_validation');


		$this->form_validation->set_rules('txtreceptor_nombre', 'Nombre', 'required');
		$this->form_validation->set_rules('txtreceptor_email', 'Email', 'required');
		$this->form_validation->set_rules('txt_customer_email', 'Email valido', 'valid_email');
		$this->form_validation->set_rules('txtreceptor_cod_pais_tel', 'Código pais', 'required');
		$this->form_validation->set_rules('txtreceptor_tel', 'Telefono', 'required');
		$this->form_validation->set_rules('txtreceptor_cod_pais_fax', 'Código Fax', 'required');
		$this->form_validation->set_rules('txtreceptor_fax', 'Fax', 'required');
		

	
		
        
        if ($this->form_validation->run() === FALSE)
        {
			$this->load->view('admin/customer/customer-add');
		}
		else
		{
			$this->customer_model->insert();
			$this->session->set_flashdata('msg','Datos Insertados Exitosamente !');
			$this->index();
		}
	}
		
	// update method
	public function update($id)
	{
		$this->customer_model->update($id);
		$this->session->set_flashdata('msg','Datos Actualizados Exitosamente !');
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
				$this->session->set_flashdata('msg','Datos Eliminados Exitosamente !');
				return redirect('customer');
			}
		}
		else
		{
				$this->customer_model->remove($id);
				$this->session->set_flashdata('msg','Datos Eliminados Exitosamente  !');
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