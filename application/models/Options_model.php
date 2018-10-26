<?php
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Options_model extends CI_Model  { 
 
		
	public function __construct()
    {
        $this->load->database();
    }
 		
	public function findAll()
	{
		$this->db->where('parent_id  !=','0');
		return $this->db->get('options')->result();
	}

	public function findAllParent()
	{
		$this->db->where('parent_id ','0');
		return $this->db->get('options')->result();
	}
		
	public function findOne($id)
	{
		$this->db->where('option_id',$id);
		return $this->db->get('options')->row_array();
	}
		
	public function change_status($id,$mode)
	{
		$data=array('option_is_active'=>$mode);
		$this->db->where('option_id',$id);
		$this->db->update('options',$data);
	}
		
	public function insert($id = 0)
	{
		$data = array(

		'parent_id' => $this->input->post('txt_parent_id'),
		'option_name' => $this->input->post('txt_option_name'),
		'option_is_active' => $this->input->post('txt_option_is_active')
		
        );
        
        if ($id == 0) {
            return $this->db->insert('options', $data);
        } else {
            $this->db->where('option_id', $id);
            return $this->db->update('options', $data);
        }
	}
		
	public function update($id)
	{
		$data = array(

		'parent_id' => $this->input->post('txt_parent_id'),
		'option_name' => $this->input->post('txt_option_name'),
		'option_is_active' => $this->input->post('txt_option_is_active')
		
        );
        
        if ($id == 0) {
            return $this->db->insert('options', $data);
        } else {
            $this->db->where('option_id', $id);
            return $this->db->update('options', $data);
        }
	}
		
	public function remove($ids)
	{
		$this->db->where('option_id',$ids);
		$this->db->delete('options');
	}
 } 
 

?>