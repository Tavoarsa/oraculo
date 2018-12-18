<?php
defined('BASEPATH') OR exit('No direct script access allowed');
				
class Report_model extends CI_Model  { 
 
		
	public function __construct()
    {
        $this->load->database();
    }
 		
	public function findAll()
	{
		$this->db->select('entry_date'); 
   		$this->db->group_by('entry_date');
		$this->db->join('sales_grandtotal', 'sales_grandtotal.grand_order_no = sales.purchase_no');
		return $this->db->get('sales')->result();

	}
		
	public function findOne($id)
	{
		$this->db->where('purchase_no',$id);
		return $this->db->get('sales')->result();
	}
		
	
 } 
 

?>