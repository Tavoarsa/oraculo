<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();

    }

    public function check_rights()
    {
        $this->db->where('user_id',$this->session->userdata('userid'));
        $data = $this->db->get('rights')->result();

        $user_rights = array();

        foreach ($data as $value) {
            $user_rights[] = $value->rights;
        }

        return $user_rights;
    }

}


?>