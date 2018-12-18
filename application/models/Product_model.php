<?php
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Product_model extends CI_Model  { 
 
		
	public function __construct()
    {
        $this->load->database();
        $this->load->library('session');
    }
 		
	public function findAll()
	{
		return $this->db->get('product')->result();
	}
		
	public function findOne($id)
	{
		$this->db->where('product_id',$id);
		return $this->db->get('product')->row_array();
	}
		
	public function change_status($id,$mode)
	{
		$data=array('product_is_active'=>$mode);
		$this->db->where('product_id',$id);
		$this->db->update('product',$data);
	}
		
	public function insert($id = 0)
	{
		$data = array(

		'admin_id' => $this->session->userdata('userid'),
		'sub_category_id' => $this->input->post('txt_sub_category_id'),
		'product_name' => $this->input->post('txt_product_name'),
		'product_serial_no' => $this->input->post('txt_product_serial_no'),
		'product_description' => $this->input->post('txt_product_description'),
		'product_is_active' => $this->input->post('txt_product_is_active'),
		'entry_date' => date('Y-m-d')
		
        );
        
        if ($id == 0) {
            return $this->db->insert('product', $data);
        } else {
            $this->db->where('product_id', $id);
            return $this->db->update('product', $data);
        }
	}
	
	public function delete_option($id)
	{
		$this->db->where('product_id',$id);
		$this->db->delete('product_option');
	}
	public function insert_option($id)
	{
		$option =  $this->input->post('txtoption');
		$option_stock = $this->input->post('txtstock');

		for ($i=0; $i < count($this->input->post('txtoption')) ; $i++) { 
			
			$data = array(

			'product_id' => $id,
			'sub_category_id' => $this->input->post('txt_sub_category_id'),
			'option_id' => $option[$i],
			'product_option_stock' => $option_stock[$option[$i]]
			);
			$this->db->insert('product_option', $data);
		}
		
	}

	public function update($id)
	{
		$data = array(

		'admin_id' => $this->session->userdata('userid'),
		'sub_category_id' => $this->input->post('txt_sub_category_id'),
		'product_name' => $this->input->post('txt_product_name'),
		'product_serial_no' => $this->input->post('txt_product_serial_no'),
		'product_description' => $this->input->post('txt_product_description'),
		'product_is_active' => $this->input->post('txt_product_is_active')

        );
        
        if ($id == 0) {
            return $this->db->insert('product', $data);
        } else {
            $this->db->where('product_id', $id);
            return $this->db->update('product', $data);
        }
	}
	
	public function update_image_f($id,$file_name)
	{
		$data=array('product_image_1'=>$file_name);
		$this->db->where('product_id',$id);
		$this->db->update('product',$data);
	}

	public function remove($ids)
	{
		$this->db->where('product_id',$ids);
		$this->db->delete('product');
	}
 } 
 

?>