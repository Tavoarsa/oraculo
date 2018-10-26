<?php
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Users_model extends CI_Model  { 
 
		
	public function __construct()
    {
        $this->load->database();
    }
 		
	public function findAll()
	{
		$this->db->where('user_id !=',1);
		return $this->db->get('users')->result();
	}
		
	public function findOne($id)
	{
		$this->db->where('user_id',$id);
		return $this->db->get('users')->row_array();
	}
		
	public function change_status($id,$mode)
	{
		$data=array('user_active'=>$mode);
		$this->db->where('user_id',$id);
		$this->db->update('users',$data);
	}
		
	public function change_password()
	{
		$data=array('password'=>base64_encode($this->input->post('txt_password')));
		$this->db->where('password',base64_encode($this->input->post('old_password')));
		$this->db->update('users',$data);
	}

	public function insert($id = 0)
	{
		$data = array(

		'user_group_id' => $this->input->post('txt_user_group_id'),
		'user_name' => $this->input->post('txt_user_name'),
		'password' => base64_encode($this->input->post('txt_password')),
		'user_active' => $this->input->post('txt_user_active'),
		
        );
        
        if ($id == 0) {
            return $this->db->insert('users', $data);
        } else {
            $this->db->where('user_id', $id);
            return $this->db->update('users', $data);
        }
	}

	public function insert_rights($id)
	{
		$this->db->where('user_id',$id);
		$this->db->delete('rights');

		for($i=1;$i<=7;$i++)
		{
			for($j=1;$j<=5;$j++)
			{
				if(isset($_POST['chk'.$j.'_'.$i]) && $_POST['chk'.$j.'_'.$i] != "")
				{
					$data = array(
						'user_id' => $id,
						'rights' => $this->input->post('chk'.$j.'_'.$i),
			        );
			        $this->db->insert('rights', $data);
				}
			}
		}

	}
		
	public function update($id)
	{
		$data = array(

		'user_group_id' => $this->input->post('txt_user_group_id'),
		'user_name' => $this->input->post('txt_user_name'),
		'user_active' => $this->input->post('txt_user_active'),
		
        );
        
        if ($id == 0) {
            return $this->db->insert('users', $data);
        } else {
            $this->db->where('user_id', $id);
            return $this->db->update('users', $data);
        }
	}
		
	public function remove($ids)
	{
		$this->db->where('user_id',$ids);
		$this->db->delete('rights');

		$this->db->where('user_id',$ids);
		$this->db->delete('users');
	}
 } 
 

?>