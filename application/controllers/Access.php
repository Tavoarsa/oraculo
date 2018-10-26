<?php
error_reporting(E_ALL ^ E_WARNING ^ E_NOTICE);
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Access extends MY_Controller  { 
 
		
	public function __construct()
    {
        parent::__construct();
    }

    public function index()
	{
		$this->load->view('admin/not_access');
	}


 }
?>