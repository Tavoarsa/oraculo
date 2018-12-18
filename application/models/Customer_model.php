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

	
	public function insert($id = 0)
	{
		$data = array(

		'receptor_nombre' => $this->input->post('txtreceptor_nombre'),
		'receptor_tipo_identif' => $this->input->post('receptor_tipo_indetif'),
		'receptor_num_identif' => $this->input->post('txtreceptor_num_identif'),
		'receptor_provincia' => $this->input->post('cbx_provincia'),
		'receptor_canton' => $this->input->post('cbx_canton'),
		'receptor_distrito' => $this->input->post('cbx_distrito'),
		'receptor_barrio' => $this->input->post('cbx_barrio'),
		'receptor_cod_pais_tel' => $this->input->post('txtreceptor_cod_pais_tel'),
		'receptor_tel' => $this->input->post('txtreceptor_tel'),
		'receptor_cod_pais_fax' => $this->input->post('txtreceptor_cod_pais_fax'),
		'receptor_fax' => $this->input->post('txtreceptor_fax'),
		'receptor_email' => $this->input->post('txtreceptor_email')
		
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

		'receptor_nombre' => $this->input->post('txtreceptor_nombre'),
		'receptor_tipo_identif' => $this->input->post('receptor_tipo_indetif'),
		'receptor_num_identif' => $this->input->post('txtreceptor_num_identif'),
		'receptor_provincia' => $this->input->post('cbx_provincia'),
		'receptor_canton' => $this->input->post('cbx_canton'),
		'receptor_distrito' => $this->input->post('cbx_distrito'),
		'receptor_barrio' => $this->input->post('cbx_barrio'),
		'receptor_cod_pais_tel' => $this->input->post('txtreceptor_cod_pais_tel'),
		'receptor_tel' => $this->input->post('txtreceptor_tel'),
		'receptor_cod_pais_fax' => $this->input->post('txtreceptor_cod_pais_fax'),
		'receptor_fax' => $this->input->post('txtreceptor_fax'),
		'receptor_email' => $this->input->post('txtreceptor_email')

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