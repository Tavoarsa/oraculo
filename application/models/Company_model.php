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

		'emisor_nombre' => $this->input->post('txtemisor_nombre'),
		'nombre_comercial' => $this->input->post('txtnombre_comercial'),
		'emisor_email' => $this->input->post('txtemisor_email'),
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
		'emisor_provincia'=>$this->input->post('cbx_provincia'),
		'emisor_canton'=>$this->input->post('cbx_canton'),
		'emisor_distrito'=>$this->input->post('cbx_distrito'),
		'emisor_barrio'=>$this->input->post('cbx_barrio'),
		'emisor_otras_senas'=>$this->input->post('txtsennas'),
		'emisor_cod_pais_tel' => $this->input->post('txtemisor_cod_pais_tel'),
		'emisor_tel' => $this->input->post('txtemisor_tel'),
		'emisor_cod_pais_fax' => $this->input->post('txtemisor_cod_pais_fax'),
		'emisor_fax' => $this->input->post('txtemisor_fax'),
		'emisor_tipo_indetif'=>$this->input->post('emisor_tipo_indetif'),
		'emisor_num_identif'=>$this->input->post('txtemisor_num_identif')

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

		'nombre_comercial' => $this->input->post('txtnombre_comercial'),
		'emisor_email' => $this->input->post('txtemisor_email'),
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
		'emisor_provincia'=>$this->input->post('cbx_provincia'),
		'emisor_canton'=>$this->input->post('cbx_canton'),
		'emisor_distrito'=>$this->input->post('cbx_distrito'),
		'emisor_barrio'=>$this->input->post('cbx_barrio'),
		'emisor_otras_senas'=>$this->input->post('txtsennas'),
		'emisor_cod_pais_tel' => $this->input->post('txtemisor_cod_pais_tel'),
		'emisor_tel' => $this->input->post('txtemisor_tel'),
		'emisor_cod_pais_fax' => $this->input->post('txtemisor_cod_pais_fax'),
		'emisor_fax' => $this->input->post('txtemisor_fax'),
		'emisor_tipo_indetif'=>$this->input->post('emisor_tipo_indetif'),
		'emisor_num_identif'=>$this->input->post('txtemisor_num_identif')

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