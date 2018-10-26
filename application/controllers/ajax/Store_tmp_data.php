<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class store_tmp_data extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
		$this->load->database();
	    
    }

	// Show view Page
	public function index(){
		
		$admin_id =$this->session->userdata('userid');
		$sn = array();
		$return = null;
		$grand_total = null;
		$_btno = '';
		$_qty = '';
		$_rt = '';
		$_pid = '';
		$_amt = '';
		$_mid = '';

		$s_a = $this->input->get('s_amount');
		$s_a = json_decode($s_a,true);

		$length = count($s_a);
		$table_id = $_SESSION['old_id'];

		if($length != 0){
			$this->db->query("delete from sales_tmp WHERE table_id = ".$table_id."  AND admin_id = ".$admin_id);
			
		}

		for($i = 0; $i < $length; $i++ )
		{
			$s_no =$this->input->get('s_no');
			$s_no = json_decode($s_no,true);
			
			$s_o = $this->input->get('s_p_option');
			$s_o = json_decode($s_o,true);
			
			$s_q = $this->input->get('s_qty');
			$s_q = json_decode($s_q,true);
			
			$s_r = $this->input->get('s_rate');
			$s_r = json_decode($s_r,true);
			
			
			$serial_no = $s_no[$i];
			$option_id = $s_o[$i];
			$qty = $s_q[$i];
			$rate = $s_r[$i];
			$total = $s_a[$i];

			$this->db->query("INSERT INTO sales_tmp (table_id,admin_id,purchase_serial_no,product_option_id,purchase_item_qty,purchase_item_rate,purchase_total)
			values(".$table_id.",".$admin_id.",'".$serial_no."',".$option_id.",".$qty.",".$rate.",".$total.")");
		}

		$q_result = $this->db->query("SELECT * FROM sales_tmp WHERE table_id =".$this->input->get('table_no')." AND admin_id = ".$admin_id."");

		foreach ($q_result->result() as $row)
		{
			$_option_p = (int)($row->product_option_id);
			$_qty = (int)($row->purchase_item_qty);
			$_ps = $row->purchase_serial_no;

			$product_r = $this->db->query("select product_actual_price,product_margin,product_name,product_actual_price,product_discount,product_serial_no,product_id from product where product_serial_no ='".$_ps."'");

			$product_option_r = $this->db->query("SELECT po.product_option_stock,po.option_parent_id,po.option_id,o.option_name,po.product_option_id FROM product_option po 
				INNER JOIN options o ON po.option_id=o.option_id
				WHERE product_option_id =".$_option_p."");
			$p_option = $product_option_r->row_array();
			$option_name = $p_option['option_name']; 

			foreach($product_r->result()  as $record)
			{
				$proid = $record->product_id;
				$_amt = floatval($p_option['product_option_stock']) * $_qty ;
				$_pnm = $record->product_name;
				$_ppr = $p_option['product_option_stock'];
				$_disc = $record->product_discount;
				$_ps = $record->product_serial_no;
				$_mar = $record->product_margin;
				
				if($_mar != 0)
				{
					$margin = $_ppr * $_mar /100;
					$_ppr += $margin;
					
					$_amt = $_ppr * $_qty;
				}
				if($_disc != 0 &&  $_disc > 0)
				{
					$t_ma = $_amt * $_disc /100;
					$_amt = floor($_amt - $t_ma);
				}


				if($_ps != '')
				{
						
						$return .= '<tr id="row_'.str_replace('.','_',$_amt).'">';
						
						$return .= '<input type="hidden" name="proid" id="pro_'.$_amt.'" value="'.$proid.'" />';
						
						$return .= '<td align="center" valign="middle"> <input type="hidden" name="select_order_serialno1[]" value='.$_ps.' />';
						
						$return .='<div style="float:left;width:20%;"><input type="hidden" value="'.$_btno.'" name="select_order_btno[]" />';
						$return .= '<a href="javascript:void(0);" style="padding-right:20px;padding-left:10px;" onclick="javascript:return deleteprd(\''.$_amt.'\');"><img src="'.base_url().'_template/images/icon-delete.gif" width="15" height="15" /></a></div>';
						
						$return .= '<strong>'.substr($_pnm,0,15).'</strong><input type="hidden" value="'.$_pnm.'" name="select_order_products_name[]" />';
						$return .= '<input type="hidden" value="'.$_mid.'" name="select_order_m_name[]" />';
						$return .= '</td>';
						
						$return .= '<td align="center" valign="middle">';
						$return .= '<strong>'.$_ps.'</strong><input type="hidden" id="serno'.str_replace('.','_',$_amt).'" value="'.$_ps.'" name="select_order_serialno[]" />';
						$return .= '</td>';
						
						$return .= '<td align="center" valign="middle">';
						$return .= '<strong>'.$_ppr.'</strong><input type="hidden" value="'.$_ppr.'" id="aprice_'.$_amt.'" name="select_order_products_rate[]" />';
						$return .= '</td>';
						
						$return .= '<td align="center" valign="middle"><input type="hidden" value="'.$_qty.'" id="qty_'.$_amt.'" name="select_products_qty[]" />
									<input type="hidden" value="'.$_option_p.'" id="option_'.$_amt.'" name="select_products_option[]" />';
						$return .= '<strong>'.$_qty.'('.$option_name.')</strong>';
						$return .= '</td>';
						
						
						$return .= '<td align="center" valign="middle"><input type="hidden" id="p_amount_'.$_ps.'_'.$_option_p.'_'.$_qty.'" value="'.$_amt.'" name="select_products_amount[]" />';
						$return .= '<strong id="amt_'.$_amt.'">'.$_amt.'</strong>';
						$return .= '</td>';
						
						$return .= '</tr>';
						
						$grand_total += $_amt;
						$sn[] = $_ps;
				}

			}

		}

		$s_numbers = implode(',',$sn);
		$s_numbers .=',';
		echo $return."||".$grand_total."||".$s_numbers;
		
		////////////////////////////////////////////////// SHOW DATA //////////////////////////////////////////////
		
		$_SESSION['old_id'] = $this->input->get('table_no');


	}
}


?>