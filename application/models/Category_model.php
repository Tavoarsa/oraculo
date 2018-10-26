<?php
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Category_model extends CI_Model  { 
 
		
	public function __construct()
    {
        $this->load->database();
    }
 		
	public function findAll()
	{
		$this->db->where('category_id  !=','28');
		return $this->db->get('category')->result();
	}
		
	public function findOne($id)
	{
		$this->db->where('category_id',$id);
		return $this->db->get('category')->row_array();
	}

	public function change_status($id,$mode)
	{
		$data=array('category_is_active'=>$mode);
		$this->db->where('category_id',$id);
		$this->db->update('category',$data);
	}
		
	public function insert($id = 0)
	{
		$data = array(

		'category_name' => $this->input->post('txt_category_name'),
		'category_is_active' => $this->input->post('txt_category_is_active'),
		'category_description' => $this->input->post('txt_category_description')
		
        );
        
        if ($id == 0) {
            return $this->db->insert('category', $data);
        } else {
            $this->db->where('category_id', $id);
            return $this->db->update('category', $data);
        }
	}
	
	public function update_image_f($id,$file_name)
	{
		$data=array('category_image'=>$file_name);
		$this->db->where('category_id',$id);
		$this->db->update('category',$data);
	}

	public function update($id)
	{
		$data = array(

		'category_name' => $this->input->post('txt_category_name'),
		'parent_id' => $this->input->post('txt_category_id'),
		'category_description' => $this->input->post('txt_category_description')
		
        );
        
        if ($id == 0) {
            return $this->db->insert('category', $data);
        } else {
            $this->db->where('category_id', $id);
            return $this->db->update('category', $data);
        }
	}
		
	public function remove($ids)
	{
		$this->db->where('category_id',$ids);
		$this->db->delete('category');
	}
 } 
 

?>