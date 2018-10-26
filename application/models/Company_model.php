<?php
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Company_model extends CI_Model  { 
 
		
	public function __construct()
    {
        $this->load->database();
    }
 		
	public function findAll()
	{
		return $this->db->get('company')->result();
	}
		
	public function findOne($id)
	{
		$this->db->where('company_id',$id);
		return $this->db->get('company')->row_array();
	}
		
	public function change_status($id,$mode)
	{
		$data=array('customer_is_active'=>$mode);
		$this->db->where('company_id',$id);
		$this->db->update('company',$data);
	}
		
	public function insert($id = 0)
	{
		$data = array(

		'company_name' => $this->input->post('txt_company_name'),
		'company_city' => $this->input->post('txt_company_city'),
		'company_address' => $this->input->post('txt_company_address'),
		'company_image' => $this->input->post('txt_company_image'),
		'company_vat_no' => $this->input->post('txt_company_vat_no'),
		'company_cst_no' => $this->input->post('txt_company_cst_no'),
		'company_gst_no' => $this->input->post('txt_company_gst_no'),
		'recipe_print' => $this->input->post('txt_recipe_print'),
		'currency' => $this->input->post('txt_currency'),
		'currency_symbol' => $this->input->post('txt_currency_symbol'),
		'sales_tax1' => $this->input->post('txt_sales_tax1'),
		'sales_tax2' => $this->input->post('txt_sales_tax2'),
		'sales_tax3' => $this->input->post('txt_sales_tax3'),
		'total_table' => $this->input->post('txt_total_table'),
		'total_parcel' => $this->input->post('txt_total_parcel'),
		'sms' => $this->input->post('txt_sms'),
		'sms_api' => $this->input->post('txt_sms_api'),
		'company_terms' => $this->input->post('txt_company_terms'),
		'backup_time' => $this->input->post('txt_backup_time'),
		'company_is_active' => $this->input->post('txt_company_is_active'),
		'create_date' => $this->input->post('txt_create_date'),
		'company_phone' => $this->input->post('txt_company_phone'),

        );
        
        if ($id == 0) {
            return $this->db->insert('company', $data);
        } else {
            $this->db->where('company_id', $id);
            return $this->db->update('company', $data);
        }
	}
		
	public function update($id)
	{
		if($this->input->post('chkdelete_logo') == 'yes')
		{
			$data=array('company_image'=>'');
			$this->db->where('company_id',$id);
			$this->db->update('company',$data);
		}
		

		$data = array(

		'company_name' => $this->input->post('txtfirst_name'),
		'company_city' => $this->input->post('txtcity'),
		'company_address' => $this->input->post('txtaddress'),
		'company_vat_no' => $this->input->post('txtvat_no'),
		'company_cst_no' => $this->input->post('txtcst_no'),
		'company_gst_no' => $this->input->post('txtgst_no'),
		'recipe_print' => $this->input->post('chkprint_logo'),
		'currency' => $this->input->post('cur'),
		'currency_symbol' => $this->input->post('cur_symbol'),
		'sales_tax1' => $this->input->post('txtsales_tax1'),
		'sales_tax2' => $this->input->post('txtsales_tax2'),
		'sales_tax3' => $this->input->post('txtsales_tax3'),
		'total_table' => $this->input->post('txttable'),
		'total_parcel' => $this->input->post('txtparcel'),
		'sms' => $this->input->post('chksms'),
		'sms_api' => $this->input->post('txtsmsapi'),
		'company_terms' => $this->input->post('txtterms'),
		'company_phone' => $this->input->post('txtcustomer_phone')

        );
        
        
            $this->db->where('company_id', $id);
            return $this->db->update('company', $data);
        
	}
	
	public function update_image_f($id,$file_name)
	{
		$data=array('company_image'=>$file_name);
		$this->db->where('company_id',$id);
		$this->db->update('company',$data);
	}

	public function remove($ids)
	{
		$this->db->where('company_id',$ids);
		$this->db->delete('company');
	}
 } 
 

?>