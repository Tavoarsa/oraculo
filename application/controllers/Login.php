<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('form');
        $this->load->model('login_model');
		
    }

	public function index()
	{
		$this->load->view('admin/login');
	}

	public function check()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('user_name', 'User Name', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');
       
        if ($this->form_validation->run() === FALSE)
        {
			$this->load->view('admin/login');
		}
		else
		{
			$data = $this->login_model->check();
			if(empty($data))
			{
				$this->session->set_flashdata('msg','Please Enter Correct User Name or Password !');
				redirect('login');
			}
			else
			{
				$newdata = array(
			        'username'  => $data['user_name'],
			        'userid'     => $data['user_id'],
			        'logged_in' => TRUE
				);

				$this->session->set_userdata($newdata);
				redirect('welcome');
			}
			
		}
	}

	public function logout()
	{
		$array_items = array('username', 'userid','logged_in');
		$this->session->unset_userdata($array_items);
		$this->session->set_flashdata('logout_msg','Success Logout , <br /> Login to Continue !');
		redirect('login');
	}

	
}
