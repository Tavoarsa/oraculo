<?php
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Users_group_model extends CI_Model  { 
 
		
	public function __construct()
    {
        $this->load->database();
    }
 		
	public function findAll()
	{
		return $this->db->get('users_group')->result();
	}
		
	public function findOne($id)
	{
		$this->db->where('user_group_id',$id);
		return $this->db->get('users_group')->row_array();
	}
		
	public function change_status($id,$mode)
	{
		$data=array('user_group_active'=>$mode);
		$this->db->where('user_group_id',$id);
		$this->db->update('users_group',$data);
	}
		
	public function insert($id = 0)
	{
		$data = array(

		'user_group_name' => $this->input->post('txt_user_group_name'),
		'user_group_active' => $this->input->post('txt_user_group_active'),
		'create_date' => $this->input->post('txt_create_date'),

        );
        
        if ($id == 0) {
            return $this->db->insert('users_group', $data);
        } else {
            $this->db->where('user_group_id', $id);
            return $this->db->update('users_group', $data);
        }
	}
		
	public function update($id)
	{
		$data = array(

		'user_group_name' => $this->input->post('txt_user_group_name'),
		'user_group_active' => $this->input->post('txt_user_group_active'),
		'create_date' => $this->input->post('txt_create_date'),

        );
        
        if ($id == 0) {
            return $this->db->insert('users_group', $data);
        } else {
            $this->db->where('user_group_id', $id);
            return $this->db->update('users_group', $data);
        }
	}
		
	public function remove($ids)
	{
		$this->db->where('user_group_id',$ids);
		$this->db->delete('users_group');
	}
 } 
 

?>