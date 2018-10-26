<?php
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Customer_model extends CI_Model  { 
 
		
	public function __construct()
    {
        $this->load->database();
    }
 		
	public function findAll()
	{
		return $this->db->get('customer')->result();
	}
		
	public function findOne($id)
	{
		$this->db->where('customer_id',$id);
		return $this->db->get('customer')->row_array();
	}

	public function change_status($id,$mode)
	{
		$data=array('customer_is_active'=>$mode);
		$this->db->where('customer_id',$id);
		$this->db->update('customer',$data);
	}
		
	public function insert($id = 0)
	{
		$data = array(

		'customer_first_name' => $this->input->post('txt_customer_first_name'),
		'customer_email' => $this->input->post('txt_customer_email'),
		'customer_address' => $this->input->post('txt_customer_address'),
		'customer_city' => $this->input->post('txt_customer_city'),
		'customer_zipcode' => $this->input->post('txt_customer_zipcode'),
		'customer_phone' => $this->input->post('txt_customer_phone'),
		'contact_person' => $this->input->post('txt_contact_person'),
		'customer_is_active' => $this->input->post('txt_customer_is_active'),
		'contact_person_phone' => $this->input->post('txt_contact_person_phone')
		
        );
        
        if ($id == 0) {
            return $this->db->insert('customer', $data);
        } else {
            $this->db->where('customer_id', $id);
            return $this->db->update('customer', $data);
        }
	}
		
	public function update($id)
	{
		$data = array(

		'customer_first_name' => $this->input->post('txt_customer_first_name'),
		'customer_email' => $this->input->post('txt_customer_email'),
		'customer_birthdate' => $this->input->post('txt_customer_birthdate'),
		'customer_address' => $this->input->post('txt_customer_address'),
		'customer_city' => $this->input->post('txt_customer_city'),
		'customer_zipcode' => $this->input->post('txt_customer_zipcode'),
		'customer_phone' => $this->input->post('txt_customer_phone'),
		'contact_person' => $this->input->post('txt_contact_person'),
		'contact_person_phone' => $this->input->post('txt_contact_person_phone'),
		'customer_is_active' => $this->input->post('txt_customer_is_active')

	);
        
        if ($id == 0) {
            return $this->db->insert('customer', $data);
        } else {
            $this->db->where('customer_id', $id);
            return $this->db->update('customer', $data);
        }
	}
		
	public function remove($ids)
	{
		$this->db->where('customer_id',$ids);
		$this->db->delete('customer');
	}
} 
 

?>