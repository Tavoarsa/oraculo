<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_model extends CI_Model {

	public function __construct()
    {
        $this->load->database();
    }

	public function check()
    {
      
        $user_name =  $this->input->post('user_name');
        $password =  base64_encode($this->input->post('password'));
       
        $this->db->where('user_name',$user_name);
        $this->db->where('password',$password);
        $this->db->where('user_active','yes');
        return $this->db->get('users')->row_array();

    } 

}
